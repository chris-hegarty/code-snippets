# Parent and Child components

(And passing props through them.)

Take the following code where you are exporting a component (Profile) with a child component (Avatar):

```jsx
function Avatar() {
  return (
    <img
      className="avatar"
      src="source.com"
      alt="an alt tag"
      width={100}
      height={100}
    />
  );
}

export default function Profile(){
  return(
    <Avatar />
  )
}
```

The Profile component isnt passing any props to its child component "Avatar"

You can pass props to Avatar:

```jsx
export default function Profile(){
  return(
    <Avatar 
    person={{name:'Chris',imageID:'1bxdr43o9'}}
    size={100}
    />
  );
}
```

Now you can read these inside the Avatar component:

```jsx
function Avatar({person, size}){
  //person and size are available here,
}

```

NOTE: Components can render other components.

Example from the React docs:
A "Gallery" component rendering three "Profile" components.
This is how it would look in one file.

(But is better to put the Profile code in its own file, then import it.)

```jsx

function Profile(){
  return(
    <img 
    src="source.com"
      alt="Some alt text"
    />
  );
}

export default function Gallery(){
  return(
    <section>
      <h1>Here is a section</h1>
      <Profile />
      <Profile />
      <Profile />
    </section>
  );
}


```