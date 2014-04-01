<?php

require_once('atg-common.php');

function atg_get_unknown_attach_id() {
	/**
	 * @todo Utilizzo WPquery o simili
	 */
	global $wpdb;
	return $wpdb->get_var(" SELECT ID FROM wp_posts WHERE post_type = 'attachment' AND post_title = '".atg_get_option(ATG_UNKNOWN)."' ");
}

function atg_get_file_http($src, $dest) {

	$out = fopen($dest, 'wb');
	if (! $out){
		return false;
	}
	
		   
	$ch = curl_init();
		           
	curl_setopt($ch, CURLOPT_FILE, $out);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_URL, $src);
			               
	$res = curl_exec($ch);
			       
	curl_close($ch);
	fclose($out);

	return $res;
}


function atg_download_image_and_attach( $src, $parent_post_id = 0 ) {
	/**
	 * @todo Chmod corretto per nuovo folder
	 */

	$matches = array();
	if (! preg_match("/\\/([^\\/]+)\$/", $src, $matches)) {
		return NULL;
	}
	
	$filename = $matches[1];
	$filebasename = $filename;
	$fileext = '';
	if (preg_match('/^(.*)\.([^\.]*)$/', $filename, $matches)) {
		$filebasename = $matches[1];
		$fileext = ".$matches[2]";
	}

	$upload_dir = wp_upload_dir();
	$path = $upload_dir['path'];

	if (! file_exists($path)) {
		if (!mkdir($path, 0777, true)) {
			return false;
		}
	} else {
		if (file_exists("$path/$filename")) {
			$i = 1;
			$filename = $filebasename."_$i$fileext";
			while (file_exists("$path/$filename")) {
				$i++;
				$filename = $filebasename."_$i$fileext";
			}
			
		}
	}
	if (! atg_get_file_http($src, "$path/$filename")) {
		return false;
	}

	$attach_id = wp_insert_attachment( array('post_title' => $filename, 'post_content' => '', 'post_mime_type' => 'image/jpeg', 'post_status' => 'inherit'), "$path/$filename", $parent_post_id );
	$attach_data = wp_generate_attachment_metadata( $attach_id, "$path/$filename" );
	wp_update_attachment_metadata( $attach_id,  $attach_data );

	return $attach_id;

}

function atg_check_size ( $width, $height ) {
	$ratio = $width / $height;
	if (atg_get_option(ATG_MIN_WIDTH) && $width < atg_get_option(ATG_MIN_WIDTH)) {
		return false;
	} elseif (atg_get_option(ATG_MIN_HEIGHT) && $height < atg_get_option(ATG_MIN_HEIGHT)) {
		return false;
	} elseif (atg_get_option(ATG_ASPECT_RATIO)) {
		$min_ratio = atg_get_option(ATG_ASPECT_RATIO) * (1 - atg_get_option(ATG_ASPECT_RATIO_TOLERANCE));
		$max_ratio = atg_get_option(ATG_ASPECT_RATIO) * (1 + atg_get_option(ATG_ASPECT_RATIO_TOLERANCE));
		if ($ratio < $min_ratio || $ratio > $max_ratio) {
			return false;
		}		
	}
	return true;
} 
	
function atg_filter_post_thumbnail_html( $html = '', $post_id = NULL, $post_thumbnail_id = NULL, $size = 'post-thumbnail', $attr = '' ) {
	
	if ($html != '') {
		return $html;
	}

	$thumb_url = '';
	
	
	// First check for meta
	
	/*
	$thumb_url = get_post_meta($post_id, ATG_THUMB_URL, true);
	if ($thumb_url) {
		if (atg_get_option(ATG_DOWNLOAD)) {
			$attach_id = atg_download_and_attach_image($photo_url);
			if ($attach_id && atg_get_option(ATG_ADD)) {
				add_thumbnail($post_id, $attach_id);
				//	return get_src_from_img_tag(get_the_post_thumbnail($post_id, $size));
			}
		}
	}
	*/

	if ( ! $thumb_url ) {
		/**
		 * @todo Look for post attachments
		 */		
		
		/* Da fare il porting...
		$images =& get_children(array('post_type' => 'attachment', 'post_mime_type' => 'image', 'post_parent' =>  $post_id ));

		if (! empty($images)) {
			foreach ( $images as $attachment_id => $attachment ) {
				$photo_url = get_src_from_img_tag(wp_get_attachment_image($attachment_id, $size));
				if ($photo_url) {
					if ($add_thumb) {
						add_thumbnail($post_id, $attachment_id);
					}
					return $photo_url;
				}
			}
		}
		*/
		
	}
	
	if ( ! $thumb_url ) {
		$already_scanned = get_post_meta( $post_id, ATG_ALREADY_SCANNED, true );
		if (! $already_scanned || atg_get_option(ATG_IGNORE)) {

			add_post_meta($post_id, ATG_ALREADY_SCANNED, 'true', true);
			$queried_post = get_post($post_id);
			$content = $queried_post->post_content;
			$last_pos = strpos($content, "<img");
			while (! $last_pos === false) {
				$content = substr($content, $last_pos + 1);
				$photo_url = get_src_from_img_tag($content);
				if ($photo_url) {
					if (preg_match('/\.jpe?g$/i', $photo_url)) {
						$img_size = getimagesize($photo_url);
						if ($img_size) {
							if (atg_check_size($img_size[0], $img_size[1])) {
								$attach_id = atg_download_image_and_attach($photo_url);
								if ( $attach_id ) {
									add_thumbnail($post_id, $attach_id);
									return wp_get_attachment_image( $attach_id, $size, false, $attr );
								}
							}
						}
					}
				}
				$last_pos = strpos($content, "<img");
			}
		}
	}
	
	if (! $thumb_url ) {
		return wp_get_attachment_image( atg_get_unknown_attach_id(), $size, false, $attr );
	}
	
	return $html;
	
}

?>