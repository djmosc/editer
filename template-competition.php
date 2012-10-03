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
 *
 *
 * Template Name: Competition
 */

get_header(); ?>

		<div id="template-competition" class="column eightteen omega alpha">
			<div id="content">	
				<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="page-content">
						<div class="top">	
							<?php the_content(); ?>
						</div>
						<div class="middle">
							
						</div>
						<div class="bottom">
							<p class="grey small arial text-center">Competition <a href="#">Terms &amp; Conditions</a></p> 
						</div>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #template-striped-border .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>