import React, { useState } from 'react';

function App() {
  const [colors, setColors] = useState(['#ffd500', '#ff0040']);
  const colorStops = colors.join(', ');
  const backgroundImage = `linear-gradient(${colorStops})`;

  function addColor(){
    if(colors.length >= 5){
      window.alert("There is a maximum of five colors");
      return;
    }
    const nextColors = [...colors];
    nextColors.push("#000");
    setColors(nextColors);
  }

  function removeColor(){
    if(colors.length <= 2) {
      window.alert("There is a minimum of two colors.")
      return;
    }
    const nextColors = [...colors];
    nextColors.pop();
    setColors(nextColors);
  }

  return (
    <div className="wrapper">
      <div className="actions">
        <button
          onClick={removeColor}
        >
          Remove Color
        </button>
        <button
        onClick={addColor}
        >
        Add Color
        </button>
      </div>

      <div
        className="gradient-preview"
        style={{
          backgroundImage,
        }}
      />

      <div className="colors">
        {colors.map( (color, i) => {
          const colorId = `color-${i}`;
          return (
            <div
              key={colorId}
              className="color-wrapper"
            >
              <label htmlFor={colorId}>Color {i + 1}</label>
              <div
                className="input-wrapper"
              >
                <input
                  type="color"
                  id={colorId}
                  value={color}
                  onChange{e=>{
                    const nextColors = [...colors];
                    nextColors[i] = e.target.value;
                    setColors(nextColors);
                }}
                />
              </div>
            </div>
          );
        })
        }
      </div>
    </div>
  );
}

export default App;