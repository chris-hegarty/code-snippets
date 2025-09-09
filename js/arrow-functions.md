# Arrow functions

Arrow functions are a more concise way to write functions in JavaScript. They are written using the `=>` syntax.

This is the syntax for a regular function:
```javascript
function exclaim(string){
  return string + '!';
}
```

This syntax is the same thing in one line:

```js
const exclaim = string => string + '!';
```

Arrow functions can improve readability with anonymous functions.

```js
const arr = ['hey','hello','hi'];

//Regular function:

arr.map(function(string){
  return string + '!';
})
  .join(' ');

//Becomes this with arrow functions:

arr.map(string => string + '!').join(' ');

```

Examples from MDN:

```js
// Traditional anonymous function
(function (a) {
  return a + 100;
});

// 1. Remove the word "function" and place arrow between the argument and opening body brace
(a) => {
  return a + 100;
};

// 2. Remove the body braces and word "return" — the return is implied.
(a) => a + 100;

// 3. Remove the parameter parentheses
a => a + 100;
```

The parentheses can only be omitted if the function has a single simple parameter. 

If it has multiple parameters, no parameters, or default, destructured, or rest parameters, the parentheses around 
the parameter list are required:

```js
// Traditional anonymous function
(function (a, b) {
  return a + b + 100;
});

// Arrow function
(a, b) => a + b + 100;

const a = 4;
const b = 2;

// Traditional anonymous function (no parameters)
(function () {
  return a + b + 100;
});

// Arrow function (no parameters)
() => a + b + 100;
```

### Short form vs long form arrow functions

Short-form:
The short form function body must be a single expression. 
The return value is the result of that expression.
It is an "implicit" return, because we dont use the 'Return' keyword.

```js
const add1 = n => n + 1;
```
Long-form adds curly braces around the function body, and uses the "return" keyword.

```js
const add1 = n => {
  return n + 1;
}
```
### Parens vs brackets

Parens can help with formatting short-form arrow functions.

These two functions are the same:

1.
```js
const withoutParens = sentence => sentence.toUpperCase();
```

2.
```js
const withParens = sentence => (
  sentence.toUpperCase()
);
```

## If an arrow function takes a SINGLE param, parens are optional.
## With MORE THAN ONE param, they are required.

Both of these are valid:
```js
//no parens:
const logUser = user => {
  console.log(user);
}

// with parens:
const logUser = (user) => {
  console.log(user);
}
```

## With NO params, they are mandatory:

```js

const sayHello = () => console.log("Hello");
```

-------------------
Implicit returns

```js
// Single-line
const sayHi = (name) => name

// Multi-line
const sayHi = (name) => (
name
)
```
Rest parameters, default parameters, and destructuring within params are supported, and always require parentheses:

```js
(a, b, ...r) => expression
(a = 400, b = 20, c) => expression
([a, b] = [10, 20]) => expression
({ a, b } = { a: 10, b: 20 }) => expression
```


