# PHP Concatenation Examples

Single quotes indicate you are leaving PHP. 

To get back in and out of PHP, use a period/dot

```php
return '<div class="height-shortcode" style="height:'.$myHeight.'">'.$content.'</div>';
```

Using ternaries to output conditional classes:

Start with the echo statement, THEN begin the ternary with the variable you want to check:

```php

<div class="<?php echo $content ?  'col-lg-8 col-md-6 col-12' : 'col-12' ?>">
<?php echo $proportions === 'fifty' ? 'col-lg-6' : 'col-lg-4' ?> p-0">


```


