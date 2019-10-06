# Warning: Datatypes must be bytea / binary when you store encrypted data

CREATE EXTENSION IF NOT EXISTS pgcrypto;

SELECT
  --decrypt
  convert_from(decrypt(
    -- encrypt
    encrypt('i like dogs.', 'secret_key', 'aes')
  ,'secret_key','aes'), 'utf-8');
