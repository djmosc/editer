<?php 

class Pinterest extends WP_Widget {
	
	function Pinterest() {
		$widget_opts = array( 'description' => __('Use this widget is to show the latest pin of a specific user.') );
		parent::WP_Widget(false, 'Pinterest', $widget_opts);
	}
	function form($instance) {
		
		$title = (isset($instance['title'])) ? esc_attr($instance['title']) : '';  
        echo '<p><label>';
		echo _e('Title:').'<input class="widefat" name="'. $this->get_field_name('title').'" type="text" value="'. $title.'" />';
        echo '</label></p>';

		$username = (isset($instance['username'])) ? esc_attr($instance['username']) : '';  
  		echo '<p><label>';
		echo _e('Username:').'<input class="widefat" name="'. $this->get_field_name('username').'" type="text" value="'. $username.'" />';
  		echo '</label></p>';

		// $pin_id = (isset($instance['pin_id'])) ? esc_attr($instance['pin_id']) : '';  
		// echo '<p><label>';
		// echo _e('Pin ID:').'<input class="widefat" name="'. $this->get_field_name('pin_id').'" type="text" value="'. $pin_id.'" />';
  		// echo '</label></p>';
	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		$args['title'] = $instance['title'];
		
		$args['username'] = (isset($instance['username'])) ? $instance['username'] : 'editerdotcom';
		echo $args['before_widget'] . '<div class="border">';
		echo '<h5 class="text-center uppercase avenir-bold small widget-title border-bottom"><span class="pin"></span><a href="http://www.pinterest.com/'.$args['username'].'" class="black" target="_blank">' . $args['title'] . '</a></h5>';
		
		$data = file_get_contents('http://pinterestapi.co.uk/jwmoz/pins');
		$json = json_decode($data);
		if(!empty($json)){
		?>
		<div id="pinterest">
	    	<ul>
			<?php
				$pins = array_slice($json->body, 0, 1);
				foreach($pins as $pin){
			?>
				<li class="pin">
					<a href="<?php echo $pin->href; ?>">
						<img src="<?php echo $pin->src ?>" class="scale" />
					</a>
				</li>
			<?php
				}
			}
			?>
			</ul>
		</div>
		<?php echo '</div>'.$args['after_widget'];
	}
}

register_widget('Pinterest');



?>
