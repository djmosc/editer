<?php 

class Recent_Posts extends WP_Widget {
	
	function Recent_Posts() {
		parent::WP_Widget(false, 'Recent_Posts');
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
		$args['title'] = $instance['title'];
		echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
		$custom_query = new WP_Query( array('posts_per_page' => 3, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
?>

		 <?php if ( $custom_query->have_posts() ) : ?>
        <ul>
            <?php
            $i = 0;
            while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
            ?>
            <li class="border-bottom">
            	<p class="date light-grey no-margin"><?php the_date();?>
                <h3 class="title no-margin"><a href="<?php the_permalink();?>" class="century-schoolbook-italic purple"><?php the_title();?></a></h3>
                <p class="author no-margin italic">Posted by <?php the_author_posts_link() ?><?php echo (get_the_author_meta('company_position')) ? ', '.get_the_author_meta('company_position'):'';?></p>
                
            </li>
            <?php
            $i++;
            endwhile;
            ?>
        </ul>
        <?php else: ?>
        <p>No posts found</p>
        <?php endif; ?>
<?php 	echo $args['after_widget'];
	}
}

register_widget('Recent_Posts');
?>