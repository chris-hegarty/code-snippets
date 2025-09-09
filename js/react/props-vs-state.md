# Props vs State

From the course:

"This reveals an important truth about props: they're the tunnels that allow data to flow through our application".
They are INPUTS to components.
(Like arguments passed to a function)

The data that passes through props can be static or boolean...or they can use React state like "hasAgreed"

----------------------------

#### Example: A form where the button is disabled unless an "Agree to Terms" checkbox is checked.

-Set a state for the checkbox.

-Bind it to the checkbox input.

### _Now, you can use the state of the checkbox to control the button._

```jsx
<button disabled={!hasAgreed}></button>

```

### What if the button is a separate component?

That's where props come in.

They are a way for parent components to communicate with child components. The state of one component will often 
become the props of a child component.

Props are passed to the child within the render method of the parent as the second argument to React.createElement().

Or, if we use JSX, like an HTML tag:

```jsx
<Child name={childName}  />
```

They can be static boolean values....or you can use them with state.

This example sets up a Button component within a box rendered by the App component.

So there will be two files:

* App.js
* Button.js

The button will have

* a boolean to check whether it is enabled
* a variant based on whether it is enabled
* children


### button.js:

```jsx

import React, { useState} from 'react';

function Button( {variant, isEnabled, children } ) {
  return(
    <button
      disabled={!isEnabled}
    >
      {children}
    </button>
  );
}

export default Button;

```
### App.js:

-set a state variable for whether the user has agreed.
-"div" can be your topmost element, so no need for a fragment.
-notice how we wrap everything in the label element.



```jsx

import Button from './Button'

function App(){
  const[hasAgreed, setHasAgreed] = useState(false);
  
  return(
    <div className="continue-modal">
      
      <p>Are you sure you want to continue?</p>
      <label htmlFor="confirm-checkbox">
        <span className="required">*</span>
        <input
          id="confirm-checkbox"
          type="checkbox"
          val={hasAgreed}
          onChange={ () => setHasAgreed(!hasAgreed) } 
        />
        <span>I agree with the <a href="/terms">Terms and Conditions</a></span>
      </label>
      
      <div className="actions">
        <Button></Button>
        <Button></Button>
      </div>
      
    </div>
  );
}

export default Button;
```

Props can be used to control the particular instance of a component.

If you have one "Button" component, you can use it in multiple places, and use props to configure the output.

**The data that passes through props can be static or boolean...or they can use React state like "hasAgreed"**


