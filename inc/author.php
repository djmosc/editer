<?php
$custom_query = new WP_Query(array(
	'post_type' => array('editor'), 
	'meta_query' => array(
		array(
			'key' => 'user_id',
			'value' => get_the_author_meta('ID')
		)
	),
	'posts_per_page' => -1
));
if ( $custom_query->have_posts()) :
?>
<div class="post-author">
	<header class="header">
		<h4 class="title novecento-demibold uppercase"><a href=""><?php _e("Meet Our Stylemakers") ?></a></h4>
	</header>
	<?php $i = 0; ?>
	<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
	<div class="post editor clearfix">
		<div class="span four alpha featured-image thumbnail">
			<a href="<?php the_permalink();?>">
                <?php
                $image_id = get_post_thumbnail_id(get_the_ID());
                $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
                ?>
                <img src="<?php echo $image[0]?>" class="scale" />
            </a>
		</div>
		<div class="span six omega content">
			<div class="post-meta">
				<h3 class="title no-margin"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
				<p class="excerpt arial small avenir dark-grey"><?php echo get_the_excerpt(); ?></p>
			</div>
			<div class="post-content">
				<p class="small"><?php echo get_limited_content(150); ?></p>
			</div>
			<footer class="footer">
				<p class="no-margin"><a href="<?php the_permalink(); ?>" class="red-btn"><?php printf( __('See  %s&#39;s Edits', 'editer'),  get_the_title()); ?></a></p>
			</footer>
		</div>
	</div>
	<?php endwhile; ?>
	<?php wp_reset_query(); ?>
	<?php wp_reset_postdata(); ?>
</div>
<?php endif; ?>