## links

- https://fractal.build
- https://codeblog.trovster.com/2020/05/laravel-components-and-component-libraries
- https://codeblog.trovster.com/2020/05/use-fractal-with-your-website
- https://www.smashingmagazine.com/2018/07/pattern-library-first-css
- https://www.creativebloq.com/how-to/document-your-design-systems-with-fractal

## commands

- ```fractal start --sync``` (this is the main way to develop in fractal)
- ```fractal build```: creates a package that can be shown ot the customer (usually not needed)

## installation (in existing project)

- ```npm i -g @frctl/fractal```
- ```cd project```
- ```npm install --save @frctl/fractal```
- ```npm install --save handlebars-helpers```
- ```mkdir fractal```

- ```vim .gitignore```

```
/fractal/build/
/fractal/public/
```

- ```vim package.json```

```json
"scripts": {
    "fractal": "fractal build",
    "fractal:dev": "fractal start --sync",
    "fractal:copy": "ncp ./fractal/src/assets ./fractal/public/assets && ncp ./fractal/public ./public",
    "fractal:copy:watch": "onchange ./fractal/src/assets/**/*.* ./fractal/src/assets/**/**/*.* ./fractal/public/**/*.css ./fractal/public/**/**/*.css ./fractal/public/**/*.js ./fractal/public/**/**/*.js --initial --poll 25 --delay 0 --await-write-finish 25 -- onerror \"npm run fractal:copy\" --title \"fractal:copy:watch\" --message \"build failed\" --sound mute",
}
```

- ```vim fractal.config.js```

```js
'use strict';
const fractal = (module.exports = require('@frctl/fractal').create());
fractal.set('project.title', 'Test Component Library');
fractal.components.set('path', __dirname + '/fractal/src/components');
fractal.web.set('builder.dest', __dirname + '/fractal/build');
fractal.web.set('static.path', __dirname + '/fractal/public');
fractal.components.set('default.preview', '@preview');

// use handlebar helpers
const helpers = require('handlebars-helpers')(),
    hbs = require('@frctl/handlebars')({ helpers });
fractal.components.engine(hbs);
fractal.docs.engine(hbs);
```

- ```vim fractal/src/components/buttons/button.hbs```

```html
<div class='a-button js-button{{#if viewtypes.modifier}}{{ prepend viewtypes.modifier ' '}}{{/if}}'>
    {{content.text}}
</div>
```

- ```vim fractal/src/components/buttons/button.config.json```

```json
{
    "title": "Button",
    "status": "ready",
    "notes": "This is a first **example**.",
    "context": {
        "switches": {
            "isLink": false,
            "hasIcon": true
        },
        "viewtypes": {
            "modifier": ""
        },
        "content": {
            "text": "Click me"
        },
      	"preview": {
          	"padding": true
        }
    },
    "variants": [
        {
            "name": "Highlighted button",
            "status": "prototype",
            "notes": "These are some special **notes** about this variant.",
            "context": {
                "switches": {
                    "isLink": true,
                    "hasIcon": false
                },
                "viewtypes": {
                    "modifier": "button--highlight"
                },
                "content": {
                    "text": "Click me!!!"
                }
            }
        }
    ]
}
```

- ```vim fractal/src/_scss/_1.atoms.buttons.scss```

```scss
.a-button {
    background-color: green;
    color: #fff;
    text-decoration: none;
    text-transform: uppercase;
    display: inline-block;
    padding: 10px 20px;
}

.button--highlight {
    border: 2px solid red;
}
```

- ```vim fractal/src/_js/buttons/button.js```

```js
export default class button {
    initOnReady() {
        this.bindClick();
    }
    initOnLoad() {}
    bindClick() {
        document.addEventListener(
            'click',
            (e) => {
                if (e.target.closest('.js-button')) {
                    alert('FOO');
                    e.preventDefault();
                }
            },
            true
        );
    }
}
```

- ```vim fractal/src/components/_preview.hbs```

```hbs
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" />
    <title>Preview</title>
    <link rel="stylesheet" href="{{ path '/css/style.css' }}" />
    <script src="{{ path '/js/script.js' }}"></script> 
</head>
<body class="fractal-preview{{#if this._target.context.preview.padding}} fractal-preview--padding{{/if}}">

{{{ yield }}}

</body>
</html>
```

- ```vim fractal/src/_scss/0.base.scss```

```scss
.fractal-preview--padding {
    padding: 20px;
}
```

- ```vim fractal/src/_scss/style.scss```

```scss
@import '0.reset';
@import '0.base';
@import '0.fonts';
@import '1.atoms.buttons';
```

- ```vim fractal/src/_js/script.js```

```js
import Common from './base/common';
import Button from './buttons/button';

const common = new Common();
const button = new Button();

document.addEventListener('DOMContentLoaded', () => {
    common.initOnReady();
    button.initOnReady();
});
window.addEventListener('load', (e) => {
    common.initOnLoad();
    button.initOnLoad();
});
```

## build pipeline

- first move all existing scss/js files and even fonts to fractal
- they are copied after building to the main project
- so you test and develop in fractal(!)

## how to use partials

- `parent.hbs`

```html
<div class="m-parent">{{ render '@child' partials.child merge=true }}</div>
```

- `parent.config.json`

```json
{
    "title": "Parent",
    "context": {
        "partials": {
            "child": {
                "content": {
                    "text": "Kontextspezifischer Text"
                }
            }
        }
    }
}
```

- `child.hbs`

```html
<div class="a-child">{{ content.text }}</div>
```

- `child.config.json`

```json
{
    "title": "Child",
    "context": {
        "content": {
            "text": "Normaler Text"
        }
    }
}
```