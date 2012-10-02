<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>

<section id="single-editor" class="content-area">
	<div id="editor-sidebar" class="widget-area five column alpha">
		<?php dynamic_sidebar( 'editor' ); ?>
	</div>
	<div id="content" class="eleven column push-one alpha omega">
	
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="editor-header">
					<h3 class="title didot-italic no-margin"><?php the_title(); ?></h3>
					<div class="social-links dotted-border">
						<div class="inner">
							<?php if(get_post_meta($post->ID, 'website_url', true)) :?>
							<a class="share-link-btn" href="<?php echo get_post_meta($post->ID, 'website_url', true); ?>" target="_blank"><?php echo get_post_meta($post->ID, 'website_url', true); ?></a>
							<?php endif; ?>
							<?php if(get_post_meta($post->ID, 'twitter_url', true)) :?>
							<a class="share-twitter-btn" href="http://www.twitter.com/<?php echo get_post_meta($post->ID, 'twitter_url', true); ?>" target="_blank"><?php echo get_post_meta($post->ID, 'twitter_url', true); ?></a>
							<?php endif; ?>
							<?php if(get_post_meta($post->ID, 'facebook_url', true)) :?>
							<a class="share-facebook-btn" href="<?php echo get_post_meta($post->ID, 'facebook_url', true); ?>" target="_blank"><?php _e('Facebook Profile'); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</header><!-- .entry-header -->

				<div class="editor-content">
					<?php the_post_thumbnail(array(484, 999));?>
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				
				<?php 
				$user_id = get_post_meta($post->ID, 'user_id', true);
				
				$custom_query = new WP_Query( array('author' => $user_id, 'post_type' => array('post'), 'post_status' => 'publish', 'limit' => -1));
				
				if ( $custom_query->have_posts() ) :
					$columns = array('one', 'two', 'three');
					$i = 0;
				?>
				<div class="editor-edits">
					<div class="navigation">
						<a class="grid-btn display-type-btn arial current" data-display-type="grid">Show as images</a>
						<a class="list-btn display-type-btn arial" data-display-type="list">Show as list</a>
					</div>
					<h5 class="novecento-bold small"><?php $user_info = get_userdata($user_id); echo $user_info->display_name; ?>'s Edits</h5>
					<ul class="posts clearfix grid" data-display-type="grid">
						<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
						<li class="post left <?php echo $columns[$i % 3];?>">
							<a href="<?php the_permalink(); ?>" class="overlay-btn">
								<div class="overlay semi-black-bg">
									<h5 class="title didot-italic text-center white"><?php the_title(); ?></h5>
								</div>
								<?php the_post_thumbnail(array('154', '999')); ?>
							</a>
						</li>
						<?php $i++; ?>
						<?php endwhile; ?>
					</ul>
					<ul class="posts hide list" data-display-type="list">
						<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
						<li class="post">
							
							<header class="post-header">
								<h4 class="no-margin"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
								<p class="date no-margin small black arial"><?php the_time(get_option('date_format')); ?></p>
							</header>
							<div class="post-excerpt">
								<p class="no-margin">...<?php echo substr(strip_tags(get_the_content($post->ID)), 0, 200); ?>...</p>
							</div>
						</li>
						<?php $i++; ?>
						<?php endwhile; ?>
					</ul>
				</div>
				<?php endif;?>
				<footer class="dotted-border">
					<div class="inner">
						<p class="text-center no-margin tiny">
							<a href="#" class="arial uppercase black">Back to top</a>
						</p>
					</div>
				</footer>
			</article><!-- #post-<?php the_ID(); ?> -->

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content .site-content -->
</section><!-- #single-editor .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>