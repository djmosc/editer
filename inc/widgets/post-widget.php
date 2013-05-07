<?php 

class Post extends WP_Widget {

    function Post() {
        $widget_opts = array( 'description' => __('Use this widget is to show a post by it\'s position or by it\'s name.') );
        parent::WP_Widget(false, 'Post', $widget_opts);
    }

    function form($instance) {
        $offset = (isset($instance['offset'])) ? esc_attr($instance['offset']) : '';
        $category_id = (isset($instance['category_id'])) ? esc_attr($instance['category_id']) : '';
        $post_id = (isset($instance['postid'])) ? esc_attr($instance['postid']) : '';
        $custom_query = new WP_Query( array('posts_per_page' => -1, 'no_found_rows' => true, 'post_type' => array('post'), 'post_status' => 'publish', 'ignore_sticky_posts' => true)); 
        echo '<p><label>';
        echo _('Position:').'&nbsp;&nbsp;<input class="widefat" style="width: 20px;" name="'. $this->get_field_name('offset').'" type="text" value="'. $offset.'" />';
        echo '</label></p>';
        echo '<p><label>';
        echo _('In category:').'&nbsp;&nbsp;';
        wp_dropdown_categories(array('hierarchical' => true, 'selected' => $category_id, 'show_option_none' => 'Current', 'show_option_all' => 'All', 'name' => $this->get_field_name('category_id')));
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

        echo '<p><label>'._('Featured:');
        echo ' <input class="checkbox" value="1" type="checkbox" id="'.$this->get_field_id( 'featured' ).'" name="'. $this->get_field_name('featured').'" ';
        echo (isset($instance['featured']) && $instance['featured']  == 1) ?'checked="checked"':'';
        echo ' /></label></p>';
       
    }

    function update($new_instance, $old_instance){
        return $new_instance;
    }

    function widget($args, $instance) {
        global $post;
        $size = ($args['id'] == 'homepage_content' || $args['id'] == 'category_content' || $args['id'] == 'shop_content') ? 'large' : 'small';
        $args['offset'] = ($instance['offset']) ? $instance['offset'] : 1;
        $args['category_id'] = (isset($instance['category_id']) && $instance['category_id'] != 0) ? $instance['category_id'] : -1;
        if(is_category()){
            $category = get_top_level_category(get_query_var('cat'));
            if($instance['category_id'] == 0){
                $args['category_id'] = $category->term_id;
            } else if($instance['category_id'] == -1){
                $args['category_id'] = get_query_var('cat');
            }
        }
        $args['postid'] = $instance['postid'];
        $args['featured'] = (isset($instance['featured'])) ? $instance['featured'] : 0;

        echo $args['before_widget'];
        $options = array('posts_per_page' => 1, 'no_found_rows' => true, 'post_type' => array('post'), 'post_status' => 'publish', 'ignore_sticky_posts' => true);
        if($args['postid']){
            $options['p'] = $args['postid'];
        } else {
            $options['offset'] = intval($args['offset']) - 1;
            // $options['category__not_in'] = array(exclude categoroy);
            $options['category__in'] = array($args['category_id']);
        }
        
        $custom_query = new WP_Query($options);
        if ( $custom_query->have_posts() ) : ?>
            <?php
            $i = 0;
            while ( $custom_query->have_posts() ) : $custom_query->the_post();
                $editor = get_the_editor($post->post_author); 
            ?>
                <div class="post border <?php if( $args['featured'] ) echo 'featured'; ?> <?php echo $size; ?>">
                    <?php if( $args['featured'] &&  is_category()): ?>
                    <span class="ribbon"><?php _e("Latest Feature", 'editer'); ?></span>
                    <?php endif; ?>
                    <div class="thumbnail featured-image">
                        <a href="<?php the_permalink();?>">
                            <?php
                            $thumbnail_size = 'thumbnail';
                            if($size == 'large'){
                                $thumbnail_size = 'medium';
                            }

                            $image_id = get_post_thumbnail_id(get_the_ID());
                            $image = wp_get_attachment_image_src( $image_id, $thumbnail_size );
                            ?>
                            <img src="<?php echo $image[0]?>" class="scale" />
                        </a>
                    </div>
                    <div class="post-meta">
                        <?php get_template_part( 'inc/category'); ?>
                        <?php if($size == 'small'): ?>
                        <hr />
                        <h4 class="title text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                        <?php else: ?>
                        <h1 class="title text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h1>
                        <?php endif; ?>
                        <p class="excerpt arial small text-center avenir dark-grey"><?php echo get_the_excerpt(); ?></p>
                        <?php if($editor): ?>
                        <p class="author didot-italic small text-center grey"><?php _e("with", 'editer'); ?> <a href="<?php echo get_permalink($editor->ID); ?>" class="dark-grey"><?php the_author(); ?></a></p>
                        <?php endif; ?>
                    </div>
                    <footer class="footer <?php echo ($size == 'small') ? 'border-top' : 'striped-border top'?>">
                        <div class="inner clearfix">
                            <div class="span five alpha omega">
                                <?php if(!$args['featured']): ?>
                                <span class="tiny light-grey text-center date"><?php the_time(get_option('date_format')); ?></span>
                               <?php endif; ?>
                            </div>
                            <div class="span five alpha omega">
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
            wp_reset_query();
            ?>
        <?php endif; ?>
        <?php 	echo $args['after_widget'];
    }
}

register_widget('Post');
?>