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

- `( export OPENCODE_DISABLE_CLAUDE_CODE=true OPENCODE_DISABLE_EXTERNAL_SKILLS=true IS_SANDBOX=1; directory=$(pwd -P);
  session_id=$(opencode session list --format json 2>/dev/null | jq -r --arg directory "$directory" '[.[] | select(.directory ==
  $directory)] | sort_by(.updated) | last | .id // empty'); if [ -n "$session_id" ]; then exec opencode . --session "$session_id"
  --auto --model opencode-go/kimi-k3; else exec opencode . --auto --model opencode-go/kimi-k3; fi )`
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

## notifications

- `mkdir -p ~/.config/opencode/plugins`
- `ln -sfn /mnt/o/DOCS/SCRIPTS/NOTIFY/opencode-notify.js ~/.config/opencode/plugins/notify.js`