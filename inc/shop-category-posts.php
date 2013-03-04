<?php
$categories = get_the_terms($post->ID, 'shop_category');
$categories = array_slice($categories, 0, 1);
$category = get_top_level_category($categories[0]->term_id, 'shop_category');
$custom_query = new WP_Query(
    array('tax_query' => array(
        array(
            'taxonomy' => 'shop_category',
            'field' => 'ID',
            'terms' => $category->term_id
        )
    ),
    'post__not_in' => array($post->ID),
    'posts_per_page' => 5,
    'post_type' => array('shop'),
    'no_found_rows' => true,
    'post_status' => 'publish',
    'ignore_sticky_posts' => true, 
    'limit' => 5)
);
if ( $custom_query->have_posts() ) :
?>
<div class="shop-category-posts">
	<header class="category-posts-header thick-border-bottom">
        <h5 class="black uppercase novecento-bold small title text-center"><?php _e("More in", 'editer') ?> <a href="<?php echo get_category_link($category->term_id);?>" class="red"><?php echo $category->name; ?></a></h5>
    </header>
	<!-- <p class="align-right no-margin arial small"><a href="<?php echo get_category_link($category->term_id);?>" class="red">show all in <span class="uppercase"><?php echo $category->cat_name; ?></span> &raquo;</a></p> -->
	<div class="clearfix posts">
		<?php $i = 0; ?>
		<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
		 <div class="post span two">
        	<div class="inner border">
                <div class="thumbnail featured-image">
            		<a href="<?php the_permalink();?>">
            			<?php the_post_thumbnail(array(250, 999), array('title' => get_the_title(), 'class' => 'scale')); ?>
            		</a>
            		
            	</div>
                <div class="post-meta">
                	<p class="tiny light-grey text-center"><?php the_time(get_option('date_format')); ?></p>
                    <hr />
            		<h4 class="title text-center uppercase"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                	<p class="excerpt arial small text-center dark-grey"><?php echo get_the_excerpt(); ?></p>
                </div>
                
            </div>
        </div>
        <?php $i++; ?>
        <?php endwhile; ?>
	</div>
    <footer class="category-posts-footer thick-border-top text-right">
        <a href="<?php echo get_category_link($category->term_id);?>" class="black-btn see-all-btn"><?php _e("See All", 'editer'); ?></a>
    </footer>
</div>
<?php wp_reset_query(); ?>
<?php wp_reset_postdata(); ?>
<?php endif; ?>