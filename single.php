<?php
/**
 * The Template for displaying all single posts.
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>

<section id="single">
	<div id="content" class="span seven-and-half alpha omega" >
	<?php if(have_posts()) : ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php $post_format = (get_field( 'post_format' )) ? get_field( 'post_format' ) : 'standard'; ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class($post_format); ?>>
			<?php if ( $post_format == 'gallery') : ?>
			<?php $gallery_id = (get_field('gallery', $post->ID)) ? get_field('gallery', $post->ID)->ID : $post->ID; ?>
			<header class="post-header">
				<?php $args = array( 
				    'post_type' => 'attachment', 
				    'post_mime_type' => 'image',
				    'numberposts' => -1, 
				    'post_status' => null, 
				    'post_parent' => $gallery_id,
				    'orderby' => 'menu_order',
				    'order' => 'ASC'
				); 
				$images = get_posts( $args );
				if(!empty($images)):
				?>
				<div class="scroller clearfix">
					<div class="span six alpha omega scroller-mask">
					<?php foreach ($images as $image): ?>
						<div class="scroll-item" data-id="<?php echo $image->ID; ?>">
							<div class="image">
								<?php $image_src = wp_get_attachment_image_src($image->ID, 'custom_large'); ?>
								<img src="<?php echo $image_src[0]; ?>" class="scale" />
							</div>
							<div class="description">
								<h3><?php echo get_the_title($image->ID); ?></h3>
								<?php echo $image->post_content;?>
							</div>
						</div>
					<?php endforeach ?>
					</div>
					<div class="span five omega alpha content">
						<div class="post-meta">
							<?php get_template_part( 'inc/category'); ?>
					    	<h1 class="title text-center"><?php the_title(); ?></h1>
							<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
						</div>
						<ul class="scroller-pagination clearfix">
							<?php foreach ($images as $image): ?>
							<li class="span three">
								<a data-id="<?php echo $image->ID ?>">
									<?php $image_src = wp_get_attachment_image_src($image->ID, 'gallery_thumbnail'); ?>
									<img src="<?php echo $image_src[0]; ?>" class="scale" />
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<?php else: ?>
				<div class="featured-image">
					<?php the_post_thumbnail('homepage_image', array('class' => 'scale')); ?>
				</div>
				<?php endif;?>
			</header><!-- .post-header -->
			<?php else: ?>
			<header class="post-header">
				<div class="featured-image">
					<?php the_post_thumbnail('large', array('class' => 'scale')); ?>
				</div>
			</header><!-- .post-header -->
			<?php endif; ?>
			
			<div class="content clearfix">
				<div class="inner">
					<?php if ( $post_format != 'gallery') : ?>
					<div class="post-meta shadow">
						<?php get_template_part( 'inc/category'); ?>
				    	<h1 class="title text-center"><?php the_title(); ?></h1>
						<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
					</div>
					<?php endif; ?>
					<div class="post-content clearfix">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</div>
			</div>

			<footer class="footer clearfix">
				<div class="span seven alpha">	
					<?php get_template_part('inc/author'); ?>
				</div>	
				<div class="span three omega share">	
					<?php get_template_part('inc/share-links'); ?>
				</div>	
			</footer>
		</article><!-- #post-<?php the_ID(); ?> -->
		
		<div class="previous-next-posts dotted-border">
			<div class="inner clearfix">
				<?php $prev_post = get_the_adjacent_fukn_post('previous');?>
				<?php if($prev_post && $prev_post->ID != $post->ID):?>
				<a href="<?php echo get_permalink($prev_post->ID);?>" class="post span five previous">
					<div class="span three featured-image thumbnail">
						<?php
		                $image_id = get_post_thumbnail_id($prev_post->ID);
		                $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
		                ?>
		                <img src="<?php echo $image[0]?>" class="scale" />
					</div>
					<div class="span seven alpha content">
						<p class="no-margin small red uppercase novecento-bold"><?php _e("Previous Article", 'editer'); ?></p>
						<h4 class="title uppercase no-margin"><?php echo get_the_title($prev_post->ID) ?></h4>
						<p class="date light-grey avenir small"><?php the_time(get_option('date_format')); ?></p>
					</div>
				</a>
				<?php endif; ?>
				
				<?php $next_post = get_the_adjacent_fukn_post('next');?>
				<?php if($next_post && $next_post->ID != $post->ID):?>
				<a href="<?php echo get_permalink($next_post->ID);?>" class="post span five next">
					<div class="span seven alpha content text-right">
						<p class="no-margin small red uppercase novecento-bold"><?php _e("Previous Article", 'editer'); ?></p>
						<h4 class="title uppercase no-margin"><?php echo get_the_title($next_post->ID) ?></h4>
						<p class="date light-grey avenir small"><?php the_time(get_option('date_format')); ?></p>
					</div>
					<div class="span three featured-image thumbnail">
						<?php
		                $image_id = get_post_thumbnail_id($next_post->ID);
		                $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
		                ?>
		                <img src="<?php echo $image[0]?>" class="scale" />
					</div>
				</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="clearfix"></div>
		<footer class="single-footer ">
			<?php get_template_part('inc/category-posts'); ?>
		</footer>
	<?php endwhile; ?>
	<?php endif; ?>
	</div><!-- #content -->
	<?php $sidebar_id = 'post'; ?>
	<?php get_sidebar(); ?>
	<?php get_template_part( 'inc/related-posts'); ?>
</section><!-- #single -->
<?php get_footer(); ?>