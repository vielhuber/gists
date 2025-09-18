## php-mcp

- `composer require php-mcp/server`

### example/test.php

```php
...
```

### mcp.php

```php
...
```

- `php mcp.php`

### authentication

- simple auth via GET argument (works with all clients)
- `/mcp?auth_token=XXX`

## playwright

- `npx @playwright/mcp@latest --port 8931 --no-sandbox --timeout-action 10000 --output-dir=./mcp-out --save-session --save-trace`

## chrome-mcp

- add fresh chrome profile
- download + unzip chrome extension from https://github.com/hangwin/mcp-chrome
- `chrome://extensions/`
- Entpackte Erweiterung laden
- Ordner auswählen
- In Windows (nicht WSL)
  - `npm install -g mcp-chrome-bridge`
  - `mcp-chrome-bridge register`

## access

- local test url
  - http://127.0.0.1:8080/mcp
- test with remote tunnel
  - https://***.ngrok-free.dev/mcp
  - `ngrok http 8080`
- public apache reverse proxy
  - https://my-mcp-server.dev/mcp
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

## chatgpt/claude.ai

- add mcp server through connectors
- enable mcp server in chat

## claude desktop

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

#### wsl support

- Falls vorhanden aus PATH in Windows entfernen
  - `.\node_modules\.bin\`
  - `.\vendor\bin`
- Datei `claude_desktop_config.json` editieren

```json
      "command": "C:\\Windows\\System32\\wsl.exe",
      "args": ["php", "/var/www/path/to/_mcp/mcp.php"],
```

## mcp inspector

- `npx @modelcontextprotocol/inspector`

## links

- MCP Repository: https://mcpservers.org/
- Video (c't): https://www.youtube.com/watch?v=S_4VUJ-x8hE
- MCP Inspector: https://modelcontextprotocol.io/legacy/tools/inspector
- Claude Desktop: https://claude.ai/download
- VSCode Cline: https://cline.bot
- Video (Laravel): https://www.youtube.com/watch?v=T22_rXew72M
- PHP Library: https://github.com/php-mcp/server
- MCP SuperAssistant: https://mcpsuperassistant.ai
- Claude Tutorial: https://www.reddit.com/r/ClaudeAI/comments/1ji8ruv/my_claude_workflow_guide_advanced_setup_with_mcp/
- Playwright MCP: https://github.com/microsoft/playwright-mcp