<?php

require_once 'atg-common.php';
require_once 'atg-admin-render.php';

function atg_admin_init( ) {
	
	$section_id = ATG_PREFIX . '_settings';
	
	register_setting( 'media', ATG_IGNORE );
	register_setting( 'media', ATG_UNKNOWN );	
	register_setting( 'media', ATG_MIN_WIDTH );
	register_setting( 'media', ATG_MIN_HEIGHT );
	register_setting( 'media', ATG_ASPECT_RATIO );
	register_setting( 'media', ATG_ASPECT_RATIO_TOLERANCE );
	
	add_settings_section( $section_id, __('Automatic Thunbnail Generator'), 'atg_render_settings_section', 'media' );
	add_settings_field(
		ATG_IGNORE, 
		__('Ignore previously scanned'), 
		'atg_render_setting', 
		'media', 
		$section_id, 
		array( 
			'id'          => ATG_IGNORE,
			'description' => __('If not checked, previously scanned posts will not be parsed any more'),
			'type'        => 'checkbox' 
		) 
	);
	add_settings_field(
		ATG_UNKNOWN, 
		__('Unknown image'), 
		'atg_render_setting', 
		'media', 
		$section_id, 
		array( 
			'id'          => ATG_UNKNOWN,
			'description' => __('Name of library image to show if no thumbnail is found'),
			'type'        => 'text' 
		) 
	);
	add_settings_field(
		ATG_MIN_WIDTH, 
		__('Minimum Width'), 
		'atg_render_setting', 
		'media', 
		$section_id, 
		array( 
			'id'          => ATG_MIN_WIDTH,
			'description' => __('Minimum width for thumbnails'),
			'type'        => 'text' 
		) 
	);
	add_settings_field(
		ATG_MIN_HEIGHT, 
		__('Minimum Height'), 
		'atg_render_setting', 
		'media', 
		$section_id, 
		array( 
			'id'          => ATG_MIN_HEIGHT,
			'description' => __('Minimum height for thumbnails'),
			'type'        => 'text' 
		) 
	);
	add_settings_field(
		ATG_ASPECT_RATIO, 
		__('Aspect ratio'), 
		'atg_render_setting', 
		'media', 
		$section_id, 
		array( 
			'id'          => ATG_ASPECT_RATIO,
			'description' => __('Aspect ratio for thumbnails'),
			'type'        => 'text' 
		) 
	);
	add_settings_field(
		ATG_ASPECT_RATIO_TOLERANCE, 
		__('Aspect ratio tolerance'), 
		'atg_render_setting', 
		'media', 
		$section_id, 
		array( 
			'id'          => ATG_ASPECT_RATIO_TOLERANCE,
			'description' => __('Aspect ratio tolerance'),
			'type'        => 'text' 
		) 
	);
}

function atg_admin_menu( ) {
	add_meta_box(ATG_PREFIX . '_post_edit', __('Automatic Thumbnail'), 'atg_render_edit_post_gui', 'post', 'side');	
}

function atg_save_post ( $post_id ) {
	
	if ($_POST['post_type'] == 'post') {
	
		check_admin_referer(ATG_EDIT_META, ATG_EDIT_META . '_nonce');
		
		if (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		
		$old_already_scanned = get_post_meta($post_id, ATG_ALREADY_SCANNED, true);
		$new_already_scanned = $_POST[ATG_ALREADY_SCANNED];
		
		if ( $new_already_scanned != $old_already_scanned ) {
			if (! $new_already_scanned ) {
				delete_post_meta($post_id, ATG_ALREADY_SCANNED);
			} else {
				update_post_meta($post_id, ATG_ALREADY_SCANNED, $new_already_scanned);
			}
		}
	}
}


?>