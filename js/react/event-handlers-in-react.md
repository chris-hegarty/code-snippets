# Event handler patterns

## To pass in a function with no params

Notice that you do -NOT- add parens at the end of the function, becasuse that would call the function imjmediately, 
adn you want to let React decide when to call it.

```jsx
const handleClick = () => alert("clicked");

<button
  onClick={handleClick}
>
 Click Me 
</button>
```

## To pass in a function with params

To do this, you need to pass in an anonymous function, like:

```jsx

<button
  onClick={ () => handleClick('param')}
>
  Click Here
</button>

```