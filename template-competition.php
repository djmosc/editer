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

<section id="template-competition" class="span seven-and-half omega alpha">
	<div id="content">	
		<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="page-content">
				<div class="top">	
					<?php the_content(); ?>
				</div>
				<div class="middle clearfix">
					<header class="header">
						<nav class="navigation">
							<ul class="tab-navigation">
								<li>Simply enter your details below to win</li>
							</ul>
						</nav>
					</header>
					<div class="clearfix white-bg content">
						<div class="column form">
							<?php gravity_form(3, false); ?>
						</div>
						<div class="column omega share">
							

							<div class="striped-border top left right bottom">
								<div class="inner">
									<h4 class="title didot-italic uppercase">The Love</h4>
									<p>
										<a class="share-email-btn-big" href="mailto: your.friends.email@address.com?subject=<?php _e('Check%20this%20out');?>&body=<?php _e('Hi,%20I%20found%20this%20compeition%20on%20Editer.com%20and%20thought%20you%20might%20like%20it.'); ?>%20<?php echo urlencode(get_permalink()); ?>" target="_blank"><span><?php _e('Email');?></span></a>
										<a class="share-twitter-btn-big share-popup-btn" href="http://twitter.com/share"><span><?php _e('Tweet, tweet');?></span></a>
										<a class="share-facebook-btn-big share-popup-btn" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title();?>"><span><?php _e('Share on Facebook');?></span></a>
										<a class="share-link-btn-big tooltip-btn"><span><?php _e('Link to the competition');?></span><i class="tooltip"><input type="text" value="<?php the_permalink(); ?>" /></i></a>
									</p>
								</div>
							</div>	
						</div>
					</div>
				</div>
				<div class="bottom">
					<p class="grey small arial">Competition <a href="/cb-terms-and-conditions/" class="grey">Terms &amp; Conditions</a></p> 
				</div>
			</div><!-- .page-content -->
		</article><!-- #post-<?php the_ID(); ?> -->

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content .site-content -->
	<?php get_sidebar(); ?>
</section><!-- #template-striped-border .content-area -->
<?php get_footer(); ?>