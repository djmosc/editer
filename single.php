<?php
/**
 * The Template for displaying all single posts.
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>

<section id="single" class="column alpha omega eightteen">
	<div id="content" class="clearfix" >
	<?php if(have_posts()) : ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php if(!in_category(get_editer_option('hts_category_id'))) : ?>
		<?php $post_classes = (has_post_format( 'gallery' )) ? 'striped-border top left right bottom' : 'column sixteen push-two omega alpha'; ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
			<div class="inner clearfix">
				<?php if ( has_post_format( 'gallery' )) : ?>
				<?php get_template_part( 'inc/category'); ?>
				<header class="post-header">
					<div class="post-meta">
						<p class="date light-grey italic small text-center"><?php the_time(get_option('date_format')); ?></p>
						<hr />
						<h1 class="title text-center"><?php the_title(); ?></h1>
						<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
					</div>
				</header><!-- .post-header -->
				<?php else: ?>
				<header class="post-header pull-two">
					<div class="featured-image">
						<?php 
						the_post_thumbnail('large');
						get_template_part( 'inc/category'); 
				    	?>
					</div>
					<div class="post-meta">
						<p class="date light-grey italic small text-center"><?php the_time(get_option('date_format')); ?></p>
						<hr />
						<h1 class="title text-center"><?php the_title(); ?></h1>
						<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
					</div>
				</header><!-- .post-header -->
				<?php endif; ?>
				
				
				<?php $post_content_classes = (has_post_format( 'gallery' )) ? 'column fourteen push-two alpha omega' : ''; ?>
				<div class="post-content clearfix <?php echo $post_content_classes; ?>">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->
		
		<?php else: ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="inner clearfix">
				<header class="post-header clearfix border">
					<div class="column ten border-right equal-height">
						<div class="featured-image">
							<?php 
		        			$image_id = get_post_meta($post->ID, 'homepage_image_id', true); 
							if(!$image_id) $image_id = get_post_thumbnail_id($post->ID);
		        			echo wp_get_attachment_image($image_id, array(420, 999));
		        			get_template_part( 'inc/category');
		        			?>
						</div>
					</div>
					<div class="column eight equal-height">
						<?php if(get_post_meta($post->ID, 'top_content', true)):?>
						<div class="top-content">
							<?php echo get_post_meta($post->ID, 'top_content', true); ?>
						</div>
						<?php endif; ?>
						<div class="post-meta">
							<p class="date light-grey italic tiny text-center"><?php the_time(get_option('date_format')); ?></p>
							<hr />
							<h1 class="title text-center"><?php the_title(); ?></h1>
							<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
						</div>

						<div class="striped-border top bottom navigation">
							<div class="inner">
								<?php $prev_post = get_the_adjacent_fukn_post('previous', 'post', array(47));?>
								<a href="<?php echo get_permalink($prev_post->ID);?>" class="prev-btn"></a>
								<?php $next_post = get_the_adjacent_fukn_post('next', 'post', array(47)); ?>
								<a href="<?php echo get_permalink($next_post->ID);?>" class="next-btn"></a>
								<h5 class="text-center novecento-bold uppercase"><a href="<?php echo get_category_link(get_editer_option('hts_category_id'));?>" class="light-grey"><?php _e('View All'); ?></a></h5>
							</div>
						</div>

						<?php if(get_post_meta($post->ID, 'bottom_content', true)):?>
						<div class="bottom-content">
							<?php echo get_post_meta($post->ID, 'bottom_content', true); ?>
						</div>
						<?php endif; ?>
					</div>
				</header><!-- .post-header -->
				
				<div class="post-content clearfix">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php 
		$custom_query = new WP_Query( array('posts_per_page' => -1, 'post_type' => array('post'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 1, 'category__in' => array(get_editer_option('hts_category_id')), 'post__not_in' => array($post->ID)));
		if ( $custom_query->have_posts() ) :
			$columns = array('one', 'two', 'three', 'four');
			$total_columns = count($columns);
			$i = 0;
		?>
		<div id="street-chics" class="clearfix">
			<ul class="posts clearfix column eightteen">
				<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
				<li class="post left <?php echo $columns[$i % $total_columns];?>">
					<div class="thumbnail featured-image">
						<a href="<?php the_permalink(); ?>" class="overlay-btn">
							<?php
								$image_id = get_post_meta($post->ID, 'homepage_image_id', true); 
								$image =  wp_get_attachment_image_src($image_id, 'custom_thumbnail');
							?>
							<img src="<?php echo $image[0]?>" />
						</a>
					</div>
					<div class="post-meta">
						<p class="text-center novecento-demibold small">
							<a href="<?php the_permalink();?>" class="grey"><?php the_time(get_option('date_format')); ?></a>
						</p>
					</div>
				</li>
				<?php $i++; ?>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php endif;?>
		<?php endif; ?>
		<div class="clearfix"></div>
		<footer class="single-footer ">
			<?php get_template_part('inc/share-links'); ?>
			<?php get_template_part('inc/category-posts'); ?>
		</footer>
	<?php endwhile; ?>
	<?php endif; ?>
	</div><!-- #content -->
</section><!-- #single -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>