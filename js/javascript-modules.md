# JavaScript Modules

When we work with a JS module system, every file becomes a "module". 

### -Scope
This means that every file has its own scope, and the variables and functions defined in it are not visible outside of it.

### -Exports
A "module" is a JS file that can contain one or more "exports".

(To make a variable or function available outside of a module, we need to explicitly export it.)

If we don't export a piece of data, it won't be available outside the module 

### -"import" keyword
We can pull code from one module into another by using the `import` keyword.

## Named Exports
 Say we have two piece of data being exported from a file called "data.js"

```js

export const bigNumber = 100000;
export function doubleNum(num){
    return num * 2;
}

```

Then, in another file, we can import them like:

```js
import {bigNumber, doubleNum} from './data.js';
//Note: you can omit the .js extension.
```

Say you have exported two functions from different files with the same name.
You can rename them on Import with the "as" keyword, like:

```js

import { Wrapper as HeaderWrapper } from './Header';
import { Wrapper as FooterWrapper } from './Footer';

```

## Default Exports

### ***Every module can have multiple named exports,but only a single default export.***

Default exports always export EXPRESSIONS.

JS modules can only have ONE default export.

```js
const hi = 5;
export default hi;
```

Then, when you import them, you DO NOT USE CURLY BRACES.

```js
import hi from './data';
```

_**(A good rule of thumb: if a file has one obvious "main" thing, make it the default export.)**_

Example:

```js

// components/Header.js
export const HEADER_HEIGHT = '5rem';

function Header() {
  return (
    <header style={{ height: HEADER_HEIGHT }}>
      {/* Stuff here */}
    </header>
  )
}

export default Header;

```