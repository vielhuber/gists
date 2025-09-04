### Einstellungen

- `WP_DEBUG = false`: Es werden alle Fehler außer Notices ausgegeben, aber es hängt an der Servereinstellung `ini_set('display_errors', ?)` ob sie wirklich angezeigt werden
- `WP_DEBUG = true`: Es werden alle Fehler, samt Notices ausgegeben. Nur dann haben `WP_DEBUG_DISPLAY` und `WP_DEBUG_LOG` Auswirkungen
- `WP_DEBUG_DISPLAY = true`: erzwingt `ini_set('display_errors', 1)`
- `WP_DEBUG_LOG`: Fehlermeldungen werden zusätzlich in eine Datei geschrieben (`wp-content/debug.log`)

### Empfehlungen

- Auf Development sollte man `WP_DEBUG = true` setzen
- Auf Production sollte man `WP_DEBUG = false` setzen und serverweit `ini_set('display_errors', 0)` aktiv sein
- Code-Verhalten: `wp-includes/load.php`: Zeile 309

### Logging manuell triggern

```php
error_log('foo');
error_log(json_encode(['foo' => 'bar', 'bar' => 'baz']));
error_log(serialize(['foo' => 'bar', 'bar' => 'baz']));
```