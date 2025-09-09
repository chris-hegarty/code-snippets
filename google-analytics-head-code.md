# Set up for GA code

Put this inside the head tag:
```php
    $ga_embed_code = get_field('ga_embed_code', 'option');
    $gtm_code = get_field('gtm_code', 'option');
    $google_site_verification_code = get_field('google_site_verification_code', 'option');
    $gtm_no_code = get_field('gtm_no_code', 'option');

    echo $ga_embed_code ? $ga_embed_code : '';
    echo $gtm_code ? $gtm_code : '';
    echo $google_site_verification_code ? $google_site_verification_code : '';
    echo $gtm_no_code ? $gtm_no_code : '';
```

