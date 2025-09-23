## server

### local

- `http://127.0.0.1:8080/mcp`

### ngrok

- `ngrok http 8080`
- `https://***.ngrok-free.dev/mcp`

### fastmcp

- `python -m venv venv`
- `source venv/bin/activate`
- `pip install fastmcp`
  - Für neueste Features: `pip install git+https://github.com/jlowin/fastmcp.git`
- `pip install "fastapi[standard]"`
- `fastmcp version`
- `uvicorn app:app --host 0.0.0.0 --port 8000`

#### /app.py

```py
...
```

### apache

- `https://my-mcp-server.dev/mcp`
- `nano /etc/apache2/sites-available/mcp.conf`

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

- `sudo a2ensite mcp.conf`
- `sudo service apache2 reload`

## mcps

### php

- `composer require php-mcp/server`

#### /example/test.php

```php
...
```

#### /mcp.php

```php
...
```

- `php mcp.php`

### chrome

- add fresh chrome profile
- download + unzip chrome extension from https://github.com/hangwin/mcp-chrome
- `chrome://extensions/`
- Entpackte Erweiterung laden
- Ordner auswählen
- In Windows (nicht WSL)
  - `npm install -g mcp-chrome-bridge`
  - `mcp-chrome-bridge register`
- start server in chrome extension
- wsl
  - cmd (admin): `netsh interface portproxy add v4tov4 listenaddress=0.0.0.0 listenport=12306 connectaddress=127.0.0.1 connectport=12306`
  - powershell (admin): `New-NetFirewallRule -DisplayName "chrome-mcp" -Direction Inbound -LocalPort 12306 -Action Allow -Protocol TCP`
  - connect to: http://172.24.160.1:12306/mcp (`ip route show | grep -i default | awk '{ print $3}'`)


### playwright

- `npx @playwright/mcp@latest --port 8931 --no-sandbox --timeout-action 10000 --output-dir=./mcp-out --save-session --save-trace`

## clients

### chatgpt web / claude web

- add mcp server through connectors
- enable mcp server in chat

### claude desktop

- Einstellungen > Entwickler > Config bearbeiten > `claude_desktop_config.json`
- Siehe unten
- Neu öffnen mit: Datei > Beenden (Fenster schließen reicht nicht!)

### `claude_desktop_config.json`

#### stdio

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

#### http

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

## wsl

- if available remove from PATH in windows
  - `.\node_modules\.bin\`
  - `.\vendor\bin`
- edit file `claude_desktop_config.json`

```json
      "command": "C:\\Windows\\System32\\wsl.exe",
      "args": ["php", "/var/www/path/to/_mcp/mcp.php"],
```

## mcp inspector

- `nvm use 23.5.0`
- `npx @modelcontextprotocol/inspector`
- `DANGEROUSLY_OMIT_AUTH=true npx @modelcontextprotocol/inspector`

## links

- mcp repo: https://mcpservers.org/
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