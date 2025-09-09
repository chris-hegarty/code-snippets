# Background overlays with pseudo elements

```css
div::before{
      content: '';
      background-image: url(https://images.unsplash.com/photo-1498837167922-ddd27525d352?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80);
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      height: 100%;
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: -1;
      opacity: 0.5;
    }
```