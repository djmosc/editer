<?php 

class Tumblr extends WP_Widget {
	
	function Tumblr() {
		$widget_opts = array( 'description' => __('Use this widget is to show the post from the ID specified in the custom post field.') );
		parent::WP_Widget(false, 'Tumblr', $widget_opts);
	}
	function form($instance) {
		
		$title = esc_attr($instance['title']);  
        echo '<p><label for="'.$this->get_field_id('title').'">';
		echo _e('Title:').'<input class="widefat" id="'. $this->get_field_id('title').'" name="'. $this->get_field_name('title').'" type="text" value="'. $title.'" />';
        echo '</label></p>';
		
	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		global $post;
		$args['title'] = $instance['title'];
		$tumblr_post_id = get_post_meta($post->ID, 'tumblr_post_id', true);
		if(!empty($tumblr_post_id)){
			$tumblr_post_ids = explode(',', trim($tumblr_post_id));
			$tumblr_post_urls = array();
			foreach($tumblr_post_ids as $id){
				array_push($tumblr_post_urls, str_replace(array('\r\n', '\r', '\n', ' '), '', 'http://api.tumblr.com/v2/blog/editerdotcom.tumblr.com/posts/?api_key=3Ok9pty4LAj6fH7iyVl7gKmFlG8hhGFHno33ACSJ1k1zpC6lpr&id='.$id));
			}
			
			$tumblr_post_requests = $this->multiple_threads_request($tumblr_post_urls);
			echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
			foreach($tumblr_post_requests as $tumblr_post_request){
				$tumblr_post_request = json_decode($tumblr_post_request);
				
				if($tumblr_post_request->meta->status == 200){
					$tumblr_post = $tumblr_post_request->response->posts[0];
			?>
        		<div class="tumblr-post">
		        	<a href="<?php echo $tumblr_post->post_url; ?>" target="_blank" class="thumbnail">
			        	<img src="<?php echo $tumblr_post->photos[0]->alt_sizes[3]->url; ?>"/>
					</a>
		        </div>
			<?php
				}
	    	}
	    	?>
			<p class="text-right tiny">
				<a href="http://editerdotcom.tumblr.com/" target="_blank" class="arial red"><?php _e("Visit Behind the Scenes", 'editer'); ?> &raquo;</a>
			</p>
			<?php echo $args['after_widget'];
    	}
	}

	function multiple_threads_request($nodes){ 
		$mh = curl_multi_init();
		$curl_array = array();
		foreach($nodes as $i => $url) { 
			$curl_array[$i] = curl_init($url); 
			curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true); 
			curl_multi_add_handle($mh, $curl_array[$i]); 
		} 
		$running = NULL; 
		do { 
			usleep(10000); 
			curl_multi_exec($mh,$running); 
		} while($running > 0); 

		$res = array();
		foreach($nodes as $i => $url) { 
			$res[$url] = curl_multi_getcontent($curl_array[$i]); 
		} 

		foreach($nodes as $i => $url){ 
			curl_multi_remove_handle($mh, $curl_array[$i]); 
		} 
		curl_multi_close($mh);        
		return $res; 
	} 
}

register_widget('Tumblr');