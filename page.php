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

		<div id="page" class="column eightteen omega alpha">
			<div id="page-sidebar" class="widget-area five column alpha">
				<?php dynamic_sidebar( 'page' ); ?>
			</div>
			<div id="content" class="twelve column push-one alpha omega">
			
				<?php while ( have_posts() ) : the_post(); ?>

					
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="page-header">
						<h3 class="title didot-italic"><?php the_title(); ?></h3>
					</header><!-- .entry-header -->

					<div class="page-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>