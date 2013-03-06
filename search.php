<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>

<section id="search" >
	<div id="content" class="span seven-and-half alpha">
		<header class="search-header striped-border top left right bottom">
			<div class="inner white-bg clearfix ">
				<div class="span one push-three"><h4 class="red didot-italic no-margin"><?php _e('search') ?></h4></div>
				<div class="span four"><?php get_search_form(); ?></div>
			</div>
		</header><!-- .search-header -->

		<?php if ( have_posts() ) : ?>
		<div class="thick-border-bottom">
			<h5 class="novecento-bold text-center small"><?php _e('Search Results'); ?></h5>
		</div>
		<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
		 	
		<div id="posts">
			<?php while ( have_posts() ) : the_post(); ?>
			<div <?php post_class('dotted-border-bottom post'); ?>>
				<header class="post-header">
					<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="post-meta arial small black">
						<span class="author"><?php the_author(); ?></span> - 
						<span class="date"><?php the_time(get_option('date_format')); ?></span>
					</p>
				</header>
				<div class="post-excerpt">
					<p>...<?php echo substr(strip_tags(get_the_content($post->ID)), 0, 200); ?>...</p>
				</div>
			</div>
			
			<?php endwhile; ?>

		</div>
		<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
		
		<?php else : ?>

		<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>

	</div><!-- #content -->
	<?php get_sidebar(); ?>
</section><!-- #search -->

<?php get_footer(); ?>