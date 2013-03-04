
<?php	
$args = array();	
$tags = wp_get_post_tags($post->ID);  

if (!empty($tags)) {  
	$tag_ids = array();  
	foreach($tags as $individual_tag) {
		$tag_ids[] = $individual_tag->term_id;
	}
}
if(isset($tag_ids)){
	$args = array(  
		'post_type' => array('post'),
		'tag__in' => $tag_ids,  
		'post__not_in' => array($post->ID),  
		'showposts' => 5,  // Number of related posts that will be shown.
		'ignore_sticky_posts'=>1  
	);
}

$custom_query = new WP_Query($args);
if ( $custom_query->have_posts() ) : ?>
<div class="clearfix"></div>
<div class="related-posts">
	<header class="header">
		<h3 class="didot-italic"><?php _e("You may also like"); ?></h3>
	</header>
	<div class="posts clearfix">
	    <?php
	    $i = 0;
	    while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
	    ?>
		<a href="<?php the_permalink();?>" class="post span omega alpha two">
			<div class="thumbnail featured-image">
				<?php 
				$image_id = get_post_thumbnail_id(get_the_ID());
				$image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				?>
				<img src="<?php echo $image[0]?>" class="scale" />
			</div>
			<div class="post-meta">
				<h5 class="title text-center uppercase"><?php the_title();?></h5>
			</div>
		</a>
	    <?php
	    $i++;
	    endwhile;
        wp_reset_query();
		wp_reset_postdata();
	    ?>
	</div>
</div>
<?php endif; ?>