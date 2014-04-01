<?php
/*
Plugin Name: Custom Author Byline
Plugin URI: http://seoserpent.com/wordpress/custom-author-byline
Version: 1.2
License: GPL2
Description: Allows you to add a custom author name to the byline other than the logged in user writing/editing the post/page.
Usage:  If the author of your post or page entry is different than your logged in user and you don't want to have to create a separate user account, just add the name as you'd like it to appear to the Custom Author Byline panel in the post/page editor.  Easy!
Author: Marty Martin
Author URI: http://seoserpent.com/wordpress/
*/

// Replaces the_author() output with your custom entry or return the logged in user if there is no custom entry
function custom_author_byline( $author ) {
	global $post;
	$custom_author = get_post_meta($post->ID, 'author', TRUE);
	if($custom_author)
		return $custom_author;
	return $author;
}
add_filter('the_author','custom_author_byline');

// Replaces the_author_link() output with your custom entry or return the logged in user if there is no custom entry
function custom_author_uri( $author_uri ) {
	//global $authordata;
	global $post, $authordata;
	$custom_author_uri = get_post_meta($post->ID, 'uri', TRUE); 
	if($custom_author_uri)
		return $custom_author_uri;
	return $author_uri;
}
add_filter( 'author_link', 'custom_author_uri' );


// Add custom write panel to post editor page (props to Spencer at Function http://wefunction.com/2008/10/tutorial-creating-custom-write-panels-in-wordpress/)
$cab_new_meta_boxes =
	array(
		"author" => array(
			"name" => "author",
			"std" => "",
			"description" => "Add a custom author name (other than your own) to override giving yourself credit for this post."
		),
		"author_uri" => array(
			"name" => "uri",
			"std" => "",
			"description" => "Add a link to your author's webpage (internal or external)."
		)
	);

function cab_new_meta_boxes() {
	global $post, $cab_new_meta_boxes;

	foreach($cab_new_meta_boxes as $meta_box) {
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);

		if($meta_box_value == "") {
			$meta_box_value = $meta_box['std'];
		}
		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
		echo'<p><input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" size="55" /><br />';
		echo'<label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label></p>';
	}
}

function cab_create_meta_box() {
	global $theme_name;
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'cab-new-meta-boxes', 'Custom Author Byline', 'cab_new_meta_boxes', 'post', 'normal', 'high' );
		add_meta_box( 'cab-new-meta-boxes', 'Custom Author Byline', 'cab_new_meta_boxes', 'page', 'normal', 'high' );
		// You can edit the below to add Custom Post Type support for the plugin.  Uncomment the line and replace 'custom_post_type' with your custom post type slug
		// You can instead add the below line to your theme's functions.php to "future-proof" your changes from being overwritten by upgrades to this plugin
		//add_meta_box( 'cab-new-meta-boxes', 'Custom Author Byline', 'cab_new_meta_boxes', 'custom_post_type', 'normal', 'high' );
	}
}

function cab_save_postdata( $post_id ) {
	global $post, $cab_new_meta_boxes;

	foreach($cab_new_meta_boxes as $meta_box) {
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
			return $post_id;
		}

		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ))
			return $post_id;
		} else {
			if ( !current_user_can( 'edit_post', $post_id ))
			return $post_id;
		}

		$data = $_POST[$meta_box['name']];

		if(get_post_meta($post_id, $meta_box['name']) == "")
			add_post_meta($post_id, $meta_box['name'], $data, true);
		elseif($data != get_post_meta($post_id, $meta_box['name'], true))
			update_post_meta($post_id, $meta_box['name'], $data);
		elseif($data == "")
		delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
	}
}
add_action('admin_menu', 'cab_create_meta_box');
add_action('save_post', 'cab_save_postdata');

?>