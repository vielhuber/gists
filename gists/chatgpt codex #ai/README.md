## installation

- `npm install -g @openai/codex`
- `codex --version`

## load skills

- `mkdir -p ~/.codex`
- `mkdir -p ~/.agents`
- `ln -sfn /var/www/skills/AGENTS.md ~/.codex/AGENTS.md`
- `ln -sfn /var/www/skills ~/.agents/skills`

## usage

- `codex resume --last --yolo -c model_reasoning_effort="high"`
- `codex --dangerously-bypass-approvals-and-sandbox` (`codex --yolo`)
- `codex --full-auto` (= `-a on-failure -s workspace-write`)
- `codex`
- `codex resume`
- `codex resume --last`
- `codex login`
- `/model`
- `/status`
- `/compact`
- `/approvals`
- `/goal`
- `/resume`, `/new`, `/clear`, `/diff`, `/review`, `/mcp`, `/skills`
- `Tab`
- `Esc Esc`
- show all sessions: `codex resume --all`
- delete session: `codex delete SESSION_ID`

## mcp

- `codex mcp add playwright -- npx -y @playwright/mcp@latest`
- `npx ctx7 setup --codex` (=> MCP server)

## notifications
- `nano ~/.codex/config.toml`
```toml
[features]
hooks = true
```

- `nano ~/.codex/hooks.json`

```json
{
  "description": "Update the taskbar harness overlay.",
  "hooks": {
    "SessionStart": [{"hooks": [{"type": "command","command": "bash /mnt/o/DOCS/SCRIPTS/NOTIFY/notify.sh codex-hook waiting","timeout": 10}]}],
    "UserPromptSubmit": [{"hooks": [{"type": "command","command": "bash /mnt/o/DOCS/SCRIPTS/NOTIFY/notify.sh codex-hook thinking","timeout": 10}]}],
    "Stop": [{"hooks": [{"type": "command","command": "bash /mnt/o/DOCS/SCRIPTS/NOTIFY/notify.sh codex-hook waiting","timeout": 10}]}],
    "PermissionRequest": [{"hooks": [{"type": "command","command": "bash /mnt/o/DOCS/SCRIPTS/NOTIFY/notify.sh codex-hook attention","timeout": 10}]}],
    "SessionEnd": [{"hooks": [{"type": "command","command": "bash /mnt/o/DOCS/SCRIPTS/NOTIFY/notify.sh codex-hook remove","timeout": 3}]}]
  }
}
```

- `codex` =>  Trust all and continue