# Object Destructuring

Object destructuring is a way to extract multiple properties from an object and assign them to variables.

```js
//The object:
const user = {
  name: 'François Bouchard',
  city: 'Saint-Louis-du-Ha! Ha!',
  province: 'Québec',
  country: 'Canada',
  postalCode: 'A1B 2C3',
};

//The old way:

const name = user.name;
const country = user.country;

//With destructuring.

const { name, country} = user;

console.log(name); // François Bouchard
```

## Destructuring function parameters:

```js

function validateUser(user) {
  const { name, password } = user;

  if (typeof name !== 'string') {
    return false;
  }

  if (password.length < 12) {
    return false;
  }

  return true;
}

```

## YOU CAN DO THIS RIGHT INT HE FUNCTION PARAMS.
***This is popular in React to destructure props in components***

```js


function validateUser({ name, password }) {
  if (typeof name !== 'string') {
    return false;
  }

  if (password.length < 12) {
    return false;
  }

  return true;
}

```