## installation

- `curl -fsSL https://opencode.ai/install | bash`
- `source ~/.bashrc`
- `opencode --version`
- `opencode upgrade`

## load skills

- `mkdir -p ~/.config/opencode`
- `ln -sfn /var/www/boilerplate/AGENTS.md ~/.config/opencode/AGENTS.md`
- `ln -sfn /var/www/boilerplate/_skills ~/.config/opencode/skills`

## usage

- `OPENCODE_DISABLE_CLAUDE_CODE=true OPENCODE_DISABLE_EXTERNAL_SKILLS=true IS_SANDBOX=1 opencode $([ -n "$(opencode session list --format json --max-count 1 2>/dev/null)" ] && echo --continue) --auto --model opencode-go/glm-5.2`
- `opencode`
- `opencode --continue`
- `/connect`
- `/models`

## settings
- `nano ~/.config/opencode/opencode.jsonc`
```js
{
  "$schema": "https://opencode.ai/config.json",
  "permission": "allow"
}
```

## mcp

- `nano ~/.config/opencode/opencode.jsonc`

```js
{
  ...
  "mcp": {
    "playwright": {
      "type": "local",
      "command": ["npx", "-y", "@playwright/mcp@latest"],
      "enabled": true,
      "timeout": 30000
    }
  }
}
```

- `npx ctx7 setup --opencode` (=> MCP server)

## notificatiopns

- `mkdir -p ~/.config/opencode/plugins`
- `ln -sfn /mnt/o/DOCS/SCRIPTS/NOTIFY/opencode-notify.js ~/.config/opencode/plugins/notify.js`