# Application Structure

It's common for a React app to have a core <App /> component that is an ancestor to every other component.

Some typical files:

### index.js

Usually contains the root component like <App />.

It's common to do "setup" tasks in this file as well. 

For example, this file is a good place to import global CSS files, or set up any error-logging services.

THis is also where you would put "provider" files


### App.js

The "home base" React component.

THis will sometimes manage core layout stuff like headers and footers.

Top level routes are often set/defined in here.

# Fragments

You can't output more than one element in a componnet without wrapping them in either a div or a fragment.

For exmaple, this will return an error:

```jsx

return (
  <div>
    <h1>Welcome to my homepage!</h1>
    <p>Don't forget to sign the guestbook!</p>
  </div>
);
```

Fragments are components that dont output a DOM node.

syntax:

```jsx
<>
  <h1>Welcome to my homepage!</h1>
  <p>Don't forget to sign the guestbook!</p>
</>
```