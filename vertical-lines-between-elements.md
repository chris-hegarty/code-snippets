# Add vertical lines between elements

### This is handy for visually separating links.

![vertical-lines.png](..%2Fvertical-lines.png)

Select the a elements, but not the last one.

Add an after pseudo element and make it a pipe, like: " | "

```css

        a:not(:last-child) {
          &::after {
            content: ' | ';
          }
        }

```