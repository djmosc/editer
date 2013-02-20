<?php
/**
 * The template for displaying search forms in editer
 *
 * @package editer
 * @since editer 1.0
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
		<input type="submit" class="submit" value="&raquo;" />
	</form>
