# CSS Layout generators

Layoutit
https://grid.layoutit.com/

CSS Grid Generator - Sarah Edo
https://grid.layoutit.com/

Griddy.io
https://griddy.io/

Grid by Example by Rachel Andrew
https://gridbyexample.com/examples/page-layout/

CSS Layouts by phuocng
https://github.com/phuocng/csslayout/tree/master/contents

Card with container queries
https://web.dev/patterns/layout/container-query-card?hl=en

Clamping width cards:
https://web.dev/patterns/layout/clamping-card?hl=en

```html

<div class="parent">
  <div class="card">
    <h1>Title Here</h1>
    <div class="visual"></div>
    <p>Descriptive Text. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed est error repellat veritatis.</p>
  </div>
</div>

```

```css


.parent {
  display: grid;
  place-items: center;
}

.card {
  width: clamp(23ch, 60%, 46ch);
  display: flex;
  flex-direction: column;
  padding: 1rem;
}

.visual {
    height: 125px;
    width: 100%;
  }
        

```

