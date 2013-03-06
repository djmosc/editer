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
 * Template Name: Instagram
 */

get_header(); ?>

<div id="template-instagram">

	<div id="content">	
		<?php while ( have_posts() ) : the_post(); ?>
		<header class="header clearfix">
			<div class="span four alpha featured-image">
				<?php the_post_thumbnail($post->ID, 'full'); ?>
			</div>
			<div class="span four omega push-two didot-italic">
				<?php the_content(); ?>
			</div>
		</header>
		<div class="page-content">
			<div id="instagram" class="clearfix"></div>
			<button class="load-more-btn">Load More</button>
			<script>
				$(function(){
					var instagram = $('#instagram'),
						loadMoreBtn = $('.load-more-btn'),
						options = {
							accessToken: '9006680.f59def8.5117b650dc924496b099bfb8e57c6f4a',
							userId: 'self',
							show: 8,
							clientId: '8c98bbc69ac6465bb3dbcb4290d00857',
							image_size: 'low_resolution',
							onComplete: function(photos, data){
								loadMoreBtn.html('Load More');
								options.next_url = data.pagination.next_url;
								instagram.imagesLoaded(function(){
									equalHeight();
								});
							}
						}

					loadMoreBtn.on('click', function(){
						loadInstagram();
					});


					loadInstagram();
					function loadInstagram(){
						loadMoreBtn.text('Loading...');
						instagram.instagram(options);
					}
				});
			</script>
		</div><!-- .entry-content -->
		<?php endwhile; // end of the loop. ?>

	</div><!-- #content .site-content -->
</div><!-- #instagram .content-area -->

<?php get_footer(); ?>