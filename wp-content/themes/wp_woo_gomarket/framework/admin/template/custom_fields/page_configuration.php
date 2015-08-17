<?php 
	global $post;
	$revolution_exists = ( class_exists('RevSlider') && class_exists('UniteFunctionsRev') );
	$datas = unserialize(get_post_meta($post->ID,THEME_SLUG.'page_configuration',true));
	$datas = wd_array_atts(array(
										"page_layout" 			=> '0'
										,"main_content_layout"	=> 'box'
										,"header_layout"		=> 'box'
										,"footer_layout"		=> 'box'
										,"main_slider_layout"	=> 'box'
										,"banner_layout"		=> 'box'
										,"page_column"			=> '0-1-0'
										,"left_sidebar" 		=>'primary-widget-area'
										,"right_sidebar" 		=> 'primary-widget-area'
										,"page_slider" 			=> 'none'
										,"page_revolution" 		=> ''
										,"page_flex" 			=> ''
										,"page_nivo" 			=> ''		
										,"product_tag" 			=> ''
										,"portfolio_columns" 	=> 1
										,"portfolio_filter"		=> 1
										,"hide_breadcrumb" 		=> 0		
										,"hide_title" 			=> 0											
										//,"hide_ads" 			=> 0
										,"toggle_vertical_menu" 	=> 1										
										,"hide_slider_hot_product"			=> 1		
								),$datas);								
?>
<div class="page_config_wrapper">
	<div class="page_config_wrapper_inner">
		<input type="hidden" value="1" name="_page_config">
		<?php wp_nonce_field( "_update_page_config", "nonce_page_config" ); ?>
		<ul class="page_config_list">
			<li class="first">
				<p>
					<label><?php _e('Layout Style','wpdance');?> : 
						<select name="page_layout" id="page_layout">
							<option value="0" <?php if( strcmp($datas['page_layout'],'0') == 0 ) echo "selected";?>>Default</option>
							<option value="wide" <?php if( strcmp($datas['page_layout'],'wide') == 0 ) echo "selected";?>>Wide</option>
							<option value="box" <?php if( strcmp($datas['page_layout'],'box') == 0 ) echo "selected";?>>Box</option>
						</select>
					</label>
				</p> 
			</li>
			<?php 
				$main_content_show = 'style="display:none;"';
				$header_show = 'style="display:none;"';
				$footer_show = 'style="display:none;"';
				$main_slider_show = 'style="display:none;"';
				$banner_show = 'style="display:none;"';
				if( strcmp($datas['page_layout'],'wide') == 0 ) {
					$main_content_show = "";
					$header_show = "";	
					$footer_show = "";
					$main_slider_show = "";
					$banner_show ="";
				}
			?>
			<li class="sub_layout header_layout" <?php echo $header_show; ?>>
				<p>
					<label><?php _e('Header layout Style','wpdance');?> : 
						<select name="header_layout" id="header_layout">
							<option value="wide" <?php if( strcmp($datas['header_layout'],'wide') == 0 ) echo "selected";?>>Wide</option>
							<option value="box" <?php if( strcmp($datas['header_layout'],'box') == 0 ) echo "selected";?>>Box</option>
						</select>
					</label>
				</p> 
			</li>
			<li class="sub_layout main_slider_layout" <?php echo $main_slider_show; ?>>
				<p>
					<label><?php _e('Main slide layout Style','wpdance');?> : 
						<select name="main_slider_layout" id="slider_layout">
							<option value="wide" <?php if( strcmp($datas['main_slider_layout'],'wide') == 0 ) echo "selected";?>>Wide</option>
							<option value="box" <?php if( strcmp($datas['main_slider_layout'],'box') == 0 ) echo "selected";?>>Box</option>
						</select>
					</label>
				</p> 
			</li>
			<!--<li class="sub_layout banner_layout" <?php echo $banner_show; ?>>
				<p>
					<label><?php _e('Banner layout Style','wpdance');?> : 
						<select name="banner_layout" id="slider_layout">
							<option value="wide" <?php if( strcmp($datas['banner_layout'],'wide') == 0 ) echo "selected";?>>Wide</option>
							<option value="box" <?php if( strcmp($datas['banner_layout'],'box') == 0 ) echo "selected";?>>Box</option>
						</select>
					</label>
				</p> 
			</li>-->
			<li class="sub_layout main_content_layout" <?php echo $main_content_show; ?>>
				<p>
					<label><?php _e('Main content layout Style','wpdance');?> : 
						<select name="main_content_layout" id="main_content_layout">
							<option value="wide" <?php if( strcmp($datas['main_content_layout'],'wide') == 0 ) echo "selected";?>>Wide</option>
							<option value="box" <?php if( strcmp($datas['main_content_layout'],'box') == 0 ) echo "selected";?>>Box</option>
						</select>
					</label>
				</p> 
			</li>
			
			<li class="sub_layout footer_layout" <?php echo $footer_show; ?>>
				<p>
					<label><?php _e('Footer layout Style','wpdance');?> : 
						<select name="footer_layout" id="footer_layout">
							<option value="wide" <?php if( strcmp($datas['footer_layout'],'wide') == 0 ) echo "selected";?>>Wide</option>
							<option value="box" <?php if( strcmp($datas['footer_layout'],'box') == 0 ) echo "selected";?>>Box</option>
						</select>
					</label>
				</p> 
			</li>	
			<li>
				<p>
					<label><?php _e('Page Layout','wpdance');?> : 
						<select name="page_column" id="page_column">
							<option value="0-1-0" <?php if( strcmp($datas['page_column'],'0-1-0') == 0 ) echo "selected";?>>Fullwidth</option>
							<option value="1-1-0" <?php if( strcmp($datas['page_column'],'1-1-0') == 0 ) echo "selected";?>>Left Sidebar</option>
							<option value="0-1-1" <?php if( strcmp($datas['page_column'],'0-1-1') == 0 ) echo "selected";?>>Right Sidebar</option>
							<option value="1-1-1" <?php if( strcmp($datas['page_column'],'1-1-1') == 0 ) echo "selected";?>>Left & Right Sidebar</option>
						</select>
					</label>
				</p> 
			</li>
			

			<li>
				<p>
					<label><?php _e('Left Sidebar','wpdance');?> : 
						<select name="left_sidebar" id="_left_sidebar">
							<?php
								global $default_sidebars;
								foreach( $default_sidebars as $key => $_sidebar ){
									$_selected_str = ( strcmp($datas["left_sidebar"],$_sidebar['id']) == 0 ) ? "selected='selected'"  : "";
									echo "<option value='{$_sidebar['id']}' {$_selected_str}>{$_sidebar['name']}</option>";
								}
							?>
						</select>
					</label>
				</p> 
			</li>
			<li>
				<p>
					<label><?php _e('Right Sidebar','wpdance');?> : 
						<select name="right_sidebar" id="_right_sidebar">
							<?php
								global $default_sidebars;
								foreach( $default_sidebars as $key => $_sidebar ){
									$_selected_str = ( strcmp($datas["right_sidebar"],$_sidebar['id']) == 0 ) ? "selected='selected'"  : "";
									echo "<option value='{$_sidebar['id']}' {$_selected_str}>{$_sidebar['name']}</option>";
								}
							?>
						</select>
					</label>
				</p> 
			</li>			
			
			<li>
				<p>
					<label><?php _e('Page Slider','wpdance');?> : 
						<select name="page_slider" id="page_slider">
							<option value="none" <?php if( strcmp($datas['page_slider'],'none') == 0 ) echo "selected";?>>No Slider</option>
							<option value="revolution" <?php if( strcmp($datas['page_slider'],'revolution') == 0 ) echo "selected";?>>Revolution Slider</option>
							<option value="flex" <?php if( strcmp($datas['page_slider'],'flex') == 0 ) echo "selected";?>>Flex Slider</option>
							<option value="nivo" <?php if( strcmp($datas['page_slider'],'nivo') == 0 ) echo "selected";?>>Nivo Slider</option>
							<option value="product" <?php if( strcmp($datas['page_slider'],'product') == 0 ) echo "selected";?>>Product Slider</option>
						</select>
					</label>
				</p> 			
			</li>
			<?php if( $revolution_exists ):?>
			<li>
				<p>
					<label><?php _e('Revolution Slider','wpdance');?> : 
					
					<?php
						$slider = new RevSlider();
						$arrSliders = $slider->getArrSlidersShort();
						$sliderID = $datas['page_revolution'];
					?>
					
					<?php echo $select = UniteFunctionsRev::getHTMLSelect($arrSliders,$sliderID,'name="page_revolution" id="page_revolution_id"',true); ?>					
					</label>
				</p> 			
			</li>
			<?php endif;?>
			<li>
				<p>
					<label><?php _e('Flex Slider','wpdance');?> : 
						<select name="page_flex" id="page_flex_id">
						
						<?php 
							$_flex_slider = wd_get_all_post_list('slide');
							foreach( $_flex_slider as $_slide ){
						?>	
						
							<option value="<?php echo $_slide[0];?>" <?php if( $_slide[0] == (int)$datas['page_flex'] ) echo "selected";?>><?php echo $_slide[1];?></option>
						
						<?php	
							}
						?>
						
						</select>
					</label>
				</p> 			
			</li>
			<li>
				<p>
					<label><?php _e('Nivo Slider','wpdance');?> : 
						<select name="page_nivo" id="page_nivo_id">

						<?php 
							$_flex_slider = wd_get_all_post_list('slide');
							foreach( $_flex_slider as $_slide ){
						?>	
						
							<option value="<?php echo $_slide[0];?>" <?php if( $_slide[0] == (int)$datas['page_nivo'] ) echo "selected";?>><?php echo $_slide[1];?></option>
						
						<?php	
							}
						?>						
						
						</select>
					</label>
				</p> 			
			</li>			
			<li>
				<p>
					<label><?php _e('Product Slider','wpdance');?> : 
					<?php
						$tags = get_terms( array('product_tag') );
						$html = '<select class="product_tag" name="product_tag">';
						$selectedStr = '';
						foreach ($tags as $index => $tag){
							$tagSlug = $tag->slug ;
							if( !isset($datas['product_tag']) )
								$datas['product_tag'] = 'all-product-tags';
							$selectedStr = strcmp(esc_html($datas['product_tag']),$tagSlug) == 0 ? "selected" : '';	
							if( $index == 0 ){
								$html .= "<option value='all-product-tags' {$selectedStr}>All Tags</option>";
							}
							
							$html .= "<option value='{$tagSlug}' {$selectedStr}>";
							$html .= "{$tag->name}</option>";
						}
						$html .= '</select>';
						echo $html; 
					?>		
					</label>
				</p> 			
			</li>
			<?php $c_template = get_post_meta( $post->ID, '_wp_page_template', true ); 
				$tp_selected = 'style="display:none;"';
				if($c_template == 'page-templates/portfolio-template.php'){
					$tp_selected = '';
				} else {
					$datas['portfolio_columns'] = 1;
				}
			?>
			<li class="last portfolio_columns" <?php echo $tp_selected; ?>>
				<p>
					<label><?php _e('Columns(For Portfolio Template)','wpdance');?> : 
						<select name="portfolio_columns" id="portfolio_columns">
							<option value="2" <?php if( absint($datas['portfolio_columns']) == 2 ) echo "selected";?>>2 Columns</option>
							<option value="3" <?php if( absint($datas['portfolio_columns']) == 3 ) echo "selected";?>>3 Columns</option>
							<option value="4" <?php if( absint($datas['portfolio_columns']) == 4 ) echo "selected";?>>4 Columns</option>
						</select>
					</label>
				</p> 	
				<p>	
					<label><?php _e('Filterable(For Portfolio Template)','wpdance');?> : 
						<select name="portfolio_filter" id="portfolio_filter">
						<option value="1" <?php if( absint($datas['portfolio_filter']) == 1 ) echo "selected";?>>Yes</option>
						<option value="0" <?php if( absint($datas['portfolio_filter']) == 0 ) echo "selected";?>>No</option>
						</select>
					</label>
				</p>			
			</li>
			
			<li class="last">
				<p>
					<label><?php _e('Hide Breadcrumb','wpdance');?> : 
						<select name="hide_breadcrumb" id="_hide_breadcrumb">
							<option value="0" <?php if( absint($datas['hide_breadcrumb']) == 0 ) echo "selected";?>>No</option>
							<option value="1" <?php if( absint($datas['hide_breadcrumb']) == 1 ) echo "selected";?>>Yes</option>
						</select>
					</label>
				</p> 			
			</li>
			<li class="last">
				<p>
					<label><?php _e('Hide Page Title','wpdance');?> : 
						<select name="hide_title" id="_hide_title">
							<option value="0" <?php if( absint($datas['hide_title']) == 0 ) echo "selected";?>>No</option>
							<option value="1" <?php if( absint($datas['hide_title']) == 1 ) echo "selected";?>>Yes</option>
						</select>
					</label>
				</p> 			
			</li>
			<!--<li class="last">
				<p>
					<label><?php _e('Hide Header Advertisement','wpdance');?> : 
						<select name="hide_ads" id="_hide_ads">
							<option value="0" <?php //if( absint($datas['hide_ads']) == 0 ) echo "selected";?>>No</option>
							<option value="1" <?php //if( absint($datas['hide_ads']) == 1 ) echo "selected";?>>Yes</option>
						</select>
					</label>
				</p> 			
			</li>	-->	
			<li class="last">
				<p>
					<label><?php _e('Toggle Vertical Menu','wpdance');?> : 
						<select name="toggle_vertical_menu" id="_toggle_vertical_menu">
							<option value="1" <?php if( absint($datas['toggle_vertical_menu']) == 1 ) echo "selected";?>>Yes</option>
							<option value="0" <?php if( absint($datas['toggle_vertical_menu']) == 0 ) echo "selected";?>>No</option>
						</select>
					</label>
				</p> 			
			</li>			
			<li class="last">
				<p>
					<label><?php _e('Hide Header Widget Area','wpdance');?> : 
						<select name="hide_slider_hot_product" id="_hide_slider_hot_product">
							<option value="1" <?php if( absint($datas['hide_slider_hot_product']) == 1 ) echo "selected";?>>Yes</option>
							<option value="0" <?php if( absint($datas['hide_slider_hot_product']) == 0 ) echo "selected";?>>No</option>
						</select>
					</label>
				</p> 			
			</li>
		</ul>
	</div>
</div>
