import tiktoken
import torch
import torch.nn as nn
import urllib.request
import re
from torch.utils.data import Dataset, DataLoader
import numpy as np
import zipfile
import os
from pathlib import Path
import pandas as pd
import time
import json
import tensorflow as tf
from tqdm import tqdm


class GPT2:
    """
    This single class encapsulates all functions and classes from the original code.
    """

    # --------------------------------------------------------------------------------
    # Basic GPT configuration (example: GPT-2 124M)
    # --------------------------------------------------------------------------------
    GPT_CONFIG_124M = {
        "vocab_size": 50257,
        "context_length": 256,
        "emb_dim": 768,
        "n_heads": 12,
        "n_layers": 12,
        "drop_rate": 0.1,
        "qkv_bias": False
    }

    # --------------------------------------------------------------------------------
    # Static Methods
    # --------------------------------------------------------------------------------

    @staticmethod
    def download_and_load_gpt2(model_size, models_dir):
        """
        Downloads the requested GPT-2 model from official or backup URLs,
        extracts all relevant files, loads TF checkpoint parameters,
        and returns the loaded settings and params as dictionaries.

        :param model_size: The model size string (e.g. '124M', '355M', '774M', '1558M').
        :param models_dir: Directory to store the downloaded model files.
        :return: (settings, params) tuple, where 'settings' is a dict of GPT-2 settings
                 and 'params' is a dict of model parameters from the TF checkpoint.
        """
        # Validate model size
        allowed_sizes = ("124M", "355M", "774M", "1558M")
        if model_size not in allowed_sizes:
            raise ValueError(f"Model size not in {allowed_sizes}")

        # Define paths
        model_dir = os.path.join(models_dir, model_size)
        base_url = "https://openaipublic.blob.core.windows.net/gpt-2/models"
        backup_base_url = "https://f001.backblazeb2.com/file/LLMs-from-scratch/gpt2"
        filenames = [
            "checkpoint", "encoder.json", "hparams.json",
            "model.ckpt.data-00000-of-00001", "model.ckpt.index",
            "model.ckpt.meta", "vocab.bpe"
        ]

        # Download files
        os.makedirs(model_dir, exist_ok=True)
        for filename in filenames:
            file_url = os.path.join(base_url, model_size, filename)
            backup_url = os.path.join(backup_base_url, model_size, filename)
            file_path = os.path.join(model_dir, filename)
            GPT2.download_file(file_url, file_path, backup_url)

        # Load settings and params
        tf_ckpt_path = tf.train.latest_checkpoint(model_dir)
        settings = json.load(open(os.path.join(model_dir, "hparams.json")))
        params = GPT2.load_gpt2_params_from_tf_ckpt(tf_ckpt_path, settings)

        return settings, params

    @staticmethod
    def download_file(url, destination, backup_url=None):
        """
        Downloads a file from a given URL (or a backup URL, if the primary fails).
        Uses a progress bar and does not re-download if file is already present
        and up-to-date.

        :param url: Primary URL to download from.
        :param destination: File path where the downloaded data will be saved.
        :param backup_url: Optional backup URL if the primary fails.
        """

        def _attempt_download(download_url):
            with urllib.request.urlopen(download_url) as response:
                # Get the total file size from headers, defaulting to 0 if not present
                file_size = int(response.headers.get("Content-Length", 0))

                # Check if file exists and has the same size
                if os.path.exists(destination):
                    file_size_local = os.path.getsize(destination)
                    if file_size == file_size_local:
                        print(f"File already exists and is up-to-date: {destination}")
                        return True  # Indicate success without re-downloading

                block_size = 1024  # 1 Kilobyte

                # Initialize the progress bar with total file size
                progress_bar_description = os.path.basename(download_url)
                with tqdm(total=file_size, unit="iB", unit_scale=True,
                          desc=progress_bar_description) as progress_bar:
                    with open(destination, "wb") as file:
                        while True:
                            chunk = response.read(block_size)
                            if not chunk:
                                break
                            file.write(chunk)
                            progress_bar.update(len(chunk))
                return True

        try:
            if _attempt_download(url):
                return
        except (urllib.error.HTTPError, urllib.error.URLError):
            if backup_url is not None:
                print(f"Primary URL ({url}) failed. Attempting backup URL: {backup_url}")
                try:
                    if _attempt_download(backup_url):
                        return
                except urllib.error.HTTPError:
                    pass

            # If we reach here, both attempts have failed
            error_message = (
                f"Failed to download from both primary URL ({url})"
                f"{' and backup URL (' + backup_url + ')' if backup_url else ''}."
                "\nCheck your internet connection or the file availability.\n"
                "For help, visit: https://github.com/rasbt/LLMs-from-scratch/discussions/273"
            )
            print(error_message)
        except Exception as e:
            print(f"An unexpected error occurred: {e}")

    @staticmethod
    def load_gpt2_params_from_tf_ckpt(ckpt_path, settings):
        """
        Loads GPT-2 parameters from a TensorFlow checkpoint and places them
        into a structured dictionary.

        :param ckpt_path: Path to the TF checkpoint (usually within the model folder).
        :param settings: Dictionary of GPT-2 model settings (including n_layer).
        :return: params (dict) containing the model parameters structured by blocks.
        """
        # Initialize parameters dictionary with empty blocks for each layer
        params = {"blocks": [{} for _ in range(settings["n_layer"])]}

        # Iterate over each variable in the checkpoint
        for name, _ in tf.train.list_variables(ckpt_path):
            # Load the variable and remove singleton dimensions
            variable_array = np.squeeze(tf.train.load_variable(ckpt_path, name))

            # Process the variable name to extract relevant parts
            variable_name_parts = name.split("/")[1:]  # Skip the 'model/' prefix

            # Identify the target dictionary for the variable
            target_dict = params
            if variable_name_parts[0].startswith("h"):
                layer_number = int(variable_name_parts[0][1:])
                target_dict = params["blocks"][layer_number]

            # Recursively access or create nested dictionaries
            for key in variable_name_parts[1:-1]:
                target_dict = target_dict.setdefault(key, {})

            # Assign the variable array to the last key
            last_key = variable_name_parts[-1]
            target_dict[last_key] = variable_array

        return params

    @staticmethod
    def train_classifier_simple(model, train_loader, val_loader,
                                optimizer, device, num_epochs, eval_freq, eval_iter):
        """
        Simple training loop for a classification model, evaluating every
        'eval_freq' steps. Returns losses, accuracies, and examples seen.

        :param model: PyTorch model to be trained.
        :param train_loader: DataLoader for the training dataset.
        :param val_loader: DataLoader for the validation dataset.
        :param optimizer: Optimizer (e.g., AdamW).
        :param device: Device to train on (CPU or GPU).
        :param num_epochs: Number of epochs to train.
        :param eval_freq: Frequency (in steps) of evaluating on training/validation sets.
        :param eval_iter: Number of mini-batches to evaluate.
        :return: (train_losses, val_losses, train_accs, val_accs, examples_seen)
        """
        train_losses, val_losses, train_accs, val_accs = [], [], [], []
        examples_seen, global_step = 0, -1

        for epoch in range(num_epochs):
            model.train()
            for input_batch, target_batch in train_loader:
                optimizer.zero_grad()
                loss = GPT2.calc_loss_batch(
                    input_batch, target_batch, model, device
                )
                loss.backward()
                optimizer.step()
                examples_seen += input_batch.shape[0]
                global_step += 1

                if global_step % eval_freq == 0:
                    train_loss, val_loss = GPT2.evaluate_model(
                        model, train_loader, val_loader, device, eval_iter
                    )
                    train_losses.append(train_loss)
                    val_losses.append(val_loss)
                    print(f"Ep {epoch+1} (Step {global_step:06d}): "
                          f"Train loss {train_loss:.3f}, "
                          f"Val loss {val_loss:.3f}")

                train_accuracy = GPT2.calc_accuracy_loader(
                    train_loader, model, device, num_batches=eval_iter
                )
                val_accuracy = GPT2.calc_accuracy_loader(
                    val_loader, model, device, num_batches=eval_iter
                )
                print(f"Training accuracy: {train_accuracy*100:.2f}% | ", end="")
                print(f"Validation accuracy: {val_accuracy*100:.2f}%")

                train_accs.append(train_accuracy)
                val_accs.append(val_accuracy)

            return train_losses, val_losses, train_accs, val_accs, examples_seen

    @staticmethod
    def calc_accuracy_loader(data_loader, model, device, num_batches=None):
        """
        Calculates accuracy on a given DataLoader for classification.

        :param data_loader: DataLoader with (input_batch, target_batch).
        :param model: PyTorch model for evaluation.
        :param device: Device to evaluate on.
        :param num_batches: Optional limit on number of batches to evaluate.
        :return: accuracy (float)
        """
        model.eval()
        correct_predictions, num_examples = 0, 0

        if num_batches is None:
            num_batches = len(data_loader)
        else:
            num_batches = min(num_batches, len(data_loader))

        for i, (input_batch, target_batch) in enumerate(data_loader):
            if i < num_batches:
                input_batch = input_batch.to(device)
                target_batch = target_batch.to(device)
                with torch.no_grad():
                    logits = model(input_batch)[:, -1, :]
                predicted_labels = torch.argmax(logits, dim=-1)
                num_examples += predicted_labels.shape[0]
                correct_predictions += (predicted_labels == target_batch).sum().item()
            else:
                break

        return correct_predictions / num_examples

    @staticmethod
    def random_split(df, train_frac, validation_frac):
        """
        Splits a DataFrame into train/validation/test sets by given fractions.

        :param df: The DataFrame to split.
        :param train_frac: Fraction of data for training.
        :param validation_frac: Fraction of data for validation.
        :return: (train_df, validation_df, test_df) DataFrames
        """
        df = df.sample(frac=1, random_state=123).reset_index(drop=True)
        train_end = int(len(df) * train_frac)
        validation_end = train_end + int(len(df) * validation_frac)
        train_df = df[:train_end]
        validation_df = df[train_end:validation_end]
        test_df = df[validation_end:]
        return train_df, validation_df, test_df

    @staticmethod
    def create_balanced_dataset(df):
        """
        Given a spam/ham dataset, balances it by sampling equally from each class.

        :param df: Original DataFrame containing a 'Label' column ('spam' or 'ham').
        :return: balanced_df (DataFrame) with equal spam/ham instances.
        """
        num_spam = df[df["Label"] == "spam"].shape[0]
        ham_subset = df[df["Label"] == "ham"].sample(num_spam, random_state=123)
        balanced_df = pd.concat([ham_subset, df[df["Label"] == "spam"]])
        return balanced_df

    @staticmethod
    def download_and_unzip_spam_data(url, zip_path, extracted_path, data_file_path):
        """
        Downloads a zip file from 'url' and extracts the file if not already present.

        :param url: URL for the SMS Spam Collection dataset.
        :param zip_path: Local zip path.
        :param extracted_path: Directory to extract to.
        :param data_file_path: Final path of the extracted file.
        """
        if data_file_path.exists():
            print(f"{data_file_path} already exists. Skipping download and extraction.")
            return
        with urllib.request.urlopen(url) as response:
            with open(zip_path, "wb") as out_file:
                out_file.write(response.read())
        with zipfile.ZipFile(zip_path, "r") as zip_ref:
            zip_ref.extractall(extracted_path)
        original_file_path = Path(extracted_path) / "SMSSpamCollection"
        os.rename(original_file_path, data_file_path)
        print(f"File downloaded and saved as {data_file_path}")

    @staticmethod
    def evaluate_model(model, train_loader, val_loader, device, eval_iter):
        """
        Evaluates the model on both training and validation sets (loss only).

        :param model: PyTorch model.
        :param train_loader: DataLoader for training set.
        :param val_loader: DataLoader for validation set.
        :param device: Device (CPU/GPU).
        :param eval_iter: Number of mini-batches to evaluate.
        :return: (train_loss, val_loss)
        """
        model.eval()
        with torch.no_grad():
            train_loss = GPT2.calc_loss_loader(
                train_loader, model, device, num_batches=eval_iter
            )
            val_loss = GPT2.calc_loss_loader(
                val_loader, model, device, num_batches=eval_iter
            )
            model.train()
        return train_loss, val_loss

    @staticmethod
    def generate_and_print_sample(model, tokenizer, device, start_context):
        """
        Generates a sample of text from the model given a start context,
        then prints the decoded text.

        :param model: PyTorch model.
        :param tokenizer: Tokenizer (compatible with GPT-2).
        :param device: Device (CPU/GPU).
        :param start_context: Initial text prompt (string).
        """
        model.eval()
        context_size = model.pos_emb.weight.shape[0]
        encoded = GPT2.text_to_token_ids(start_context, tokenizer).to(device)
        with torch.no_grad():
            token_ids = GPT2.generate_text_simple(
                model=model,
                idx=encoded,
                max_new_tokens=50,
                context_size=context_size
            )
        decoded_text = GPT2.token_ids_to_text(token_ids, tokenizer)
        print(decoded_text.replace("\n", " "))
        model.train()

    @staticmethod
    def train_model_simple(model, train_loader, val_loader, optimizer,
                           device, num_epochs, eval_freq, eval_iter,
                           start_context, tokenizer):
        """
        Simple language modeling training loop. Evaluates on train/val sets,
        generates sample text after each epoch.

        :param model: PyTorch model.
        :param train_loader: Training DataLoader.
        :param val_loader: Validation DataLoader.
        :param optimizer: Optimizer (e.g., AdamW).
        :param device: Device (CPU/GPU).
        :param num_epochs: Number of training epochs.
        :param eval_freq: Steps between evaluations.
        :param eval_iter: Number of mini-batches for evaluation.
        :param start_context: String prompt to use for sample generation.
        :param tokenizer: GPT-2-compatible tokenizer for sample generation.
        :return: (train_losses, val_losses, track_tokens_seen)
        """
        train_losses, val_losses, track_tokens_seen = [], [], []
        tokens_seen, global_step = 0, -1

        for epoch in range(num_epochs):
            model.train()
            for input_batch, target_batch in train_loader:
                optimizer.zero_grad()
                loss = GPT2.calc_loss_batch(
                    input_batch, target_batch, model, device
                )
                loss.backward()
                optimizer.step()
                tokens_seen += input_batch.numel()
                global_step += 1

                if global_step % eval_freq == 0:
                    train_loss, val_loss = GPT2.evaluate_model(
                        model, train_loader, val_loader, device, eval_iter
                    )
                    train_losses.append(train_loss)
                    val_losses.append(val_loss)
                    track_tokens_seen.append(tokens_seen)
                    print(f"Ep {epoch+1} (Step {global_step:06d}): "
                          f"Train loss {train_loss:.3f}, "
                          f"Val loss {val_loss:.3f}")
            GPT2.generate_and_print_sample(
                model, tokenizer, device, start_context
            )

        return train_losses, val_losses, track_tokens_seen

    @staticmethod
    def calc_loss_loader(data_loader, model, device, num_batches=None):
        """
        Calculates average loss over the given data loader.

        :param data_loader: DataLoader of (input, target) pairs.
        :param model: PyTorch model.
        :param device: Device (CPU/GPU).
        :param num_batches: Number of batches to use for the calculation.
        :return: Average loss (float).
        """
        total_loss = 0.
        if len(data_loader) == 0:
            return float("nan")
        elif num_batches is None:
            num_batches = len(data_loader)
        else:
            num_batches = min(num_batches, len(data_loader))

        for i, (input_batch, target_batch) in enumerate(data_loader):
            if i < num_batches:
                loss = GPT2.calc_loss_batch(
                    input_batch, target_batch, model, device
                )
                total_loss += loss.item()
            else:
                break
        return total_loss / num_batches

    @staticmethod
    def calc_loss_batch(input_batch, target_batch, model, device):
        """
        Calculates cross-entropy loss for a single batch (classification or last-token LM).

        :param input_batch: Tensor of shape (batch_size, seq_len).
        :param target_batch: Tensor of shape (batch_size,) or (batch_size, seq_len), depending on model.
        :param model: PyTorch model.
        :param device: Device (CPU/GPU).
        :return: loss (scalar).
        """
        input_batch = input_batch.to(device)
        target_batch = target_batch.to(device)
        logits = model(input_batch)[:, -1, :]  # using only last token for classification
        loss = torch.nn.functional.cross_entropy(logits, target_batch)
        return loss

    @staticmethod
    def text_to_token_ids(text, tokenizer):
        """
        Converts a text string into a tensor of token IDs using the given tokenizer.

        :param text: Input text string.
        :param tokenizer: GPT-2-compatible tokenizer.
        :return: A torch.LongTensor (1, seq_len).
        """
        encoded = tokenizer.encode(text, allowed_special={'<|endoftext|>'})
        encoded_tensor = torch.tensor(encoded).unsqueeze(0)
        return encoded_tensor

    @staticmethod
    def token_ids_to_text(token_ids, tokenizer):
        """
        Converts a tensor of token IDs back into a text string using the given tokenizer.

        :param token_ids: Tensor of shape (1, seq_len).
        :param tokenizer: GPT-2-compatible tokenizer.
        :return: Decoded text string.
        """
        flat = token_ids.squeeze(0)
        return tokenizer.decode(flat.tolist())

    @staticmethod
    def generate(model, idx, max_new_tokens, context_size, temperature=0.0,
                 top_k=None, eos_id=None):
        """
        Generates text token by token, optionally using temperature sampling
        and top-k filtering.

        :param model: PyTorch model.
        :param idx: Tensor of shape (1, context_so_far_length).
        :param max_new_tokens: Number of tokens to generate.
        :param context_size: Maximum context size of the model.
        :param temperature: Temperature parameter for sampling (0.0 = greedy).
        :param top_k: Keep only top K tokens for sampling (optional).
        :param eos_id: Optional EOS token id to stop generation prematurely.
        :return: Updated idx tensor with new tokens appended.
        """
        for _ in range(max_new_tokens):
            idx_cond = idx[:, -context_size:]
            with torch.no_grad():
                logits = model(idx_cond)
            logits = logits[:, -1, :]

            if top_k is not None:
                top_logits, _ = torch.topk(logits, top_k)
                min_val = top_logits[:, -1]
                logits = torch.where(
                    logits < min_val,
                    torch.tensor(float('-inf')).to(logits.device),
                    logits
                )
            if temperature > 0.0:
                logits = logits / temperature
                probs = torch.softmax(logits, dim=-1)
                idx_next = torch.multinomial(probs, num_samples=1)
            else:
                idx_next = torch.argmax(logits, dim=-1, keepdim=True)

            if eos_id is not None and idx_next == eos_id:
                break

            idx = torch.cat((idx, idx_next), dim=1)
        return idx

    @staticmethod
    def generate_text_simple(model, idx, max_new_tokens, context_size):
        """
        Generates text greedily (no temperature, no top-k) for demonstration.

        :param model: PyTorch model.
        :param idx: Tensor of shape (1, context_so_far_length).
        :param max_new_tokens: Number of tokens to generate.
        :param context_size: Maximum context size of the model.
        :return: Updated idx tensor with new tokens appended.
        """
        for _ in range(max_new_tokens):
            idx_cond = idx[:, -context_size:]
            with torch.no_grad():
                logits = model(idx_cond)
            logits = logits[:, -1, :]
            probas = torch.softmax(logits, dim=-1)
            idx_next = torch.argmax(probas, dim=-1, keepdim=True)
            idx = torch.cat((idx, idx_next), dim=1)
        return idx

    @staticmethod
    def assign(left, right):
        """
        Helper method to assign Numpy arrays to PyTorch parameters with shape checking.

        :param left: Torch Parameter.
        :param right: Numpy array with the same shape.
        :return: Torch Parameter with the assigned data.
        """
        if left.shape != right.shape:
            raise ValueError(f"Shape mismatch. Left: {left.shape}, "
                             f"Right: {right.shape}")
        return torch.nn.Parameter(torch.tensor(right))

    @staticmethod
    def load_weights_into_gpt(gpt, params):
        """
        Loads pre-trained GPT-2 weights from the 'params' dictionary into a PyTorch GPT model.

        :param gpt: GPTModel (PyTorch) instance.
        :param params: Dictionary structure of weights (from TF checkpoint).
        """
        gpt.pos_emb.weight = GPT2.assign(gpt.pos_emb.weight, params['wpe'])
        gpt.tok_emb.weight = GPT2.assign(gpt.tok_emb.weight, params['wte'])

        for b in range(len(params["blocks"])):
            q_w, k_w, v_w = np.split(
                (params["blocks"][b]["attn"]["c_attn"])["w"], 3, axis=-1
            )
            gpt.trf_blocks[b].att.W_query.weight = GPT2.assign(
                gpt.trf_blocks[b].att.W_query.weight, q_w.T
            )
            gpt.trf_blocks[b].att.W_key.weight = GPT2.assign(
                gpt.trf_blocks[b].att.W_key.weight, k_w.T
            )
            gpt.trf_blocks[b].att.W_value.weight = GPT2.assign(
                gpt.trf_blocks[b].att.W_value.weight, v_w.T
            )

            q_b, k_b, v_b = np.split(
                (params["blocks"][b]["attn"]["c_attn"])["b"], 3, axis=-1
            )
            gpt.trf_blocks[b].att.W_query.bias = GPT2.assign(
                gpt.trf_blocks[b].att.W_query.bias, q_b
            )
            gpt.trf_blocks[b].att.W_key.bias = GPT2.assign(
                gpt.trf_blocks[b].att.W_key.bias, k_b
            )
            gpt.trf_blocks[b].att.W_value.bias = GPT2.assign(
                gpt.trf_blocks[b].att.W_value.bias, v_b
            )

            gpt.trf_blocks[b].att.out_proj.weight = GPT2.assign(
                gpt.trf_blocks[b].att.out_proj.weight,
                params["blocks"][b]["attn"]["c_proj"]["w"].T
            )
            gpt.trf_blocks[b].att.out_proj.bias = GPT2.assign(
                gpt.trf_blocks[b].att.out_proj.bias,
                params["blocks"][b]["attn"]["c_proj"]["b"]
            )

            gpt.trf_blocks[b].ff.layers[0].weight = GPT2.assign(
                gpt.trf_blocks[b].ff.layers[0].weight,
                params["blocks"][b]["mlp"]["c_fc"]["w"].T
            )
            gpt.trf_blocks[b].ff.layers[0].bias = GPT2.assign(
                gpt.trf_blocks[b].ff.layers[0].bias,
                params["blocks"][b]["mlp"]["c_fc"]["b"]
            )
            gpt.trf_blocks[b].ff.layers[2].weight = GPT2.assign(
                gpt.trf_blocks[b].ff.layers[2].weight,
                params["blocks"][b]["mlp"]["c_proj"]["w"].T
            )
            gpt.trf_blocks[b].ff.layers[2].bias = GPT2.assign(
                gpt.trf_blocks[b].ff.layers[2].bias,
                params["blocks"][b]["mlp"]["c_proj"]["b"]
            )

            gpt.trf_blocks[b].norm1.scale = GPT2.assign(
                gpt.trf_blocks[b].norm1.scale,
                params["blocks"][b]["ln_1"]["g"]
            )
            gpt.trf_blocks[b].norm1.shift = GPT2.assign(
                gpt.trf_blocks[b].norm1.shift,
                params["blocks"][b]["ln_1"]["b"]
            )
            gpt.trf_blocks[b].norm2.scale = GPT2.assign(
                gpt.trf_blocks[b].norm2.scale,
                params["blocks"][b]["ln_2"]["g"]
            )
            gpt.trf_blocks[b].norm2.shift = GPT2.assign(
                gpt.trf_blocks[b].norm2.shift,
                params["blocks"][b]["ln_2"]["b"]
            )

        gpt.final_norm.scale = GPT2.assign(gpt.final_norm.scale, params["g"])
        gpt.final_norm.shift = GPT2.assign(gpt.final_norm.shift, params["b"])
        gpt.out_head.weight = GPT2.assign(gpt.out_head.weight, params["wte"])

    # --------------------------------------------------------------------------------
    # Internal Dataset Classes
    # --------------------------------------------------------------------------------

    class SpamDataset(Dataset):
        """
        Dataset for spam/ham classification using GPT tokenization for text encoding.
        """
        def __init__(self, csv_file, tokenizer, max_length=None, pad_token_id=50256):
            """
            :param csv_file: CSV file path with columns 'Text' and 'Label'.
            :param tokenizer: GPT-2-compatible tokenizer for encoding text.
            :param max_length: Maximum sequence length. If None, determined by the longest example.
            :param pad_token_id: Token ID used for padding.
            """
            self.data = pd.read_csv(csv_file)
            self.encoded_texts = [tokenizer.encode(text) for text in self.data["Text"]]

            # Determine or set max length
            if max_length is None:
                self.max_length = self._longest_encoded_length()
            else:
                self.max_length = max_length
                self.encoded_texts = [
                    encoded_text[:self.max_length] for encoded_text in self.encoded_texts
                ]

            # Pad encoded texts to max_length
            self.encoded_texts = [
                encoded_text + [pad_token_id] * (self.max_length - len(encoded_text))
                for encoded_text in self.encoded_texts
            ]

        def __getitem__(self, index):
            encoded = self.encoded_texts[index]
            label = self.data.iloc[index]["Label"]
            return (
                torch.tensor(encoded, dtype=torch.long),
                torch.tensor(label, dtype=torch.long)
            )

        def __len__(self):
            return len(self.data)

        def _longest_encoded_length(self):
            """
            Finds the maximum length among all encoded texts.
            """
            max_length = 0
            for encoded_text in self.encoded_texts:
                encoded_length = len(encoded_text)
                if encoded_length > max_length:
                    max_length = encoded_length
            return max_length

    # --------------------------------------------------------------------------------
    # Simple Dataset for GPT-like Training
    # --------------------------------------------------------------------------------

    class GPTDatasetV1(Dataset):
        """
        A dataset class that slices text into overlapping chunks for GPT training.
        """
        def __init__(self, txt, tokenizer, max_length, stride):
            """
            :param txt: A long text string.
            :param tokenizer: GPT-2-compatible tokenizer.
            :param max_length: Sequence length for each chunk.
            :param stride: Step size between consecutive chunks.
            """
            self.input_ids = []
            self.target_ids = []

            token_ids = tokenizer.encode(txt)
            # Overlapping slices
            for i in range(0, len(token_ids) - max_length, stride):
                input_chunk = token_ids[i:i + max_length]
                target_chunk = token_ids[i + 1:i + max_length + 1]

                self.input_ids.append(torch.tensor(input_chunk))
                self.target_ids.append(torch.tensor(target_chunk))

        def __len__(self):
            return len(self.input_ids)

        def __getitem__(self, idx):
            return self.input_ids[idx], self.target_ids[idx]

    # --------------------------------------------------------------------------------
    # Tokenizer Classes (for demonstration)
    # --------------------------------------------------------------------------------

    class SimpleTokenizerV1:
        """
        A very basic tokenizer using string split, for demonstration only.
        """
        def __init__(self, vocab):
            self.str_to_int = vocab
            self.int_to_str = {i: s for s, i in vocab.items()}

        def encode(self, text):
            preprocessed = re.split(r'([,.?_!"()\']|--|\s)', text)
            preprocessed = [item.strip() for item in preprocessed if item.strip()]
            ids = [self.str_to_int[s] for s in preprocessed]
            return ids

        def decode(self, ids):
            text = " ".join([self.int_to_str[i] for i in ids])
            text = re.sub(r'\s+([,.?!"()\'])', r'\1', text)
            return text

    class SimpleTokenizerV2:
        """
        A slightly improved tokenizer with an <|unk|> token.
        """
        def __init__(self, vocab):
            self.str_to_int = vocab
            self.int_to_str = {i: s for s, i in vocab.items()}

        def encode(self, text):
            preprocessed = re.split(r'([,.:;?_!"()\']|--|\s)', text)
            preprocessed = [item.strip() for item in preprocessed if item.strip()]
            preprocessed = [
                item if item in self.str_to_int else "<|unk|>" for item in preprocessed
            ]
            ids = [self.str_to_int[s] for s in preprocessed]
            return ids

        def decode(self, ids):
            text = " ".join([self.int_to_str[i] for i in ids])
            text = re.sub(r'\s+([,.:;?!"()\'])', r'\1', text)
            return text

    # --------------------------------------------------------------------------------
    # GPT Components: Attention, FeedForward, Transformer Blocks, etc.
    # --------------------------------------------------------------------------------

    class MultiHeadAttention(nn.Module):
        """
        Multi-head Causal Self-Attention module used in GPT models.
        """
        def __init__(self, d_in, d_out, context_length, dropout, num_heads, qkv_bias=False):
            super().__init__()
            assert (d_out % num_heads == 0), \
                "d_out must be divisible by num_heads"
            self.d_out = d_out
            self.num_heads = num_heads
            self.head_dim = d_out // num_heads

            self.W_query = nn.Linear(d_in, d_out, bias=qkv_bias)
            self.W_key = nn.Linear(d_in, d_out, bias=qkv_bias)
            self.W_value = nn.Linear(d_in, d_out, bias=qkv_bias)
            self.out_proj = nn.Linear(d_out, d_out)
            self.dropout = nn.Dropout(dropout)

            # Upper triangular mask to prevent attention to future tokens
            self.register_buffer(
                "mask",
                torch.triu(torch.ones(context_length, context_length), diagonal=1)
            )

        def forward(self, x):
            b, num_tokens, d_in = x.shape
            keys = self.W_key(x)
            queries = self.W_query(x)
            values = self.W_value(x)

            # Reshape to (batch_size, num_heads, seq_len, head_dim)
            keys = keys.view(b, num_tokens, self.num_heads, self.head_dim)
            values = values.view(b, num_tokens, self.num_heads, self.head_dim)
            queries = queries.view(b, num_tokens, self.num_heads, self.head_dim)

            keys = keys.transpose(1, 2)
            queries = queries.transpose(1, 2)
            values = values.transpose(1, 2)

            # Compute attention scores
            attn_scores = queries @ keys.transpose(2, 3)

            # Apply causal mask
            mask_bool = self.mask.bool()[:num_tokens, :num_tokens]
            attn_scores.masked_fill_(mask_bool, -torch.inf)

            attn_weights = torch.softmax(
                attn_scores / keys.shape[-1]**0.5, dim=-1
            )
            attn_weights = self.dropout(attn_weights)

            # Combine values (context vector)
            context_vec = (attn_weights @ values).transpose(1, 2)
            context_vec = context_vec.contiguous().view(b, num_tokens, self.d_out)

            # Final linear projection
            context_vec = self.out_proj(context_vec)
            return context_vec

    class FeedForward(nn.Module):
        """
        The feed-forward sub-layer of a Transformer block.
        """
        def __init__(self, cfg):
            super().__init__()
            self.layers = nn.Sequential(
                nn.Linear(cfg["emb_dim"], 4 * cfg["emb_dim"]),
                GPT2.GELU(),
                nn.Linear(4 * cfg["emb_dim"], cfg["emb_dim"]),
            )

        def forward(self, x):
            return self.layers(x)

    class GELU(nn.Module):
        """
        GELU activation function used in GPT-2.
        """
        def __init__(self):
            super().__init__()

        def forward(self, x):
            return 0.5 * x * (1 + torch.tanh(
                torch.sqrt(torch.tensor(2.0 / torch.pi)) *
                (x + 0.044715 * torch.pow(x, 3))
            ))

    class LayerNorm(nn.Module):
        """
        Layer normalization without bias/affine.
        """
        def __init__(self, emb_dim):
            super().__init__()
            self.eps = 1e-5
            self.scale = nn.Parameter(torch.ones(emb_dim))
            self.shift = nn.Parameter(torch.zeros(emb_dim))

        def forward(self, x):
            mean = x.mean(dim=-1, keepdim=True)
            var = x.var(dim=-1, keepdim=True, unbiased=False)
            norm_x = (x - mean) / torch.sqrt(var + self.eps)
            return self.scale * norm_x + self.shift

    class TransformerBlock(nn.Module):
        """
        A single Transformer block consisting of (LayerNorm -> Self-Attn -> FF) with residuals.
        """
        def __init__(self, cfg):
            super().__init__()
            self.att = GPT2.MultiHeadAttention(
                d_in=cfg["emb_dim"],
                d_out=cfg["emb_dim"],
                context_length=cfg["context_length"],
                num_heads=cfg["n_heads"],
                dropout=cfg["drop_rate"],
                qkv_bias=cfg["qkv_bias"]
            )
            self.ff = GPT2.FeedForward(cfg)
            self.norm1 = GPT2.LayerNorm(cfg["emb_dim"])
            self.norm2 = GPT2.LayerNorm(cfg["emb_dim"])
            self.drop_shortcut = nn.Dropout(cfg["drop_rate"])

        def forward(self, x):
            # Self-attention sub-layer
            shortcut = x
            x = self.norm1(x)
            x = self.att(x)
            x = self.drop_shortcut(x)
            x = x + shortcut

            # Feed-forward sub-layer
            shortcut = x
            x = self.norm2(x)
            x = self.ff(x)
            x = self.drop_shortcut(x)
            x = x + shortcut
            return x

    class GPTModel(nn.Module):
        """
        A GPT-style model: token embedding -> positional embedding -> transformer blocks -> final norm -> output head.
        """
        def __init__(self, cfg):
            super().__init__()
            self.tok_emb = nn.Embedding(cfg["vocab_size"], cfg["emb_dim"])
            self.pos_emb = nn.Embedding(cfg["context_length"], cfg["emb_dim"])
            self.drop_emb = nn.Dropout(cfg["drop_rate"])

            # Create n_layers TransformerBlocks in a Sequential
            self.trf_blocks = nn.Sequential(
                *[GPT2.TransformerBlock(cfg) for _ in range(cfg["n_layers"])]
            )
            self.final_norm = GPT2.LayerNorm(cfg["emb_dim"])
            self.out_head = nn.Linear(cfg["emb_dim"], cfg["vocab_size"], bias=False)

        def forward(self, in_idx):
            # in_idx: (batch_size, seq_len)
            batch_size, seq_len = in_idx.shape
            tok_embeds = self.tok_emb(in_idx)
            pos_embeds = self.pos_emb(torch.arange(seq_len, device=in_idx.device))
            x = tok_embeds + pos_embeds
            x = self.drop_emb(x)
            x = self.trf_blocks(x)
            x = self.final_norm(x)
            # Project to vocabulary
            logits = self.out_head(x).to(in_idx.device)
            return logits

    # --------------------------------------------------------------------------------
    # Dummy Models (for demonstration or debugging)
    # --------------------------------------------------------------------------------

    class DummyGPTModel(nn.Module):
        """
        A dummy GPTModel that does nothing in its Transformer blocks, used for debugging.
        """
        def __init__(self, cfg):
            super().__init__()
            self.tok_emb = nn.Embedding(cfg["vocab_size"], cfg["emb_dim"])
            self.pos_emb = nn.Embedding(cfg["context_length"], cfg["emb_dim"])
            self.drop_emb = nn.Dropout(cfg["drop_rate"])
            self.trf_blocks = nn.Sequential(
                *[GPT2.DummyTransformerBlock(cfg) for _ in range(cfg["n_layers"])]
            )
            self.final_norm = GPT2.DummyLayerNorm(cfg["emb_dim"])
            self.out_head = nn.Linear(cfg["emb_dim"], cfg["vocab_size"], bias=False)

        def forward(self, in_idx):
            batch_size, seq_len = in_idx.shape
            tok_embeds = self.tok_emb(in_idx)
            pos_embeds = self.pos_emb(torch.arange(seq_len, device=in_idx.device))
            x = tok_embeds + pos_embeds
            x = self.drop_emb(x)
            x = self.trf_blocks(x)
            x = self.final_norm(x)
            logits = self.out_head(x)
            return logits

    class DummyTransformerBlock(nn.Module):
        """
        A dummy TransformerBlock that simply returns the input. Used for debugging.
        """
        def __init__(self, cfg):
            super().__init__()

        def forward(self, x):
            return x

    class DummyLayerNorm(nn.Module):
        """
        A dummy layer norm that returns the input unmodified.
        """
        def __init__(self, normalized_shape, eps=1e-5):
            super().__init__()

        def forward(self, x):
            return x

    # --------------------------------------------------------------------------------
    # Utility function to create a DataLoader for GPT training (example usage).
    # --------------------------------------------------------------------------------

    @staticmethod
    def create_dataloader_v1(txt, batch_size=4, max_length=256, stride=128,
                             shuffle=True, drop_last=True, num_workers=0):
        """
        Creates a DataLoader for GPT-like training using GPTDatasetV1.

        :param txt: A long text string.
        :param batch_size: Batch size for DataLoader.
        :param max_length: Sequence length for each chunk.
        :param stride: Step size for chunk creation.
        :param shuffle: Whether to shuffle the dataset.
        :param drop_last: Whether to drop the last incomplete batch.
        :param num_workers: Number of workers for data loading.
        :return: A PyTorch DataLoader.
        """
        tokenizer = tiktoken.get_encoding("gpt2")
        dataset = GPT2.GPTDatasetV1(txt, tokenizer, max_length, stride)
        dataloader = DataLoader(
            dataset,
            batch_size=batch_size,
            shuffle=shuffle,
            drop_last=drop_last,
            num_workers=num_workers
        )
        return dataloader
