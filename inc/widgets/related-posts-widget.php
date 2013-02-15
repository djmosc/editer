<?php 

class Related_Posts extends WP_Widget {
	
	function Related_Posts() {
		$widget_opts = array( 'description' => __('Use this widget to show posts related to a certain post.') );
		parent::WP_Widget(false, 'Related Posts', $widget_opts);
	}
	
	function form($instance) {
		
		$title = (isset($instance['title'])) ? esc_attr($instance['title']) : '';  
        echo '<p><label>';
		echo _e('Title:').'<input class="widefat" name="'. $this->get_field_name('title').'" type="text" value="'. $title.'" />';
        echo '</label></p>';
		
	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		global $post;
		$args['title'] = $instance['title'];
		echo $args['before_widget'] . '<h5 class="thick-border-bottom black uppercase novecento-bold small title text-center">' . $args['title'] . '</h5>';
		
		$tags = wp_get_post_tags($post->ID);  
		if ($tags) {  
			$tag_ids = array();  
			foreach($tags as $individual_tag) {
				$tag_ids[] = $individual_tag->term_id;
			}
		}
		if(isset($tags__ids)){
			$args = array(  
				'tag__in' => $tag_ids,  
				'post__not_in' => array($post->ID),  
				'showposts' => 3,  // Number of related posts that will be shown.  
				'caller_get_posts'=>1  
			);
		}
		$custom_query = new WP_Query($args);
		?>

		<?php if ( $custom_query->have_posts() ) : ?>
        <?php
        $i = 0;
        while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
        ?>
		<div class="post">
			<div class="thumbnail featured-image">
				<a href="<?php the_permalink();?>">
					<?php 
					$image_id = get_post_thumbnail_id(get_the_ID());
					$image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
					?>
					<img src="<?php echo $image[0]?>" />
				</a>
				<?php get_template_part( 'inc/category'); ?>
			</div>
			<div class="post-meta">
				<p class="tiny italic light-grey text-center"><?php the_time(get_option('date_format')); ?></p>
				<hr />
				<h5 class="title text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
				<p class="excerpt arial small text-center dark-grey"><?php echo get_the_excerpt(); ?></p>
			</div>
		</div>
        <?php
        $i++;
        endwhile;
        ?>
        <?php else: ?>
        <p>No posts found</p>
        <?php endif; ?>
<?php 	echo $args['after_widget'];
	}
}

register_widget('Related_Posts');

?>