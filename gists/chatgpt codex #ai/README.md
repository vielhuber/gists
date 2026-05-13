## installation

- `npm install -g @openai/codex`
- `codex --version`

## load skills

- `mkdir -p ~/.agents`
- `ln -s /var/www/boilerplate/AGENTS.md ~/.codex/AGENTS.md`
- `ln -s /var/www/boilerplate/_skills ~/.agents/skills`

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

## chrome / playwright

- `codex mcp add playwright -- npx -y @playwright/mcp@latest`