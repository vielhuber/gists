## installation

- `npm install -g @openai/codex`
- `codex --version`

## load skills

- `mkdir -p ~/.codex/skills`
- `ln -s /var/www/boilerplate/AGENTS.md ~/.codex/AGENTS.md`
- `ln -s /var/www/boilerplate/SKILLS ~/.codex/skills`

## usage

- `codex resume --last --yolo`
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
- `/resume`, `/new`, `/clear`, `/diff`, `/review`, `/mcp`, `/skills`
- `Tab`
- `Esc Esc`