<?php 

class Sub_Menu extends WP_Widget {
	
	function Sub_Menu() {
		$widget_opts = array( 'description' => __('Use this widget to show the sub menu of a page.') );
		parent::WP_Widget(false, 'Sub Menu', $widget_opts);
	}
	function form($instance) {
		
		$title = esc_attr($instance['title']);  
        echo '<p><label for="'.$this->get_field_id('title').'">';
		echo _e('Title:').'<input class="widefat" id="'. $this->get_field_id('title').'" name="'. $this->get_field_name('title').'" type="text" value="'. $title.'" />';
        echo '</label></p>';
	
	}
	function update($new_instance, $old_instance){
			// processes widget options to be saved
			return $new_instance;
	}
	function widget($args, $instance) {
		global $post;
		$args['title'] = $instance['title'];
		$args['content'] = $instance['content'];
		echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];

		global $wp_query;
		$parent = $post->post_parent;
		if( empty($post_parent) ) {
			$parent = $post->ID;
		}
		?>
		<div class="striped-border top left right bottom">
			<nav class="menu inner">
				<ul>
					<?php wp_list_pages("title_li=&child_of=$parent" ); ?>
				</ul>
			</nav>
		</div>
		<?php
		echo $args['after_widget'];
	}
}

register_widget('Sub_Menu');



?>