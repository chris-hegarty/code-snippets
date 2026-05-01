# String interpolation

### Old way:

```js
const userName = "Christopher";
const dynamicString = 'Hello ' + userName + '!';
```

### Newer better way:
Use dollar sign double bracket syntax like ${}.

Note: You must use backticks, not single or double quotes.

Anything within the brackets will be evaluated as an expression.

```js
const dynamicString = `Hello ${userName}!`;
```
