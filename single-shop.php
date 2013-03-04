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
				
				<?php 
				$products = get_field('products');
				?>
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
	<?php endwhile; ?>
	<?php endif; ?>
	<?php get_template_part('inc/shop-category-posts'); ?>
	</div><!-- #content -->
	<?php $sidebar_id = 'shop'; ?>
	<?php get_sidebar(); ?>
</section><!-- #single -->
<?php get_footer(); ?>