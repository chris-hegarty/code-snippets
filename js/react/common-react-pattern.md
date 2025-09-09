# Common React pattern

* Elements - anything inside angle brackets.
* Components - return elements.

## You define a component by writing a function that returns an element.

1) Import your stuff
2) Write the function. Return the element with its props.
3) Deploy the component to the DOM.

```javascript

import React from "react";

//Create the component with the props object. Preferably destructured.
function FriendlyGreeting(props){
  return (
    <p
      style={{
        color: "blue",
        fontSize: "20px"
      }}
    >
      Greetings, {props.name}!
    </p>
  );
}

//Deploy the component:
render(
 <div>
   <FriendlyGreeting name="Chris" />
 </div>,
  document.querySelector('#root')
);

```

### Remember though: you'll rarely see "props" written like this.

Most of the time, the function will use object destructuring.

This is handy so you can see what the props are rigth away.

```javascript
function FriendlyGreeting({ name }){
  return (
    <p
      style={{
        color: "blue",
        fontSize: "20px"
      }}
    >
      Greetings, {name}!
    </p>
  );
}
```
In pure JavaScript, this looks like:

```javascript
render(
  React.createElement(
    FriendlyGreeting,
    {
      name: "Chris"
    }
  ),
  document.querySelector("#root")
);
```

(The React element is basicaly transpiled to a JavaScript object.)

Another example:

Remember that

color: color
is the same as just
color


```javascript
function Button({color, borderColor, children}){
  return(
    <button
      style={{
        background: 'white',
        borderRadius: 4,
        padding: 20,
        color,
        borderColor
      }}
    >
      {children}
    </button>
  )
}

render(
    <div>
      <Button
        color="red"
        borderColor="red"
      >
        Learn More
      </Button>
      <Button
        color="green"
        borderColor="green"
      >
        Contact Us
      </Button>
    </div>
)
```