<?php
	global $default_sidebars;
	
	$default_sidebars = array(

						array(
							'name' => __( 'Primary Widget Area', 'wpdance' ),
							'id' => 'primary-widget-area',
							'description' => __( 'The primary sidebar widget area', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Category Widget Area', 'wpdance' ),
							'id' => 'category-widget-area',
							'description' => __( 'The Category sidebar widget area', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)	
						,array(
							'name' => __( 'Product Widget Area', 'wpdance' ),
							'id' => 'product-widget-area',
							'description' => __( 'Product default sidebar widget area', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)	
						,array(
							'name' => __( 'Secondary Widget Area', 'wpdance' ),
							'id' => 'secondary-widget-area',
							'description' => __( 'The secondary sidebar widget area', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Top Header Widget Area', 'wpdance' ),
							'id' => 'top-header-widget-area',
							'description' => __( 'Top right header widget area', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Header Widget Area', 'wpdance' ),
							'id' => 'header-widget-area',
							'description' => __( 'The header widget area', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						/*	
						,array(
							'name' => __( 'Body End Widget Area', 'wpdance' ),
							'id' => 'body-end-widget-area',
							'description' => __( 'The widget area before body end', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Banner Widget Area', 'wpdance' ),
							'id' => 'banner-widget-area',
							'description' => __( 'The widget area banner', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)*/
						,array(
							'name' => __( 'First Footer Widget Area 1', 'wpdance' ),
							'id' => 'first-footer-widget-area-1',
							'description' => __( 'The first footer widget area 1', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)						
						,array(
							'name' => __( 'First Footer Widget Area 2', 'wpdance' ),
							'id' => 'first-footer-widget-area-2',
							'description' => __( 'The first footer widget area 2', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'First Footer Widget Area 3', 'wpdance' ),
							'id' => 'first-footer-widget-area-3',
							'description' => __( 'The first footer widget area 3', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						/*
						,array(
							'name' => __( 'First Footer Widget Area 4', 'wpdance' ),
							'id' => 'first-footer-widget-area-4',
							'description' => __( 'The first footer widget area 4', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)*/
						,array(
							'name' => __( 'Second Footer Widget Area 1', 'wpdance' ),
							'id' => 'second-footer-widget-area-1',
							'description' => __( 'The second footer widget area 1', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						
						,array(
							'name' => __( 'Second Footer Widget Area 2', 'wpdance' ),
							'id' => 'second-footer-widget-area-2',
							'description' => __( 'The second footer widget area 2', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Second Footer Widget Area 3', 'wpdance' ),
							'id' => 'second-footer-widget-area-3',
							'description' => __( 'The second footer widget area 3', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Second Footer Widget Area 4', 'wpdance' ),
							'id' => 'second-footer-widget-area-4',
							'description' => __( 'The second footer widget area 4', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						/*
						,array(
							'name' => __( 'Third Footer Widget Area 2', 'wpdance' ),
							'id' => 'thrid-footer-widget-area-2',
							'description' => __( 'The third footer widget area 2', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Third Footer Widget Area 3', 'wpdance' ),
							'id' => 'thrid-footer-widget-area-3',
							'description' => __( 'The third footer widget area 3', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Third Footer Widget Area 4', 'wpdance' ),
							'id' => 'thrid-footer-widget-area-4',
							'description' => __( 'The third footer widget area 4', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Third Footer Widget Area 5', 'wpdance' ),
							'id' => 'thrid-footer-widget-area-5',
							'description' => __( 'The third footer widget area 5', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)*/
						// ,array(
							// 'name' => __( 'Four Footer Widget Area', 'wpdance' ),
							// 'id' => 'four-footer-widget-area',
							// 'description' => __( 'The four footer widget area', 'wpdance' ),
							// 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							// 'after_widget' => '</li>',
							// 'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							// 'after_title' => '</h3></div>',
						// )
						
						,array(
							'name' => __( 'Product AD Banner Widget Area', 'wpdance' ),
							'id' => 'product-ad-banner-widget-area',
							'description' => __( 'The product ad-banner widget area', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Footer Bottom Widget Area', 'wpdance' ),
							'id' => 'bottom-footer-widget-area',
							'description' => __( 'The footer bottom widget area', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => __( 'Blog Widget Area', 'wpdance' ),
							'id' => 'blog-widget-area',
							'description' => __( 'The default widget area for blog page', 'wpdance' ),
							'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</li>',
							'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)						
	);

function wpdance_widgets_init() {
	global $default_sidebars;
	
	$custom_sidebar_str = get_option(THEME_SLUG.'areas');
	if($custom_sidebar_str){
		$custom_sidebar_arr = json_decode($custom_sidebar_str);		
	}else{
		$custom_sidebar_arr = array();
	}	

		
	$_init_sidebar_array = array();	
	if( count($custom_sidebar_arr) > 0 ){
		
			foreach( $custom_sidebar_arr as $_area ){
				$_area_name = stripslashes(esc_html (ucwords( str_replace("-"," ",$_area) ) ));
				$_init_sidebar_array[] = array(
							'name' => sprintf( __( '%s Widget Area','wpdance' ), $_area_name ) //__( "{$_area_name} Widget Area", 'wpdance' )
							,'id' => strtolower( str_replace(" ","-",$_area) )
							,'description' => sprintf( __( '%s sidebar widget area','wpdance' ), $_area_name ) //__( "{$_area_name} sidebar widget area", 'wpdance' )
							,'before_widget' => '<li id="%1$s" class="widget-container %2$s">'
							,'after_widget' => '</li>'
							,'before_title' => '<div class="widget_title_wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">'
							,'after_title' => '</h3></div>'
				);	
				
			}	
	}	
	
	$default_sidebars = array_merge($default_sidebars,$_init_sidebar_array);
	
	foreach( $default_sidebars as $sidebar ){
		register_sidebar($sidebar);
	}	
}
/** Register sidebars by running wpdance_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'wpdance_widgets_init' );
?>