<?php
/**
 * The Template for displaying all single posts.
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>

<section id="category" class="column eightteen alpha omega">
	<div id="posts" class="clearfix" >
	<?php $i = 0;?>
	<?php while ( have_posts() ) : the_post(); ?>

		<div class="post <?php echo ($i > 0) ? 'small':'large'; ?> <?php if($i > 0) echo ($i % 2) ? 'left' : 'right';?> ">
			<div class="thumbnail featured-image">
				<?php $image_size = ($i > 0) ? array(380, 999) : array(790, 999);?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($image_size, array('title' => '')); ?></a>
		    	<?php get_template_part( 'inc/category'); ?>
			</div>
			<div class="post-meta">
				<p class="date light-grey italic tiny text-center"><?php the_time(get_option('date_format')); ?></p>
				<hr />
				<?php if($i > 0) :?>
				<h3 class="title text-center"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php else: ?>
				<h1 class="title text-center"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<?php endif; ?>
				
				<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
			</div>
		</div>
	<?php $i++; ?>
	<?php endwhile; ?>
	</div><!-- #posts -->
	<?php wp_simple_pagination(); ?>
</section><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>