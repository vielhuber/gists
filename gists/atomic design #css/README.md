## links

- https://bradfrost.com/blog/post/atomic-web-design
- https://t3n.de/news/atomic-design-baukastensystem-721010
- https://www.lullabot.com/articles/bem-atomic-design-a-css-architecture-worth-loving

## atomic design

- **atom**: most basic building blocks (e.g. a button)
- **molecule**: combined atoms, smallest fundamental unit of a compound (e.g. a search form)
- **organism**: complex, distinct section of an interface (e.g. a header)
- **template**: groups of organisms stiched together (often as wireframes) to form pages
- **page**: specific instances of templates (placeholder content of templates are replced by real content)

## classes

- prefix all bem classes with `a-` (atom), `m-` (molecule), `o-` (organism), `t-` (template), `p-` (page)
- example: `a-button a-button--primary`

## folder structure

```
00_base/
├  _root.scss
├  _normalize.scss
└  _typography.scss

01_atom/
└  _a-buttons.scss

02_molecule/
├  _m-teaser.scss
├  _m-menu.scss
└  _m-card.scss

03_organism/
├  _o-teaser-list.scss
└  _o-card-list.scss

04_template/
├  _t-section.scss
└  _t-article.scss

05_page/
├  _p-blog.scss
└  _p-home.scss

style.scss
```