## variant 1 (with sourcemaps)
```vue
<style lang="scss">
@import "@/scss/style.scss";
</style>
```
```js
// vue.config.js
module.exports = {
    /* ... */
    css: {
        /* enable sourcemaps */
        sourceMap: true,
        /* disable css extraction into app.css */
        extract: false,
    }
    /* ... */
};

```

## variant 2 (no source maps)
```js
// src/main.js
require('./scss/style.scss');
```

## variant 3 (no source maps)
```js
// src/main.js
import './scss/style.scss';
```