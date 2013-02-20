<?php
/**
 * editer functions and definitions
 *
 * @package editer
 * @since editer 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since editer 1.0
 */

if ( ! function_exists( 'editer_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since editer 1.0
 */
function editer_setup() {

	require( get_template_directory() . '/inc/post_types.php' );

	require( get_template_directory() . '/inc/metaboxes.php' );

	require( get_template_directory() . '/inc/shortcodes.php' );

	require( get_template_directory() . '/inc/widgets/post-widget.php' );

	require( get_template_directory() . '/inc/widgets/twitter-feed-widget.php' );

	require( get_template_directory() . '/inc/widgets/pinterest-widget.php' );

	require( get_template_directory() . '/inc/widgets/facebook-widget.php' );

	require( get_template_directory() . '/inc/widgets/sub-menu-widget.php' );

	require( get_template_directory() . '/inc/widgets/weekly-edit-widget.php' );

	require( get_template_directory() . '/inc/widgets/ad-widget.php' );

	require( get_template_directory() . '/inc/widgets/related-posts-widget.php' );

	require( get_template_directory() . '/inc/widgets/tumblr-widget.php' );




	require( get_template_directory() . '/inc/options.php' );
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on editer, use a find and replace
	 * to change 'editer' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'editer', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'editer' ),
		'footer' => __( 'Footer Menu', 'editer' )
	) );

	add_image_size( 'gallery', 580, 9999);
	add_image_size( 'custom_large', 530, 650, true);
	add_image_size( 'custom_medium', 380, 250, true);
	add_image_size( 'custom_thumbnail', 210, 9999);

	add_filter('jpeg_quality', function($arg){return 100;});

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'gallery' ) );

	add_filter('next_posts_link_attributes', 'posts_link_next_class');
	function posts_link_next_class() {
		return 'class="next-btn"';
	} 
	
	add_filter('previous_posts_link_attributes', 'posts_link_prev_class');
	function posts_link_prev_class() {
		return 'class="prev-btn"';
	}

	add_filter('excerpt_more', 'new_excerpt_more');

	function new_excerpt_more($more) {
		return '...';
	}

	function remove_menus () {
		global $menu;
		$restricted = array(__('Links'),__('Comments'));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)) unset($menu[key($menu)]);
		}
	}
	add_action('admin_menu', 'remove_menus');

	add_filter('widget_text', 'do_shortcode');

}
endif; // editer_setup
add_action( 'after_setup_theme', 'editer_setup' );


if(function_exists('register_field')) {
	register_field('Users_field', dirname(__File__) . '/inc/fields/users_field/users_field.php');
}
/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since editer 1.0
 */
function editer_widgets_init() {

	/********************** Sidebars ***********************/

	register_sidebar( array(
		'name' => __( 'Default Sidebar', 'editer' ),
		'id' => 'default',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title no-margin text-center didot-italic">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Homepage Sidebar', 'editer' ),
		'id' => 'homepage',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title no-margin text-center avenir-bold">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Page Sidebar', 'editer' ),
		'id' => 'page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title no-margin text-center didot-italic">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Editor Sidebar', 'editer' ),
		'id' => 'editor',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title no-margin text-center didot-italic">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Post Sidebar', 'editer' ),
		'id' => 'post',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title no-margin text-center didot-italic">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Index Sidebar', 'editer' ),
		'id' => 'index',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title no-margin text-center didot-italic">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Category Sidebar', 'editer' ),
		'id' => 'category',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title no-margin text-center didot-italic">',
		'after_title' => '</h3>',
	) );



	/********************** Content ***********************/


	register_sidebar( array(
		'name' => __( 'Homepage Content', 'editer' ),
		'id' => 'homepage_content',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title no-margin text-center avenir-bold">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'editer_widgets_init' );



if ( ! function_exists( 'get_top_level_category' )) {
	function get_top_level_category($id){
		$category = get_category($id);
		$parent_category = NULL;
		if($category->category_parent != 0){
			$parent_category = get_top_level_category($category->category_parent );
		} else {
			$parent_category = get_category($category->cat_ID);
		}
		return $parent_category;
	}
}

if ( ! function_exists( 'get_sub_category' )) {
	function get_sub_category($id){
		$sub_categories = get_categories( array('child_of' => $id, 'hierarchical' => false, 'orderby' => 'count'));
		foreach($sub_categories as $sub_category){
			if(has_category($sub_category->term_id)){
				$category = $sub_category;
			}
		}

		return $category;
	}
}

function get_the_adjacent_fukn_post($adjacent, $post_type = 'post', $category = array(), $post_parent = 0){
	global $post;
	$args = array( 
		'post_type' => $post_type,
		'order' => 'ASC', 
		'posts_per_page' => -1,
		'category__in' => $category,
		'post_parent' => $post_parent
	);
	
	$curr_post = $post;
	$new_post = NULL;
	$custom_query = new WP_Query($args);
	$posts = $custom_query->get_posts();
	$total_posts = count($posts);
	$i = 0;
	foreach($posts as $a_post) {
		if($a_post->ID == $curr_post->ID){
			if($adjacent == 'next'){
				$new_i = ($i + 1 >= $total_posts) ? 0 : $i + 1; 
				$new_post = $posts[$new_i];	
			} else {
				$new_i = ($i - 1 <= 0) ? $total_posts - 1 : $i - 1; 
				$new_post = $posts[$new_i];	
			}
			break;	
		}
		$i++;
	}
	
	return $new_post;
}

function get_editer_option($option){
	$options = get_option('editer_theme_options');
	return $options[$option];
}

if ( ! function_exists( 'array_insert' )) {
	function array_insert(&$array,$element,$position=null) {
		if (count($array) == 0) {
			$array[] = $element;
		} elseif (is_numeric($position) && $position < 0) {
			if((count($array)+position) < 0) {
				$array = array_insert($array,$element,0);
			} else {
				$array[count($array)+$position] = $element;
			}
		} else if (is_numeric($position) && isset($array[$position])) {
			$part1 = array_slice($array,0,$position,true);
			$part2 = array_slice($array,$position,null,true);
			$array = array_merge($part1,array($position=>$element),$part2);
			foreach($array as $key=>$item) {
				if (is_null($item)) {
					unset($array[$key]);
				}
			}
		} else if (is_null($position)) {
			$array[] = $element;
		} else if (!isset($array[$position])) {
			$array[$position] = $element;
		}
		$array = array_merge($array);
		return $array;
	}
}

function get_the_editor($user_id = 0){
	$args = array( 
		'post_type' => 'editor',
		'order' => 'ASC', 
		'posts_per_page' => -1
	);
	
	$custom_query = new WP_Query($args);
	$posts = $custom_query->get_posts();
	foreach($posts as $post) {
		if(get_post_meta($post->ID, 'user_id', true) == $user_id){
			return $post;
		}
	}
}