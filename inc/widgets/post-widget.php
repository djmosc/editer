<?php 

class Post extends WP_Widget {

    function Post() {
        $widget_opts = array( 'description' => __('Use this widget is to show a post by it\'s position or by it\'s name.') );
        parent::WP_Widget(false, 'Post', $widget_opts);
    }

    function form($instance) {
        $offset = (isset($instance['offset'])) ? esc_attr($instance['offset']) : '';
        $post_id = (isset($instance['postid'])) ? esc_attr($instance['postid']) : '';
        $custom_query = new WP_Query( array('posts_per_page' => -1, 'no_found_rows' => true, 'post_type' => array('post'), 'post_status' => 'publish', 'ignore_sticky_posts' => true)); 
        echo '<p><label>';
        echo _('Position:').'&nbsp;&nbsp;<input class="widefat" style="width: 20px;" name="'. $this->get_field_name('offset').'" type="text" value="'. $offset.'" />';
        echo '</label></p>';

        echo '<p>';
        if ( $custom_query->have_posts() ) :
            echo ' '. _('or').' <label>'._('Post:');
            echo '&nbsp;&nbsp;<select name="'.$this->get_field_name('postid').'" style="width: 170px;">';
            echo '<option value="">--None--</option>';
            while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
                echo '<option value="'.get_the_ID().'" ';
                if(get_the_ID() == $post_id) echo 'selected';
                echo '>'.get_the_title().'</option>';
            endwhile;
            echo '</select></label>';
        endif;
        echo '</p>';
       
    }

    function update($new_instance, $old_instance){
        return $new_instance;
    }

    function widget($args, $instance) {
        global $post;
        $args['offset'] = $instance['offset'];
        $args['postid'] = $instance['postid'];
        
        echo $args['before_widget'];
        $options = array('posts_per_page' => 1, 'no_found_rows' => true, 'post_type' => array('post'), 'post_status' => 'publish', 'ignore_sticky_posts' => true);
        if($args['postid']){
            $options['p'] = $args['postid'];
        } else {
            $options['offset'] = intval($args['offset']) - 1;
            $options['category__not_in'] = array(47);
        }
    
        $custom_query = new WP_Query($options);
        if ( $custom_query->have_posts() ) : ?>
            <?php
            $i = 0;
            while ( $custom_query->have_posts() ) : $custom_query->the_post();
                $editor = get_the_editor($post->post_author); 
            ?>
                <div class="post border">
                    <div class="thumbnail featured-image">
                        <a href="<?php the_permalink();?>">
                            <?php
                            $image_id = get_post_thumbnail_id(get_the_ID());
                            $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
                            ?>
                            <img src="<?php echo $image[0]?>" class="scale" />
                        </a>
                    </div>
                    <div class="post-meta">
                        <?php get_template_part( 'inc/category'); ?>
                        <hr />
                        <h4 class="title text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                        <p class="excerpt arial small text-center avenir dark-grey"><?php echo get_the_excerpt(); ?></p>
                        <?php if($editor): ?>
                        <p class="author italic tiny text-center grey"><?php _e("With", 'editer'); ?> <a href="<?php echo get_permalink($editor->ID); ?>" class="dark-grey"><?php the_author(); ?></a></p>
                        <?php endif; ?>
                    </div>
                    <footer class="footer border-top">
                        <div class="inner clearfix">
                            <div class="span five omega">
                                <span class="tiny light-grey text-center"><?php the_time(get_option('date_format')); ?></span>
                            </div>
                            <div class="span five alpha">
                                <p class="no-margin text-right">
                                    <a href="<?php the_permalink(); ?>" class="red-btn read-more-btn"><?php _e("Read More", 'editer'); ?></a>
                                </p>
                            </div>
                        </div>
                    </footer>
                </div>
            <?php
            $i++;
            endwhile;
            wp_reset_postdata();
            ?>
        <?php else: ?>
        <p>No post found</p>
        <?php endif; ?>
        <?php 	echo $args['after_widget'];
    }
}

register_widget('Post');
?>