# brand Projects Functions

Main function for getting Projects.

It has seven usages:

![brand-get-projects-usages-screenshot.png](brand-get-projects-usages-screenshot.png)



```php

function brand_get_projects( $market, $submarket, $limit = 9, $exclude = array(), $services = array() ) {
    
	if ( $market === $submarket && $market !== 'all' && empty( $services ) ) {
		$args = array(
			'post_type'  => 'projects',
			'meta_query' => array(
				array(
					'key'   => 'project_market',
					'value' => $market,
				)
			),
			'numberposts' => $limit,
            'exclude' => $exclude,
            'suppress_filters' => false
		);
	} 
    else if ( $market === 'all' && empty( $services ) ) {
        $args = array(
			'post_type' => 'projects',
            'orderby' => 'rand',
            'order' => 'DESC',
			'numberposts' => $limit,
            'exclude' => $exclude,
            'suppress_filters' => false
		);
    }
    else if ( !empty( $services ) ) {

        $meta_query = array('relation' => 'OR');

        foreach($services as $service) {
            $meta_query[] = array(
                'key'     => 'project_services',
                'value'   => $service,
                'compare' => 'LIKE',
            );
        }
        
        $args = array(
			'post_type'  => 'projects',
			'meta_query' => $meta_query,
			'numberposts' => $limit,
            'exclude' => $exclude
		);

    }
    else {
		$args = array(
			'post_type'  => 'projects',
			'meta_query' => array(
				array(
					'key'   => 'project_market',
					'value' => $market,
				),
				array(
					'key'   => 'project_sub_market_' . str_replace('-','_',$market),
					'value' => $submarket
				),
			),
			'numberposts' => $limit,
            'exclude' => $exclude,
            'suppress_filters' => false
		);
	}

	$projects = get_posts( $args );

    if ( sizeof($projects) === 0 && sizeof($exclude) > 0 ) {
        $projects = brand_get_projects($market,$market,9,$exclude);
    }
    
	return $projects;
	
}

```

## Load More Posts AJAX:

```php

function loadmore_ajax_handler() {
	
	if (empty($_POST['tag']) && $_POST['tag'] !== '0') {
		$paged = intval($_POST['page']) + 1;
	} else {
		$paged = intval($_POST['page']);
	}
	// prepare our arguments for the query
	$args = array(
		'paged' => $paged,
		'posts_per_page' => 6,
		'post_status' => 'publish',
		'category__not_in' => array(19),
		'tag' => (empty($_POST['tag'] && $_POST['tag'] !== '0') ? '' : $_POST['tag'])
	);
	$i = 0;
	$recent = new WP_Query( $args );
	if ($recent->have_posts() ) : 
		while ($recent->have_posts()) : $recent->the_post();
		$i++;
		ob_start();
		get_template_part( 'articles');
		$items[] = ob_get_clean();
		endwhile;
	endif;


	
	if ($i > 0) {
		wp_send_json_success(array('items' => $items, 'total_pages' => $recent->max_num_pages, 'page' => $paged)); //Success
	} else {
		wp_send_json_error(array('message' => 'No content to display.')); //Error
	}
}

add_action('wp_ajax_loadmore', 'loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

```