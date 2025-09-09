# Fluid Type Scales

### Utopia - Type, Space and Grid Calculators
https://utopia.fyi/

### Blog post and calculator for CSS clamp:
https://www.aleksandrhovhannisyan.com/blog/fluid-type-scale-with-css-clamp/
Fluid Type Calculator
https://www.fluid-type-scale.com/

### Linearly scale font-size with CSS clamp() based on the viewport
https://css-tricks.com/linearly-scale-font-size-with-css-clamp-based-on-the-viewport/

### Andy Bell blog post:
https://css-tricks.com/consistent-fluidly-scaling-type-and-spacing/

"In that screenshot of type-scale.com, I’ve selected a “Perfect Fourth” scale which uses a ratio of 1.333. This means each time you go up a size, you multiply the current size by 1.333, and each time you go down a size, you divide by 1.333.

If you have a base font size of 16px, using this scale, the next size up is 16 * 1.333, which is 21.33px. The next size up is 21.33 * 1.333, which is 28.43px. This provides a lovely curve as you move up and down the scale."

https://typescale.com/

```css
.my-element {
  font-size: clamp(1rem, calc(1rem * 3vw), 2rem);
}
```

General Clamp Calculator
https://min-max-calculator.9elements.com/

The "Slope-Intercept" equation:
```
y = mx + b

y = difference between min and max font sizes (19px - 16px = 3)
x = difference between min and max viewport widths (1280px - 320px = 960)
```
Use x and y to find m:
```
m = (19px - 16px) / (1280px - 320px)
m = 3/960
m = 0.003125
```
Plug these values into "y = mx + b" to get the b value:
```
19px = (0.003125 * 1280px) + b
b = (0.003125 * 1280px) - 19px
b = 19px - 4px = 15px
```

We now have the pixel value and the slope value. 
To express the slope as a valid vw unit, we’ll need to multiply it by 100, 
meaning the slope is 0.3125 (rounded up to 0.31):

```css
body {
  --font-size-300: clamp(16px, 0.31vw + 15px, 19px)
}
```

Then divide by 16 to turn it into a rem value
```css
body {
  --font-size-300: clamp(1rem, 0.31vw + 0.938rem, 1.19rem)
}
```
Then you can use a SASS function to create fluid typography:
"Creating a Fluid Typescale with CSS Clamp":

https://www.aleksandrhovhannisyan.com/blog/fluid-type-scale-with-css-clamp/

Some examples:

```css

body {
    --font-size-fluid-0: clamp(.75rem, 2vw, 1rem);
    --font-size-fluid-1: clamp(1rem, 4vw, 1.5rem);
    --font-size-fluid-2: clamp(1.5rem, 6vw, 2.5rem);
    --font-size-fluid-3: clamp(2rem, 9vw, 3.5rem);
}

```




