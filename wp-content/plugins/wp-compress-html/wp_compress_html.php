<?php
/*
Plugin Name: WP-Compress-HTML
Plugin URI: http://www.mandar-marathe.com/wp-compress-html
Description: Removes all white space from the HTML document.
Version: 1.0
Author: Mandar Marathe
Author URI: http://www.mandar-marathe.com
Author Email: info@mandar-marathe.com
*/

function wp_compress_html()
{

function wp_compress_html_main ($buffer)
{
	$initial=strlen($buffer);
	$buffer=explode("<!--wp-compress-html-->", $buffer);
	$count=count ($buffer);

	for ($i = 0; $i <= $count; $i++)
	{
		if (stristr($buffer[$i], '<!--wp-compress-html no compression-->'))
		{
			$buffer[$i]=(str_replace("<!--wp-compress-html no compression-->", " ", $buffer[$i]));
		}
		else
		{
			$buffer[$i]=(str_replace("\t", " ", $buffer[$i]));
			$buffer[$i]=(str_replace("\n\n", "\n", $buffer[$i]));
			$buffer[$i]=(str_replace("\n", "", $buffer[$i]));
			$buffer[$i]=(str_replace("\r", "", $buffer[$i]));

			while (stristr($buffer[$i], '  '))
			{
			$buffer[$i]=(str_replace("  ", " ", $buffer[$i]));
			}
		}
		$buffer_out.=$buffer[$i];
	}
	$final=strlen($buffer_out);
	$savings=($initial-$final)/$initial*100;
	$savings=round($savings, 2);
	$buffer_out.="\n<!--WP-Compress-HTML Uncompressed size: $initial bytes; Compressed size: $final bytes; $savings% savings-->";
	return $buffer_out;
}

ob_start("wp_compress_html_main");
}

add_action('get_header', 'wp_compress_html');
?>
