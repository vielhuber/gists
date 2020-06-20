### youtube

- replace `https://www.youtube.com` with `https://www.youtube-nocookie.com`

```html
<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/LE90ETa1s8Y?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
```

### vimeo

- add parameter `dnt=1`

``` html
<iframe src="https://player.vimeo.com/video/27?dnt=1&title=0&byline=0&portrait=0" width="640" height="480" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
```
