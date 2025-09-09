## Transitions with background images

```css

.bg-transition {
  .img {
    background-color:rgba(red,0.75);
    background-image:url(./youtube-a.jpg);
    background-size:125%;
    background-repeat:no-repeat;
    background-position: center;
    transition: 2s ease all;
    background-blend-mode:multiply;
  }
  &:hover {
    .img {
      background-color:rgba(red,0);
      background-size:100%;
      background-image:url(./youtube-a.gif);
    }
  }
}

```