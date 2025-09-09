# Sorting examples with PHP 

Examples from McNally

`taxonomy-specialties.php`

and brand Projects

### Notes

### `add_query_arg()`
https://developer.wordpress.org/reference/functions/add_query_arg/

You can rebuild the URL and append query variables to the URL query by using this function.
There are two ways to use this function; either a single key and value, or an associative array.
(NOTE: return value is NOT escaped by default.)

1. Using a single key and value:

```php
add_query_arg( 'key', 'value', 'http://example.com' );
```
Example:
```php
<?php ?>
a href="<?php echo esc_url( add_query_arg('sort', 'CompletionDate DESC')) ?>">Date</a>
```


2. Use an associative array

```php
add_query_arg( array(
    'key1' => 'value1',
    'key2' => 'value2',
), 'http://example.com' );
```

------------------

###  `get_query_var()`
https://developer.wordpress.org/reference/functions/get_query_var/

get_query_var( The variable key to retrieve , Value to return if the query variable is not set. )

Need to add them to WP_Query "query_vars" filter. Two examples below:

https://developer.wordpress.org/reference/classes/wp_query/

### McNally example:

```php
function themeslug_query_vars( $qvars ) {
$qvars[] = 'custom_query_var';
return $qvars;
}
add_filter( 'query_vars', 'themeslug_query_vars' );

function mcnally_custom_query_var( $vars ){
    $vars[] = "sort";
    return $vars;
}
add_filter( 'query_vars', 'mcnally_custom_query_var' );
```
 

```php
?>

<div class="tab-content col-12 col-md-9 columns" id="myTabContent">
    <div class="tab-pane fade show active">
        <h1><?php echo mcnally_tax_custom_title(); ?></h1>
        //Set up tabs here:
        //Use add_query_arg()
        <ul class="content-sort px-0 mx-0">
            <li>
                <a href="<?php echo get_term_link($term->term_id); ?>">Project Name</a>
            </li>
            <li>
                <a href="<?php echo esc_url( add_query_arg('sort', 'Location')) ?>">Location</a>
            </li>
            <li>
                <a href="<?php echo esc_url( add_query_arg('sort', 'CompletionDate DESC')) ?>">Date</a>
            </li>
        </ul>
        //Now you have two possible query args:
        //One with the key of sort and the value of Location
        //And one with the key of sort and the value of CompletionDateDESC.
        <div class="container">
            <div class="row">

                <?php
                //Set counter here outside of all the loops, then increment after the endif loop.
                $counter = 0;
                //Begin using the query args here.
                $sort = get_query_var('sort');
                // Here is where you setup the tabs/sorting mechanism a user might choose.
                //Start with a default/no choice option:
                if(!$sort || empty($sort)):
                //Here is where you modify the array of arguments that are about to be passed
                //To the get_posts() function.
                //get_posts() references WP_Query so the args are the same.
                //"If you would just like to call an array of posts based on a small and simple set of parameters within a page, then get_posts is your best option."
                //These are the defaults:
                $defaults = array(
                    'numberposts'      => 5,
                    'category'         => 0,
                    'orderby'          => 'date',
                    'order'            => 'DESC',
                    'include'          => array(),
                    'exclude'          => array(),
                    'meta_key'         => '',
                    'meta_value'       => '',
                    'post_type'        => 'post',
                    'suppress_filters' => true,
                );
                //Examples
                //Here, we are storing the possible array additions or modifications in variables:
                //Maybe use a switch statement if there are a ton possibilities.
                //After this, you'll use array_merge to push them into the query $args array.
                    $orderby = [
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ];

                elseif($sort === 'Location'):

                    $orderby = [
                        'meta_key' => 'location',
                        'orderby' => 'location',
                        'order' => 'ASC',
                    ];

                elseif($sort === 'CompletionDate DESC'):

                    $orderby = [
                        'meta_key' => 'date',
                        'orderby' => 'date',
                        'order' => 'DESC',
                    ];

                endif;

                //Get projects based on current taxonomy
                $args = [
                    'post_type' => 'projects',
                    'posts_per_page' => -1,
                    /*
                    'meta_key' => 'client_feedback_score',
                    'orderby' => 'client_feedback_score',
                    'order' => 'DESC',
                    */
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'specialties',
                            'field' => 'term_id',
                            'terms' => $term->term_id,
                        ),
                    ),
                ];

                $args = array_merge($args, $orderby);

                $projects = get_posts($args);

                foreach ($projects as $project) {

                    $img = get_field('project_image', $project->ID);
                    if($img) :
                        $src = $img['url'];
                        $alt = acf_set_alt($img);
                    endif;
                    ?>
                    <div class="column col-12 col-sm-6">
                        <?php if($img) : ?>
                            <div class="column-image">
                                <a href="<?php echo get_permalink($project->ID); ?>">
                                    <img src="<?php echo $src; ?>" alt="<?php echo $alt; ?>">
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="column-heading">
                            <h2><?php echo $project->post_title; ?></h2>
                        </div>
                        <div class="column-text">
                            <p><?php echo get_field('location', $project->ID); ?></p>
                            <p><?php echo get_field('date', $project->ID); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

```

## brand Projects
### Note: brand Projects and Continental Projects have similar sorting setups.

ACF `get_field_object()` 
Returns an array of values.
Defaults:
```php
array(
'ID'                => 0,
'key'               => '',
'label'             => '',
'name'              => '',
'prefix'            => '',
'type'              => 'text',
'value'             => null,
'menu_order'        => 0,
'instructions'      => '',
'required'          => 0,
'id'                => '',
'class'             => '',
'conditional_logic' => 0,
'parent'            => 0,
'wrapper'           => array(
'width'             => '',
'class'             => '',
'id'                => ''
)
);
```
Store the returned array in a variable:

```php
$field = get_field_object('project_delivery_method');
```
var_dump the results:
```php
echo '<pre>';
var_dump( get_field_object('project_delivery_method') );
echo '</pre>'; 
```
For Continental's "Delivery Method", this is the resulting array:
```php
array(27) {
  ["ID"]=>
  int(0)
  ["key"]=>
  string(19) "field_5fecf460bd37b"
  ["label"]=>
  string(15) "Delivery Method"
  ["name"]=>
  string(23) "project_delivery_method"
  ["aria-label"]=>
  string(0) ""
  ["prefix"]=>
  string(3) "acf"
  ["type"]=>
  string(8) "checkbox"
  ["value"]=>
  array(1) {
    [0]=>
    array(2) {
      ["value"]=>
      string(12) "design-build"
      ["label"]=>
      string(12) "Design-Build"
    }
  }
  ["menu_order"]=>
  int(3)
  ["instructions"]=>
  string(0) ""
  ["required"]=>
  int(0)
  ["id"]=>
  string(0) ""
  ["class"]=>
  string(0) ""
  ["conditional_logic"]=>
  int(0)
  ["parent"]=>
  string(19) "group_5d39c0d7389ee"
  ["wrapper"]=>
  array(3) {
    ["width"]=>
    string(0) ""
    ["class"]=>
    string(0) ""
    ["id"]=>
    string(0) ""
  }
  ["wpml_cf_preferences"]=>
  int(0)
  ["choices"]=>
  array(7) {
    ["bid-build"]=>
    string(9) "Bid-Build"
    ["cmgc"]=>
    string(5) "CM/GC"
    ["cmar"]=>
    string(4) "CMAR"
    ["design-build"]=>
    string(12) "Design-Build"
    ["engineering"]=>
    string(11) "Engineering"
    ["integrated-project-delivery"]=>
    string(27) "Integrated Project Delivery"
    ["public-private-partnerships"]=>
    string(27) "Public-Private Partnerships"
  }
  ["allow_custom"]=>
  int(0)
  ["default_value"]=>
  array(0) {
  }
  ["layout"]=>
  string(8) "vertical"
  ["toggle"]=>
  int(0)
  ["return_format"]=>
  string(5) "array"
  ["save_custom"]=>
  int(0)
  ["custom_choice_button_text"]=>
  string(14) "Add new choice"
  ["_name"]=>
  string(23) "project_delivery_method"
  ["_valid"]=>
  int(1)
}
```








