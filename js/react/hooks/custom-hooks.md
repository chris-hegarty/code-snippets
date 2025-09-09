# Custom Hooks

This refactors the code from clock-app.md.
You combine the state variable and effect into a function.
You can do this in the same file at the bottom or put it in its own file.

Custom hooks are like any other function in JS that allow you to package up and reuse functionality.

You have to start it with the word "use"

### Clock.js (original):

```jsx
import React, {useState} from 'react';
import format from 'date-fns/format'

function Clock(){
  const[time, setTime] = useState(new Date());
  
  useEffect( () => {
    const intervalID = window.setInterval( ()=>{
      setTime( new Date() );
      }, 1000);
    
    return () => {
      window.clearInterval(intervalID);
    }
  }, [] );
  
  return(
    <p className={"clock"}>
      {format(time, 'hh:mm:ss a')}
    </p>
  );
}

export default Clock;
```

### Clock.js (w/ custom hook):

```jsx
function Clock(){
    const time = useTime();
    
    return(
        <p className={"clock"}>
          {format(time, 'hh:mm:ss a')}
        </p>
    );
}

export default Clock;

function useTime(){
  const[time, setTime] = useState(new Date());

  useEffect( () => {
    const intervalID = window.setInterval( ()=>{
      setTime( new Date() );
    }, 1000);

    return () => {
      window.clearInterval(intervalID);
    }
  }, [] );
}
```

useIsOnScreen hook:

```jsx

import React, {useState, useEffect, useRef} from 'react';

function useIsOnScreen(){
  const[isOnScreen, setIsOnScreen] = useState(false);
  const elementRef = useRef(null);
  
  useEffect( () => {
    const observer = new IntersectionObserver((entries) => {
      const [entry] = entries;
      setIsOnScreen(entry.isIntersecting);
    });
    observer.observe(elementRef.current);
    return () => {
      observer.disconnect();
    }
  },[elementRef]);
  
  return [isOnScreen, elementRef];
    
}

export default useIsOnScreen;
```

App.js

```jsx
import React, {useRef} from 'react';
import isOnScreen from './useIsOnScreen';

function App(){
  
  const [isOnScreen, elementRef] = useIsOnScreen(elementRef);
  return(
    <>
        <header>
          Red box visible: {isOnScreen ? 'YES' : 'NO'}
        </header>
        <div className="wrapper">
            <div ref={elementRef} className="red-box"></div>
        </div>
    </>
    
  );
}

export default App;
```