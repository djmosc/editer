<?php

add_shortcode( 'base_url', 'base_url_handler' );
function base_url_handler( $atts ) {
	return get_bloginfo('url');
}

add_shortcode( 'uploads_url', 'uploads_url_handler' );
function uploads_url_handler( $atts ) {
	$uploads_dir = wp_upload_dir();
	return $uploads_dir['baseurl'];
}

remove_shortcode('gallery');
add_shortcode( 'gallery', 'gallery_handler' );
function gallery_handler( $atts ) {
	global $post;
	$output = '';

    extract(shortcode_atts(array(
        'id'      => '0',
        'type'	  => 'gallery'
    ), $atts));

    $gallery = get_post($atts['id']);
	if($gallery) {
		$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $gallery->ID, 'orderby' => 'menu_order', 'order' => 'ASC' ); 
		$attachments = get_posts($args);
		$type = (isset($atts['type'])) ? $atts['type'] : 'gallery';
		switch($type){

			case 'shop':
				$output .= '<div class="shop" data-id="'.$gallery->ID.'">';
				$output .= apply_filters('the_content', $gallery->post_content);
				if (!empty($attachments)) {
					$output .= '<ul class="shop-list clearfix" >';
					$columns = array('first', 'second', 'third', 'fourth');
					$total_columns = count($columns);
					$i = 0;
					foreach ( $attachments as $attachment ) {
						$output .= '<li class="product span two-and-half '.$columns[$i % $total_columns].'">';
						$output .= '<div class="thumbnail">';
						$output .= '<a href="'.get_post_meta($attachment->ID, 'external_url', true).'" target="_blank">';
						$image = wp_get_attachment_image_src( $attachment->ID, 'custom_thumbnail' );
						$output .= '<img src="'.$image[0].'" />';
						$output .= '</a>';
						$output .= '</div>';
						$output .= '<div class="product-meta">';
						$output .= '<h5 class="title uppercase">'.$attachment->post_title.'</h5>';
						$output .= '<div class="description">';
						$output .=  apply_filters('the_content', $attachment->post_content);
						$output .= '<p class="no-margin">';
						$output .= '<a href="'.get_post_meta($attachment->ID, 'external_url', true).'" target="_blank" class="red-btn">'.__('Shop Now', 'editer').'</a>';
						$output .= '</p>';
						$output .= '</div>';
						$output .= '</div>';
						$output .= '</li>';
						$i++;
					}
					$output .= '</ul>';
				}
				$output .= '</div>';
				break;

			case 'how_to':
				$output .= '<div class="how-to" data-id="'.$gallery->ID.'">';
				$output .= apply_filters('the_content', $gallery->post_content);
				if (!empty($attachments)) {
					$output .= '<ul class="how-to-list clearfix" >';
					$columns = array('one', 'two');
					$total_columns = count($columns);
					$i = 0;
					foreach ( $attachments as $attachment ) {
						$output .= '<li class="span five step '.$columns[$i % $total_columns].'">';
						$output .= '<div class="thumbnail">';
						$image = wp_get_attachment_image_src( $attachment->ID, 'large' );
						$output .= '<a href="'.$image[0].'" class="fancybox" rel="how_to" title="'.$attachment->post_content.'">';
						$image = wp_get_attachment_image_src( $attachment->ID, 'custom_medium' );
						$output .= '<img src="'.$image[0].'" />';
						$output .= '</a>';
						$output .= '</div>';
						$output .= '<div class="product-meta clearfix">';
						$output .= '<span class="span two number didot-italic">';
						$output .= $i + 1;
						$output .= '</span>';
						$output .= '<div class="span eight description">';
						$output .=  apply_filters('the_content', $attachment->post_content);
						$output .= '</div>';
						$output .= '</div>';
						$output .= '</li>';
						$i++;
					}
					$output .= '</ul>';
				}
				$output .= '</div>';
				break;
			default;
				$output .= '<div class="gallery-scroller scroller" data-id="'.$gallery->ID.'">';
				$output .= apply_filters('the_content', $gallery->post_content);
				if (!empty($attachments)) {
					$output .= '<div class="scroller-mask">';
					$output .= '<div class="scroll-items-container clearfix">';
					foreach ( $attachments as $attachment ) {
						$output .= '<div class="scroll-item" data-id="'.$attachment->ID.'">';
						$output .= '<div class="image">';
						$image = wp_get_attachment_image_src( $attachment->ID, 'gallery' );
						$output .= '<img src="'.$image[0].'" width="'.$image[1].'" />';
						$output .= '</div>';
						$output .= '<div class="description">';
						$output .=  apply_filters('the_content', $attachment->post_content);
						$output .= '</div>';
						$output .= '</div>';
					}		
					$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="scroller-navigation">';
					$output .= '<a class="prev-btn"></a>';
					$output .= '<a class="next-btn"></a>';
					$output .= '</div>';
				}
				$output .= '</div>';
		}
	}
	return $output;
}

add_shortcode( 'embed_page', 'embed_page_handler' );
function embed_page_handler( $atts ) {
	global $post;
	$output = '';
    extract(shortcode_atts(array(
        'id'      => '0'
    ), $atts));

    $page = get_post($atts['id']);
	if($page) {
		$output .= '<div class="embed-page striped-border top left right bottom">';
		$output .= '<div class="inner">';
		$output .= '<header class="embed-page-header">';
		$output .= '<h3 class="text-center red didot-italic">'.get_the_title($page->ID).'</h3>';
		$output .= '</header>';
		$output .= '<div class="content">';
		$output .=  apply_filters('the_content', $page->post_content);
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';	
	}
	return $output;
}