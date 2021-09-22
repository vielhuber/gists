### php

- ```base64_encode(serialize('❤️"'))``` // czo3OiLinaTvuI8iIjs=
- ```unserialize(base64_decode('czo3OiLinaTvuI8iIjs='))``` // ❤"

### js

- ```btoa(unescape(encodeURIComponent(JSON.stringify('❤️"'))))``` // IuKdpO+4j1wiIg==
- ```JSON.parse(decodeURIComponent(escape(atob('IuKdpO+4j1wiIg=='))))``` // ❤"

### notes

- don't use json_encode/json_decode in php, because it changes arrays to objects
- if you don\'t want to use deprecated functions like `unescape` in js and need full interchangability between js/php,\
use this the functions `base64_encode`, `base64_decode`, `serialize` `unserialize` from https://locutus.io/php/ in js