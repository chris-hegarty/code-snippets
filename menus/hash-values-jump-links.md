# Working with hash values

It's important to know the difference between a hash value and the href attribute.

```js
$(this).attr("href")
```
This is a jQuery method.
It retrieves the value of the href attribute of the current element.
Example: If the element is <a href="https://example.com">Link</a>, $(this).attr("href") would return "https://example.com".

----------

```js
this.hash
```
This is a plain JavaScript property.
It retrieves the fragment identifier (the part of the URL after the #) of the current element’s URL.
Example: If the URL is https://example.com/page#section1, this.hash would return "#section1".

```js
$(this).hash
```

!!! This is not a valid jQuery method or property! !!!

jQuery objects do not have a hash property.

Here is how to set up and use a hash within jQuery:

```javascript

$(document).ready(function() {
    $("a").click(function(event) {
        // Prevent the default action of the link
        event.preventDefault();

        // Get the hash value of the clicked link
        // Note: This is vanilla JS b/c there is no .hash method in jQuery.
        var hashValue = this.hash;

        // Do something with the hash value
        console.log("Hash value:", hashValue);

        // Optionally, you can use jQuery to scroll to the section with the hash
        $('html, body').animate({
            scrollTop: $(hashValue).offset().top
        }, 800);
    });
});

```

