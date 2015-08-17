<?php
/*
Plugin Name: Auto Replace Google's URL
Plugin URI: http://www.mywpku.com/auto-remove-googles-url.html
Description: 将完美替换原有的Google资源库（Font.GoogleAPIs.com/AJAX.GoogleAPIs.com），无论是前台还是后台，速度都将会有质的提升。
Author: PCDotFan
Author URI: http://www.mywpku.com/
Version: 0.0.1
Text Domain: wauto-remove-googles-url
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

add_action('wp_loaded','google_ob_start');
function google_ob_start() {
		ob_start('google_cdn_replace');
}
	
function google_cdn_replace($html) {
		return str_replace('fonts.googleapis.com', 'fonts.useso.com', $html);
		return str_replace('ajax.googleapis.com', 'ajax.useso.com', $html);	
}