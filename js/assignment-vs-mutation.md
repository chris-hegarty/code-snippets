# Assignment vs Mutation

There's a mental model to keep in mind.

Take this array:

```js
const cats = ['zoe','firecracker','wrigley','leo']
```
It's tempting to think you are creating a variable called cats, then filling out the array.

**It's more accurate to say the array gets created FIRST.**

**Then, we point the "cats" label at it.**

## LET

When we use "let" to create a variable,
we are able to change which "thing" the label points to.

### This is known as "reassignment".

```js
//Start with a labeled array:

let dogs = ['Anthony','Zap','Clancy','Ben'];

// You can point the "dogs" label to a different value:

dogs = ['Rusty','Buddy','Maggie','Daisy'];

```
In the example above, we aren't modifying the data, we're MODIFYING THE LABEL.

Which brings us to "const".

## CONST

Variables created with "const" are not allowed to be reassigned.
Think of it as an  "indestructible link between a variable name and a piece of data."

We can, however, modify the data itself.

For example, we can add and remove items from the array.

### This is know as "mutation".

It's the same concept with objects...we can add and remove properties...as long as the label keeps pointing to the 
same object.

### When we create a constant with const, we can be 100% sure that the variable will never be re-assigned.
### But no promises are made when it comes to mutation. 
### "const" doesn't block mutation at all.
