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
get_header();
?>
<section id="archive-shop">
	<div id="content" class="clearfix">
		<?php dynamic_sidebar( 'shop_content' ); ?>
	</div><!-- #content -->
</section><!-- #front-page -->

<script>
	$(function(){
		var container = $('#archive-shop #content');
		container.imagesLoaded(function(){
			container.masonry({
				itemSelector: '.widget',
				columnWidth: function(containerWidth){
					return containerWidth / 4;
				},
			    isAnimated: !Modernizr.csstransitions,
				isResizable: false
			});
		});
	});
</script>
<?php get_footer(); ?>