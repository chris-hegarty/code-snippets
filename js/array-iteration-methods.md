# Array iterations methods

React relies on built-in JavaScript methods to iterate over arrays.

## forEach

Accepts a function as its argument.
```js
const pizzaToppings = ['pepperoni', 'sausage', 'onions', 'peppers'];

pizzaToppings.forEach( (topping) => {
  console.log(topping);
});

```

forEach accepts a 2nd param to access the index of the array items:

```js

pizzaToppings.forEach((topping, index) => {
  console.log(index, topping);
});

```

## filter

Accepts a function as its argument. 
The function should return a boolean value. 
If the function returns true, the item will be included in the new array.

"filter" produces a value.
It produces a NEW ARRAY with the items that pass the test.
Example:

```js

const students = [
  { name: 'Aisha', grade: 89 },
  { name: 'Bruno', grade: 55 },
  { name: 'Carlos', grade: 68 },
  { name: 'Dacian', grade: 71 },
  { name: 'Esther', grade: 40 },
];

// Now let's "filter" the students who passed the test with a grade higher than 60:

const passingStudents = students.filter(student => {
  return student.grade >= 60;
});

console.log(passingStudents);

//will output:

/*
  [
    { name: 'Aisha', grade: 89 },
    { name: 'Carlos', grade: 68 },
    { name: 'Dacian', grade: 71 },
  ]
*/

```

Another example: filtering for even numbers.

```js
const nums = [5, 12, 15, 31, 40];

const evenNumbers = nums.filter((num) => {
  return num % 2 === 0;
});

console.log(evenNumbers); // [12, 40]
```

## map

"map" will produce a brand new array with transformed values.
It will "collect" the values in the original array, transform them, and put them in a new array.

```js

const nums = [1, 2, 3];

const incrementNums = nums.map((num) => {
  return num + 1;
});

//Or, write it one line:

const incrementNums = nums.map(num => num + 1);

```

### Accessing the index:

```js

const people = [
  { name: 'Aisha', grade: 89 },
  { name: 'Bruno', grade: 55 },
  { name: 'Carlos', grade: 68 },
  { name: 'Dacian', grade: 71 },
  { name: 'Esther', grade: 40 },
];

const numberedNames = people.map((person, index) => {
  return `${index}-${person.name}`;
});

console.log(numberedNames);
/*
  ['0-Aisha', '1-Bruno', '2-Carlos', '3-Dacian', '4-Esther']
*/


```

Another method to look into: "reduce".
It will combine all the items of an array into a single value.
https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array

## "for" loop:

```javascript

const students = [
  { name: 'Aisha', grade: 89 },
  { name: 'Bruno', grade: 55 },
  { name: 'Carlos', grade: 68 },
  { name: 'Dacian', grade: 71 },
  { name: 'Esther', grade: 40 },
];

const passedStudentNames = [];

for (let i = 0; i < students.length; i++) {
  const student = students[i];

  if (student.grade >= 60) {
    passedStudentNames.push(student.name);
  }
}

```

Note: arrow functions work differently in JSX.

They use shorthand syntax for implicit returns.

Brackets are explicit returns, that use the 
"return" keyword.

They will sometimes use parens instead of curly braces.

(It is common syntax for returning JSX elements directly.)

You don't need the "return" keyword with parens.



```jsx
function NavigationLinks({ links }) {
  return (
    <ul>
      {links.map(item => (
        <li key={item.id}>
          <a href={item.href}>
            {item.text}
          </a>
        </li>
      ))}
    </ul>
  );
}

```
