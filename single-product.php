<?php
/**
 * The Template for displaying all single posts.
 *
 * @package editer
 * @since editer 1.0
 */

if($post->post_parent):
get_header(); ?>
<section id="single-product" class="column alpha omega eightteen">
	<div id="content" class="clearfix" >
	<?php if(have_posts()) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('column sixteen push-two omega alpha'); ?>>
			<div class="inner clearfix">
				<header class="post-header">
					<div class="entry-meta">
						<p class="date light-grey italic small text-center"><?php the_time(get_option('date_format')); ?></p>
						<hr />
						<h1 class="title text-center"><?php the_title(); ?></h1>
						<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
					</div>
				</header><!-- .post-header -->
				
				<div class="post-content clearfix">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->
		<div class="clearfix"></div>
		<footer class="single-product-footer ">
			<?php get_template_part('inc/share-links'); ?>
		</footer>
	<?php endwhile; ?>
	<?php endif; ?>
	</div><!-- #content -->
</section><!-- #single -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php else: ?>
<?php get_template_part('archive', 'product');?>
<?php endif; ?>