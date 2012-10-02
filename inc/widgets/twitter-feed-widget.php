<?php 

class Twitter_Feed extends WP_Widget {
	
	function Twitter_Feed() {
		$widget_opts = array( 'description' => __('Use this widget is to show the tweets of a specific user.') );
		parent::WP_Widget(false, 'Twitter Feed', $widget_opts);
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
	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		$args['title'] = $instance['title'];
		
		$args['username'] = (isset($instance['username'])) ? $instance['username'] : 'editerdotcom';
		echo $args['before_widget'] . '<h5 class="thick-border-bottom black uppercase novecento-bold small title">' . $args['title'] . '</h5>';
		?>
        <script>
        	$(function(){
        		var url='http://api.twitter.com/1/statuses/user_timeline.json?count=4&screen_name=<?php echo $args['username']; ?>&callback=?';
				$.getJSON(url,function(tweets){

					var output = [];

					for (i in tweets) {
						var tweet = tweets[i];
						output.push('<li class="tweet">'+
										'<div class="tweet-text arial small">'+tweet.text+'</div>'+
										'<div class="clearfix">'+
											'<div class="tweet-authorphoto left">'+
												'<img width="36" src="'+tweet.user.profile_image_url +'" alt="'+''+'">'+
											'</div>'+
											'<div class="tweet-meta right">'+
												'<span class="tweet-time tiny grey arial">6 days ago by </span><br />'+
												'<a class="tweet-author tiny red arial bold" href="http://twitter.com/'+tweet.user.screen_name+'">'+tweet.user.screen_name+'</a>'+
											'</div>'+
										'</div>'+
									'</li>');
					}

					$("#twitter-feed").html(output.join(''));
				});
        	})
        </script>
        <ul id="twitter-feed">
	        	
        </ul>
            
		<?php echo $args['after_widget'];
	}
}

register_widget('Twitter_Feed');



?>
