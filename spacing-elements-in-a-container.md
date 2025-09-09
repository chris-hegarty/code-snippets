# Cool snippet for vertically spacing elements in a container.


```css
main > * + * {
margin-top: calc(var(--spacer) / 2);
}
```
## Explanation:

Selector: main > * + *

main: This targets the "main" element. Could also be a class or id selector.

`> *`  This targets all direct child elements of the main element.

` + * `  This targets any element that is immediately preceded by another element within the "main" container.
  
Property: `margin-top` - This sets the top margin of the targeted elements.

Value: calc(var(--spacer) / 2)

`calc()` : This function allows you to perform calculations to determine CSS property values.

`var(--spacer)` : This references a custom property (CSS variable) named --spacer.

`/ 2` : This divides the value of --spacer by 2.

## What it does:

This CSS rule applies a top margin to every direct child element of .card that is immediately preceded by another sibling element. The margin value is half of the value defined in the --spacer custom property.

## Use Cases:

* ### Consistent Spacing: 

  This rule is useful for maintaining consistent vertical spacing between sibling elements 
  within a container. For example, in a card layout where you want uniform spacing between different sections or items.

* ### Dynamic Layouts: 

  By using CSS variables and the calc() function, you can easily adjust the spacing by changing 
  the value of --spacer without modifying the CSS rule itself.

* ### Responsive Design: 
  This approach can be particularly helpful in responsive design, where spacing might need to be 
  adjusted based on different screen sizes or design requirements.

## Possible use case with background colors to try:

This also uses negative margins.

```html

<main class="main-container">
  <section class="section-header">Header</section>
  <section class="section-image">Image</section>
  <section class="section-description">Description</section>
  <section class="section-footer">Footer</section>
</main>

```

```css

.main-container {
  --spacer: 20px; /* Define the custom property for spacing */
}

.main-container > * + * {
  margin-top: calc(var(--spacer) / 2);
  padding-top: calc(var(--spacer) / 2);
}

.section-header {
  background-color: lightblue; /* Example background color */
}

.section-image {
  background-color: lightgreen; /* Example background color */
}

.section-description {
  background-color: lightcoral; /* Example background color */
}

.section-footer {
  background-color: lightgoldenrodyellow; /* Example background color */
}

```

### Explanation

#### Negative Margin and Padding: 

By using both margin-top and padding-top with the same value, you ensure that the sections are visually connected without any gaps. The margin-top creates the spacing, while the padding-top ensures that the background color extends into the margin area, eliminating any white space.

#### Background Colors: 

You can apply different background colors to each section as needed. The combination of negative margins and padding will ensure that the sections appear seamless, even with different background colors.
