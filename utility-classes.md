

### Full-width container:

```css
.full-bleed {
  width: 100vw;
  margin-left: calc(50% - 50vw);
}

.wrapper {
  max-width: 50rem;
  margin-left: auto;
  margin-right: auto;
}

/* Or, target the direct children of the wrapper: */

.full-bleed > * {
  max-width: 50rem;
  margin-left: auto;
  margin-right: auto;
}

```

### Get rid of horizontal scrolling:

```css
body {
  overflow-x: hidden;
}

```