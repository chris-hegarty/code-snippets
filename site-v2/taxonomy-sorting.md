# Sorting multiple taxonomies in WordPress


The Sort Terms option in ACF's custom taxonomy registration corresponds to the 'sort' parameter in WordPress's register_taxonomy() function. 

This is a lesser-known but important parameter that controls how terms are ordered when assigned to posts.

WordPress register_taxonomy() Equivalent
In PHP, this would be set as:

```php


register_taxonomy('your_taxonomy', 'your_post_type', array(
    'sort' => true, // or false
    // other arguments...
));

```

## What It Does
The sort parameter determines whether terms in the taxonomy should maintain the order they are provided to wp_set_object_terms() when being assigned to posts. Here's how it works:

When sort = true (default): Terms are automatically sorted alphabetically by WordPress, regardless of the order you provide them
When sort = false: Terms maintain the exact order they were provided in wp_set_object_terms()

### Benefits of Each Setting

#### Setting Sort Terms = True (Default)

Benefits:

Consistent alphabetical ordering across your site
Predictable term display order
Good for taxonomies where alphabetical order makes sense (like categories, tags, locations)
Use cases:

Category lists
Alphabetical tags
Location taxonomies
Any taxonomy where consistent sorting is preferred

#### Setting Sort Terms = False

Benefits:

Custom ordering control - You can specify exactly how terms appear
Priority-based ordering - Display most important terms first
Sequential ordering - Maintain chronological or step-by-step order
Manual curation - Content editors can control the display order
Use cases:

Priority levels (High, Medium, Low)
Process steps (Step 1, Step 2, Step 3)
Featured categories that should appear first
Any scenario where manual ordering is more important than alphabetical

### Practical Example
If you have a "Priority" taxonomy with terms: "High", "Medium", "Low":

With sort = true: Always displays as "High, Low, Medium" (alphabetical)
With sort = false: Displays in the order you assign them, allowing "High, Medium, Low" (logical priority order)

Recommendation
Choose based on your content strategy:

Use Sort = True for general taxonomies where alphabetical order is logical
Use Sort = False when you need manual control over term display order, especially for taxonomies that represent priorities, sequences, or hierarchical relationships