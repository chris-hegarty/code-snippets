# Checking class and style variables

This is an attempt to write PHP that -does not- output style, id or class attributes unless they exist.

Often, a script will do something like this:

```php
?>
<section id="<?php echo $id?>">
```
The problem is that if there is no id set, you will still see it in the output, like:
```php
?>
<section id="">
```

It's not a huge deal. It doesn't break anything. But we can write the PHP a little differently to avoid that.
These line won't output the id attribute if it's empty.
The first checks if the id exists.
The second isn't going to echo anything if the id is empty.

```php
$id = (!empty( $add_id )) ? 'id="' . $add_id . '"' : null;
<section <?php echo $id ?>

```

```php
<?php

	$background_slider = get_sub_field( 'background_slider' );
	$add_id = get_sub_field( 'add_id' );
	$add_class = get_sub_field( 'add_class' );
	$background_image = get_sub_field( 'background_image' );
	$background_image = $background_image;
	$background_color = get_sub_field( 'background_color' );
	$background_overlay = get_sub_field( 'background_overlay' );
	$background_overlay_light = get_sub_field( 'background_overlay_light' );
	$top_shadow = get_sub_field( 'top_shadow' );
	$content_contain_max_width = get_sub_field( 'content_contain_max_width' );
	$center_content_block = get_sub_field( 'center_content_block' );
	$headline_text_color = get_sub_field( 'headline_text_color' );
	$center_headline = get_sub_field( 'center_headline' );
	$headline = get_sub_field( 'headline' );
	$body_text_color = get_sub_field( 'body_text_color' );
	$column = get_sub_field( 'column' );
	$button_alignment = get_sub_field( 'button_alignment' );
	$button_link = get_sub_field( 'button_link' );
	$button_theme_color = get_sub_field( 'button_theme_color' );
	$button_text = get_sub_field( 'button_text' );

	$id = (!empty( $add_id )) ? 'id="' . $add_id . '"' : null;

?>

<?php if($background_slider): ?>

<section <?php echo $id ?>
	class="single-column-background-image builder-background-image-options <?php echo $add_class; ?>"
	style="position:relative;">

	<?php get_template_part( 'template-parts/slider' );

else:

	?>

<section <?php echo $id ?>
	class="updated-script single-column-background-image builder-background-image-options <?php echo $add_class; ?>"
	<?php
		$bg_src = $background_image ? $background_image[0] : null;
		if( $background_color || $bg_src ):
			?>
			style="<?php echo $background_color ? 'background-color: ' . $background_color . ';' : ''; ?>
			<?php echo $bg_src ? 'background-image: url(' . $bg_src . ');' : ''; ?>"
		<?php endif; ?>>

<?php endif; ?>

	<div class="background-wrap
	<?php echo $background_overlay ? 'single-column-background-image-overlay' : ''; ?>
	<?php echo $background_overlay_light ? 'single-column-background-image-overlay-light' : ''; ?>
	<?php echo $top_shadow ? 'top-shadow' : ''; ?>">

		<div class="container single-column-contain">
			<div class="row">
				<div class="content-container">
					<div class="single-section-container width-container"
						 style="<?php echo get_max_width_style($content_contain_max_width); ?>">
						<div class="single-section-content-container">
							<?php if($headline) : ?>
								<h2 style="<?php echo $headline_text_color ? 'color: ' . $headline_text_color . ';' : null; ?> <?php echo $center_headline ? 'text-align: center;' : null; ?>">
									<?php echo $headline; ?>
								</h2>
							<?php endif; ?>
							<div style="<?php echo $body_text_color ? 'color: ' . $body_text_color . ';' : null; ?>
							<?php echo $center_content_block ? 'text-align: center;' : null; ?> ">
								<?php echo $column; ?>
							</div>
							<div class="button-contain"
								 style="<?php echo get_button_alignment_style($button_alignment); ?>">
								<?php
									$link = $button_link;
									if( $link ):
										$link_url = $link['url'];
										$link_target = $link['target'] ?: '_self';
										?>
										<a class="button <?php echo get_button_theme_color($button_theme_color) ?>"
										   href="<?php echo esc_url( $link_url ); ?>"
										   target="<?php echo esc_attr( $link_target ); ?>"><?php echo $button_text; ?></a>
									<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

```