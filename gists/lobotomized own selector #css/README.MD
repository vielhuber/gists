- apply manually only to specific divs
- use margin collapsing to handle margins between parents and inner child

```.scss
.owl > * + * {
    margin-top: 20px;
}
```