# WP Meta query notes

From the codex:

The meta query clauses can be nested in order to construct complex queries.

The 'meta_query' clauses can be nested in order to construct complex queries.

For example, show products

-where color=orange OR
-color=red&size=small

```php
$args = array(
    'post_type' => 'product',
    'meta_query' => array(
        'relation' => 'OR',
        //Begin 1st meta_query
        array(
        'key' => 'color',
        'value' => 'orange',
        'compare' => '=',
        ),
        //Begin 2nd meta_query
        //It has two parts, so set the relation
        array(
        'relation' => 'AND',
            array(
            'key' => 'color',
            'value' => 'red',
            'compare' => '=',
            ),
            array(
            'key' => 'size',
            'value' => 'small',
            'compare' => '=',
            ),
        ),
    ),
);
$query = new WP_Query( $args );
```
