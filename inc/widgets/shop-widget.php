<?php 

class Shop extends WP_Widget {

    function Shop() {
        $widget_opts = array( 'description' => __('Use this widget is to show a Shop by it\'s position or by it\'s name.') );
        parent::WP_Widget(false, 'Shop', $widget_opts);
    }

    function form($instance) {
        $offset = (isset($instance['offset'])) ? esc_attr($instance['offset']) : '';
        $term_id = (isset($instance['term_id'])) ? esc_attr($instance['term_id']) : '';
        $post_id = (isset($instance['postid'])) ? esc_attr($instance['postid']) : '';
        $style = (isset($instance['style'])) ? esc_attr($instance['style']) : '';
        $custom_query = new WP_Query( array('posts_per_page' => -1, 'no_found_rows' => true, 'post_type' => array('shop'), 'post_status' => 'publish', 'ignore_sticky_posts' => true)); 
        echo '<p><label>';
        echo _('Position:').'&nbsp;&nbsp;<input class="widefat" style="width: 20px;" name="'. $this->get_field_name('offset').'" type="text" value="'. $offset.'" />';
        echo '</label></p>';
        echo '<p><label>';
        echo _('In category:').'&nbsp;&nbsp;';
        wp_dropdown_categories(array('hierarchical' => true, 'selected' => $term_id, 'show_option_none' => 'Current', 'show_option_all' => 'All', 'name' => $this->get_field_name('term_id'), 'taxonomy' => 'shop_category'));
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
        $styles = array(1, 2, 3, 4, 5);
        echo '<p><label>'._('Style:');
        echo '&nbsp;&nbsp;<select name="'.$this->get_field_name('style').'" style="width: 170px;">';
            foreach($styles as $a_style){
                 echo '<option value="'.$a_style.'" ';
                 if($a_style == $style) echo 'selected';
                 echo '>'.$a_style.'</option>';
            }
            echo '</select>';
        echo '</label></p>';
       
    }

    function update($new_instance, $old_instance){
        return $new_instance;
    }

    function widget($args, $instance) {
        global $post;
        $size = ($args['id'] == 'homepage_content' || $args['id'] == 'category_content') ? 'large' : 'small';
        $args['offset'] = ($instance['offset']) ? $instance['offset'] : 1;
        $args['term_id'] = (isset($instance['term_id']) && $instance['term_id'] != 0) ? $instance['term_id'] : -1;
        if(is_category()){
            $category = get_top_level_category(get_query_var('cat'));
            if($instance['term_id'] == 0){
                $args['term_id'] = $category->term_id;
            } else if($instance['term_id'] == -1){
                $args['term_id'] = get_query_var('cat');
            }
        }

        $args['postid'] = $instance['postid'];
        $args['style'] = $instance['style'];
        
        echo $args['before_widget'];
        $options = array('posts_per_page' => 1, 'no_found_rows' => true, 'post_type' => array('shop'), 'post_status' => 'publish', 'ignore_sticky_posts' => true);
        if($args['postid']){
            $options['p'] = $args['postid'];
        } else {
            $options['offset'] = intval($args['offset']) - 1;
            // $options['category__not_in'] = array(exclude category);
            if($args['term_id'] != 0 && $args['term_id'] != -1){

                $options['tax_query'] = array(
                    array(
                        'taxonomy' => 'shop_category',
                        'field' => 'ID',
                        'terms' => $args['term_id']
                    )
                );
            }
        }
        $custom_query = new WP_Query($options);
        if ( $custom_query->have_posts() ) : ?>
            <?php
            $i = 0;
            while ( $custom_query->have_posts() ) : $custom_query->the_post();
                
                $categories = get_the_terms($post->ID, 'shop_category');
                $categories = array_slice($categories, 0, 1);
                $category = get_top_level_category($categories[0]->term_id, 'shop_category');
                $thumbnail_size = 'thumbnail';
                if($size == 'large'){
                    $thumbnail_size = 'medium';
                }
                $image_id = get_post_thumbnail_id(get_the_ID());
                $image = wp_get_attachment_image_src( $image_id, $thumbnail_size );
                            
                switch($args['style']):
                    case 2: 
            ?>
                <div class="post shop style-2 <?php echo $size; ?>">
                    <div class="inner">
                        <?php 
                        if(isset($category)):
                            $category_image_id = get_field('image_id', 'shop_category_'.$category->term_id);

                            if($category_image_id):
                                $category_image = wp_get_attachment_image_src($category_image_id, 'full');
                            ?>
                        <div class="category-image text-center">
                            <a href="<?php echo get_term_link( $category->slug, 'shop_category' ); ?>">
                                <img src="<?php echo $category_image[0]; ?>" class="scale" />
                            </a>
                        </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="thumbnail featured-image">
                            <a href="<?php the_permalink();?>">
                                <img src="<?php echo $image[0]?>" class="scale" />
                            </a>
                        </div>
                        <div class="post-meta">
                            <p class="excerpt arial small text-center avenir dark-grey"><?php echo get_the_excerpt(); ?></p>
                        </div>
                        <footer class="footer">
                            <div class="inner clearfix">
                                <p class="no-margin text-right">
                                    <a href="<?php the_permalink(); ?>" class="black-btn see-more-btn"><?php _e("See More", 'editer'); ?></a>
                                </p>
                            </div>
                        </footer>
                    </div>
                </div>
                <?php break; ?>
            <?php case 3: ?>
                <div class="post shop style-3 <?php echo $size; ?>">
                    <div class="thumbnail featured-image">
                        <a href="<?php the_permalink();?>">
                            <img src="<?php echo $image[0]?>" class="scale" />
                        </a>
                    </div>
                    <div class="post-meta">
                        <?php if($size == 'small'): ?>
                        <h3 class="title didot-italic text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                        <?php else: ?>
                        <h1 class="title didot-italic text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h1>
                        <?php endif; ?>
                        <p class="excerpt arial small text-center avenir dark-grey"><?php echo get_the_excerpt(); ?></p>
                    </div>
                    <footer class="footer">
                        <div class="inner clearfix">
                            <p class="no-margin text-center">
                                <a href="<?php the_permalink(); ?>" class="red-btn read-more-btn"><?php _e("Read More", 'editer'); ?></a>
                            </p>
                        </div>
                    </footer>
                </div>
                <?php break; ?>
            <?php case 4: ?>
                <div class="post shop style-4 <?php echo $size; ?>">
                    <div class="inner">
                        <?php 
                        if(isset($category)):
                            $category_image_id = get_field('image_id', 'shop_category_'.$category->term_id);

                            if($category_image_id):
                                $category_image = wp_get_attachment_image_src($category_image_id, 'full');
                            ?>
                        <div class="category-image text-center">
                            <a href="<?php echo get_term_link( $category->slug, 'shop_category' ); ?>">
                                <img src="<?php echo $category_image[0]; ?>" class="scale" />
                            </a>
                        </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="thumbnail featured-image">
                            <a href="<?php the_permalink();?>">
                                <img src="<?php echo $image[0]?>" class="scale" />
                            </a>
                        </div>
                        <div class="post-meta">
                            <p class="small avenir grey text-center"><?php the_time(get_option('date_format')); ?></p>
                        </div>
                        <footer class="footer">
                            <div class="inner clearfix">
                                <p class="no-margin text-center">
                                    <a href="<?php the_permalink(); ?>" class="red-btn read-now-btn"><?php _e("Read Now", 'editer'); ?></a>
                                </p>
                            </div>
                        </footer>
                    </div>
                </div>
                <?php break; ?>

            <?php case 5: ?>
                <div class="post shop style-5 <?php echo $size; ?>">
                    <div class="inner">
                        <?php 
                        if(isset($category)):
                            $category_image_id = get_field('image_id', 'shop_category_'.$category->term_id);

                            if($category_image_id):
                                $category_image = wp_get_attachment_image_src($category_image_id, 'full');
                            ?>
                        <div class="category-image text-center">
                            <a href="<?php echo get_term_link( $category->slug, 'shop_category' ); ?>">
                                <img src="<?php echo $category_image[0]; ?>" class="scale" />
                            </a>
                        </div>
                             <?php endif; ?>
                        <?php endif; ?>
                        <div class="thumbnail featured-image">
                            <a href="<?php the_permalink();?>">
                                <img src="<?php echo $image[0]?>" class="scale" />
                            </a>
                        </div>
                        <div class="post-meta">
                            <p class="excerpt arial small text-center avenir dark-grey"><?php echo get_the_excerpt(); ?></p>
                        </div>
                        <footer class="footer">
                            <div class="inner clearfix">
                                <p class="no-margin text-center">
                                    <a href="<?php the_permalink(); ?>" class="red-btn read-now-btn"><?php _e("Read Now", 'editer'); ?></a>
                                </p>
                            </div>
                        </footer>
                    </div>
                </div>
                <?php break; ?>
            <?php default: ?>
                <div class="post style-1 border <?php echo $size; ?>">
                    <div class="thumbnail featured-image">
                        <a href="<?php the_permalink();?>">
                            <img src="<?php echo $image[0]?>" class="scale" />
                        </a>
                    </div>
                    <div class="post-meta">
                        <?php //get_template_part( 'inc/category'); ?>
                        <?php if($size == 'small'): ?>
                        <hr />
                        <h4 class="title text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                        <?php else: ?>
                        <h1 class="title text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h1>
                        <?php endif; ?>
                        <p class="excerpt arial small text-center avenir dark-grey"><?php echo get_the_excerpt(); ?></p>
                    </div>
                    <footer class="footer <?php echo ($size == 'small') ? 'border-top' : 'striped-border top'?>">
                        <div class="inner clearfix">
                            <div class="span five alpha omega">
                                <span class="tiny light-grey text-center"><?php the_time(get_option('date_format')); ?></span>
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
                endswitch;
            $i++;
            endwhile;
            wp_reset_postdata();
            wp_reset_query();
            ?>
        <?php endif; ?>
        <?php 	echo $args['after_widget'];
    }
}

register_widget('Shop');
?>