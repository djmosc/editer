<?php 
$custom_query = new WP_Query( array('posts_per_page' => -1, 'post_type' => array('post'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 1, 'category__in' => array(get_editer_option('hts_category_id')), 'post__not_in' => array($post->ID)));
if ( $custom_query->have_posts() ) :
	$columns = array('first', 'second', 'third', 'fourth');
	$total_columns = count($columns);
	$i = 0;
?>
<div id="street-chics" class="clearfix">
	<ul class="posts clearfix">
		<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
		<li class="post span two-and-half <?php echo $columns[$i % $total_columns];?>">
			<div class="thumbnail featured-image">
				<a href="<?php the_permalink(); ?>" class="overlay-btn">
					<?php
						$image_id = get_post_meta($post->ID, 'homepage_image_id', true); 
						$image =  wp_get_attachment_image_src($image_id, 'custom_thumbnail');
					?>
					<img src="<?php echo $image[0]?>" class="scale" />
				</a>
			</div>
			<div class="post-meta">
				<p class="text-center novecento-demibold small">
					<a href="<?php the_permalink();?>" class="grey"><?php the_time(get_option('date_format')); ?></a>
				</p>
			</div>
		</li>
		<?php $i++; ?>
		<?php endwhile; ?>
	</ul>
</div>
<?php endif;?>