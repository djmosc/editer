<?php 

class Weekly_Edit extends WP_Widget {
	
	function Weekly_Edit() {
		$widget_opts = array( 'description' => __('Use this widget is to show some content with  "The Weekly Edit" title.') );
		parent::WP_Widget(false, 'Weekly Edit', $widget_opts);
	}
	function form($instance) {
		
		$text = (isset($instance['text'])) ? esc_attr($instance['text']) : '';  
     
		echo '<p><label>';
		echo '<textarea class="widefat" rows="16" columns="20" name="'. $this->get_field_name('text').'" >'. $text.'</textarea>';
        echo '</label></p>';
		
	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		$args['text'] = $instance['text'];
		echo $args['before_widget'];
		?>
        
        <div class="bracket top bottom">
			<div class="mask">
				<div class="inner">
					<h3 class="title uppercase no-margin">The<br /> Weekly <span class="italic red">Edit</span></h3>
					<?php echo do_shortcode($args['text']); ?>
				</div>
			</div>
		</div>
            
		<?php echo $args['after_widget'];
	}
}

register_widget('Weekly_Edit');

