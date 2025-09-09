# Range utility

If you don't know how many elements are in an array.

This is where you would use a classic for loop, above and outside of your JSX return statement.

```jsx

function StarRating({ rating }){
  let stars = [];
  for(let i=0; i > rating; i++) {
    stars.push(
      <img 
          key={i}
          alt=""
          className="goldStar"
          src="www.link.com"
      />
    );
  }
  
  return(
    <div className="star-wrapper">
      {stars}
    </div>
  );
}

```

#### **_The range utility is the EXPRESSION VERSION OF A CLASSIC FOR LOOP._**

It will produce an array from 0 up to n, where n is the supplied parameter.

Here is how you can put the logic into your JSX with the range utility:

```jsx

function StarRating({ rating }) {
  return(
    <div className="star-wrapper">
      {range(rating).map((num)=>(
            <img 
              key={num}
              alt=""
              className="gold-star"
              src="/source.com"
            />
          )
        )
      }
    </div>
  );
}

```

Here is what "range" is doing under the hood:

```javascript

const range = (start, end, step = 1) => {
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

### Example with grid-style layout using nested ranges/two-dimensional array:

Note: keys do not have to be globally unique. They just need to be uinique within their arrays.

Important because some of these grids may seem to share keys...but they actually don't, because they are in 
different arrays.

### grid.js:

```jsx

import { range } from './utils';

function Grid({ numRows, numCols }) {
  return (
    <div className="grid">
      {range(numRows).map(rowIndex => (
        <div key={rowIndex} className="row">
          {range(numCols).map(colIndex =>  (
            <div key={colIndex} className="cell"></div>
          ))}
        </div>
      ))}
    </div>
  );
}

export default Grid;

```
### App.js:

```jsx

import Grid from '/';

function App(){
  return(
    <Grid 
      numRows={8}
      numCols={6}
    />
  );
}

export default App;


```



