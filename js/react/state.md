# The useState hook

When you import React, you also want to import the useState function.

That way, instead of writing "React.useState(0)"...

You can just write "useState(0)"

```js

import React, {useState} from 'react';

function Counter(){
  const[count, setCount] = React.useState(0);
  
  return(
    <button
      onClick={() => setCount(count + 1)}
    >
      Value: {count}
    </button>
  );
}

export default Counter;

```

When a state variable is updated, it triggers a re-render.

Each render is like taking a snapshot, and React compares the two.

When it's the first time and there is no component to compare, React calls it "Mounting" the component.

Important point to remember - even if React does not update the DOM, it is still re-rendering.

When it DOES change the DOM, it triggers a repaint by the browser.

## IMPORTANT: State setters are not immediate!!

Updating a state variable is an asynchronous operation. It affects what the state will be _for the next render._

### Examples

You might think this chunk outputs "1"...but it actually outputs "0".

```jsx

function App(){
  const[count,setCount] = useState(0);
  
  return(
    <>
      <p>You've clicked {count} times.</p>
      <button
            onClick={ () => {
              setCount(count + 1);
            }
        }
      >
        CLICK HERE
      </button>
    
    </>
  );
}

```

Here is how to work around that delay and access the new value right away.

In the onClick function:

* store the expression in a variable
* THEN pass variable into setCount():

```jsx

import React, {useState} from 'react';

function App(){
  const[count, setCount] = useState(0);
  
  return(
    <>
      <p>You've clicked {count} times.</p>
      <button
        onClick = {() => {
          const nextCount = count + 1;
          setCount(nextCount);
        }}
      >
        CLICK ME!
      </button>
    </>
  );
}
```

If you need to pass in a variable, use a wrapper function:

```jsx

<button
  onClick={ () => setTheme('dark') }
>
 Dark Theme 
</button>

```