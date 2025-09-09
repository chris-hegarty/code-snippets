# Rest and Spread

Note: these are technically not operators. Better to refer to each as a "syntax".

Both use the same syntax: `...`

But they do opposite things.

----------------------------------------

#### Rest - Gathers values.

#### Spread - Unpacks a set of gathered values.

----------------------------------------

## REST

Example: a function with a variable number of parameters.

```js
function addNums(...nums){
  //do stuff
}

```
"nums' is a single parameter that will gather ALL OTHER PARAMS into an array.

### Note: You can only have one rest parameter, and it has to come last.

## SPREAD

"Spread" - spreads an array of data into individual arguments.

Example: Here is a function with three parameters:

```js

function createDate(year, month, day) {
    return new Date(year, month, day);
}
//Here is an array to pass into createDate():

const dates = [2015, 2, 18];

//Now when you call createDate, you can use the spread sytax:

createDate(...dates)
```
### Use cases:

- Copy an array

```js
const myArray = [1,2,3,4,5];

const copyOfMyArray = [...myArray];
```

- Merge arrays:
```js

const firstArray = [1,2,3,4,5];
const secondArray = [6,7,8,9,10];

const combinedArray = [...firstArrray, ...secondArray]
```

- Works with objects too.
- Create a copy of an object:
```js
const originalObject = {
  latitude: 1.234,
  longitude: 4.321,
};

const clonedObj = { ...originalObject };

```

- Extend existing objects into new objects with new properties:
```js
const sharedCharacteristics = {
  species: 'human',
  location: 'earth',
};

const human1 = {
  ...sharedCharacteristics,
  name: 'Tina',
  eyeColor: 'green',
};

const human2 = {
  ...sharedCharacteristics,
  name: 'James',
  eyeColor: 'brown',
};
```
(Note: this works in PHP too!! And is more efficient than array_merge()).
https://www.tutorialspoint.com/php/php_spread_operator.htm

```php

<?php
   $arr1 = [4,5];
   $arr2 = [1,2,3, ...$arr1];

   print_r($arr2);
?>

<?php
   $arr1 = [1,2,3];
   $arr2 = [4,5,6];
   $arr3 = [...$arr1, ...$arr2];

   print_r($arr3);
?>


```