# Full Screen Background Video example

```html

<body>
      <div class="home">
        <video autoplay muted loop>
          <source src="ressources/cooking.mp4" type="video/mp4" />
        </video>
        <div class="overlay"></div>
        <div class="home-content">
              <h1>High-End Kitchen.</h1>
              <div class="middle-line"></div>
              <button>DISCOVER</button>
        </div>
      </div>
  </body>

```

```css

.home {
  height: 100vh;
  position: relative;
}

video {
  object-fit: cover;
  position: absolute;
  width: 100%;
  height: 100%;
  position: absolute;
  z-index: 1;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  z-index: 2;
  background: rgba(0,0,0,0.6);
}
 ```

Note: in .overlay, you can use either

```
width: 100%;
height: 100%;
```

or

```
 top: 0;
 left: 0;
 bottom: 0;
 right: 0;

```

Next, make sure .home-content is `position: relative` so you can apply the z-index.

```css

.home-content {
  width: 600px;
  margin: 0 auto;
  position: relative;
  top: 150px;
  color: #fff;
  z-index: 3;
}

```