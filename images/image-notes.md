# Image Notes

Link: https://web.dev/learn/design/responsive-images

## Standard image code:

```css
img {
  max-inline-size: 100%;
  block-size: auto;
  aspect-ratio: 2/1;
  object-fit: cover;
}

/* Change the position:*/

object-position: top center;
```

## Proper sizing

Add width and height attributes. 

The browser will set aside that amount of space and load faster.

(Note: WordPress automatically lazy loads.)

```html
<img
 src="image.png"
 alt="A description of the image."
 width="300"
 height="200"
 loading="lazy"
>
```

You can add `fetchpriority="high"` and/or `rel="preload"`

to tell the browser to get the image right away.

## Using srcset

You can pass in a list of values separated by commas. Each value should be the URL of an image followed by a space followed by some metadata about the image. This metadata is called a descriptor.

In this example, the metadata describes the width of each image using the w unit. One w is one pixel.

```html 
<img
src="small-image.png"
alt="A description of the image."
width="300"
height="200"
loading="lazy"
decoding="async"
srcset="small-image.png 300w,
medium-image.png 600w,
large-image.png 1200w"
>
```

If you're using the width descriptor, you must also use the sizes attribute to give the browser more information. This tells the browser what size you expect the image to be displayed under different conditions. Those conditions are specified in a media query.

```html

<img
 src="small-image.png"
 alt="A description of the image."
 width="300"
 height="200"
 loading="lazy"
 decoding="async"
 srcset="small-image.png 300w,
  medium-image.png 600w,
  large-image.png 1200w"
 sizes="(min-width: 66em) 33vw,
  (min-width: 44em) 50vw,
  100vw"
>

```

## Pixel density descriptor

There's another situation where you might want to provide multiple versions of the same image.

Some devices have high-density displays. On a double-density display you can pack two pixels worth of information into the space of one pixel. This keeps images looking sharp on those kinds of displays.

(Note: Note: You can use either width descriptors or density descriptors, but not both together.)
```html

<img
 src="small-image.png"
 alt="A description of the image."
 width="300"
 height="200"
 loading="lazy"
 decoding="async"
 srcset="small-image.png 1x,
  medium-image.png 2x,
  large-image.png 3x"
>

```

# The picture element

You can specify multiple source elements inside a picture element, each one with its own srcset attribute. The browser then executes the first one that it can.

```html
<picture>
  <source srcset="image.avif" type="image/avif">
  <source srcset="image.webp" type="image/webp">
  <img src="image.jpg" alt="A description of the image." 
    width="300" height="200" loading="lazy" decoding="async">
</picture>
```

As well as switching between image formats, you can switch between image sizes. Use the media attribute to tell the browser how wide the image will be displayed. Put a media query inside the media attribute.

```html

<picture>
  <source srcset="large.png" media="(min-width: 75em)">
  <source srcset="medium.png" media="(min-width: 40em)">
  <img src="small.png" alt="A description of the image." 
    width="300" height="200" loading="lazy" decoding="async">
</picture>

```

This is different to using the srcset and sizes attributes on the img element. In that case you're providing suggestions to the browser. The source element is more like a command than a suggestion.

You can also use the pixel density descriptor inside the srcset attribute of a source element.

```html
<picture>
  <source srcset="large.png 1x" media="(min-width: 75em)">
  <source srcset="medium.png 1x, large.png 2x" media="(min-width: 40em)">
  <img src="small.png" alt="A description of the image." width="300" height="200" loading="lazy" decoding="async"
    srcset="small.png 1x, medium.png 2x, large.png 3x">
</picture>

```