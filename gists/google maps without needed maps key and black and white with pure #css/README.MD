### #1

- this is an example of generated iframe via maps.google.com

```html
<iframe
	src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d85173.90062477115!2d11.471796465604353!3d48.15488947537066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x479e75f9a38c5fd9%3A0x10cb84a7db1987d!2zTcO8bmNoZW4!5e0!3m2!1sde!2sde!4v1520412472991"
    width="800"
    height="600"
    allowfullscreen="allowfullscreen"
    style="filter:grayscale(1)"
></iframe>
```

### #2

- very important: restrict the api key to domain referrers

```html
<iframe
	src="https://www.google.com/maps/embed/v1/place?key=xxxxxxxxxxxxxxxxxxxxxxxxxxx&q=Auenstraße 6, 80469 München, Deutschland&zoom=9"
    width="800"
    height="600"
    allowfullscreen="allowfullscreen"
    style="filter:grayscale(1)"
></iframe>
```

```html
<iframe
	src="https://www.google.com/maps/embed/v1/place?key=xxxxxxxxxxxxxxxxxxxxxxxxxxx&q=48.127660,11.575380&zoom=9"
    width="800"
    height="600"
    allowfullscreen="allowfullscreen"
    style="filter:grayscale(1)"
></iframe>
```

### #3

- this solution doesn't work anymore (google stopped supporting `output=embed` and no use of an api key)

```html
<iframe
	src="https://www.google.com/maps?q=Auenstraße 6, 80469 München, Deutschland&z=9&output=embed"
    width="800"
    height="600"
    allowfullscreen="allowfullscreen"
    style="filter:grayscale(1)"
></iframe>
```

```html
<iframe
	src="https://www.google.com/maps?q=48.127660,11.575380&z=9&output=embed"
    width="800"
    height="600"
    allowfullscreen="allowfullscreen"
    style="filter:grayscale(1)"
></iframe>
```

### #4

- you can use more styles

```css
iframe {
   grayscale(0%) invert(0%) sepia(70%) saturate(40%) brightness(100%) contrast(100%) hue-rotate(0deg);
}
```