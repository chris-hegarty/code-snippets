# Clock App

Here is the new file with the new hook: "useToggle":

```jsx
import React, {useState} from 'react';

function useToggle(initalValue = false){
  //generic name for the state variable 
  const [value, setValue] = useState(initialValue);
  //write a toggleValue function:
  //setValue uses a setter function so wherever the hook is used, it gets the freshest value:
  const toggleValue = () => setValue( (currentValue) => !currentValue );
  // This will return an array:
  return [
    value,
    toggleValue
  ];
}

export default useToggle;
```

Here is the hook where we memoize the toggleValue() function:

```jsx

function useToggle(initialValue = false) {
  if (typeof initialValue !== 'boolean') {
    console.warn('Invalid type for useToggle');
  }

  const [value, setValue] = React.useState(
    initialValue
  );

  function toggleValue() {
    setValue((currentValue) => !currentValue);
  }

  return [value, toggleValue];
}

```

Clock.js:
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

App.js:
```jsx

import React, {useState} from 'react';
import Clock from './Clock'
import useToggle from './useToggle';

function App(){
  // const[showClock, setShowClock] = useState(true);
  // Refactored to use custom toggle hook:
  const[showClock, toggleClock] = useToggle(true);
  return(
    <>
        <button
          className="clock-toggle"
          // onClick={ () => setShowClock(!showClock) }
          // refactor to use custom Toggle hook function:
          // onClick = { () => toggleClock() }
          //or you can make it even more concise. There's no argument so you can just pass the function name
          onClick = {toggleClock}
        >
          {/*{showClock ? 'CLOCK ON' : 'CLOCK OFF'}*/}
          Toggle Clock
        </button>

      {showClock && <Clock />}
      
    </>
  );
}

export default App;
```