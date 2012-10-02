<?php
/**
 * The Template for displaying all single posts.
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>

<section id="archive-product" class="column alpha omega eightteen">
	<div id="content" class="clearfix striped-border top left right bottom" >
		<div class="inner">
			<header class="products-header">
				<div class="inner">
					<h1 class="title uppercase no-margin"><?php _e('The<br />weekly <span class="didot-italic red">edit</span>', 'editer' );?></h1>
					<p class="description didot-italic dark-grey no-margin"><?php echo get_the_excerpt()?></p>
				</div>
			</header>

			<?php 
			if(is_archive()){
				$args = array_merge( $wp_query->query_vars, array('orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => 100, 'post_parent' => 0));	
			} else {
				$args = array('orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => 100, 'post_parent' => $post->ID, 'post_type' => array('product'));	
			}

			$custom_query = new WP_Query($args); ?>
			<?php if($custom_query->have_posts()) : ?>
			<div id="products" class="clearfix">
				<?php 
				$i = 0;				
				$total = 20;
				$row = 0;
				$columns = array('one', 'two', 'three');
				$total_columns = count($columns);
				$total_rows = round($total / $total_columns);
				$total_rows = 2;
				while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$image_top = (get_post_meta($post->ID, 'image_top', true)) ? get_post_meta($post->ID, 'image_top', true) : 0;
				$image_left = (get_post_meta($post->ID, 'image_left', true)) ? get_post_meta($post->ID, 'image_left', true) : 0;
				$url = (get_post_meta($post->ID, 'external_url', true)) ? get_post_meta($post->ID, 'external_url', true) : get_permalink();
				?>
				<div class="product <?php echo $columns[$i % $total_columns]; ?> <?php if($row == 0) echo 'first-row'; ?> <?php if($row + 1 == $total_rows) echo 'last-row'; ?>">
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
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</div><!-- #content -->
	<div class="pagination clearfix">
		
		<?php $next_post = get_the_adjacent_fukn_post('next', 'product', array(), 0); ?>
		<?php if($next_post && $next_post->ID != $post->ID):?>
		<a href="<?php echo get_permalink($next_post->ID);?>" class="right"><?php echo get_the_title($next_post->ID) ?></a>
		<?php endif; ?>
		<?php $prev_post = get_the_adjacent_fukn_post('previous', 'product', array(), 0);?>
		<?php if($prev_post && $prev_post->ID != $post->ID):?>
		<a href="<?php echo get_permalink($prev_post->ID);?>" class="left"><?php echo get_the_title($prev_post->ID) ?></a>
		<?php endif; ?>
	</div>
	<footer class="products-footer ">
		<?php get_template_part('inc/share-links'); ?>
		
		<?php 
		$custom_query = new WP_Query( array('orderby' => 'rand', 'posts_per_page' => 3, 'post_type' => array('post'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
		if ( $custom_query->have_posts() ) :
		?>
		<div class="category-posts">
			<header class="category-posts-header thick-border-bottom">
		        <h5 class="black uppercase novecento-bold small title text-center"><?php _e('You may also like'); ?></h5>
		    </header>
			<div class="clearfix">
				<?php $i = 0; ?>
				<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
				<div class="post <?php if(($i + 1)  % 3 == 0) echo 'omega'; ?> <?php if(($i) % 3 == 0) echo 'alpha'; ?>">
		        	<div class="thumbnail featured-image">
		        		<a href="<?php the_permalink();?>">
		        			<?php the_post_thumbnail(array(250, 999), array('title' => get_the_title())); ?>
		        		</a>
		        		<?php
		                $category_level = 2;
		                get_template_part( 'inc/category');
		                ?>
		        	</div>
		            <div class="post-meta">
		            	<p class="date light-grey italic tiny text-center"><?php the_time(get_option('date_format')); ?></p>
		        		<hr />
		        		<h4 class="title text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
		            	<p class="excerpt arial small text-center dark-grey"><?php echo get_the_excerpt(); ?></p>
		            </div>
		        </div>
		        <?php $i++; ?>
				<?php endwhile; ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</footer>
</section><!-- #single -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>