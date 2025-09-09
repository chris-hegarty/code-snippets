# useEffect

## **A React hook that lets you sync a component with an external system.**

-----------

Remember that with the React Core Loop, functional components are essentially returning descriptions of the UI that 
React translates to changes to the DOM.

Sometimes you need to do things that fall out of this purview. Like, sometimes you need to update something outside 
the root React application, but need to keep it in sync with React's changes.

Example: updating the "title" so your browser tab updates. It lives in the <head>...so it falls outside React's purview.

React calls these "side effects".

We are telling React to call this function immediately after every re-render.

If a state variable (count) or a prop (name) changes, React first renders, and updates the UI described in the return.

Immediately after that, it calls the useEffect function:

```jsx
function Counter({name, initialVal = 0}) {
  
  const[count, setCount] = useState(initialVal);
  
  useEffect(() => {
    document.title = `(${count}) - Counter 2.0`
  }, [count]);

  return(
    <>
    
    </>
  );
}
```

### Dependency array: controlling when useEffect fires.

You can actually call the document.title change without the useEffect hook -- but the hook gives you more control.

Without it, you'd be updating the title on EVERY re-render when you dont actually need to. (Like if you update the 
name prop, the "count" state variable in the title would also update, even though it hasn't changed.)

useEffect takes an array as a 2nd argument. Here, you enter the state variable the hook depends on. 

It basically means React will only call the function when that state variable changes.

useEffect works when you tell it what to look for in its dependency tree.

-------------

### IMPORTANT NOTES 

-useEffect will always fire after the first time the component mounts, and will begin listening for the state 
variable AFTER that.

-If "Strict Mode" is enabled, the effect will run TWICE when the component mounts.

-You can only call it at the TOP LEVEL of your component. You can’t call it inside loops or 
conditions.

-You can have multiple useEffects in a component. In fact, it is recommended to limit useEffect to a single concern 
if possible.

------------

### Example: Give an input field focus on page load.

This uses the useRef hook AND useEffect hook.

NOTES: 
* If you set an empty array, the effect ONLY runs on mount, and not again after that.
* `<input>` has a built-in autofocus attribute, but it DOES NOT WORK in React.
* "Subscriptions": it's super important that, when you use something like `window.addEventListener` to provide 
useEffect with an EMPTY ARRAY. 
That way, you only add a SINGLE EVENT LISTENER when the component mounts.
  (Otherwise, you are adding event listeners on every change and your computer will explode.)
* You need to use a named function with event listeners/subscriptions, otherwise you cant de-register them.

```js

import React, {useEffect, useRef} from 'react';

function App(){
  const[searchTerm, setSearchTerm] = useState('');
  //remember that when you 1st set up useRef, the "current" value defaults to "undefined".
  const inputRef = useRef();
  
  useEffect(()=>{
    inputRef.current.focus();
  },[]);
  
  return(
    <form>
      <input 
        ref={inputRef}
        value={searchTerm}
        onChange={(e)=>{
          setSearchTerm(e.target.value);
        }}
      />
    </form>
  );
}

```

Example: Watch for the window resizing and return the width and height coordinates:

```jsx

import React, {useState, useEffect} from 'react'

function WindowSize(){
  const[windowDimensions, setWindowDimensions] = useState({
    width: window.innerWidth,
    height: window.innerHeight,
  });
  
  useEffect( () => {
    function handleResize() {
      setWindowDimensions({
        width: window.innerWidth,
        height: window.innerHeight,
      });
      window.addEventListener('resize', handleResize);
    }
  },[]);
  
  return(
    <p>
      {windowDimensions.width} / {windowDimensions.height}
    </p>
  );
}

export default WindowSize;

```

Cool way to handle booleans:

```jsx
//Instead of this:
      if (entry.isIntersecting) {
        // Show character
        setIsShown(true);
      } else {
        // Hide character
        setIsShown(false);
      }
      
      //"entry.isIntersecting" is already a boolean, so just write:

      setIsShown(entry.isIntersecting)


```