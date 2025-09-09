# Prop Delegation

What if a component has a list of props and you want to pass them all?

Instead of listing them out one by one, we can rest and spread synyax.

```jsx

function Banner({ user, ...rest }){
  
  return <Banner {...rest} />
}

```

Then you apply them like:

```jsx

<Banner {...rest}  />

```

The line above is the same as:

```jsx

<Banner
  type={delegated.type}
  children={delegated.children}
/>

// ...which is the same thing as this code:
<Banner type={delegated.type}>
  {delegated.children}
</Banner>

```


Example: a slider element that extends the native input type range element.

Files: app.js | Slider.js

```jsx
//Slider.js
//In this first example, we only expose four attributes to pass on the range slider.
//Anything else you try to pass in App.js will be ignored.

import React, { useId } from 'react';

//In this first example, we only expose four attributes to pass on the range slider.
//Anything else you try to pass in App.js will be ignored.
//The workaround is to take this line:

//function Slider({ label, min, max, value, onChange }) {

//And rewrite it like this:

function Slider({ label, ...rest }) {
  const id = useId();
  
  return(
    <div>
      <label htmlFor=""></label>
      
  {/*Then, instead of passing the props one by one, we use rest:*/}
      
      <input 
        type="range"
        id={id}
        {...rest}
      />
    </div>
    
  );
}

export default Slider;

```
app.js

```jsx

import React from 'react';

import Slider from './Slider';

function App(){
  
  return(
    <main>
      //Now we can pass any attributes we want to the slider:
      <Slider 
      
      
      />
        
    </main>
  );
}

export default App;

```