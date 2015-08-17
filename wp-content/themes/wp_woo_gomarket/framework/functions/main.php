<?php 


	/**
	*	Combine a input array with defaut array
	*
	**/
	if(!function_exists ('wd_valid_color')){
		function wd_valid_color( $color = '' ) {
			if( strlen(trim($color)) > 0 ) {
				$named = array('aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue', 'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen');
				if (in_array(strtolower($color), $named)) {
					return true;
				}else{
					return preg_match('/^#[a-f0-9]{6}$/i', $color);			
				}
			}
			return false;
		}
	}

	/**
	*	Combine a input array with defaut array
	*
	**/
	if(!function_exists ('wd_array_atts')){
		function wd_array_atts($pairs, $atts) {
			$atts = (array)$atts;
			$out = array();
		   foreach($pairs as $name => $default) {
				if ( array_key_exists($name, $atts) ){
					if( strlen(trim($atts[$name])) > 0 ){
						$out[$name] = $atts[$name];
					}else{
						$out[$name] = $default;
					}
				}
				else{
					$out[$name] = $default;
				}	
			}
			return $out;
		}
	}
	
	if(!function_exists ('wd_array_atts_str')){
		function wd_array_atts_str($pairs, $atts) {
			$atts = (array)$atts;
			$out = array();
		   foreach($pairs as $name => $default) {
				if ( array_key_exists($name, $atts) ){
					if( strlen(trim($atts[$name])) > 0 ){
						$out[$name] = $atts[$name];
					}else{
						$out[$name] = $default;
					}
				}
				else{
					$out[$name] = $default;
				}	
			}
			return $out;
		}
	}	
	
	if(!function_exists ('wd_get_all_post_list')){
		function wd_get_all_post_list( $_post_type = "post" ){
			wp_reset_query();
			$args = array(
				'post_type'=> $_post_type
				,'posts_per_page'  => -1
			);
			$_post_lists = get_posts( $args );
			
			if( $_post_lists ){
				foreach ( $_post_lists as $post ) {
					setup_postdata($post);
					$ret_array[] = array(
						$post->ID
						,get_the_title($post->ID)
					);
				}
			}else{
				$ret_array = array();
			}
			wp_reset_query();	
			return $ret_array ;
			
		}
	}	
	
	if(!function_exists ('show_page_slider')){
		function show_page_slider(){
			global $page_datas;
			$revolution_exists = ( class_exists('RevSlider') && class_exists('UniteFunctionsRev') );
			switch ($page_datas['page_slider']) {
				case 'revolution':
					if( $revolution_exists )
						RevSliderOutput::putSlider($page_datas['page_revolution'],"");
					break;
				case 'flex':
					show_flex_slider($page_datas['page_flex']);
					break;	
				case 'nivo':
					show_nivo_slider($page_datas['page_nivo']);
					break;	
				case 'product' :
					show_prod_slider($page_datas['product_tag']);
					break;							
				case 'none' :
					break;							
				default:
				   break;
			}	
		}
	}
	add_action( 'wd_header_init', 'wd_print_header_head', 10 );
	if(!function_exists ('wd_print_header_head')){
		function wd_print_header_head(){
		global $wd_data;	
	?>	
	
			<div class="header-top">
				<div class="header-top-container">
					<div class="container">
						<div class="left-header-top-content span12">
							<div class="header-top_text"><?php echo $wd_data['header_top_text'];?></div>
						</div>
						<div class="right-header-top-content span12">
							<div>
								<?php
									if ( is_active_sidebar( 'top-header-widget-area' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'top-header-widget-area' ); ?>
									</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div><!-- end header top -->
			
		<?php	
		}	
	}
	
	add_action( 'wd_header_init', 'wd_print_header_body', 20 );
	if(!function_exists ('wd_print_header_body')){
		function wd_print_header_body(){
	?>	
			<div class="header-middle">
				<div class="header-middle-content">
					<?php theme_logo();?>
					<div class="header_woo_content">
						<div class="header-bottom-wishlist">
							<?php echo wd_tini_account();//TODO : account form goes here?>
						</div>
						<div class="shopping-cart shopping-cart-wrapper">
							<?php echo wd_tini_cart();?>
						</div>
						<div class="phone_quick_menu_1 visible-phone">
							<div class="mobile_my_account">
								<?php if ( is_user_logged_in() ) { ?>
									<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','wpdance'); ?>"><?php _e('My Account','wpdance'); ?></a>
								<?php }
								else { ?>
									<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','wpdance'); ?>"><?php _e('Login / Register','wpdance'); ?></a>
								<?php } ?>
							</div>
						</div>
						<div class="mobile_cart_container visible-phone">
							<div class="mobile_cart">
							<?php
								global $woocommerce;
								if( isset($woocommerce) && isset($woocommerce->cart) ){
									$cart_url = $woocommerce->cart->get_cart_url();
									echo "<a href='{$cart_url}' title='View Cart'>View Cart</a>";
								}

							?>
							</div>
							<div class="mobile_cart_number">0</div>
						</div>
					</div>
					<div class="header_search"><?php wd_product_search_form(); ?></div>
				</div>
			</div><!-- end .header-middle -->	
			<?php wp_reset_query();?>			
		
	<?php	
		}	
	}

	add_action( 'wd_header_init', 'wd_print_header_footer', 30 );
	if(!function_exists ('wd_print_header_footer')){
		function wd_print_header_footer(){
		global $page_datas;
	?>	
			<div class="header-bottom">
				<div class="header-bottom-content container">
					<div class="wd_vertical_menu toggle_active span6 wd_mega_menu_wrapper">
						<?php 
							if ( has_nav_menu( 'vertical_menu' ) ) {
								wp_nav_menu( array( 'container_class' => 'vertical-menu pc-menu wd-mega-menu-wrapper','theme_location' => 'vertical_menu','walker' => new WD_Walker_Nav_Menu() ) );
							}else{
								wp_nav_menu( array( 'container_class' => 'vertical-menu pc-menu wd-mega-menu-wrapper','theme_location' => 'vertical_menu' ) );
							}
						?>
						<script type="text/javascript">
						<?php if(is_page() && isset($page_datas['toggle_vertical_menu']) && absint($page_datas['toggle_vertical_menu']) == 0 ) :?>
							//jQuery(".wd_vertical_menu #menu-vertical-menu").css('position','absolute');
							jQuery(".header-bottom .wd_vertical_menu").removeClass('toggle_active').addClass('no_toggle');
							//jQuery(".wd_vertical_menu #menu-vertical-menu").addClass('active');
						<?php endif; ?>
						</script>	
					</div>
					<div class="static_content span18">
						<div class="nav wd_mega_menu_wrapper">
							<?php 
								if ( has_nav_menu( 'primary' ) ) {
									wp_nav_menu( array( 'container_class' => 'main-menu pc-menu wd-mega-menu-wrapper','theme_location' => 'primary','walker' => new WD_Walker_Nav_Menu() ) );
								}else{
									wp_nav_menu( array( 'container_class' => 'main-menu pc-menu wd-mega-menu-wrapper','theme_location' => 'primary' ) );
								}
							?>
						</div>
						<?php if(is_page() && isset($page_datas['hide_slider_hot_product']) && absint($page_datas['hide_slider_hot_product']) == 0 ) :?>
						<div class="static_header">
							<?php
								if ( is_active_sidebar( 'header-widget-area' ) ) : ?>
								<ul class="xoxo">
									<?php dynamic_sidebar( 'header-widget-area' ); ?>
								</ul>
							<?php endif; ?>
						</div>
						<?php endif;?>
					</div>
				</div>
			</div><!-- end .header-bottom -->
			<script type="text/javascript">
				//var header_bottom_height = jQuery(".header-bottom").outerHeight();
				//jQuery(".header-bottom").css("bottom","-"+header_bottom_height+"px");
				//jQuery(".main-slideshow").attr('style','min-height:' + header_bottom_height + ';other-styles');
				//jQuery(".main-slideshow").css("min-height",header_bottom_height + "px");
			</script>
	<?php		
		}	
	}	
	
	
	add_action( 'wd_bofore_main_container', 'wd_print_inline_script', 10 );
	if(!function_exists ('wd_print_inline_script')){
		function wd_print_inline_script(){
	?>	
		<script type="text/javascript">
			_ajax_uri = '<?php echo admin_url('admin-ajax.php');?>';
			_on_phone = <?php echo WD_IS_MOBILE === true ? 1 : 0 ;?>;
			_on_tablet = <?php echo WD_IS_TABLET === true ? 1 : 0 ;?>;
			theme_ajax = '<?php echo admin_url( 'admin-ajax.php' )?>';
			//if(navigator.userAgent.indexOf(\"Mac OS X\") != -1)
			//	console.log(navigator.userAgent);
			<?php 
				global $wd_data;
				if(isset($wd_data['wd_nicescroll']) && $wd_data['wd_nicescroll'] == 1) :
			?>
			jQuery("html").niceScroll({cursorcolor:"#000"});
			<?php endif; ?>
			jQuery('.menu li').each(function(){
				if(jQuery(this).children('.sub-menu').length > 0) jQuery(this).addClass('parent');
			});
		</script>
	<?php
		}
	}	
	//add_action( 'wd_bofore_main_container', 'wd_print_ads_block', 20 );
	if(!function_exists ('wd_print_ads_block')){
		function wd_print_ads_block(){
			global $page_datas;
	?>	
			<div class="header_ads_wrapper">
				<?php 
					if( !is_home() && !is_front_page() ){
						if( !is_page() ){
							printHeaderAds();
						}else{
							if( isset($page_datas['hide_ads']) && absint($page_datas['hide_ads']) == 0 )
								printHeaderAds();
						}
						
					}
						
				?>
			</div>
	<?php
		}
	}	


	add_action( 'wd_before_body_end', 'wd_before_body_end_widget_area', 10 );
	if(!function_exists ('wd_before_body_end_widget_area')){
		function wd_before_body_end_widget_area(){
	?>	
	
		<div class="container">
				<div class="body-end-widget-area">
					<?php
						if ( is_active_sidebar( 'body-end-widget-area' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'body-end-widget-area' ); ?>
							</ul>
						<?php endif; ?>						
				</div><!-- end #footer-first-area -->
		</div>	
		<?php wp_reset_query();?>
	
	<?php
		}
	}	

	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_1', 10 );
	if(!function_exists ('wd_footer_init_widget_area_1')){
		function wd_footer_init_widget_area_1(){
	?>	
	
		<?php //if( !wp_is_mobile() ): ?>
			<div class="first-footer-widget-area">
				<div class="container">
					<div class="first-footer-widget-area-content hidden-phone">
						<div class="container">
							<?php if ( is_active_sidebar( 'first-footer-widget-area-1' ) ) : ?>
								<ul class="xoxo">
									<?php dynamic_sidebar( 'first-footer-widget-area-1' ); ?>
								</ul>
							<?php endif; ?>
						</div>
					</div><!-- end #footer-first-area -->
					<div class="first-footer-widget-area-2 span16 hidden-phone">
						<div class="first-footer-widget-2-area">
							<?php
								if ( is_active_sidebar( 'first-footer-widget-area-2' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'first-footer-widget-area-2' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
					</div><!-- end #footer-first-area-2 -->
					<div class="first-footer-widget-area-3 span8 hidden-phone">
						<div class="first-footer-widget-3-area">
							<?php
								if ( is_active_sidebar( 'first-footer-widget-area-3' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'first-footer-widget-area-3' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
					</div><!-- end #footer-first-area-3 -->
				</div>
			</div>
			<?php wp_reset_query();?>
		<?php //endif; ?>	
		
	<?php
		}
	}

	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_2', 20 );
	if(!function_exists ('wd_footer_init_widget_area_2')){
		function wd_footer_init_widget_area_2(){
	?>	
	
		<?php //if( !wp_is_mobile() ): ?>
			<div class="second-footer-widget-area">
				<div class="container">
					<div class="second-footer-widget-area-1 span6 hidden-phone">
						<div class="second-footer-widget-1-area alpha omega">
							<?php
								if ( is_active_sidebar( 'second-footer-widget-area-1' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-1' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
					</div><!-- end #footer-second-area-1 -->	
					<div class="second-footer-widget-area-2 span6 hidden-phone">
						<div class="second-footer-widget-2-area alpha omega">
							<?php
								if ( is_active_sidebar( 'second-footer-widget-area-2' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-2' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
					</div><!-- end #footer-second-area-2 -->
					<div class="second-footer-widget-area-3 span6 hidden-phone">
						<div class="second-footer-widget-3-area alpha omega">
							<?php
								if ( is_active_sidebar( 'second-footer-widget-area-3' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-3' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
					</div><!-- end #footer-second-area-3 -->
					<div class="second-footer-widget-area-4 span6 hidden-phone">
						<div class="second-footer-widget-4-area alpha omega">
							<?php
								if ( is_active_sidebar( 'second-footer-widget-area-4' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-4' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
					</div><!-- end #footer-second-area-3 -->
				</div>
			</div>
			<?php wp_reset_query();?>
		<?php //endif; ?>	
		
	<?php
		}
	}


	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_3', 30 );
	if(!function_exists ('wd_footer_init_widget_area_3')){
		function wd_footer_init_widget_area_3(){
		global $wd_data;	
	?>	
	
				<div class="third-footer-area">
					<div class="container">
						<div class="payment span12">
							<div>
								<h3 class="payment_title"><?php _e('payment accept','wpdance'); ?></h3>
								<ul>
									<?php if($wd_data['wd_visa_image']) { ?><li><a href="#"><img alt="visa" title ="visa" src="<?php echo $wd_data['wd_visa_image'] ?>" /></a></li><?php } ?>
									<?php if($wd_data['wd_master_card_image']) { ?><li><a href="#"><img alt="master card" title="master card" src="<?php echo $wd_data['wd_master_card_image'] ?>" /></a></li><?php } ?>
									<?php if($wd_data['wd_american_express_image']) { ?><li><a href="#"><img alt="express" title="express" src="<?php echo $wd_data['wd_american_express_image'] ?>" /></a></li><?php } ?>
									<?php if($wd_data['wd_paypal_image']) { ?><li><a href="#"><img alt="paypal" title ="paypal" src="<?php echo $wd_data['wd_paypal_image'] ?>" /></a></li><?php } ?>
									<?php if($wd_data['wd_foo_image']) { ?><li><a href="#"><img alt="foo" title ="paypal" src="<?php echo $wd_data['wd_foo_image'] ?>" /></a></li><?php } ?>
								</ul>
							</div>
						</div>
						<div class="service span12">	
							<div>
								<h3 class="service_title"><?php _e('shipping service','wpdance'); ?></h3>
								<ul>
									<?php if($wd_data['wd_z_image']) { ?><li><a href="#"><img alt="z_service" title ="z service" src="<?php echo $wd_data['wd_z_image'] ?>" /></a></li><?php } ?>
									<?php if($wd_data['wd_fedex_image']) { ?><li><a href="#"><img alt="fedex" title="fedex" src="<?php echo $wd_data['wd_fedex_image'] ?>" /></a></li><?php } ?>
									<?php if($wd_data['wd_ups_image']) { ?><li><a href="#"><img alt="ups" title="ups" src="<?php echo $wd_data['wd_ups_image'] ?>" /></a></li><?php } ?>
								<ul>
							</div>
						</div>
					</div>
				</div><!-- end #footer-thrid-area -->
			<?php wp_reset_query();?>
	
	<?php
		}
	}


	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_4', 40 );
	if(!function_exists ('wd_footer_init_widget_area_4')){
		function wd_footer_init_widget_area_4(){
	?>	
	
				<div class="fourth-footer-widget-area">
					<div class="container"> 
						
						<?php 							
							if ( is_active_sidebar( 'bottom-footer-widget-area' ) ) : ?>
								<ul class="xoxo alpha">
									<?php dynamic_sidebar( 'bottom-footer-widget-area' ); ?>
								</ul>
							<?php endif; 	
						?>			
					</div>
				</div><!-- end #footer-fourth-area -->
				<?php wp_reset_query();?>
	
	<?php
		}
	}	


	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_5', 50 );
	if(!function_exists ('wd_footer_init_widget_area_5')){
		function wd_footer_init_widget_area_5(){
		global $wd_data;	
	?>	
			<div class="fifth-footer-area" >
				<div class="container">
					<div id="copy-right" class="copy-right span24">
						<div class="copyright">
							<?php global $wd_data;?>
							<?php echo stripslashes($wd_data['footer_text']); ?>
							<!--<p><?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?>  seconds.</p>-->
						</div>
					</div><!-- end #copyright -->
				</div>
			</div>	
				<?php wp_reset_query();?>
	
	<?php
		}
	}

	add_action( 'wd_before_footer_end', 'wd_before_body_end_content', 10 );
	if(!function_exists ('wd_before_body_end_content')){
		function wd_before_body_end_content(){
		global $wd_data;
	?>	
		<?php $_content = stripslashes($wd_data['sidebar_content']); ?>
		
		<?php if( strlen(trim($_content)) > 0 && trim($_content) != 'null'):?>
			<div id="feedback" class="hidden-phone">
				<a class="feedback-button wd-prettyPhoto" href="#<?php if (strlen($_content) > 0) {  ?>wd_contact_content<?php } ?>" ></a>
			</div>
			<div class="contact_form hidden-phone hidden" >
				<div class="contact_form_inner123" style="overflow:hidden;" id="wd_contact_content"><?php echo do_shortcode($_content);?></div>
			</div>
		<?php endif;?>
		
		<?php if(!wp_is_mobile()): ?>
		<div id="to-top" class="scroll-button">
			<a class="scroll-button" href="javascript:void(0)" title="<?php _e('Back to Top','wpdance');?>"></a>
		</div>
		<?php endif; ?>
		
		<!--<div class="loading-mark-up">
			<span class="loading-image"></span>
		</div>
		<span class="loading-text"></span>-->
	
	<?php
		}
	}
	
?>