# Background shorthand syntax

Link: https://css-tricks.com/almanac/properties/b/background/

## Recommended order

* background-image
* background-position
* background-size
* background-repeat
* background-attachment
* background-origin
* background-clip
* background-color

**Anything you don’t specify in the background property is automatically set to its default. So if you do something 
like this:**

```css
body {
  background-color: red;
  background: url(sweettexture.jpg);
}
```

The background will be transparent, instead of red. 

The fix is easy though: 

* just define background-color after background, 
* or just use the shorthand (e.g. background: url(...) red;)
* 
Example:

```css

background-size: cover !important;
background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 50%, rgba(0,0,0,0.65) 100%), url(qijin-xu.png) no-repeat center center scroll;


```

