# Component Syntax

* ## Components return one or more React elements.

* ## Components are created and defined as functions.

They MUST started with a capital letter.

THEY ARE JAVASCRIPT FUNCTIONS.

They are  invoked on every re-render.

They are rendered -kind of- like HTML tags.

----------

What is the difference between 
```js
<Component />
```
and 
```js
<Component>
  
</Component>
```
----------
From eslint:

## Always self-close tags that have no children. 

eslint: react/self-closing-comp

// bad
```jsx 
<Foo variant="stuff"></Foo>
```
// good
```jsx
<Foo variant="stuff" />
```
### If your component has multiline properties, close its tag on a new line.

// bad
```jsx
<Foo
bar="bar"
baz="baz" />
```

// good
```jsx
<Foo
bar="bar"
baz="baz"
/>
  ```

```js
//Instead of tags like <div> or <p>, we use the component name:
<Greeting>
```



You can use arrow or standard syntax.

Here is an arrow syntax example:

```js
const Greeting = () => {
  
}
```

(Remember: with NO parameters, parens are mandatory in arrow functions.)

## Children

One of the props passed is "Children"

TODO: Need to review these. Two different forms of children?

Note: if you need a white space, use quotes and curly brackets:

```jsx
<div>
  <strong>Days until Santa returns:</strong>
  {' '}
  {daysUntilSantaReturns}
</div>
```

