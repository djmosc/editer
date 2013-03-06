<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package editer
 * @since editer 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!-- <meta name="viewport" content="width=device-width" /> -->
	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/style.css" />
    <link type="text/css" rel="stylesheet" href="http://fast.fonts.com/cssapi/f156b48a-eb23-4ef8-9924-e69840e6f4c9.css"/>

    
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    
    <script type="text/javascript">
		var themeUrl = '<?php bloginfo( 'template_url' ); ?>';
		var baseUrl = '<?php bloginfo( 'url' ); ?>';
	</script>
    <?php

	if ( ! is_admin() ) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri().'/js/libs/jquery.min.js', false, '1.9.1');
        wp_enqueue_script('jquery');
    }
	
	function load_js() {
		wp_enqueue_script('modernizr', get_template_directory_uri().'/js/libs/modernizr.min.js');
		wp_enqueue_script('jquery', get_template_directory_uri().'/js/libs/jquery.min.js');
		wp_enqueue_script('easing', get_template_directory_uri().'/js/plugins/jquery.easing.js', array('jquery'), '', true);
		wp_enqueue_script('scroller', get_template_directory_uri().'/js/plugins/jquery.scroller.js', array('jquery'), '', true);
		wp_enqueue_script('imagesloaded', get_template_directory_uri().'/js/plugins/jquery.imagesloaded.min.js', array('jquery'), '', true);
		wp_enqueue_script('masonry', get_template_directory_uri().'/js/plugins/jquery.masonry.js', array('jquery'), '', true);
		
		// if(is_post_type_archive('shop')){
		// }

		if(is_page_template('template-instagram.php')){
			wp_enqueue_script('instagram', get_template_directory_uri().'/js/plugins/jquery.instagram.js', array('jquery'), '', true);
		}
		wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery'), '', true);
	}
	add_action('wp_enqueue_scripts', 'load_js');
	?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrap" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="header" class="site-header" role="banner">
		<div class="container">
			<div class="center span three alpha omega text-center">
				<h1 class="no-margin text-center logo-container"><a class="logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<p class="didot-italic description"><?php bloginfo('description'); ?></p>
			</div>
		</div>
		<div class="container">
			<nav role="navigation" class="site-navigation main-navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'clearfix', 'container' => false ) ); ?>
			</nav><!-- .site-navigation .main-navigation -->
		</div>

	</header><!-- #masthead .site-header -->

	<div id="main" class="site-main container">