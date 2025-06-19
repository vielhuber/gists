## tl;dr

- Neuen Ordner anlegen und Dateien unterhalb erstellen
- Chrome > Erweiterungen > Entpackte Erweiterung laden > Ordner auswählen
- Plugin zum schnellen aktualisieren: [Extensions Reloader](https://chromewebstore.google.com/detail/extensions-reloader/fimgfedafeadlieiabdeeaodndnlbhid)

#### `/manifest.json`

```json
{
    "manifest_version": 3,
    "name": "🚀My custom extension🚀",
    "description": "Lorem ipsum dolor sit amet.",
    "version": "42",
    "permissions": ["storage"],
    "host_permissions": ["<all_urls>"],
    "icons": {
        "128": "icon.png"
    },
    "content_scripts": [
        {
            "matches": ["<all_urls>"],
            "js": ["script.js"],
            "css": ["style.css"]
        }
    ]
}
```

#### `/icon.png`

- 128px x 128px

#### `style.css`

```css
/* this gets applied on every page! */
.foo {
    box-shadow: 10px 10px 10px red;
}
```

#### `script.js`

```js
(async () => {
  
  	alert('foo');
  
  	document.body.style.opacity = '0.5';
  
  	setInterval(() => {
        if (document.querySelector('.foo') !== null) {
          document.querySelectorAll('.foo').forEach($el => {
            $el.remove();
          });
        }
    }, 1000);
  
    await chrome.storage.local.set({
      ['my_custom_global_key']: {
        foo: 'bar',
        bar: 'baz'
      }
    });
  
  	await chrome.storage.local.get('my_custom_global_key'); // { foo: 'bar', bar: 'baz' }

})();
```
