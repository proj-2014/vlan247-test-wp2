<?php
	function toRGB($Hex){
		if (substr($Hex,0,1) == "#")
			$Hex = substr($Hex,1);
			
			

		$R = substr($Hex,0,2);
		$G = substr($Hex,2,2);
		$B = substr($Hex,4,2);

		$R = hexdec($R);
		$G = hexdec($G);
		$B = hexdec($B);

		$RGB['R'] = $R;
		$RGB['G'] = $G;
		$RGB['B'] = $B;

		return $RGB;
	}

	add_action('of_save_options_after','save_custom_style',10000);
	add_action('wp_enqueue_scripts', 'custom_style_inline_script');
	function save_custom_style( $data = array() ){
		//wrong input type
		if( !is_array($data) ){
			return -1;
		}
		
		$data_style = $data['data'];
		
		try{			
			ob_start();
			print_r($data_style['wd_custom_css']);
			$custom_css_file = THEME_CACHE.'/custom.css';	
			$file1 = @fopen($custom_css_file, 'w');
			if( $file1 != false ){
				@fwrite($file1, ob_get_contents()); 
				@fclose($file1); 
			}
			ob_end_clean();

		}catch(Excetion $e){
			return -1;
		}
			
		$cache_file = THEME_CACHE.'custom.less';	
					
		try{			
			ob_start();

			?>
			
			// Font
			@font_body:"<?php echo $font_name = $data_style['wd_body_font1_googlefont_enable'] == 1 ? esc_attr( $data_style['wd_body_font1_family'] ) : esc_attr( $data_style['wd_body_font1_googlefont'] ) ?>", sans-serif;

			@font_horizontalmenu:"<?php echo $font_name = $data_style['wd_horizontal_menu_font_googlefont_enable'] == 1 ? esc_attr( $data_style['wd_menu_fontfamily'] ) : esc_attr( $data_style['wd_menu_font_googlefont'] ) ?>", sans-serif;
			
			@font_horizontalmenu_submenu:"<?php echo $font_name = $data_style['wd_horizontal_submenu_font_googlefont_enable'] == 1 ? esc_attr( $data_style['wd_submenu_fontfamily'] ) : esc_attr( $data_style['wd_submenu_font_googlefont'] ) ?>", sans-serif;

			@font_verticalmenu:"<?php echo $font_name = $data_style['wd_vertical_menu_font_enable'] == 1 ? esc_attr( $data_style['wd_vertical_menu_family_font'] ) : esc_attr( $data_style['wd_vertical_menu_googlefont'] ) ?>", sans-serif;
			
			@font_verticalmenu_submenu:"<?php echo $font_name = $data_style['wd_vertical_submenu_font_enable'] == 1 ? esc_attr( $data_style['wd_vertical_submenu_family_font'] ) : esc_attr( $data_style['wd_vertical_submenu_googlefont'] ) ?>", sans-serif;

			@font_heading:"<?php echo $font_name = $data_style['wd_heading_font_googlefont_enable'] == 1 ? esc_attr( $data_style['wd_heading_fontfamily'] ) : esc_attr( $data_style['wd_heading_font_googlefont'] ) ?>", sans-serif;

			
			@primary_color:<?php echo esc_attr($data_style['wd_primary_color']); ?>;
			@secondary_color:<?php echo esc_attr($data_style['wd_secondary_color']); ?>;
			@tertiary_color:<?php echo esc_attr($data_style['wd_tertiary_color']); ?>;

			// PRIMARY

			@primary_text_color:<?php echo esc_attr($data_style['wd_primary_text_color']); ?>;
			@primary_link_color:<?php echo esc_attr($data_style['wd_primary_link_color']); ?>;
			@primary_link_color_hover:<?php echo esc_attr($data_style['wd_primary_link_color_hover']); ?>;
			@primary_heading_color:<?php echo esc_attr($data_style['wd_primary_heading_color']); ?>;
			@secondary_heading_color:<?php echo esc_attr($data_style['wd_secondary_heading_color']); ?>;
			@primary_border_color:<?php echo esc_attr($data_style['wd_primary_border_color']); ?>;
			@primary_border_color_hover:<?php echo esc_attr($data_style['wd_primary_border_color_hover']); ?>;
			@primary_icon_color:<?php echo esc_attr($data_style['wd_primary_icon_color']); ?>;
			@primary_button_gradient_start_color:<?php echo esc_attr($data_style['wd_primary_button_gradient_start_color']); ?>;
			@primary_button_gradient_end_color:<?php echo esc_attr($data_style['wd_primary_button_gradient_end_color']); ?>;
			@primary_button_border_color:<?php echo esc_attr($data_style['wd_primary_button_border_color']); ?>;
			@primary_button_text_color:<?php echo esc_attr($data_style['wd_primary_button_text_color']); ?>;
			@primary_button_hover_gradient_start_color:<?php echo esc_attr($data_style['wd_primary_button_hover_gradient_start_color']); ?>;
			@primary_button_hover_gradient_end_color:<?php echo esc_attr($data_style['wd_primary_button_hover_gradient_end_color']); ?>;
			@primary_button_hover_border_color:<?php echo esc_attr($data_style['wd_primary_button_hover_border_color']); ?>;
			@primary_button_hover_text_color:<?php echo esc_attr($data_style['wd_primary_button_hover_text_color']); ?>;
			@secondary_button_gradient_start_color:<?php echo esc_attr($data_style['wd_secondary_button_gradient_start_color']); ?>;
			@secondary_button_gradient_end_color:<?php echo esc_attr($data_style['wd_secondary_button_gradient_end_color']); ?>;
			@secondary_button_border_color:<?php echo esc_attr($data_style['wd_secondary_button_border_color']); ?>;
			@secondary_button_text_color:<?php echo esc_attr($data_style['wd_secondary_button_text_color']); ?>;
			@secondary_button_hover_gradient_start_color:<?php echo esc_attr($data_style['wd_secondary_button_hover_gradient_start_color']); ?>;
			@secondary_button_hover_gradient_end_color:<?php echo esc_attr($data_style['wd_secondary_button_hover_gradient_end_color']); ?>;
			@secondary_button_hover_border_color:<?php echo esc_attr($data_style['wd_secondary_button_hover_border_color']); ?>;
			@sedondary_button_hover_text_color:<?php echo esc_attr($data_style['wd_sedondary_button_hover_text_color']); ?>;
			@tertiary_button_background_color:<?php echo esc_attr($data_style['wd_tertiary_button_background_color']); ?>;
			@tertiary_button_border_color:<?php echo esc_attr($data_style['wd_tertiary_button_border_color']); ?>;
			@tertiary_button_text_color:<?php echo esc_attr($data_style['wd_tertiary_button_text_color']); ?>;
			@tertiary_button_hover_background_color:<?php echo esc_attr($data_style['wd_tertiary_button_hover_background_color']); ?>;
			@tertiary_button_hover_border_color:<?php echo esc_attr($data_style['wd_tertiary_button_hover_border_color']); ?>;
			@tertiary_button_hover_text_color:<?php echo esc_attr($data_style['wd_tertiary_button_hover_text_color']); ?>;
			@primary_tab_border_color:<?php echo esc_attr($data_style['wd_primary_tab_border_color']); ?>;
			@primary_tab_text_color:<?php echo esc_attr($data_style['wd_primary_tab_text_color']); ?>;
			@primary_tab_hover_text_color:<?php echo esc_attr($data_style['wd_primary_tab_hover_text_color']); ?>;
			@primary_tab_active_gradient_start_color:<?php echo esc_attr($data_style['wd_primary_tab_active_gradient_start_color']); ?>;
			@primary_tab_active_gradient_end_color:<?php echo esc_attr($data_style['wd_primary_tab_active_gradient_end_color']); ?>;
			@primary_tab_active_text_color:<?php echo esc_attr($data_style['wd_primary_tab_active_text_color']); ?>;
			@primary_accordion_border_color:<?php echo esc_attr($data_style['wd_primary_accordion_border_color']); ?>;
			@primary_accordion_text_color:<?php echo esc_attr($data_style['wd_primary_accordion_text_color']); ?>;
			@primary_accordion_gradient_start_color:<?php echo esc_attr($data_style['wd_primary_accordion_gradient_start_color']); ?>;
			@primary_accordion_gradient_end_color:<?php echo esc_attr($data_style['wd_primary_accordion_gradient_end_color']); ?>;
			@primary_accordion_hover_gradient_start_color:<?php echo esc_attr($data_style['wd_primary_accordion_hover_gradient_start_color']); ?>;
			@primary_accordion_hover_gradient_end_color:<?php echo esc_attr($data_style['wd_primary_accordion_hover_gradient_end_color']); ?>;

			// TOP HEADER 

			@header_top_background_color:<?php echo esc_attr($data_style['wd_header_top_background_color']); ?>;
			@header_top_text_color:<?php echo esc_attr($data_style['wd_header_top_text_color']); ?>;

			// VERTICAL MENU

			@vertical_menu_control_gradient_start_color:<?php echo esc_attr($data_style['wd_vertical_menu_control_gradient_start_color']); ?>;
			@vertical_menu_control_gradent_end_color:<?php echo esc_attr($data_style['wd_vertical_menu_control_gradent_end_color']); ?>;
			@vertical_menu_control_border_color:<?php echo esc_attr($data_style['wd_vertical_menu_control_border_color']); ?>;
			@vertical_menu_control_text_color:<?php echo esc_attr($data_style['wd_vertical_menu_control_text_color']); ?>;
			@vertical_menu_background_color:<?php echo esc_attr($data_style['wd_vertical_menu_background_color']); ?>;
			@vertical_menu_text_color:<?php echo esc_attr($data_style['wd_vertical_menu_text_color']); ?>;
			@vertical_menu_text_color_hover:<?php echo esc_attr($data_style['wd_vertical_menu_text_color_hover']); ?>;
			@vertical_menu_border_color:<?php echo esc_attr($data_style['wd_vertical_menu_border_color']); ?>;
			@vertical_menu_submenu_background_color:<?php echo esc_attr($data_style['wd_vertical_menu_submenu_background_color']); ?>;
			@vertical_menu_submenu_text_color:<?php echo esc_attr($data_style['wd_vertical_menu_submenu_text_color']); ?>;
			@vertical_menu_submenu_text_color_hover:<?php echo esc_attr($data_style['wd_vertical_menu_submenu_text_color_hover']); ?>;
			@vertical_menu_submenu_border_color:<?php echo esc_attr($data_style['wd_vertical_menu_submenu_border_color']); ?>;
			// HORIZONTAL MENU

			@horizontal_menu_gradient_start_color:<?php echo esc_attr($data_style['wd_horizontal_menu_gradient_start_color']); ?>;
			@horizontal_menu_gradient_end_color:<?php echo esc_attr($data_style['wd_horizontal_menu_gradient_end_color']); ?>;
			@horizontal_menu_border_color:<?php echo esc_attr($data_style['wd_horizontal_menu_border_color']); ?>;
			@horizontal_menu_text_color:<?php echo esc_attr($data_style['wd_horizontal_menu_text_color']); ?>;
			@horizontal_menu_text_color_hover:<?php echo esc_attr($data_style['wd_horizontal_menu_text_color_hover']); ?>;
			@horizontal_menu_submenu_background_color:<?php echo esc_attr($data_style['wd_horizontal_menu_submenu_background_color']); ?>;
			@horizontal_menu_submenu_border_color:<?php echo esc_attr($data_style['wd_horizontal_menu_submenu_border_color']); ?>;
			@horizontal_menu_submenu_text_color:<?php echo esc_attr($data_style['wd_horizontal_menu_submenu_text_color']); ?>;
			@horizontal_menu_submenu_text_color_hover:<?php echo esc_attr($data_style['wd_horizontal_menu_submenu_text_color_hover']); ?>;
			
			// SIDEBAR 

			@sidebar_text_color:<?php echo esc_attr($data_style['wd_sidebar_text_color']); ?>;
			@sidebar_link_color:<?php echo esc_attr($data_style['wd_sidebar_link_color']); ?>;
			@sidebar_link_color_hover:<?php echo esc_attr($data_style['wd_sidebar_link_color_hover']); ?>;
			@sidebar_heading_color:<?php echo esc_attr($data_style['wd_sidebar_heading_color']); ?>;
			@sidebar_border_color:<?php echo esc_attr($data_style['wd_sidebar_border_color']); ?>;
			@sidebar_gradient_heading_start_color:<?php echo esc_attr($data_style['wd_sidebar_gradient_heading_start_color']); ?>;
			@sidebar_gradient_heading_end_color:<?php echo esc_attr($data_style['wd_sidebar_gradient_heading_end_color']); ?>;
			@sidebar_gradient_hover_heading_start_color:<?php echo esc_attr($data_style['wd_sidebar_gradient_hover_heading_start_color']); ?>;
			@sidebar_gradient_hover_heading_end_color:<?php echo esc_attr($data_style['wd_sidebar_gradient_hover_heading_end_color']); ?>;
			@sidebar_gradient_hover_text_color:<?php echo esc_attr($data_style['wd_sidebar_gradient_hover_text_color']); ?>;

			// FOOTER 

			@footer_text_color:<?php echo esc_attr($data_style['wd_footer_text_color']); ?>;
			@footer_link_color:<?php echo esc_attr($data_style['wd_footer_link_color']); ?>;
			@footer_link_color_hover:<?php echo esc_attr($data_style['wd_footer_link_color_hover']); ?>;
			@footer_heading_color:<?php echo esc_attr($data_style['wd_footer_heading_color']); ?>;
			@footer_border_color:<?php echo esc_attr($data_style['wd_footer_border_color']); ?>;

			// PRODUCT 

			@product_category_text_color:<?php echo esc_attr($data_style['wd_product_category_text_color']); ?>;
			//@product_category_text_color_hover:<?php echo esc_attr($data_style['wd_product_category_text_color_hover']); ?>;
			@product_price_color:<?php echo esc_attr($data_style['wd_product_price_color']); ?>;
			@product_new_price_color:<?php echo esc_attr($data_style['wd_product_new_price_color']); ?>;
			@product_old_price_color:<?php echo esc_attr($data_style['wd_product_old_price_color']); ?>;
			
			// Functions
			.gradient(@start, @end) {
				background: mix(@start, @end, 50%);
				filter: ~"progid:DXImageTransform.Microsoft.gradient(startColorStr="@start~", EndColorStr="@end~")";
				background: -webkit-gradient(linear, left top, left bottom, from(@start), to(@end));
				background: -webkit-linear-gradient(@start, @end);
				background: -moz-linear-gradient(top, @start, @end);
				background: -ms-linear-gradient(@start, @end);
				background: -o-linear-gradient(@start, @end);
				background: linear-gradient(@start, @end);
				zoom: 1;
			}

			.gradient_1(@start, @end) {
				background: mix(@start, @end, 50%);
				filter: ~"progid:DXImageTransform.Microsoft.gradient(startColorStr="@start~", EndColorStr="@end~")";
				background-image: -webkit-linear-gradient(top, @start 19%, @end 100%);
				background-image: -moz-linear-gradient(top, @start 19%, @end 100%);
				background-image: -o-linear-gradient(top, @start 19%, @end 100%);
				background-image: linear-gradient(@start 19%, @end 100%); 
			}

			.gradient_2(@start, @end) {
				background: mix(@start, @end, 50%);
				filter: ~"progid:DXImageTransform.Microsoft.gradient(startColorStr="@start~", EndColorStr="@end~")";
				background-image: -webkit-linear-gradient(top, @start 62%, @end 100%);
				background-image: -moz-linear-gradient(top, @start 62%, @end 100%);
				background-image: -o-linear-gradient(top, @start 62%, @end 100%);
				background-image: linear-gradient(@start 62%, @end 100%); 
			}
			
			.gradient_3(@start, @end) {
				background: mix(@start, @end, 50%);
				background: -webkit-gradient(linear, left top, left bottom, from(@start), to(@end));
				background: -webkit-linear-gradient(@start, @end);
				background: -moz-linear-gradient(top, @start, @end);
				background: -ms-linear-gradient(@start, @end);
				background: -o-linear-gradient(@start, @end);
				background: linear-gradient(@start, @end);
				zoom: 1;
			}
			
			
			/*==============================================================*/
			/*                  RESET                                       */
			/*==============================================================*/

/* TEXT */

body,
body input, body select, body textarea{
	font-family:@font_body;
	color:@primary_text_color;
}

html .woocommerce ul.products li.product .heading-title {
	font-family:@font_body;
}

.custom_category_shortcode .wd_description,
ul.list-posts .post .short-content,
ul.list-posts .post .time,
ul.list-posts li .post-info-content,
#comments .commentlist li .detail .comment-meta a,
.related .time  {
	color:( @primary_text_color + #303030 );
}

ul.products li.product .price .from,
.woocommerce ul.products li.product .price .from,
.woocommerce-page ul.products li.product .price .from,
.checkout #payment ul.payment_methods li .payment_box,
.woocommerce .checkout #payment ul.payment_methods li .payment_box, 
.woocommerce-page .checkout #payment ul.payment_methods li .payment_box,
.product_meta .posted_in,
div.list_carousel .slider_control > a:after,
#footer .static_block_service .item .desc h3,
#respond span.label,
.static_block_service .item .desc h3,
.header_search #searchform #s,
body code   {
	color:@primary_text_color;
}

body.woocommerce nav.woocommerce-pagination ul li span.current,
body.woocommerce-page nav.woocommerce-pagination ul li span.current,
body.woocommerce #content nav.woocommerce-pagination ul li span.current,
body.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
body.woocommerce nav.woocommerce-pagination ul li a:hover,
body.woocommerce-page nav.woocommerce-pagination ul li a:hover,
body.woocommerce #content nav.woocommerce-pagination ul li a:hover,
body.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
body.woocommerce nav.woocommerce-pagination ul li a:focus,
body.woocommerce-page nav.woocommerce-pagination ul li a:focus,
body.woocommerce #content nav.woocommerce-pagination ul li a:focus,
body.woocommerce-page #content nav.woocommerce-pagination ul li a:focus {
	background-color:@primary_text_color;
	border-color:@primary_text_color;
}

/* LINK */

a,mark,
html .woocommerce div.product div.summary p.availability .wd_availability, 
html .woocommerce #content div.product div.summary p.availability .wd_availability, 
html .woocommerce-page div.product div.summary p.availability .wd_availability, 
html .woocommerce-page #content div.product div.summary p.availability .wd_availability,
html .woocommerce div.product div.summary p.wd_product_sku, 
html .woocommerce #content div.product div.summary p.wd_product_sku, 
html .woocommerce-page div.product div.summary p.wd_product_sku, 
html .woocommerce-page #content div.product div.summary p.wd_product_sku,
.woocommerce .social_sharing h6.title-social,
.woocommerce-page .social_sharing h6.title-social,
html .woocommerce .woocommerce-breadcrumb a, 
html .woocommerce-page .woocommerce-breadcrumb a,
html .woocommerce .woocommerce-breadcrumb, #crumbs,
html .woocommerce .woocommerce-breadcrumb .brn_arrow:after,#crumbs .brn_arrow:after,
.wd_tini_account_control a span,
.shopping-cart .cart_size a,
.woocommerce #content .order_details tfoot th, 
.woocommerce-page #content .order_details tfoot th,
#content table.my_account_orders td .amount,
.woocommerce #content table.my_account_orders td .amount, 
.woocommerce-page #content table.my_account_orders td .amount,
.shopping-cart .dropdown_footer .total strong,
.shopping-cart .cart_size,
#content .cart-collaterals .shipping_calculator .shipping-calculator-form p,
.woocommerce #content .cart-collaterals .shipping_calculator .shipping-calculator-form p,
.woocommerce-page #content .cart-collaterals .shipping_calculator .shipping-calculator-form p,
.cart-collaterals .cart_totals .cart_totals_wrapper tr th,
.woocommerce .cart-collaterals .cart_totals .cart_totals_wrapper tr th, 
.woocommerce-page .cart-collaterals .cart_totals .cart_totals_wrapper tr th,
.wpcf7,
.cart_totals span.amount,
ul#shipping_method li label, 
.woocommerce .shipping ul#shipping_method li label, 
.woocommerce-page .shipping ul#shipping_method li label,
#collapse-order-review .cart-subtotal span.amount,
#collapse-order-review .shipping span.amount {
	color:@primary_link_color
}

body.woocommerce nav.woocommerce-pagination ul li a.prev,
body.woocommerce-page nav.woocommerce-pagination ul li a.prev,
body.woocommerce #content nav.woocommerce-pagination ul li a.prev,
body.woocommerce nav.woocommerce-pagination ul li a.next,
body.woocommerce-page nav.woocommerce-pagination ul li a.next,
body.woocommerce #content nav.woocommerce-pagination ul li a.next,
.page_navi .wp-pagenavi a.next, 
.page_navi .wp-pagenavi a.prev, 
.page_navi .wp-pagenavi a.previouspostslink, 
.page_navi .wp-pagenavi a.nextpostslink,
.page_navi .wp-pagenavi a.previous {
	color:rgba(red(@primary_link_color), green(@primary_link_color), blue(@primary_link_color), 0.3);
}

body.woocommerce nav.woocommerce-pagination ul li a.prev:hover,
body.woocommerce-page nav.woocommerce-pagination ul li a.prev:hover,
body.woocommerce #content nav.woocommerce-pagination ul li a.prev:hover,
body.woocommerce nav.woocommerce-pagination ul li a.next:hover,
body.woocommerce-page nav.woocommerce-pagination ul li a.next:hover,
body.woocommerce #content nav.woocommerce-pagination ul li a.next:hover,
.page_navi .wp-pagenavi a.next:hover, 
.page_navi .wp-pagenavi a.prev:hover, 
.page_navi .wp-pagenavi a.previouspostslink:hover, 
.page_navi .wp-pagenavi a.nextpostslink:hover,
.page_navi .wp-pagenavi a.previous:hover,
.pp_description {
	color:@primary_link_color;
}

a:hover,
ul.products li.product a:hover,
html .woocommerce ul.products li.product a:hover,
html .woocommerce-page ul.products li.product a:hover, 
.custom_category_shortcode .wd_feature_title:hover,
.subscribe_widget .button:hover span, 
html .woocommerce .subscribe_widget .button:hover span, 
html .woocommerce-page .subscribe_widget .button:hover span,
html .woocommerce .woocommerce-breadcrumb a:hover, 
html .woocommerce-page .woocommerce-breadcrumb a:hover,
.cart_dropdown ul.cart_list li .wd_cart_title:hover,
.woocommerce .cart_dropdown ul.cart_list li .wd_cart_title:hover, 
.woocommerce-page .cart_dropdown ul.cart_list li .wd_cart_title:hover,
.cart_dropdown ul.product_list_widget li .wd_cart_title:hover, 
.woocommerce .cart_dropdown ul.product_list_widget li .wd_cart_title:hover, 
.woocommerce-page .cart_dropdown ul.product_list_widget li .wd_cart_title:hover,
.wd_tini_account_control a:hover,
.wd_tini_account_control a:hover span,
.shopping-cart .cart_size a:hover,
.shopping-cart .cart_size a:hover span,
.wd_tini_cart_control .cart_size:hover,
.cart_dropdown ul.product_list_widget li .wd_cart_title:hover, 
.woocommerce .cart_dropdown ul.product_list_widget li .wd_cart_title:hover, 
.woocommerce-page .cart_dropdown ul.product_list_widget li .wd_cart_title:hover,
ul.products li.product .heading-title.product-title a:hover,
html .woocommerce ul.products li.product .heading-title.product-title a:hover,
html .woocommerce-page ul.products li.product .heading-title.product-title a:hover,
.wd_hot_product .detail .title a:hover,
ul.archive-product-subcategories > li.product h3:hover,
.woocommerce ul.products li.product.product-category h3:hover, 
.woocommerce-page ul.products li.product.product-category h3:hover,
html .pp_woocommerce form.cart .button.product_type_simple:hover {
	color:@primary_link_color_hover;
}

/* HEADING */

h1,h2,h3,h4,h5,h6,
.widget-title,
.custom_category_shortcode .wd_feature_title,
.static_block_service .item .desc h3,
html .page div.product .product_title,
html .woocommerce div.product .product_title,
html.woocommerce #content div.product .product_title,
html .woocommerce-page div.product .product_title,
html.woocommerce-page #content div.product .product_title,
.single-content .post-title .heading-title,
.custom_category_shortcode .wd_feature_title,
#content .cart-collaterals .coupon_wrapper label, 
.woocommerce #content .cart-collaterals .coupon_wrapper label, 
.woocommerce-page #content .cart-collaterals .coupon_wrapper label,
#content .cart-collaterals .cart_totals h2, 
.woocommerce #content .cart-collaterals .cart_totals h2, 
.woocommerce-page #content .cart-collaterals .cart_totals h2,
h1.heading-title.page-title,
h1.site-title,
.heading_404 {
	font-family:@font_heading;
}

h1, h3, h4 {
	color:@primary_heading_color;
}

h2 {
	color:@secondary_heading_color;
}

h5 {
	color:@primary_text_color;
}

h6,
div.product #tab-tags .tag_heading,
ul.list-posts li .post-info-content .post-title .heading-title:hover {
	color:@secondary_heading_color;
}

.wd_heading h5,
.custom_category_shortcode .wd_feature_title,
.widget_multitab ul.nav-tabs li a, 
.widget_multitab ul.nav-tabs li a:hover,
#accordion-checkout-details label,
#accordion-review table.shop_table tfoot th,
.woocommerce #accordion-review table.shop_table tfoot th, 
.woocommerce-page #accordion-review table.shop_table tfoot th,
.checkout #payment ul.payment_methods li label,
.woocommerce .checkout #payment ul.payment_methods li label, 
.woocommerce-page .checkout #payment ul.payment_methods li label,
html .page div.product .product_title,
html .woocommerce div.product .product_title,
html.woocommerce #content div.product .product_title,
html .woocommerce-page div.product .product_title,
html.woocommerce-page #content div.product .product_title,
.related > .heading-title,
.related > .title,
.cart_dropdown ul.cart_list li .wd_cart_title,
.woocommerce .cart_dropdown ul.cart_list li .wd_cart_title, 
.woocommerce-page .cart_dropdown ul.cart_list li .wd_cart_title,
div.product .summary .short-description .short-description-title,
.return-shipping .title-quick h6,
body.woocommerce .upsells.products > .heading-title,
.customer_details dt,
.woocommerce #content .order_details thead th, 
.woocommerce-page #content .order_details thead th,
.order-detail-title, .custom-detail-title,
#content table.my_account_orders th,
.woocommerce #content table.my_account_orders th, 
.woocommerce-page #content table.my_account_orders th,
.my-address-title,
.recent-order-title,
#content .cart-collaterals .cart_totals h2 ,
.woocommerce #content .cart-collaterals .cart_totals h2 ,
.woocommerce-page #content .cart-collaterals .cart_totals h2,
#content .cart-collaterals .coupon_wrapper label,
.woocommerce #content .cart-collaterals .coupon_wrapper label,
.woocommerce-page #content .cart-collaterals .coupon_wrapper label,
.woocommerce #content .cart-collaterals .cross-sells h2, 
.woocommerce-page #content .cart-collaterals .cross-sells h2,
ul.list-posts li .post-info-content .post-title .heading-title,
#customer_login h2,
#content .cart-collaterals .shipping_calculator h2 a, 
.woocommerce #content .cart-collaterals .shipping_calculator h2 a, 
.woocommerce-page #content .cart-collaterals .shipping_calculator h2 a  {
	color:@primary_heading_color;
}

.cart_dropdown ul.product_list_widget li .wd_cart_title, 
.woocommerce .cart_dropdown ul.product_list_widget li .wd_cart_title, 
.woocommerce-page .cart_dropdown ul.product_list_widget li .wd_cart_title,
ul.products li.product .heading-title.product-title a,
html .woocommerce ul.products li.product .heading-title.product-title a,
html .woocommerce-page ul.products li.product .heading-title.product-title a,
.wd_hot_product .detail .title a {
	color:(@primary_heading_color + #101010);
}

/* BORDER COLOR */
.box-heading,
.wd_popular_product_wrapper,
.wd_popular_product_wrapper .wd_popular_product_wrapper_meta,
.custom_category_shortcode_style2,
.custom_category_shortcode_style2 .wd_heading,
.wd_product_category_list_shortcode,
.wd_product_category_list_shortcode .top_title,
.wd_hot_product,
.custom_category_shortcode_style2 .wd_heading:hover,
.widget_subscriptions,
.widget_social,
select,
textarea,
html input[type^="text"], 
html input[type^="email"],
html input[type^="password"],
.wd_meta_loop,
#container .gridlist-toggle a#grid,
#container .gridlist-toggle a,
body.woocommerce nav.woocommerce-pagination,
body.woocommerce-page nav.woocommerce-pagination,
body.woocommerce #content nav.woocommerce-pagination,
body.woocommerce-page #content nav.woocommerce-pagination,
body.woocommerce nav.woocommerce-pagination ul li a.prev,
body.woocommerce-page nav.woocommerce-pagination ul li a.prev,
body.woocommerce #content nav.woocommerce-pagination ul li a.prev,
body.woocommerce nav.woocommerce-pagination ul li a.next,
body.woocommerce-page nav.woocommerce-pagination ul li a.next,
body.woocommerce #content nav.woocommerce-pagination ul li a.next,
body.woocommerce nav.woocommerce-pagination ul li a,
body.woocommerce-page nav.woocommerce-pagination ul li a,
body.woocommerce #content nav.woocommerce-pagination ul li a,
body.woocommerce-page #content nav.woocommerce-pagination ul li a,
body.woocommerce nav.woocommerce-pagination ul li span,
body.woocommerce-page nav.woocommerce-pagination ul li span,
body.woocommerce #content nav.woocommerce-pagination ul li span,
body.woocommerce-page #content nav.woocommerce-pagination ul li span,
.widget_multitab .tab-content ul li,
body .checkout .accordion-inner,
.checkout #payment ul.payment_methods li .payment_box,
.woocommerce .checkout #payment ul.payment_methods li .payment_box, 
.woocommerce-page .checkout #payment ul.payment_methods li .payment_box,
.checkout #payment ul.payment_methods,
.woocommerce .checkout #payment ul.payment_methods, 
.woocommerce-page .checkout #payment ul.payment_methods,
#accordion-review  table.shop_table td,
.woocommerce #accordion-review  table.shop_table td, 
.woocommerce-page #accordion-review  table.shop_table td,
#accordion-review table.shop_table thead th,
.woocommerce #accordion-review table.shop_table thead th, 
.woocommerce-page #accordion-review table.shop_table thead th,
body .checkout .accordion-heading a.accordion-toggle,
body #accordion-checkout-details .accordion-heading a.accordion-toggle,
body .checkout .accordion-heading a.accordion-toggle.collapsed:hover,
body #accordion-checkout-details .accordion-heading a.accordion-toggle.collapsed:hover,
.quantity .minus,
body.woocommerce .quantity .minus,
body.woocommerce-page .quantity .minus,
body.woocommerce #content .quantity .minus,
body.woocommerce-page #content .quantity .minus,
body.page .quantity .minus,
.quantity .plus,
body.woocommerce .quantity .plus,
body.woocommerce-page .quantity .plus,
body.woocommerce #content .quantity .plus,
body.woocommerce-page #content .quantity .plus,
body.page .quantity .plus,
.quantity input.qty,
body.woocommerce .quantity input.qty,
body.woocommerce-page .quantity input.qty,
body.woocommerce #content .quantity input.qty,
body.woocommerce-page #content .quantity input.qty,
.quantity input.qty,
.product_meta,
.related > .heading-title,
.related > .title,
.related,
.shopping-cart .cart_dropdown,
.cart_list.product_list_widget .remove,
.div.product .summary .short-description,
body.woocommerce .upsells.products > .heading-title,
body.woocommerce .upsells.products,
#content table.shop_table.cart,
.woocommerce #content table.shop_table.cart, 
.woocommerce-page #content table.shop_table.cart,
#content table.shop_table.cart thead th,
html .woocommerce #content table.shop_table.cart thead th, 
html .woocommerce-page #content table.shop_table.cart thead th,
#content table.shop_table.cart tbody tr.cart_table_item td,
.woocommerce #content table.shop_table.cart tbody tr.cart_table_item td, 
.woocommerce-page #content table.shop_table.cart tbody tr.cart_table_item td,
table.cart a.remove,
html .woocommerce table.cart a.remove, 
html .woocommerce-page table.cart a.remove, 
#content table.cart a.remove,
html .woocommerce #content table.cart a.remove, 
html .woocommerce-page #content table.cart a.remove,
 #content .cart-collaterals form > div,
.woocommerce #content .cart-collaterals form > div,
.woocommerce-page #content .cart-collaterals form > div,
#content .cart-collaterals .cart_totals > div,
.woocommerce #content .cart-collaterals .cart_totals > div,
.woocommerce-page #content .cart-collaterals .cart_totals > div,
#content .cart-collaterals .cart_totals > div, 
.woocommerce #content .cart-collaterals .cart_totals > div, 
.woocommerce-page #content .cart-collaterals .cart_totals > div,
#content .cart-collaterals .coupon_wrapper input#coupon_code,
.woocommerce #content .cart-collaterals .coupon_wrapper input#coupon_code,
.woocommerce-page #content .cart-collaterals .coupon_wrapper input#coupon_code,
.woocommerce #content .order_details, 
.woocommerce-page #content .order_details,
.woocommerce #content .order_details thead th, 
.woocommerce-page #content .order_details thead th,
.woocommerce #content .order_details tfoot th, 
.woocommerce-page #content .order_details tfoot th,
.woocommerce #content .order_details tbody td, 
.woocommerce-page #content .order_details tbody td,
.woocommerce #content .order_details tfoot td, 
.woocommerce-page #content .order_details tfoot td,
#content table.my_account_orders,
.woocommerce #content table.my_account_orders, 
.woocommerce-page #content table.my_account_orders,
#content table.my_account_orders th,
.woocommerce #content table.my_account_orders th, 
.woocommerce-page #content table.my_account_orders th ,
#content table.my_account_orders td,
.woocommerce #content table.my_account_orders td, 
.woocommerce-page #content table.my_account_orders td,
.shopping-cart .dropdown_footer,
#content .cart-collaterals .shipping_calculator h2,
.woocommerce #content .cart-collaterals .shipping_calculator h2,
.woocommerce-page #content .cart-collaterals .shipping_calculator h2,
#content .cart-collaterals .cart_totals h2 ,
.woocommerce #content .cart-collaterals .cart_totals h2 ,
.woocommerce-page #content .cart-collaterals .cart_totals h2,
.woocommerce #content .cart-collaterals .cross-sells h2, 
.woocommerce-page #content .cart-collaterals .cross-sells h2,
.woocommerce #content .cart-collaterals .cross-sells ul.products, 
.woocommerce-page #content .cart-collaterals .cross-sells ul.products,
.featured_product_slider_content,
div.list_carousel .slider_control > a,
body.woocommerce ul.products.list li.product,
body.woocommerce-page ul.products.list li.product,
.woocommerce .social_sharing  ,
.woocommerce-page .social_sharing,#content .cart-collaterals .cross-sells .cross_wrapper,
.woocommerce #content .cart-collaterals .cross-sells .cross_wrapper, 
.woocommerce-page #content .cart-collaterals .cross-sells .cross_wrapper,
h1.author-title.site-title,
html div.pp_woocommerce .pp_previous:before, 
html div.pp_woocommerce .pp_next:before,
html div.pp_woocommerce .pp_arrow_previous, 
html div.pp_woocommerce .pp_arrow_next,
.page-template-page-templatesblog-template-php .page-content,
ul.list-posts li,
.nav-content,
.page_navi .wp-pagenavi a,
.page_navi .wp-pagenavi span,
.static_block_service,
#respond #reply-title,
#respond,
#comments .commentlist,
#comments #comments-title,
.single-content .post-info-meta > .short-content,
#accordion-review  table.shop_table td.product-name a.remove,
.woocommerce #accordion-review  table.shop_table td.product-name a.remove, 
.woocommerce-page #accordion-review  table.shop_table td.product-name a.remove,
body code,
.after_checkout_form,
.quantity input.qty:hover,
body.woocommerce .quantity input.qty:hover,
body.woocommerce-page .quantity input.qty:hover,
body.woocommerce #content .quantity input.qty:hover,
body.woocommerce-page #content .quantity input.qty:hover,
html .select2-drop,
body #header .header-bottom-content .main-menu > ul.menu > li .one_half, 
body #header .header-bottom-content .main-menu > ul.menu > li .one_third, 
body #header .header-bottom-content .main-menu > ul.menu > li .two_third, 
body #header .header-bottom-content .main-menu > ul.menu > li .one_fourth, 
body #header .header-bottom-content .main-menu > ul.menu > li .three_fourth, 
body #header .header-bottom-content .main-menu > ul.menu > li .one_fifth, 
body #header .header-bottom-content .main-menu > ul.menu > li .two_fifth, 
body #header .header-bottom-content .main-menu > ul.menu > li .three_fifth, 
body #header .header-bottom-content .main-menu > ul.menu > li .four_fifth, 
body #header .header-bottom-content .main-menu > ul.menu > li .one_sixth, 
body #header .header-bottom-content .main-menu > ul.menu > li .three_sixth, 
body #header .header-bottom-content .main-menu > ul.menu > li .one_sixth, 
body #header .header-bottom-content .main-menu > ul.menu > li .five_sixth,
.woocommerce table.shop_attributes td, 
.woocommerce-page table.shop_attributes td,
.woocommerce table.shop_attributes th, 
.woocommerce-page table.shop_attributes th {
	border-color:@primary_border_color;
}

body.woocommerce nav.woocommerce-pagination ul li a.prev,
body.woocommerce-page nav.woocommerce-pagination ul li a.prev,
body.woocommerce #content nav.woocommerce-pagination ul li a.prev,
body.woocommerce nav.woocommerce-pagination ul li a.next,
body.woocommerce-page nav.woocommerce-pagination ul li a.next,
body.woocommerce #content nav.woocommerce-pagination ul li a.next,
.page_navi .wp-pagenavi a.next, 
.page_navi .wp-pagenavi a.prev, 
.page_navi .wp-pagenavi a.previouspostslink, 
.page_navi .wp-pagenavi a.nextpostslink,
.page_navi .wp-pagenavi a.previous {
	border-color:rgba(red(@primary_border_color),green(@primary_border_color),blue(@primary_border_color),0.3);
}

body.woocommerce nav.woocommerce-pagination ul li a.prev:hover,
body.woocommerce-page nav.woocommerce-pagination ul li a.prev:hover,
body.woocommerce #content nav.woocommerce-pagination ul li a.prev:hover,
body.woocommerce nav.woocommerce-pagination ul li a.next:hover,
body.woocommerce-page nav.woocommerce-pagination ul li a.next:hover,
body.woocommerce #content nav.woocommerce-pagination ul li a.next:hover,
.page_navi .wp-pagenavi a.next:hover, 
.page_navi .wp-pagenavi a.prev:hover, 
.page_navi .wp-pagenavi a.previouspostslink:hover, 
.page_navi .wp-pagenavi a.nextpostslink:hover,
.page_navi .wp-pagenavi a.previous:hover {
	border-color:@primary_border_color;
	background:#fff;
}

#content .cart-collaterals .coupon_wrapper label:after,
.woocommerce #content .cart-collaterals .coupon_wrapper label:after,
.woocommerce-page #content .cart-collaterals .coupon_wrapper label:after,
div.list_carousel .slider_control > a:hover,
#collapse-login-regis .accordion-inner > div:after,
.static_block_service .item .desc:after,
#comments .commentlist li .detail .comment-author:after,
.single-content .post-info-meta > .time:after,
.single-content .post-info-meta > .author:after,
ul.list-posts .post .author:after,
ul.list-posts .portfolio .author:after,
.lost_reset_password > p:first-child,
body.woocommerce ul.products.list li.product:after,
body.woocommerce-page ul.products.list li.product:after {
	background:@primary_border_color;
}

div.product .summary .short-description {
	border-color:(@primary_border_color + #050505);
}

@media 
only screen and (max-width-device-width: 1024px),
only screen and (max-width: 1024px){ 
	div.product form.cart table.group_table,
	html .woocommerce div.product form.cart table.group_table, 
	html .woocommerce #content div.product form.cart table.group_table, 
	html .woocommerce-page div.product form.cart table.group_table, 
	html .woocommerce-page #content div.product form.cart table.group_table,
	html .page div.product form.cart table.group_table {
		border-color:@primary_border_color;
	}
}

html input[type^="text"]:hover, 
html input[type^="email"]:hover,
html input[type^="password"]:hover,
textarea:hover,
textarea:focus{
	border-color:@primary_border_color_hover;
	box-shadow:0 0 3px rgba(red(@primary_border_color_hover), green(@primary_border_color_hover), blue(@primary_border_color_hover), 0.2);
	-moz-box-shadow:0 0 3px rgba(red(@primary_border_color_hover), green(@primary_border_color_hover), blue(@primary_border_color_hover), 0.2);
	-webkit-box-shadow:0 0 3px rgba(red(@primary_border_color_hover), green(@primary_border_color_hover), blue(@primary_border_color_hover), 0.2);
}

.wd_heading:after {
	background-color:@primary_border_color;
}

.custom_category_shortcode .wd_description,
ul.products li.product .wd_related {
	border-color:(@primary_border_color + #1d1d1d);
}

body .checkout .accordion-heading a.accordion-toggle.collapsed,
body #accordion-checkout-details .accordion-heading a.accordion-toggle.collapsed {
	background:(@primary_border_color + #1b1b1b);
	border-color:(@primary_border_color + #1b1b1b);
}

#accordion-review table.shop_table thead th,
.woocommerce #accordion-review table.shop_table thead th, 
.woocommerce-page #accordion-review table.shop_table thead th {
	background:(@primary_border_color + #2a2a2a);
}

@media 
only screen and (max-width-device-width: 1024px) and (min-width-device-width: 768px),
only screen and (max-width: 1024px) and (min-width: 768px) {
	#content #container-main.span18 table.shop_table.cart tbody tr.cart_table_item td.product-quantity input.qty , 
	.woocommerce #content #container-main table.shop_table.cart tbody tr.cart_table_item td.product-quantity input.qty , 
	.woocommerce-page #content #container-main table.shop_table.cart tbody tr.cart_table_item .quantity input.qty{
		border-color:@primary_border_color;
	}
}

@media 
only screen and (max-width-device-width: 360px),
only screen and (max-width: 360px) {
	html .woocommerce div.product form.cart table div.quantity input.qty, 
	html .woocommerce #content div.product form.cart table div.quantity input.qty, 
	html .woocommerce-page div.product form.cart table div.quantity input.qty, 
	html .woocommerce-page #content div.product form.cart table div.quantity input.qty, 
	html .page div.product form.cart table div.quantity input.qty {
		border-right-color:@primary_border_color;
	}
}

@media 
only screen and (max-width-device-width: 360px),
only screen and (max-width: 360px) {
	#content table.my_account_orders td.order-number, 
	.woocommerce #content table.my_account_orders td.order-number, 
	.woocommerce-page #content table.my_account_orders td.order-number {
		border-color:@primary_border_color;
	}
}

/* TAB */
.tabs-default[id^="multitabs"],
.tabs-default.style1 > ul li.active,
.tabbable.style1 ul li.active.last,
[id^=multitabs].tabs-default > ul,
.tabbable ul li.active,
.tabbable.tabs-right,
.tabbable.tabs-right .nav-tabs li a,
.tabbable.tabs-right .nav-tabs li:hover > a
.tabbable.tabs-left,
.tabbable.tabs-left .nav-tabs li a,
.tabbable.tabs-left .nav-tabs li:hover > a,
.tabbable.tabs-left {
	border-color:@primary_tab_border_color;
}

.tabbable.tabs-left .nav-tabs:after,
.tabbable.tabs-right .nav-tabs:after {
	background:@primary_tab_border_color;
}

.tabbable ul li.active:after, 
.tabbable ul li.active:hover:after {
	.gradient(@primary_tab_active_gradient_start_color, @primary_tab_active_gradient_end_color);
}

.tabs-default[id^="multitabs"] .nav-tabs li a,
.tabbable.tabs-left .nav-tabs li a,
.tabbable.tabs-right .nav-tabs li a {
	color:@primary_tab_text_color;
}

.tabs-default[id^="multitabs"] .nav-tabs li a:hover,
.tabbable.tabs-left .nav-tabs li a:hover, 
.tabbable.tabs-right .nav-tabs li a:hover {
	color:@primary_tab_hover_text_color;
}

.tabs-default[id^="multitabs"] .nav-tabs li.active a,
.tabs-default.style1 > ul li.active:first-child a,
.tabbable.tabs-left .nav-tabs li.active a,
.tabbable.tabs-left .nav-tabs li.active a {
	color:@primary_tab_active_text_color;
}

@media 
only screen and (max-width-device-width: 360px),
only screen and (max-width: 360px) {
	.tabbable ul.nav-tabs li {
		border-color:@primary_tab_border_color;
	}
}

/* COLOR */
.fa,
.wd_tini_account_control a span:before,
.shopping-cart:before,
.header_search #searchform > div.wd_search_form:after,
.subscribe_widget .button span,
html .woocommerce .subscribe_widget .button span,
html .woocommerce-page .subscribe_widget .button span{
	color:@primary_icon_color;
}

.fa:hover {
	color:@primary_color;
}

/* PRIMARY BUTTON */
button.button, 
a.button, 
input[type^="submit"], 
html .woocommerce a.button, 
html .woocommerce button.button, 
html .woocommerce input.button, 
html .woocommerce #respond input#submit, 
.woocommerce #content input.button, 
html .woocommerce-page a.button, 
html .woocommerce-page button.button, 
.woocommerce-page input.button, 
html .woocommerce-page #respond input#submit, 
html .woocommerce-page #content input.button, 
html .woocommerce-page #content input.button, 
html .woocommerce #content table.cart input.button, 
html input.button,
.wd_popular_product_wrapper .wd_readmore a,
.featured_product_slider_wrapper .slider_control a,
ul.products.grid li.product .product-meta-wrapper .list_add_to_cart a.button,
.woocommerce ul.products.grid li.product .product-meta-wrapper .list_add_to_cart a.button,
.woocommerce-page ul.products.grid li.product .product-meta-wrapper .list_add_to_cart a.button,
ul.products.list li.product .product-meta-wrapper .list_add_to_cart a.button,
.woocommerce ul.products.list li.product .product-meta-wrapper .list_add_to_cart a.button,
.woocommerce-page ul.products.list li.product .product-meta-wrapper .list_add_to_cart a.button,
#left-sidebar .subscribe_widget .button,
html .woocommerce #left-sidebar .subscribe_widget .button,
html .woocommerce-page #left-sidebar .subscribe_widget .button,
#right-sidebar .subscribe_widget .button,
html .woocommerce #right-sidebar .subscribe_widget .button,
html .woocommerce-page #right-sidebar .subscribe_widget .button,
.single_add_to_cart_button.button,
html .woocommerce .single_add_to_cart_button.button,
html .woocommerce .single_add_to_cart_button.button,
html .woocommerce .single_add_to_cart_button.button.alt,
html .woocommerce .single_add_to_cart_button.button.alt,
html .page .single_add_to_cart_button.button,
#left-sidebar button.button, 
#left-sidebar a.button, 
#left-sidebar input[type^="submit"],
#right-sidebar button.button, 
#right-sidebar a.button, 
#right-sidebar input[type^="submit"],
.shopping-cart .dropdown_footer .buttons a,
.group_table a.button.alt,
.woocommerce .group_table a.button.alt,
.woocommerce-page .group_table a.button.alt,
#content .group_table a.button.alt,
#content .woocommerce .group_table a.button.alt,
.woocommerce-page #content .group_table a.button.alt,
.single-content .post-title .navi-prev a,
.single-content .post-title .navi-next a   {
	.gradient(@primary_button_gradient_start_color, @primary_button_gradient_end_color);
	border-color:@primary_button_border_color;
	color:@primary_button_text_color;
}

button.button:hover, 
a.button:hover, 
input[type^="submit"]:hover, 
html .woocommerce a.button:hover, 
html .woocommerce button.button:hover, 
html .woocommerce input.button:hover, 
html .woocommerce #respond input#submit:hover, 
.woocommerce #content input.button:hover, 
html .woocommerce-page a.button:hover, 
html .woocommerce-page button.button:hover, 
.woocommerce-page input.button:hover, 
html .woocommerce-page #respond input#submit:hover, 
html .woocommerce-page #content input.button:hover, 
html .woocommerce-page #content input.button:hover, 
html .woocommerce #content table.cart input.button:hover, 
html input.button:hover,
.wd_popular_product_wrapper .wd_readmore a:hover,
.featured_product_slider_wrapper .slider_control a:hover,
ul.products.grid li.product .product-meta-wrapper .list_add_to_cart a.button:hover,
.woocommerce ul.products.grid li.product .product-meta-wrapper .list_add_to_cart a.button:hover,
.woocommerce-page ul.products.grid li.product .product-meta-wrapper .list_add_to_cart a.button:hover,
ul.products.list li.product .product-meta-wrapper .list_add_to_cart a.button:hover,
.woocommerce ul.products.list li.product .product-meta-wrapper .list_add_to_cart a.button:hover,
.woocommerce-page ul.products.list li.product .product-meta-wrapper .list_add_to_cart a.button:hover,
#left-sidebar .subscribe_widget .button:hover,
html .woocommerce #left-sidebar .subscribe_widget .button:hover,
html .woocommerce-page #left-sidebar .subscribe_widget .button:hover,
#right-sidebar .subscribe_widget .button:hover,
html .woocommerce #right-sidebar .subscribe_widget .button:hover,
html .woocommerce-page #right-sidebar .subscribe_widget .button:hover,
.single_add_to_cart_button.button:hover,
html .woocommerce .single_add_to_cart_button.button:hover,
html .woocommerce .single_add_to_cart_button.button:hover,
html .woocommerce .single_add_to_cart_button.button.alt:hover,
html .woocommerce .single_add_to_cart_button.button.alt:hover,
html .page .single_add_to_cart_button.button:hover,
#left-sidebar button.button:hover, 
#left-sidebar a.button:hover, 
#left-sidebar input[type^="submit"]:hover,
#right-sidebar button.button:hover, 
#right-sidebar a.button:hover, 
#right-sidebar input[type^="submit"]:hover,
.shopping-cart .dropdown_footer .buttons a:hover,
.group_table a.button.alt:hover,
.woocommerce .group_table a.button.alt:hover,
.woocommerce-page .group_table a.button.alt:hover,
#content .group_table a.button.alt:hover,
#content .woocommerce .group_table a.button.alt:hover,
.woocommerce-page #content .group_table a.button.alt:hover,
.single-content .post-title .navi-prev a:hover,
.single-content .post-title .navi-next a:hover {
	.gradient(@primary_button_hover_gradient_start_color, @primary_button_hover_gradient_end_color);
	border-color:@primary_button_hover_border_color;
	color:@primary_button_hover_text_color;
}

.custom_category_shortcode_grid .wd_readmore a:hover {
	.gradient(@primary_button_gradient_end_color, @primary_button_gradient_start_color);
	border-color:@primary_button_border_color;
	color:@primary_button_text_color;
}

.custom_category_shortcode_grid .wd_readmore a {
	.gradient(@primary_button_hover_gradient_end_color, @primary_button_hover_gradient_start_color);
	border-color:@primary_button_hover_border_color;
	color:@primary_button_hover_text_color;
}

.wd_hot_control a,
.custom_category_shortcode .wd_slider_control a,
.wd_product_category_list_shortcode .wd_slider_control a,
.related .wd_single_related_control a,
.related .flex-direction-nav a,
.upsells .upsell_control a,
.cross-sells .cross_control a {
	.gradient_2(@primary_button_gradient_start_color, @primary_button_gradient_end_color);
	border-color:@primary_button_border_color;
	color:@primary_button_text_color;
}

.wd_hot_control a:hover,
.custom_category_shortcode .wd_slider_control a:hover,
.wd_product_category_list_shortcode .wd_slider_control a:hover,
.related .wd_single_related_control a.prev:hover,
.related .wd_single_related_control a.next:hover,
.related .flex-direction-nav a:hover,
.upsells .upsell_control a:hover,
.cross-sells .cross_control a:hover  {
	.gradient_2(@primary_button_hover_gradient_start_color, @primary_button_hover_gradient_end_color);
	border-color:@primary_button_hover_border_color;
	color:@primary_button_hover_text_color;
}

#left-sidebar .subscribe_widget .button span,
html .woocommerce #left-sidebar .subscribe_widget .button span,
html .woocommerce-page #left-sidebar .subscribe_widget .button span,
#right-sidebar .subscribe_widget .button span,
html .woocommerce #right-sidebar .subscribe_widget .button span,
html .woocommerce-page #right-sidebar .subscribe_widget .button span {
	color:@primary_button_text_color
}

#left-sidebar .subscribe_widget:hover .button span,
html .woocommerce #left-sidebar .subscribe_widget:hover .button span,
html .woocommerce-page #left-sidebar .subscribe_widget:hover .button span,
#right-sidebar .subscribe_widget:hover .button span,
html .woocommerce #right-sidebar .subscribe_widget:hover .button span,
html .woocommerce-page #right-sidebar .subscribe_widget:hover .button span {
	color:@primary_button_hover_text_color;
}

/* SECONDARY BUTTON */
.shopping-cart .dropdown_footer .buttons a.checkout,
#content .cart-collaterals form .checkout-button-visible, 
.woocommerce #content .cart-collaterals form .checkout-button-visible, 
.woocommerce-page #content .cart-collaterals form .checkout-button-visible,
#content .cart-collaterals .cart_totals .checkout-button-visible, 
.woocommerce #content .cart-collaterals .cart_totals .checkout-button-visible, 
.woocommerce-page #content .cart-collaterals .cart_totals .checkout-button-visible,
.wd_tini_account_wrapper .form_wrapper_footer .button,
.checkout #payment #place_order.button,
.woocommerce .checkout #payment #place_order.button, 
.woocommerce-page .checkout #payment #place_order.button,
html #content .widget_shopping_cart a.button.checkout,
html #wd_product_content .widget_shopping_cart a.button.checkout,
.woocommerce #payment #place_order, 
.woocommerce-page #payment #place_order {
	color:@secondary_button_text_color;
	.gradient(@secondary_button_gradient_start_color, @secondary_button_gradient_end_color);
	border-color:@secondary_button_border_color;
	border-bottom-color:(@secondary_button_border_color - #2f201e);;
}
.shopping-cart .dropdown_footer .buttons a.checkout:before,
#content .cart-collaterals form .checkout-button-visible:after, 
.woocommerce #content .cart-collaterals form .checkout-button-visible:after, 
.woocommerce-page #content .cart-collaterals form .checkout-button-visible:after,
#content .cart-collaterals .cart_totals .checkout-button-visible:after, 
.woocommerce #content .cart-collaterals .cart_totals .checkout-button-visible:after, 
.woocommerce-page #content .cart-collaterals .cart_totals .checkout-button-visible:after,
.wd_tini_account_wrapper .form_wrapper_footer .button:before,
.checkout #payment #place_order.button:before,
.woocommerce .checkout #payment #place_order.button:before, 
.woocommerce-page .checkout #payment #place_order.button:before,
html #content .widget_shopping_cart a.button.checkout:after,
html #wd_product_content .widget_shopping_cart a.button.checkout:after,
.woocommerce #payment #place_order:before, 
.woocommerce-page #payment #place_order:before {
	background:(@secondary_button_gradient_start_color + #0d3740);
}

.checkout #payment #place_order.button,
.woocommerce .checkout #payment #place_order.button, 
.woocommerce-page .checkout #payment #place_order.button,
.woocommerce #payment #place_order, 
.woocommerce-page #payment #place_order {
	box-shadow:0 1px 0 (@secondary_button_gradient_start_color + #0d3740) inset;
}

.shopping-cart .dropdown_footer .buttons a.checkout:hover,
#content .cart-collaterals form .checkout-button-visible:hover, 
.woocommerce #content .cart-collaterals form .checkout-button-visible:hover, 
.woocommerce-page #content .cart-collaterals form .checkout-button-visible:hover,
#content .cart-collaterals .cart_totals .checkout-button-visible:hover, 
.woocommerce #content .cart-collaterals .cart_totals .checkout-button-visible:hover, 
.woocommerce-page #content .cart-collaterals .cart_totals .checkout-button-visible:hover,
.wd_tini_account_wrapper .form_wrapper_footer .button:hover,
.checkout #payment #place_order.button:hover,
.woocommerce .checkout #payment #place_order.button:hover, 
.woocommerce-page .checkout #payment #place_order.button:hover,
html #content .widget_shopping_cart a.button.checkout:hover,
html #wd_product_content .widget_shopping_cart a.button.checkout:hover,
.woocommerce #payment #place_order:hover, 
.woocommerce-page #payment #place_order:hover {
	color:@sedondary_button_hover_text_color;
	.gradient(@secondary_button_hover_gradient_start_color, @secondary_button_hover_gradient_end_color);
	border-color:@secondary_button_hover_border_color;	
}
.shopping-cart .dropdown_footer .buttons a.checkout:hover:before,
#content .cart-collaterals form .checkout-button-visible:hover:after, 
.woocommerce #content .cart-collaterals form .checkout-button-visible:hover:after, 
.woocommerce-page #content .cart-collaterals form .checkout-button-visible:hover:after,
#content .cart-collaterals .cart_totals .checkout-button-visible:hover:after, 
.woocommerce #content .cart-collaterals .cart_totals .checkout-button-visible:hover:after, 
.woocommerce-page #content .cart-collaterals .cart_totals .checkout-button-visible:hover:after,
.wd_tini_account_wrapper .form_wrapper_footer .button:hover:after {
	background:(@secondary_button_hover_gradient_start_color + #0d3740);
}

/* TERTIARY BUTTON */
#content input.button.button_shipping_address_continue,
html .woocommerce #content input.button.button_shipping_address_continue,
html .woocommerce-page #content input.button.button_shipping_address_continue,
html .woocommerce #content input.button.button_review_order_continue,
html .woocommerce-page #content input.button.button_review_order_continue,
#content .cart-collaterals input.button,
.woocommerce #content .cart-collaterals input.button,
.woocommerce-page #content .cart-collaterals input.button,
#content .cart-collaterals .shipping_calculator .shipping-calculator-form button,
.woocommerce #content .cart-collaterals .shipping_calculator .shipping-calculator-form button,
.woocommerce-page #content .cart-collaterals .shipping_calculator .shipping-calculator-form  button,
.wpcf7 input[type^="submit"],
html #content .woocommerce .widget_price_filter .price_slider_amount .button, 
html .woocommerce-page #content .widget_price_filter .price_slider_amount .button,
#comments .commentlist li .detail .reply a,
#reviews .add_review a.button,
#respond button.button span span,
.pp_woocommerce #respond #commentform input#submit,
html .pp_woocommerce #respond #commentform input#submit,
html #content #customer_login input.button,
html #content #customer_login .woocommerce input.button,
html #content .woocommerce-page #customer_login input.button,
html #content .lost_reset_password input.button,
html #content .woocommerce .lost_reset_password input.button,
html #content .woocommerce-page .lost_reset_password input.button,
html #collapse-login-regis input.button,
html body .woocommerce #collapse-login-regis input.button,
html body.woocommerce-page #collapse-login-regis input.button,
html #collapse-createaccount input.button,
html body .woocommerce #collapse-createaccount input.button,
html body.woocommerce-page #collapse-createaccount input.button,
html #content.after_checkout_form .checkout_coupon .form-row input.button,
html .woocommerce #content .after_checkout_form form.checkout_coupon .form-row input.button, 
html .woocommerce-page #content .after_checkout_form form.checkout_coupon .form-row input.button {
	background:@tertiary_button_background_color;
	color:@tertiary_button_text_color;
	border-color:@tertiary_button_border_color;
	border-width:1px;
	font-weight:bold;
	filter:none;
}

#content input.button.button_shipping_address_continue:hover,
html .woocommerce #content input.button.button_shipping_address_continue:hover,
html .woocommerce-page #content input.button.button_shipping_address_continue:hover,
html .woocommerce #content input.button.button_review_order_continue:hover,
html .woocommerce-page #content input.button.button_review_order_continue:hover,
#content .cart-collaterals input.button:hover,
.woocommerce #content .cart-collaterals input.button:hover,
.woocommerce-page #content .cart-collaterals input.button:hover,
#content .cart-collaterals .shipping_calculator .shipping-calculator-form button:hover,
.woocommerce #content .cart-collaterals .shipping_calculator .shipping-calculator-form button:hover,
.woocommerce-page #content .cart-collaterals .shipping_calculator .shipping-calculator-form  button:hover,
.wpcf7 input[type^="submit"]:hover,
html #content .woocommerce .widget_price_filter .price_slider_amount .button:hover, 
html .woocommerce-page #content .widget_price_filter .price_slider_amount .button:hover,
#reviews .add_review a.button:hover,
#respond button.button span span:hover,
#comments .commentlist li .detail .reply a:hover,
#respond button.button:hover span span,
.pp_woocommerce #respond #commentform input#submit:hover,
html .pp_woocommerce #respond #commentform input#submit:hover,
html #content #customer_login input.button:hover,
html #content #customer_login .woocommerce input.button:hover,
html #content .woocommerce-page #customer_login input.button:hover,
html #content .lost_reset_password input.button:hover,
html #content .woocommerce .lost_reset_password input.button:hover,
html #content .woocommerce-page .lost_reset_password input.button:hover,
html #collapse-login-regis input.button:hover,
html body .woocommerce #collapse-login-regis input.button:hover,
html body.woocommerce-page #collapse-login-regis input.button:hover,
html #collapse-createaccount input.button:hover,
html body .woocommerce #collapse-createaccount input.button:hover,
html body.woocommerce-page #collapse-createaccount input.button:hover,
html #content .after_checkout_form .checkout_coupon .form-row input.button:hover,
html .woocommerce #content .after_checkout_form form.checkout_coupon .form-row input.button:hover, 
html .woocommerce-page #content .after_checkout_form form.checkout_coupon .form-row input.button:hover {
	background:@tertiary_button_hover_background_color;
	color:@tertiary_button_hover_text_color;
	border-color:@tertiary_button_hover_border_color;
	filter:none;
}

/* ACCORDION */
body .accordion-heading,
body .accordion-inner  {
	border-color:@primary_accordion_border_color;
}

body .accordion-heading a.accordion-toggle {
	color:@primary_accordion_text_color;
}

body .accordion-heading a.accordion-toggle {
	.gradient_1(@primary_accordion_gradient_start_color, @primary_accordion_gradient_end_color);
}

body .accordion-heading a.accordion-toggle:hover {
	.gradient_1(@primary_accordion_hover_gradient_start_color, @primary_accordion_hover_gradient_end_color);
}


/*==============================================================*/
/*             PRIMARY - SECONDARY - TERTIARY                   */
/*==============================================================*/

/* PRIMARY */
#wp-calendar #today,
.wd_meet_team .info p.role {
	color:@secondary_color;
}

#feedback a.feedback-button,
#em_quickshop_handler,
ul.products li.product .product_thumbnail_wrapper .list_add_to_cart a,
.woocommerce ul.products li.product .product_thumbnail_wrapper .list_add_to_cart a,
.woocommerce-page ul.products li.product .product_thumbnail_wrapper .list_add_to_cart a,
#wp-calendar thead tr th, 
#to-top a,
html div.pp_woocommerce .pp_previous:hover:before, 
html div.pp_woocommerce .pp_next:hover:before,
html div.pp_woocommerce .pp_close,
.wd_feedback .pp_close,
div.pp_woocommerce.wd_feedback .pp_close {
	background-color:@primary_color;
}

html div.pp_woocommerce .pp_previous:hover:before, 
html div.pp_woocommerce .pp_next:hover:before {
	border-color:@primary_color;
}

.cart_list.product_list_widget .remove:hover,
table.cart a.remove:hover,
html .woocommerce table.cart a.remove:hover, 
html .woocommerce-page table.cart a.remove:hover, 
#content table.cart a.remove:hover,
html .woocommerce #content table.cart a.remove:hover, 
html .woocommerce-page #content table.cart a.remove:hover {
	border-color:@primary_color;
}

/* SECONDARY */
.vertical-menu > .menu li.parent:after,
.header_search .select2-container .select2-choice div b:before,
#footer .box-heading .read-more:after,
.wd_popular_product_wrapper .wd_readmore a:after,
.custom_category_shortcode_grid .wd_readmore a:after,
.widget_title_wrapper .block-control:after,
.wd_tini_account_control a span:after,
.shopping-cart:after,
#footer .box-heading .read-more:hover,
html .woocommerce .star-rating span, 
html .woocommerce-page .star-rating span,
.woocommerce p.stars a[class^="star"].active,
.wd_quickshop .details_view a:after
 {
	color:@secondary_color;
}

#to-top a:hover,
#feedback a.feedback-button:hover,
#em_quickshop_handler:hover,
.custom_category_shortcode .wd_product_heading span.onsale,
.woocommerce .custom_category_shortcode .wd_product_heading span.onsale,
.woocommerce-page .custom_category_shortcode .wd_product_heading span.onsale,
ul.products li.product .product_thumbnail_wrapper .list_add_to_cart a:hover,
.woocommerce ul.products li.product .product_thumbnail_wrapper .list_add_to_cart a:hover,
.woocommerce-page ul.products li.product .product_thumbnail_wrapper .list_add_to_cart a:hover,
html div.pp_woocommerce .pp_close:hover,
.wd_feedback .pp_close:hover,
div.pp_woocommerce.wd_feedback .pp_close:hover{
	background-color:@secondary_color;
}

.widget_social ul li.icon-facebook:hover a,
.widget_social ul li.icon-twitter:hover a,
.widget_social ul li.icon-pin:hover a,
.widget_social ul li.icon-rss:hover a {
	background-color:@secondary_color;
}

/* TERTIARY COLOR */
div.product .posted_in a,
div.product .tagged_as a,
.woocommerce #content .order_details small, 
.woocommerce-page #content .order_details small,
#content .addresses .edit,
.woocommerce #content .addresses .edit,
.woocommerce-page #content .addresses .edit,
#content table.my_account_orders td.order-actions a.button,
.woocommerce #content table.my_account_orders td.order-actions a.button, 
.woocommerce-page #content table.my_account_orders td.order-actions a.button,
html #reviews #comments ol.commentlist li .comment-text strong,
html .woocommerce #reviews #comments ol.commentlist li .comment-text strong, 
html .woocommerce-page #reviews #comments ol.commentlist li .comment-text strong,
body .woocommerce form.login a.lost_password, 
body.woocommerce-page form.login a.lost_password, 
body .woocommerce form.checkout_coupon a.lost_password, 
body.woocommerce-page form.checkout_coupon a.lost_password, 
body .woocommerce form.register a.lost_password, 
body.woocommerce-page form.register a.lost_password,
ul.list-posts .post .author a,
ul.list-posts .portfolio .author a,
ul.list-posts li .post-info-content .cat-links a,
.single-content .post-info-meta > .author a,
.tags_social .tags .tag-links a,
#author-description .view-all-author-posts a,
#comments .commentlist li .detail .comment-author a  {
	color:@tertiary_color;
}

/*==============================================================*/
/*                  TOP HEADER                                  */
/*==============================================================*/

.header-top {
	background-color:@header_top_background_color;
	color:@header_top_text_color;
}

.header-top a,
.header-top ul.currency_switcher li a {
	color:@header_top_text_color;
}

/*==============================================================*/
/*                  HORIZONTAL MENU                             */
/*==============================================================*/

/* FONT */
#header .nav,
#header .nav h1,
#header .nav h2,
#header .nav h3,
#header .nav h4,
#header .nav h5,
#header .nav h6,
#header .nav > .main-menu > ul.menu > li > ul.sub-menu,
#header .nav > div.menu > ul > li ul.children {
	font-family:@font_horizontalmenu_submenu;
}

#header .nav > .main-menu > ul.menu > li > a > span,
#header .nav > div.menu > ul > li > a  {
	font-family:@font_horizontalmenu;
}

/* GRADIENT */
#header .nav{
	.gradient_3(@horizontal_menu_gradient_start_color,@horizontal_menu_gradient_end_color);
	border-color:@horizontal_menu_border_color;
	border-bottom-color:(@horizontal_menu_border_color - #2f201e);
}

#header .nav #wd-menu-item-dropdown-div {
	.gradient(@horizontal_menu_gradient_start_color,@horizontal_menu_gradient_end_color);
}

#header .nav:before,
#header .nav #wd-menu-item-dropdown-div:before{
	background-color:(@horizontal_menu_gradient_start_color + #0d3740);
}

#header .nav:after,
#header .nav #wd-menu-item-dropdown-div:after {
	background-color:(@horizontal_menu_gradient_end_color + #101007);
}

#header .nav > .main-menu > ul.menu > li > a {
	border-color:(@horizontal_menu_gradient_end_color - #0e0f10);
}

@media 
only screen and (max-width-device-width: 767px),
only screen and (max-width: 767px) {
	#header #menu-main-menu {
		border-color:@horizontal_menu_border_color;
	}
}

/* TEXT COLOR LEVEL 01 */
#header .nav #wd-menu-item-dropdown-div,
#header .nav > .main-menu > ul.menu > li > a > span,
#header .nav > .main-menu > ul.menu > li.parent:after,
#header .nav .main-menu > ul.menu > li.parent > span.menu-drop-icon:after,
#header .nav > div.menu > ul > li > a {
	color:@horizontal_menu_text_color;
}

#header .nav > .main-menu > ul.menu > li:hover > a > span, 
#header .nav > .main-menu > ul.menu > li.current-menu-item > a > span, 
#header .nav > .main-menu > ul.menu > li.current_page_item > a > span, 
#header .nav > .main-menu > ul.menu > li.current-menu-ancestor > a > span, 
#header .nav > .main-menu > ul.menu > li.current_page_ancestor > a > span,
#header .nav > .main-menu > ul.menu > li.parent:hover:after, 
#header .nav > .main-menu > ul.menu > li.parent.current-menu-item:after, 
#header .nav > .main-menu > ul.menu > li.parent.current_page_item:after, 
#header .nav > .main-menu > ul.menu > li.parent.current-menu-ancestor:after, 
#header .nav > .main-menu > ul.menu > li.parent.current_page_ancestor:after,
#header .nav > .main-menu > ul.menu > li.parent:hover > span.menu-drop-icon:after,
#header .nav > .main-menu > ul.menu > li.parent.current-menu-item > span.menu-drop-icon:after,
#header .nav > .main-menu > ul.menu > li.parent.current_page_item > span.menu-drop-icon:after,
#header .nav > .main-menu > ul.menu > li.parent.current-menu-ancestor > span.menu-drop-icon:after,
#header .nav > .main-menu > ul.menu > li.parent.current_page_ancestor > span.menu-drop-icon:after, {
	color:@horizontal_menu_text_color_hover;
}

@media 
only screen and (max-width-device-width: 767px),
only screen and (max-width: 767px) {
	#header .nav > .main-menu > ul.menu > li > a > span {
		color:@horizontal_menu_submenu_text_color;
		font-family:@font_horizontalmenu_submenu;
	}
	body #header .nav > .main-menu > ul.menu > li {
		border-color:@horizontal_menu_submenu_border_color;
	}
	#header .nav > .main-menu > ul.menu > li.parent:after,
	#header .nav .main-menu > ul.menu > li.parent > span.menu-drop-icon:after {color:@horizontal_menu_submenu_text_color;}
}

/* SUBMENU */
#header .nav > .main-menu > ul.menu ul.sub-menu:before,
#header .nav > div.menu > ul > li ul.children:before {
	background-color:@horizontal_menu_submenu_background_color;
	border-color:@horizontal_menu_submenu_border_color;
}

#header .nav > .main-menu > ul.menu > li > ul.sub-menu,
#header .nav > .main-menu > ul.menu > li > ul.sub-menu a,
#header .nav > .main-menu > ul.menu > li > ul.sub-menu a.menu_readmore,
.nav ul.products li.product .price .from,
.nav .woocommerce ul.products li.product .price .from,
.woocommerce-page .nav ul.products li.product .price .from {
	color:@horizontal_menu_submenu_text_color;
}

#header .nav > .main-menu > ul.menu ul.sub-menu li:hover > a, 
#header .nav > .main-menu > ul.menu ul.sub-menu li.current-menu-item > a, 
#header .nav > .main-menu > ul.menu ul.sub-menu li.current-page-ancestor > a, 
#header .nav > .main-menu > ul.menu ul.sub-menu li.current-menu-ancestor > a, 
#header .nav > .main-menu > ul.menu ul.sub-menu li.current-page-parent > a,
#header .nav > .main-menu > ul.menu > li > ul.sub-menu a.menu_readmore:hover,
#header .nav ul.products li.product a:hover, 
html .nav .woocommerce ul.products li.product a:hover, 
html .nav .vertical-menu ul.products li.product a:hover, 
.nav .custom_category_shortcode .wd_feature_title:hover,
#header .nav > .main-menu > ul.menu > li > ul.sub-menu a.menu_readmore:hover {
	color:@horizontal_menu_submenu_text_color_hover;
}

/* ---- Icons */
#header .nav > .main-menu > ul.menu > li.wd-fly-menu li.parent:after,
#header .nav .main-menu > ul.menu > li li.wd-fly-menu > span.menu-drop-icon:after {
	color:@horizontal_menu_submenu_text_color;
}

#header .nav > .main-menu > ul.menu > li.wd-fly-menu li.parent:hover:after,
#header .nav .main-menu > ul.menu > li li.wd-fly-menu:hover > span.menu-drop-icon:after,
#header .nav .main-menu > ul.menu > li li.wd-fly-menu > span.menu-drop-icon.active:after  {
	color:@horizontal_menu_submenu_text_color_hover;
}

/*==============================================================*/
/*                  VERTICAL MENU                               */
/*==============================================================*/

/* FONT */
.wd_vertical_menu,
.wd_vertical_menu h1,
.wd_vertical_menu h2,
.wd_vertical_menu h3,
.wd_vertical_menu h4,
.wd_vertical_menu h5,
.wd_vertical_menu h6,
html .wd_vertical_menu ul.products li.product .heading-title,
html .wd_vertical_menu .woocommerce ul.products li.product .heading-title,
html .woocommerce-page .wd_vertical_menu ul.products li.product .heading-title {
	font-family:@font_verticalmenu_submenu;
}

.wd_vertical_menu .mega-control-menu,
.vertical-menu > .menu > li > a {
	font-family:@font_verticalmenu;
}

/* COLOR */

.wd_vertical_menu .mega-control-menu  {
	.gradient(@vertical_menu_control_gradient_start_color,@vertical_menu_control_gradent_end_color);
}

.wd_vertical_menu .mega-control-menu:hover {
	.gradient(@vertical_menu_control_gradent_end_color,@vertical_menu_control_gradient_start_color);
}

.wd_vertical_menu .vertical-menu {
	border-color:@vertical_menu_control_border_color;
}

.wd_vertical_menu .mega-control-menu {
	border-color:@vertical_menu_border_color;
	color:@vertical_menu_control_text_color;
}

.vertical-menu > .menu > li  {
	border-color:@vertical_menu_border_color;
}

.vertical-menu > .menu > li > a {
	color:@vertical_menu_text_color;
}

.vertical-menu > .menu > li:hover > a > span, 
.vertical-menu > .menu > li.current-product_cat-ancestor > a > span, 
.vertical-menu > .menu > li.current-menu-ancestor > a > span, 
.vertical-menu > .menu > li.current-product_cat-parent > a > span,
.vertical-menu > .menu > li.current-menu-item > a > span {
	color:@vertical_menu_text_color_hover;
}

.vertical-menu > .menu li:hover:after, 
.vertical-menu > .menu li.current-product_cat-ancestor:after, 
.vertical-menu > .menu li.current-menu-ancestor:after, 
.vertical-menu > .menu li:hover > .menu-drop-icon:after,
.vertical-menu > .menu li.current-menu-item .menu-drop-icon:after ,
.vertical-menu > .menu li.current-product_cat-ancestor .menu-drop-icon:after , 
.vertical-menu > .menu li.current-menu-ancestor .menu-drop-icon:after   {
	color:@vertical_menu_text_color_hover;
}

/* Sub menu */

.vertical-menu > .menu li li.parent:hover:after {
	color:@vertical_menu_submenu_text_color_hover;
}

.vertical-menu > .menu > li li a,
.vertical-menu > .menu > li ul.sub-menu,
.wd_vertical-menu > .menu > li ul.sub-menu a,
.vertical-menu > .menu li li.parent:after,
.vertical-menu > .menu li li > .menu-drop-icon:after,
.vertical-menu > .menu > li ul.sub-menu a.menu_readmore,
.vertical-menu ul.products li.product .price .from,
.vertical-menu .woocommerce ul.products li.product .price .from,
.woocommerce-page .vertical-menu ul.products li.product .price .from  {
	color:@vertical_menu_submenu_text_color;
}

.vertical-menu > .menu > li li a:hover,
.vertical-menu > .menu > li li:hover > a,
.vertical-menu > .menu li li.current-menu-ancestor > a,
.vertical-menu > .menu li li.current-menu-parent > a,
.vertical-menu > .menu li li.current-menu-item > a 
.vertical-menu > .menu li li:hover > .menu-drop-icon:after, 
.vertical-menu > .menu li li.current-menu-ancestor > .menu-drop-icon:after, 
.vertical-menu > .menu li li.current-menu-parent > .menu-drop-icon:after, 
.vertical-menu > .menu li li.current-menu-item > .menu-drop-icon:after,
.vertical-menu > .menu li li:hover > .menu-drop-icon:after,
.vertical-menu > .menu li li.current-menu-item .menu-drop-icon:after ,
.vertical-menu > .menu li li.current-product_cat-ancestor .menu-drop-icon:after , 
.vertical-menu > .menu li li.current-menu-ancestor .menu-drop-icon:after,
.vertical-menu .menu_readmore:after,
.vertical-menu ul.products li.product a:hover, 
html .vertical-menu .woocommerce ul.products li.product a:hover, 
html .woocommerce-page .vertical-menu ul.products li.product a:hover, 
.vertical-menu .custom_category_shortcode .wd_feature_title:hover ,
.vertical-menu > .menu > li ul.sub-menu a.menu_readmore:hover{
	color:@vertical_menu_submenu_text_color_hover;
}

.vertical-menu > .menu > li ul.sub-menu {
	border-color:@vertical_menu_submenu_border_color;
	background:@vertical_menu_submenu_background_color;
}

.vertical-menu > .menu > li {
	background:@vertical_menu_background_color;
}

/*==============================================================*/
/*                  PRODUCTS                                    */
/*==============================================================*/

span.amount {
	color:@product_price_color;
}

del span.amount,
.widget-container del,
ul.products .product del {
	color:@product_old_price_color;
}

ul.products li.product .wd_product_categories a,
html .woocommerce ul.products li.product .wd_product_categories a,
html .woocommerce-page ul.products li.product .wd_product_categories a,
.cart_list.product_list_widget .wd_cart_item_categories a,
.nav ul.products li.product .wd_product_categories a,
html .nav .woocommerce ul.products li.product .wd_product_categories a,
html .woocommerce-page .nav ul.products li.product .wd_product_categories a,
.wd_vertical_menu ul.products li.product .wd_product_categories a,
html .wd_vertical_menu .woocommerce ul.products li.product .wd_product_categories a,
html .woocommerce-page .wd_vertical_menu ul.products li.product .wd_product_categories a,
#footer ul.products li.product .wd_product_categories a,
html #footer .woocommerce ul.products li.product .wd_product_categories a,
html .woocommerce-page #footer ul.products li.product .wd_product_categories a
 {
	color:@product_category_text_color;
}

ul.products li.product .wd_related ul li a,
.add_new_review a {
	color:@tertiary_color;
}

/*==============================================================*/
/*                  FOOTER                                      */
/*==============================================================*/

/* HEADING */
#footer h1, #footer h2, #footer h3, 
#footer h4, #footer h5, #footer h6,
#footer .widget-title,
.third-footer-area .payment .payment_title, 
.third-footer-area .service .service_title,
#footer .box-heading .read-more,
#footer .widget_multitab ul.nav-tabs li a,
#footer .widget_multitab ul.nav-tabs li a:hover, {
	color:@footer_heading_color;
}

/* LINKS */
#footer a {
	color:@footer_link_color;
}

#footer a:hover,
#footer .copyright a:hover {
	color:@footer_link_color_hover;
}

/* BORDER */
#footer .box-heading,
#footer .widget_subscriptions,
#footer .widget_social,
html #footer input[type^="text"], 
html #footer input[type^="email"],
html #footer input[type^="password"],
#footer textarea,
#footer select,#footer input,
#footer .static_block_service  {
	border-color:@footer_border_color;
}

.second-footer-widget-area > .container:after,
.static_block_service .item .desc:after {
	background:@footer_border_color;
}

/* TEXT */
#footer,
#footer .copyright a, 
#footer .fourth-footer-widget-area .widget_nav_menu .menu li a,
html #footer input[type^="text"], 
html #footer input[type^="email"],
html #footer input[type^="password"],
#footer ul.products li.product .price .from,
#footer .woocommerce ul.products li.product .price .from,
#footer .woocommerce-page ul.products li.product .price .from,
body #footer input, body #footer select, body #footer textarea  {
	color:@footer_text_color;
}

.fourth-footer-widget-area .widget_nav_menu .menu li,
#footer .widget_multitab .tab-content ul li {
	border-color:(@footer_text_color + #696969);
}

/*==============================================================*/
/*                  SIDEBAR                                     */
/*==============================================================*/

/* TEXT COLOR */
#left-sidebar,
#right-sidebar,
#left-sidebar ul.products li.product .price .from,
#left-sidebar .woocommerce ul.products li.product .price .from,
.woocommerce-page #left-sidebar ul.products li.product .price .from,
#right-sidebar ul.products li.product .price .from,
#right-sidebar .woocommerce ul.products li.product .price .from,
.woocommerce-page #right-sidebar ul.products li.product .price .from,
body #left-sidebar input, body #left-sidebar select, body #left-sidebar textarea,
body #right-sidebar input, body #right-sidebar select, body #right-sidebar textarea,
html .widget_layered_nav ul small.count,
html .woocommerce .widget_layered_nav ul small.count, 
html .woocommerce-page .widget_layered_nav ul small.count {
	color:@sidebar_text_color;
}

/* LINK COLOR */
#left-sidebar a,
#right-sidebar a,
#left-sidebar .widget_product_categories ul li:hover > a,
#right-sidebar .widget_product_categories ul li.current-cat > a,
#left-sidebar .widget_nav_menu ul li:hover > a,
#right-sidebar .widget_nav_menu ul li.current-cat > a,
#left-sidebar .widget_pages a:hover,
#right-sidebar .widget_pages a:hover,
#left-sidebar .widget_layered_nav a:hover,
#right-sidebar .widget_layered_nav a:hover,
#left-sidebar .widget_product_categories ul li a:hover,
#right-sidebar .widget_product_categories ul li a:hover,
#left-sidebar .widget_categories ul li a:hover,
#right-sidebar .widget_categories ul li a:hover,
.woocommerce .widget_price_filter .price_slider_amount .price_label, 
.woocommerce-page .widget_price_filter .price_slider_amount .price_label,
.woocommerce .widget_price_filter .price_slider_amount .price_label span, 
.woocommerce-page .widget_price_filter .price_slider_amount .price_label span,
#left-sidebar ul.currency_switcher li a.active,
#left-sidebar ul.currency_switcher li a:hover,
#right-sidebar ul.currency_switcher li a.active,
#right-sidebar ul.currency_switcher li a:hover {
	color:@sidebar_link_color;
}

#left-sidebar a:hover,
#right-sidebar a:hover {
	color:@sidebar_link_color_hover;
}

/* BORDER COLOR */
#left-sidebar .box-heading,
#right-sidebar .box-heading,
#left-sidebar .widget-container,
#right-sidebar .widget-container,
#left-sidebar .box-heading,
#left-sidebar .wd_popular_product_wrapper,
#left-sidebar .wd_popular_product_wrapper .wd_popular_product_wrapper_meta,
#left-sidebar .custom_category_shortcode_style2,
#left-sidebar .custom_category_shortcode_style2 .wd_heading,
#left-sidebar .wd_product_category_list_shortcode,
#left-sidebar .wd_product_category_list_shortcode .top_title,
#left-sidebar .wd_hot_product,
#left-sidebar .custom_category_shortcode_style2 .wd_heading:hover,
#left-sidebar .widget_subscriptions,
#left-sidebar .widget_social,
#left-sidebar select,
html #left-sidebar input[type^="text"], 
html #left-sidebar input[type^="email"],
html #left-sidebar input[type^="password"],
#right-sidebar .wd_meta_loop,
#right-sidebar .box-heading,
#right-sidebar .wd_popular_product_wrapper,
#right-sidebar .wd_popular_product_wrapper .wd_popular_product_wrapper_meta,
#right-sidebar .custom_category_shortcode_style2,
#right-sidebar .custom_category_shortcode_style2 .wd_heading,
#right-sidebar .wd_product_category_list_shortcode,
#right-sidebar .wd_product_category_list_shortcode .top_title,
#right-sidebar .wd_hot_product,
#right-sidebar .custom_category_shortcode_style2 .wd_heading:hover,
#right-sidebar .widget_subscriptions,
#right-sidebar .widget_social,
#right-sidebar select,
html #right-sidebar input[type^="text"], 
html #right-sidebar input[type^="email"],
html #right-sidebar input[type^="password"],
#right-sidebar .wd_meta_loop,
#left-sidebar .widget_multitab .tab-content ul li, 
#right-sidebar .widget_multitab .tab-content ul li {
	border-color:@sidebar_border_color;
}

@media 
only screen and (max-width-device-width: 767px),
only screen and (max-width: 767px) {
	#left-sidebar .widget-container > div,
	#left-sidebar .widget-container > ul,
	#right-sidebar .widget-container > div,
	#right-sidebar .widget-container > ul {
		border-color:@sidebar_border_color;
	}
}

/* HEADING */
#left-sidebar .widget-container .widget-title,
#right-sidebar .widget-container .widget-title,
#left-sidebar .widget_social .widget_desc,
#right-sidebar .widget_social .widget_desc,
#left-sidebar  .widget_multitab ul.nav-tabs,
#right-sidebar  .widget_multitab ul.nav-tabs  {
	.gradient(@sidebar_gradient_heading_start_color, @sidebar_gradient_heading_end_color);
	border-color:@sidebar_border_color;
	color:@sidebar_heading_color;
}

#left-sidebar .widget-container .widget-title:hover,
#right-sidebar .widget-container .widget-title:hover {
	.gradient(@sidebar_gradient_hover_heading_start_color, @sidebar_gradient_hover_heading_end_color);
	color:@sidebar_gradient_hover_text_color;
}

#left-sidebar h1, #left-sidebar h2, #left-sidebar h3,
#left-sidebar h4, #left-sidebar h5, #left-sidebar h6,
#left-sidebar .widget_multitab ul.nav-tabs li a,
#left-sidebar .widget_multitab ul.nav-tabs li a:hover,
#right-sidebar .widget_multitab ul.nav-tabs li a,
#right-sidebar .widget_multitab ul.nav-tabs li a:hover,
#wp-calendar caption {
	color:@sidebar_heading_color;
}

			<?php 
			$file = @fopen($cache_file, 'w');
			if( $file != false ){
				@fwrite($file, ob_get_contents()); 
				@fclose($file); 
			}else{
				define('USING_CSS_CACHE', false);
			}
			update_option(THEME_SLUG.'custom_style', ob_get_contents());
			//ob_end_flush();		
			ob_end_clean();
			
			return USING_CSS_CACHE == true ? 1 : 0;
		}catch(Excetion $e){
			// $result = new StdClass();
			// $result->status = array();
			// return $result;
			return -1;
		}
	}
		
	function wd_load_gg_fonts() {
		global $wd_font_name,$wd_font_size;	
		$font_size_str = "";
		if( isset($wd_font_size) && strlen($wd_font_size) > 0 ){
			$font_size_str = ":{$wd_font_size}";
		}
		if( isset($wd_font_name) && strlen( $wd_font_name ) > 0 ){
			$font_name_id = strtolower($wd_font_name);
			$protocol = is_ssl() ? 'https' : 'http';
			wp_enqueue_style( "gomarket-{$font_name_id}", "{$protocol}://fonts.googleapis.com/css?family={$wd_font_name}{$font_size_str}" );		
		}
	}		
		
	function custom_style_inline_script(){
		global $wd_data;
		$enable_style_fonts = absint($wd_data['wd_style_fonts']);
		
		$body_font =  esc_attr( $wd_data['wd_body_font1_googlefont'] );
		$body_font  = str_replace( " ", "+", $body_font );
	   
		$heading_font = esc_attr( $wd_data['wd_heading_font_googlefont'] );
		$heading_font  = str_replace( " ", "+", $heading_font );
		
		$horizontal_menu_font = esc_attr( $wd_data['wd_menu_font_googlefont'] );
		$horizontal_menu_font  = str_replace( " ", "+", $horizontal_menu_font );		
		
		$horizontal_submenu_font = esc_attr( $wd_data['wd_submenu_font_googlefont'] );
		$horizontal_submenu_font  = str_replace( " ", "+", $horizontal_submenu_font );
		
		$vertical_menu_font = esc_attr( $wd_data['wd_vertical_menu_googlefont'] );
		$vertical_menu_font  = str_replace( " ", "+", $vertical_menu_font );		
		
		$vertical_submenu_font = esc_attr( $wd_data['wd_vertical_submenu_googlefont'] );
		$vertical_submenu_font  = str_replace( " ", "+", $vertical_submenu_font );	
		
		global $wd_font_name,$wd_font_size;	
			
		if( $enable_style_fonts ){
			if( $wd_data['wd_body_font1_googlefont_enable'] == 0 && strcmp($body_font,'none') != 0 ){?>
				<?php 
					$wd_font_name = trim( $body_font );
					//$wd_font_size = trim( $body_font_weight );
					wd_load_gg_fonts();
				?>
			<?php }
			if( $wd_data['wd_heading_font_googlefont_enable'] == 0 && strcmp($heading_font,'none') != 0){?>
				<?php 
					$wd_font_name = trim( $heading_font );
					//$wd_font_size = trim( $heading_font_weight );
					wd_load_gg_fonts();
				?>
			<?php }			
			if( $wd_data['wd_horizontal_menu_font_googlefont_enable'] == 0 && strcmp($horizontal_menu_font,'none') != 0){?>
				<?php 
					$wd_font_name = trim( $horizontal_menu_font );
					//$wd_font_size = trim( $horizontal_menu_font_weight );
					wd_load_gg_fonts();
				?>
			<?php }
			if( $wd_data['wd_horizontal_submenu_font_googlefont_enable'] == 0 && strcmp($horizontal_submenu_font,'none') != 0){?>
				<?php 
					$wd_font_name = trim( $horizontal_submenu_font );
					//$wd_font_size = trim( $horizontal_menu_font_weight );
					wd_load_gg_fonts();
				?>
			<?php }
			if($wd_data['wd_vertical_menu_font_enable'] == 0 && strcmp($vertical_menu_font,'none') != 0){?>
				<?php 
					$wd_font_name = trim( $vertical_menu_font );
					//$wd_font_size = trim( $vertical_menu_font_weight );
					wd_load_gg_fonts();
				?>
			<?php }
			if($wd_data['wd_vertical_submenu_font_enable'] == 0 && strcmp($vertical_submenu_font,'none') != 0){?>
				<?php 
					$wd_font_name = trim( $vertical_submenu_font );
					//$wd_font_size = trim( $vertical_menu_font_weight );
					wd_load_gg_fonts();
				?>
			<?php }
		}
		if( USING_CSS_CACHE == false ){
			global $custom_style;
			echo '<style type="text/css">';
			echo get_option(THEME_SLUG.'custom_style', '');
			echo '</style>';
		}		
		
	}
		
			
		
	function include_cache_css(){
		global $wd_data;
		$custom_cache_file = THEME_CACHE.'custom.less';
		$custom_cache_file_uri = THEME_URI.'/cache_theme/custom.less';
		
		if (file_exists($custom_cache_file) && $wd_data['wd_style_fonts']) {
			wp_dequeue_style('custom_default');
			wp_register_style( 'custom-style',$custom_cache_file_uri );
			wp_enqueue_style('custom-style');
		}
		
		if(file_exists(THEME_CACHE.'custom.css')){
			wp_register_style( 'wd_custom_css', THEME_URI.'/cache_theme/custom.css');
			wp_enqueue_style('wd_custom_css');
		}
	}

	if( USING_CSS_CACHE == true ){
		add_action('wp_enqueue_scripts','include_cache_css',10000000000000);
	}	
?>