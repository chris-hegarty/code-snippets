# async and await

Step 1: Declare the function as "async":

```js
async function doSomethingAsynchronously() {};

//or with an arrow function:

const doSomethingAsynchronously = async () => {};

```

Then, within the function, "await" can "pause" the function execution until the async op is complteted.

```js

async function doMultipleThings() {
  await doFirstThing();
  await doSecondThing();
  return "done!"
}

```

The await expression also produces a value, and we can assign that value to a variable:

```js

async function doMath() {
  const result = await add(1, 2);
}

```