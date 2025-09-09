```php
	        if( have_rows('page_builder') ):
		        while(have_rows('page_builder')) : the_row();
			        get_template_part('template-parts/builder/' . get_row_layout() );
		        endwhile; // close the loop of flexible content
	        endif; // close flexible content conditional

```

```php

```