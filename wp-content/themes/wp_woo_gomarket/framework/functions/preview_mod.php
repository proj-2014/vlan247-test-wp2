<?php
	function font_string_to_font_obj( $font_name = "" ,$font_style_str = "" ,$font_size = "" ){
		if( strlen( $font_style_str ) > 0 ){
			$font_weight = strcmp( $font_style_str,'regular' ) == 0 ? '400' : $font_style_str;
			$font_weight = strcmp( $font_style_str,'italic' ) == 0 ? '400italic' : $font_style_str;
			$font_style = strpos($font_weight, 'italic') == false ? 'normal' : 'italic';
			$font_weight = str_replace( "italic", "", $font_weight );
			return $ret = array(
								"font_name" => $font_name
								,"font_weight" => $font_weight
								,"font_style" => $font_style
								,"font_size" => $font_size
							);
		}
		return $ret = array(
							"font_name" => $font_name
							,"font_weight" => ""
							,"font_style" => ""
							,"font_size" => $font_size		
		);
	}

		

	$wd_custom_style_config = get_option(THEME_SLUG.'custom_style_config','');
	$wd_custom_style_config = unserialize($wd_custom_style_config);
	if( !is_array($wd_custom_style_config) ){
		$wd_custom_style_config = array();
	}
	$wd_custom_style_config = wd_array_atts_str($default_custom_style_config,$wd_custom_style_config);	
	
	
	add_action('wp_ajax_nopriv_wd_ajax_style', 'ajax_save_style');
	add_action('wp_ajax_wd_ajax_style', 'ajax_save_style');
	
	function ajax_save_style(){
		if(	! is_user_logged_in() ){
			die('You do not have sufficient permissions to do this action.');
		}else{
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to do this action.','wpdance' ) );
			}else{
				//TODO : check nonce & do font save
				if ( empty($_POST) || !wp_verify_nonce($_POST['ajax_preview'],'ajax_save_style') ){
					wp_die( __( 'Something goes wrong!Please login again','wpdance' ) );
				}else{
				   // process form data
					$_default_font_arr = array("arial","verdana","trebuchet","georgia","times new roman","tahoma","palatino","helvetica");
					global $wd_data;						
					
					if( isset($_POST['@font_body']) && strlen(trim($_POST['@font_body'])) > 0 ){
						if( in_array( trim($_POST['@font_body']) , $_default_font_arr)  ){
							$wd_data['wd_body_font1_googlefont_enable'] = 1;
							$wd_data['wd_body_font1_family'] = wp_kses_data($_POST['@font_body']) ;
						}else{
							$wd_data['wd_body_font1_googlefont_enable'] = 0;
							$wd_data['wd_body_font1_googlefont'] = wp_kses_data($_POST['@font_body']) ;
						}
					}
					
					if( isset($_POST['@font_verticalmenu']) && strlen(trim($_POST['@font_verticalmenu'])) > 0 ){
						if( in_array( trim($_POST['@font_verticalmenu']) , $_default_font_arr)  ){
							$wd_data['wd_vertical_menu_font_enable'] = 1;
							$wd_data['wd_vertical_menu_family_font'] = wp_kses_data($_POST['@font_verticalmenu']) ;
						}else{
							$wd_data['wd_vertical_menu_font_enable'] = 0;
							$wd_data['wd_vertical_menu_googlefont'] = wp_kses_data($_POST['@font_verticalmenu']) ;
						}
					}
					
					if( isset($_POST['@font_heading']) && strlen(trim($_POST['@font_heading'])) > 0 ){
						if( in_array( trim($_POST['@font_heading']) , $_default_font_arr)  ){
							$wd_data['wd_heading_font_googlefont_enable'] = 1;
							$wd_data['wd_heading_fontfamily']= wp_kses_data($_POST['@font_heading']) ;
						}else{
							$wd_data['wd_heading_font_googlefont_enable'] = 0;
							$wd_data['wd_heading_font_googlefont'] = wp_kses_data($_POST['@font_heading']) ;
						}
					}
					
					if( isset($_POST['@font_horizontalmenu']) && strlen(trim($_POST['@font_horizontalmenu'])) > 0 ){
						if( in_array( trim($_POST['@font_horizontalmenu']) , $_default_font_arr)  ){
							$wd_data['wd_horizontal_menu_font_googlefont_enable'] = 1;
							$wd_data['wd_menu_fontfamily'] = wp_kses_data($_POST['@font_horizontalmenu']) ;
						}else{
							$wd_data['wd_horizontal_menu_font_googlefont_enable'] = 0;
							$wd_data['wd_menu_font_googlefont'] = wp_kses_data($_POST['@font_horizontalmenu']) ;
						}
					}
					
					$wd_data['wd_layout_styles'] 	= strlen( $_POST['wd_layout_styles'] ) > 0 	? wp_kses_data($_POST['wd_layout_styles']) 	: $wd_data['wd_layout_styles'];
					
					foreach( $_POST as $_key => $_value ){
						if( strpos( $_key,'@' ) == 0 && strpos( $_key,'@' ) !== false ){
							$_old_key = 'wd_'.substr( $_key , 1 , strlen($_key) - 1 );
							if( array_key_exists( $_old_key ,$wd_data) ){
								$wd_data[$_old_key] = strlen( $_POST[$_key] ) > 0 	? wp_kses_data($_POST[$_key]) 	: $wd_data[$_old_key];
							}
						}
					}
					of_save_options( $wd_data );
						
					wp_die( "1" );
				}
			}
			
		}
	
	}
	

	function previewPanel(){
	/***************Start font block****************/
	
	//$api_key = get_option(THEME_SLUG.'googlefont_api_key','AIzaSyAP4SsyBZEIrh0kc_cO9s90__r2oCJ8Rds');
	$api_key = get_option(THEME_SLUG.'googlefont_api_key','AIzaSyBVL7XGnZp8r-e0Xgr8pBo4kh6974i7bQA');
	$google_font_url = "https://www.googleapis.com/webfonts/v1/webfonts?key=".$api_key;
	
	global $wd_data;	
		//print_r($wd_data);
	?>
	
		<div id="wd-control-panel" class="default-font hidden-phone">
			<div id="control-panel-main">
						<a id="wd-control-close" href="#"></a>			
			<div class="accordion" id="review_panel_accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#review_panel_accordion" href="#collapse_layout">
							<h2 class="wd-preview-heading">Layout Style</h2>
						</a>
					</div>
					<div id="collapse_layout" class="accordion-body collapse in">
						<div class="accordion-inner">
							<select name="page_layout" id="_page_layout" class="page_layout">
								<option value="wide" <?php if( strcmp(esc_html($wd_data['wd_layout_styles']),'wide') == 0 ) echo 'selected="selected"';?>>Wide</option>
								<option value="box" <?php if( strcmp(esc_html($wd_data['wd_layout_styles']),'box') == 0 ) echo 'selected="selected"';?>>Box</option>
							</select>	
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#review_panel_accordion" href="#collapse_color">
							<h2 class="wd-preview-heading">Custom Color</h2>
						</a>
					</div>
					<div id="collapse_color" class="accordion-body collapse">
						<div class="accordion-inner">
							<div class="input-append color colorpicker6 colorpicker_theme_color" data-color="<?php echo esc_html($wd_data['wd_primary_color']); ?>" data-color-format="hex">
								<p class="custom-title">Primary Color</p>
								<input name="theme_color" id="theme_color" type="text" class="span2" value="<?php echo esc_html($wd_data['wd_primary_color']); ?>" >
								<span class="add-on"><i style="color: <?php echo esc_html($wd_data['wd_primary_color']); ?>"></i></span>
							</div>		

							<div class="input-append color colorpicker6 colorpicker_secondary_color" data-color="<?php echo esc_html($wd_data['wd_secondary_color']); ?>" data-color-format="hex">
								<p class="custom-title">Secondary Color</p>
								<input name="secondary_color" id="secondary_color" type="text" class="span2" value="<?php echo esc_html($wd_data['wd_secondary_color']); ?>" >
								<span class="add-on"><i style="color: <?php echo esc_html($wd_data['wd_secondary_color']); ?>"></i></span>
							</div>					
							
							<div class="input-append color colorpicker6 colorpicker_tertiary_color" data-color="<?php echo esc_html($wd_data['wd_tertiary_color']); ?>" data-color-format="hex">
								<p class="custom-title">Tertiary Color</p>
								<input name="tertiary_color" id="tertiary_color" type="text" class="span2" value="<?php echo esc_html($wd_data['wd_tertiary_color']); ?>" >
								<span class="add-on"><i style="color: <?php echo esc_html($wd_data['wd_tertiary_color']); ?>"></i></span>
							</div>
							
							<div class="input-append color colorpicker_header_top_color" data-color="<?php echo esc_html($wd_data['wd_header_top_background_color']); ?>" data-color-format="hex">
								<p class="custom-title">Top Header</p>
								<input name="header_top_color" id="header_top_color" type="text" class="span2" value="<?php echo esc_html($wd_data['wd_header_top_background_color']); ?>" >
								<span class="add-on"><i style="background-color: <?php echo esc_html($wd_data['wd_header_top_background_color']); ?>"></i></span>
							</div>
							
							<div class="input-append color colorpicker6 colorpicker_horizontal_menu_color" data-color="<?php echo esc_html($wd_data['wd_horizontal_menu_gradient_start_color']); ?>" data-color-format="hex">
								<p class="custom-title">Horizontal Menu Color</p>
								<input name="horizontal_menu_color" id="horizontal_menu_color" type="text" class="span2" value="<?php echo esc_html($wd_data['wd_horizontal_menu_gradient_start_color']); ?>" >
								<span class="add-on"><i style="background-color: <?php echo esc_html($wd_data['wd_horizontal_menu_gradient_start_color']); ?>"></i></span>
							</div>
							
							<div class="input-append color colorpicker6 colorpicker_vertical_menu_color" data-color="<?php echo esc_html($wd_data['wd_vertical_menu_control_gradient_start_color']); ?>" data-color-format="hex">
								<p class="custom-title">Vertical Menu Color</p>
								<input name="vertical_menu_color" id="vertical_menu_color" type="text" class="span2" value="<?php echo esc_html($wd_data['wd_vertical_menu_control_gradient_start_color']); ?>" >
								<span class="add-on"><i style="background-color: <?php echo esc_html($wd_data['wd_vertical_menu_control_gradient_start_color']); ?>"></i></span>
							</div>

							<div class="input-append color colorpicker_primary_button_color colorpicker" data-color="<?php echo esc_html($wd_data['wd_primary_button_gradient_start_color']); ?>" data-color-format="hex">
								<p class="custom-title">Primary Button</p>
								<input name="primary_button_color" id="primary_button_color" type="text" class="span2 colorpicker_control_rgba" value="<?php echo esc_html($wd_data['wd_primary_button_gradient_start_color']); ?>" >
								<span class="add-on"><i style="background-color: <?php echo esc_html($wd_data['wd_primary_button_gradient_start_color']); ?>"></i></span>
							</div>		
							
							<div class="input-append color colorpicker_secondary_button_color colorpicker" data-color="<?php echo esc_html($wd_data['wd_secondary_button_gradient_start_color']); ?>" data-color-format="hex">
								<p class="custom-title">Secondary Button</p>
								<input name="secondary_button_color" id="secondary_button_color" type="text" class="span2 colorpicker_control_rgba" value="<?php echo esc_html($wd_data['wd_secondary_button_gradient_start_color']); ?>" >
								<span class="add-on"><i style="background-color: <?php echo esc_html($wd_data['wd_secondary_button_gradient_start_color']); ?>"></i></span>
							</div>
							
							<div class="input-append color colorpicker_tertiary_button_color colorpicker" data-color="<?php echo esc_html($wd_data['wd_tertiary_button_background_color']); ?>" data-color-format="hex">
								<p class="custom-title">Tertiary Button</p>
								<input name="tertiary_button_color" id="tertiary_button_color" type="text" class="span2 colorpicker_control_rgba" value="<?php echo esc_html($wd_data['wd_tertiary_button_background_color']); ?>" >
								<span class="add-on"><i style="background-color: <?php echo esc_html($wd_data['wd_tertiary_button_background_color']); ?>"></i></span>
							</div>
							
							<div class="input-append color colorpicker_icon_color colorpicker" data-color="<?php echo esc_html($wd_data['wd_primary_icon_color']); ?>" data-color-format="hex">
								<p class="custom-title">Icon</p>
								<input name="icon_color" id="icon_color" type="text" class="span2 colorpicker_control_rgba" value="<?php echo esc_html($wd_data['wd_primary_icon_color']); ?>" >
								<span class="add-on"><i style="background-color: <?php echo esc_html($wd_data['wd_primary_icon_color']); ?>"></i></span>
							</div>
							
						</div>
					</div>
				</div>
	
	
	
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#review_panel_accordion" href="#collapse_font">
				<h2 class="wd-preview-heading">Custom Font</h2>
			</a>
		</div>
		<div id="collapse_font" class="accordion-body collapse">
			<div class="accordion-inner">					
				<div class="custom-body">
					<p class="custom-title">Body Font</p>
					<label for="textbody" id="textbody-contain">
						<select name="body_font" id="list_body_font">
						</select>
					</label>
				</div>
				
				<div class="custom-heading">
				
					<p class="custom-title">Heading Font</p>
					<label for="heading" id="textbody-contain">
						<select name="heading_font" id="list_heading_font">
						</select>
					</label>					
				</div>
				
				<div class="custom-menu">						
					<p class="custom-title">Horizontal Menu Font</p>
					<label for="menu" id="textbody-contain">
						<select name="menu_font" id="list_menu_font">
						</select>
					</label>											
				</div>
				
				<div class="custom-sub-menu">						
					<p class="custom-title">Vertical Menu Font</p>
					<label for="sub_menu" id="textbody-contain">
						<select name="sub_menu_font" id="list_sub_menu_font">
						</select>
					</label>					
				</div>
						
			</div>
		</div>
	</div>
	
	
	<?php global $_demo_mod ;$_demo_mod=1;?>	
	<?php if( $_demo_mod ): ?>	
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#review_panel_accordion" href="#collapse_textures">
				<h2 class="wd-preview-heading">Textures</h2>
			</a>
		</div>
		<div id="collapse_textures" class="accordion-body collapse">
			<div class="accordion-inner">

					<h2 class="wd-preview-heading">Custom Background (Support Box Layout Only)</h2>
					<hr/>					
					<div class="wd-background-wrapper">
						<p class="custom-title">Background Image</p>
						<?php
							$_base_path = get_template_directory_uri() . '/images/partern/';
							echo "<ul class='wd-background-patten'>";
							for( $i = 0 ; $i <= 10 ; $i++ ){
								$temp_class = '';
								$_cur_path = $_base_path."{$i}.png";
								if($i==0)
									$temp_class = ' class="active"';
								echo "<li".$temp_class."><img id='patten_{$i}' class='wd-background-patten-image' src='{$_cur_path}' title='patten {$i}' alt='patten {$i}'></li>";
							}
							echo "</ul>";
						?>
						
						<h2 class="wd-preview-heading">Backgrounds Color</h2>
						<div class="input-append color colorpicker1 colorpicker_background_color" data-color="#f5f5f5" data-color-format="hex">
							<input name="background_color" id="background_color" type="text" class="span2" value="#f5f5f5" >
							<span class="add-on"><i style="background-color: #f5f5f5"></i></span>
						</div>
						
					</div>					
			</div>
		</div>
	</div>	
	<?php endif; ?>	
</div>					
						
					<p class="button-save"><button class="btn btn-primary" data-loading-text="Saving..." id="font-save-btn" type="button">Save</button></p>
					<p class="button-clear"><button class="btn btn-primary" data-loading-text="Clearing..." id="font-clear-btn" type="button">Clear</button></p>
					
					<div id="preview-save-result" class="alert" style="display:none;">

					</div>

					<?php //TODO ?>
					<?php wp_nonce_field('ajax_save_style','preview_nonce_field'); ?>	
			</div>
		</div>
	<script type="text/javascript">
	//<![CDATA[
		function loadSelectedFont( font_name ){
			//console.log(font_name);
			if(  font_name.length > 0 ){
				jQuery('head').append("<link id='" + font_name + "' href='http://fonts.googleapis.com/css?family="+font_name.replace(/ /g,'+') +"' rel='stylesheet' type='text/css' />");
			}
		}

		function set_cookie(custom_datas){
			var json_object = JSON.stringify(custom_datas);
			var custom = [];
			if(custom_datas.length < 2883){
				jQuery.cookie("custom_datas",  JSON.stringify(custom_datas));
			} else {
				var number_cookie = parseInt(json_object.length / 2800) + 1;
				for(i = 0 ; i < number_cookie; i++){
					custom[i]= {}; 
				}
				var j = 0;
				var flag = 2800;
				jQuery.each(custom_datas, function(key, value) {
					custom[j][key] = value;
					if(JSON.stringify(custom[j]).length > flag){
						delete custom[j].key;
						flag = flag * 2;
						j++;
						custom[j][key] = value;
					}
					//console.log('key: ' + key + '\n' + 'value: ' + value);
				});
				for(i = 0; i<custom.length;i++){
					if(i==0){
						temp = '';
					} else {
						temp = '_'+i;
					}
					//console.log(custom[i]);
					jQuery.cookie("custom_datas"+temp,  JSON.stringify(custom[i]));
				}
			}
		}
		function get_number_cookie(custom_datas){
			var json_object = JSON.stringify(custom_datas);
			var number_cookie = parseInt(json_object.length / 2800) + 1;
			return number_cookie;
		}
		function get_from_cookie(number_cookie){
			var result = '';
			for(i = 0; i< number_cookie;i++){
				if(i==0){
					tempple = '';
				} else {
					tempple = '_' + i;
				}
				var temp = jQuery.cookie("custom_datas"+tempple);
				temp = temp.replace("{", "");
				temp = temp.replace("}", "");
				result = result + ',' + temp;
			}
			result = result.substring(1);
			result = '{' + result + '}';
			return result;
		}
		function remove_data_cookie(custom_datas){
			var number_cookie = get_number_cookie(custom_datas);
			for(i = 0; i< number_cookie;i++){
				if(i==0){
					tempple = '';
				} else {
					tempple = '_' + i;
				}
				jQuery.removeCookie("custom_datas"+tempple);
			}	
		}
		function set_color( selector_id,color_value ){
			jQuery(selector_id).find('input.span2').val(color_value);
			setTimeout(function(){
				jQuery(selector_id).find('i').eq(0).css('background-color',color_value);
			},1000);
		}		
		
	jQuery(document).ready(function() {
		jQuery.cookie.defaults = { path: '/', expires: 365 };
			<?php
				global $wd_data;

				foreach( $wd_data as $_key => $_value ){
					if(is_string($_value)){
						$wd_data[$_key] = strlen($_value) <= 0 ? "null" : $_value;
					}
				}
			?>
			custom_datas = {	"@font_body" : "<?php echo $font_name = $wd_data['wd_body_font1_googlefont_enable'] == 1 ? esc_attr( $wd_data['wd_body_font1_family'] ) : esc_attr( $wd_data['wd_body_font1_googlefont'] ) ?>"
								,"@font_horizontalmenu" : "<?php echo $font_name = $wd_data['wd_horizontal_menu_font_googlefont_enable'] == 1 ? esc_attr( $wd_data['wd_menu_fontfamily'] ) : esc_attr( $wd_data['wd_menu_font_googlefont'] ) ?>"
								,"@font_verticalmenu" : "<?php echo $font_name = $wd_data['wd_vertical_menu_font_enable'] == 1 ? esc_attr( $wd_data['wd_vertical_menu_family_font'] ) : esc_attr( $wd_data['wd_vertical_menu_googlefont'] ) ?>"
								,"@font_heading" : "<?php echo $font_name = $wd_data['wd_heading_font_googlefont_enable'] == 1 ? esc_attr( $wd_data['wd_heading_fontfamily'] ) : esc_attr( $wd_data['wd_heading_font_googlefont'] ) ?>"
								,"@font_horizontalmenu_submenu" : "<?php echo $font_name = $wd_data['wd_horizontal_submenu_font_googlefont_enable'] == 1 ? esc_attr( $wd_data['wd_submenu_fontfamily'] ) : esc_attr( $wd_data['wd_submenu_font_googlefont'] ) ?>"
								,"@font_verticalmenu_submenu":"<?php echo $font_name = $wd_data['wd_vertical_submenu_font_enable'] == 1 ? esc_attr( $wd_data['wd_vertical_submenu_family_font'] ) : esc_attr( $wd_data['wd_vertical_submenu_googlefont'] ) ?>"
								
								,"@primary_color" : "<?php echo esc_html($wd_data['wd_primary_color']);  ?>"
								,"@secondary_color" : "<?php echo esc_html($wd_data['wd_secondary_color']);  ?>"
								,"@tertiary_color" : "<?php echo esc_html($wd_data['wd_tertiary_color']);  ?>"

								// PRIMARY 

								,"@primary_text_color" : "<?php echo esc_html($wd_data['wd_primary_text_color']);  ?>"
								,"@primary_link_color" : "<?php echo esc_html($wd_data['wd_primary_link_color']);  ?>"
								,"@primary_link_color_hover" : "<?php echo esc_html($wd_data['wd_primary_link_color_hover']);  ?>"
								,"@primary_heading_color" : "<?php echo esc_html($wd_data['wd_primary_heading_color']);  ?>"
								,"@secondary_heading_color" : "<?php echo esc_html($wd_data['wd_secondary_heading_color']);  ?>"
								,"@primary_border_color" : "<?php echo esc_html($wd_data['wd_primary_border_color']);  ?>"
								,"@primary_border_color_hover" : "<?php echo esc_html($wd_data['wd_primary_border_color_hover']);  ?>"
								,"@primary_icon_color" : "<?php echo esc_html($wd_data['wd_primary_icon_color']);  ?>"
								,"@primary_button_gradient_start_color" : "<?php echo esc_html($wd_data['wd_primary_button_gradient_start_color']);  ?>"
								,"@primary_button_gradient_end_color" : "<?php echo esc_html($wd_data['wd_primary_button_gradient_end_color']);  ?>"
								,"@primary_button_border_color" : "<?php echo esc_html($wd_data['wd_primary_button_border_color']);  ?>"
								,"@primary_button_text_color" : "<?php echo esc_html($wd_data['wd_primary_button_text_color']);  ?>"
								,"@primary_button_hover_gradient_start_color" : "<?php echo esc_html($wd_data['wd_primary_button_hover_gradient_start_color']);  ?>"
								,"@primary_button_hover_gradient_end_color" : "<?php echo esc_html($wd_data['wd_primary_button_hover_gradient_end_color']);  ?>"
								,"@primary_button_hover_border_color" : "<?php echo esc_html($wd_data['wd_primary_button_hover_border_color']);  ?>"
								,"@primary_button_hover_text_color" : "<?php echo esc_html($wd_data['wd_primary_button_hover_text_color']);  ?>"
								,"@secondary_button_gradient_start_color" : "<?php echo esc_html($wd_data['wd_secondary_button_gradient_start_color']);  ?>"
								,"@secondary_button_gradient_end_color" : "<?php echo esc_html($wd_data['wd_secondary_button_gradient_end_color']);  ?>"
								,"@secondary_button_border_color" : "<?php echo esc_html($wd_data['wd_secondary_button_border_color']);  ?>"
								,"@secondary_button_text_color" : "<?php echo esc_html($wd_data['wd_secondary_button_text_color']);  ?>"
								,"@secondary_button_hover_gradient_start_color" : "<?php echo esc_html($wd_data['wd_secondary_button_hover_gradient_start_color']);  ?>"
								,"@secondary_button_hover_gradient_end_color" : "<?php echo esc_html($wd_data['wd_secondary_button_hover_gradient_end_color']);  ?>"
								,"@secondary_button_hover_border_color" : "<?php echo esc_html($wd_data['wd_secondary_button_hover_border_color']);  ?>"
								,"@sedondary_button_hover_text_color" : "<?php echo esc_html($wd_data['wd_sedondary_button_hover_text_color']);  ?>"
								,"@tertiary_button_background_color" : "<?php echo esc_html($wd_data['wd_tertiary_button_background_color']);  ?>"
								,"@tertiary_button_border_color" : "<?php echo esc_html($wd_data['wd_tertiary_button_border_color']);  ?>"
								,"@tertiary_button_text_color" : "<?php echo esc_html($wd_data['wd_tertiary_button_text_color']);  ?>"
								,"@tertiary_button_hover_background_color" : "<?php echo esc_html($wd_data['wd_tertiary_button_hover_background_color']);  ?>"
								,"@tertiary_button_hover_border_color" : "<?php echo esc_html($wd_data['wd_tertiary_button_hover_border_color']);  ?>"
								,"@tertiary_button_hover_text_color" : "<?php echo esc_html($wd_data['wd_tertiary_button_hover_text_color']);  ?>"
								,"@primary_tab_border_color" : "<?php echo esc_html($wd_data['wd_primary_tab_border_color']);  ?>"
								,"@primary_tab_text_color" : "<?php echo esc_html($wd_data['wd_primary_tab_text_color']);  ?>"
								,"@primary_tab_hover_text_color" : "<?php echo esc_html($wd_data['wd_primary_tab_hover_text_color']);  ?>"
								,"@primary_tab_active_gradient_start_color" : "<?php echo esc_html($wd_data['wd_primary_tab_active_gradient_start_color']);  ?>"
								,"@primary_tab_active_gradient_end_color" : "<?php echo esc_html($wd_data['wd_primary_tab_active_gradient_end_color']);  ?>"
								,"@primary_tab_active_text_color" : "<?php echo esc_html($wd_data['wd_primary_tab_active_text_color']);  ?>"
								,"@primary_accordion_border_color" : "<?php echo esc_html($wd_data['wd_primary_accordion_border_color']);  ?>"
								,"@primary_accordion_text_color" : "<?php echo esc_html($wd_data['wd_primary_accordion_text_color']);  ?>"
								,"@primary_accordion_gradient_start_color" : "<?php echo esc_html($wd_data['wd_primary_accordion_gradient_start_color']);  ?>"
								,"@primary_accordion_gradient_end_color" : "<?php echo esc_html($wd_data['wd_primary_accordion_gradient_end_color']);  ?>"
								,"@primary_accordion_hover_gradient_start_color" : "<?php echo esc_html($wd_data['wd_primary_accordion_hover_gradient_start_color']);  ?>"
								,"@primary_accordion_hover_gradient_end_color" : "<?php echo esc_html($wd_data['wd_primary_accordion_hover_gradient_end_color']);  ?>"

								// TOP HEADER 
								,"@header_top_background_color" : "<?php echo esc_html($wd_data['wd_header_top_background_color']);  ?>"
								,"@header_top_text_color" : "<?php echo esc_html($wd_data['wd_header_top_text_color']);  ?>"

								// HORIZONTAL 
								,"@horizontal_menu_gradient_start_color" : "<?php echo esc_html($wd_data['wd_horizontal_menu_gradient_start_color']);  ?>"
								,"@horizontal_menu_gradient_end_color" : "<?php echo esc_html($wd_data['wd_horizontal_menu_gradient_end_color']);  ?>"
								,"@horizontal_menu_border_color" : "<?php echo esc_html($wd_data['wd_horizontal_menu_border_color']);  ?>"
								,"@horizontal_menu_text_color" : "<?php echo esc_html($wd_data['wd_horizontal_menu_text_color']);  ?>"
								,"@horizontal_menu_text_color_hover" : "<?php echo esc_html($wd_data['wd_horizontal_menu_text_color_hover']);  ?>"
								,"@horizontal_menu_submenu_background_color" : "<?php echo esc_html($wd_data['wd_horizontal_menu_submenu_background_color']);  ?>"
								,"@horizontal_menu_submenu_border_color" : "<?php echo esc_html($wd_data['wd_horizontal_menu_submenu_border_color']);  ?>"
								,"@horizontal_menu_submenu_text_color" : "<?php echo esc_html($wd_data['wd_horizontal_menu_submenu_text_color']);  ?>"
								,"@horizontal_menu_submenu_text_color_hover" : "<?php echo esc_html($wd_data['wd_horizontal_menu_submenu_text_color_hover']);  ?>"

								// VERTICAL 
								,"@vertical_menu_control_gradient_start_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_control_gradient_start_color']);  ?>"
								,"@vertical_menu_control_gradent_end_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_control_gradent_end_color']);  ?>"
								,"@vertical_menu_control_border_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_control_border_color']);  ?>"
								,"@vertical_menu_control_text_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_control_text_color']);  ?>"
								,"@vertical_menu_background_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_background_color']);  ?>"
								,"@vertical_menu_text_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_text_color']);  ?>"
								,"@vertical_menu_text_color_hover" : "<?php echo esc_html($wd_data['wd_vertical_menu_text_color_hover']);  ?>"
								,"@vertical_menu_border_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_border_color']);  ?>"
								,"@vertical_menu_submenu_background_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_submenu_background_color']);  ?>"
								,"@vertical_menu_submenu_text_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_submenu_text_color']);  ?>"
								,"@vertical_menu_submenu_text_color_hover" : "<?php echo esc_html($wd_data['wd_vertical_menu_submenu_text_color_hover']);  ?>"
								,"@vertical_menu_submenu_border_color" : "<?php echo esc_html($wd_data['wd_vertical_menu_submenu_border_color']);  ?>"

								// SIDEBAR 
								,"@sidebar_text_color" : "<?php echo esc_html($wd_data['wd_sidebar_text_color']);  ?>"
								,"@sidebar_link_color" : "<?php echo esc_html($wd_data['wd_sidebar_link_color']);  ?>"
								,"@sidebar_link_color_hover" : "<?php echo esc_html($wd_data['wd_sidebar_link_color_hover']);  ?>"
								,"@sidebar_heading_color" : "<?php echo esc_html($wd_data['wd_sidebar_heading_color']);  ?>"
								,"@sidebar_border_color" : "<?php echo esc_html($wd_data['wd_sidebar_border_color']);  ?>"
								,"@sidebar_gradient_heading_start_color" : "<?php echo esc_html($wd_data['wd_sidebar_gradient_heading_start_color']);  ?>"
								,"@sidebar_gradient_heading_end_color" : "<?php echo esc_html($wd_data['wd_sidebar_gradient_heading_end_color']);  ?>"
								,"@sidebar_gradient_hover_heading_start_color" : "<?php echo esc_html($wd_data['wd_sidebar_gradient_hover_heading_start_color']);  ?>"
								,"@sidebar_gradient_hover_heading_end_color" : "<?php echo esc_html($wd_data['wd_sidebar_gradient_hover_heading_end_color']);  ?>"
								,"@sidebar_gradient_hover_text_color" : "<?php echo esc_html($wd_data['wd_sidebar_gradient_hover_text_color']);  ?>"

								// FOOTER 
								,"@footer_text_color" : "<?php echo esc_html($wd_data['wd_footer_text_color']);  ?>"
								,"@footer_link_color" : "<?php echo esc_html($wd_data['wd_footer_link_color']);  ?>"
								,"@footer_link_color_hover" : "<?php echo esc_html($wd_data['wd_footer_link_color_hover']);  ?>"
								,"@footer_heading_color" : "<?php echo esc_html($wd_data['wd_footer_heading_color']);  ?>"
								,"@footer_border_color" : "<?php echo esc_html($wd_data['wd_footer_border_color']);  ?>"

								//PRODUCTS
								,"@product_category_text_color" : "<?php echo esc_html($wd_data['wd_product_category_text_color']);  ?>"
								//,"@product_category_text_color_hover" : "<?php echo esc_html($wd_data['wd_product_category_text_color_hover']);  ?>"
								,"@product_price_color" : "<?php echo esc_html($wd_data['wd_product_price_color']);  ?>"
								,"@product_new_price_color" : "<?php echo esc_html($wd_data['wd_product_new_price_color']);  ?>"
								,"@product_old_price_color" : "<?php echo esc_html($wd_data['wd_product_old_price_color']);  ?>"
								
							};
			orgin_custom_datas = custom_datas;

			if ( jQuery.cookie("page_layout") !== undefined ){
				jQuery('#_page_layout').val(jQuery.cookie("page_layout"));
				jQuery('body').removeClass('wide box').addClass(jQuery.cookie("page_layout"));
			}
			if ( jQuery.cookie("bg_image") !== undefined ){
				jQuery('ul.wd-background-patten > li.active').removeClass('active');
				var _img_id = '#'+jQuery.cookie("bg_image");
				if( jQuery(_img_id).length > 0 ){
					jQuery('body').css( "background-image",'url("' + jQuery(_img_id).attr('src') + '")' );
					jQuery('body').css( "background-repeat","repeat" );	
					jQuery(_img_id).parent().addClass('active');
				}
			}			
			if ( jQuery.cookie("bg_color") !== undefined ){
				set_color( '.colorpicker_background_color',jQuery.cookie("bg_color") );
				jQuery('body').css('background-color',jQuery.cookie("bg_color"));	
			}			
			
			if ( jQuery.cookie("custom_datas") !== undefined ){
				var number_cookie = get_number_cookie(custom_datas);
				//custom_datas = jQuery.cookie("custom_datas");
				custom_datas = get_from_cookie(number_cookie);
				if( typeof custom_datas == 'string' ){
					custom_datas = jQuery.parseJSON(custom_datas);
					set_color('.colorpicker_theme_color',custom_datas['@primary_color']);
					set_color('.colorpicker_secondary_color',custom_datas['@secondary_color']);
					set_color('.colorpicker_tertiary_color',custom_datas['@tertiary_color']);
					

					set_color('.colorpicker_header_top_color',custom_datas['@header_top_background_color']);
					set_color('.horizontal_menu_color',custom_datas['@horizontal_menu_gradient_start_color']);
					set_color('.vertical_menu_color',custom_datas['@vertical_menu_control_gradient_start_color']);
					set_color('.colorpicker_icon_color',custom_datas['@primary_icon_color']);
					set_color('.colorpicker_primary_button_color',custom_datas['@primary_button_gradient_start_color']);
					set_color('.colorpicker_secondary_button_color',custom_datas['@secondary_button_gradient_start_color']);
					set_color('.colorpicker_tertiary_button_color',custom_datas['@tertiary_button_background_color']);
					//set_color('.colorpicker_text_color',custom_datas['@primary_text_color']);
					//set_color('.colorpicker_heading_color',custom_datas['@primary_heading_color']);

					
					loadSelectedFont(custom_datas['@font_body']);
					loadSelectedFont(custom_datas['@font_heading']);
					loadSelectedFont(custom_datas['@font_horizontalmenu']);
					loadSelectedFont(custom_datas['@font_verticalmenu']);
					
					jQuery('body').bind('font_load_success',function(){
						setTimeout(function(){
							jQuery('#list_body_font').val(custom_datas['@font_body']);
							jQuery('#list_heading_font').val(custom_datas['@font_heading']);
							jQuery('#list_menu_font').val(custom_datas['@font_horizontalmenu']);
							jQuery('#list_sub_menu_font').val(custom_datas['@font_verticalmenu']);
						},1000);						
					});

					less.modifyVars(custom_datas);
				}
			}	

			
					
			jQuery('ul.wd-background-patten > li > img.wd-background-patten-image').click(function(event){
				jQuery('ul.wd-background-patten > li.active').removeClass('active');
				$_src_img = jQuery(this).attr('src');
				jQuery('body').css( "background-image",'url("' + $_src_img + '")' );
				jQuery('body').css( "background-repeat","repeat" );		
				jQuery.cookie("bg_image", jQuery(this).attr('id'));
				jQuery(this).parent().addClass('active');
				if(jQuery(this).attr('id') == 'patten_0'){
					jQuery('.wd-background-wrapper .color').children('.add-on.default-style').hide();
					jQuery('.wd-background-wrapper .color').children('#background_color').prop('disabled', true);
				} else {
					jQuery('.wd-background-wrapper .color').children('.add-on.default-style').show();
					jQuery('.wd-background-wrapper .color').children('#background_color').prop('disabled', false);
				}
				event.preventDefault();
			});
			jQuery('#_page_layout').change(function(event){
				//less goes here
				jQuery('body').removeClass('wide').removeClass('box').addClass(jQuery(this).val());
				jQuery.cookie("page_layout", jQuery(this).val());
				
				if( jQuery('.slideshow-wrapper').length > 0 ){
					if( jQuery(this).val() == 'wide' ){
						jQuery('.slideshow-wrapper').removeClass('container').addClass('wide');
						jQuery('.slideshow-sub-wrapper').removeClass('span24').addClass('wide-wrapper');
					}	
					if( jQuery(this).val() == 'box' ){
						jQuery('.slideshow-wrapper').removeClass('wide').addClass('container');
						jQuery('.slideshow-sub-wrapper').removeClass('wide-wrapper').addClass('span24');
						jQuery('body').css('background-color',jQuery('input#background_color').val());	
						jQuery.cookie("bg_color", jQuery('input#background_color').val());	
						//jQuery('body').css('background-color',jQuery.cookie("bg_color"));	
						//#f5f0f0
						
					}	
					jQuery('body').trigger('resize');					
				}

			});		
	
	
			jQuery('#wd-control-panel').find('p,span,a,button,div,input,textarea,button').addClass('default-style');
			

			/******************START FONT LOADER*******************/
			font_config = new Array();
			var body_option_html,selected_body_font,selected_body_weight,body_font_weight_obj,heading_font_weight_obj,menu_font_weight_obj;
			var body_font_primary      	= 	"<?php echo $font_name = $wd_data['wd_body_font1_googlefont_enable'] == 1 ? esc_attr( $wd_data['wd_body_font1_family']) : esc_attr( $wd_data['wd_body_font1_googlefont'] ) ?>";
			var heading_font			=	"<?php echo $font_name = $wd_data['wd_heading_font_googlefont_enable'] == 1 ? esc_attr( $wd_data['wd_heading_fontfamily'] ) : esc_attr( $wd_data['wd_heading_font_googlefont'] ) ?>";			
			var horizontal_menu_font			=	"<?php echo $font_name = $wd_data['wd_horizontal_menu_font_googlefont_enable'] == 1 ? esc_attr( $wd_data['wd_menu_fontfamily'] ) : esc_attr( $wd_data['wd_menu_font_googlefont'] ) ?>";			
			var vertical_menu_font		=	"<?php echo $font_name = $wd_data['wd_vertical_menu_font_enable'] == 1 ? esc_attr( $wd_data['wd_vertical_menu_family_font'] ) : esc_attr( $wd_data['wd_vertical_menu_googlefont'] ) ?>";
			body_font_primary = jQuery.trim( body_font_primary );
			heading_font = jQuery.trim( heading_font );
			horizontal_menu_font = jQuery.trim( horizontal_menu_font );
			vertical_menu_font = jQuery.trim( vertical_menu_font );
				
			var _default_font_arr = new Array("arial","verdana","trebuchet","georgia","times","tahoma","palatino","helvetica");
			var _default_font = 	'<option value="arial">Arial</option>'
								+ 	'<option value="verdana">Verdana, Geneva</option>'
								+	'<option value="trebuchet">Trebuchet</option>'
								+	'<option value="georgia">Georgia</option>'
								+	'<option value="times new roman">Times New Roman</option>'
								+	'<option value="tahoma">Tahoma, Geneva</option>'
								+	'<option value="palatino">Palatino</option>'
								+	'<option value="helvetica">Helvetica</option>';
			

			jQuery.ajax("<?php echo esc_url($google_font_url); ?>", {
				data : { sort: "alpha" }
				,dataType: 'jsonp'
				,success : function(data){
					
					if( typeof(data) == 'string' ){
						data = JSON.parse(data);
					}
					option_html = "";
					//apend list font to select box,prepare data for font array object
					jQuery.each(data.items, function(i, obj) {
						font_config[obj.family] = new Array(
							new Array(obj.variants)
							,new Array(obj.subsets)
						);
						option_html = option_html + '<option value="'+obj.family+'" >' + obj.family + '</option>';
					});
					jQuery('#list_body_font').html(_default_font+option_html).val(body_font_primary);
					jQuery('#list_heading_font').html(_default_font+option_html).val(heading_font);
					jQuery('#list_menu_font').html(_default_font+option_html).val(horizontal_menu_font);					
					jQuery('#list_sub_menu_font').html(_default_font+option_html).val(vertical_menu_font);					
					
					jQuery('body').trigger('font_load_success');
					//end first font weigh
				}


			});

			
			//select another font,reload font weight
				jQuery('#list_body_font').change(function(event){
					if( jQuery(this).val() != 'Arial' ){
						
						loadSelectedFont(jQuery(this).val());
					}
					custom_datas['@font_body'] = jQuery(this).val();
					jQuery('body').trigger('less_update');
					//less goes here
				});

				jQuery('#list_heading_font').change(function(event){
					if( jQuery(this).val() != 'Arial' ){
						loadSelectedFont(jQuery(this).val());
					}
					custom_datas['@font_heading'] = jQuery(this).val();
					jQuery('body').trigger('less_update');
					//less goes here
				});	

				jQuery('#list_menu_font').change(function(event){
					if( jQuery(this).val() != 'Arial' ){
						loadSelectedFont(jQuery(this).val());
					}
					custom_datas['@font_horizontalmenu'] = jQuery(this).val();
					jQuery('body').trigger('less_update');
					//less goes here
				});					
				
				jQuery('#list_sub_menu_font').change(function(event){
					if( jQuery(this).val() != 'Source Sans Pro' ){
						loadSelectedFont(jQuery(this).val());
					}
					custom_datas['@font_verticalmenu'] = jQuery(this).val();
					jQuery('body').trigger('less_update');
					//less goes here
				});	
		/******************END FONT LOADER*******************/

		/******************START COLOR PICKER*******************/
		// color picker1 - Theme color
		$body_bg_picker = jQuery('.colorpicker_theme_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@primary_color'] = ev.color.toHex();
			custom_datas['@primary_link_color'] = ev.color.toHex();
			custom_datas['@primary_heading_color'] = ev.color.toHex();
			custom_datas['@tertiary_button_text_color'] = ev.color.toHex();
			custom_datas['@primary_tab_active_text_color'] = ev.color.toHex();
			custom_datas['@primary_accordion_text_color'] = ev.color.toHex();
			custom_datas['@vertical_menu_control_text_color'] = ev.color.toHex();
			custom_datas['@vertical_menu_text_color'] = ev.color.toHex();
			custom_datas['@vertical_menu_text_color_hover'] = ev.color.toHex();
			custom_datas['@vertical_menu_text_color_hover'] = ev.color.toHex();
			custom_datas['@sidebar_link_color'] = ev.color.toHex();
			custom_datas['@sidebar_heading_color'] = ev.color.toHex();
			custom_datas['@sidebar_gradient_hover_text_color'] = ev.color.toHex();
			custom_datas['@footer_heading_color'] = ev.color.toHex();
			jQuery('body').trigger('less_update');
		});

		// color picker1 - Theme color 2
		$secondary_bg_picker = jQuery('.colorpicker_secondary_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@secondary_color'] = ev.color.toHex();
			custom_datas['@primary_link_color_hover'] = ev.color.toHex();
			custom_datas['@primary_tab_hover_text_color'] = ev.color.toHex();
			custom_datas['@horizontal_menu_submenu_text_color_hover'] = ev.color.toHex();
			custom_datas['@vertical_menu_submenu_text_color_hover'] = ev.color.toHex();
			jQuery('body').trigger('less_update');
		});		
		
		// color picker1 - Theme color 3
		$tertiary_bg_picker = jQuery('.colorpicker_tertiary_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@tertiary_color'] = ev.color.toHex();
			custom_datas['@secondary_heading_color'] = ev.color.toHex();
			custom_datas['@sidebar_link_color_hover'] = ev.color.toHex();
			custom_datas['@footer_link_color'] = ev.color.toHex();
			custom_datas['@footer_link_color_hover'] = ev.color.toHex();
			jQuery('body').trigger('less_update');
		});		
		
		$background_bg_picker = jQuery('.colorpicker_background_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			jQuery('body').css('background-color',ev.color.toHex());	
			jQuery.cookie("bg_color", ev.color.toHex());			
		});
		
		$header_top_bg_picker = jQuery('.colorpicker_header_top_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@header_top_background_color'] = ev.color.toHex();
			jQuery('body').trigger('less_update');
		});
		// color picker3 - horizontal_menu_color
		$horizontal_menu_color_picker = jQuery('.colorpicker_horizontal_menu_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@horizontal_menu_gradient_start_color'] = ev.color.toHex();
			var temp = parseInt(ev.color.toHex().substr(1), 16) - parseInt('1c1e15', 16);
			temp = temp.toString(16);
			custom_datas['@horizontal_menu_gradient_end_color'] = "#"+temp;
			custom_datas['@vertical_menu_control_border_color'] =  ev.color.toHex();
			var temp2 = parseInt(ev.color.toHex().substr(1), 16) - parseInt('101007', 16);
			temp2 = temp2.toString(16);
			custom_datas['@horizontal_menu_border_color'] = "#"+temp2;
			jQuery('body').trigger('less_update');
		});
		
		// color picker4 - vertical_menu_color
		$vertical_menu_color_picker = jQuery('.colorpicker_vertical_menu_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@vertical_menu_control_gradient_start_color'] = ev.color.toHex();	
			var temp = parseInt(ev.color.toHex().substr(1), 16) - parseInt('161616', 16);
			temp = temp.toString(16);
			custom_datas['@vertical_menu_control_gradient_end_color'] = "#"+temp;
			custom_datas['@vertical_menu_control_border_color'] = custom_datas['@horizontal_menu_gradient_start_color'];
			jQuery('body').trigger('less_update');			
		});
		
		// color picker4 - colorpicker_footer_first_color
		$text_picker = jQuery('.colorpicker_icon_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@primary_icon_color'] = ev.color.toHex();	
			jQuery('body').trigger('less_update');			
		});
		
		// color picker4 - colorpicker_primary_button_color
		$primary_button_picker = jQuery('.colorpicker_primary_button_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@primary_button_gradient_start_color'] = ev.color.toHex();	
			custom_datas['@primary_button_hover_gradient_end_color'] = ev.color.toHex();
			var temp = (parseInt(ev.color.toHex().substr(1), 16) - parseInt('161616', 16)).toString(16);		
			custom_datas['@primary_button_gradient_end_color'] = "#"+temp;
			custom_datas['@primary_button_hover_gradient_start_color'] = "#"+temp;
			var temp2 = (parseInt(ev.color.toHex().substr(1), 16) - parseInt('2f2f2f', 16)).toString(16);
			custom_datas['@primary_button_border_color'] = "#"+temp2;
			custom_datas['@primary_button_hover_border_color'] = "#"+temp2;	
			jQuery('body').trigger('less_update');			
		});
		
		// color picker4 - colorpicker_secondary_button_color
		$secondary_button_picker = jQuery('.colorpicker_secondary_button_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@secondary_button_gradient_start_color'] = ev.color.toHex();	
			custom_datas['@secondary_button_hover_gradient_end_color'] = ev.color.toHex();
			var temp = (parseInt(ev.color.toHex().substr(1), 16) - parseInt('1c1e15', 16)).toString(16);
			custom_datas['@secondary_button_gradient_end_color'] = "#"+temp;	
			custom_datas['@secondary_button_gradient_end_color'] = "#"+temp;	
			var temp2 = (parseInt(ev.color.toHex().substr(1), 16) - parseInt('101007', 16)).toString(16);
			custom_datas['@secondary_button_border_color'] = "#"+temp2;
			custom_datas['@secondary_button_hover_border_color'] = "#"+temp2;
			jQuery('body').trigger('less_update');			
		});
		
		// color picker4 - colorpicker_tertiary_button_color
		$tertiary_button_picker = jQuery('.colorpicker_tertiary_button_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@tertiary_button_background_color'] = ev.color.toHex();
			var temp2 = (parseInt(ev.color.toHex().substr(1), 16) - parseInt('404040', 16)).toString(16);
			custom_datas['@tertiary_button_border_color'] = "#"+temp2;
			custom_datas['@tertiary_button_hover_background_color'] = "#"+temp2;	
			custom_datas['@tertiary_button_hover_border_color'] = "#"+temp2;	
			jQuery('body').trigger('less_update');			
		});
		
		/******************END COLOR PICKER*******************/

		
	
		jQuery('body').bind('less_update',jQuery.debounce( 250, function(){	
			less.modifyVars(custom_datas);	
			set_cookie(custom_datas);
			//jQuery.cookie("custom_datas", JSON.stringify(custom_datas));	
			
			var static_content_width = jQuery('.static_content').width();
			
			var _container_offet = jQuery('.static_content').offset();
			setTimeout(function(){
				jQuery('#menu-main-menu').children('.menu-item-level0.wd-mega-menu.fullwidth-menu,.menu-item-level0.wd-mega-menu.columns-6').each(function(index,value){
					var _cur_offset = jQuery(value).offset();
					var _margin_left = _cur_offset.left - _container_offet.left ;
					_margin_left = _margin_left - (jQuery('.static_content').outerWidth() - jQuery('.static_content').width() ) /2 - 1;
					jQuery(value).children('ul.sub-menu').css('width',jQuery('.static_content').width()).css('margin-left','-'+_margin_left+'px');
				});	
				jQuery('#menu-vertical-menu').children('.menu-item-level0.wd-mega-menu.fullwidth-menu,.menu-item-level0.wd-mega-menu.columns-6').each(function(index,value){
					var _cur_offset = jQuery(value).offset();
					jQuery(value).children('ul.sub-menu').css('width',jQuery('.static_content').width()+22);
					
				});
			},3000);			
		}));
	
		/******************START PANEL CONTROLLER*******************/
		
			// open and close custom panel
			var $et_control_panel = jQuery('#wd-control-panel'),
			$et_control_close = jQuery('#wd-control-close');

			$et_control_panel.animate( { left: -$et_control_panel.outerWidth() } );
			
			$et_control_close.click(function(){
				if ( jQuery(this).hasClass('control-open') ) {
					$et_control_panel.animate( { left: -jQuery("#wd-control-panel").outerWidth() } );
					jQuery(this).removeClass('control-open');
					jQuery.cookie('et_aggregate_control_panel_open', 0);
				} else {
					$et_control_panel.animate( { left: 0 } );
					jQuery(this).addClass('control-open');
					jQuery.cookie('et_aggregate_control_panel_open', 1);
				}
				return false;
			});
			if ( jQuery.cookie('et_aggregate_control_panel_open') == 1 ) { 
				$et_control_panel.animate( { left: 0 } );
				$et_control_close.addClass('control-open');
			}else{
				$et_control_panel.animate( { left: -jQuery("#wd-control-panel").outerWidth() } );
				$et_control_close.removeClass('control-open');
			}			
		/******************END PANEL CONTROLLER*******************/
		
		/******************START AJAX SAVE CONFIG*******************/
		jQuery('#font-clear-btn').click(function(event){
			//jQuery.removeCookie("custom_datas");
			remove_data_cookie(custom_datas);
			jQuery.removeCookie("page_layout");
			jQuery.removeCookie("bg_image");
			jQuery.removeCookie("bg_color");
			jQuery.removeCookie("body_font_style_str");
			jQuery.removeCookie("heading_font_style_str");
			jQuery.removeCookie("horizontal_menu_font_style_str");
			jQuery.removeCookie("vertical_menu_font_style_str");
			jQuery('body').css( "background-image",'' );
			jQuery('body').css( "background-color","#ffffff" );		

			//jQuery('#_page_layout').val('<?php echo esc_html($style_datas['page_layout']);?>').trigger('change');
			jQuery('ul.wd-background-patten > li.active').removeClass('active');
			
			custom_datas = orgin_custom_datas;
			setTimeout(function(){
				jQuery('#list_body_font').val(custom_datas['@font_body']);
				jQuery('#list_heading_font').val(custom_datas['@font_heading']);
				jQuery('#list_menu_font').val(custom_datas['@font_horizontalmenu']);
				jQuery('#list_sub_menu_font').val(custom_datas['@font_verticalmenu']);
			},1000);			
			
			less.modifyVars(custom_datas);
		});
		
		
			jQuery('#font-save-btn').click(function(event){
				
				var current_btn = jQuery(this);
				current_btn.button('loading');
			
				var ajax_data =  {
						//action
						action  				: 'wd_ajax_style'
						//verify nonce
						,ajax_preview			: jQuery('#preview_nonce_field').val()
						,page_layout 			: jQuery('#_page_layout').val()
				};			
				ajax_data = jQuery.extend(ajax_data, custom_datas);
				
				
				//console.log(ajax_data);
				jQuery.ajax({
					type  :'POST'
					,url   : '<?php echo admin_url('admin-ajax.php'); ?>'
					,data  : ajax_data
					,success : function(data){
						//console.log(data);
						if( parseInt(data) == 1 ){
							jQuery('#preview-save-result').html('Success').attr('class','alert alert-success').show()//.wait(3000).hide();
							setTimeout(								
								function(){
									jQuery('#preview-save-result').hide();
								},3000);
						}else{
							jQuery('#preview-save-result').html('You must login as administrator to save changes').attr('class','alert alert-error').show()//.wait(3000).hide();
							setTimeout(	
								function(){
									jQuery('#preview-save-result').hide();
								},3000);
						}	
						current_btn.button('reset');
					}			
				}).fail(function(){
					current_btn.button('reset');
				});
			});		

		
		
		/******************END AJAX SAVE CONFIG*******************/	

	});
	//]]>
	</script>	
	<?php
		
	}
?>