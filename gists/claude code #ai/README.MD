## installation

- `curl -fsSL https://claude.ai/install.sh | bash`
- `claude --version`

## load skills

- `mkdir ~/.claude`
- `ln -s /var/www/boilerplate/AGENTS.md ~/.claude/CLAUDE.md`
- `ln -s /var/www/boilerplate/SKILLS ~/.claude/skills`

## usage

- `IS_SANDBOX=1 claude --continue --dangerously-skip-permissions --effort high`
- `claude`
- `claude --continue`
- `/login`
- `/model`
- `/usage`
- `/compact`
- `/permissions`
- `ctrl+enter`

## settings
- `nano ~/.claude/settings.json`
```js
{
  "skipDangerousModePermissionPrompt": true,
  "spinnerTipsEnabled": false
}
```

## agent teams

- `~/.claude/settings.json`
- `{ "env": { "CLAUDE_CODE_EXPERIMENTAL_AGENT_TEAMS": "1" } }`
- `apt-get install -y tmux`
- `echo "set -g mouse on" >> ~/.tmux.conf`
- `tmux new-session -s claude`
- `cd /var/www/my-project`
- `nvm use --lts`
- `git init`
- `touch CLAUDE.md`
- `git add -A . && git commit -m "init"`
- `claude`
- `exit`
- `tmux attach -t claude`
- `tmux kill-session -t claude`

## prompt

```
Erstelle ein Snake-Spiel als Webapplikation mit:
- Frontend: HTML5 Canvas Game (index.html, game.js, styles.css)
- Backend: Node.js Express Server mit Highscore-API (server.js, routes/, db/)
- Tests: Unit-Tests für Game-Logik und API-Endpoints

Phase 1: Plane die Architektur in CLAUDE.md mit klarer Task-Aufteilung.
Phase 2: Erstelle ein Team — ein Teammate für Frontend, einer für Backend, 
einer für Tests. Alle arbeiten parallel.
```

## ralph mode

### install
- `mkdir /tmp/ralph-claude-code`
- `cd /tmp/ralph-claude-code`
- `git clone https://github.com/frankbria/ralph-claude-code.git .`
- `./install.sh`
- `cd ~/`
- `rm -rf /tmp/ralph-claude-code`

### usage
- `cd my-project`
- init: `ralph-enable`
- run: `ralph --monitor`
- stop: `pkill -9 -f 'ralph_loop.sh|claude --model|timeout.*claude'; tmux ls 2>/dev/null | cut -d: -f1 | xargs -rI{} tmux kill-session -t {}`
- log: `tail -F -q .ralph/logs/claude_output_*.log | jq .`
- reset (soft): `find .ralph -mindepth 1 -maxdepth 1 ! -name '*.md' ! -name '.gitignore' -exec rm -rf {} +`
- reset (hard): `rm -rf .ralph .ralphrc && ralph-enable`

### .ralphrc

```
CLAUDE_MODEL="claude-opus-4-7"
ALLOWED_TOOLS="Write,Read,Edit,Grep,Glob,Bash,Monitor,WebFetch,WebSearch,Task,TodoWrite,NotebookEdit"
MAX_CALLS_PER_HOUR=30
MAX_TOKENS_PER_HOUR=800000
CB_NO_PROGRESS_THRESHOLD=2
```

### gitignore

#### option 1

```
/.ralph
/.ralphrc
```

#### option 2

```
/.ralph/*
!/.ralph/.gitignore
!/.ralph/*.md
```

## security pentest

### installation
- `cd /var/www/project`
- `claude`
- `/plugin marketplace add trailofbits/skills`
- `/plugin marketplace add anthropics/claude-plugins-official`
- `/plugin install static-analysis@trailofbits`
- `/plugin install insecure-defaults@trailofbits`
- `/plugin install sharp-edges@trailofbits`
- `/plugin install supply-chain-risk-auditor@trailofbits`
- `/plugin install differential-review@trailofbits`
- `/plugin install audit-context-building@trailofbits`
- `/plugin install variant-analysis@trailofbits`

### usage
- `cd /var/www/project`
- `claude`
- `security-review against http://localhost:8080`

## chrome / playwright

- `claude mcp add playwright npx @playwright/mcp@latest`
- alternative: claude code chrome (currently not supported in wsl): https://code.claude.com/docs/de/chrome