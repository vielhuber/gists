### client
```
let doc = new DOMParser().parseFromString('<!DOCTYPE html><html lang="de"><head></head><body></body></html>', 'text/html');
doc.documentElement.querySelector('body').classList.add('foo');
new XMLSerializer().serializeToString(doc);
```

### server (node)
```
npm install xmldom
const DOMParser = require('xmldom').DOMParser;
/* same as above */
```

### hide warnings
```
let doc = new DOMParser({ locator: {}, errorHandler: { warning: function(w) {}, error: function(e) {}, fatalError: function(e) { console.error(e); } } }).parseFromString('<!DOCTYPE html><html lang="de"><head></head><body></body></html>', 'text/html');
```