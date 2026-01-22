#### installation

```sh
npm install katex
```

#### copy fonts in build pipeline

```json
"scripts": {
    "katex:copy": "ncp ./node_modules/katex/dist/fonts ./build/fonts/",
},
```

#### style.scss
```scss
@import './node_modules/katex/dist/katex.min';
```


#### script.js
```.js
import katex from 'katex';
import renderMathInElement from 'katex/dist/contrib/auto-render.js';
renderMathInElement(document.body);
```



