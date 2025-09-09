### An expression produces a value.
(A statement does not produce a value.)

If you can console.log something, it is an expression.
Expressions:

1 → produces 1
"hello" → produces "hello"
5 * 10 → produces 50

This ternary is an expression:
```js
isHappy ? "🙂" : "🙁"
```
Expressions can contain expressions.
## ALL FUNCTION ARGUMENTS MUST BE EXPRESSIONS.

### In React, curly braces are used to insert expressions into JSX.
```js

```


### A statement performs an action. 
It's an instruction.
Examples:
-create a variable
-run an if/else condition
-start a loop.

```js
let hi = 5; //statement
```

### Statements often have "slots" for expressions.

```js
let hi = /* some expression */;
```

### Statements typically end in a semicolon, expressions do not.

However, the semicolon isn't necessary for certain statements, 
like if statements, while loops, and function declarations.

### All function arguments must be expressions. 

Expressions produce a value, and that value will be passed into the function. 
Statements don't produce a value, and so they can't be used as function arguments.

###  Expressions can't exist on their own. They're always part of a statement.

Some statement examples:

```js
// Statement 1: Create a variable
let hi = /* expression slot */;

// Statement 2: Return a value in a function
return /* expression slot */;

// Statement 3: Loop until the provided expression is falsy
while (/* expression slot */) { }

// Statement 4: Execute the provided expression
/* expression slot */;
```

### Expressions produce a value. 

We can log them, assign them to variables, or pass them to functions. 
We can pop expressions in whenever we see an expression slot.

### Statements are instructions to do a particular thing, like declaring a variable or running a loop. 

We can only 
place statements in very specific places.