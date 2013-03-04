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
	$custom_query = new WP_Query( array('posts_per_page' => -1, 'post_type' => array('slide'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => -1, 'orderby' => 'menu_order', 'order' => 'ASC'));
	if ( $custom_query->have_posts() && 1 == 1) :
	?>
	<div id="homepage-scroller" class="scroller" data-scroll-all="true">
		<div class="scroller-mask">
			<div class="scroll-items-container">
				<?php $i = 0; ?>
				<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
				<?php 
					$slide = $post;
					if(get_field('use_post', $slide->ID)){
						$related_post = (get_field('post', $slide->ID)) ? get_field('post', $slide->ID) : get_latest_post();
						setup_postdata($related_post);
						$post = $related_post;
					}
					$url = ( get_field('external_url', $post->ID) ) ? get_field('external_url', $post->ID) : get_permalink($post->ID);
				?>
				<div class="scroll-item <?php if($i == 0) echo 'current'; ?> <?php the_field('image_type', $slide->ID); ?>" data-id="<?php echo $slide->ID;?>">
					<div class="post">
						<?php if(( get_field('use_post', $slide->ID) ) && date('Ymd', strtotime($post->post_date)) == date('Ymd')): ?>
						<span class="todays-edit ribbon description"><?php _e("Today's Edit", 'editer') ?></span>
						<?php endif; ?>
			        	<div class="thumbnail featured-image">
			        		<!-- <a href="<?php echo $url;?>" <?php if(get_field('external_url')) echo 'target="_blank"'; ?>> -->
			        			<?php 
			        			$image_id = get_post_thumbnail_id($post->ID);
			        			echo wp_get_attachment_image($image_id, 'slide', false, array('title' => ''));
			        			?>
			        		<!-- </a> -->
		        		</div>
			        	<div class="content description <?php the_field('content_alignment', $slide->ID); ?>" style="<?php the_field('content_styles', $slide->ID); ?>">
				        	<?php if($slide->post_content != ''): ?>
				        		<?php echo $slide->post_content; ?>
				        	<?php else: ?>
					        	<?php if($post->post_type == 'post') : ?>
				        		<?php get_template_part( 'inc/category'); ?>
					        	<?php endif; ?>
				        		<header class="header">
					        		<h1 class="title uppercase"><a href="<?php echo $url;?>" <?php if(get_field('external_url', $post->ID)) echo 'target="_blank"'; ?>><?php echo the_title();?></a></h1>
					            	<!-- <p class="date italic small"><?php echo get_the_time(get_option('date_format'), $post->ID); ?></p> -->
					        		<p class="author didot-italic small">with <?php the_author(); ?></p>
					        	</header>
					        	<div class="post-content">
				        			<p class="excerpt avenir small"><?php echo get_the_excerpt();; ?></p>
					        		<p><a href="<?php echo $url; ?>" <?php if(get_field('external_url', $post->ID)) echo 'target="_blank"'; ?> class="red-btn"><?php _e("Read More", 'editer'); ?></a>
			            		</div>
			            	<?php endif; ?>
			            </div>
		            </div>
		            <div class="overlay"></div>
				</div>
				<?php $i++; ?>
				<?php endwhile; ?>
			</div>
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