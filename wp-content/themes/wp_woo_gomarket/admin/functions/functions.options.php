<?php
add_action('init','of_options');

/***********Instruction***************
** Begin : 177
** Styling options : 396 -> 1061 ==>  	THEME COLOR: 437,THEME PRIMARY:466, THEME BUTTON PRIMAR:524,THEME BUTTON SECONDARY: 580
**			THEME BUTTON TERTIARY:636, PRIMARY TAB: 680, PRIMARY ACCORDION:718, TOP HEADER: 762, VERTICAL MENU:782
**			HORIZONTAL MENU:844 + 20 =  864, SIDEBAR: 918 + 20, FOOTER:986 + 20, PRODUCT:1024 + 20
** Typography	1122 -> 1317	
** Mega Menu	1319 -> 1361
** Integration	1422 -> 1450
** Product Category 	1465 -> 1506
** Product Details		1507 -> 1793
** Blog Options
** Blog Details
** Backup Options
** Documentation
** End
*************************************/
if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sidebars
		$of_sidebars 	= array();
		global $default_sidebars;
		if($default_sidebars){
			foreach( $default_sidebars as $key => $_sidebar ){
				$of_sidebars[$_sidebar['id']] = $_sidebar['name'];
			}
		}

		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}
		
		//default value for logo and favor icon
		$df_logo_images_uri = get_stylesheet_directory_uri(). '/images/logo.png'; 
		$df_icon_images_uri = get_stylesheet_directory_uri(). '/images/favicon.ico'; 
		$df_visa_images_uri = get_stylesheet_directory_uri(). '/images/media/icon_payment_visa.png';
		$df_mastercard_images_uri = get_stylesheet_directory_uri(). '/images/media/icon_payment_master_card.png'; 		
		$df_american_images_uri = get_stylesheet_directory_uri(). '/images/media/icon_payment_american.png'; 		
		$df_paypal_images_uri = get_stylesheet_directory_uri(). '/images/media/icon_payment_paypal.png'; 		
		$df_skrill_images_uri = get_stylesheet_directory_uri(). '/images/media/icon_payment_skrill.png'; 		
		
		$df_z_images_uri = get_stylesheet_directory_uri(). '/images/media/icon_service_01.png'; 		
		$df_fedex_images_uri = get_stylesheet_directory_uri(). '/images/media/icon_service_02.png'; 		
		$df_ups_images_uri = get_stylesheet_directory_uri(). '/images/media/icon_service_03.png'; 		
		
		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		            	natsort($bg_images); //Sorts the array into a natural order
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		$default_font_size = array(	
			"10px"
			,"11px"
			,"12px"
			,"13px"
			,"14px"
			,"15px"
			,"16px"
			,"17px"
			,"18px"
			,"19px"
			,"20px"
			,"21px"
			,"22px"
			,"23px"
			,"24px"
			,"25px"
			,"26px"
			,"27px"
			,"28px"
			,"29px"
			,"30px"		
			,"31px"
			,"32px"
			,"33px"
			,"34px"
			,"35px"
			,"36px"
			,"37px"
			,"38px"
			,"39px"	
			,"40px"	
			,"41px"
			,"42px"
			,"43px"
			,"44px"
			,"45px"
			,"46px"
			,"47px"
			,"48px"
			,"49px"	
			,"50px"		
		);
		
		$faces = array('arial'=>'Arial',
					'verdana'=>'Verdana, Geneva',
					'trebuchet'=>'Trebuchet',
					'georgia' =>'Georgia',
					'times'=>'Times New Roman',
					'tahoma, geneva'=>'Tahoma, Geneva',
					'palatino'=>'Palatino',
					'helvetica'=>'Helvetica' );
										
		$url =  ADMIN_DIR . 'assets/images/';	

		$default_font_size = array_combine($default_font_size, $default_font_size);
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

/***************** TODO : GENERAL ****************/					


global $of_options,$wd_google_fonts;

$of_options = array();
					
$of_options[] = array( 	"name" 		=> "General Settings",
						"type" 		=> "heading"
				);						

$of_options[] = array( 	"name" 		=> "Logo image"
						,"desc" 	=> "Change your logo."
						,"id" 		=> "wd_logo"
						,"std"		=> $df_logo_images_uri
						,"type" 	=> "upload"
				);

$of_options[] = array( 	"name" 		=> "Favor icon image"
						,"desc" 	=> "Accept ICO files"
						,"id" 		=> "wd_icon"
						,"std" 		=> $df_icon_images_uri
						,"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Text Logo"
						,"desc" 	=> "Text Logo"
						,"id" 		=> "wd_text_logo"
						,"std" 		=> "Gomarket"
						,"type" 	=> "text"
				);		
				

$of_options[] = array( 	"name" 		=> "Custom Catalog Mod"
						,"desc" 	=> ""
						,"id" 		=> "introduction_custom_catalog_mod"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Custom Catalog Mod</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);
				
$of_options[] = array( 	"name" 		=> "Catalog Mod"
						,"desc" 	=> "Enable/Disable Add To Cart Button on site"
						,"id" 		=> "wd_catelog_mod"
						,"on"		=> "Enable"
						,"off"		=> "Disable"
						,"std" 		=> 1
						,"type" 	=> "switch"
				);					

$of_options[] = array( 	"name" 		=> "Header Top"
						,"desc" 	=> "Show information support"
						,"id" 		=> "header_top_text"
						,"std" 		=> '24/7 Customer Support (01) 123 456 YOUR STORE'
						,"type" 	=> "textarea"
				);

$of_options[] = array( 	"name" 		=> "Payment Block"
		,"desc" 	=> ""
		,"id" 		=> "introduction_payment"
		,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Custom Image for Payment Block</h3>"
		,"icon" 	=> true
		,"type" 	=> "info"
);	
				
$of_options[] = array( 	"name" 		=> "Visa image"
						,"desc" 	=> "Change your Visa image."
						,"id" 		=> "wd_visa_image"
						,"std"		=> $df_visa_images_uri
						,"type" 	=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Master Card image"
						,"desc" 	=> "Change your Master Card image."
						,"id" 		=> "wd_master_card_image"
						,"std"		=> $df_mastercard_images_uri
						,"type" 	=> "upload"
				);
$of_options[] = array( 	"name" 		=> "American Express image"
						,"desc" 	=> "Change your American Express image."
						,"id" 		=> "wd_american_express_image"
						,"std"		=> $df_american_images_uri
						,"type" 	=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Paypal image"
						,"desc" 	=> "Change your Paypal image."
						,"id" 		=> "wd_paypal_image"
						,"std"		=> $df_paypal_images_uri
						,"type" 	=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Skrill image"
						,"desc" 	=> "Change your Skrill image."
						,"id" 		=> "wd_foo_image"
						,"std"		=> $df_skrill_images_uri
						,"type" 	=> "upload"
				);

$of_options[] = array( 	"name" 		=> "Shipping service Block"
		,"desc" 	=> ""
		,"id" 		=> "introduction_shipping_service"
		,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Custom Image for Shipping Service Block</h3>"
		,"icon" 	=> true
		,"type" 	=> "info"
);	
				
$of_options[] = array( 	"name" 		=> "Z image"
						,"desc" 	=> "Change your Z image."
						,"id" 		=> "wd_z_image"
						,"std"		=> $df_z_images_uri
						,"type" 	=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Fedex image"
						,"desc" 	=> "Change your Fedex image."
						,"id" 		=> "wd_fedex_image"
						,"std"		=> $df_fedex_images_uri
						,"type" 	=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Ups image"
						,"desc" 	=> "Change your Ups image."
						,"id" 		=> "wd_ups_image"
						,"std"		=> $df_ups_images_uri
						,"type" 	=> "upload"
				);
				
$of_options[] = array( 	"name" 		=> "Custom Image Size"
						,"desc" 	=> ""
						,"id" 		=> "introduction_custom_img_size"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Custom Image Size</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);								
				
			
$of_options[] = array( 	"name" 		=> "Size #1"
						,"desc" 	=> "Size #1 width.<br/>Min: 5, max: 1200, step: 5, default value: 1200"
						,"id" 		=> "wd_size1_width"
						,"std" 		=> "1200"
						,"min" 		=> "5"
						,"step"		=> "5"
						,"max" 		=> "1200"
						,"type" 	=> "sliderui" 
				);
				
$of_options[] = array( 	"name" 		=> ""
						,"desc" 	=> "Size #1 height.<br/>Min: 5, max: 1200, step: 5, default value: 450"
						,"id" 		=> "wd_size1_height"
						,"std" 		=> "450"
						,"min" 		=> "5"
						,"step"		=> "5"
						,"max" 		=> "1200"
						,"type" 	=> "sliderui" 
				);
				
$of_options[] = array( 	"name" 		=> "Size #2"
						,"desc" 	=> "Size #2 width.<br /> Min: 5, max: 1200, step: 5, default value: 960"
						,"id" 		=> "wd_size2_width"
						,"std" 		=> "960"
						,"min" 		=> "5"
						,"step"		=> "5"
						,"max" 		=> "1200"
						,"type" 	=> "sliderui" 
				);
				
$of_options[] = array( 	"name" 		=> ""
						,"desc" 	=> "Size #2 height.<br /> Min: 5, max: 1200, step: 5, default value: 300"
						,"id" 		=> "wd_size2_height"
						,"std" 		=> "300"
						,"min" 		=> "5"
						,"step"		=> "5"
						,"max" 		=> "1200"
						,"type" 	=> "sliderui" 
				);


$of_options[] = array( 	"name" 		=> "Size #3"
						,"desc" 	=> "Size #3 width.<br /> Min: 5, max: 1200, step: 5, default value: 480"
						,"id" 		=> "wd_size3_width"
						,"std" 		=> "480"
						,"min" 		=> "5"
						,"step"		=> "5"
						,"max" 		=> "1200"
						,"type" 	=> "sliderui" 
				);
				
$of_options[] = array( 	"name" 		=> ""
						,"desc" 	=> "Size #3 height.<br /> Min: 5, max: 1200, step: 5, default value: 320"
						,"id" 		=> "wd_size3_height"
						,"std" 		=> "320"
						,"min" 		=> "5"
						,"step"		=> "5"
						,"max" 		=> "1200"
						,"type" 	=> "sliderui" 
				);				


$of_options[] = array( 	"name" 		=> "Right Sidebar Feedback Section"
						,"desc" 	=> ""
						,"id" 		=> "introduction_right_sidebar"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Right Sidebar Feedback Section</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);				
		
		
$of_options[] = array( 	"name" 		=> "Sidebar Content"
						,"desc" 	=> 'You can use the contact form 7 shortcode : [contact-form-7 id="Your form ID" title="Your title"]'
						,"id" 		=> "sidebar_content"
						,"std" 		=> '[contact-form-7 id="4" title="GoMarket contact form"]'
						,"type" 	=> "textarea"
				);					
				
$of_options[] = array( 	"name" 		=> "Copyright Section"
						,"desc" 	=> ""
						,"id" 		=> "introduction_custom_copyright"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Copyright Section</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);				
				
$of_options[] = array( 	"name" 		=> "Footer Copyright"
						,"desc" 	=> "You can use the following shortcodes in your footer text: [wp-link] [theme-link] [loginout-link] [blog-title] [blog-link] [the-year]"
						,"id" 		=> "footer_text"
						,"std" 		=> '&amp;copy 2014 GoMarket Wordpress Store. All Rights Reversed. WordPress Templates by <a href="http://wpdance.com/" title="WordPress Themes">WPDance.com</a>'
						,"type" 	=> "textarea"
				);		
				
/***************** TODO : STYLE ****************/					
				
$of_options[] = array( 	"name" 		=> "Styling Options"
						,"type" 	=> "heading"
				);
		
$of_options[] = array( 	"name" 		=> "Preview Panel"
						,"desc" 	=> "Preview Panel allow you to view,change style on frontend"
						,"id" 		=> "wd_preview_panel"
						,"std" 		=> 0
						,"type" 	=> "switch"
				);
			
$of_options[] = array( 	"name" 		=> "Enbale NiceScroll"
						,"desc" 	=> "Enable Nice Scroll Bar on the right browsers"
						,"id" 		=> "wd_nicescroll"
						,"std" 		=> 0
						,"type" 	=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Enbale Custom Style And Fonts"
						,"desc" 	=> "Enable Custom Style And Fonts"
						,"id" 		=> "wd_style_fonts"
						,"std" 		=> 0
						,"type" 	=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Layout Style"
						,"desc" 	=> ""
						,"id" 		=> "wd_layout_styles"
						,"std" 		=> "wide"
						,"type" 	=> "select"
						,"options"	=> array("wide","box")
				);				
$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "Quickly add some CSS to your theme by adding it to this block.",
						"id" 		=> "wd_custom_css",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
				
/************************ THEME COLOR *************************************/
$of_options[] = array( 	"name" 		=> "Theme Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_them_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Theme Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);					
				
		
$of_options[] = array( 	"name" 		=> "Theme Primary Scheme Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Theme Secondary Scheme Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_secondary_color"
						,"std" 		=> "#ff6c00"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Theme Tertiary Scheme Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_tertiary_color"
						,"std" 		=> "#3471b7"
						,"type" 	=> "color"
				);		

/************************ THEME PRIMARY *************************************/
$of_options[] = array( 	"name" 		=> "Primary Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_primary_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Primary Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);					
				
		
$of_options[] = array( 	"name" 		=> "Primary Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_text_color"
						,"std" 		=> "#505050"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Primary Link Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_link_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Primary Link Color Hover"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_link_color_hover"
						,"std" 		=> "#ff6c00"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Primary Heading Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_heading_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Secondary Heading Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_secondary_heading_color"
						,"std" 		=> "#3471b7"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Primary Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_border_color"
						,"std" 		=> "#d0d0d0"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Border Color Hover"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_border_color_hover"
						,"std" 		=> "#ffb399"
						,"type" 	=> "color"
				);		
$of_options[] = array( 	"name" 		=> "Primary Icon Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_icon_color"
						,"std" 		=> "#E02439"
						,"type" 	=> "color"
				);
/************************ THEME BUTTON PRIMARY *************************************/
$of_options[] = array( 	"name" 		=> "Primary Button Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_primary_button_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Primary Button Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);
$of_options[] = array( 	"name" 		=> "Primary Button Gradient Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_button_gradient_start_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Button Gradient End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_button_gradient_end_color"
						,"std" 		=> "#e9e9e9"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Button Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_button_border_color"
						,"std" 		=> "#d8d8d8"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Button Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_button_text_color"
						,"std" 		=> "#505050"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Button Hover Gradient Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_button_hover_gradient_start_color"
						,"std" 		=> "#e9e9e9"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Button Hover Gradient End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_button_hover_gradient_end_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Button Hover Gradient Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_button_hover_border_color"
						,"std" 		=> "#d8d8d8"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Button Hover Hover Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_button_hover_text_color"
						,"std" 		=> "#505050"
						,"type" 	=> "color"
				);	
/************************ THEME BUTTON SECONDARY *************************************/
$of_options[] = array( 	"name" 		=> "Second Button Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_second_button_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Second Button Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);	
$of_options[] = array( 	"name" 		=> "Second Button Gradient Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_secondary_button_gradient_start_color"
						,"std" 		=> "#F24925"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Second Button Gradient End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_secondary_button_gradient_end_color"
						,"std" 		=> "#D62B10"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Second Button Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_secondary_button_border_color"
						,"std" 		=> "#E2391E"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Second Button Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_secondary_button_text_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Second Button Hover Gradient Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_secondary_button_hover_gradient_start_color"
						,"std" 		=> "#D62B10"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Second Button Hover Gradient End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_secondary_button_hover_gradient_end_color"
						,"std" 		=> "#F24925"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Second Button Hover Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_secondary_button_hover_border_color"
						,"std" 		=> "#E2391E"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Second Button Hover Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sedondary_button_hover_text_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);		
/************************ THEME BUTTON TERTIARY *************************************/
$of_options[] = array( 	"name" 		=> "Tertiary Button Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_tertiary_button_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Tertiary Button Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);	
$of_options[] = array( 	"name" 		=> "Tertiary Button Background Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_tertiary_button_background_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Tertiary Button Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_tertiary_button_border_color"
						,"std" 		=> "#bfbfbf"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Tertiary Button Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_tertiary_button_text_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Tertiary Button Hover Background Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_tertiary_button_hover_background_color"
						,"std" 		=> "#bfbfbf"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Tertiary Button Hover Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_tertiary_button_hover_border_color"
						,"std" 		=> "#bfbfbf"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Tertiary Button Hover Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_tertiary_button_hover_text_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
/************************ PRIMARY TAB *************************************/
$of_options[] = array( 	"name" 		=> "Tab Primary Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_tab_primary_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Tab Primary Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);	
$of_options[] = array( 	"name" 		=> "Primary Tab Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_tab_border_color"
						,"std" 		=> "#d0d0d0"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Tab Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_tab_text_color"
						,"std" 		=> "#707070"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Primary Tab Hover Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_tab_hover_text_color"
						,"std" 		=> "#ff6c00"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Tab Active Gradient Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_tab_active_gradient_start_color"
						,"std" 		=> "#e9e9e9"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Tab Active Gradient End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_tab_active_gradient_end_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Tab Active Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_tab_active_text_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);	
/************************ PRIMARY ACCORDION *************************************/
$of_options[] = array( 	"name" 		=> "Accordion Primary Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_accordion_primary_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Accordion Primary Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);	
$of_options[] = array( 	"name" 		=> "Primary Accordion Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_accordion_border_color"
						,"std" 		=> "#d0d0d0"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Accordion Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_accordion_text_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Primary Accordion Gradient Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_accordion_gradient_start_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);		
$of_options[] = array( 	"name" 		=> "Primary Accordion Gradient End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_accordion_gradient_end_color"
						,"std" 		=> "#fff"
						,"type" 	=> "color"
				);		
$of_options[] = array( 	"name" 		=> "Primary Accordion Hover Gradient Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_accordion_hover_gradient_start_color"
						,"std" 		=> "#fff"
						,"type" 	=> "color"
				);		
$of_options[] = array( 	"name" 		=> "Primary Accordion Hover Gradient End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_primary_accordion_hover_gradient_end_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
/************************ TOP HEADER *************************************/
$of_options[] = array( 	"name" 		=> "Top Header Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_top_header_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Top Header Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);	
$of_options[] = array( 	"name" 		=> "Header Top Background Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_header_top_background_color"
						,"std" 		=> "#f2f2f2"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Header Top Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_header_top_text_color"
						,"std" 		=> "#505050"
						,"type" 	=> "color"
				);	
/************************ VERTICAL MENU*************************************/
$of_options[] = array( 	"name" 		=> "Vertical Menu Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_vertical_menu_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Vertical Menu Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);	
$of_options[] = array( 	"name" 		=> "Vertical Menu Control Gradient Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_control_gradient_start_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Vertical Menu Control Gradient End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_control_gradent_end_color"
						,"std" 		=> "#e9e9e9"
						,"type" 	=> "color"
				);			
$of_options[] = array( 	"name" 		=> "Vertical Menu Control Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_control_border_color"
						,"std" 		=> "#f24925"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Vertical Menu Control Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_control_text_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Vertical Menu Background Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_background_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);		
$of_options[] = array( 	"name" 		=> "Vertical Menu Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_text_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Vertical Menu Text Color Hover"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_text_color_hover"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Vertical Menu Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_border_color"
						,"std" 		=> "#d9d9d9"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Vertical Sub Menu Background Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_submenu_background_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Vertical Sub Menu Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_submenu_text_color"
						,"std" 		=> "#505050"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Vertical Sub Menu Text Color Hover"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_submenu_text_color_hover"
						,"std" 		=> "#ff6c00"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Vertical Sub Menu Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_vertical_menu_submenu_border_color"
						,"std" 		=> "#d4d4d4"
						,"type" 	=> "color"
				);				
/************************ HORIZONTAL MENU *************************************/
$of_options[] = array( 	"name" 		=> "Horizontal Menu Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_horizontal_menu_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Horizontal Menu Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);
$of_options[] = array( 	"name" 		=> "Horizontal Menu Gradient Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_horizontal_menu_gradient_start_color"
						,"std" 		=> "#f24925"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Horizontal Menu Gradient End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_horizontal_menu_gradient_end_color"
						,"std" 		=> "#d62b10"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Horizontal Menu Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_horizontal_menu_border_color"
						,"std" 		=> "#e2391e"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Horizontal Menu Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_horizontal_menu_text_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Horizontal Menu Text Color Hover"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_horizontal_menu_text_color_hover"
						,"std" 		=> "#f9b22b"
						,"type" 	=> "color"
				);				
$of_options[] = array( 	"name" 		=> "Horizontal Sub Menu Background Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_horizontal_menu_submenu_background_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);		
$of_options[] = array( 	"name" 		=> "Horizontal Sub Menu Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_horizontal_menu_submenu_border_color"
						,"std" 		=> "#d4d4d4"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Horizontal Sub Menu Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_horizontal_menu_submenu_text_color"
						,"std" 		=> "#505050"
						,"type" 	=> "color"
				);

$of_options[] = array( 	"name" 		=> "Horizontal Sub Menu Text Color Hover"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_horizontal_menu_submenu_text_color_hover"
						,"std" 		=> "#ff6c00"
						,"type" 	=> "color"
				);	
/************************ SIDEBAR *************************************/
$of_options[] = array( 	"name" 		=> "Sidebar Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_sidebar_menu_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Sidebar Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);
$of_options[] = array( 	"name" 		=> "Sidebar Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_text_color"
						,"std" 		=> "#505050"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sidebar Link Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_link_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Sidebar Link Color Hover"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_link_color_hover"
						,"std" 		=> "#3471b7"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sidebar Heading Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_heading_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Sidebar Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_border_color"
						,"std" 		=> "#d0d0d0"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sidebar Gradient Heading Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_gradient_heading_start_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Sidebar Gradient Heading End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_gradient_heading_end_color"
						,"std" 		=> "#e9e9e9"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sidebar Gradient Hover Heading Start Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_gradient_hover_heading_start_color"
						,"std" 		=> "#e9e9e9"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Sidebar Gradient Hover Heading End Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_gradient_hover_heading_end_color"
						,"std" 		=> "#ffffff"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Sidebar Gradient Hover Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_sidebar_gradient_hover_text_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);
/************************ FOOTER *************************************/
$of_options[] = array( 	"name" 		=> "Footer Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_footer_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Footer Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);	
$of_options[] = array( 	"name" 		=> "Footer Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_footer_text_color"
						,"std" 		=> "#505050"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Footer Link Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_footer_link_color"
						,"std" 		=> "#3471b7"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Footer Link Color Hover"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_footer_link_color_hover"
						,"std" 		=> "#3471b7"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Footer Heading Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_footer_heading_color"
						,"std" 		=> "#202020"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Footer Border Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_footer_border_color"
						,"std" 		=> "#e3e3e3"
						,"type" 	=> "color"
				);	
/************************ PRODUCT *************************************/
$of_options[] = array( 	"name" 		=> "Product Color Scheme"
						,"desc" 	=> ""
						,"id" 		=> "introduction_product_color"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Product Color Scheme</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);	
$of_options[] = array( 	"name" 		=> "Product Category Text Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_product_category_text_color"
						,"std" 		=> "#65aa00"
						,"type" 	=> "color"
				);	
/*$of_options[] = array( 	"name" 		=> "Product Category Text Color Hover"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_product_category_text_color_hover"
						,"std" 		=> "#cb0000"
						,"type" 	=> "color"
				);*/
$of_options[] = array( 	"name" 		=> "Product Price Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_product_price_color"
						,"std" 		=> "#cb0000"
						,"type" 	=> "color"
				);	
$of_options[] = array( 	"name" 		=> "Product New Price Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_product_new_price_color"
						,"std" 		=> "#009CF5"
						,"type" 	=> "color"
				);
$of_options[] = array( 	"name" 		=> "Product Old Price Color"
						,"desc" 	=> "Select your themes alternative color scheme."
						,"id" 		=> "wd_product_old_price_color"
						,"std" 		=> "#CACACA"
						,"type" 	=> "color"
				);
		
$of_options[] = array( 	"name" 		=> "Background Options"
						,"desc" 	=> ""
						,"id" 		=> "introduction_background"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">BACKGROUND OPTIONS BELOW ONLY WORK IN BOX MODE.</h3>
						Find this option by go to Appearance => Background"
						,"icon" 	=> true
						,"type" 	=> "info"
				);			
		
// $of_options[] = array( 	"name" 	=> "Background Image"
						// ,"desc" 	=> "Please choose an image or insert an image url to use for the backgroud."
						// ,"id" 		=> "wd_bg_image"
						// ,"std" 		=> ""
						// ,"type" 	=> "upload"
					// );

// $of_options[] = array( 	"name" 		=> "100% Background Image"
						// ,"desc" 	=> "Have background image always at 100% in width and height and scale according to the browser size."
						// ,"id" 		=> "wd_bg_full"
						// ,"std" 		=> 0
						// ,"type" 	=> "checkbox"
					// );

// $of_options[] = array( 	"name" 		=> "Background Repeat"
						// ,"desc" 	=> ""
						// ,"id" 		=> "wd_bg_repeat"
						// ,"std" 		=> ""
						// ,"type" 	=> "select"
						// ,"options" 	=> array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat')
					// );  

// $of_options[] = array( 	"name" 		=>  "Background Color"
						// ,"desc" 	=> "Pick a background color."
						// ,"id" 		=> "wd_bg_color"
						// ,"std" 		=> "#fff"
						// ,"type" 	=> "color"
					// );

// $of_options[] = array(  "name" 		=> "Background Pattern?"
						// ,"desc" 	=> "If yes, select the pattern from below:"
						// ,"id" 		=> "wd_bg_pattern_enable"
						// ,"std" 		=> 0
						// ,"folds" 	=> 1
						// ,"on"		=> "yes"
						// ,"off"		=> "no"						
						// ,"type" 	=> "switch"
				// );	
		
// $of_options[] = array( 	"name" 		=> "Background Images"
						// ,"desc" 	=> "Select a background pattern."
						// ,"id" 		=> "wd_bg_pattern"
						// ,"std" 		=> $bg_images_url."bg0.png"
						// ,"type" 	=> "tiles"
						// ,"options" 	=> $bg_images
						// ,"fold" 	=> "wd_bg_pattern_enable"
				// );		
		
/***************** TODO : TYPO ****************/		

$of_options[] = array( 	"name" 		=> "Typography"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-typography.gif"
				);
		
$of_options[] = array( 	"name" 		=> "Body Font"
						,"desc" 	=> ""
						,"id" 		=> "introduction_bodyfont"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Body Font Options.</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);				
					
$of_options[] = array( 	"name" 		=> "Body font"
						,"desc" 	=> "Using google font for your body font"
						,"id" 		=> "wd_body_font1_googlefont_enable"
						,"std" 		=> 1
						,"folds"	=> 1
						,"on" 		=> "Family Font"
						,"off" 		=> "Google Font"
						,"type" 	=> "switchs"
				);
					
$of_options[] = array( 	"name" 		=> "Body Font Family"
						,"desc" 	=> "Specify the body font properties.Using in case google font disabed"
						,"id" 		=> "wd_body_font1_family"
						,"position"	=> "left"
						,"fold"		=> "wd_body_font1_googlefont_enable"
						,"std" 		=> "Arial"
						,"type" 	=> "select"
						,"options"	=> $faces
				);					
									
					
$of_options[] = array( 	"name" 		=> "Body Google Font"
						,"desc" 	=> "This font going to overwrite the default font."
						,"id" 		=> "wd_body_font1_googlefont"
						,"position"	=> "right"
						,"std" 		=> "Roboto"
						,"type" 	=> "select_google_font"
						,"fold"		=> "wd_body_font1_googlefont_enable"
						,"preview" 	=> array(
										"text" => "This is my body font preview!"
										,"size" => "30px"
						)
						,"options" 	=> $wd_google_fonts
				);	

				
				
// $of_options[] = array( 	"name" 		=> "Body Font Size"
						// ,"desc" 	=> "Specify the body font size properties."
						// ,"id" 		=> "wd_body_fontsize"
						// ,"std" 		=> "12px"
						// ,"type" 	=> "select"
						// ,"options"	=>	$default_font_size
				// );	
				
					
$of_options[] = array( 	"name" 		=> "Heading Font"
						,"desc" 	=> ""
						,"id" 		=> "introduction_headingfont"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Heading Font Options.</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);						
					
$of_options[] = array( 	"name" 		=> "Heading font"
						,"desc" 	=> "Using google font for your heading font"
						,"id" 		=> "wd_heading_font_googlefont_enable"
						,"std" 		=> 1
						,"folds"	=> 1
						,"on" 		=> "Family Font"
						,"off" 		=> "Google Font"
						,"type" 	=> "switchs"
				);
					
$of_options[] = array( 	"name" 		=> "Heading Font Family"
						,"desc" 	=> "Specify the body font properties.Using in case google font disabed"
						,"id" 		=> "wd_heading_fontfamily"
						,"position"	=> "left"
						,"fold"		=> "wd_heading_font_googlefont_enable"
						,"std" 		=> "Arial"
						,"type" 	=> "select"
						,"options"	=> $faces
				);					
					
$of_options[] = array( 	"name" 		=> "Heading Google Font"
						,"desc" 	=> "This font going to overwrite the default font."
						,"id" 		=> "wd_heading_font_googlefont"
						,"std" 		=> "Roboto"
						,"position"	=> "right"
						,"type" 	=> "select_google_font"
						,"fold"		=> "wd_heading_font_googlefont_enable"
						,"preview" 	=> array(
										"text" => "This is my heading font preview!"
										,"size" => "30px"
						)
						,"options" 	=> $wd_google_fonts
				);	

			
					
$of_options[] = array( 	"name" 		=> "Horizontal Menu Font"
						,"desc" 	=> ""
						,"id" 		=> "introduction_horizontal_menufont"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Horizontal Menu Font Options.</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);	
				
$of_options[] = array( 	"name" 		=> "Horizontal Menu font"
						,"desc" 	=> "Using google font for your top menu font"
						,"id" 		=> "wd_horizontal_menu_font_googlefont_enable"
						,"std" 		=> 0
						,"folds"	=> 1
						,"on" 		=> "Family Font"
						,"off" 		=> "Google Font"
						,"type" 	=> "switchs"
				);
					
$of_options[] = array( 	"name" 		=> "Horizontal Menu Font Family"
						,"desc" 	=> "Specify the menu font properties."
						,"id" 		=> "wd_menu_fontfamily"
						,"position"	=> "left"
						,"fold"		=> "wd_horizontal_menu_font_googlefont_enable"
						,"std" 		=> "Arial"
						,"type" 	=> "select"
						,"options"	=> $faces
				);					
					
$of_options[] = array( 	"name" 		=> "Horizontal Menu Google Font Select"
						,"desc" 	=> "This font going to overwrite the default font."
						,"id" 		=> "wd_menu_font_googlefont"
						,"std" 		=> "Source Sans Pro"
						,"position"	=> "right"
						,"type" 	=> "select_google_font"
						,"fold"		=> "wd_horizontal_menu_font_googlefont_enable"
						,"preview" 	=> array(
										"text" => "This is my menu font preview!"
										,"size" => "30px"
						)
						,"options" 	=> $wd_google_fonts
				);	

$of_options[] = array( 	"name" 		=> "Horizontal Sub Menu Font"
		,"desc" 	=> ""
		,"id" 		=> "introduction_subhorizontal_menufont"
		,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Horizontal Sub Menu Font Options.</h3>"
		,"icon" 	=> true
		,"type" 	=> "info"
				);	
				
$of_options[] = array( 	"name" 		=> "Horizontal Sub Menu font"
						,"desc" 	=> "Using google font for your top menu font"
						,"id" 		=> "wd_horizontal_submenu_font_googlefont_enable"
						,"std" 		=> 1
						,"folds"	=> 1
						,"on" 		=> "Family Font"
						,"off" 		=> "Google Font"
						,"type" 	=> "switchs"
				);
					
$of_options[] = array( 	"name" 		=> "Horizontal SubMenu Font Family"
						,"desc" 	=> "Specify the menu font properties."
						,"id" 		=> "wd_submenu_fontfamily"
						,"position"	=> "left"
						,"fold"		=> "wd_horizontal_submenu_font_googlefont_enable"
						,"std" 		=> "Arial"
						,"type" 	=> "select"
						,"options"	=> $faces
				);					
					
$of_options[] = array( 	"name" 		=> "Horizontal Menu Google Font Select"
						,"desc" 	=> "This font going to overwrite the default font."
						,"id" 		=> "wd_submenu_font_googlefont"
						,"std" 		=> "Roboto"
						,"position"	=> "right"
						,"type" 	=> "select_google_font"
						,"fold"		=> "wd_horizontal_submenu_font_googlefont_enable"
						,"preview" 	=> array(
										"text" => "This is my menu font preview!"
										,"size" => "30px"
						)
						,"options" 	=> $wd_google_fonts
				);
				
$of_options[] = array( 	"name" 		=> "Vertical Menu Font"
						,"desc" 	=> ""
						,"id" 		=> "introduction_vertical_menufont"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Vertical Menu Font Options.</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);
$of_options[] = array( 	"name" 		=> "Vertical Menu Font"
						,"desc" 	=> "Select font for your vertical menu font"
						,"id" 		=> "wd_vertical_menu_font_enable"
						,"std" 		=> 1
						,"folds"	=> 1
						,"on" 		=> "Family Font"
						,"off" 		=> "Google Font"
						,"type" 	=> "switchs"
				);
					
$of_options[] = array( 	"name" 		=> "Vertical Menu Default Font"
						,"desc" 	=> "Specify the Vertical menu font properties."
						,"id" 		=> "wd_vertical_menu_family_font"
						,"std" 		=> 'Arial'
						,"position"	=> "left"
						,"fold"		=> "wd_vertical_menu_font_enable"
						,"type" 	=> "select"
						,"options"	=> $faces
				);					
					
$of_options[] = array( 	"name" 		=> "Vertical Menu Google Font Select"
						,"desc" 	=> "This font going to overwrite the default font."
						,"id" 		=> "wd_vertical_menu_googlefont"
						,"std" 		=> "Roboto"
						,"position"	=> "right"
						,"type" 	=> "select_google_font"
						,"fold"		=> "wd_vertical_menu_font_enable"
						,"preview" 	=> array(
										"text" => "This is my Sub menu font preview!"
										,"size" => "30px"
						)
						,"options" 	=> $wd_google_fonts
				);					
$of_options[] = array( 	"name" 		=> "Vertical SubMenu Font"
						,"desc" 	=> ""
						,"id" 		=> "introduction_subvertical_menufont"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Vertical SubMenu Font Options.</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);
$of_options[] = array( 	"name" 		=> "Vertical SubMenu Font"
						,"desc" 	=> "Select font for your vertical submenu font"
						,"id" 		=> "wd_vertical_submenu_font_enable"
						,"std" 		=> 1
						,"folds"	=> 1
						,"on" 		=> "Family Font"
						,"off" 		=> "Google Font"
						,"type" 	=> "switchs"
				);
					
$of_options[] = array( 	"name" 		=> "Vertical Menu Default Font"
						,"desc" 	=> "Specify the Vertical submenu font properties."
						,"id" 		=> "wd_vertical_submenu_family_font"
						,"std" 		=> 'Arial'
						,"position"	=> "left"
						,"fold"		=> "wd_vertical_submenu_font_enable"
						,"type" 	=> "select"
						,"options"	=> $faces
				);					
					
$of_options[] = array( 	"name" 		=> "Vertical Menu Google Font Select"
						,"desc" 	=> "This font going to overwrite the default font."
						,"id" 		=> "wd_vertical_submenu_googlefont"
						,"std" 		=> "Source Sans Pro"
						,"position"	=> "right"
						,"type" 	=> "select_google_font"
						,"fold"		=> "wd_vertical_submenu_font_enable"
						,"preview" 	=> array(
										"text" => "This is my Sub menu font preview!"
										,"size" => "30px"
						)
						,"options" 	=> $wd_google_fonts
				);				
// $of_options[] = array( 	"name" 		=> "Menu Font Size"
						// ,"desc" 	=> "Specify the menu font size properties."
						// ,"id" 		=> "wd_menu_fontsize"
						// ,"std" 		=> "12px"
						// ,"type" 	=> "select"
						// ,"options"	=>	$default_font_size
				// );	  
  

/***************** TODO : Mega Menu ****************/		

$of_options[] = array( 	"name" 		=> "Mega Menu"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "slider-control.png"
				);
				
$of_options[] = array( 	"name" 		=> "Menu Text"
						,"desc" 	=> "Menu text on mobile"
						,"id" 		=> "wd_menu_text"
						,"std" 		=> __("Menu","wpdance")
						,"type" 	=> "text"
				);		

$of_options[] = array( 	"name" 		=> "Menu Thumbnail Size"
						,"desc" 	=> "Thumbnail width.<br /> Min: 5, max: 48, step: 1, default value: 20"
						,"id" 		=> "wd_menu_thumb_width"
						,"std" 		=> "20"
						,"min" 		=> "5"
						,"step"		=> "1"
						,"max" 		=> "48"
						,"type" 	=> "sliderui" 
				);
				
$of_options[] = array( 	"name" 		=> ""
						,"desc" 	=> "Thumbnail height.<br /> Min: 5, max: 48, step: 1, default value: 20"
						,"id" 		=> "wd_menu_thumb_height"
						,"std" 		=> "20"
						,"min" 		=> "5"
						,"step"		=> "1"
						,"max" 		=> "48"
						,"type" 	=> "sliderui" 
				);		

$of_options[] = array( 	"name" 		=> "Mega Menu Widget Area"
						,"desc" 	=> "Number Widget Area Available.<br /> Min: 1, max: 30, step: 1, default value: 5"
						,"id" 		=> "wd_menu_num_widget"
						,"std" 		=> "10"
						,"min" 		=> "1"
						,"step"		=> "1"
						,"max" 		=> "30"
						,"type" 	=> "sliderui" 
				);				


/***************** TODO : Quickshop ****************/		

/**
 * Check if WD Quickshop is active
 **/
 /*
if ( in_array( 'wd_quickshop/wd_quickshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	$df_qs_images_uri = get_stylesheet_directory_uri(). '/images/quickshop.png'; 

	$of_options[] = array( 	"name" 		=> "Quickshop Options"
							,"type" 	=> "heading"
							,"icon"		=> ADMIN_IMAGES . "icon-settings.png"
					);		

	$of_options[] = array( 	"name" 		=> "Button Label"
							,"desc" 	=> "Change button label"
							,"id" 		=> "wd_qs_button_label"
							,"std" 		=> __("Quickshop","wpdance")
							,"type" 	=> "text"
					);	

	$of_options[] = array( 	"name" 		=> "Button image"
							,"desc" 	=> "Change your button image.Leave blank to use button label"
							,"id" 		=> "wd_qs_button_imgage"
							,"std"		=> ""
							,"type" 	=> "upload"
					);	
}

		
				
/***************** TODO : Advertisement ****************/		
/*
$of_options[] = array( 	"name" 		=> "Advertisement"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-edit.png"
				);
				
$of_options[] = array( 	"name" 		=> "Enable Advertisement"
						,"desc" 	=> ""
						,"id" 		=> "wd_enable_advertisement"
						,"std" 		=> 0
						,"folds"	=> 1
						,"on"		=> "yes"
						,"off"		=> "no"
						,"type" 	=> "switch"
				);								
				
$of_options[] = array( 	"name" 		=> "Advertisement Code"
						,"desc" 	=> "Input Html/Js Advertisement Code."
						,"id" 		=> "wd_advertisement_code"
						,"std" 		=> ""
						,"fold"		=> "wd_enable_advertisement"
						,"type" 	=> "textarea"
				);					
				
				
/***************** TODO : Integration ****************/	
			
$of_options[] = array( 	"name" 		=> "Integration"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-add.png"
				);			
	
$of_options[] = array( 	"name" 		=> "Top Blog Details Codes"
						,"desc" 	=> "Quickly add some html/css to top of blog details by adding it to this block."
						,"id" 		=> "wd_top_blog_code"
						,"std" 		=> ""
						,"type" 	=> "textarea"
				);
				
$of_options[] = array( 	"name" 		=> "Bottom Blog Details Codes"
						,"desc" 	=> "Quickly add some html/css to bottom of blog details by adding it to this block."
						,"id" 		=> "wd_bottom_blog_code"
						,"std" 		=> ""
						,"type" 	=> "textarea"
				);

$of_options[] = array( 	"name" 		=> "Before Body End Code"
						,"desc" 	=> "Quickly add some html/css adding it to this block."
						,"id" 		=> "wd_before_body_end_code"
						,"std" 		=> ""
						,"type" 	=> "textarea"
				);				
	
$of_options[] = array( 	"name" 		=> "Google Analytic Code"
						,"desc" 	=> "Quickly add some html/css adding it to this block."
						,"id" 		=> "wd_google_analytic_code"
						,"std" 		=> ""
						,"type" 	=> "textarea"
				);	
/*	
$of_options[] = array( 	"name" 		=> "Custom CSS"
						,"desc" 	=> "Quickly add some CSS to your theme by adding it to this block."
						,"id" 		=> "wd_custom_css"
						,"std" 		=> ""
						,"type" 	=> "textarea"
				);
*/				
								
/***************** TODO : Product Category Options ****************/							
$of_options[] = array( 	"name" 		=> "Product Category"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);
$of_options[] = array( 	"name" 		=> "Category Columns"
						,"id" 		=> "wd_prod_cat_column"
						,"std" 		=> "5"
						,"type" 	=> "select"
						,"mod"		=> "mini"
						,"options" 	=> array(2,3,4,5,6)
				);		

$of_options[] = array( 	"name" 		=> "Category Layout"
						,"desc" 	=> "Select main content and sidebar alignment. Choose between 1, 2 column layout."
						,"id" 		=> "wd_prod_cat_layout"
						,"std" 		=> "0-1-0"
						,"type" 	=> "images"
						,"options" 	=> array(
							'0-1-0' 	=> $url . '1col.png'
							,'0-1-1' 	=> $url . '2cr.png'
							,'1-1-0' 	=> $url . '2cl.png'
							,'1-1-1' 	=> $url . '3cm.png'
						)
				);								

$of_options[] = array( 	"name" 		=> "Left Sidebar"
						,"id" 		=> "wd_prod_cat_left_sidebar"
						,"std" 		=> "category-widget-area"
						,"type" 	=> "select"
						//,"mod"		=> "mini"
						,"options" 	=> $of_sidebars
				);

$of_options[] = array( 	"name" 		=> "Right Sidebar"
						,"id" 		=> "wd_prod_cat_right_sidebar"
						,"std" 		=> "category-widget-area"
						,"type" 	=> "select"
						//,"mod"		=> "mini"
						,"options" 	=> $of_sidebars
				);
				
/***************** TODO : Product Details Options ****************/	
$of_options[] = array( 	"name" 		=> "Product Details"
						,"type" 		=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);		

$of_options[] = array( 	"name" 		=> "Product Image"
						,"desc" 	=> "Show/hide Product Image"
						,"id" 		=> "wd_prod_image"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Product Cloud-zoom"
						,"desc" 	=> "Show/hide Product Cloud-zoom"
						,"id" 		=> "wd_prod_cloudzoom"
						,"std" 		=> 1
						,"on" 		=> "Enable"
						,"off" 		=> "Disable"
						,"type" 	=> "switch"
				);	

$of_options[] = array( 	"name" 		=> "Product Label"
						,"desc" 	=> "Show/hide Product Label"
						,"id" 		=> "wd_prod_label"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
	

$of_options[] = array( 	"name" 		=> "Product Title"
						,"desc" 	=> "Show/hide Product Title"
						,"id" 		=> "wd_prod_title"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Product Sku"
						,"desc" 	=> "Show/hide Product Sku"
						,"id" 		=> "wd_prod_sku"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
/*$of_options[] = array( 	"name" 		=> "Product Rating"
						,"desc" 	=> "Show/hide Product Rating"
						,"id" 		=> "wd_prod_rating"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
*/				
$of_options[] = array( 	"name" 		=> "Product Banner"
						,"desc" 	=> "Show/hide Product Banner Area"
						,"id" 		=> "wd_prod_banner"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);				
$of_options[] = array( 	"name" 		=> "Product Rating & Review"
						,"desc" 	=> "Show/hide Product Rating & Review"
						,"id" 		=> "wd_prod_review"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
	

$of_options[] = array( 	"name" 		=> "Product Availability"
						,"desc" 	=> "Show/hide Product Availability"
						,"id" 		=> "wd_prod_availability"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
	

$of_options[] = array( 	"name" 		=> "Product AddToCart Button"
						,"desc" 	=> "Show/hide Product AddToCart Button"
						,"id" 		=> "wd_prod_cart"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);


$of_options[] = array( 	"name" 		=> "Product Price"
						,"desc" 	=> "Show/hide Product Price"
						,"id" 		=> "wd_prod_price"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);


$of_options[] = array( 	"name" 		=> "Product Short Desc"
						,"desc" 	=> "Show/hide Product Short Desc"
						,"id" 		=> "wd_prod_shortdesc"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);



$of_options[] = array( 	"name" 		=> "Product Meta(Tags,Categories) "
						,"desc" 	=> "Show/hide Product Meta(Tags,Categories) "
						,"id" 		=> "wd_prod_meta"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
	

$of_options[] = array( 	"name" 		=> "Product Related Products"
						,"desc" 	=> "Show/hide Product Related Products"
						,"id" 		=> "wd_prod_related"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);
	
$of_options[] = array( 	"name" 		=> "Related Product Title"
						,"id" 		=> "wd_prod_related_title"
						,"std" 		=> __('RELATED ITEMS','wpdance')
						,"fold" 	=> "wd_prod_related"
						,"type" 	=> "text"
				);			
/*				
$of_options[] = array( 	"name" 		=> "Related Product Number"
						,"desc" 	=> "Number of related products"
						,"id" 		=> "wd_prod_related_num"
						,"std" 		=> 6
						,"fold" 	=> "wd_prod_related"
						,"type" 	=> "select"
						,"mod"		=> "mini"
						,"options" 	=> array(3,4,5,6,7,8,9)
				);	*/		
$of_options[] = array( 	"name" 		=> "Product Upsell"
						,"desc" 	=> "Show/hide Product Upsell"
						,"id" 		=> "wd_prod_upsell"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);			
$of_options[] = array( 	"name" 		=> "Upsell Product Title"
						,"id" 		=> "wd_prod_upsell_title"
						,"std" 		=> __('YOU MAY ALSO LIKE','wpdance')
						,"fold" 	=> "wd_prod_upsell"
						,"type" 	=> "text"
				);			
			
$of_options[] = array( 	"name" 		=> "Product Share"
						,"desc" 	=> "Show/hide Product Social Sharing"
						,"id" 		=> "wd_prod_share"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Product Share"
						,"id" 		=> "wd_prod_share_title"
						,"std" 		=> __('Share this','wpdance')
						,"fold" 	=> "wd_prod_share"
						,"type" 	=> "text"
				);	
/*
$of_options[] = array( 	"name" 		=> "Product Sharing Code"
						,"id" 		=> "wd_prod_share_code"
						,"std" 		=> "Share This"
						,"fold" 	=> "wd_prod_share"
						,"type" 	=> "textarea"
				);
*/
$of_options[] = array( 	"name" 		=> "Ship & Return Box"
						,"desc" 	=> "Show/hide Ship & Return Box"
						,"id" 		=> "wd_prod_ship_return"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds" 	=> 1
						,"type" 	=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Show Ship & Return Box Title"
						,"id" 		=> "wd_prod_ship_return_title"
						,"std" 		=> "FREE SHIPPING & RETURN"
						,"fold" 	=> "wd_prod_ship_return"
						,"type" 	=> "text"
				);

$of_options[] = array( 	"name" 		=> "Show Ship & Return Box Content"
						,"id" 		=> "wd_prod_ship_return_content"
						,"std" 		=> '<a href="#"><img title="free shipping and return" alt="free shipping and return" src="http://demo.wpdance.com/imgs/woocommerce/return_shipping.png" /></a>
<div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s</div>'
						,"fold" 	=> "wd_prod_ship_return"
						,"type" 	=> "textarea"
				);
								
$of_options[] = array( 	"name" 		=> "Product Tabs"
						,"desc" 	=> "Show/hide Product Tabs"
						,"id" 		=> "wd_prod_tabs"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);	
	
$of_options[] = array( 	"name" 		=> "Product Custom Tab"
						,"desc" 	=> "Show/hide Product Custom Tab"
						,"id" 		=> "wd_prod_customtab"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"fold"		=> "wd_prod_tabs"
						,"type" 	=> "switch"
				);			
		
$of_options[] = array( 	"name" 		=> "Product Custom Tab Title"
						,"id" 		=> "wd_prod_customtab_title"
						,"std" 		=> "Custom Tab"
						,"fold" 	=> "wd_prod_customtab"
						,"type" 	=> "text"
				);

$of_options[] = array( 	"name" 		=> "Product Custom Tab Content"
						,"id" 		=> "wd_prod_customtab_content"
						,"std" 		=> "custom contents goes here"
						,"fold" 	=> "wd_prod_customtab"
						,"type" 	=> "textarea"
				);		

$of_options[] = array( 	"name" 		=> "Product Layout"
						,"desc" 	=> "Select main content and sidebar alignment. Choose between 1, 2 column layout."
						,"id" 		=> "wd_prod_layout"
						,"std" 		=> "0-1-0"
						,"type" 	=> "images"
						,"options" 	=> array(
							'0-1-0' 	=> $url . '1col.png'
							,'0-1-1' 	=> $url . '2cr.png'
							,'1-1-0' 	=> $url . '2cl.png'
							,'1-1-1' 	=> $url . '3cm.png'
						)
				);
$of_options[] = array( 	"name" 		=> "Left Sidebar"
						,"id" 		=> "wd_prod_left_sidebar"
						,"std" 		=> "category-widget-area"
						,"type" 	=> "select"
						//,"mod"		=> "mini"
						,"options" 	=> $of_sidebars
				);	
$of_options[] = array( 	"name" 		=> "Right Sidebar"
						,"id" 		=> "wd_prod_right_sidebar"
						,"std" 		=> "category-widget-area"
						,"type" 	=> "select"
						//,"mod"		=> "mini"
						,"options" 	=> $of_sidebars
				);				
/***************** TODO : Blog Options ****************/	
$of_options[] = array( 	"name" 		=> "Blog Options"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);
				
$of_options[] = array( 	"name" 		=> "Blog Categories"
						,"desc" 	=> "Show/hide Categories"
						,"id" 		=> "wd_blog_categories"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
				
$of_options[] = array( 	"name" 		=> "Blog Author"
						,"desc" 	=> "Show/hide Author"
						,"id" 		=> "wd_blog_author"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		

$of_options[] = array( 	"name" 		=> "Blog Time"
						,"desc" 	=> "Show/hide Time"
						,"id" 		=> "wd_blog_time"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);	
/*	
$of_options[] = array( 	"name" 		=> "Blog Tags"
						,"desc" 	=> "Show/hide Tags"
						,"id" 		=> "wd_blog_tags"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);	
*/	
	

				
$of_options[] = array( 	"name" 		=> "Blog Comment Number"
						,"desc" 	=> "Show/hide Comment Number"
						,"id" 		=> "wd_blog_comment_number"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Excerpt"
						,"desc" 	=> "Show/hide Excerpt"
						,"id" 		=> "wd_blog_excerpt"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Thumbnail"
						,"desc" 	=> "Show/hide Thumbnail"
						,"id" 		=> "wd_blog_thumbnail"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Read More"
						,"desc" 	=> "Show/hide Read More"
						,"id" 		=> "wd_blog_readmore"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);							

/***************** TODO : Blog Details ****************/
	
$of_options[] = array( 	"name" 		=> "Blog Details"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);
				
$of_options[] = array( 	"name" 		=> "Blog Categories"
						,"desc" 	=> "Show/hide Categories"
						,"id" 		=> "wd_blog_details_categories"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
				
$of_options[] = array( 	"name" 		=> "Blog Author"
						,"desc" 	=> "Show/hide Author"
						,"id" 		=> "wd_blog_details_author"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		

$of_options[] = array( 	"name" 		=> "Blog Time"
						,"desc" 	=> "Show/hide Time"
						,"id" 		=> "wd_blog_details_time"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Tags"
						,"desc" 	=> "Show/hide Tags"
						,"id" 		=> "wd_blog_details_tags"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);
/*					
$of_options[] = array( 	"name" 		=> "Blog Thumbnail"
						,"desc" 	=> "Show/hide Thumbnail"
						,"id" 		=> "wd_blog_details_thumbnail"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
*/					
$of_options[] = array( 	"name" 		=> "Blog Comment"
						,"desc" 	=> "Show/hide Comment"
						,"id" 		=> "wd_blog_details_comment"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Social Sharing"
						,"desc" 	=> "Show/hide Social Sharing"
						,"id" 		=> "wd_blog_details_socialsharing"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Author Box"
						,"desc" 	=> "Show/hide Author Box"
						,"id" 		=> "wd_blog_details_authorbox"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Related Posts"
						,"desc" 	=> "Show/hide Related Posts"
						,"id" 		=> "wd_blog_details_related"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);			

$of_options[] = array( 	"name" 		=> "Blog Related Label"
						,"desc" 	=> "Related Label"
						,"id" 		=> "wd_blog_details_relatedlabel"
						,"std" 		=> __("Related Posts","wpdance")
						,"fold"		=> "wd_blog_details_related"
						,"type" 	=> "text"		
					);	
$of_options[] = array( 	"name" 		=> "Blog Related Number"
						,"desc" 	=> "Related Number"
						,"id" 		=> "wd_blog_details_relatednumber"
						,"std" 		=> "6"
						,"mod"		=> "mini"
						,"fold"		=> "wd_blog_details_related"
						,"type" 	=> "select"	
						,"options"	=> array(4,5,6,7,8,9,10)
					);					
$of_options[] = array( 	"name" 		=> "Blog Comment List"
						,"desc" 	=> "Show/hide Comment List"
						,"id" 		=> "wd_blog_details_commentlist"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);						
				
$of_options[] = array( 	"name" 		=> "Blog Comment List Label"
						,"desc" 	=> "Comment List Label"
						,"id" 		=> "wd_blog_details_commentlabel"
						,"std" 		=> __("Comment(s)","wpdance")
						,"fold"		=> "wd_blog_details_commentlist"
						,"type" 	=> "text"		
					);					
/***************** TODO : Backup Options ****************/

$of_options[] = array( 	"name" 		=> "Backup Options"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-backup.png"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options"
						,"id" 		=> "of_backup"
						,"std" 		=> ""
						,"type" 	=> "backup"
						,"desc" 	=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.'
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data"
						,"id" 		=> "of_transfer"
						,"std" 		=> ""
						,"type" 	=> "transfer"
						,"desc" 	=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".'
				);
				
/***************** TODO : Documentation ****************/				
				
$of_options[] = array( 	"name" 		=> "Documentation"
						,"type" 		=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-docs.png"
				);
				
$of_options[] = array( 	"name" 		=> "Docs #1"
						,"desc" 		=> ""
						,"id" 		=> "introduction"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Welcome to the Options Framework demo.</h3>
							This is a slightly modified version of the original options framework by Devin Price with a couple of aesthetical improvements on the interface and some cool additional features. If you want to learn how to setup these options or just need general help on using it feel free to visit my blog at <a href=\"http://aquagraphite.com/2011/09/29/slightly-modded-options-framework/\">AquaGraphite.com</a>"
						,"icon" 		=> true
						,"type" 		=> "info"
				);	

$of_options[] = array( 	"name" 		=> "Docs #2"
						,"desc" 		=> ""
						,"id" 		=> "introduction"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Welcome to the Options Framework demo.</h3>
							This is a slightly modified version of the original options framework by Devin Price with a couple of aesthetical improvements on the interface and some cool additional features. If you want to learn how to setup these options or just need general help on using it feel free to visit my blog at <a href=\"http://aquagraphite.com/2011/09/29/slightly-modded-options-framework/\">AquaGraphite.com</a>"
						,"icon" 		=> true
						,"type" 		=> "info"
				);	


$of_options[] = array( 	"name" 		=> "Docs #3"
						,"desc" 		=> ""
						,"id" 		=> "introduction"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Welcome to the Options Framework demo.</h3>
							This is a slightly modified version of the original options framework by Devin Price with a couple of aesthetical improvements on the interface and some cool additional features. If you want to learn how to setup these options or just need general help on using it feel free to visit my blog at <a href=\"http://aquagraphite.com/2011/09/29/slightly-modded-options-framework/\">AquaGraphite.com</a>"
						,"icon" 		=> true
						,"type" 		=> "info"
				);	

$of_options[] = array( 	"name" 		=> "Docs #4"
						,"desc" 		=> ""
						,"id" 		=> "introduction"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Welcome to the Options Framework demo.</h3>
							This is a slightly modified version of the original options framework by Devin Price with a couple of aesthetical improvements on the interface and some cool additional features. If you want to learn how to setup these options or just need general help on using it feel free to visit my blog at <a href=\"http://aquagraphite.com/2011/09/29/slightly-modded-options-framework/\">AquaGraphite.com</a>"
						,"icon" 		=> true
						,"type" 		=> "info"
				);					
				
	}//End function: of_options()
}//End chack if function exists: of_options()

function get_google_font(){
	//$url = "https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha";
	$url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAP4SsyBZEIrh0kc_cO9s90__r2oCJ8Rds&sort=alpha";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_REFERER, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	curl_close($ch);
	return ($result);
}
?>
