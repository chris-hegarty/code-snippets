# Cleanup

useEffects don't automatically go away when the component they are in is unmounted.

"Unmounted" does not mean "deleted". It's more like removing references to the component.

In the example below, "setMousePosition" is still attached to the component instance.

That means the JavaScript garbage collector can't clean it up.

Remember that useEffect is for managing stuff "outside" of React, so that's why React can't automatically clean up 
after whatever is going on inside it. 

For example, `window.addEventListener()` isn't part of React, it is part of the DOM.

React doesn't even know what is going inside a useEffect...it just knows it has a function to run, and instructions 
from the dependency array.

So how do you remove/cleanup after the effect? How do you remove the event listener?

You have to write and return a cleanup function WITHIN the main effect function, for React to hang on to for when the 
component 
unmounts.

This example shows a common pattern with useEffect:
* You start with the main logic function
* Then, inside it, you RETURN a cleanup function.

You write the cleanup function WITHIN the effect function so it has access to everything in that function. 

```jsx

//MouseTracker.js:

import React from 'react';

function MouseTracker() {
  const [mousePosition, setMousePosition] = React.useState({
    x: 0,
    y: 0,
  });

  React.useEffect(() => {
    // Effect logic:
    function handleMouseMove(event) {
      console.log('move');
      setMousePosition({
        x: event.clientX,
        y: event.clientY,
      });
    }

    window.addEventListener('mousemove', handleMouseMove);

    // Cleanup function:
    return () => {
      window.removeEventListener('mousemove', handleMouseMove);
    };
  }, []);

  return (
    <p>
      {mousePosition.x} / {mousePosition.y}
    </p>
  );
}

export default MouseTracker;

```

### NOTE: Another cool way to handle booleans in here:

```jsx
//App.js:

import React, {useState} from 'react';

import MouseTracker from './MouseTracker';

function App(){
  const[isTrackingMouse, setIsTrackingMouse] = useState(true);
  
  function toggleMouseTracking(){
    setIsTrackingMouse(!isTrackingMouse);
  }
  return (
    <div className="wrapper">
      <button onClick={toggleMouseTracking}>Toggle Mouse Tracking</button>
      {isTrackingMouse && 
        <MouseTracker />
      }
    </div>
    
  );
}
 export default App;

```