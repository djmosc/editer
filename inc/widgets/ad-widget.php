<?php 

class Ad extends WP_Widget {
	
	function Ad() {
		$widget_opts = array( 'description' => __('Use this widget is to show a Ad.') );
		parent::WP_Widget(false, 'Ad', $widget_opts);
	}
	function form($instance) {
		
		    $title = (isset($instance['title'])) ? esc_attr($instance['title']) : '';  
        $post_id = (isset($instance['postid'])) ? esc_attr($instance['postid']) : '';
      
        echo '<p><label>';
		    echo _e('Title:').'<input class="widefat" name="'. $this->get_field_name('title').'" type="text" value="'. $title.'" />';
        echo '</label></p>';
		

		  $custom_query = new WP_Query( array('posts_per_page' => -1, 'no_found_rows' => true, 'post_type' => array('ad'), 'post_status' => 'publish', 'ignore_sticky_posts' => true)); 
    
        echo '<p>';
        if ( $custom_query->have_posts() ) :
        echo '<label>'._('Ad:').'<br />';
        echo '<select name="'.$this->get_field_name('postid').'" style="width: 220px;">';
        echo '<option value="">--None--</option>';
       	while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
       	echo '<option value="'.get_the_ID().'" ';
       	if(get_the_ID() == $post_id){
       		echo 'selected';
       	}
       	echo '>'.get_the_title().'</option>';
        endwhile;
        echo '</select></label>';
        endif;
        echo '</p>';
        echo '<p>';
        echo '<label>'._('Featured:');
        echo ' <input class="checkbox" value="1" type="checkbox" id="'.$this->get_field_id( 'featured' ).'" name="'. $this->get_field_name('featured').'" ';
        echo ($instance['featured']  == 1) ?'checked="checked"':'';
        echo ' /></label>';
        echo '</p>';
	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		$args['title'] = $instance['title'];
		$args['postid'] = $instance['postid'];
    $args['featured'] = (isset($instance['featured'])) ? $instance['featured'] : 0;
		echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
		$options = array('posts_per_page' => 1, 'no_found_rows' => true, 'post_type' => array('ad'), 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'p' => $args['postid']);
		$custom_query = new WP_Query($options);
		
		if ( $custom_query->have_posts() ) : ?>
			<?php
            $i = 0;
            while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
            ?>
           	<?php if($args['featured']) : ?>
           		<div class="bracket top bottom">
           		<div class="mask">
           		<div class="inner">
           	<?php endif; ?>
            <div class="post">
	        	<div class="thumbnail featured-image">
	        		<a href="<?php echo get_post_meta(get_the_ID(), 'external_url', true);?>" <?php if(get_post_meta($post->ID, 'new_tab', true)) echo 'target="_blank"'; ?>>
                <?php 
                $image_id = get_post_thumbnail_id(get_the_ID());
                $image = wp_get_attachment_image_src( $image_id, 'custom_thumbnail' );
                ?>
                <img src="<?php echo $image[0]?>" <?php if($args['featured']) echo 'width="188"'; ?> />
              </a>
	        	</div>
            <?php if(!$args['featured']) : ?>
          <?php endif; ?>
            	<!-- <h5 class="title text-center uppercase"><a href="<?php echo get_post_meta(get_the_ID(), 'external_url', true);?>"><?php the_title();?></a></h5>
            	<p class="excerpt arial small text-center dark-grey"><?php echo get_the_excerpt(); ?></p> -->
            </div>
            <?php if($args['featured']) :?>
           		</div>
           		</div>
           		</div>
           	<?php endif; ?>
            <?php
            $i++;
            endwhile;
            ?>
        <?php else: ?>
        <p>No post found</p>
        <?php endif; ?>
<?php 	echo $args['after_widget'];
	}
}

register_widget('Ad');



?>
