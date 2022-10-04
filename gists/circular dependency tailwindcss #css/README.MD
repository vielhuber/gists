### html

```html
<div class="
    w-full
    h-96
    text-white
    bg-black
    after:relative
    after:-top-8
    after:content-['circular_dependency_test']
"
></div>
```

### scss

```scss
.bg-black {
    &:after {
        @apply bg-black;
    }
}
```

### error

You cannot `@apply` the `bg-black` utility here because it creates a circular dependency.

### solution 1

```scss
[class~='bg-black'] {
    &:after {
        @apply bg-black;
    }
}
```

### solution 2

```html
<div class="
    bg-black
    after:bg-black
"
></div>