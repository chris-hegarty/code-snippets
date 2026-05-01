# JSX

Here is a component that uses JSX instead of vanilla JS.

It does NOT use React.createElement.

But the JSX is transpiled into React.createElement (by Babel in a build process).

```js

import React from 'react';
import {createRoot} from 'react-dom/client';

//// Old way:
// const element = React.createElement(
//   'p',
//   {
//     id: 'hello',
//   },
//   'Hello World!'
// );

//JSX way:

const element = (
  <p id="hello">
    Hello World!
  </p>
);

const container = document.querySelector('#root');
const root = createRoot(container):
rooter.render(element);
```

### NOTE: convention in React to push the JSX onto its own line, and to use parentheses to ensure it works correctly.

------------------------------

## Expression Slots

Say you have an array, and you want to use the -length- of the array.
```js
const shoppingList = ['milk', 'bread', 'eggs'];
```
You would typically do "shoppingList.length" to return "3".

In React, HAVE TO USE CURLY BRACES TO INSERT THE EXPRESSION.

```js
const element = (
  <div>
    <p>There are {shoppingList.length} items on your shopping list.</p>
  </div>
)
```

## REMEMBER: We are only allowed to use expressions in the curly braces.

You cannot have a statement in the middle of a function call.

## Attribute Expression Slots
You can also use curly braces for dynamic attributes like ids or classes.
```js
const uniqueId = 'content-wrapper';

const element = (
  <main id={uniqueId}>
    Hello World
  </main>
);
```

---------------------------------

## GOTCHAS/Important differences from HTML and CSS

### You CANNOT use "class" or "for". 
They are reserved keywords.

_("for" is a "label" attribute.)_


In JSX:

* use className instead of "class"
* use htmlFor instead of "for"

### Self-closing tags must be closed with a slash.

You can't just do 
```html
<img src="pic.jpg">
```
You have to close it with a slash:
```js
const element = (
  <img src="pic.jpg" />
)
```

### HTML attributes must be camel case!

```js
const element = (
  <video
    src="/videos/cat-skateboarding.mp4"
    autoPlay={true}
    //  ^ Capital “P”
  />
);
```
Other examples:
* onclick → onClick
* tabindex → tabIndex
* stroke-dasharray → strokeDasharray (this one is specific for SVGs)

The only exceptions are data attributes and ARIA attributes:

```js

const element = (
  <button
    data-test-id="close-dialog-button"
    aria-label="Close dialog"
  >
    <img alt="" src="/icons/x.svg" />
  </button>
);
```

### Inline CSS styles are OBJECTS!

If you want to add an inline style in JSX, it must be an object.

That means DOUBLE BRACKETS.

The outer brackets create the expression slot.
The inner bracket create the style object.

```js
const element = (
  <div
    style={{
      color: 'red',
      fontSize: '24px',
    }}
  >
    Hello World
  </div>
);
```

* One trick is to create the style object separately, then insert it into the expression slot:

```js
const customStyles = {
  fontSize: '2rem',
  fontWeight: 'bold',
};

const element = (
  <h1 style={customStyles}>
    Hello World!
  </h1>
);
```

### All CSS properties are written in camelCase!

* background-position becomes **backgroundPosition**
* border-bottom-color becomes **borderBottomColor**

```js
<div
  style={{
    width: 200, // Equivalent to `width: 200px`
    paddingTop: 8, // Equivalent to `padding-top: 8px`
  }}
>
```