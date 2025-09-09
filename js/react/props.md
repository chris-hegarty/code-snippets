# Props

React components have "props", which are like arguments to a function.

Props allow us to pass data to components.

You can pass data from one component to another in React

by defining custom HTML attributes to which you assign your data with JSX's syntax.

Example: className, src, alt, width, and height are some of the props you can pass to an <img>:

```jsx

function Avatar() {
  return (
    <img
      className="avatar"
      src="https://i.imgur.com/1bX5QH6.jpg"
      alt="Lin Lanying"
      width={100}
      height={100}
    />
  );
}

export default function Profile() {
  return (
    <Avatar />
  );
}

```

## You write them like this:

```jsx
const Welcome = (props) => {
  return(
    <h1>{props.text}</h1>
  );
}
```

### (OR...you destructure the props object):

```jsx

const Welcome = ({ text }) => {}
  return(
     <h1>{text}</h1>
  )

```

## Then deploy them like this:

```jsx

const App = () => {
  const greeting = "Welcome to React";
  
  return(
    <div>
      <Welcome text={greeting} />
    </div>
  )
}

```


It is an object...

And it often gets destructured.

So instead of seeing this:

```js
function friendlyGreeting(props){}
```

It is a common pattern to see the props destructured like this:

```js

function friendlyGreeting({name, age, etc}){
    
}

```

And then when you use the prop, you don't have to write "props.name" 
you can just write "name"

## Children prop

You can write components with self-closing tags and with regular closing tags, like
```javascript
<RedButton contents="Learn More" />
//or
<Button>Learn More</Button>
```
### If you use a closing tag, you can access the "children" prop.

The children prop contains the content between the opening and closing tags of a component.

Under the hood, React is doing this:
```javascript
const element = (
  <div>
    Hello World
  </div>
);
```
Now, console log element and this is what you'll see:

```{
  "type": "div",
  "key": null,
  "ref": null,
  "props": {
    "children": "Hello World"
  },
  "_owner": null,
  "_store": {}
}
```

In this code, Profile does not pass any props to its child component, Avatar"

```jsx
export default function Profile() {
  return (
    <Avatar />
  );
}

```
Here is how to add them.

1) Pass props to the child component:
```jsx

export default function Profile(){
  return(
    <Avatar 
      person={{
        name: 'Chris',
        title: 'Dev',
      }}
      size={40}
    />
  );
}
```

Then, read the props inside the child component:

```jsx
function Avatar({ person, size }){
  //person and size available here.
}

```

Now you can render Avatar in different ways with different props:

```jsx
function Avatar({ person, size }){
  return(
    <img 
      src="" 
      alt="{person.name}"
      width={size}
      height={size}
    />
  );
}

function Profile(){
  return(
    <div>
      <Avatar 
        size={100}
        person={{
          name: "Another Name",
          size: 60,
        }}
      />
    </div>
  );
}

```

Sometime, passing props gets repetitive, or there's just a ton of them:

```jsx
function Profile({ person, size, isSepia, thickBorder }) {
  return (
    <div className="card">
      <Avatar
        person={person}
        size={size}
        isSepia={isSepia}
        thickBorder={thickBorder}
      />
    </div>
  );
}
```

You can use the spread syntax to make things more concise:

```jsx
function Profile(props){
  return(
    <div className="card">
      <Avatar
        {...props}
      />
    </div>
  );
}
```