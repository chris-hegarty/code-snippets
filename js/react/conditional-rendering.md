# Conditional Rendering

----------

## IF statements

You cant use statements in JSX.

You have to pull the logic out of the JSX... (if you want to use if statements)

### (Note: You can assign chunks of JSX to variables)

```jsx

function Friend({ name, isOnline }){

    if(isOnline){
        prefix = <div className="online-status" />;
    }

    return(
      <li className="friend">
        {prefix}
        {name}
      </li>
    );

}

export default Friend;

```

-------------

## Using && operator
 
This is a control flow operator.

### _It is an expression, not a statement._

Important things to note:

-It does NOT return true or false. It returns either the left or the right hand side. HOWEVER...
-It is a good practice to make sure the left side is a boolean.
-React will ignore most falsy values (like "false" or "null") but it won't ignore zero.

See how React handles various falsy values:

```jsx

function App() {
  return (
    <ul>
      <li>false: {false}</li>
      <li>undefined: {undefined}</li>
      <li>null: {null}</li>
      <li>Empty string: {''}</li>
      <li>Zero: {0}</li>
      <li>NaN: {NaN}</li>
    </ul>
  );
}

export default App;

//This code consoles out to:

// false:
// undefined:
// null:
// Empty string:
// Zero: 0
// NaN: NaN

```

The && control flow operator allows for using logic within the JSX.

The same example from above can be written like this:

```jsx

function Friend({ name, isOnline }) {
  return(
    <li className="friend">
      { isOnline && <div className="green-dot" /> }
      {name}
    </li>
  );
}

function App(){
  return(
    <ul>
      <Friend name="Mike" isOnline={false} />
      <Friend name="Ellen" isOnline={true}/>
      <Friend name="Tyler" isOnline={false}/>
    </ul>
  );
}
```

Here is an example of using a boolean expression on the left hand side.
(Greater than and less than are booleans)

```jsx

function App(){
  const shoppingList = ['stuff1', 'thing2', 'stuff3'];
  const numOfItems = shoppingList.length;
  
  return(
    <div>
      {numOfItems > 0 && (
        <ShoppingList items={shoppingList} />
      )}
    </div>
  )
}
```

------------------------------------------

## Ternaries

The && operator lets us conditionally render something if a condition is met.

### A ternary allows us to **_render something else if the condition is not met_**.

Here is an example of checking if a user is logged in -- ONLY with &&.

### Note: remember that the two exclamation points are converting "user" into a boolean.

The first negates "user". (a truthy value becomes false; a falsy value becomes true.)
THEN - The 2nd negates the result AGAIN, converting it back to its original truthy/falsy value.


```jsx

function App({ user }) {
  
  const isLoggedIn = !!user;
  
  return(
    <>
      {isLoggedIn && <AdminDashboard />};
      {!isLoggedIn && <p>Please login first.</p>};
    </>  
  );
  
}
```

THE TERNARY IS BETTER IN THIS SITUATION.
(It also allows you to embed logic directly into JSX...because it is an OPERATOR, not a STATEMENT, so it can be used 
inside an EXPRESSION).

```jsx

function App({ user }){
  const isLoggedIn = !!user;
  
  return(
    <>
      {isLoggedIn
        ? <AdminDashboard />
        : <p>Please login first.</p>
      }
    </>  
  );
}

```

### Example: Two factor auth with ternary:

-Start by setting the state hook with code/setCode
-Initialize it with an empty string!!
-Bind it to the input with val=code
-set up the onChange event in the input to watch for user input.
-Use an onSubmit() event on the form, rather than an onClick() event on the button.
-"handleSubmit" is a solid naming convention for the function you need to set up for the submit event.
(That way, it still goes through id the user hits return instead of clicking on the button.)
-The <form> can be your top most element, instead of using fragments.
-Make sure to use e.preventDefault so your form doesn't refresh the page on submit.

```jsx

import React, { useState } from 'react';

const CORRECT_CODE = '123456';

function TwoFactor(){

  const[code, setCode] = useState('');
  
  function handleSubmit(e){
    e.preventDefault();
    const isCorrect = code === CORRECT_CODE;
    window.alert(isCorrect ? 'Correct' : 'Incorrect!')
  }
     
return(
    <form onSubmit={handleSubmit}>
    
      <label htmlFor="auth-code" >Enter Auth Code</label>
      
      <input
        id="auth-code"
        type="text"
        required={true}
        maxLength={6}
        val={code}
        onChange={(e)=>{
          setCode(e.target.value)
        }}
      />
      
      <button>VALIDATE</button>
                  
    </form>

);

}

export default TwoFactor;



```