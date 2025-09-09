# The "ref" attribute + useRef() hook

Part of the JavaScript object that react.CreateElement returns.

Helpful to think of a ref as a box. 

The -primary- use case is to store DOM nodes.

But you can store anything you want in them:

* DOM nodes
* numbers
* arrays
* objects
* functions

By default, it creates a "current" property, set to undefined by default.

React refs, unlike React state variables, are intended to be mutated.

If you find yourself reaching for a classic "document.querySelector" or similar JS to target a DOM node, that's when 
you probably need to think about the useRef hook. Otherwise, you could end up with multiple component calls 
targeting the same node.

The workaround: use the "ref" attribute.

```jsx
<element
  ref={}
/>
```

Using the useRef hook:

```jsx

import React, {useRef} from 'react';

function ArtGallery(){
  //create a variable pointing to the new "useRef" object.
  //the initial state of "current" is "undefined".
  const canvasRef = useRef();
  //Then, you don't reassign the variable, you mutate the object.
  return(
    <main>
      <div className="canvasWrapper">
        <canvas
          //You could set current like:
          //canvasRef.current - ref;
          //The better way is to pass the canvasRef object directly to the ref attribute:
          ref={canvasRef}
        />
      </div>
    </main>
  );
}

```

Another example, using the <audio> tag:
Remember that when you set a useRef object, "current" starts as undefined.
```jsx
import React, {useState, useRef} from 'react';

function MediaPlayer({ src }){
  const [isPlaying, setIsPlaying] = useState(false);
  const audioRef = useRef();
  return(
    <div className="wrapper">
      <div className="media-player">
        <img src="" alt=""/>
        <div className="summary">
          <h2>Title</h2>
          <p>Description</p>
        </div>
        <button
          onClick={()=>{

            if(isPlaying){
              audioRef.current.pause();
            } else {
              audioRef.current.play()
            }
            
            //after this, reset the playing state:
            setIsPlaying(!isPlaying);
          }}
        >
          
        </button>
        
        <audio 
          ref={audioRef}
          src={src}
        />
      </div>
    </div>
    
  );
}
```





