# FETCH
## on Event

Uses state variables for the form field
useID for unique html IDs
a handleSubmit function for the button
a status variable to update the UI after the user submits the form.

This is a good example of disabling inputs on submit.

Note: this catches expected errors. 

To catch unexpected errors, we'd wrap the handleSubmit function in a try/catch statement.

-----

```jsx

import React, {useState, useId} from 'react';

const ENDPOINT = ('/api/contact-form');

function ContactForm(){
    const [email, setEmail] = useState('');
    const [message, setMessage] = useState('');
    //We need idle, loading, success and error.
    const [status, setStatus] = useState('idle');
    
    const id = useId();
    const emailId = `${id}-email`;
    const messageId = `${id}-message`;
    
    async function handleSubmit(e) {
      //prevent the page from refreshing
      e.preventDefault();
      //change status right away to "loading":
      setStatus('loading');
      
      const response = await fetch(ENDPOINT, {
          method: 'POST',
        //Dont forget to stringify! You can only send strings, not objects or arrays.
          body: JSON.stringify({
            email, 
            message, 
          }),
        });
      
      const json = await response.json();
      console.log(json);
      
      if(json.ok) {
        setStatus('success');
        //If the message goes through, set the input back to an empty string.
        setMessage('');
      } else {
        //Here we set up an error status but dont do anything with it.
        //Just as a quick example, we'll use it near the bottom of the component.
        setStatus('error');
      }
    }
    
  return(
    <form action="">
      
      <div className="row address">
        <label htmlFor=""></label>
        <input 
          id={emailID}
          required={true}
          disabled={status === 'loading'}
          type="text"
          value={email}
          onChange={(e)=>{
            setEmail(e.target.value);
          }}
        />
      </div>
      
      <div className="row message">
        <label htmlFor=""></label>
        <input 
          id={messageId}
          required={true}
          disabled={status === 'loading'}
          type="text"
          value={message}
          onChange={(e)=>{
            setMessage(e.target.value);
          }}
        />
      </div>
      
      <div className="row button-row">
        <span className="button-spacer" />
        <button
          disabled={status === 'loading'}
          onSubmit={handleSubmit}
        >
          {status === 'loading' ? 'Submitting...' : 'SUBMIT'}
        </button>
      </div>
      {status === 'success' && <p>Message Sent!</p>}
      {status === 'error' && <p>Something went wrong.</p>}
    </form>
    
  );
}

export default ContactForm;
```