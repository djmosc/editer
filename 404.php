<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>

<section id="error" class="column eightteen alpha omega">
	<div id="content" class="site-content" role="main">

		<article id="post-0" class="post error-404 not-found">
			<header class="error-header">
				<p class="arial uppercase grey text-center"><?php _e('Error', 'editer'); ?></p>
				<h1 class="title text-center"><?php _e( 'PAGE<br /><span class="didot-italic red">not</span><br />FOUND', 'editer' ); ?></h1>
				<p class="text-center"><?php _e('Sorry, the page you are looking for does not exist...', 'editer'); ?></p>
			</header><!-- .entry-header -->

			<div class="content">
				<div class="error-search striped-border top left right bottom">
					<div class="inner white-bg clearfix">
						<div class="column eight push-four"><?php get_search_form(); ?></div>
					</div>
				</div><!-- .search-header -->
			</div><!-- .entry-content -->
			<footer class="error-footer dotted-border top bottom">
				<div class="inner">
					<p class="small uppercase arial text-center"><?php _e('Back to home', 'editer'); ?></p>
				</div>
			</footer>
		</article><!-- #post-0 .post .error404 .not-found -->

	</div><!-- #content .site-content -->
</section><!-- #error -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>