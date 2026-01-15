## SERVER

### NOTES

- local: use `fastmcp` directly
- production: use `fastmcp` as a gateway and `cloudflare` for ssl/dns

### NGROK

- `https://***.ngrok-free.dev/mcp`

#### installation

- `curl -sSL https://ngrok-agent.s3.amazonaws.com/ngrok.asc | sudo tee /etc/apt/trusted.gpg.d/ngrok.asc >/dev/null && echo "deb https://ngrok-agent.s3.amazonaws.com buster main" | sudo tee /etc/apt/sources.list.d/ngrok.list && sudo apt update  && sudo apt install ngrok`

#### usage

- `ngrok http 8000`

### FASTMCP

- `http://127.0.0.1:8080/mcp`

#### installation

- `python -m venv venv`
- `source venv/bin/activate`
- `pip install fastmcp`
  - Für neueste Features: `pip install git+https://github.com/jlowin/fastmcp.git`
- `pip install "fastapi[standard]"`
- `fastmcp version`

#### usage

- `uvicorn app:app --host 0.0.0.0 --port 8000`

### CLOUDFLARE

#### installation

- `curl -fsSL https://pkg.cloudflare.com/cloudflare-main.gpg | sudo tee /usr/share/keyrings/cloudflare-main.gpg >/dev/null`
- `echo 'deb [signed-by=/usr/share/keyrings/cloudflare-main.gpg] https://pkg.cloudflare.com/cloudflared jammy main' | sudo tee /etc/apt/sources.list.d/cloudflared.list`
- `sudo apt-get update`
- `sudo apt-get install cloudflared`
- `cloudflared tunnel login`
- `cloudflared tunnel create TUNNEL`
- `cloudflared tunnel route dns --overwrite-dns TUNNEL custom-domain.xyz`
- `cloudflared tunnel route dns --overwrite-dns TUNNEL '*.custom-domain.xyz'`
- notes
  - admin interface can be found on cloudflare.com > Zero Trust > Networks > Tunnels
  - remove warnings in log
    - `echo "net.ipv4.ping_group_range = 0 2147483647" | sudo tee -a /etc/sysctl.conf`
    - `sudo sysctl -p`
  - if the connection via node is not working, restart wsl and/or put direct ip (`ping custom-domain.xyz`) inside `/etc/hosts`

### usage

- `cloudflared tunnel run --url http://localhost:8000 TUNNEL`

### APACHE

#### installation

- `https://my-mcp-server.dev/mcp`
- `nano /etc/apache2/sites-available/mcp.conf`
- `sudo a2ensite mcp.conf`
- `sudo service apache2 reload`

```
<VirtualHost *:443>
    ServerName my-mcp-server.dev

    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    RequestHeader set X-Real-IP "%{REMOTE_ADDR}s"
    RequestHeader set X-Forwarded-Proto "https"

    ProxyPreserveHost On
    ProxyRequests Off
    ProxyAddHeaders On
    ProxyTimeout 3600
    RequestReadTimeout header=60,MinRate=1 body=60,MinRate=1

    ProxyPass / http://127.0.0.1:8080/ keepalive=On retry=0 flushpackets=on
    ProxyPassReverse / http://127.0.0.1:8080/

    <Location />
        Require all granted
        Header unset Connection
    </Location>

    SSLEngine on
    SSLCertificateFile ...
    SSLCertificateKeyFile ...
</VirtualHost>
```

## MCP CLIENTS

### mcp-inspector

- `nvm use --lts`
- `npx @modelcontextprotocol/inspector`
- `DANGEROUSLY_OMIT_AUTH=true npx @modelcontextprotocol/inspector` (disable security token from inspector, has nothing to do with oauth of mcps)
- usage with ngrok: install chrome extension `ModHeader` and set `ngrok-skip-browser-warning = 69420`

### chatgpt.com

- https://chatgpt.com
- add mcp server through connectors
- enable mcp server in chat

### openai playground

- https://platform.openai.com/chat/edit
- Tools > Add > MCP server > + Server

### claude.ai

- https://claude.ai
- add mcp server through connectors
- enable mcp server in chat

### claude desktop

- Einstellungen > Entwickler > Config bearbeiten > `claude_desktop_config.json`
- Siehe unten
- Neu öffnen mit: Datei > Beenden (Fenster schließen reicht nicht!)

#### `claude_desktop_config.json`

##### stdio

```json
{
  "mcpServers": {
    "custom": {
      "command": "php",
      "args": ["/var/www/path/to/mcp.php"]
    }
  }
}
```

##### http

```json
{
  "mcpServers": {
    "custom": {
        "command": "npx",
        "args": ["mcp-remote", "http://127.0.0.1:8080/mcp"]
    }
  }
}
```

## MISC

### WSL

- if available remove from PATH in windows
  - `.\node_modules\.bin\`
  - `.\vendor\bin`
- edit file `claude_desktop_config.json`

```json
      "command": "C:\\Windows\\System32\\wsl.exe",
      "args": ["php", "/var/www/path/to/_mcp/mcp.php"],
```

### LINKS

- mcp repo: https://mcpservers.org
- mcp repo: https://dxt.so
- video (c't): https://www.youtube.com/watch?v=S_4VUJ-x8hE
- mcp inspector: https://modelcontextprotocol.io/legacy/tools/inspector
- claude desktop: https://claude.ai/download
- vscode cline: https://cline.bot
- video (laravel): https://www.youtube.com/watch?v=T22_rXew72M
- php library: https://github.com/php-mcp/server
- mcp superassistant: https://mcpsuperassistant.ai
- claude tutorial: https://www.reddit.com/r/ClaudeAI/comments/1ji8ruv/my_claude_workflow_guide_advanced_setup_with_mcp/
- playwright mcp: https://github.com/microsoft/playwright-mcp
- fastmcp: https://gofastmcp.com
- mcp-cli: https://github.com/chrishayuk/mcp-cli