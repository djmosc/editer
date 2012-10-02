<?php global $category_position, $category_level; ?>

<?php $category_position = ($category_position) ? $category_position : 'top'; ?>
<div class="post-category novecento-bold <?php echo $category_position; ?>">
	<div class="inner">
		<?php
		$categories = get_the_category();
		$category = get_top_level_category($categories[0]->term_id);
		if(is_category() || $category_level == 2 || is_single()) {
			$category = get_sub_category($category->term_id);
		}
		?>
		<a href="<?php echo get_category_link($category->term_id );?>" title="<?php esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ); ?>"><?php echo $category->cat_name; ?></a>
	</div>
</div>
