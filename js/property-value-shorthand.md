# Property Value Shorthand

Property value shorthand is a way to specify multiple values for a single property in a single line of code. 

This is useful for reducing the amount of code you need to write and making your code more readable.

Take this code:

```js

const name = 'Chris';
const age = 10000;

const user = {
  name: name,
  age: age,
};

console.log(user);
// { name: 'Chris', age: 10000 }
```

## We can shorten this to just write "name" and "age" once:

```js

const name = "Chris";
const age = 10000;

const user = {
  name, 
  age,
};
console.log(user);
// { name: 'Chris', age: 10000 }
```