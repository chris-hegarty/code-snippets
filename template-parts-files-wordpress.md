# WordPress template parts | files | best practices

## PHP include

The include statement in PHP is used to include and evaluate a specified file. 

If the file is not found, a warning is issued, but the script will continue to execute. 

("require" is identical to "include" except upon failure it will produce a fatal error. 

```php
include 'filename.php';
```

---------------------------------

## get_template_part()

Used to include template files in a WordPress theme.

```php
get_template_part( 'template-parts/content', 'page' );
```

Directory structure:

`
/your-theme

├── template-parts

│   └── content-page.php

├── functions.php

├── header.php

├── footer.php

└── index.php
`

------------

## get_template_part_{$slug}

Include specific template parts based on context (e.g., single post, page).

```php
get_template_part('template-parts/content', 'single');

```

Directory structure

/your-theme
├── template-parts
│   └── content-single.php
├── functions.php
├── header.php
├── footer.php
└── index.php

-------------

## locate_template()

The locate_template() function searches for a template file in the theme,

and then returns the path to the file if found. 
 
_It does not include the file --  but returns the path for further use._

`locate_template()` takes an array as its first parameter.

This way, you can specify multiple fallback files if needed.

Example:
```php
$post_type = get_post_type();
$template = locate_template(array(
    "single-{$post_type}.php", // Specific template for the post type
    'single.php',              // Generic single post template
    'index.php'                // Fallback to the main template
));
if ($template) {
    include $template;
}
```

### Best Practices:

* Use this function when you need to find a template file and include it conditionally.
* Combine with include or require to include the template file after locating it.

* ### Examples:
* 


```php
$template = locate_template(array('custom-template.php'));
if ($template) {
    include $template;
}
```
Include a custom template for a custom post type:

```php
// This line calls the get_post_type() function to get the post type of the current post.
// The post type could be something like 'post', 'page', or a custom post type like 'product'.

$post_type = get_post_type();

$template = locate_template(array("single-{$post_type}.php"));
if ($template) {
    include $template;
} else {
    include 'single-default.php';
}
```

Including a Template for a Custom Page Template:

```php
$page_template = get_page_template_slug();
$template = locate_template(array("page-templates/{$page_template}.php"));
if ($template) {
    include $template;
} else {
    include 'page-templates/default.php';
}
```

Including a Template for a Custom Taxonomy:
```php
//Scroll down for more information on the get_query_var()
$taxonomy = get_query_var('taxonomy');
$template = locate_template(array("taxonomy-{$taxonomy}.php"));
if ($template) {
    include $template;
} else {
    include 'taxonomy-default.php';
}
```
-----------------
## Summary

* PHP include: Simple file inclusion, use for non-WordPress specific files.
* WordPress get_template_part(): Modular template inclusion, use for reusable theme parts.
* WordPress get_template_part_{$slug}: Context-specific template inclusion, use for different content types.
* WordPress locate_template(): Template path retrieval, use for conditional template inclusion.

------------
## Notes on `get_query_var()`

These query variables are parameters used in WordPress queries to filter and display specific content. 

Here are some common query variables and how get_query_var() can be used with them:



### Common Query Variables

1. **'post_type'**
    - **Usage:** Retrieve the post type of the current query.
    - **Example:**
      ```php
      $post_type = get_query_var('post_type');
      if ($post_type == 'product') {
          // Do something specific for products
      }
      ```

2. **'category_name'**
    - **Usage:** Retrieve the category name of the current query.
    - **Example:**
      ```php
      $category_name = get_query_var('category_name');
      if ($category_name == 'news') {
          // Do something specific for the news category
      }
      ```

3. **'tag'**
    - **Usage:** Retrieve the tag of the current query.
    - **Example:**
      ```php
      $tag = get_query_var('tag');
      if ($tag == 'featured') {
          // Do something specific for featured posts
      }
      ```

4. **'author'**
    - **Usage:** Retrieve the author ID of the current query.
    - **Example:**
      ```php
      $author_id = get_query_var('author');
      if ($author_id == 1) {
          // Do something specific for the author with ID 1
      }
      ```

5. **'paged'**
    - **Usage:** Retrieve the current page number in a paginated query.
    - **Example:**
      ```php
      $paged = get_query_var('paged');
      if ($paged > 1) {
          // Do something specific for paginated pages
      }
      ```

### Real-World Example
Let's say you have a custom post type called "event" and you want to display a custom message on the archive page for this post type. You can use `get_query_var()` to check the post type and conditionally display the message.

**Example:**
```php
// In your theme's archive template file
$post_type = get_query_var('post_type');
if ($post_type == 'event') {
    echo '<p>Welcome to our events archive!</p>';
}
```
**Explanation:**
1. **Retrieve the Post Type:** The line `$post_type = get_query_var('post_type');` gets the post type of the current query.
2. **Conditional Display:** The `if` statement checks if the post type is 'event'. If it is, it displays a custom message.

By using `get_query_var()` with different query variables, you can create dynamic and context-specific content in your WordPress theme.

---------------------

### When to use `include( locate_template() )` vs `get_template_part()`

(Source: https://keithdevon.com/passing-variables-to-get_template_part-in-wordpress/)
(Source: https://make.wordpress.org/core/2020/07/17/passing-arguments-to-template-files-in-wordpress-5-5/))

Here are some scenarios where you might prefer using include( locate_template() ) over get_template_part() in WordPress:

Passing Variables: If you need to pass variables or data to the template file, include( locate_template() ) is more flexible. This method allows you to pass any variables from your current script directly to the template file, making it easier to handle dynamic content1.

Complex Logic: When your template file requires complex logic or conditional statements, include( locate_template() ) provides more control. You can include the template file conditionally based on various factors, which might be harder to achieve with get_template_part()1.

Custom Template Loading: If you need to load a template file that is not part of the standard WordPress template hierarchy, include( locate_template() ) can be a better choice. This method allows you to specify the exact path to the template file, ensuring it is loaded correctly1.

Backward Compatibility: In some cases, you might be working on a theme or plugin that needs to maintain backward compatibility with older versions of WordPress. Using include( locate_template() ) can help ensure that your code works with older versions that might not support the latest features of get_template_part()2.

Custom Template Functions: If you have custom template functions that need to be included in the template file, include( locate_template() ) allows you to include these functions directly. This can be useful for advanced theme development where you need to extend the functionality of your templates2.

In summary, while get_template_part() is great for including reusable template parts and adhering to WordPress standards, include( locate_template() ) offers more flexibility and control for scenarios where you need to pass variables, handle complex logic, or ensure backward compatibility21.

----------------

### Different headers/footers/sidebars for different places

```php
<?php
if ( is_home() ) :
	get_header( 'home' );
elseif ( is_404() ) :
	get_header( '404' );
else :
	get_header();
endif;
?>
```
Note: The file names for the home and 404 headers should be header-home.php and header-404.php respectively.

----------------------

## `get_template_part()`  with theme subfolders

if you have a folder called “partials” in your theme directory and a template part called “content-page.php” in that sub-folder, you would use get_template_part() like this:

```php

<?php get_template_part( 'partials/content', 'page' ); ?>

```
You can check for post type archives in your templates and load specific templates accordingly, which is what your current code is already doing. Your approach of using conditional checks like `is_post_type_archive()` is the correct way to handle this.

    Your current implementation is already:
    1. Checking if the current page is a post type archive
    2. Loading the appropriate template based on the post type
    3. Falling back to a default template if needed

    This is a common pattern in WordPress theme development for handling different content types. The code you have implemented should work correctly as long as the template files exist in your theme directory.

```php

            if (is_post_type_archive()) {
                $post_type = get_post_type();
                $template = "/template-parts/pages/page-{$post_type}.php";
            } elseif (is_tax() || is_category() || is_tag()) {
                $taxonomy = $term->taxonomy;
                $template = "tax-{$taxonomy}.php";
            } else {
                // Default to projects for regular archives or fallback
                $template = 'page-projects.php';
                echo 'defaulted to page-projects!!!!!';
            }
            
            // Check if the template exists, otherwise fall back to default
            if (locate_template(array($template))) {
                include(locate_template(array($template)));
            } else {
                include(locate_template(array('page-projects.php')));
            }

```








