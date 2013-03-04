<?php 

class Category_Image extends WP_Widget {
	
	function Category_Image() {
		$widget_opts = array( 'description' => __('Use this widget is to show the image of the top level category.') );
		parent::WP_Widget(false, 'Category Image', $widget_opts);
	}
	
	
	function widget($args, $instance) {
		global $post;
		
		$category = get_top_level_category(get_query_var('cat'));
		$image_id = get_field('image_id', 'category_'.$category->term_id);
		if($image_id):
		$image = wp_get_attachment_image_src($image_id, 'thumbnail');
		echo $args['before_widget'];
		?>
		<a href="<?php echo get_category_link( $category->term_id ); ?>">
			<img src="<?php echo $image[0]; ?>" class="scale" />
		</a>
		<?php echo $args['after_widget'];
		endif;
	}
}

register_widget('Category_Image');