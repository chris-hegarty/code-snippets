# Mutation bugs

-See assignment vs mutation
-See rest and spread operators.

Here is code for a simple gradient picker:

Notice the initial state is an array.

App.js:

```jsx
import React from 'react';

function App(){
  const[colors, setColors] = useState([
    '#ffd500',
    '#ff0040'
  ])
  
  const colorStops = colors.join(', ');
  const backgroundImage = `linear-gradient( ${colorStops} )`;
  
  return (
    <>
      <div
      className="gradient-preview"
      style={{
        backgroundImage,
      }}
      >
      </div>
        
      <form action="">

        {colors.map( (color, index) => {
          const colorId = `color-${index}`;

          return (
            
            <div key={colorId} className="color-row">
              <label htmlFor={colorId}>Color {index + 1};</label>
              <input
                id={colorId}
                type="color"
                value={color}
                onChange={(e) => {
                  const nextColors = [...colors];
                  nextColors[index] = e.target.value;
                  setColors(nextColors);
                }}
              />
            </div>
            
          );
        })}
      </form>
    </>
  );
}
      

export default App;
```




(This is the correct version to compare.)
-Don't forget to open curly braces before opening a .map function.

```javascript
import React from 'react';

function App() {
  const [colors, setColors] = React.useState([
    '#FFD500',
    '#FF0040',
  ]);

  const colorStops = colors.join(', ');
  const backgroundImage = `linear-gradient(${colorStops})`;

  return (
    <>
      <div
        className="gradient-preview"
        style={{
          backgroundImage,
        }}
      />

      <form>
        {colors.map((color, index) => {
          const colorId = `color-${index}`;

          return (
            <div key={colorId} className="color-row">
              <label htmlFor={colorId}>
                Color {index + 1}:
              </label>
              <input
                id={colorId}
                type="color"
                value={color}
                onChange={(e) => {
                  const nextColors = [...colors];
                  nextColors[index] = e.target.value;

                  setColors(nextColors);
                }}
              />
            </div>
          );
        })}
      </form>
    </>
  );
}

export default App;
```



