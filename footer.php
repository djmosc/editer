<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package editer
 * @since editer 1.0
 */
?>

	</div><!-- #main .site-main -->
	<div id="subscribe">
		<div class="inner container">
			<div class="span ten">
				<?php gravity_form(2); ?>
			</div>
		</div>
	</div>
	<footer id="footer" class="site-footer" role="contentinfo">
		<div class="inner container">
			<div class="alpha two span">
				<h1 class="no-margin">
					<a class="ir logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<nav role="navigation" class="site-navigation footer-navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false ) ); ?>
				</nav><!-- .site-navigation .main-navigation -->
			</div>
			<div class="omega eight span alpha">
				<nav role="navigation" class="site-navigation main-navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'clearfix', 'container' => false ) ); ?>
				</nav><!-- .site-navigation .main-navigation -->
				<div class="right social">
					<a href="https://twitter.com/editerdotcom" target="_blank" class="twitter-btn">Twitter</a>
					<a href="https://www.facebook.com/editerdotcom" target="_blank" class="facebook-btn">Facebook</a>
					<a href="http://editerdotcom.tumblr.com/" target="_blank" class="tumblr-btn">Tumblr</a>
					<a class="pinterest-btn">Pinterest</a>
					<!-- <a href="http://pinterest.com/editerdotcom/" target="_blank" class="pinterest-btn">Pinterest</a> -->
				</div>
			</div>
		</div>
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
var _gaq = _gaq || [];_gaq.push(["_setAccount", "UA-26694866-2"]);
_gaq.push(["_trackPageview"]);
(function() {
	var ga = document.createElement("script");
	ga.type = "text/javascript";ga.async = true;
	ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";var s = document.getElementsByTagName("script")[0];
	s.parentNode.insertBefore(ga, s);
})();
//--><!]]>
</script>

</body>
</html>