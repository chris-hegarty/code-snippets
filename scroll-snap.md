# Scrolling

https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_scroll_snap

CSS Scroll Snap works by applying two primary properties: 

`scroll-snap-type `

`scroll-snap-align`

------------

## scroll-snap-type

This is applied to the parent container.

It accepts two arguments:

-snap direction 

-snap behavior

```css

.container {
 scroll-snap-type: [ x | y | block | inline | both ] [ mandatory | proximity ];
}

```

"proximity" - means the snap only appears at the nearest point to where the user stopped scrolling.
"mandatory" - the snap occurs at defined points.

## scroll-snap-align

This is applied to the container's children.

```css

.children {
 scroll-snap-align: [ none | start | end | center ]{1,2};
}

```

NOTES:

- You have to specify the container's overflow AND give it a fixed height.
- Dont use "mandatory" if the content inside one of the child elements is longer than the parent container. (The 
  user wont be able to see that content.)