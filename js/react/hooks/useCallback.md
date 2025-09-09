# useCallback

Works similarly to useMemo, except it stores functions instead of arrays or objects.

--------------

Syntax:

```jsx
const handleMegaBoost = React.useCallback( () => {
  return function() {
    setCount( (currentValue) => currentValue + 1234);
  }
},[]);
```

Note that the example uses the alternative syntax for updating a state variable (See state-setter callback functions).

This lets you 
-avoid using "count" in the dependency array
-therefore avoiding regenerating the function each time "count" is updated.
-you get the freshest value.

### Note: You can sometimes wrap an entire export.

Example: Grids and Pixels

App.js | Grid.js | Utils.js

Grid.js:

```jsx

import React from 'react';

import { range } from './utils';

function Grid({ numRows, numCols }) {
  console.info('Grid render');
  
  return (
    <div className="grid-wrapper">
      {range(numRows).map((rowIndex) => (
        <div key={rowIndex} className="row">
          {range(numCols).map((colIndex) => (
            <div key={colIndex} className="cell" />
          ))}
        </div>
      ))}
    </div>
  );
}

export default React.memo(Grid);

```

App.js

```jsx

import React, {useState, useCallback, useMemo} from 'react';

import Grid from './Grid';

function App() {
  const [
    mousePosition,
    setMousePosition,
  ] = React.useState({ x: 0, y: 0 });

  const [numRows, setNumRows] = React.useState(12);
  const [numCols, setNumCols] = React.useState(12);

  const id = React.useId();

  React.useEffect(() => {
    function handleMouseMove(event) {
      setMousePosition({
        x: event.clientX,
        y: event.clientY,
      });
    }

    window.addEventListener('mousemove', handleMouseMove);

    return () => {
      window.removeEventListener(
        'mousemove',
        handleMouseMove
      );
    };
  }, []);

  return (
    <>
      <form>
        <div>
          <label htmlFor={`${id}-rows`}>Rows:</label>
          <input
            id={`${id}-rows`}
            type="range"
            value={numRows}
            onChange={(event) => setNumRows(event.target.value)}
            min={5}
            max={40}
          />
        </div>
        <p>
          {mousePosition.x} / {mousePosition.y}
        </p>
        <div>
          <label htmlFor={`${id}-cols`}>Columns:</label>
          <input
            id={`${id}-cols`}
            type="range"
            value={numCols}
            onChange={(event) => setNumCols(event.target.value)}
            min={5}
            max={40}
          />
        </div>
      </form>
      
      <Grid numRows={numRows} numCols={numCols} />
    </>
  );
}

export default App;

```

utils.js (for "range" functionality)

```jsx

export const range = (start, end, step = 1) => {
  let output = [];
  if (typeof end === 'undefined') {
    end = start;
    start = 0;
  }
  for (let i = start; i < end; i += step) {
    output.push(i);
  }
  return output;
};

```

### Shopping Cart

#### Files: App.js | ShoppingCart.js | CartTable.js

App.js - Here we set items in state, and make an object for each item:

```jsx

import React from 'react';

import ShoppingCart from './ShoppingCart';

function App() {
  const [items, setItems] = React.useState([
    {
      id: 'hk123',
      imageSrc: 'https://sandpack-bundler.vercel.app/img/shopping-cart-coffee-machine.jpg',
      imageAlt: 'A pink drip coffee machine with the “Hello Kitty” logo',
      title: '“Hello Kitty” Coffee Machine',
      price: '89.99',
      inStock: true,
    },
    {
      id: 'co999',
      imageSrc: 'https://sandpack-bundler.vercel.app/img/shopping-cart-can-opener.jpg',
      imageAlt: 'A black can opener',
      title: 'Safety Can Opener',
      price: '19.95',
      inStock: false,
    },
    {
      id: 'cnl333',
      imageSrc: 'https://sandpack-bundler.vercel.app/img/shopping-cart-night-light.png',
      imageAlt: 'A kid-friendly nightlight sculpted to look like a dog astronaut',
      title: 'Astro-pup Night Light',
      price: '130.00',
      inStock: true,
    },
    {
      id: 'scb777',
      imageSrc: 'https://sandpack-bundler.vercel.app/img/shopping-cart-backpack.jpg',
      imageAlt: 'A pink backpack with a unicorn illustration',
      title: 'Magical Unicorn Backpack',
      price: '74.98',
      inStock: true,
    },
  ]);
  
  return (
    <ShoppingCart
      items={items}
    />
  );
}

export default App;

```
CartTable.js - Here, we memoize the entire component on export:
(Also note that items is a prop set in App.js)

```jsx
import React from 'react';

function CartTable({ items }) {
  console.info('CartTable render');

  return (
    <table className="shopping-cart">
      <thead>
      <tr>
        <th></th>
        <th>Title</th>
        <th>Price</th>
      </tr>
      </thead>
      <tbody>
      {items.map(
        ({
           id,
           imageSrc,
           imageAlt,
           title,
           price,
         }) => (
          <tr key={id} className="cart-row">
            <td>
              <img
                className="product-thumb"
                src={imageSrc}
                alt={imageAlt}
              />
            </td>
            <td>{title}</td>
            <td>${price}</td>
          </tr>
        )
      )}
      </tbody>
    </table>
  );
}

export default React.memo(CartTable);

```

ShoppingCart.js - Here we will memoize the in stock and out of stock items.
We are also 
-passing the "items" prop in from App.js
-using `filter()` to filter the items


```jsx

import React, {useState, useMemo, useId} from 'react';

import CartTable from './CartTable';

function ShoppingCart({items}){
  const [postalCode, setPostalCode] = useState('');
  const postalCodeId = useId();
  
  const inStockItems = useMemo(()=>{
    return items.filter((item) => item.inStock)
  },[items]);
  
  const outOfStockItems = useMemo(()=>{
    return items.filter((item)=> !item.inStock);
  },[items]);
  
  return(
    <>
      <h2>Shopping cart</h2>

      <form>
        <label htmlFor={postalCodeId}>
          Enter Postal / ZIP code for shipping
          estimate:
        </label>
        <input
          id={postalCodeId}
          type="text"
          value={postalCode}
          onChange={(e) => {
            setPostalCo(e.target.value);
          }}
        />
      </form>

      <CartTable items={inStockItems} />

      <div className="actions">
        <button>Continue checkout</button>
      </div>

      <h2>Sold out</h2>
      <CartTable items={outOfStockItems} />
    </>
  );
}

export default ShoppingCart;

```




