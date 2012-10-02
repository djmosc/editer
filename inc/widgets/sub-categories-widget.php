<?php 

class Sub_Categories extends WP_Widget {
	
	function Sub_Categories() {
		parent::WP_Widget(false, 'Sub Categories');
	}
	function form($instance) {
		
		$title = esc_attr($instance['title']);  
        echo '<p><label>';
		echo _e('Title:').'<input class="widefat" name="'. $this->get_field_name('title').'" type="text" value="'. $title.'" />';
        echo '</label></p>';
		
		$parent_category = esc_attr($instance['parent_category']);  
        echo '<p><label>';
		echo _e('Parent Category:').'<input class="widefat" name="'. $this->get_field_name('parent_category').'" type="text" value="'. $parent_category .'" />';
        echo '</label></p>';
	
	}
	function update($new_instance, $old_instance){
			return $new_instance;
	}
	function widget($args, $instance) {
		$args['title'] = $instance['title'];
		$args['parent_category'] = $instance['parent_category'];
		echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
	
		$cat_args['title_li'] = '';
		$cat_args['child_of'] = (int)$args['parent_category'];
		$cat_args['hide_empty'] = 0;
		echo '<div class="category-menu menu">';
		echo '<ul>';
		wp_list_categories($cat_args);
		echo '</ul>';
		echo '</div>';
		echo $args['after_widget'];
	}
}

register_widget('Sub_Categories');



?>
