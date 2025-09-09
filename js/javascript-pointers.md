# JavaScript pointers, references, variables

Create a variable called "word" that stores the string "hello":

```javascript
let word = "hello";
```
The variable is -not- the string. It points to a "box" containing the string.

Then if you do 

```js
word = "world"
```

...you are creating a new box.

## Primitive types are immutable

With primitive types (string, number, boolean)
you can't modify their values.
You can only re assign to new variables. (Create new boxes for them.)

(This is why with JS string methods, they return new strings, they dont modify the existing one. )

Example: this code will still console.log "Chris" in upper case.
```js
let name = "Chris"
name.toLowerCase();
console.log(name)
```

To get the lower case value, you have to store it first.
```js
name = name.toLowerCase();
console.log(name);
```

Variables always point to boxes, never to other variables. 

When we assign backup = book, JS immediately does the work to look up what book points to, and points backup TO THE 
SAME THING. 
It doesn’t point "backup" to book.

## "Object" types are mutable.
(You -can- change the value in the box.)

Object types:
* arrays
* functions
* objects
* other data structures





