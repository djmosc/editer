<?php
/**
 * The Template for displaying all single posts.
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>
<section id="single-shop" class="clearfix">
	<div id="content" class="span seven-and-half alpha omega" >
	<?php if(have_posts()) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php if(is_object_in_term($post->ID, 'shop_category', get_editer_option('hts_category_id'))) : ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('category-hit-the-streets'); ?>>
			<header class="post-header">
				<div class="inner clearfix">
					<div class="span seven image omega">
						<div class="featured-image">
							<?php 
		        			$image_id = get_post_thumbnail_id($post->ID);
		        			$image = wp_get_attachment_image_src($image_id, 'custom_large', array('class' => 'scale'));
		        			?>
		        			<img src="<?php echo $image[0]; ?>" class="scale" />
						</div>
					</div>
					<div class="span three content">
						<header class="header">
							<?php
							$image_id = get_field('image_id', 'category_'.get_editer_option('hts_category_id'));
							if($image_id):
								$image = wp_get_attachment_image_src($image_id, 'full');
							?>
							<h3 class="category-image">
								<a href="<?php echo get_category_link( get_editer_option('hts_category_id') ); ?>">
									<img src="<?php echo $image[0]; ?>" class="scale" />
								</a>
							</h3>
							<?php endif; ?>
						</header>
						<div class="post-meta">
							<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
						</div>

						<div class="striped-border top bottom navigation">
							<div class="inner">
								<?php $prev_post = get_the_adjacent_fukn_post('previous', 'post', array(get_editer_option('hts_category_id')));?>
								<a href="<?php echo get_permalink($prev_post->ID);?>" class="prev-btn"></a>
								<?php $next_post = get_the_adjacent_fukn_post('next', 'post', array(get_editer_option('hts_category_id'))); ?>
								<a href="<?php echo get_permalink($next_post->ID);?>" class="next-btn"></a>
								<h5 class="text-center novecento-bold uppercase"><a href="<?php echo get_category_link(get_editer_option('hts_category_id'));?>" class="light-grey"><?php _e('View All'); ?></a></h5>
							</div>
						</div>
					</div>
				</div>
			</header><!-- .post-header -->
			
			<div class="post-content clearfix">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
			<footer class="footer clearfix">
				<div class="span three omega share push-seven">	
					<?php $size = 'small'; ?>
					<?php get_template_part('inc/share-links'); ?>
				</div>	
			</footer>
		</article><!-- #post-<?php the_ID(); ?> -->
		
		<?php get_template_part('inc/street-chics'); ?>

		<?php elseif(is_object_in_term($post->ID, 'shop_category', 119)): ?>
		<script>
			$(function(){
				var container = $('#products');
				container.imagesLoaded(function(){
					container.masonry({
						itemSelector: '.product',
						columnWidth: function(containerWidth){
							return containerWidth / 3;
						},
					    isAnimated: !Modernizr.csstransitions,
						isResizable: false
					});
				});
			});
		</script>
		<article id="post-<?php the_ID(); ?>" <?php post_class('category-the-chic-list'); ?>>
			<header class="post-header">
				<div class="category-image center">
				<?php
				$categories = get_the_terms($post->ID, 'shop_category');
				$categories = array_slice($categories, 0, 1);
				$category = get_top_level_category($categories[0]->term_id, 'shop_category');
				if(isset($category)):
					$image_id = get_field('image_id', 'shop_category_'.$category->term_id);

					if($image_id):
						$image = wp_get_attachment_image_src($image_id, 'full');
					?>
					<a href="<?php echo get_term_link( $category->slug, 'shop_category' ); ?>">
						<img src="<?php echo $image[0]; ?>" class="scale" />
					</a>	
					<?php endif; ?>
				<?php endif; ?>
				</div>
				<div class="post-meta">
					<hr />
					<h1 class="title text-center"><?php the_title(); ?></h1>
					<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
				</div>
			</header><!-- .post-header -->
			<div class="content striped-border top bottom">
				<div class="inner clearfix">
					<div class="span six omega right featured-image">
						<?php 
	        			$image_id = get_post_thumbnail_id($post->ID);
	        			$image = wp_get_attachment_image_src($image_id, 'custom_large', array('class' => 'scale'));
	        			?>
	        			<img src="<?php echo $image[0]; ?>" class="scale" />
					</div>
					<?php the_content(); ?>
				</div>
			</div>
			<?php $products = get_field('products');?>
			<?php if(!empty($products)) : ?>
			<div id="recommendations" class="clearfix">
				<p class="novecento-bold small"><?php the_title(); ?> <span class="red">Recommendations</span><p>
				<div id="products">
				<?php 
				$i = 0;

				foreach ( $products as $post) :
					setup_postdata($post);
					$url = (get_post_meta($post->ID, 'external_url', true)) ? get_post_meta($post->ID, 'external_url', true) : get_permalink();
				?>
					<div class="product">
						<div class="inner border-bottom">
							<?php if(!get_post_meta($post->ID, 'hidden', true)) : ?>
							<span class="number"><?php echo $i + 1; ?></span>
							<div class="featured-image thumbnail">
								<a href="<?php echo $url; ?>" <?php if(get_post_meta($post->ID, 'external_url', true)) echo 'target="_blank"'; ?>>
									<?php the_post_thumbnail('full', array('title' => get_the_title())); ?>
								</a>
							</div>
							<div class="content">
								<div class="product-content">
									<p class="small avenir">
										<?php echo get_the_content(); ?>
									</p>	
								</div>
								<div class="product-meta">
									<p class="avenir small light-grey">
										(<span class="title"><?php the_title();?></span>;
										<span class="price"><?php echo get_post_meta($post->ID, 'price', true)?></span>
										)
									</p>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php $i++;?>
					<?php endforeach; ?>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
			<?php endif; ?>

		</article>
		<?php else: ?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class('striped-border top left right bottom'); ?>>
			<div class="inner clearfix">
				<header class="post-header">
					<div class="category-image center">
					<?php
					$categories = get_the_terms($post->ID, 'shop_category');
					$categories = array_slice($categories, 0, 1);
					$category = get_top_level_category($categories[0]->term_id, 'shop_category');
					if(isset($category)):
						$image_id = get_field('image_id', 'shop_category_'.$category->term_id);

						if($image_id):
							$image = wp_get_attachment_image_src($image_id, 'full');
						?>
						<a href="<?php echo get_term_link( $category->slug, 'shop_category' ); ?>">
							<img src="<?php echo $image[0]; ?>" class="scale" />
						</a>	
						<?php endif; ?>
					<?php endif; ?>
					</div>
					<div class="post-meta">
						<p class="date light-grey italic small text-center"><?php the_time(get_option('date_format')); ?></p>
						<hr />
						<h1 class="title text-center"><?php the_title(); ?></h1>
						<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
					</div>
				</header><!-- .post-header -->

				<?php $products = get_field('products'); ?>
				<?php if(!empty($products)) : ?>
				<div id="products" class="clearfix">
				<?php 
				$i = 0;				
				$total = count($products);
				$row = 0;
				$columns = array('first', 'second', 'third');
				$total_columns = count($columns);
				$total_rows = round($total / $total_columns);
				foreach ( $products as $post) :
					setup_postdata($post);
					$image_top = (get_post_meta($post->ID, 'image_top', true)) ? get_post_meta($post->ID, 'image_top', true) : 0;
					$image_left = (get_post_meta($post->ID, 'image_left', true)) ? get_post_meta($post->ID, 'image_left', true) : 0;
					$url = (get_post_meta($post->ID, 'external_url', true)) ? get_post_meta($post->ID, 'external_url', true) : get_permalink();
				?>
					<div class="product <?php echo $columns[$i % $total_columns]; ?> <?php if($row == 0) echo 'first-row'; ?> <?php if($row == $total_rows - 1) echo 'last-row'; ?>">
						<div class="inner">
							<?php if(!get_post_meta($post->ID, 'hidden', true)) : ?>
							<header class="product-header">
								<p class="no-margin small arial">
									<span class="title bold"><?php the_title();?></span><br />
									<span class="excerpt"><?php echo get_the_excerpt(); ?></span><br />
									<span class="price"><?php echo get_post_meta($post->ID, 'price', true)?></span><br />
									<a href="<?php echo $url; ?>" <?php if(get_post_meta($post->ID, 'external_url', true)) echo 'target="_blank"'; ?> class="red-btn uppercase"><?php _e('Shop Now');?></a>
								</p>
							</header>
							<div class="thumbnail" style="top: <?php echo $image_top; ?>; left: <?php echo $image_left; ?>;">
								<a href="<?php echo $url; ?>" <?php if(get_post_meta($post->ID, 'external_url', true)) echo 'target="_blank"'; ?>>
									<?php the_post_thumbnail('full', array('title' => get_the_title())); ?>
								</a>
							</div>

							<?php if($row != 0 && ($i % $total_columns) != $total_columns - 1) : ?>
							<div class="crosshair"></div>
							<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					<?php if(($i + 1) % 3 == 0) $row++; ?>
					<?php $i++;?>
					<?php endforeach; ?>
				</div>
				<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->
	
		
		<?php endif; ?>
	<?php endwhile; ?>
	<?php endif; ?>
	<?php get_template_part('inc/shop-category-posts'); ?>
	</div><!-- #content -->
	<?php $sidebar_id = 'shop'; ?>
	<?php get_sidebar(); ?>
</section><!-- #single -->
<?php get_footer(); ?>