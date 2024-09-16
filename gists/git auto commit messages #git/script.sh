#!/usr/bin/env bash

# Settings
chatgpt_api_key="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
chatgpt_model="gpt-4o"

debug=true
declare -A prompts=(
    ["system"]="
        You are a professional code reviewer.
    "
    ["user.intro"]="
        Please review a pull request by summarizing the changes made
        with the help of a bullet list of items that have been changed.

        Instructions:
        - Review the given output of \"git diff\" for the pull request
        - If you cannot identify any changes in the diff, return that no changes have been made
        - If only a slight change has been made, don't miss that change
        - Use the imperative mood in every bullet list item
        - Return always a single bullet list
        - Don't mention any sensitive information like passwords
        - Finish every bullet list item with a \".\"
        - Summarize the overview of the changes made
        - Don't mention file names
        - Create a bullet list of different items
        - The response sentences are no longer than 16 words each
        - Keep the response sentences as short as possible
        - Don't wrike any headlines and start with the bullet list

        If you have prepared the list and it has more than 3 entries,
        then merge the entries so that they add up to exactly 3 entries.
    "
    ["user.pre"]="
        This is the output of \"git diff\":
    "
)

# Variables
commit_msg_file="$1"
commit_mode="$2"
existing_msg=$(cat "$commit_msg_file")
data_log="/tmp/prepare-commit-msg-data.log"
output_log="/tmp/prepare-commit-msg-output.log"
diff_log="/tmp/prepare-commit-msg-diff.log"
chatgpt_url="https://api.openai.com/v1/chat/completions"

# Exit if a proper message is already provided
if [[ "$commit_mode" == "message" && "$existing_msg" != "." ]]; then
    exit
fi

# Output log file
echo "Automatically generating git commit message..."

# Fetch the staged git diff with unified context of 10 lines, no color and strip out all lines longer than 1000 chars
diff=$(git diff --unified=10 --staged --no-color | sed '/.\{1000\}./d')

# Log the diff for reference
echo "$diff" > "$diff_log"

# Add diff to prompts array
prompts["user.ai"]="$diff"

# Escape special characters for JSON formatting
for prompts__key in "${!prompts[@]}"; do
    prompts[$prompts__key]=$(sed -r 's/\\/\\\\/g' <<< "${prompts[$prompts__key]}") # \
    prompts[$prompts__key]=$(sed -r 's/"/\\\"/g' <<< "${prompts[$prompts__key]}") # "
    prompts[$prompts__key]=$(sed ':a;N;$!ba;s/\n/\\n/g' <<< "${prompts[$prompts__key]}") # \n
    prompts[$prompts__key]=$(sed 's/\t/    /g' <<< "${prompts[$prompts__key]}") # tabs
done

# Trim strings
for prompts__key in "${!prompts[@]}"; do
    if [[ "$prompts__key" != "user.ai" ]]; then
        prompts[$prompts__key]=$(sed -r 's/\\n( +)/\\n/g' <<< "${prompts[$prompts__key]}") # Remove blank space
        prompts[$prompts__key]=$(sed -r 's/^\\n//g' <<< "${prompts[$prompts__key]}") # Remove first line break
        prompts[$prompts__key]=$(sed -r 's/\\n$//g' <<< "${prompts[$prompts__key]}") # Remove last line break
    fi
done

# Prepare the payload for the API request
payload="{
    \"model\": \"$chatgpt_model\",
    \"messages\": [
        { \"role\": \"system\", \"content\": \"${prompts["system"]}\" },
        { \"role\": \"user\", \"content\": \"${prompts["user.intro"]}\" },
        { \"role\": \"user\", \"content\": \"${prompts["user.pre"]}\" },
        { \"role\": \"user\", \"content\": \"${prompts["user.ai"]}\" }
    ]
}"

# Save payload to log for debugging purposes
echo "$payload" > "$data_log"

# Make the API call using curl and capture the response
response=$(curl "$chatgpt_url" \
    -H "Content-Type: application/json" \
    -H "Authorization: Bearer $chatgpt_api_key" \
    --silent \
    --data-binary "@$data_log")

# Log the raw response for debugging
echo "$response" > "$output_log"

# Exit if response contains errors
if [[ $response == *"\"error\": {"* ]]; then
    echo "Error calling api..."
    exit
fi

# Extract the content from the response (handles potential formatting issues)
response=$(sed -nr 's/.+content": "(.+?)".+/\1/p' <<< "$response")
response=$(sed -r 's/\\n/\n/g' <<< "$response")

# Delete debug files
if [[ "$debug" = false ]]; then
    rm -f "$data_log"
    rm -f "$output_log"
    rm -f "$diff_log"
fi

# If commit mode is 'message' => `git commit -m '…'`
if [[ "$commit_mode" = "message" ]]; then
    # If commit message file contains only a '.'
    if [[ "$existing_msg" = "." ]]; then
        echo "$response" > "$commit_msg_file"
    fi
# If commit mode is 'commit' => `git commit`
else
    # If the first line is empty, then user didn’t use `git commit --amend`
    first_line=$(head -n1 "$commit_msg_file")
    if [[ -z "$first_line" ]]; then
        echo "$response" > "$commit_msg_file"
    fi
fi
