<?php

	if(!function_exists('banner_shortcode_function')){
		function banner_shortcode_function($atts,$content){
			extract(shortcode_atts(array(
				'link_url'				=> "#" 
				,'bg_image' 			=> ""
				,'bg_color'				=> "none" 
				,'title'				=> "Big title goes here" 
				,'font_size_title'		=> "44" 
				,'title'				=> "Big title goes here"
				,'font_size_subtitle'	=> "18" 
				,'title_color'			=> "#fff" 
				,'subtitle'				=> "Subtitle goes here" 
				,'subtitle_color'		=> "#fff" 
				,'top_padding'			=> "40px" 
				,'left_padding'			=> "20px" 
				,'bottom_padding'		=> "20px" 
				,'right_padding'		=> "20px" 
				,'border_color' 		=> "#000"
				,'inner_stroke' 		=> "2px"
				,'inner_stroke_color' 	=> "#fff"				
				,'sep_color' 			=> "#fff"
				,'sep_padding'			=> "5px" 
				,'label'				=> "no"
				//,'label_bg_color'		=> "#000"
				,'label_text_color'		=> "#fff" 
				,'label_text' 			=> "Label Text"		
				,'label_top'			=> "10px"	
				,'label_right'			=> "10px"	
				,'box_shadow_color'		=> "rgba(0,0,0,0)"	
			),$atts));
			ob_start();
			?>
			
			<div class="shortcode_wd_banner" onclick="location.href='<?php echo $link_url;?>'" style="background-color:<?php echo $bg_color;?>; background-image:url('<?php echo $bg_image;?>')">
				<div class="shortcode_wd_banner_inner" style="padding:<?php echo $top_padding;?> <?php echo $right_padding;?> <?php echo $bottom_padding;?> <?php echo $left_padding;?>;  border: <?php echo $inner_stroke;?> solid <?php echo $inner_stroke_color;?>; box-shadow:0 0 100px <?php echo $box_shadow_color;?>;">
					
					<div><h4 class="heading-title banner-sub-title" style="font-size:<?php echo $font_size_subtitle;?>px;color:<?php echo $subtitle_color;?>; "><?php echo do_shortcode($subtitle);?></h4></div>
					
					<div><h3 class="heading-title banner-title" style="font-size:<?php echo $font_size_title;?>px;color:<?php echo $title_color;?>"><?php echo do_shortcode($title);?></h3></div>
				</div>
				<?php if( absint($label) == 1 || strcmp($label,'yes') == 0 || strcmp($label,'Yes') == 0 ):?>
					<div class="shortcode_banner_simple_bullet" style="top:<?php echo $label_top;?>; right:<?php echo $label_right;?>;  color:<?php echo $label_text_color;?>"><span><?php echo $label_text;?></span></div>
				<?php endif;?>
			</div>
					
			<?php
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}
	add_shortcode('banner','banner_shortcode_function');
?>