<?php

define('ATG_PREFIX', 'atg');

// SETTINGS
define('ATG_IGNORE', ATG_PREFIX . '_ignore');
define('ATG_UNKNOWN', ATG_PREFIX . '_unknown');
define('ATG_MIN_WIDTH', ATG_PREFIX . '_min_width');
define('ATG_MIN_HEIGHT', ATG_PREFIX . '_min_height');
define('ATG_ASPECT_RATIO', ATG_PREFIX . '_aspect_ratio');
define('ATG_ASPECT_RATIO_TOLERANCE', ATG_PREFIX . '_aspect_ratio_tolerance');

// META
define('ATG_ALREADY_SCANNED', '_' . ATG_PREFIX . '_already_scanned');

// NONCE ACTIONS
define('ATG_EDIT_META' , ATG_PREFIX . '-edit-meta');


function atg_get_option( $option_name ) {
	/**
	 * @todo Set default values for defined options
	 */
	$default = NULL;
	
	if ( $option_name == ATG_UNKNOWN) {
		$default = 'unknown-thumbnail';
	} 
	
	return get_option( $option_name, $default );
}

?>