<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>
<section id="front-page" class="clearfix">


<?php 
	$carousel_ary = array('', '', '', '', '');
	
	$posts_query = new WP_Query( array('posts_per_page' => 3, 'post_type' => array('post'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 3, 'category__not_in' => array(get_editer_option('hts_category_id'))));
	$posts_position_ary = array(0, 2, 4);
	$ads_query = new WP_Query( array('posts_per_page' => 2, 'post_type' => array('ad'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 2, 'orderby' => 'menu_order', 'order' => 'ASC' ));
	$ads_position_ary = array(1, 3);
	
	if ( $posts_query->have_posts() ) {
		$i = 0;
		while ( $posts_query->have_posts() ) { 
			$posts_query->the_post();
			$carousel_ary[$posts_position_ary[$i]] = $post;
			$i++;
		}
	}

	if ( $ads_query->have_posts() ) {
		$i = 0;
		while ( $ads_query->have_posts() ) { 
			$ads_query->the_post();
			if($post){
				$carousel_ary[$ads_position_ary[$i]] = $post;
			}
			$i++;
		}
	}

	if ( !empty($carousel_ary) ) :

	?>
	<div id="homepage-scroller" class="scroller">
		<div class="scroller-mask">
			<?php foreach($carousel_ary as $post) :?>
				<?php if ($post): ?>
				<?php $url = ($post->post_type == 'post' || $post->post_type == 'product') ? get_permalink($post->ID) : get_post_meta($post->ID, 'external_url', true); ?>
				<div class="scroll-item" data-id="<?php echo $post->ID;?>">
					<div class="post">
			        	<div class="thumbnail featured-image">
			        		<a href="<?php echo $url;?>" <?php if(get_post_meta($post->ID, 'new_tab', true)) echo 'target="_blank"'; ?>>
			        			<?php 
			        			$image_id = get_post_meta($post->ID, 'homepage_image_id', true); 
			        			if(!$image_id) $image_id = get_post_thumbnail_id($post->ID);
			        			echo wp_get_attachment_image($image_id, 'custom_large', false, array('title' => get_the_title())); ?>
			        		</a>
			        		<?php if($post->post_type == 'post') : ?>
			        		<?php get_template_part( 'inc/category'); ?>
				        	<?php endif; ?>
			        	</div>
			        	<div class="post-meta">
				        	<?php if($post->post_type == 'post') : ?>
				        	<p class="date light-grey italic small text-center"><?php echo get_the_time(get_option('date_format'), $post->ID); ?></p>
			        		<hr />
			        		<?php endif; ?>
			        		<h1 class="title text-center uppercase"><a href="<?php echo $url;?>" <?php if($post->post_type == 'ad') echo 'target="_blank"'; ?>><?php echo get_the_title($post->ID);?></a></h1>
			            	<p class="excerpt arial small text-center dark-grey"><?php echo $post->post_excerpt; ?></p>
			            </div>
		            </div>
				</div>
				<?php endif ?>
			<?php endforeach; ?>
		</div>
		<div class="scroller-navigation">
			<a class="prev-btn"></a>
			<a class="next-btn"></a>
		</div>
	</div><!-- #homepage-scroller -->
	<?php endif; ?>



	<div id="homepage-sidebar" class="widget-area two span alpha omega">
		<?php dynamic_sidebar( 'homepage' ); ?>
	</div>
	<div id="content" class="span five alpha omega">
		<?php dynamic_sidebar( 'homepage_content' ); ?>
	</div><!-- #content -->
	<?php get_sidebar(); ?>
</section><!-- #front-page -->

<?php get_template_part('inc/editors'); ?>

<?php get_footer(); ?>