<?php 

class Editor extends WP_Widget {
	
	function Editor() {
		$widget_opts = array( 'description' => __('Use this widget is to show a random editor within a category.') );
		parent::WP_Widget(false, 'Editor', $widget_opts);
	}
	
	function widget($args, $instance) {
		global $post;
		$size = ($args['id'] == 'homepage_content' || $args['id'] == 'category_content') ? 'large' : 'small';
		$category = get_top_level_category(get_query_var('cat'));
		$custom_query = new WP_Query(array(
			'post_type' => array('editor'), 
			'meta_query' => array(
				array(
					'key' => 'category_id',
					'value' => $category->slug
				)
			),
			'posts_per_page' => 1, 
			'limit' => 1,
			'orderby' => 'rand'
		));
		if ( $custom_query->have_posts() && 1 == 1) :
			echo $args['before_widget'];
		?>
			<header class="header">
				<h4 class="title novecento-demibold uppercase"><a href=""><?php _e("Meet Our Stylemakers") ?></a></h4>
			</header>
			<?php $i = 0; ?>
			<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
				<div class="post editor">
					<div class="featured-image thumbnail">
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
						<h3 class="title text-center no-margin"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
						<p class="excerpt arial small text-center avenir dark-grey"><?php echo get_the_excerpt(); ?></p>
					</div>
					<footer class="footer">
						<p class="text-center no-margin"><a href="<?php the_permalink(); ?>" class="red-btn"><?php printf( __('See  %s&#39;s Edits', 'editer'),  get_the_title()); ?></a></p>
					</footer>
				</div>
			<?php 
			endwhile;
			wp_reset_postdata();
			echo $args['after_widget'];
		endif;
	}
}

register_widget('Editor');