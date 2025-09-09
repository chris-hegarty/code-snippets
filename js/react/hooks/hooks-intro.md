# Hooks

Hooks allow you to reuse logic just like a component.

You want to try to write your components in a way that makes them re-useable, even if you aren't sure you'll use 
them again.

That can be tricky though...what if you have 
-a user/pass login component
-with a unique id
-but you want to put more than one of that component on a page?

There is a relatively recent addition to React that helps with this.

```javascript
const id = React.useId();
```

Hooks are Javascript functions that allow us to access ("hook into") React internals.
THey expect to be used in specific ways.

## Rules of Hooks

Some important rules and conventions:

* Hooks have to be called within the scope of a React application. (You cannot call a hook outside of a React component.)
* Hooks have to be called at the TOP LEVEL of a component.
* The order matters. The way React knows which hook is which is by the order they are being called when the 
  component renders. 
* You can't use them conditionally. (Like in an if statement or ternary)

