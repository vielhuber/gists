### client
```
let doc = new DOMParser().parseFromString('<!DOCTYPE html><html lang="de"><head></head><body></body></html>', 'text/html');
doc.querySelector('body').classList.add('foo');
console.log(new XMLSerializer().serializeToString(doc));
```

### server (node) - legacy
```
npm install xmldom
const DOMParser = require('xmldom').DOMParser;
/* same as above */
```

#### server (node) - recommended
```
npm install jsdom
const jsdom = require('jsdom'), { JSDOM } = jsdom;
let dom = new JSDOM('<!DOCTYPE html><html lang="de"><head></head><body></body></html>');
dom.window.document.querySelector('body').classList.add('foo');
console.log(dom.serialize());
```

### hide warnings
```
let doc = new DOMParser({ locator: {}, errorHandler: { warning: function(w) {}, error: function(e) {}, fatalError: function(e) { console.error(e); } } }).parseFromString('<!DOCTYPE html><html lang="de"><head></head><body></body></html>', 'text/html');
```