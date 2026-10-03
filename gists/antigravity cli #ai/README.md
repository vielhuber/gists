## installation

- `curl -fsSL https://antigravity.google/cli/install.sh | bash`
- `agy --version`

## load skills

- `mkdir -p ~/.gemini/config`
- `ln -sfn /var/www/skills/AGENTS.md ~/.gemini/config/AGENTS.md`
- `ln -sfn /var/www/skills ~/.gemini/config/skills`

## usage
- `agy`
- `agy resume`
- `agy resume --last`
- `agy login`
- `/logout`
- `/model`
- `/status`
- `/compact`
- `/mcp`
- `/skills`
- `/resume`, `/new`, `/clear`, `/diff`, `/review`
- `Tab`
- `Esc Esc`

## --yolo
- `mkdir -p ~/.gemini/antigravity-cli`
- `nano ~/.gemini/antigravity-cli/settings.json`
```json
{
  "toolPermission": "always-proceed",
  "artifactReviewPolicy": "always-proceed"
}
```

## chrome / playwright
- `nano ~/.gemini/config/mcp_config.json`
```json
{
  "mcpServers": {
    "playwright": {
      "command": "npx",
      "args": ["-y", "@playwright/mcp@latest"]
    }
  }
}
```
