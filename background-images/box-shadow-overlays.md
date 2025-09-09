# Using box-shadow for an overlay

Note: This could have performance issues, so probably not a great option for full-screen

CodePen link: https://codepen.io/selbekk/pen/ydzmEv

```html
<div class="image-box" style="--image-url: url(https://picsum.photos/3000/2000)">
  <h1>Buy our product</h1>
</div>
```

```css

.image-box {

  /* Here's the trick */
  box-shadow: inset 0 0 0 100vw rgba(0,0,0,0.5);

  /* Basic background styles */
  background: var(--image-url) center center no-repeat;
  background-size: cover;

  /* Here's the same styles we applied to our content-div earlier */
  color: white;
  min-height: 50vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

```