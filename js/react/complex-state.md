# Complex state

-------------------
Summary: 
1. Create a new array
2. Modify it as needed
3. SET the NEW array in state, not the original one.
-------------------------

Common pattern:
Make a new array within the onChange function:

```jsx
<input
    onChange = { (e) => {
        nextColors = [...colors];
        nextColors[index] = e.target.value;
        setColors(nextColors);
    }}
/>


```

While state can be set as a boolean, string or number, 
it can get more complex in React, like with an object or an array.

In this example, the state is using an array of strings:

```jsx

const [colors, setColors] = useState(['#000000','#ffffff', '#ffd200']);

```

### IMPORTANT CONCEPT:

You should never mutate an array or object held in state.

Meaning, if you call "setState", you need to provide a brand new array.

(Which is where spread operators come in handy. See "rest-and-spread-operators").

Also, make sure to understand assignment vs. mutation, particularly with arrays and objects.

(Arrays and objects are assigned to variables. The data in the object or array can be edited. This is mutation.)

```jsx

// Copy an array
const myArray = [1,2,3,4,5];

const copyOfMyArray = [...myArray];

// Merge arrays:
const firstArray = [1,2,3,4,5];
const secondArray = [6,7,8,9,10];

const combinedArray = [...firstArray, ...secondArray]

```
In a nutshell - if you use arrays or objects in state, you have to pass new ones when they change.
Otherwise, React won't re-render.

Note: In Javascript, you have objects in memory and variables that point to them.
More than one pointer (variable) can point to the object.

Spread syntax gives you a concise way to copy an existing array into a new one.

That way, in React, you get a NEW object on render.

Reference: Pointers for JavaScript developers
https://daveceddia.com/javascript-references/


 