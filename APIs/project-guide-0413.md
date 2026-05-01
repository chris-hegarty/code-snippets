# API Project Guide

Four areas to get familiar with:

## Admin Data

Go to Users → All Users in wp-admin. Click Edit on your chris.hegarty@kiewit.com employee account. Scroll to the bottom — you'll see three ACF field groups: Base Location, Country, and District. These are the three fields the entire project revolves around. Note what terms are currently selected.

Go to Posts → Country (or find the three taxonomy terms in the left menu — they may be under a custom menu item). Browse the terms that exist in country, baselocation, and district. These are the WordPress taxonomy term IDs that all the ACF fields store. Getting familiar with them now will make the code much more concrete later.

Look at the URL when you're on a term edit page: wp-admin/term.php?taxonomy=country&tag_ID=123. That tag_ID number is the term ID you'll be storing and querying everywhere.

------------------------------------

## REST API in the browser

ch-dev
ID = 39740
API Project
jRYd FQWY Ebac cE7B 6NqB jgH7

Omaha
USA
Kiewit Technology Group Shared Services

Country Tags/Terms
USA = 524
Canada = 525
Mexico = 526
All Company = 539

chris.hegarty@kiewit.com 
ID = 29525

---------------------------------------

## array_map()

applies a callback function to each array element and returns a new array.

Use `array_map` when you want to transform every element and get a new array back.

Use `foreach` when you need side effects.

### `foreach()` loop:

```php

$taglist = ['php', 'laravel','api'];
$result = [];
foreach($taglist as $tag){
    $result[] = strtoupper($tag);
}

```

### with `array_map()`

```php

$taglist = ['php', 'laravel','api'];
$result = [];

function uppercaseTag($tag){
    return strtoupper($tag);
}

$result = array_map('uppercaseTag', $taglist);

// you can pass in multiple arrays:

$names = ['Chris','Steve','Michael'];
$ages = ['100', '101','102'];
$result = [];

//Traditional array syntax

$result = array_map(function($name, $age){
    return "$name is $age";
}, $names, $ages);

// Arrow function

$result = array_map(fn($name, $age) => "$name is $age", $names, $ages);

// Named function passed as string

function describePerson($name, $age){
    return "$name is $age";
}

result = array_map('describePerson', $names, $ages);

```


