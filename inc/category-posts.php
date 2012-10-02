<?php 
$categories = get_the_category();
$category = get_top_level_category($categories[0]->term_id);
$custom_query = new WP_Query( array('cat' => $category->term_id, 'post__not_in' => array($post->ID),'posts_per_page' => 3, 'post_type' => array('post'), 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'limit' => 3));
if ( $custom_query->have_posts() ) :
?>
<div class="category-posts">
	<header class="category-posts-header thick-border-bottom">
        <h5 class="black uppercase novecento-bold small title text-center">More in <a href="<?php echo get_category_link($category->term_id);?>" class="red"><?php echo $category->cat_name; ?></a></h5>
    </header>
	<!-- <p class="align-right no-margin arial small"><a href="<?php echo get_category_link($category->term_id);?>" class="red">show all in <span class="uppercase"><?php echo $category->cat_name; ?></span> &raquo;</a></p> -->
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