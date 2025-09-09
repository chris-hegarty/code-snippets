# Animations with jQuery

```javascript

$(selector).animate({params},speed,callback);

```

The selector is the jQuery selector to find HTML elements.

The params is a JSON object defining the CSS properties to animate.

The speed is an optional parameter to specify the duration of the effect. It can take a value in milliseconds or predefined strings like 'slow' or 'fast'.

The callback is an optional function to run once the animation completes.

Example:

```php
.animate({opacity: 0.5}, 300);
```