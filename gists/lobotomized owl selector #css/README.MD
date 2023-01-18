- apply manually only to specific divs
- use margin collapsing to handle margins between parents and inner child

```.scss
.owl > * + * {
    margin-top: 20px;
}

// if you want to exclude <input type="hidden" /> fields
.owl > input[type="hidden"] + *:not(input[type="hidden"]) {
    margin-top:0;
}
.owl > *:not(input[type="hidden"]) + input[type="hidden"] + *:not(input[type="hidden"]),
.owl > *:not(input[type="hidden"]) + input[type="hidden"] + input[type="hidden"] + *:not(input[type="hidden"]),
.owl > *:not(input[type="hidden"]) + input[type="hidden"] + input[type="hidden"] + input[type="hidden"] + *:not(input[type="hidden"]),
.owl > *:not(input[type="hidden"]) + input[type="hidden"] + input[type="hidden"] + input[type="hidden"] + input[type="hidden"] + *:not(input[type="hidden"]),
.owl > *:not(input[type="hidden"]) + input[type="hidden"] + input[type="hidden"] + input[type="hidden"] + input[type="hidden"] + input[type="hidden"] + *:not(input[type="hidden"]) {
    margin-top: 20px;
}
```