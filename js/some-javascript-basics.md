# Some JavaScript basics/reminders:

//Use other tags besides "document":

```js
// Grab the header
const header = document.querySelector('#header');

// Find the first `<a>` tag inside the header
const firstLink = header.querySelector('a');
//                ^^^^^^ header, not document!
```
//Set an attribute:

```js
const node = document.querySelector('#user-andrew');

node.setAttribute('class', 'online');
```

//Change the text within an element using "innerText"
//Note: innerText is a property, not a method, so you don't need parentheses.

```js
const node = document.querySelector('#user-andrew');

node.innerText = 'Andrew (online)';
```

//Create a new element:

```js
const element = document.createElement('div');
```

//Add attributes:

```js
const element = document.createElement('div');

element.setAttribute('style', 'color: red;');
element.innerText = "Hello world!";

```

//Now attach it to the DOM with appendChild
//Note: appendChild can only be called on the <body> element, not on the element itself.

```js
const body = document.querySelector('body');
body.appendChild(element);
```
