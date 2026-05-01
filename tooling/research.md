# Notes around tooling

Why doesn't the .npmrc specify a Node version?

Should we build a prettier.rc...

stylelin.rc for sass

what does a "store" file do in a react app?

where is global.scss ending up compiling to?

AdminApi.ts

import IEmployeeSearchItem from '../../@interfaces/EmployeeSearch/IEmployeeSearch';

There is an env.json file that appears to manage running the API locally.

LanguageSettings.tsx

This line.... an "UpdateEmployeeConfiguration" component?

import { updateEmployeeConfiguration } from '../../../store/slices/userPreference';

*** translations.json - seems to have every hard coded string manually entered. ***

So, if someone needs/wants to update that text, is it necessary to go into that file and copy paste text that 
someone has already had translated? Where are these translations coming from and how do you update them?

PopperJS - This is worth looking into to compare what it does to what native CSS can do now...basically, what kind of 
CSS 
library is this under the hood? What classes do Bootstrap and Tailwind give us that can do this?

React joyride - for guided tours
Uses React Floater for "Flexible, customizable, and accessible tooltips, popovers, and guided hints for React."

"Maintenance Mode: This library is built on Popper.js v2, which is no longer actively maintained. For new projects, we recommend using Floating UI directly."

Searches for PopperJs end up at docs for V2 with a push to FloatingUI...which does anchor positioning? It does have 
User interactions for React. And uses Tailwind for styling.

So Bootstrap 5.3 has a dependency on PopperJs, now Floating UI, that uses Tailwind. 
In FloatingUI, here is where they are targeting pseudo selectors like ":popover-open" and ":modal" to get top layer 
functionality:

```js

export function isTopLayer(element: Element): boolean {
try {
if (element.matches(':popover-open')) {
return true;
}
} catch (_e) {
// no-op
}

try {
return element.matches(':modal');
} catch (_e) {
return false;
}
}

```

Here is where they are getting the computed style of an element:

```js

export function getComputedStyle(element: Element): CSSStyleDeclaration {
  return getWindow(element).getComputedStyle(element);
}

```

Need to revisit use of the nvmrc file.

What is a .storybook file?

A microsoft tool for extracting json files? https://developer.microsoft.com/json-schemas/api-extractor/v7/api-extractor.schema.json

What is "tabbable 6.0.0"

floating-ui/packages/utils/src/

From Bootstrap: If you’re using our compiled JavaScript and prefer to include Popper separately, add Popper before 
our JS, via a CDN preferably. (Which means if you -not- including it via CDN, do you have to update Popper or 
upgrade to FloatingUI on your own?) PopperJS Core has 16 million weekly downloads. The link to the repo now goes to 
Floating UI



