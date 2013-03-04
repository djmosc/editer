<?php 
$custom_query = new WP_Query( array('posts_per_page' => -1, 'post_type' => array('editor'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'rand'));
if ( $custom_query->have_posts() && 1 == 1) :
	$categories = get_categories(array('parent' => 0, 'order' => 'DESC', 'orderby' => 'id')); 
?>
<section id="editors" class="striped-border top left right bottom">
	<div class="white-bg inner">
		<header class="header clearfix">
			<div class="span three omega alpha">
				<h3 class=""><?php _e("Our Stylemakers", 'editer'); ?></h3>
			</div>
			<div class="span seven omega alpha">
				<nav class="category-navigation">
					<ul class="clearfix">
						<!-- <li>
							<a data-id="0" class="cateogry-btn"><?php _e("All", 'editer') ?></a>
						</li> -->
					<?php
						$i = 0; 
						$total_categories = count($categories);
						foreach ($categories as $category) :
					?>
						<li class="<?php if($i == $total_categories - 1) echo 'current'; ?>">
							<a href="<?php echo get_category_link( $category->term_id ); ?>" data-category-id="<?php echo $category->term_id; ?>" class="category-btn"><?php echo $category->cat_name; ?></a>
						</li>
					<?php $i++; ?>
					<?php endforeach; ?>
					</ul>
				</nav>
			</div>
		</header>
		<div class="scrollers">
			<?php $i = 0; ?>
			<?php foreach ($categories as $category) : ?>
			<?php //&& $category_id == get_field('category_id') ?>
			<?php $category_id = $category->term_id;?>
			<div class="scroller <?php echo ($i == $total_categories - 1) ? 'current' : 'hide'; ?>" data-callback="onEditorChange" data-category-id="<?php echo $category->term_id; ?>" >
				<div class="scroller-pagination-mask">
					<ul class="scroller-pagination clearfix">
						<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
						<?php if(has_post_thumbnail() && ($category_id == get_field('category_id'))): ?>
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
					<?php if(has_post_thumbnail() && ($category_id == get_field('category_id'))): ?>
					<div class="scroll-item" data-id="<?php echo get_the_ID(); ?>">
						<div class="inner">
							<h3 class="title didot-italic"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
							<div class="excerpt grey avenir ">
								<?php the_excerpt(); ?>
							</div>
							<div class="content">
								<?php the_content(); ?>
							</div>
						</div>
						<hr />
						<p class="no-margin">
							<a class="big red-btn" href="<?php the_permalink(); ?>">See <?php the_title(); ?>'s Edits</a>
						</p>
						<!--p class="social-links">
							<?php if(get_post_meta($post->ID, 'website_url', true)) :?>
							<a class="share-link-btn" href="<?php echo get_post_meta($post->ID, 'website_url', true); ?>" target="_blank"><?php echo get_post_meta($post->ID, 'website_url', true); ?></a>
							<?php endif; ?>
							<?php if(get_post_meta($post->ID, 'twitter_url', true)) :?>
							<a class="share-twitter-btn" href="http://www.twitter.com/<?php echo get_post_meta($post->ID, 'twitter_url', true); ?>" target="_blank"><?php echo get_post_meta($post->ID, 'twitter_url', true); ?></a>
							<?php endif; ?>
							<?php if(get_post_meta($post->ID, 'facebook_url', true)) :?>
							<a class="share-facebook-btn" href="<?php echo get_post_meta($post->ID, 'facebook_url', true); ?>" target="_blank"><?php _e('Facebook Profile'); ?></a>
							<?php endif; ?>
						</p-->
					</div>
					<?php endif; ?>
					<?php endwhile; ?>
				</div>
				<div class="scroller-navigation">
					<a class="prev-btn"></a>
					<a class="next-btn"></a>
				</div>
			</div>

			<?php $i++; ?>
			<?php endforeach; ?>
			<?php wp_reset_query(); ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php endif;?>