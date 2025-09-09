# Stale values
## Media player example

This example sets up a keyboard shortcut with the space bar.
You have to both update the state variable AND the audio tag.
This example sets up and uses TWO useEffect hooks.

Three files: app.js | MediaPlayer.js | VisuallyHidden.js

#### VisuallyHidden.js:

```js
import React from 'react';

const hiddenStyles = {
  display: 'inline-block',
  position: 'absolute',
  overflow: 'hidden',
  clip: 'rect(0 0 0 0)',
  height: 1,
  width: 1,
  margin: -1,
  padding: 0,
  border: 0,
}

const VisuallyHidden = ({ children }) => {
  return(
    <span style={HiddenStyles}>
      {children}
    </span>
  );
}

export default VisuallyHidden;
```

#### MediaPlayer.js

```jsx

import React, { useState, useRef, useEffect } from 'react';
import {Play, Pause} from 'react-feather';
import VisuallyHidden from './VisuallyHidden';

function MediaPlayer({ src }){
  const[playing, setIsPlaying] = useState(false);
  const audioRef = useRef();
  
  useEffect(()=>{
    function handleKeyDown(e){
      if(e.code === 'Space'){
        //See: State setter callback functions:
        setIsPlaying((currentValue)=>{
          return !currentValue;
        });
      }
    }
    window.addEventListener('keydown', handleKeyDown);
    return () => {
      window.removeEventListener('keydown', handleKeyDown)
    }
  },[]);
    
    useEffect(()=>{
      if(isPlaying){
        audioRef.current.play();
      } else {
        audioRef.current.pause();
      }
    },[isPlaying]);
  
  return(
    <div className="wrapper">
      <div className="media-player">
        <img src="https://sandpack-bundler.vercel.app/img/take-it-easy.png" alt="Take it easy"/>
        <div className="summary">
          <h2>Take it Easy</h2>
          <p>Bvurnout ft. Mia Vaile</p>
        </div>
        <button
          onKeyDown={(e)=>{
            if(event.code === 'Space'){
              event.stopPropagation();
            }
          }}
          onClick={()=> {
            // Removed this code to manage the isPlaying state in a useEffect!
            // if (isPlaying) {
            //   audioRef.current.pause();
            // } else {
            //   audioRef.current.play();
            // }
            setIsPlaying(!isPlaying);
          }}
        >
          {isPlaying ? <Pause /> : <Play />}
          <VisuallyHidden>TogglePlaying</VisuallyHidden>
        </button>
        <audio 
          ref={audioRef}
          src={src}
          onEnded ={()=>{
            setIsPlaying(false);
          }}
        />
      </div>
    </div>
  );
}

export default MediaPlayer;
```

#### App.js

```jsx

import React from 'react';
import MediaPlayer from './MediaPlayer';

const DEMO_SONG_SRC = 'https://storage.googleapis.com/joshwcomeau/bvrnout-take-it-easy-short.mp3';

function App(){
  
  return(
    <>
      <MediaPlayer src={DEMO_SONG_SRC}></MediaPlayer>
    </>
  );
}

export default App;
```

### Event propagation

In MediaPlayer.js, we are adding a keydown event listener to the window object.
But when you press the spacebar key, you dont have the window object in focus.
The window event is the top level event. When you trigger an event on a DOM node, the event will "BUBBLE" up the tree.
SO when we press our button, it triggers on every element above it UNLESS we stop propagating it.
This way it doesnt call the handler event in the first useEffect.


### Strict mode

In strict mode, React will run the effect, immediately run the cleanup, then run the effect AGAIN.
This means that an effect that switches a boolean...will immediately switch it right back.

It's a development mode tool...effects run twice
