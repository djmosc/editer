<?php
/**
 * The Template for displaying all single posts.
 *
 * @package editer
 * @since editer 1.0
 */

get_header(); ?>

<section id="category">
	<?php if(!is_paged()): ?>
	<div id="category-sidebar" class="widget-area two span alpha omega">
		<?php dynamic_sidebar( 'category' ); ?>
	</div>
	<div id="content" class="span five alpha omega">
		<?php dynamic_sidebar( 'category_content' ); ?>
	</div><!-- #content -->
	<?php else: ?>
	<div  class="paged span seven-and-half alpha omega">
		<header class="header clearfix">
			<div class="category-image span one alpha omega">
				<?php 
				$categories = get_the_category();
				$category = get_top_level_category($categories[0]->term_id);		
				$image_id = get_field('image_id', 'category_'.$category->term_id);
				if($image_id):
					$image = wp_get_attachment_image_src($image_id, 'thumbnail');
				?>
				<a href="<?php echo get_category_link( $category->term_id ); ?>">
					<img src="<?php echo $image[0]; ?>" class="scale" />
				</a>
				<?php endif; ?>
			</div>
			<div class="span nine omega">
				<nav class="category-navigation">
					<ul class="clearfix">
						<?php
						wp_list_categories(array('title_li' => '', 'child_of' => $category->term_id));
						?>
					</ul>
				</nav>
			</div>
		</header>
		<div id="posts" class="clearfix" >
		<?php $i = 0;?>
		<?php while ( have_posts() ) : the_post(); ?>

			<div class="post border span four small <?php echo ($i % 2) ? 'left' : 'right';?> ">
				<div class="thumbnail featured-image">
					<?php $image_size =  array(380, 999);?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($image_size, array('title' => '', 'class' => 'scale')); ?></a>
			    	
				</div>
				<div class="post-meta">
					<?php get_template_part( 'inc/category'); ?>
					<hr />
					<h3 class="title text-center uppercase"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="excerpt dark-grey small arial text-center"><?php echo get_the_excerpt(); ?></p>
				</div>
				<footer class="footer striped-border top">
                    <div class="inner clearfix">
                        <div class="span five alpha omega">
                        	<span class="tiny light-grey text-center"><?php the_time(get_option('date_format')); ?></span>
                        </div>
                        <div class="span five alpha omega">
                            <p class="no-margin text-right">
                                <a href="<?php the_permalink(); ?>" class="red-btn read-more-btn"><?php _e("Read More", 'editer'); ?></a>
                            </p>
                        </div>
                    </div>
                </footer>
			</div>
			<?php if($i % 2): ?><div class="clearfix"></div><?php endif; ?>
		<?php $i++; ?>
		<?php endwhile; ?>
		<?php //wp_simple_pagination(); ?>
		</div><!-- #posts -->
	</div>
	<?php endif; ?>
	<?php get_sidebar(); ?>
</section><!-- #primary .content-area -->
<?php get_footer(); ?>