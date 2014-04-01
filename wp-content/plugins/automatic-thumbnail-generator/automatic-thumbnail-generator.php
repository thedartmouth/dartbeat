<?php
/*
Plugin Name: Automatic Thumbnail Generator
Plugin URI: http://www.iukonline.com/auto-thumbnail-generator/
Description: Automated on-demand generation of posts thumbnails 
Version: 0.1
Author: iuk
Author URI: http://www.iukonline.com/
License: GPL2

Copyright 2010 iuk (email : iuk@iukonline.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once 'atg-admin.php';
require_once 'atg-filter.php';

add_action( 'admin_init', 'atg_admin_init' );
add_action( 'admin_menu', 'atg_admin_menu' );
add_action( 'save_post', 'atg_save_post' );


add_filter( 'post_thumbnail_html', 'atg_filter_post_thumbnail_html', 10, 5);


?>
