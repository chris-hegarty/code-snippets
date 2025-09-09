
Source: Creating an Archive Index
https://codex.wordpress.org/Creating_an_Archive_Index

Source: How to build and add taxonomies to WordPress Post Types
https://www.advancedcustomfields.com/blog/add-taxonomy-to-custom-post-type/

To set up a separate archive index you'll need to create it as a Page, and assign it a special template.

Make a file named "archive.php":

```php
<?php
/*
Template Name: Archives
*/
get_header(); ?>

<div id="container">
	<div id="content" role="main">

		<?php the_post(); ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		
		<?php get_search_form(); ?>
		
		<h2>Archives by Month:</h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
		
		<h2>Archives by Subject:</h2>
		<ul>
			 <?php wp_list_categories(); ?>
		</ul>

	</div><!-- #content -->
</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

```

useful functions:

`get_archives()`: https://developer.wordpress.org/reference/functions/get_archives/
Retrieves a list of archives
`wp_get_archives` https://developer.wordpress.org/reference/functions/wp_get_archives/
Displays archive links based on type and format.

Adding custom fields to taxonomy terms

-Create a field group
-Assign it to "Taxonomy"
To display this enhanced taxonomy information in your templates, 
use ACF’s `get_field()` function with the taxonomy term as the second parameter:
```php
$term = get_queried_object();
$logo = get_field('brand_logo', $term);
if ($logo) {
    echo '<img src="' . $logo['url'] . '" alt="' . $term->name . ' logo">';
}

```

Display list of posts with setup_postdata:
(Uses ACF Post Object)

```php



```

ACF Archives with pre_get_posts()

```php

?>

<div id="search-component">

<?php 

$field = get_field_object();
$values = explode(',', $GET[]);

?>

<ul>
 <?php foreach( $field['choices'] as $choice_value => $choice_label ) :?>
 
 <li>
 <input type="checkbox" value="<?php echo $choice_value ?>">
 </li>

 
 <?php endforeach;?>


</ul>

</div>

```

Then add Javascript:

```javascript

$("#search-component").on("change",'input[type="checkbox"]', function(){
  const $ul = $(this).closest('ul');
  vals = [];
  
  $ul.find('input:checked').each(function(){
    vals.push($(this).val());
  });
  //turn the array into a string with a comma delimiter
  vals = vals.join(",");
  //can also use window.href.replace
  window.location.replace('<?php echo home_url("houses"); ?>?bedrooms=' + vals);
  
  
  
})

```



