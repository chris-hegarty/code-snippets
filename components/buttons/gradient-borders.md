# Border gradient buttons

THis uses a super cool technique to apply a gradient to a button's borders. 
It uses a linear gradient and a conic gradient layered on top of each other, and a registered custom property.
Then uses "padding box" on the linear gradient.

Note: "turn" is used to specify a rotation angle as a fraction of a circle. 
"1urn" = 360 degrees.

-Make the border transparent



```css

@property --angle {
    syntax: "<angle>";
    initial-value: 0turn;
    inherits: true;
}

@keyframes rotate {
    to {
        --angle: 1turn;
    }
}

button {
    font: inherit;
    color: black;
    padding: .5em 1.25em;
    border-radius: 8px;
    border: 8px solid transparent;
    background: linear-gradient(white) padding-box,
    conic-gradient(from var(--angle), purple, yellow, purple) border-box;
}

button:hover, button:focus-visible {
    animation: rotate 3s linear infinite;
}


```

Note: transitions using "starting style":

```css

.thing {
    opacity: 1;
    translate: 0 0;
    @starting-style {
        opacity: 0;
        translate: 0 10px;
    }
}

```
