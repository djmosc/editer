<?php 
$custom_query = new WP_Query( array('posts_per_page' => -1, 'post_type' => array('editor'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'menu_order', 'order' => 'ASC'));
if ( $custom_query->have_posts() && 1 == 1) :
?>
<section id="editors" class="striped-border top left right bottom">
	<div class="white-bg inner">
		<h3 class="red didot-italic">our experts</h3>
		<div class="scroller" data-callback="onEditorChange">
			<div class="scroller-pagination-mask">
				<ul class="scroller-pagination clearfix">
					<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
					<?php if(has_post_thumbnail()): ?>
					<li>
						<a data-id="<?php echo get_the_ID(); ?>">
							<?php the_post_thumbnail(array(170, 180), array('title' => get_the_title()));?>
							<div class="overlay semi-black-bg"></div>
						</a>
					</li>
					<?php endif; ?>
					<?php endwhile;?>
				</ul>
			</div>
			<div class="scroller-mask">
				<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
				<?php if(has_post_thumbnail()): ?>
				<div class="scroll-item" data-id="<?php echo get_the_ID(); ?>">
					<div class="inner">
						<h3 class="title didot-italic"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
						<div class="excerpt bold">
							<?php the_excerpt(); ?>
						</div>
						<div class="content">
							<?php the_content(); ?>
						</div>
						<p class="small">
							<a class="red novecento-bold uppercase" href="<?php the_permalink(); ?>">See <?php the_title(); ?>'s Edits</a>
						</p>
						<p class="social-links">
							<?php if(get_post_meta($post->ID, 'website_url', true)) :?>
							<a class="share-link-btn" href="<?php echo get_post_meta($post->ID, 'website_url', true); ?>" target="_blank"><?php echo get_post_meta($post->ID, 'website_url', true); ?></a>
							<?php endif; ?>
							<?php if(get_post_meta($post->ID, 'twitter_url', true)) :?>
							<a class="share-twitter-btn" href="http://www.twitter.com/<?php echo get_post_meta($post->ID, 'twitter_url', true); ?>" target="_blank"><?php echo get_post_meta($post->ID, 'twitter_url', true); ?></a>
							<?php endif; ?>
							<?php if(get_post_meta($post->ID, 'facebook_url', true)) :?>
							<a class="share-facebook-btn" href="<?php echo get_post_meta($post->ID, 'facebook_url', true); ?>" target="_blank"><?php _e('Facebook Profile'); ?></a>
							<?php endif; ?>
						</p>
						
					</div>
				</div>
				<?php endif; ?>
				<?php endwhile; ?>
			</div>
			<div class="scroller-navigation">
				<a class="prev-btn"></a>
				<a class="next-btn"></a>
			</div>
		</div>
	</div>
</section>
<?php endif;?>