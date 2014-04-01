<?php
/*
Plugin Name: Image Replacement
Plugin URI: http://blog.slaven.net.au/wordpress-plugins/image-replacement-wordpress-plugin/
Description: Use javascript to replace html tags with images to create image headlines.
Author: Glenn Slaven
Version: 1.1
Author URI: http://blog.slaven.net.au/
*/

define('FONTS_FOLDER', ABSPATH . 'wp-content/plugins/wp-imagereplacement-fonts/');
define('WP_IMAGEREPLACE_DEFAULT_TEST_IMAGE', '/wp-admin/images/wordpress-logo.png');
define('WP_IMAGEREPLACE_DEFAULT_CACHE_FOLDER', ABSPATH . 'wp-content/cache/wp-imagereplacement/');
define('WP_IMAGEREPLACE_DEFAULT_DEMOTEXT', 'The quick brown fox jumps over the lazy dog. 0123456789 !@#$%^&*()_+-=');
if (function_exists('get_settings')) { define('WP_IMAGEREPLACE_IMAGELINK', get_settings('siteurl') . '?wp-imagereplacement=true&'); }
define('WP_IMAGEREPLACE_RESAMPLE_SIZE', 10);
define('WP_IMAGEREPLACE_SHADOW_SHIFT', 1.5);
define('WP_IMAGEREPLACE_SHADOW_COLOUR', 'BBBBBB');

class wp_imagereplacement {

	var $display_name = 'Image Replacements';
	var $short_name = 'wp_imagereplacement';
	var $_error = false;

	function wp_imagereplacement() {
		add_action('admin_menu', array(&$this, 'add_options_page'));
		add_action('wp_head', array(&$this, 'add_head_javascript'));
		add_action('wp_footer', array(&$this, 'add_trigger'));
	}


	function add_options_page() {
	    if (function_exists('add_options_page')) {
			add_options_page($this->short_name, $this->display_name, 9, __FILE__, array(&$this, 'options_page'));
	    }
	}


	function add_trigger() {
?>
	<script type="text/javascript"><?=$this->short_name?>_init();</script>
<?php
	}

	function add_head_javascript($template_file) {
		$data = $this->get_replacements();
		$gen_options = $this->get_general_options();
?>
	<script type="text/javascript">
	<!--
	if (!document.getElementsByClass) {
		/* Props to Dustin Diaz: http://www.dustindiaz.com/getelementsbyclass/ */
		function getElementsByClass(searchClass,node,tag) {
			var classElements = new Array();
			if ( node == null )
				node = document;
			if ( tag == null )
				tag = '*';
			var els = node.getElementsByTagName(tag);
			var elsLen = els.length;
			var pattern = new RegExp("(^|\s)"+searchClass+"(\s|$)");
			for (i = 0, j = 0; i < elsLen; i++) {
				if ( pattern.test(els[i].className) ) {
					classElements[j] = els[i];
					j++;
				}
			}
			return classElements;
		}
	}

	function <?=$this->short_name?>_init()
	{
		var W3CDOM = (document.createElement && document.getElementsByTagName);
		if (!W3CDOM) return;
<?php
		foreach($data as $d) {
			print "\t\t\t".$this->short_name."_replace(document.getElementsByTagName('".$d[$this->short_name . '_element']."'),'".$d[$this->short_name . '_class']."', 'background=".$d[$this->short_name . '_backgroundcolour']."&colour=".$d[$this->short_name . '_fontcolour']."&ypad=".$d[$this->short_name . '_ypad']."&size=".$d[$this->short_name . '_fontsize']."&padding=".$d[$this->short_name . '_padding']."&shadow=".$d[$this->short_name . '_shadow']."&font=".$d[$this->short_name . '_fontname']."&type=png');\n";
		}
?>
	}

	function <?=$this->short_name?>_traverse(oNode, sArgs)
	{
		for (var i=0; i<oNode.childNodes.length; i++) {
			var childObj = oNode.childNodes[i];
			if (childObj.nodeType == 3 && childObj.nodeValue != '') {
				<?=$this->short_name?>_swap(oNode, childObj, sArgs);
			}

			<?=$this->short_name?>_traverse(childObj, sArgs);
		}
	}


	function <?=$this->short_name?>_swap(parent, el, sArgs) {
		var replace = document.createElement('img');
		var y = replace.cloneNode(true);

		y.src = '<?=WP_IMAGEREPLACE_IMAGELINK?>' + sArgs + '&text=' + el.nodeValue;
		y.alt = el.nodeValue;
		parent.replaceChild(y,el);
	}

	function <?=$this->short_name?>_replace(aNodes, sClass, sArgs) {
		for (var i=0;i<aNodes.length;i++) {
			if (!sClass || (aNodes[i].className == sClass)) {
				<?=$this->short_name?>_traverse(aNodes[i], sArgs);
			}
		}
	}
	-->
	</script>
<?php
	}

	function get_defaults() {
		return array(
			$this->short_name . '_fontname' => '',
			$this->short_name . '_fontsize' => '12',
			$this->short_name . '_fontcolour' => '000000',
			$this->short_name . '_backgroundcolour' => 'FFFFFF',
			$this->short_name . '_pading' => '0 0 0 0'
		);

	}

	function save_replacement() {
		$data = $this->get_replacements();

		$this->_error = false;
		if (!$_POST[$this->short_name . '_element'] && !$_POST[$this->short_name . '_class']) {
		    $this->_error = 'Please select an element or enter a class name (or do both)';
		} elseif (!$_POST[$this->short_name . '_fontname']) {
			$this->_error = 'Please select font';
		} elseif (!$_POST[$this->short_name . '_fontcolour']) {
			$this->_error = 'Please enter a font colour in hex format (ie FFFFFF = white).  Note: do not put the # at the start of the colour';
		} elseif (!$_POST[$this->short_name . '_backgroundcolour']) {
			$this->_error = 'Please enter a background colour in hex format (ie FFFFFF = white).  Note: do not put the # at the start of the colour';
		}

		if ($this->_error) {
		    return false;
		}

		if ($_POST[$this->short_name . '_rid']) {
		    $rid = $_POST[$this->short_name . '_rid'];
			unset($data[$rid]);
		} else {
			$rid = $_POST[$this->short_name . '_element'] . '||' . $_POST[$this->short_name . '_class'];
		}

		$data[$rid] = array(
			$this->short_name . '_element' => 			$_POST[$this->short_name . '_element'],
			$this->short_name . '_class' => 			$_POST[$this->short_name . '_class'],
			$this->short_name . '_fontname' => 			$_POST[$this->short_name . '_fontname'],
			$this->short_name . '_fontsize' => 			$_POST[$this->short_name . '_fontsize'],
			$this->short_name . '_fontcolour' => 		$_POST[$this->short_name . '_fontcolour'],
			$this->short_name . '_backgroundcolour' => 	$_POST[$this->short_name . '_backgroundcolour'],
			$this->short_name . '_padding' => 			$_POST[$this->short_name . '_padding'],
			$this->short_name . '_shadow' => 			$_POST[$this->short_name . '_shadow']
		);

		update_option($this->short_name . '_replacements', $data);

		//Flush the cache
		wp_imagereplacement_imagetext::flush_cache();
		return $rid;

	}

	function delete_replacement($rid) {
		$data = $this->get_replacements();
		if (array_key_exists($rid, $data)) {
			unset($data[$rid]);
		}
		update_option($this->short_name . '_replacements', $data);
		return true;
	}

	function get_replacements() {
		$data = get_option($this->short_name . '_replacements');
		if (!$data) {
		    $data = array();
		}
		return $data;

	}

	function get_replacement_on_key($key) {
		$data = $this->get_replacements();
		if (array_key_exists($key, $data)) {
		    return $data[$key];
		} else {
			return false;
		}
	}

	function get_general_options(){
		$options = get_option('wp_imagereplacement_options');
		if (!$options) {
			$options = array(
				'use_cache'			=> '1',
				'cache_location'	=> WP_IMAGEREPLACE_DEFAULT_CACHE_FOLDER,
				'cache_age'			=> '14',
				'demo_text'			=> WP_IMAGEREPLACE_DEFAULT_DEMOTEXT,
				'test_image'		=> WP_IMAGEREPLACE_DEFAULT_TEST_IMAGE
			);
		}

		//Ensure the test image is loaded
		if (! $options['test_image']) {
			$options['test_image'] = WP_IMAGEREPLACE_DEFAULT_TEST_IMAGE;
		}

		return $options;
	}

	function options_page() {

		$edit = false;
		if ($_POST) {
			if ($_POST[$this->short_name . '_delete']) {
			    $this->delete_replacement($_POST[$this->short_name . '_rid']);
				$msg = 'Image Replacement Deleted';
				$values = $this->get_defaults();
			} elseif ($_POST['a'] == 'update_options') {
				update_option($this->short_name . '_options', $_POST[$this->short_name . '_options']);
			} elseif ($_POST['a'] == 'clear_cache') {
				$irit = new wp_imagereplacement_imagetext('','');
				$irit->flush_cache();
			} else {
			    if ($rid = $this->save_replacement()) {
			        $msg = 'Image Replacement Saved';
			    }
				$values = $this->get_defaults();
			}
		} elseif($_GET['rid']) {
			$values = $this->get_replacement_on_key($_GET['rid']);
			$values[$this->short_name . '_rid'] = $_GET['rid'];
			$edit = true;
		} else {
			$values = $this->get_defaults();
		}


		$gen_options = $this->get_general_options();

		$replaceable_elements = array('h1','h2','h3','h4','h5','h6','div','span', 'p');
		$font_sizes = array();
		for ($i = 1; $i <= 100; $i++) {
			$font_sizes[] = $i;
		}
		$fonts = wp_imagereplacement_font::load_directory(FONTS_FOLDER);
?>
<style type="text/css">
#<?=$this->short_name?>_currentlist {
	margin: 0 0 50px 20px;
}

#<?=$this->short_name?>_currentlist th {
	text-align: left;
	padding: 0 0 5px 0;
	border-bottom: 1px solid #000000;
}

#<?=$this->short_name?>_currentlist .examplerow td {
	padding: 5px;
	border-bottom: 1px dotted #CCCCCC;
}
</style>
<script type="text/javascript">
function show_demo_font() {

	oEl = document.getElementById('<?=$this->short_name?>_fontname');
	if (oEl != null) { var sFont = oEl.value; }

	if (!sFont) { return; }

	oEl = document.getElementById('<?=$this->short_name?>_fontsize');
	if (oEl != null) { var iSize = oEl.value; }

	oEl = document.getElementById('<?=$this->short_name?>_fontcolour');
	if (oEl != null) { var sColour = oEl.value; }

	oEl = document.getElementById('<?=$this->short_name?>_backgroundcolour');
	if (oEl != null) { var sBgColour = oEl.value; }

	oEl = document.getElementById('<?=$this->short_name?>_padding');
	if (oEl != null) { var sPadding = oEl.value; }

	oEl = document.getElementById('<?=$this->short_name?>_shadow');
	if (oEl != null) { var bShadow = (oEl.checked ? '1' : '0'); }

	var sUrl = '<?=WP_IMAGEREPLACE_IMAGELINK?>background=' + sBgColour + '&padding=' + sPadding + '&shadow=' + bShadow + '&colour=' + sColour + '&font=' + sFont + '&type=png&size=' + iSize + '&forceupdate=true&text=<?=urlencode($gen_options['demo_text'])?>';

	oEl = document.getElementById('<?=$this->short_name?>_demoimage');
	if (oEl != null) {
		oEl.src = sUrl;
		oEl.style.display = 'inline';
	}
}
</script>
<div class=wrap>
 <h2><?=_($this->display_name)?></h2>
	<fieldset class="options">
  <legend>Current Replacements</legend>
  <table cellspacing="0" cellpadding="0" width="80%" id="<?=$this->short_name?>_currentlist">
  <tr><th>Element</th><th>Class</th><th>Font</th><th>Size</th><th>Font Colour</th><th>Background</th><th>Padding</th><th></th></tr>
<?php
	$replist = $this->get_replacements();
	if (is_array($replist)) {
	    foreach($replist as $key => $r) {
			$font = new wp_imagereplacement_font($r[$this->short_name . '_fontname'], FONTS_FOLDER);
			print "<tr><td>{$r[$this->short_name . '_element']}</td><td>{$r[$this->short_name . '_class']}</td><td>{$font->name}</td><td>{$r[$this->short_name . '_fontsize']}</td><td style=\"color:#{$r[$this->short_name . '_fontcolour']}\">#{$r[$this->short_name . '_fontcolour']}</td><td style=\"background-color:#{$r[$this->short_name . '_backgroundcolour']}\">#{$r[$this->short_name . '_backgroundcolour']}</td><td>{$r[$this->short_name . '_padding']}</td><td rowspan=\"2\" valign=\"middle\"><input value=\"Edit\" type=\"button\" onclick=\"location.href='$PHP_SELF?page={$_GET['page']}&amp;rid=".urlencode($key)."';\"></td></tr>\n";
			print "<tr class=\"examplerow\"><td colspan=\"8\"><img src=\"".WP_IMAGEREPLACE_IMAGELINK."background={$r[$this->short_name . '_backgroundcolour']}&colour={$r[$this->short_name . '_fontcolour']}&font={$r[$this->short_name . '_fontname']}&type=png&padding={$r[$this->short_name . '_padding']}&shadow={$r[$this->short_name . '_shadow']}&size={$r[$this->short_name . '_fontsize']}&forceupdate=true&text=".$gen_options['demo_text']."\" alt=\"\" /></td></tr>\n";
		}
	}

?>
  </table>
  </fieldset>
  <form method="post">
  <input type="hidden" name="a" id="hidden_a" value="" />
  <fieldset class="options">
  	<legend>General Options</legend>
  	<table cellspacing="2" cellpadding="5" class="editform">
	<tr>
		<th scope="row">Use Cache:</th>
		<td><input type="checkbox" name="<?=$this->short_name?>_options[use_cache]" value="1"<?=($gen_options['use_cache'] ? ' checked="checked"' : '')?> /></td>
	</tr>
	<tr>
		<th scope="row">Cache Location:</th>
		<td><input size="70" type="text" name="<?=$this->short_name?>_options[cache_location]" value="<?=$gen_options['cache_location']?>" /></td>
	</tr>
	<tr>
		<th scope="row">Cache Age (days):</th>
		<td><input size="5" type="text" name="<?=$this->short_name?>_options[cache_age]" value="<?=$gen_options['cache_age']?>" /></td>
	</tr>
	<tr>
		<th scope="row">Demo Text:</th>
		<td><input size="70" type="text" name="<?=$this->short_name?>_options[demo_text]" value="<?=$gen_options['demo_text']?>" /></td>
	</tr>
	<tr>
		<th scope="row">Test Image:</th>
		<td><input size="70" type="text" name="<?=$this->short_name?>_options[test_image]" value="<?=$gen_options['test_image']?>" /><br />This must be the location of a real image that exists on your site.  It is loaded first to test if images can be loaded by the browser.</td>
	</tr>
	<tr>
	 <td class="submit"><input onclick="oEl = document.getElementById('hidden_a');  oEl.value='update_options';" type="submit" name="<?=$this->short_name?>_options_update" value="<?php _e('Update') ?> &raquo;" /></td>
	 <td class="submit" style="text-align:left;"><input onclick="oEl = document.getElementById('hidden_a');  oEl.value='clear_cache';" type="submit" name="<?=$this->short_name?>_clear_cache" value="<?php _e('Clear Cache') ?>" /></td>
  </tr>
	</table>
  </fieldset>
  </form>
  <form method="post">
  <fieldset class="options">
	<legend><?=($edit ? 'Edit' : 'Create a new')?> replacement</legend>
	<input type="hidden" name="<?=$this->short_name?>_rid" value="<?=$values[$this->short_name . '_rid']?>" />
  <p>Select the HTML element to replace.  If you can enter a class name as well as selecting an element, it will only replace those elements that also have the class name.  <!--If you select <code>[on class name only]</code> &amp; enter a class it will replace <em>any</em> element that has that class name.  Take care when entering this, as you could end up replacing whole paragraphs of text.--></p>
<?php
		if ($this->_error) {
		    print "<p style=\"color:red;\"><strong>Error: </strong>$this->_error</p>\n";
		} elseif ($msg) {
			print "<p style=\"color:red;\"><strong>$msg</strong></p>\n";
		}
?>
  <table cellspacing="2" cellpadding="5" class="editform">
  <tr>
   <th scope="row">Element:</th>
   <td><select name="<?=$this->short_name?>_element"><!--<option value="">[on class name only]</option>--><?php foreach($replaceable_elements as $e) { print "<option value=\"$e\"".($values[$this->short_name . '_element'] == $e ? ' selected="selected"' : '').">$e</option>"; } ?></select></td>
  </tr>
	<tr>
   <th scope="row">Class Name:</th>
	 <td><input type="text" name="<?=$this->short_name?>_class" value="<?=$values[$this->short_name . '_class']?>" /></td>
	</tr>
	<tr>
	 <th>Font Size (points):</th>
	 <td><select onchange="show_demo_font();" name="<?=$this->short_name?>_fontsize" id="<?=$this->short_name?>_fontsize"><?php foreach($font_sizes as $e) { print "<option value=\"$e\"".($values[$this->short_name . '_fontsize'] == $e ? ' selected="selected"' : '').">$e</option>"; } ?></select></td>
	</tr>
	<tr>
	 <th scope="row">Font:</th>
	 <td><select onchange="show_demo_font();" id="<?=$this->short_name?>_fontname" name="<?=$this->short_name?>_fontname"><option value="">Select...</option><?php foreach($fonts as $f) { print "<option value=\"$f->file_name\"".($values[$this->short_name . '_fontname'] == $f->file_name ? ' selected="selected"' : '').">$f->name</option>"; } ?></select></td>
  </tr>
	<tr>
	 <th>Font Colour (hex):</th>
	 <td>#<input maxlength="6" onchange="show_demo_font();" type="text" id="<?=$this->short_name?>_fontcolour" name="<?=$this->short_name?>_fontcolour" value="<?=$values[$this->short_name . '_fontcolour']?>" /></td>
	</tr>
	<tr>
	 <th>Background Colour (hex):</th>
	 <td>#<input maxlength="6" onchange="show_demo_font();" type="text" id="<?=$this->short_name?>_backgroundcolour" name="<?=$this->short_name?>_backgroundcolour" value="<?=$values[$this->short_name . '_backgroundcolour']?>" /></td>
	</tr>
	<tr>
	 <th>Padding (pixels, CSS style T R B L):</th>
	 <td><input onchange="show_demo_font();" type="text" id="<?=$this->short_name?>_padding" name="<?=$this->short_name?>_padding" value="<?=$values[$this->short_name . '_padding']?>" /></td>
	</tr>
	<tr>
	 <th>Shadow:</th>
	 <td><input type="checkbox" onclick="show_demo_font();"<?=($values[$this->short_name . '_shadow'] ? ' checked="checked"' : '')?> id="<?=$this->short_name?>_shadow" name="<?=$this->short_name?>_shadow" value="1" /></td>
	</tr>
	<tr>
	 <td></td>
	 <td><img id="<?=$this->short_name?>_demoimage" src="" alt="" style="display:none;" /></td>
	</tr>
	<tr>
	 <td class="submit"><input type="submit" name="<?=$this->short_name?>_addnew" value="<?php _e(($edit ? 'Update' : 'Add') . ' Image Replacement') ?> &raquo;" /></td>
	 <td><?php if ($edit) { ?><input type="submit" name="<?=$this->short_name?>_delete" value="Delete" onclick="return confirm('You are about to delete this image replacement\n"OK" to delete, "Cancel" to stop.');" /><?php } ?><script type="text/javascript">show_demo_font();</script></td>
  </tr>
  </table>
  </fieldset>
 </form>
	<div style="background-color:rgb(238, 238, 238); border: 1px solid rgb(85, 85, 85); padding: 5px;">
	<p>Did you find this plugin useful?  Please consider donating to help me continue developing it and other plugins.</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="paypal@slaven.net.au">
<input type="hidden" name="item_name" value="<?=$this->display_name?> Wordpress Plugin">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="AUD">
<input type="hidden" name="tax" value="0">
<input type="hidden" name="bn" value="PP-DonationsBF">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but04.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form></div>

</div>
<?php
	}
}

class wp_imagereplacement_font {

	var $file_path;
	var $file_name;
	var $family;
	var $name;
	var $sub_family;
	var $copyright;

	function wp_imagereplacement_font($file_name, $path = './') {
		if (substr($path, -1, 1) != '/') {
		    $path = $path . '/';
		}

		$this->file_path = $path . $file_name;

		if (strrpos($file_name, '.')) {
		    $this->file_name = substr($file_name, 0, strrpos($file_name, '.'));
		} else {
			$this->file_name = $file_name;
			$this->_get_file_extension();
		}

		if (file_exists($this->file_path) && is_readable($this->file_path)) {
		    $this->_parse();
		}
	}

	function __constructor($file_path) {
		return $this->Font($file_path);
	}

	function load_directory($path) {
		if ($dh = opendir($path)) {
			$fonts = array();
			while (false !== ($file = readdir($dh))) {
			    if (in_array(strtolower(substr($file, strrpos($file, '.') + 1)), wp_imagereplacement_font::_get_known_font_types())) {
			        $fonts[] = new wp_imagereplacement_font($file, $path);
			    }
			}
			return $fonts;
		}
	}

	function _get_known_font_types() {
		$known_fonts = 'ttf,otf';

		return split(',', $known_fonts);
	}

	function _get_file_extension() {
		foreach($this->_get_known_font_types() as $t) {
			if (file_exists($this->file_path . '.' . $t)) {
			    return $this->file_path = $this->file_path . '.' . $t;
			}
		}
	}

	function _parse() {
		if (file_exists($this->file_path)) {
		    switch(strtolower(substr($this->file_path, strrpos($this->file_path, '.') + 1))) {
			case 'ttf':
				$this->_parse_ttf();
				break;
			case 'otf':
				$this->_parse_ttf();
				break;
			}
		}
	}


	function _parse_ttf() {
		if (function_exists('file_get_contents')) {
		    $text = file_get_contents($this->file_path);
		} else {
			if ($fd = fopen($this->file_path, "r")) {
			    while (!feof($fd)) {
					$text .= fread($fd, 1024);
				}
				fclose($fd);
			}
		}
		$number_of_tabs = wp_imagereplacement_font::dec2hex(ord($text[4])) . wp_imagereplacement_font::dec2hex(ord($text[5]));
		for ($i=0;$i<hexdec($number_of_tabs);$i++){
			$tag = $text[12+$i*16].$text[12+$i*16+1].$text[12+$i*16+2].$text[12+$i*16+3];
			if ($tag == "name") {
				$offset_name_table_hex = wp_imagereplacement_font::dec2hex(ord($text[12+$i*16+8])) . wp_imagereplacement_font::dec2hex(ord($text[12+$i*16+8+1])) . wp_imagereplacement_font::dec2hex(ord($text[12+$i*16+8+2])) . wp_imagereplacement_font::dec2hex(ord($text[12+$i*16+8+3]));
				$offset_name_table_dec = hexdec($offset_name_table_hex);
				$offset_storage_hex = wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+4])) . wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+5]));
				$offset_storage_dec = hexdec($offset_storage_hex);
				$number_name_records_hex = wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+2])) . wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+3]));
				$number_name_records_dec = hexdec($number_name_records_hex);
				break;
			}
		}
		$storage_dec = $offset_storage_dec + $offset_name_table_dec;
		$storage_hex = strtoupper(dechex($storage_dec));
		for ($j=0;$j<$number_name_records_dec;$j++){
			$platform_id_hex = wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+6+$j*12+0])) . wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+6+$j*12+1]));
			$platform_id_dec = hexdec($platform_id_hex);
			$name_id_hex = wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+6+$j*12+6])) . wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+6+$j*12+7]));
			$name_id_dec = hexdec($name_id_hex);
			$string_length_hex = wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+6+$j*12+8])) . wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+6+$j*12+9]));
			$string_length_dec = hexdec($string_length_hex);
			$string_offset_hex = wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+6+$j*12+10])) . wp_imagereplacement_font::dec2hex(ord($text[$offset_name_table_dec+6+$j*12+11]));
			$string_offset_dec = hexdec($string_offset_hex);
			if ($name_id_dec==0 and $copyright=="") {
				for($l=0;$l<$string_length_dec;$l++){
					if (ord($text[$storage_dec+$string_offset_dec+$l])) {
					    $this->copyright.=$text[$storage_dec+$string_offset_dec+$l];
					}
				}
			}
			if ($name_id_dec==1 and $fontfamily=="") {
				for($l=0;$l<$string_length_dec;$l++){
					if (ord($text[$storage_dec+$string_offset_dec+$l])) {
					    $this->family.=$text[$storage_dec+$string_offset_dec+$l];
					}
				}
			}
			if ($name_id_dec==2 and $fontsubfamily=="") {
				for($l=0;$l<$string_length_dec;$l++){
					if (ord($text[$storage_dec+$string_offset_dec+$l])) {
					    $this->sub_family.=$text[$storage_dec+$string_offset_dec+$l];
					}
				}
			}
			if ($name_id_dec==4 and $fullfontname=="") {
				for($l=0;$l<$string_length_dec;$l++){
					if (ord($text[$storage_dec+$string_offset_dec+$l])) {
					    $this->name.=$text[$storage_dec+$string_offset_dec+$l];
					}

				}
			}
			if ($this->family<>"" and $this->sub_family<>"" and $this->name<>"" and $this->copyright<>"") {
				break;
			}
		}
		return (true);
	}

	function dec2hex($dec){
		$hex=dechex($dec);
		return( str_repeat("0",2-strlen($hex)) . strtoupper($hex) );
	}
}



class wp_imagereplacement_imagetext {

	var $_img;

	var $width;
	var $height;
	var $type;
	var $bgcolour;
	var $text;
	var $font_face;
	var $font_file;
	var $size;
	var $colour;
	var $padding = array();
	var $shadow;
	var $read_cache;
	var $write_cache;
	var $cache_folder;

	function wp_imagereplacement_imagetext($text = '',
										   $font_face,
										   $size = DEFAULT_FONT_SIZE,
										   $bgcolour = DEFAULT_BACKGROUND_COLOUR,
										   $colour = DEFAULT_FONT_COLOUR,
										   $type = DEFAULT_FONT_TYPE,
										   $padding = '0 0 0 0',
										   $shadow = false,
										   $force_write_cache = false) {

		$options = wp_imagereplacement::get_general_options();
		if ($options) {
			$read_cache = (boolean)$options['use_cache'];
			$this->cache_folder = $options['cache_location'];
			$cache_age = $options['cache_age'];
		} else {
			$read_cache = true;
			$this->cache_folder = WP_IMAGEREPLACE_DEFAULT_CACHE_FOLDER;
			$cache_age = 14;
		}


		$this->text = str_replace('\\', '', $text);
		$this->font_face = $font_face;
		$this->size = $size * WP_IMAGEREPLACE_RESAMPLE_SIZE;
		$this->bgcolour = $this->hex_to_rgb($bgcolour);
		$this->colour = $this->hex_to_rgb($colour);
		$this->type = ($type == 'jpg' ? 'jpeg' : $type);
		$this->padding = split(' ', $padding);
		$this->shadow = (boolean)$shadow;
		$this->cache_file = md5($this->text . $this->font_face . $this->size . $this->bgcolour . $this->colour . $this->padding . $this->shadow) . '.' . $this->type;
		$this->write_cache = $this->check_write_cache($read_cache, $force_write_cache, $cache_age);
	    $this->read_cache = (!$this->write_cache && $this->check_read_cache($read_cache, $cache_age));
	}

	function hex_to_rgb($hex_colour) {
		if (strlen($hex_colour) > 6) { $hex_colour = substr($hex_colour, 1, 6); }
		$int = hexdec($hex_colour);

		return array(RED_IDX => 0xFF & ($int >> 0x10),
					 GREEN_IDX => 0xFF & ($int >> 0x8),
					 BLUE_IDX => 0xFF & $int);
	}

	function allocate_colour($colour) {
		if (is_array($colour)) {
		    $colour_array = $colour;
		} elseif (is_string($colour)) {
			$colour_array = wp_imagereplacement_imagetext::hex_to_rgb($colour);
		}

		return imagecolorallocate($this->_img, $colour_array[RED_IDX], $colour_array[GREEN_IDX], $colour_array[BLUE_IDX]);
	}

	function render() {
		header("Content-type: image/" . $this->type);
		if ($this->read_cache) {
			readfile($this->cache_folder . $this->cache_file);
		} else {
			$this->font_file = $this->_generateFontPath();

			$dimensions = $this->_getTextSize();

			$this->_img = @ImageCreateTrueColor($dimensions['width'], $dimensions['height']);
			$black = @ImageColorAllocate($this->_img, 0,0,0);

			$bgcolour = $this->allocate_colour($this->bgcolour);
			imagefill($this->_img, 0, 0, $bgcolour);
			ImageColorTransparent($this->_img, $bgcolour);

			$this->width = $dimensions['width'];
			$this->height = $dimensions['height'];

			//Add the shadow
			if ($this->shadow) {
			    imagettftext($this->_img, $this->size, 0, ($this->padding[3] * WP_IMAGEREPLACE_RESAMPLE_SIZE) + (WP_IMAGEREPLACE_SHADOW_SHIFT * WP_IMAGEREPLACE_RESAMPLE_SIZE), ($this->size + ($this->padding[0] * WP_IMAGEREPLACE_RESAMPLE_SIZE) + (WP_IMAGEREPLACE_SHADOW_SHIFT * WP_IMAGEREPLACE_RESAMPLE_SIZE)), $this->allocate_colour(WP_IMAGEREPLACE_SHADOW_COLOUR), $this->font_file, $this->text);
			}

			//Add the text
			imagettftext($this->_img, $this->size, 0, ($this->padding[3] * WP_IMAGEREPLACE_RESAMPLE_SIZE), ($this->size + ($this->padding[0] * WP_IMAGEREPLACE_RESAMPLE_SIZE)), $this->allocate_colour($this->colour), $this->font_file, $this->text);

			//Resample to view size
			$im = imagecreatetruecolor($this->width/WP_IMAGEREPLACE_RESAMPLE_SIZE, $this->height/WP_IMAGEREPLACE_RESAMPLE_SIZE);
			if (function_exists('imageantialias')) { //Create transparant background
				imageAntiAlias($im,true);
				imagealphablending($im, false);
				imagesavealpha($im,true);
				$transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
				imagefilledrectangle($im, 0, 0, $this->width/WP_IMAGEREPLACE_RESAMPLE_SIZE, $this->height/WP_IMAGEREPLACE_RESAMPLE_SIZE, $transparent);
			}
			imagecopyresampled($im, $this->_img, 0, 0, 0, 0, $this->width/WP_IMAGEREPLACE_RESAMPLE_SIZE, $this->height/WP_IMAGEREPLACE_RESAMPLE_SIZE, $this->width, $this->height);
			imagedestroy($this->_img);
			$this->_img = $im;


			if (function_exists('image' . $this->type)) {
				ob_start();
			    call_user_func('image' . $this->type, $this->_img);
				$content = ob_get_contents();
				ob_end_clean();
				if ($this->write_cache) {
					if ($handle = @fopen($this->cache_folder . $this->cache_file, 'wb')) {
					    @fwrite($handle, $content);
						@fclose($handle);
					}
				}
				print $content;
			}
			imagedestroy($this->_img);
		}


	}

	function _generateFontPath($font_face = false) {
		$font_face = ($font_face ? $font_face : $this->font_face);

		$fontfile = false;

		$known_font_types = wp_imagereplacement_font::_get_known_font_types();

		if (is_array($known_font_types)) {
		    foreach($known_font_types as $type) {
				if (file_exists(FONTS_FOLDER . $font_face . '.' . $type)) {
					$fontfile = FONTS_FOLDER . $font_face . '.' . $type;
					break;
				} elseif (file_exists(FONTS_FOLDER . $font_face . '.' . strtoupper($type))) {
					$fontfile = FONTS_FOLDER . $font_face . '.' . strtoupper($type);
					break;
				}
			}
		}

		return ($fontfile ? $fontfile : FONTS_FOLDER . DEFAULT_FONT_FACE . DEFAULT_FONT_EXT);
	}

	function _getTextSize() {
		$boundingbox = imagettfbbox(ceil($this->size), 0, $this->font_file, $this->text);
		if (is_array($boundingbox)) {
			$array['width'] = (abs($boundingbox[0]) + abs($boundingbox[2])) + (($this->padding[1] + $this->padding[3]) * WP_IMAGEREPLACE_RESAMPLE_SIZE);
			$array['height'] = (abs($boundingbox[1]) + abs($boundingbox[5])) + (($this->padding[0] + $this->padding[2]) * WP_IMAGEREPLACE_RESAMPLE_SIZE);
			return $array;
		}
	}


	function check_write_cache($use_cache, $force, $cache_age) {
		if ($use_cache) {
			if (file_exists($this->cache_folder . $this->cache_file)) {
			    $delta = (time() - filectime($this->cache_folder . $this->cache_file))/60/60/24;
				return (is_writable($this->cache_folder . $this->cache_file) && ($delta > $cache_age || $force));
			} else {
				if (file_exists($this->cache_folder)) {
				    return is_writable($this->cache_folder);
				} else {
					$parent = dirname($this->cache_folder);
					if (is_writable($parent)) {
					    return mkdir($this->cache_folder);
					}
				}

			}
		}
		return false;
	}

	function flush_cache(){
		if (file_exists($this->cache_folder) && is_writable($this->cache_folder)) {
			$files = array();
			if ($handle = opendir($this->cache_folder)) {
			   while (false !== ($file = readdir($handle))) {
			       if ($file != "." && $file != "..") {
					   unlink($this->cache_folder . $file);
			       }
			   }
			   closedir($handle);
			}
		}
	}

	function check_read_cache($use_cache, $cache_age) {
		if ($use_cache) {
			if (file_exists($this->cache_folder . $this->cache_file) && is_readable($this->cache_folder . $this->cache_file)) {
				$delta = (time() - filectime($this->cache_folder . $this->cache_file))/60/60/24;
				if ($delta < $cache_age) {
				    return true;
				} elseif ($this->check_write_cache(true, true, $cache_age)) {
					//If the file is too old, delete the cache file
					unlink($this->cache_folder . $this->cache_file);
					return false;
				}
			}
		}
		return false;
	}

}


if (strlen($_GET['wp-imagereplacement']) > 0 && $_GET['text'] && $_GET['font'] && $_GET['size']) {
	$img = new wp_imagereplacement_imagetext($_GET['text'], $_GET['font'], $_GET['size'], $_GET['background'], ($_GET['colour'] ? $_GET['colour'] : $_GET['color']), $_GET['type'], $_GET['padding'], $_GET['shadow'], strlen($_GET['forceupdate']));

	$img->render();
	exit;
} else {
	$obj_fircoat = new wp_imagereplacement();
}

?>