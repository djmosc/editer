<?php 

class Category_Sub_Navigation extends WP_Widget {
	
	function Category_Sub_Navigation() {
		$widget_opts = array( 'description' => __('Use this widget is to show the navigation of the top level category.') );
		parent::WP_Widget(false, 'Category Sub Navigation', $widget_opts);
	}
	
	
	function widget($args, $instance) {
		global $post;
		
		$category = get_top_level_category(get_query_var('cat'));
		echo $args['before_widget'];
		?>
		<nav class="category-navigation striped-border top bottom">
			<ul class="inner">
				<?php
				wp_list_categories(array('title_li' => '', 'child_of' => $category->term_id));
				?>
			</ul>
		</nav>
		<?php echo $args['after_widget'];
	}
}

register_widget('Category_Sub_Navigation');