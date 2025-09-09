# Setting state variables with callback functions

## Alternative syntax to directly calling a new value

-----------------------

The basic way:


```jsx
// set initial value to 0:
const[count, setCount] = useState(0);
//update the value to 100;
setCount(100);
```

You can instead pass a function that returns the new value.
It's the same as directly passing a new value.
The nice thing, though, is React will provide the CURRENT value this way.
And if you are working with effects, it helps get the freshest value.
This is helpful when using useEffect, useMemo and useCallback.
It's also valuable if you are passing a setter through props.

It helps you to avoid using a potentially stale "snapshot" state variable.

```jsx
setCount( (currentCount) => currentCount + 1);
```

