<?php 
if(!function_exists ('button')){
	function button($atts,$content){
		extract(shortcode_atts(array(
			'size'			=>	'',
			'color'			=>	'',
			'type' 			=>  '',
			//'shadow'		=>	'',
			'custom_class'	=>	'',
			//'color_hover'	=>	'',
			//'type'			=>	'button',
			'link'			=>	'',
			'background'	=>	'yes',
			'opacity'		=>	'boldest',	
			//'color_text'	=>	''	
		),$atts));
		
		$sizes_arr = array(
			'primary' => 'btn-primary'
			,'danger' => 'btn-danger'
			,'warning' => 'btn-warning'	
			,'success' => 'btn-success'
			,'info' => 'btn-info'	
			,'inverse' => 'btn-inverse'		
		);
		
		$color_arr = array (
			'white' => 'btn-white'
			,'blue' => 'btn-blue'
			,'orange' => 'btn-orange'
			,'yellow' => 'btn-yellow'
			,'green' => 'btn-green'
			,'indigo' => 'btn-indigo'
			,'aqua'	=> 'btn-aqua'	
			,'black'=> 'btn-black'
			,'dodgerblue' => 'btn-dodgerblue'
		);
		
		
		$types_arr = array(
			'largest' => 'btn-largest'
			,'large' => 'btn-large'
			,'medium' => 'btn-medium'
			,'small' => 'btn-small'
			,'mini' => 'btn-mini'
		);
		
		$size = (!empty($size)) ? "btn-{$size}" : '';
		$type = (!empty($type)) ? "btn-{$type}" : '';
		$color = (!empty($color)) ? "{$color}" : '';
		$background = (!empty($background)) ? "btn-background-{$background}" : '';
		$opacity = (!empty($opacity)) ? "btn-{$opacity}" : '';
		//$link = ( strlen($link) > 0 ) ? $link : 'javascript:void(0)';
		$custom_class = (!empty($custom_class)) ? " {$custom_class}" : '';
		if( strlen($link) > 0 ){
			return "<a href='$link' class='btn {$custom_class} {$type} {$color} {$size} {$background} {$opacity}'>".do_shortcode($content)."</a>";
		}
		return "<button class='btn {$custom_class} {$type} {$color} {$size} {$background} {$opacity}'>".do_shortcode($content)."</button>";	
	}
}
add_shortcode('button','button');


if(!function_exists ('button_group')){
	function button_group($atts,$content){
		extract(shortcode_atts(array(
			'vertical' => 0
		),$atts));
		$_vertical = '';
		if( $vertical == 1 )
			$_vertical = " btn-group-vertical";
			
		return "<div class='btn-toolbar'><div class='btn-group{$_vertical}'>".do_shortcode($content)."</div></div>";
	}
}
add_shortcode('button_group','button_group');
?>