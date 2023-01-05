### notes

- you can use data-attributes for exchanging data (```<div data-foo="..."></div>```)
- be aware, that ```json_encode```/```json_decode``` in php changes arrays to objects(!)
- if you don\'t want to use deprecated functions like `unescape` in js and need full interchangability between js/php,\
use this the functions `base64_encode`, `base64_decode`, `serialize` `unserialize` from https://locutus.io/php/ in js
- the following examples work both for unicode strings and complex objects etc.

### php <=> js

- ```htmlspecialchars(json_encode('❤️'), ENT_QUOTES, 'UTF-8')``` // "\u2764\ufe0f"
- ```JSON.parse('"\u2764\ufe0f"')``` // ❤"

### php <=> php

- ```base64_encode(serialize('❤️"'))``` // czo3OiLinaTvuI8iIjs=
- ```unserialize(base64_decode('czo3OiLinaTvuI8iIjs='))``` // ❤"

### js <=> js

- ```btoa(unescape(encodeURIComponent(JSON.stringify('❤️"'))))``` // IuKdpO+4j1wiIg==
- ```JSON.parse(decodeURIComponent(escape(atob('IuKdpO+4j1wiIg=='))))``` // ❤"
