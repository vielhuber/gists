## installation

- `curl -fsSL https://antigravity.google/cli/install.sh | bash`
- `agy --version`

## load skills

- `mkdir -p ~/.antigravity`
- `mkdir -p ~/.agents`
- `ln -s /var/www/boilerplate/AGENTS.md ~/.antigravity/AGENTS.md`
- `ln -s /var/www/boilerplate/_skills ~/.agents/skills`

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
- `nano ~/.antigravity/mcp_config.json`
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