```css

/**
 * FLOW
 *
 * A tiny utility that helps with rhythm by adding margin to siblings
 *
 * --flow-space: The amount of space between siblings: Default 1em;
 */
.flow {
    --flow-space: 1em;
}

.flow > * + * {
    margin-top: 1em;
    margin-top: var(--flow-space);
}


```

Notes:

From GPT4o:

The error occurs because the custom property `--flow-space` is defined within the `.flow` class, making it a **scoped custom property**. It is only available to elements within the `.flow` class or its descendants.

If the CSS rule at line 15 (`margin-top: var(--flow-space);`) is applied to elements outside the `.flow` class, the custom property will not resolve, resulting in the error.

To fix this, ensure that the elements using `var(--flow-space)` are descendants of `.flow`. Alternatively, define `--flow-space` globally (e.g., in the `:root` selector) if it needs to be accessible everywhere.

From Claude 3.7

The custom property --flow-space is actually defined correctly in your code and should not produce an error. The error message "Cannot resolve '--flow-space' custom property" is likely a false positive from your IDE.

Looking at your code:


You define --flow-space: 1em; within the .flow class
You then use it in .flow > * + * with margin-top: var(--flow-space);
This is valid CSS because:


The custom property is scoped to the .flow class
You're only using it within elements that are descendants of .flow (specifically direct children that follow another child)
The duplicate margin-top property at line 15 is unnecessary though - browsers will ignore the first declaration and use the second one with the custom property. You could remove the first margin-top: 1em; line.

Your IDE might be showing this error because some CSS linters and tools don't always correctly track the scope of custom properties, especially when they're used in complex selectors.