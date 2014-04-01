<?php
function atg_render_settings_section( ) {
}

function atg_render_setting( $parameters ) {
	?>
	<fieldset>
		<legend class="screen-reader-text">
			<span><?php echo $parameters['description']; ?></span>
		</legend>
		<label for="<?php echo $parameters['id']; ?>">
			<?php if ( $parameters['type'] == 'checkbox'): ?>
				<input name="<?php echo $parameters['id']; ?>" id="<?php echo $parameters['id']; ?>" value="1" <?php if ( atg_get_option( $parameters['id'] ) ) echo 'checked="checked"'; ?> type="checkbox"/>
				<?php echo $parameters['description']; ?>
			<?php elseif ( $parameters['type'] == 'text'): ?>
				<input type="text" class="regular-text code" value="<?php echo atg_get_option( $parameters['id'] ); ?>" id="<?php echo $parameters['id']; ?>" name="<?php echo $parameters['id']; ?>">
				<span class="description"><?php echo $parameters['description']; ?></span>
			<?php endif;?>
		</label>
	</fieldset>
	<?php 
}

function atg_render_edit_post_gui () {
	global $post;
	
	wp_nonce_field(ATG_EDIT_META, ATG_EDIT_META . '_nonce');
	
	?>
	
	<div class="inside">
		<p class="meta-options">
			<label class="selectit" for="<?php echo ATG_ALREADY_SCANNED; ?>"><input type="checkbox" <?php if ( get_post_meta( $post->ID, ATG_ALREADY_SCANNED, true )) : ?>checked="checked" <?php endif; ?>value="true" id="<?php echo ATG_ALREADY_SCANNED; ?>" name="<?php echo ATG_ALREADY_SCANNED; ?>"> <?php _e("This post was already scanned for thumbnails")?></label><br>
		</p>
	</div>
	

	<?php
}

?>