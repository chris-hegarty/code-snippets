# React.createElement

This section is to unpack the createElement method a bit.

What does this sentence mean?

_"Props are passed to the child within the render method of the parent as the second argument to React.createElement()."_

From the React docs
https://react.dev/reference/react/createElement

createElement lets you create a React element. It serves as an alternative to writing JSX.

```javascript
const element = createElement(type, props, ...children)
```

You call it like:

```javascript
function Greeting({name}){
  return(
    createElement(
      'h1',
      {className: 'greeting'},
      'Hello'
    )
  );
}
```

## Params:

### Type

Must be a valid React component.
Can be an HTML tag
Can be a React component like a function or special component, like <Fragment>

### Props

Is an object.
React will create the element with the props you've passed.
***IMPORTANT NOTE - "keys" and "ref" are NOT Props! 

### Child nodes

## Return

Returns a React element object with the following properties:

* type
* props
* ref
* key

