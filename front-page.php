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

get_header(); ?>
<div class="clearfix">
	<section id="front-page" class="column eightteen alpha omega">
		<div id="homepage-sidebar" class="widget-area five column alpha">
			<?php dynamic_sidebar( 'homepage' ); ?>
		</div>
		<div id="content" class="twelve column push-one alpha omega">
			<?php 
			$carousel_ary = array(0, 4, '');
			
			$posts_query = new WP_Query( array('posts_per_page' => 3, 'post_type' => array('post'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 3, 'category__not_in' => array(get_editer_option('hts_category_id'))));
			$posts_position_ary = array(0, 2, 4);
			$ads_query = new WP_Query( array('posts_per_page' => 2, 'post_type' => array('ad'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 2, 'orderby' => 'menu_order', 'order' => 'ASC' ));
			$ads_position_ary = array(1, 3);
			
			
			
			if ( $posts_query->have_posts() ) {
				$i = 0;
				while ( $posts_query->have_posts() ) { 
					$posts_query->the_post();
					$carousel_ary[$posts_position_ary[$i]] = $post;
					$i++;
				}
			}

			if ( $ads_query->have_posts() ) {
				$i = 0;
				while ( $ads_query->have_posts() ) { 
					$ads_query->the_post();
					$carousel_ary[$ads_position_ary[$i]] = $post;
					$i++;
				}
			}

			// Every monday

			if(date('N') == 1 || isset($_GET['dev'])){
			//if(isset($_GET['dev'])){
				$products_query = new WP_Query( array('posts_per_page' => 1, 'post_parent' => '0', 'post_type' => array('product'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 1 ));
				$products_position_ary = array(0);
				if ( $products_query->have_posts() ) {
					$i = 0;
					while ( $products_query->have_posts() ) { 
						$products_query->the_post();
						array_insert($carousel_ary, $post, $products_position_ary[$i]);
						$i++;
					}
					unset($carousel_ary[1]);
				}
			}



			if ( !empty($carousel_ary) ) :

			?>
			<div id="homepage-scroller" class="scroller" data-auto-scroll="true">
				<div class="scroller-mask">
					<?php foreach($carousel_ary as $post) :?>
					<?php $url = ($post->post_type == 'post' || $post->post_type == 'product') ? get_permalink($post->ID) : get_post_meta($post->ID, 'external_url', true); ?>
					<div class="scroll-item" data-id="<?php echo $post->ID;?>">
						<div class="post">
				        	<div class="thumbnail featured-image">
				        		<a href="<?php echo $url;?>" <?php if(get_post_meta($post->ID, 'new_tab', true)) echo 'target="_blank"'; ?>>
				        			<?php 
				        			$image_id = get_post_meta($post->ID, 'homepage_image_id', true); 
				        			if(!$image_id) $image_id = get_post_thumbnail_id($post->ID);
				        			echo wp_get_attachment_image($image_id, 'custom_large', false, array('title' => get_the_title())); ?>
				        		</a>
				        		<?php if($post->post_type == 'post') : ?>
				        		<?php get_template_part( 'inc/category'); ?>
					        	<?php endif; ?>
				        	</div>
				        	<div class="post-meta">
					        	<?php if($post->post_type == 'post') : ?>
					        	<p class="date light-grey italic small text-center"><?php echo get_the_time(get_option('date_format'), $post->ID); ?></p>
				        		<hr />
				        		<?php endif; ?>
				        		<h1 class="title text-center uppercase"><a href="<?php echo $url;?>" <?php if($post->post_type == 'ad') echo 'target="_blank"'; ?>><?php echo get_the_title($post->ID);?></a></h1>
				            	<p class="excerpt arial small text-center dark-grey"><?php echo $post->post_excerpt; ?></p>
				            </div>
			            </div>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="scroller-navigation">
					<a class="prev-btn"></a>
					<a class="next-btn"></a>
				</div>
				<ul class="scroller-pagination">
					<?php foreach($carousel_ary as $post) : ?>
					<li><a data-id="<?php echo $post->ID;?>"></a></li>
					<?php endforeach; ?>
				</ul>
			</div><!-- #homepage-scroller -->
			<?php endif; ?>

			<?php 
			$custom_query = new WP_Query( array('posts_per_page' => 1, 'post_type' => array('post'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 1, 'category__in' => array(get_editer_option('hts_category_id'))));
			if ( $custom_query->have_posts() ) :
				$category = get_category(get_editer_option('hts_category_id'));
			?>

			<div id="feature-category" class="striped-border top bottom left right">
				<div class="white-bg inner">
					<h3 class="text-center category-title"><a href="<?php echo get_category_link( $category->term_id );?>" class="red didot-italic"><?php echo $category->name; ?></a></h3>
					<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
					<div <?php post_class(); ?>>
						<div class="thumbnail featured-image">
			        		<a href="<?php the_permalink();?>">
			        			<?php the_post_thumbnail(array(488, 999), array('title' => get_the_title())); ?>
			        		</a>
			        		<?php
			        		$category_position = 'bottom'; 
			        		get_template_part( 'inc/category');
			        		?>
			        	</div>
			        	<div class="post-meta">
				        	<h2 class="text-center title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
				        	<?php echo category_description($category->term_id);?>
				        	<!-- <p class="text-center didot-italic no-margin with">with</p>
				        	<p class="text-center logo"><a href="category/fashion-style/hit-the-streets/"><img src="wp-content/uploads/nap_logo.gif" /></a></p> -->
				        </div>
				    </div>
					<?php endwhile; ?>
				</div>
			</div>
			<?php endif; ?>

			<?php 
			$custom_query = new WP_Query( array('posts_per_page' => 1, 'post_type' => array('post'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 1, 'offset' => 8 - 1,  'category__not_in' => array(get_editer_option('hts_category_id'))));
			if ( $custom_query->have_posts() ) :
			?>
			<div id="eighth-post">
				<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
				<div <?php post_class(); ?>>
					<div class="thumbnail featured-image">
		        		<a href="<?php the_permalink();?>">
		        			<?php the_post_thumbnail(array(528, 999), array('title' => get_the_title())); ?>
		        		</a>
		        		<?php
		        		$category_position = 'bottom'; 
		        		get_template_part( 'inc/category');
		        		?>
		        	</div>
		        	<div class="post-meta">
			        	<p class="date light-grey italic tiny text-center"><?php the_time(get_option('date_format')); ?></p>
		        		<hr />
		        		<h5 class="title text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
		            	<p class="excerpt arial small text-center dark-grey"><?php echo get_the_excerpt(); ?></p>
		            </div>
		        </div>
				<?php endwhile; ?>
			</div>
			<?php endif; ?>
		</div><!-- #content -->
	</section><!-- #index -->
<?php get_sidebar(); ?>
</div>



<?php 
$custom_query = new WP_Query( array('posts_per_page' => -1, 'post_type' => array('editor'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'menu_order', 'order' => 'ASC'));
if ( $custom_query->have_posts() && 1 == 2) :
?>
<section id="editors" class="striped-border top left right bottom">
	<div class="white-bg inner">
		<h3 class="red didot-italic">our experts</h3>
		<div class="scroller" data-callback="onEditorChange">
			<div class="scroller-pagination-mask">
				<ul class="scroller-pagination clearfix">
					<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
					<li>
						<a data-id="<?php echo get_the_ID(); ?>">
							<?php the_post_thumbnail(array(170, 180), array('title' => get_the_title()));?>
							<div class="overlay semi-black-bg"></div>
						</a>
					</li>
					<?php endwhile;?>
				</ul>
			</div>
			<div class="scroller-mask">
				<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
				<div class="scroll-item" data-id="<?php echo get_the_ID(); ?>">
					<div class="inner">
						<h3 class="title didot-italic"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
						<div class="excerpt">
							<?php the_excerpt(); ?>
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
<?php get_footer(); ?>