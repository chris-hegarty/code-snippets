# useMemo

A hook to remember a computed value between renders.

It takes two arguments: a callback function that handles the computation and a dependency array.

```jsx


const allPrimeNumbers = React.useMemo(()=>{
  const result = [];
  
  for( let counter = 2; counter < selectedNum; counter++ ){
    if(isPrime(counter)){
      result.push(counter);
    }
  }
  return result;
},[selectedNum]);

```

Imagine an app with a clock in state that updates every second.

You dont want other stuff to update once a second as well. That's where useMemo() can help.

On mount, React does the calculation, then stores them in the variable "allPrimeNumbers".

### Differences between React.memo and useMemo hook

**React.memo** - memoizes the result of rendering a component, only re-running when the props change.

**React.useMemo** - memoizes the result of a computation, only re-running when the dependencies change.

Example

```js
let ExpensiveThing = memo(() => {
  let now = performance.now();
  while (performance.now() - now < 100) {
    // Artificial delay -- do nothing for 100ms
  }
  return <p>I am a very slow expensive component.</p>;
});
```

### Objects, arrays and preserved references

Simple data types — things like strings, numbers, and boolean values — can be compared by value. 

But when it comes to arrays and objects, they're only compared by reference. 

Reminder: when we write `let cat = "Zoe"`  cat IS NOT Zoe...cat POINTS TO the "box" Zoe is in.

----------------

Good read on reference in JavaScript: https://daveceddia.com/javascript-references/

-----------------

Problem: rendering invokes the component function and everything inside it:

```jsx
// Every time we render this component, we call this function...
function App() {
  // ...and wind up creating a brand new array...
  const boxes = [
    { flex: boxWidth, background: 'hsl(345deg 100% 50%)' },
    { flex: 3, background: 'hsl(260deg 100% 40%)' },
    { flex: 1, background: 'hsl(50deg 100% 60%)' },
  ];

  // ...which is then passed as a prop to this component!
  return (
    <PureBoxes boxes={boxes} />
  );
}

```

Solution with useMemo. In this case, we are only preserving a reference to the array.

```jsx
const boxes = React.useMemo(() => {
  return [
    { flex: boxWidth, background: 'hsl(345deg 100% 50%)' },
    { flex: 3, background: 'hsl(260deg 100% 40%)' },
    { flex: 1, background: 'hsl(50deg 100% 60%)' },
  ];
}, [boxWidth]);
```



