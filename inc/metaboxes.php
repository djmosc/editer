<?php 
add_action('admin_init', 'add_custom_boxes');
add_action('admin_head', 'load_externals');

add_filter("attachment_fields_to_edit", 'image_fields_to_edit', null, 2);
add_filter("attachment_fields_to_save", 'image_fields_to_save', null , 2);

function add_custom_boxes(){
	$post_id = NULL;
	if(isset($_GET['post'])){
		$post_id = $_GET['post'];
	} elseif(isset($_POST['post_ID'])){
		$post_id = $_POST['post_ID'];
	}
	$post = get_post($post_id);
	$template_file = get_post_meta($post_id,'_wp_page_template', true);
 	
	if($post){
		add_meta_box('homepage_image_box', 'Homepage Image', 'homepage_image_input', 'post');
		add_meta_box('homepage_image_box', 'Homepage Image', 'homepage_image_input', 'ad');
		if($post->post_parent == 0){
			add_meta_box('homepage_image_box', 'Homepage Image', 'homepage_image_input', 'product');
		}
		if(in_category(get_editer_option('hts_category_id'), $post_id)){
			add_meta_box('hts_post_box', 'Hit the streets Fields', 'hts_post_input', 'post');
		}
		add_action('save_post', 'post_fields_save');
		
		
		add_meta_box('editor_box', 'Editor Fields', 'editor_input', 'editor');
		add_action('save_post', 'editor_fields_save');
		
		if($post->post_parent){
			add_meta_box('product_box', 'Product Fields', 'product_input', 'product');
			add_action('save_post', 'product_fields_save');
		}

		add_meta_box('ad_box', 'Ad Fields', 'ad_input', 'ad');
		add_action('save_post', 'ad_fields_save');

		
		// if (in_array($template_file, array('default', 'case-studies.php', 'work.php'))){
		// 	add_meta_box('default_box', 'Default Fields', 'default_fields_input', 'page');
		// 	add_action('save_post', 'default_fields_save');
		// }
		
		// add_meta_box('work_fields_box', 'Work Fields', 'work_fields_input', 'work');
		// add_action('save_post', 'work_fields_save');

		
	}
}

function load_externals(){
	?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/admin.css" />
	<script type="text/javascript">
		var themeUrl = '<?php bloginfo( 'template_url' ); ?>/';
		var baseUrl = '<?php bloginfo( 'url' ); ?>';
	</script>
	
	<!--script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/admin.js"></script-->
    <?php
}

/**************Homepage Image*****************/


function homepage_image_input(){
	global $post;
	$image_width = 266;
	$homepage_image_id = get_post_meta($post->ID, 'homepage_image_id', true);
	?>
    <input type="hidden" name="post_fields_nonce" value="<?php echo wp_create_nonce('post_fields');?>" />
	<script>
	jQuery(document).ready(function($) {

		var hasImage = <?php echo ($homepage_image_id) ? 'true' : 'false'; ?>;
		var uploadID;
		var originalSendToEditor = window.send_to_editor;
		var newSendToEditor;
		if(hasImage){
			$('.remove-homepage-image-btn').show();
			$('.upload-homepage-image-btn').hide();
			$('#homepage-image-link').show();
		} else {
			$('.remove-homepage-image-btn').hide();
			$('.upload-homepage-image-btn').show();
		}

		$('.upload-homepage-image-btn').click(function() {
			window.send_to_editor = newSendToEditor;
			uploadID = $('#homepage-image-id');
			tb_show('', 'media-upload.php?type=image&TB_iframe=true');
			return false;
		});

		$('.remove-homepage-image-btn').click(function() {
			uploadID = $('#homepage-image-id');
			uploadID.val('');
			uploadID = null;
			$('#homepage-image-link').html('');
			$('.remove-homepage-image-btn').hide();
			$('.upload-homepage-image-btn').show();
			return false;
		});

		newSendToEditor = function(html) {
			var id = '';
			var img = $(html);
			var classes = img.attr('class').split(' ');
			for(i in classes){
				var theClass = classes[i];

				if(theClass.indexOf('wp-image') !== -1){
					classAry = theClass.split('-');
					id = classAry[classAry.length - 1];
				}
			}

			uploadID.val(id);
			img.width(<?php echo $image_width; ?>).height('auto');
			$('.upload-homepage-image-btn').hide();
			$('.remove-homepage-image-btn').show();
			$('#homepage-image-link').show().html(img);
			tb_remove();
			window.send_to_editor = originalSendToEditor;
		}
	});
	</script>
	<p>
		<a href="#" id="homepage-image-link" class="upload-homepage-image-btn" style="display:none;">
			<?php if($homepage_image_id){
				$image_attributes = wp_get_attachment_image_src( $homepage_image_id );?> 
				<img src="<?php echo $image_attributes[0]; ?>" width="<?php echo $image_width; ?>" height="">
			<?php } ?>
		</a>
		<input type="hidden" id="homepage-image-id" name="homepage_image_id" value="<?php echo $homepage_image_id;?>" />
	</p>
	<p>
		<a href="#" class="upload-homepage-image-btn" style="display:none;">Set homepage image</a>
		<a href="#" class="remove-homepage-image-btn" style="display:none;">Remove homepage image</a>
	</p>
	<?php
}

/**************Hit the Streets Fields*****************/


function hts_post_input(){
	global $post;
	?>
    <!-- <input type="hidden" name="post_fields_nonce" value="<?php echo wp_create_nonce('post_fields_nonce');?>" /> -->
	<p>
		<label><b>Top Content:</b></label>
		<?php wp_editor( get_post_meta($post->ID, 'top_content', true), 'top_content');  ?>
	</p>
	<p>
		<label><b>Bottom Content:</b></label>
		<?php wp_editor( get_post_meta($post->ID, 'bottom_content', true), 'bottom_content');  ?>
	</p>
	<?php
}

function post_fields_save($post_id) {
	if(isset($_POST['post_fields_nonce'])){
		if (!wp_verify_nonce($_POST['post_fields_nonce'], 'post_fields')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		update_post_meta($post_id, 'homepage_image_id', $_POST['homepage_image_id']);
		update_post_meta($post_id, 'top_content', $_POST['top_content']);
		update_post_meta($post_id, 'bottom_content', $_POST['bottom_content']);
	}
}



/**************Editor Fields*****************/


function editor_input(){
	global $post;
	$user_id = get_post_meta($post->ID, 'user_id', true);
	$website_url = get_post_meta($post->ID, 'website_url', true);
	$twitter_url = get_post_meta($post->ID, 'twitter_url', true);
	$facebook_url = get_post_meta($post->ID, 'facebook_url', true);
	?>
    <input type="hidden" name="editor_fields_nonce" value="<?php echo wp_create_nonce('editor_fields');?>" />
	
	<p>
		<label>User: <?php

		$wp_user_query = new WP_User_Query(array('orderby' => 'display_name'));
		$users = $wp_user_query->get_results();
		if (!empty($users)) {
		    echo '<select name="user_id">';
		    echo '<option value="0">--Not a user--</option>';
		    foreach ($users as $user) {
		    	if(user_can($user->ID, 'edit_posts')){
		    		$user_info = get_userdata($user->ID);
			        echo '<option value="'.$user->ID.'"';
			        if($user_id == $user->ID) echo ' selected';
			        echo '>'.$user_info->display_name.'</option>';
			    }
		    }
		    echo '</select>';
		} else {
		    echo 'No users found';
		}
		?>
	</p>

	<table style="width: 300px;">
		<thead>
			<tr>
				<th colspan="2"><h4 style="text-align: left; margin: 0;">Social Links</h4></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<label>Website Url:</label>
				</td>
				<td>
					<input type="text" value="<?php echo $website_url; ?>" name="website_url" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Twitter Username: </label>
				</td>
				<td>
					<input type="text" value="<?php echo $twitter_url; ?>" name="twitter_url" placeholder="e.g: @UserName" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Facebook Url:</label>
				</td>
				<td>
					<input type="text" value="<?php echo $facebook_url; ?>" name="facebook_url" />
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

function editor_fields_save($post_id) {
	if(isset($_POST['editor_fields_nonce'])){
		if (!wp_verify_nonce($_POST['editor_fields_nonce'], 'editor_fields')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		update_post_meta($post_id, 'user_id', $_POST['user_id']);
		update_post_meta($post_id, 'website_url', $_POST['website_url']);
		update_post_meta($post_id, 'twitter_url', $_POST['twitter_url']);
		update_post_meta($post_id, 'facebook_url', $_POST['facebook_url']);
	}
}

/**************Product Fields*****************/


function product_input(){
	global $post;
	$price = get_post_meta($post->ID, 'price', true);
	$external_url = get_post_meta($post->ID, 'external_url', true);
	$image_left = get_post_meta($post->ID, 'image_left', true);
	$image_top = get_post_meta($post->ID, 'image_top', true);
	?>
    <input type="hidden" name="product_fields_nonce" value="<?php echo wp_create_nonce('product_fields');?>" />
	<p>
		<label><input type="checkbox" name="hidden" value="1" <?php echo (get_post_meta($post->ID, 'hidden', true) == '1' ) ? 'checked="checked"':'';?> /> Hide Product</label>
	</p>
	<table style="width: 300px;">
		<thead>
			<tr>
				<th colspan="2"><h4 style="text-align: left; margin: 0;">Product Options</h4></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<label>Price:</label>
				</td>
				<td>
					<input type="text" value="<?php echo $price; ?>" name="price" />
				</td>
			</tr>
			<tr>
				<td>
					<label>External Url:</label>
				</td>
				<td>
					<input type="text" value="<?php echo $external_url; ?>" name="external_url" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Image Position:</label>
				</td>
				<td>
					<input type="text" style="width: 50px;" value="<?php echo $image_top; ?>" name="image_top" placeholder="Top" />
					<input type="text" style="width: 50px;" value="<?php echo $image_left; ?>" name="image_left" placeholder="Left" />
					<small><i>(Top/Left)</i></small>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

function product_fields_save($post_id) {
	if(isset($_POST['product_fields_nonce'])){
		if (!wp_verify_nonce($_POST['product_fields_nonce'], 'product_fields')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		update_post_meta($post_id, 'price', $_POST['price']);
		update_post_meta($post_id, 'external_url', $_POST['external_url']);
		$hidden = (isset($_POST['hidden'])) ? '1' : '0';
		update_post_meta($post_id, 'hidden', $hidden);
		update_post_meta($post_id, 'image_top', $_POST['image_top']);
		update_post_meta($post_id, 'image_left', $_POST['image_left']);
	}
}


/**************Ad Fields*****************/


function ad_input(){
	global $post;
	$external_url = get_post_meta($post->ID, 'external_url', true);
	?>
    <input type="hidden" name="ad_fields_nonce" value="<?php echo wp_create_nonce('ad_fields');?>" />
	<table style="width: 300px;">
		<thead>
			<tr>
				<th colspan="2"><h4 style="text-align: left; margin: 0;">Ad Options</h4></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<label>External Url:</label>
				</td>
				<td>
					<input type="text" value="<?php echo $external_url; ?>" name="external_url" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Open new tab:</label>
				</td>
				<td>
					<input type="checkbox" name="new_tab" value="1" <?php echo (get_post_meta($post->ID, 'new_tab', true) == '1' ) ? 'checked="checked"':'';?> />
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

function ad_fields_save($post_id) {
	if(isset($_POST['ad_fields_nonce'])){
		if (!wp_verify_nonce($_POST['ad_fields_nonce'], 'ad_fields')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		update_post_meta($post_id, 'external_url', $_POST['external_url']);
		$new_tab = (isset($_POST['new_tab'])) ? '1' : '0';
		update_post_meta($post_id, 'new_tab', $new_tab);
	}
}


/**************Attachment Fields*****************/


function image_fields_to_edit($form_fields, $post){
	$form_fields['external_url'] = array(
		'label' => __("External Link"),
		'input' => 'text',
		'value' => get_post_meta($post->ID, 'external_url', true),
		'helps' => __("http://"),
	);
	return $form_fields;
}

function image_fields_to_save($post, $attachment) {
	if( isset($attachment['external_url']) ){
		update_post_meta($post['ID'], 'external_url', $attachment['external_url']);
	}
	return $post;
}