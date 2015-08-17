<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 **/
?><!DOCTYPE html>
<!--[if IE 7 ]><html class="ie ie7" lang="en-US"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en-US"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="en-US"> <![endif]-->
<?php 
global $is_IE;
$ie_id ='';
if($is_IE){
	$ie_id='id="wd_ie"';
}
?>
<html <?php echo $ie_id; ?> <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title>
<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'wpdance' ), max( $paged, $page ) );

	?>
</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php theme_icon();?>
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<?php
	global $is_iphone,$wd_data,$page_datas;
	$enable_custom_preview = absint($wd_data['wd_preview_panel']);
	$wd_layout_style = '';
	if($wd_data['wd_layout_style'] != ''){
		$wd_layout_style .= $wd_data['wd_layout_style'];
	}
?>

<body <?php body_class($wd_layout_style); ?>>
<?php
	if( $enable_custom_preview && !is_admin() && !$is_iphone && !wp_is_mobile() /*&& !preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT']) */){	
		previewPanel();
	}	
	$header_layout = '';
	if(strcmp($page_datas['page_layout'],'wide') == 0){
		if($page_datas['header_layout'] == '0') { 
			$header_layout = ' class="wd_box"'; 
		} else { 
			$header_layout = ' class="wd_'.$page_datas['header_layout'].'"'; 
		}
	}	
?>
<div class="main-template-loader"></div>
<div id="template-wrapper" class="hfeed">
	<div id="header" <?php echo $header_layout; ?>>
		<div class="header-container">
			<?php do_action( 'wd_header_init' ); ?>
		</div>
	</div><!-- end #header -->

	<?php do_action( 'wd_bofore_main_container' ); ?>

	<div id="main-module-container">