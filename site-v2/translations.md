# WPML Helper Functions

## Manual Link Translation (Non-ACF)

Non-ACF links require manual translation using WPML filters, while ACF link fields are automatically handled by the 
existing filter in the code.

Note: The following features work automatically and require no additional setup:
-Media metadata duplication when using WPML media translation
-ACF link field URL copying from default language with translated titles. 8. ACF Link Field Translation
The acf/format_value/type=link filter ensures that the URL in ACF link fields is copied from the default language while allowing the title/target to be translated. This is applied globally and requires no additional setup.
-Featured image fallback for posts without thumbnails in translations
-ACF image field fallback for empty image fields in article translations
-Display as translated snippet disabled on front-end to show only true translations

### For links that are not ACF fields (hardcoded links, menu items, or custom fields), use these approaches:

#### For Internal Links:

Use `kiewit_wpml_lang_param()` to add language parameters:

```php
// Simple internal link
$url = '/about-us' . kiewit_wpml_lang_param('?');

// Link with existing parameters
$url = '/search?q=test' . kiewit_wpml_lang_param('&');
```

#### Get the current language:
Use `kiewit_get_current_language()` to retrieve the current language code (e.g., en, fr-ca):

```php
$current_language = kiewit_get_current_language();

```

#### For Post/Page Links

Use WPML's `wpml_permalink` filter to get translated URLs:

```php
// Get translated permalink for a specific post
$post_id = 123;
$current_lang = kiewit_get_current_language();
$translated_url = apply_filters('wpml_permalink', get_permalink($post_id), $current_lang);

// Or use wpml_object_id to get the translated post first
$translated_post_id = apply_filters('wpml_object_id', $post_id, 'page', false, $current_lang);
$translated_url = get_permalink($translated_post_id);
```

#### For Dynamic Link Building

```php
// Build a category archive link
$category_id = 5;
$translated_cat_id = apply_filters('wpml_object_id', $category_id, 'category', false, kiewit_get_current_language());
$category_url = get_category_link($translated_cat_id);

// Build a custom post type archive link
$archive_url = get_post_type_archive_link('project');
$current_lang = kiewit_get_current_language();
$translated_archive_url = apply_filters('wpml_permalink', $archive_url, $current_lang);
```

#### Get language switcher data
```php
$languages = kiewit_get_switcher_languages();
foreach ($languages as $lang) {
echo '<a href="' . $lang['url'] . '">' . $lang['native_name'] . '</a>';
}
```

#### Get post in current language

```php
$translated_post = kiewit_get_post_in_view_lang($post);
```





