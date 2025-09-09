# Lifting state

Data can only be passed through props and through context.

One directional - parent to child.

It might be tempting to lift state all the way up to the App component, but it is a best practice to only lift state 
above the components that need it.

Example: Shopping List
You need two pieces of state here.
-The actual list of items
-The input for a new item.

--------------------------------

From the React docs:

_"Sometimes, you want the state of two components to always change together. 

To do it, remove state from both of them, move it to their closest common parent, and then pass it down to them via props. 

This is known as lifting state up, and it’s one of the most common things you will do writing React code."_

----------------------------------
```javascript
//AddNewItemForm.js

import React from 'react';

function AddNewItemForm(){
  const [label, setLabel] = useState('');
  return(
    <div className="new-list-item-form">
      <form
        onSubmit={(e)=>{
          e.preventDefault();
          handleAddItem(label);
          setLabel('');
        }}
      >
        <label>New Item: </label>
        <div className="row">
            <input 
              value={label}
              onChange={(e)=>{
                setLabel(e.target.value);
              }}
            />
            <button>
              Add Item
            </button>
          </div>
        </form>
    </div>
  );
}

export default AddNewItemForm();
```

Instead of an array, make each item an object with a unique key.
Then, when you want to add a new item, make that an object too.

```javascript

//App.js

import React, {useState} from 'react';
import AddNewItemForm from './AddNewItemForm';

function App(){
  const [items, setItems] = useState([]);
  
  function handleAddItem(label){
    const newItem = {
      label,
      id: Math.random(),
    }
    const nextItems = [...items, newItem];
    setItems(nextItems);
  }
  
  return(
    <div className="wrapper">
      <div className="list-wrapper">
        <ol className="shopping-list">
          {items.map(({id, label}) => {
            <li key={id}>{label}</li>
          })}
        </ol>
      </div>
      <AddNewItemForm handleAddItem={handleAddItem} />
    </div>
  );
}

export default App();

```



