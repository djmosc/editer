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
    
    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/libs/modernizr.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/plugins/jquery.easing.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/plugins/jquery.scroller.js"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/main.js"></script>

    
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrap" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="header" class="site-header" role="banner">
		<div class="container">
			<div class="center span five alpha omega">
				<h1 class="no-margin"><a class="ir logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			</div>
		</div>
		<div class="container">
			<nav role="navigation" class="site-navigation main-navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'clearfix', 'container' => false ) ); ?>
			</nav><!-- .site-navigation .main-navigation -->
		</div>

	</header><!-- #masthead .site-header -->

	<div id="main" class="site-main container">