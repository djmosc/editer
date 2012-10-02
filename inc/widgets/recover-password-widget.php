<?php 

class Recover_Password extends WP_Widget {
	
	function Recover_Password() {
		$widget_opts = array( 'description' => __('Use this widget to show the recover password form.') );
		parent::WP_Widget(false, 'Recover Password', $widget_opts);
	}
	function form($instance) {
		
		$title = esc_attr($instance['title']);  
        echo '<p><label>';
		echo _e('Title:').'<input class="widefat" name="'. $this->get_field_name('title').'" type="text" value="'. $title.'" />';
        echo '</label></p>';
		
		$content = esc_attr($instance['content']);
        echo '<p><label>'._e('Content:').'</label>';
		echo '<textarea class="widefat"  name="'. $this->get_field_name('content').'" >'.$content.'</textarea>';
        echo '</p>';
	}
	
	function update($new_instance, $old_instance) {
			return $new_instance;
	}
	
	function widget($args, $instance) {
		global $post;
		$args['title'] = $instance['title'];
		$args['content'] = $instance['content'];
		echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
		
		if(isset($_SESSION['errors'])){
			echo '<p class="black helvetica uppercase">'.$_SESSION['errors'].'</p>';
			$_SESSION['errors'] = NULL;
			unset($_SESSION['errors']);
		}
		if($args['content']){
			echo '<p class="black helvetica uppercase">'.$args['content'].'</p>';
		}
		echo '<form action="'. site_url('wp-login.php?action=lostpassword').'" method="post">';
        echo '<input type="text" name="user_login" value="abc123@example.com" rel="abc123@example.com" />';
        echo '<input type="submit" value="Get a new password" class="helvetica orange-btn uppercase" name="recover_password" />';
		echo '<input type="hidden" name="redirect_to" value="'.site_url($post->ID).'" />';
		echo '<input type="hidden" name="instance" value="1" />';
		echo '</form>';
		echo $args['after_widget'];
	}
}

register_widget('Recover_Password');



?>