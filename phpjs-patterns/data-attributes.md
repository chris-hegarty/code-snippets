```php
//Set up data attributes in HTML
 ?>
    <div class="projects__display" 
    data-market="<?php echo $market; ?>" 
    data-submarket="<?php echo $submarket; ?>" 
    data-services="<?php echo implode(',',$services); ?>" 
    data-limit="<?php echo $limit; ?>" 
    data-page="<?php echo $page; ?>" 
    data-total="<?php echo kiewit_count_projects( $market, $submarket, $services ); ?>">
```

Use in JavaScript:

(Except in success, better to call that "response" to make things less confusing.)

```javascript

    $(".projects .loadmore").on("click", function (e) {
        e.preventDefault();
        var params = $(".projects__display").data();
        params['action'] = "projects";
        $.ajax({
            type: "GET",
            url: "/wp-admin/admin-ajax.php",
            data: params,
            beforeSend: function() { $(".loading").show(); },
            complete: function() { $(".loading").hide(); },
            success: function(data) {
                $( data.data.items ).insertAfter( $(".projects__display .row:last-child") );
                //$( ".projects__display" ).attr("data-page", data.data.page);
                $( ".projects__display" ).data("page", data.data.page);
                if ( ( parseInt(data.data.page) * parseInt(params['limit']) ) >= parseInt(params['total']) ) {
                    $(".button.loadmore").hide();
                }
            }
        });
        return false;
    });


```
















```
Full scripts:

```php

```php
//Set up data attributes in HTML
 ?>
    <div class="projects__display" data-market="<?php echo $market; ?>" data-submarket="<?php echo $submarket; ?>" data-services="<?php echo implode(',',$services); ?>" data-limit="<?php echo $limit; ?>" data-page="<?php echo $page; ?>" data-total="<?php echo kiewit_count_projects( $market, $submarket, $services ); ?>">
    <?php
    $counter = 0;
    
    
    foreach($projects as $project) {
        $photos = get_post_meta( $project->ID, 'project_photos', true );

        $counter++;
        if ($counter === 1) {
        ?>

        <div class="row">
        <?php
        } //End $counter = 1
        ?>

            <div class="col-sm-12 col-md-4">
                <div class="card projects__project<?php echo (is_front_page() ? ' projects__project--home' : ''); ?><?php echo (is_front_page() ? ' animated' : ''); ?>" data-id="<?php echo $project->ID; ?>">
                    <a class="projects__photo" href="<?php echo get_permalink($project->ID); ?>" style="background-image: url('<?php echo kiewit_convert_attachment_format( wp_get_attachment_image_src( $photos[0], 'medium_large' )[0], '768px'); ?>')">
                        <div class="projects__info">
                            <h4><?php echo $project->post_title; ?></h4>
                            <p><?php echo trim(get_post_meta( $project->ID, 'project_location_city', true )); ?>, <?php echo trim(get_post_meta( $project->ID, 'project_location_state', true )); ?></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php
        if ($counter === 3) {
            $counter = 0; //reset counter
        ?>

        </div>
        <?php
        } //End $counter = 3

    } //End foreach


    if ($counter !== 0) { ?>

        </div>
    <?php
    } //End $counter != 0
    ?>
    
    </div>
    <?php
```

```