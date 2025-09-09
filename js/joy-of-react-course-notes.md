

React takes object descriptions of DOM elements, and renders them to the screen.
Take this "reactElement" object:
```js
const reactElement = {
type: 'a',
props: {
  href: 'https://wikipedia.org/',
},
  children: 'Read more on Wikipedia',
};
```

Here is what React is doing, shown with plain JS.
It uses plain JS methods like createElement, setAttribute and appendChild.

```js
function render(reactElement, containerDOMElement) {
  // 1. create a DOM element
  const domElement = document.createElement(reactElement.type);

  // 2. update properties
  domElement.innerText = reactElement.children;
  for (const key in reactElement.props) {
    const value = reactElement.props[key];
    domElement.setAttribute(key, value);
  }

  // 3. put it in the container
  containerDOMElement.appendChild(domElement);
}
```

## "Props"

are members of an object that associates a key with a value.

It is an abstract concept.

In the following code, the object has two properties:

```js
const obj = {
  a: 1,
  b() {},
};
```
## React Props

In React, "Props" are arguments passed into React components.
They are passed via HTML attributes.

Example:
Add a "brand" attribute to the "Car" element:

```js
const myElement = <Car brand="Porsche" />;
```

The component recieves the argument as a "props" object:

```js
function Car(props){
  return(
    <h2>The car is a {props.brand}</h2>
  )
}
```
If you have a variable, put it inside curly brackets:

```js

function Garage(){
  const carName = "Veloster";
  
  return(
    <Car brand={carName} />  
  );
}

```
