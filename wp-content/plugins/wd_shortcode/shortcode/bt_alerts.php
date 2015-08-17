<?php 
if(!function_exists ('alert')){
	function alert($atts,$content){
		extract(shortcode_atts(array(
			'style' 			=>  '',
			'close'			=>  1
		),$atts));
		
		$close_html = $close == 1 ? '<button class="close" type="button" data-dismiss="alert">&times;</button>' : '';
		$style = (!empty($style)) ? " alert-{$style}" : '';
		return "<div class='alert{$style}'>{$close_html}".do_shortcode($content)."</div>";	
	}
}
add_shortcode('alert','alert');
?>