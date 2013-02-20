<?php 

class Facebook extends WP_Widget {
	
	function Facebook() {
		$widget_opts = array( 'description' => __('Use this widget is to show the facebook stuff') );
		parent::WP_Widget(false, 'Facebook', $widget_opts);
	}
	function form($instance) {
		
		$content = (isset($instance['content'])) ? esc_attr($instance['content']) : '';  
        echo '<p><label>';
		echo _e('Content:').'<textarea class="widefat" rows="16" cols="20" name="'. $this->get_field_name('content').'" >'. $content.'</textarea>';
        echo '</label></p>';

	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		$args['content'] = $instance['content'];
		echo $args['before_widget'] . '<div class="border inner"><div class="inner border">';
		echo $args['content'];
		echo '</div></div>'.$args['after_widget'];
	}
}

register_widget('Facebook');



?>
