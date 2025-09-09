# Clock App

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

function App(){
  const[showClock, setShowClock] = useState(true);
  return(
    <>
        <button
          className="clock-toggle"
          onClick={ () => setShowClock(!showClock) }
        >
          {showClock ? 'CLOCK ON' : 'CLOCK OFF'}
        </button>

      {showClock && <Clock />}
      
    </>
  );
}

export default App;


```