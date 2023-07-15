<ul class="pgwSlider">
<?php  $slider_cat = get_theme_mod( 'wp_fanzone_category'); ?>	
<?php
//query posts
$args =	array(
	'offset'           => 0,
	'category_name' => $slider_cat,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true
);
$counter = 1;
$the_query = new WP_Query( $args );
?>

                        
<?php //echo $slider_cat; ?>
<?php if ($the_query->have_posts()) : ?>           
	<?php while ($the_query->have_posts()) : $the_query->the_post(); ?> 
    	<?php
			
			if ( '' != get_the_post_thumbnail() && $counter < 6) { 
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slide-large-image');
				$medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slide-medium-thumb');
				$small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slide-small-thumb');
				
				if($counter == 1){
					$img_thumb  = $medium_image_url[0];
				} else{
					$img_thumb  = $small_image_url[0];
				}				
				
		?>
        <li><a href="<?php the_permalink('') ?>"><img src="<?php echo $img_thumb; ?>" alt="<?php the_title(); ?>" data-large-src="<?php echo $large_image_url[0] ?>" data-description="<?php the_excerpt(); ?>" /></a></li>
        <?php	$counter++;
				
				
			}
			
		 ?>
    
    <?php endwhile; ?> 
<?php endif; ?> 
<?php wp_reset_query(); ?>
</ul>