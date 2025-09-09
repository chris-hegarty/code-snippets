
```css
.box-shadow-example {
  box-shadow: -10px 2px 12px -6px rgba(0,0,0,0.16);
}
```

```css

:root {
  --callout-shadow-color: rgba(0, 0, 0, .132);
  --callout-shadow-secondary-color: rgba(0, 0, 0, .108);
}

.element {
  box-shadow: 0 3.2px 7.2px 0 var(--callout-shadow-color, rgba(0, 0, 0, .132)), 0 .6px 1.8px 0 var(--callout-shadow-secondary-color, rgba(0, 0, 0, .108));
}

```
