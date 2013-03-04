<?php global $category_level; ?>
<div class="post-category novecento-bold">
	<?php
	$taxonomy = 'shop_category';
	$categories = get_the_terms($post->ID, $taxonomy);
	//print_r($categories);
	$categories = array_slice($categories, 0, 1);
	$category = get_top_level_category($categories[0]->term_id, $taxonomy);
	if(is_category() || $category_level == 2 || is_single()) {
		$category = get_sub_category($post->ID, $taxonomy);
	}

	if($category):
	?>
	<a href="<?php echo get_category_link($category->term_id );?>" title="<?php esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ); ?>"><?php echo $category->name; ?></a>
	<?php endif; ?>
</div>