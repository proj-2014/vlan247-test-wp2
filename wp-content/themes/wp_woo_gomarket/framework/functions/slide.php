<?php


if(!function_exists ('show_flex_slider')){
	function show_flex_slider($post_id){
		if( (int)$post_id > 0 ){
			
			global $post,$wd_custom_style_config;
		
			//$slider_datas = get_post_meta($post_id,THEME_SLUG.'_portfolio_slider',true);
			$slider_datas = get_post_meta($post_id,'wd_portfolio_slider',true);
			$slider_datas = unserialize($slider_datas);

			//$slider_configs = get_post_meta($post_id,THEME_SLUG.'_portfolio_slider_config',true);
			$slider_configs = get_post_meta($post_id,'wd_portfolio_slider_config',true);
			$slider_configs = wd_array_atts(array(
															"portfolio_slider_config_autoslide" => 1
															,"portfolio_slider_config_size" => 'slider'
														),unserialize($slider_configs));		
			$_main_size = 'slideshow_wide';
			if(is_page( $post->ID )){
				if( strcmp($wd_custom_style_config['page_layout'],'box') == 0 ){
					$_main_size = 'slideshow_box';
				}
			}
														
			
			if( is_array($slider_datas) && count($slider_datas) > 0 ){
				$_slider_id = "flex_slider_" . $post_id . "_" . rand();
				echo "<div class=\"flexslider\" id=\"{$_slider_id}\">";
				echo "	<ul class=\"slides\">";
				foreach($slider_datas as $slider){
					//print_r($slider);
					echo "<li>";
					echo "<a href=\"{$slider['url']}\" title=\"{$slider['title']}\">";
					echo wp_get_attachment_image( $slider['thumb_id'], $_main_size, false, array('title' => $slider['title'], 'alt' => $slider['title']) );
					echo "</a>";
					echo "</li>";
				}
				echo "	</ul>";
				echo "</div>";
				
?>
	<script type="text/javascript" charset="utf-8">
		//<![CDATA[
			jQuery(window).load(function() {
				jQuery('#<?php echo $_slider_id?>').flexslider();
			});
		//]]>	
	</script>
<?php				
			}

		}
	}
}	

if(!function_exists ('show_prod_slider')){
	function show_prod_slider( $product_tag = 'all-product-tags' ){
		$_short_code = "[featured_product_slider columns='3' layout='big' per_page='12' title='' desc='' show_nav='1' show_icon_nav='1' show_image='1' show_title='1' show_sku='1' show_price='1' show_label='1' show_rating='1' product_tag='{$product_tag}']";
		echo do_shortcode($_short_code);
	}
}	

	
	
if(!function_exists ('show_nivo_slider')){
	function show_nivo_slider( $post_id = 0 ){
		if( (int)$post_id > 0 ){
			
			global $post,$wd_custom_style_config;
			$_thumb_size = 'slider_thumb_wide';
			$_main_size = 'slideshow_wide';
			$_bottom_padding = '-65px';
			$_up_size = '-50px';
			if(is_page( $post->ID )){
				if( strcmp($wd_custom_style_config['page_layout'],'box') == 0 ){
					$_thumb_size = 'slider_thumb_box';
					$_main_size = 'slideshow_box';
					$_up_size = "-25px";
					$_bottom_padding = '-45px';
				}
			}
			
			$slider_datas = get_post_meta($post_id,'wd_portfolio_slider',true);
			$slider_datas = unserialize($slider_datas);

			
			$slider_configs = get_post_meta($post_id,'wd_portfolio_slider_config',true);
			$slider_configs = wd_array_atts(array(
															"portfolio_slider_config_autoslide" => 1
															,"portfolio_slider_config_size" => 'slider'
														),unserialize($slider_configs));		
												
			

			if( is_array($slider_datas) && count($slider_datas) > 0 ){
			

				echo 	'<div id="wrapper">
							<div class="slider-wrapper theme-default">
								<div id="slider" class="nivoSlider">';		
            $_caption_html = '<div class="nivo-html-caption">';
                
            							
				foreach($slider_datas as $slider){
					
					$_orgin_thumb_uri = wp_get_attachment_image_src( $slider['thumb_id'], 'full', false );
					$_title = $slider['title'];
					$_post_uri = isset($slider['url']) && strlen($slider['url']) > 0 ? $slider['url'] : "#";
					//$_thumb_uri = print_thumbnail($_orgin_thumb_uri,true,$_title, $slider_configs['portfolio_slider_config_width'], $slider_configs['portfolio_slider_config_height'],'',false,true);
					//$_sub_thumb_uri = print_thumbnail($_orgin_thumb_uri,true,$_title, $_thumb_size, $_thumb_size,'',false,true);
					$_thumb_uri = wp_get_attachment_image_src( $slider['thumb_id'], $_main_size, false );
					$_thumb_uri = $_thumb_uri[0];
					$_sub_thumb_uri = wp_get_attachment_image_src( $slider['thumb_id'], $_thumb_size, false );
					$_sub_thumb_uri = $_sub_thumb_uri[0];

					$_post_excerpt = $slider['slide_content'];
					$_caption_html .= "<div id='nivo-slider-meta-{$post_id}' class='nivo-slider-meta'>	
											<h2 class='post-title slider-title'><a href='{$_post_uri}' target='_blank'>{$_title}</a></h2>
											<p class='short-content'>{$_post_excerpt}</p>
										</div>";
?>
				<a href="<?php echo $_post_uri;?>">
					<img src="<?php echo $_thumb_uri;?>" data-thumb="<?php echo $_sub_thumb_uri;?>" alt="<?php echo $_title;?>" title="<?php echo "#nivo-slider-meta-{$post_id}";?>" />
				</a>
<?php	
				}
				$_caption_html .= "</div>";	
				echo 	"		</div>
							</div>
						</div>";			
			
			}
			
		}				
?>
	<style>
		.nivo-controlNav  a{
			float:left;
		}
		.nivo-controlNav{
			float:left;
			overflow:hidden;
		}		
	</style>

	<script type="text/javascript">
	//<![CDATA[
	function getdeg() {
		return deg = Math.floor(Math.random()* 41)-7 + 'deg';
	}
			
	function upThumb(){
		jQuery(this).stop().animate({
				'marginTop'	: '<?php echo $_up_size;?>'
		}, 400, 'easeOutBack').find('img').stop().animate({'rotate': '0deg'}, 400);		
	}
			
	function downThumb(){
		jQuery(this).stop().animate({
			'marginTop' : '0px'
		}, 400).find('img').stop().animate({'rotate': getdeg()}, 400);
	}
			
	function hideThumb(){
		jQuery('.nivo-controlNav > .nivo-control.active').addClass('hided').stop(true, true).animate({'marginTop': '-100px',opacity:0}, 400, 'easeOutBack');
	}		
			
	function showThumb(){
		jQuery('.nivo-controlNav > .nivo-control.hided').removeClass('hided').stop(true, true).animate({'marginTop': '0px',opacity:1}, 800);
	}
	
	function thumbnails() {	
		var e = jQuery('.nivo-controlNav');
		var cWidth = i = space = left = 0;

		if( jQuery('body').width() <= 480 ) {
			nSpacer = 0;
		} else {
			nSpacer = spacer;
		}
		e.find('.nivo-control').each(function(){
			i++;
			var space = 960 / (nb_thumbs + 1);
			var left = (space * i) - spacer; 
			cWidth = left + space;
					
			jQuery(this).attr('id', 't'+i);
			jQuery(this).stop().animate({'left':left+'px'}, 700, function(){

				jQuery(this).unbind('mouseenter')
					.bind('mouseenter', jQuery.throttle( 250,upThumb) )
					.unbind('mouseleave')
					.bind('mouseleave', jQuery.throttle( 250,downThumb));
				}).find('img').stop().animate({'rotate': getdeg()}, 300);
					
		});
		var cWidth = cWidth + ( 960 / (nb_thumbs + 1) ) - spacer;
	}
			
    jQuery(document).ready(function($) {
		_on_thumb_click = false;
        jQuery('#slider').nivoSlider({
			effect: 'random'
			,slices: 15
			,boxCols: 8
			,boxRows: 4
			,animSpeed: 500
			,pauseTime: 5000
			,startSlide: 0
			,directionNav: true
			,controlNav: true 
			,controlNavThumbs: true
			,pauseOnHover: true
			,manualAdvance: <?php echo ( (int)$slider_configs['portfolio_slider_config_autoslide'] == 1 ? 'false' : 'true' ) ;?>
			,prevText: 'Prev'
			,nextText: 'Next'
			,randomStart: false
			,beforeChange: function(){	
				showThumb();
				//console.log( jQuery('#slider').data('nivo:vars') );
			}
			,afterChange: function(){
				hideThumb();
			}
			,slideshowEnd: function(){}
			,lastSlide: function(){}
			,afterLoad: function(){
				var i = 0;
				spacer = 50;
				var current = false;
				var start = false;
					
				var _margin_bottom = '<?php echo $_bottom_padding;?>';		
				
				nb_thumbs = jQuery('.nivo-controlNav').addClass('hidden-phone').css('opacity',0).find('.nivo-control').length;	

				var defaults = {
					width: 960,
					pause: 5000,
					animationSpeed: 1500			
				};
				o = jQuery.extend(defaults, defaults);
				
				thumbnails();
				hideThumb();
				setTimeout(function(){
					var _margin_left = '-' + jQuery('.nivo-controlNav').width()/2 + 'px';
					jQuery('.nivo-controlNav').animate({ marginLeft: _margin_left , marginBottom:_margin_bottom ,opacity : 1}, 500 )
				},1000);					
			} 
		});
    });
	
	//]]>
    </script>
<?php		
		wp_reset_query();
	}
}	
	
	
if(!function_exists ('show_fredsel_slider')){
	function show_fredsel_slider($post_id){
		if( (int)$post_id > 0 ){
			$slider_datas = get_post_meta($post_id,THEME_SLUG.'_portfolio_slider',true);
			$slider_datas = unserialize($slider_datas);

			
			$slider_configs = get_post_meta($post_id,THEME_SLUG.'_portfolio_slider_config',true);
			$slider_configs = wd_array_atts(array(
															"portfolio_slider_config_autoslide" => 1
															,"portfolio_slider_config_size" => 'slider'
														),unserialize($slider_configs));	

			
			$_custom_size = $slider_configs['portfolio_slider_config_size'];
			$_width = 208;
										
			switch ($_custom_size) {
				case 'slideshow':
					$_width = 960;
					break;
				case 'slider':
					$_width = 208;
					break;
				case 'blog_thumb':
					$_width = 280;
					break;
				case 'prod_midium_thumb_1':
					$_width = 510;
					break;
				case 'prod_midium_thumb_2':
					$_width = 366;
					break;
				case 'prod_small_thumb':
					$_width = 141;
					break;
				case 'prod_tini_thumb':
					$_width = 75;
					break;
				case 'slider_thumb_wide':
					$_width = 150;
					break;
				case 'slider_thumb_box':
					$_width = 100;
					break;
				case 'related_thumb':
					$_width = 190;
					break;					
			}							

							
			if( is_array($slider_datas) && count($slider_datas) > 0 ){
				$_random_id = "fredsel_" . $post_id . "_" . rand();
				
				ob_start();
				
				?>
				<div class="featured_product_slider_wrapper shortcode_slider" id="<?php echo $_random_id;?>">
					<div class="fredsel_slider_wrapper_inner">
						<ul>
							<?php
								foreach( $slider_datas as $_slider ){
							?>	
								<li>
									<a href="<?php echo $_slider['url'];?>" title="<?php echo $_slider['slide_title'];?>">
										<?php echo wp_get_attachment_image( $_slider['thumb_id'], $_custom_size , false, array('title' => $_slider['title'], 'alt' => $_slider['title']) ); ?>
									</a>
								</li>
							<?php
								}
							?>						
						</ul>
						<div class="slider_control">
							<a id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						// Using custom configuration
						jQuery("#<?php echo $_random_id?> > .fredsel_slider_wrapper_inner > ul").carouFredSel({
							items 				: {
								width: <?php echo $_width;?>
								,height: 'auto'<?php //echo $slider_configs['portfolio_slider_config_height'];?>
								,visible: {
									min: 1
									,max: 4
								}							
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { onMouse: true, onTouch: true }		
							,scroll				: { items : 1,
													duration : 1000
													, pauseOnHover:true
													, easing : "easeInOutCirc"}
							,width				: '100%'
							,height				: '100%'<?php //echo $slider_configs['portfolio_slider_config_height'];?>
							,circular			: true
							,infinite			: true
							,auto				: <?php echo (int)$slider_configs['portfolio_slider_config_autoslide'] == 1 ? "true" : "false";?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							,pagination 		: '#<?php echo $_random_id;?>_pager'						
						});	
					});
					//]]>
				</script>
				<?php	
				return ob_get_clean();
			}
		}		
	}
}	
?>