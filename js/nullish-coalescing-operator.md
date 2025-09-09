# Nullish Coalescing Operator

There are two "nullish" values:

## null
## undefined

Very similar to the OR operator.

It evaluates to the first "not-nullish" value.

It means we dont have to worry about surprising "falsy" values like 0.

Here is an example of a gotcha.

The following code says that if there is at least one item in the array, then render a shopping list:

```js

{items.length && <ShoppingList items={items} />}

```

The problem is that if items is an empty array, then the length is 0, which is falsy, so the ShoppingList will not be rendered.

You can either check for a boolean value like this:

```js

{items.length > 0 && <ShoppingList items={items} />}
```

this way, items.length > 0 will always evaluate either to true or false.
