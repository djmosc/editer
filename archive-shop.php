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
function load_masonary() {
	wp_enqueue_script('masonary');
}
get_header();
add_action('wp_enqueue_scripts', 'load_masonary');
?>
<section id="archive-shop">
	<div id="content" class="clearfix">
			<?php dynamic_sidebar( 'shop_content' ); ?>
	</div><!-- #content -->
</section><!-- #front-page -->

<?php get_footer(); ?>