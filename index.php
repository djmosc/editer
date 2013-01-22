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
<div id="index" class="column eightteen alpha omega">
	<div id="index-sidebar" class="widget-area five column alpha">
		<?php dynamic_sidebar( 'index' ); ?>
	</div>
	<div id="content" class="twelve column push-one alpha omega">
	
		<h3>
		<?php 
		_e("Archive", 'editer'); ?> - <?php 
		if(get_query_var('category_name')){
			$category = get_category_by_slug(get_query_var('category_name'));
			echo $category->name;
		} else {
			_e("All", 'editer');
		}
		?>
		</h3>
	
		<div class="archive">
			<div class="navigation">
				<a class="grid-btn display-type-btn arial current" data-display-type="grid"><?php _e("Show as images") ?></a>
				<a class="list-btn display-type-btn arial" data-display-type="list"><?php _e("Show as list") ?></a>
			</div>

			<?php 
				global $wp_query;
				query_posts(array_merge( $wp_query->query_vars, array('posts_per_page' => 20)));
			?>
			<div class="posts list hide" data-display-type="list">
				<?php $i = 0; ?>
				<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
					<?php
					$month = get_the_date('F Y', '', '', FALSE);
					if ($month !== $month_check) {
						if($i > 0) echo "</ul>";
						echo '<h4 class="month red small novecento-bold">' . $month . '</h4><ul class="clearfix">';
					}
					$month_check = $month;
					?>
					<li class="post">
						<header class="post-header">
							<h4 class="no-margin"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
							<p class="date no-margin small black arial"><?php the_time(get_option('date_format')); ?></p>
						</header>
						<div class="post-excerpt">
							<p class="no-margin">...<?php echo substr(strip_tags(get_the_content($post->ID)), 0, 200); ?>...</p>
						</div>
					</li>
				<?php $i++; ?>
				<?php endwhile; ?>
				<?php endif; ?>
				</ul>
			</div>
			<div class="posts grid" data-display-type="grid">
				<?php $columns = array('one', 'two', 'three'); ?>
				<?php $i = 0; ?>
				<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
					<?php
					$month = get_the_date('F Y', '', '', FALSE);
					if ($month !== $month_check) {
						if($i > 0) echo "</ul>";
						$i = 0;
						echo '<h4 class="month red small novecento-bold">' . $month . '</h4><ul class="clearfix">';
					}
					$month_check = $month;
					?>
					<li class="post left <?php echo $columns[$i % 3];?>">
						<a href="<?php the_permalink(); ?>" class="overlay-btn">
							<div class="overlay semi-black-bg">
								<h5 class="title didot-italic text-center white"><?php the_title(); ?></h5>
							</div>
							<?php the_post_thumbnail(array('168', '999')); ?>
						</a>
					</li>
					<?php $i++; ?>
					<?php endwhile; ?>
					<?php endif; ?>	
				</ul>
			</div>
			<?php wp_simple_pagination(); ?>
			<?php wp_reset_query(); // reset the query ?>
		</div> <!-- END .all -->
			<footer class="dotted-border">
				<div class="inner">
					<p class="text-center no-margin tiny">
						<a href="#" class="arial uppercase black">Back to top</a>
					</p>
				</div>
			</footer>
			
	</div> <!-- End Content -->

</div><!-- #index -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>