<?php 

class Subscribe extends WP_Widget {
	
	function Subscribe() {
		parent::WP_Widget(false, 'Subscribe');
	}
	function form($instance) {
		
		$title = esc_attr($instance['title']);  
        echo '<p><label for="'.$this->get_field_id('title').'">';
		echo _e('Title:').'<input class="widefat" id="'. $this->get_field_id('title').'" name="'. $this->get_field_name('title').'" type="text" value="'. $title.'" />';
        echo '</label></p>';
		
		$content = esc_attr($instance['content']);  
        echo '<p><label for="'.$this->get_field_id('content').'">'._e('Content:').'</label>';
		echo '<textarea class="widefat" id="'. $this->get_field_id('content').'" name="'. $this->get_field_name('content').'">'.$content.'</textarea>';
        echo '</p>';
	}
	
	function update($new_instance, $old_instance) {
			return $new_instance;
	}
	
	function widget($args, $instance){
		
		$args['title'] = $instance['title'];
		$args['content'] = $instance['content'];
		echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
		echo '<p class="black helvetica uppercase">'.$args['content'].'</p>';
		echo '<form>';
        echo '<input type="text" value="Enter your name" rel="Enter your name" class="show" />';
        echo '<input type="text" value="Enter your email address" rel="Enter your email address" class="show" />';
        echo '<input type="submit" value="Subscribe" class="helvetica orange-btn full-width uppercase" />';                
		echo '</form>';
		echo $args['after_widget'];
	}
}

register_widget('Subscribe');



?>