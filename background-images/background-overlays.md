# Background Image Overlays

Resources:

Hero generator:
https://hero-generator.netlify.app/?ref=undesign

Animated background generator:
https://wweb.dev/resources/animated-css-background-generator

Use a custom variable to pass values:
https://dev.to/selbekk/how-to-overlay-your-background-images-59le

```html

<div class="image-box" style="--image-url(some-image.jpg)">
  <h1>Buy our product</h1>
</div>

```

```css

.image-box {

  /* Here's the trick */
  background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)) , url("picture.png");
  background-size: cover;

  /* Here's the same styles we applied to our content-div earlier */
  color: white;
  min-height: 50vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

```

## So for ACF:

Use an inline style tag.
Use the CSS background shorthand.
You'll essentially have two, comma-separated backgrounds.
The linear gradient should come first, then the URL.


------

Good background gradient to try:

```CSS
background: linear-gradient(175deg, rgba(5, 5, 5, 0.53) -15.8%, rgba(21, 21, 21, 0.1) 98.69%);
```



