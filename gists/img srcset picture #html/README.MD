## intro

- there are two concepts for responsive images
- <img srcset ... />: give the browser alternative images for smaller resolutions, the browser chooses the best fit (based on size, bandwidth, ...)
- <picture ... />: best for fine-grained manipulation, alternative image formats and showing alternative images on mobile reliably
- <div ... />: simple and effective, good for showing compressed versions for background images

## srcset

### example 1

- small.jpg is loaded from viewport sizes 0-320px, medium.jpg from 320-600px, large.jpg above 600px, fallback.jpg in legacy browsers
- the w-values are the pixel widths of the images (the browser does not know them beforehand, so we must provide them)
- chrome: be sure to set device pixel ratio to 1 and clear cache on page load (if chrome has the bigger image in cache, it does not load the lower images)

```html
<!DOCTYPE html><html lang="de"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" /><title>.</title><style>
    img {
        width:100%;
        display:block;
    }
</style></head>
<body>
    <img
        srcset="https://via.placeholder.com/320x100.png?text=small 320w,
                https://via.placeholder.com/600x100.png?text=medium 600w,
                https://via.placeholder.com/900x100.png?text=large 900w"
        src="https://via.placeholder.com/900x100.png?text=fallback"
        alt=""
    />
</body></html>
```
   
### example 2

- use this if your image you want to provide different images for different device pixel ratios

```html
<!DOCTYPE html><html lang="de"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" /><title>.</title><style>
    img {
        width:100%;
        display:block;
    }
</style></head>
<body>
    <img
        srcset="https://via.placeholder.com/320x100.png?text=small,
                https://via.placeholder.com/600x100.png?text=medium 1.5x,
                https://via.placeholder.com/900x100.png?text=large 2x"
        src="https://via.placeholder.com/900x100.png?text=fallback"
        alt=""
    />
</body></html>
```

### example 3

- if the images don't have the full browser width, the browser needs more information to not show too big images in smaller divs
- via the sizes attribute, you give the browser a hint, which width the image actually has on the page (dependent on the viewport)
- from 0-800px the image has full width of the viewport, from 800-1200px a width of 1/2 of the viewport, above 1/3 (this is the default value)
- the browser then automatically tries to serve the optimal image

```html
<!DOCTYPE html><html lang="de"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" /><title>.</title><style>
    img {
        width:33.33%;
        display:block;
        float:left;
    }
    @media screen and (max-width:1200px) {
        img { width:50%; }
    }
    @media screen and (max-width:800px) {
      img { width:100%; }
    }
</style></head>
<body>
    <img
        srcset="https://via.placeholder.com/320x100.png?text=small 320w,
                https://via.placeholder.com/600x100.png?text=medium 600w,
                https://via.placeholder.com/900x100.png?text=large 900w"
        sizes="(max-width: 800px) 100vw,
               (max-width: 1200px) 50vw,
               33.33vw"
        src="https://via.placeholder.com/900x100.png?text=fallback"
        alt=""
    />
    <img
        srcset="https://via.placeholder.com/320x100.png?text=small 320w,
                https://via.placeholder.com/600x100.png?text=medium 600w,
                https://via.placeholder.com/900x100.png?text=large 900w"
        sizes="(max-width: 800px) 100vw,
               (max-width: 1200px) 50vw,
               33.33vw"
        src="https://via.placeholder.com/900x100.png?text=fallback"
        alt=""
    />
    <img
        srcset="https://via.placeholder.com/320x100.png?text=small 320w,
                https://via.placeholder.com/600x100.png?text=medium 600w,
                https://via.placeholder.com/900x100.png?text=large 900w"
        sizes="(max-width: 800px) 100vw,
               (max-width: 1200px) 50vw,
               33.33vw"
        src="https://via.placeholder.com/900x100.png?text=fallback"
        alt=""
    />
</body></html>
```

## picture

### example 1

- the source parts only show, if the condition in media is fulfilled
- you can also provide srcset and sizes on a source element (e.g. for 1x, 2x cases!)
- img acts as default value if no media conditions are fulfilled

```html
<!DOCTYPE html><html lang="de"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" /><title>.</title><style>
    img {
        width:100%;
        display:block;
        float:left;
    }
</style></head>
<body>
    <picture>
      <source media="(max-width: 800px)" srcset="https://via.placeholder.com/800x800.png?text=small">
      <source media="(max-width: 1200px)" srcset="https://via.placeholder.com/1200x400.png?text=medium">
      <img src="https://via.placeholder.com/1920x200.png?text=large" alt="" />
    </picture>
</body></html>
```

## media queries

### example

```html
<!DOCTYPE html><html lang="de"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" /><title>.</title><style>
    .img {
        width:100%;
        height:0;
        padding-bottom:20%;
        display:block;
        float:left;
        background-size:cover;
        background-repeat:no-repeat;
        background-position:center;
        background-image:url('https://via.placeholder.com/1920x200.png?text=large');
    }
    @media screen and (max-width: 1200px) {
        .img {
            background-image:url('https://via.placeholder.com/1200x400.png?text=medium');
        }
    }
    @media screen and (max-width: 800px) {
        .img {
            background-image:url('https://via.placeholder.com/800x800.png?text=small');
        }
    }
</style></head>
<body>
    <div class="img"></div>
</body></html>
```