# Data Binding

Resource: Cheat sheet for various form inputs:
https://courses.joshwcomeau.com/joy-of-react/02-state/11-bonus-cheatsheet

This is particularly important when dealing with forms.

You need to set a default value. But there's some catches to look out for.

When you set that initial value, the input is bound and locked to it.

Then, you use the onChange event.

When event listeners fire, they call an event...

An Event is an object that describes what happened during the change.

That object will include the target of the event (which is typically the input).

```jsx
<input 
  type="text"
  id="search-input"
  value={searchTerm}
  onChange={(event) => {
    setSearchTerm(event.target.value)
  }}
/>
```

##  COMMON PITFALL:

When you are working with a form element

AND you are using the onSubmit() event...

You need to prevent the default behavior before calling the function...it's becasue, by default, the onSubmit event 
will refresh the entire page.

(More specifically, the browser will try to send the user to the URL specified by the action attribute.)

## Other form controls and other quirks

### textareas

these weirdos don't define their content as "values", they define them as children.

#### Example: Form with select options, using "Country" library:

```jsx

import React from 'react';

import { COUNTRIES } from './data';

const countryNames = Object.entries(COUNTRIES);

function App() {
  const [
    country,
    setCountry,
  ] = React.useState('');

  return (
    <form>
      <fieldset>
        <legend>Shipping Info</legend>
        <label htmlFor="country">
          Country:
        </label>
        <select
          required
          id="country"
          name="country"
          value={country}
          onChange={event => {
            setCountry(event.target.value)
          }}
        >
          <option value="">— Select Country —</option>
          <optgroup label="Countries">
            {countryNames.map(([id, label]) => {
              return (
                <option value={id} key={id}>
                  {label}
                </option>
              );
            })}
          </optgroup>
        </select>
      </fieldset>

      <p className="country-display">
        Selected country: {COUNTRIES[country]}
      </p>

      <button>Submit</button>
    </form>
  );
}

export default App;

```

if correct code !=== CORRECT_CODE

window.alert("The auth code is not correct.")

else

window.alert("Authorized)



