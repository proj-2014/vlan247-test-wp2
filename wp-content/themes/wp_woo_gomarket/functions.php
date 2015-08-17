<?php
/**
 * @package WordPress
 * @subpackage TechGo
 * @since WD_Responsive
 **/
 //error_reporting("-1");
$_template_path = get_template_directory();
require_once $_template_path."/theme/theme.php";
$theme = new Theme(array(
	'theme_name'	=>	"GoMarket",
	'theme_slug'	=>	'gomarket'
));
$theme->init();

/**
 * Slightly Modified Options Framework
 */
require_once ('admin/index.php');

// add for extra patch  20150716
//require_once ( ABSPATH . '/extra2.1/patch4mall/modify/myfunctions.php');
// 20150807 fix the path
//require_once ( PATCHPATH . 'modify/myfunctions.php');
//require_once ( ABSPATH . '/extra2.1/patch4mall-2/modify/myfunctions.php');
if ( defined('PATCHPATH') )
   require_once ( PATCHPATH . 'modify/myfunctions.php');

?>
