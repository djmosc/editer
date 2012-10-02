<?php
remove_filter('template_redirect', 'redirect_canonical');
add_action('init', 'post_types_init');
function post_types_init(){
	
	/*****Gallery*****/
	
	$labels = array(
		'name' => _x('Galleries', 'post type general name'),
		'singular_name' => _x('Gallery', 'post type singular name'),
		'add_new' => _x('Add New', 'gallery'),
		'add_new_item' => __('Add New Gallery'),
		'edit_item' => __('Edit Gallery'),
		'new_item' => __('New Gallery'),
		'all_items' => __('All Galleries'),
		'view_item' => __('View Gallery'),
		'search_items' => __('Search Galleries'),
		'not_found' =>  __('No Galleries found'),
		'not_found_in_trash' => __('No galleries found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Galleries'
	
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => 'galleries'),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'page-attributes')
	);
	register_post_type('gallery',$args);
	

	/*****Editor*****/
	
	$labels = array(
		'name' => _x('Editors', 'post type general name'),
		'singular_name' => _x('Editor', 'post type singular name'),
		'add_new' => _x('Add New', 'editor'),
		'add_new_item' => __('Add New Editor'),
		'edit_item' => __('Edit Editor'),
		'new_item' => __('New Editor'),
		'all_items' => __('All Editors'),
		'view_item' => __('View Editor'),
		'search_items' => __('Search Editors'),
		'not_found' =>  __('No Editors found'),
		'not_found_in_trash' => __('No editors found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Editors'
	
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => 'editors'),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')
	);
	register_post_type('editor',$args);
	
	/*****Product*****/
	
	$labels = array(
		'name' => _x('Products', 'post type general name'),
		'singular_name' => _x('Product', 'post type singular name'),
		'add_new' => _x('Add New', 'product'),
		'add_new_item' => __('Add New Product'),
		'edit_item' => __('Edit Product'),
		'new_item' => __('New Product'),
		'all_items' => __('All Products'),
		'view_item' => __('View Product'),
		'search_items' => __('Search Products'),
		'not_found' =>  __('No Products found'),
		'not_found_in_trash' => __('No products found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Products'
	
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => 'products'),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => true,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')
	);

	register_post_type('product',$args);
	
	/*****Ad*****/
	
	$labels = array(
		'name' => _x('Ads', 'post type general name'),
		'singular_name' => _x('Ad', 'post type singular name'),
		'add_new' => _x('Add New', 'ad'),
		'add_new_item' => __('Add New Ad'),
		'edit_item' => __('Edit Ad'),
		'new_item' => __('New Ad'),
		'all_items' => __('All Ads'),
		'view_item' => __('View Ad'),
		'search_items' => __('Search Ads'),
		'not_found' =>  __('No Ads found'),
		'not_found_in_trash' => __('No ads found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Ads'
	
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => 'ads'),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')
	);

	register_post_type('ad',$args);


	/*****Embed Page*****/
	
	$labels = array(
		'name' => _x('Embed Pages', 'post type general name'),
		'singular_name' => _x('Embed Page', 'post type singular name'),
		'add_new' => _x('Add New', 'embed_page'),
		'add_new_item' => __('Add New Embed Page'),
		'edit_item' => __('Edit Embed Page'),
		'new_item' => __('New Embed Page'),
		'all_items' => __('All Embed Pages'),
		'view_item' => __('View Embed Page'),
		'search_items' => __('Search Embed Pages'),
		'not_found' =>  __('No Embed Pages found'),
		'not_found_in_trash' => __('No Embed Pages found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Embed Pages'
	
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => 'embed-pages'),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor')
	);

	register_post_type('embed_page',$args);

	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

add_filter('post_updated_messages', 'custom_post_updated_messages');
function custom_post_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['galleries'] = array(
    0 => '',
    1 => sprintf( __('Gallery updated. <a href="%s">View gallery</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Gallery updated.'),    5 => isset($_GET['revision']) ? sprintf( __('Gallery restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Gallery published. <a href="%s">View work</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Gallery saved.'),
    8 => sprintf( __('Gallery submitted. <a target="_blank" href="%s">Preview Gallery</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Gallery scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Work</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Gallery draft updated. <a target="_blank" href="%s">Preview Gallery</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  $messages['editors'] = array(
    0 => '',
    1 => sprintf( __('Editor updated. <a href="%s">View editor</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Editor updated.'),    5 => isset($_GET['revision']) ? sprintf( __('Editor restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Editor published. <a href="%s">View editor</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Editor saved.'),
    8 => sprintf( __('Editor submitted. <a target="_blank" href="%s">Preview editor</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Editor scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Editor</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Editor draft updated. <a target="_blank" href="%s">Preview Editor</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  $messages['products'] = array(
    0 => '',
    1 => sprintf( __('Product updated. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Product updated.'),    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Product published. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.'),
    8 => sprintf( __('Product submitted. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Product</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview Product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );


  $messages['ads'] = array(
    0 => '',
    1 => sprintf( __('Ad updated. <a href="%s">View ad</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Ad updated.'),    5 => isset($_GET['revision']) ? sprintf( __('Ad restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Ad published. <a href="%s">View ad</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Ad saved.'),
    8 => sprintf( __('Ad submitted. <a target="_blank" href="%s">Preview ad</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Ad scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Ad</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Ad draft updated. <a target="_blank" href="%s">Preview Ad</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );


  $messages['embed_pages'] = array(
    0 => '',
    1 => sprintf( __('Embed Page updated. <a href="%s">View Embed Page</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Embed Page updated.'),    5 => isset($_GET['revision']) ? sprintf( __('Embed Page restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Embed Page published. <a href="%s">View Embed Page</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Embed Page saved.'),
    8 => sprintf( __('Embed Page submitted. <a target="_blank" href="%s">Preview Embed Page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Embed Page scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Embed Page</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Embed Page draft updated. <a target="_blank" href="%s">Preview Embed Page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  

  return $messages;
}

// add_filter('manage_edit-work_columns', 'work_columns');
// function work_columns($columns) {
//     $columns['case_study'] = 'Case Study';
//     $columns['featured'] = 'Featured';
//     return $columns;
// }

// add_action('manage_posts_custom_column',  'work_show_columns');
// function work_show_columns($name) {
//     global $post;
//     switch ($name) {
//         case 'case_study':
//             echo (get_post_meta($post->ID, 'case_study', true) == '1' ) ? 'Yes':'No';
//             break;
//         case 'featured':
//             echo (get_post_meta($post->ID, 'featured', true) == '1' ) ? 'Yes':'No';
//             break;
//     }
// }


?>