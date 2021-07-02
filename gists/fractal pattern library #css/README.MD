## links

- https://fractal.build
- https://codeblog.trovster.com/2020/05/laravel-components-and-component-libraries
- https://codeblog.trovster.com/2020/05/use-fractal-with-your-website
- https://www.smashingmagazine.com/2018/07/pattern-library-first-css
- https://www.creativebloq.com/how-to/document-your-design-systems-with-fractal

## commands

- ```fractal start --sync```
- ```fractal build```

## installation

- ```npm i -g @frctl/fractal```
- ```mkdir fractal-test```
- ```cd fractal-test```
- ```npm init -y```
- ```npm install --save @frctl/fractal```
- ```mkdir src```
- ```mkdir src/components```
- ```mkdir src/docs```
- ```vim fractal.config.js```

```js
'use strict';
const fractal = (module.exports = require('@frctl/fractal').create());
fractal.set('project.title', 'HovawartDB Component Library');
fractal.components.set('path', __dirname + '/fractal/src/components');
fractal.docs.set('path', __dirname + '/fractal/src/docs');
fractal.web.set('builder.dest', __dirname + '/fractal/build');
fractal.web.set('static.path', __dirname + '/fractal/assets');
fractal.components.set('default.preview', '@preview');
```

- ```vim src/components/alert.hbs```

```html
<div class="alert alert--{{ modifier }}">This is an alert!</div>
<h1>{{ heading }}</h1>
<p>{{ text }}</p>
```

- ```vim src/components/alert.config.js```

```yml
module.exports = {
    title: 'Example component 123',
    status: 'ready',
    notes: 'These are some **notes** about the component',
    context: {
        modifier: 'default',
        text: 'This is an example component!',
        heading: 'My heading'
    },
    variants: [
        {
            name: 'warning',
            context: {
                modifier: 'alert',
                message: 'This is a warning banner'
            }
        },
        {
            name: 'success',
            status: 'prototype',
            notes: 'These are some special **notes** about the component',
            context: {
                modifier: 'success',
                message: 'This is a success banner'
            }
        }
    ]
};
```

- ```vim src/components/_preview.hbs```

```hbs
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link media="all" rel="stylesheet" href="{{ path '/css/style.css' }}">
    <title>Preview Layout</title>
</head>
<body>

{{{ yield }}}

</body>
</html>
```

- ```fractal start --sync```
- ```fractal build```
- create vhost that points to `fractal-test/bundle/`

### embed in build pipeline

package.json

```json
"scripts": {
    "fractal": "fractal build",
    "fractal:dev": "fractal start --sync",
    "fractal:copy": "ncp ./original/css/bundle.css ./fractal/assets/css/style.css && ncp ./original/fonts ./fractal/assets/fonts/",
    "fractal:copy:watch": "onchange ./original/css/bundle.css --initial --poll 25 --delay 0 --await-write-finish 25 -- onerror \"npm run fractal:copy\" --title \"fractal:copy:watch\" --message \"build failed\" --sound mute",
}
```