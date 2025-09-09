# PHP ternary operator

The ternary operator is an expression.

It doesn't evaluate to a variable, but to the result of an expression.

## with `isset()`

```php

 echo isset($value) ? $value : '';
// with null coalescing operator:
echo $value ?? '';

```

```php

// Example usage for: Ternary Operator
$action = (empty($_POST['action'])) ? 'default' : $_POST['action'];

// The above is identical to this if/else statement
if (empty($_POST['action'])) {
    $action = 'default';
} else {
    $action = $_POST['action'];
}
?>


```

## Multiple ternaries

```php
?>
 <section class="section projects<?php echo (is_front_page() ? ' projects--home' : ''); echo ('projects' === get_post_type() ? ' projects--related' : ''); ?>">


```

More info: https://stackoverflow.com/questions/4261133/notice-undefined-variable-notice-undefined-index-warning-undefined-arr?rq=1

