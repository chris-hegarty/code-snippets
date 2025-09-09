# Array Destructuring

Array destructuring is a way to unpack values from an array or object into distinct variables. 

It's a convenient way to extract multiple values from an array or object and assign them to variables.

Traditional way:

```js

const fruits = ['strawberry','cherry','banana'];

//assign values with indexes and assignment statements:

const fruitOne = fruits[0];
const fruitTwo = fruits[1];

```

This will feel backwards, but with array destructuring

-The array goes on the right
-The variables go on the left.

```js

const fruits = ['strawberry','cherry','banana'];

const [fruitOne, fruitTwo] = fruits;

```

## when the [ ] characters are used AFTER the assignment operator (=), 
## they're used to package items into an array. 

## When they're used before, they do the opposite:
## they UNPACK items from an array: