## installation

- IDE Download / Login

```sh
cd /tmp
wget https://storage.googleapis.com/antigravity-public/antigravity-hub/2.0.1-6566078776737792/linux-x64/Antigravity.tar.gz
mkdir -p /opt/antigravity
tar -xzf Antigravity.tar.gz -C /opt/antigravity --strip-components=1
/opt/antigravity/antigravity --no-sandbox
```

- CLI Installation

```sh
curl -fsSL https://antigravity.google/cli/install.sh | bash
agy
```

## load skills

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

## auto-execution (Codex „--yolo" Äquivalent)
- Settings → `terminal.autoExecution` → `Always proceed` (alias „Turbo")
- Settings → Agent Review Policy → `Always Proceed`
- Permissions/Settings syncen bidirektional mit der Antigravity 2.0 GUI

## chrome / playwright
- MCP via globaler Config `~/.antigravity/mcp_config.json`:
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
- Alternativ in der TUI: `/mcp` → Manage MCP Servers