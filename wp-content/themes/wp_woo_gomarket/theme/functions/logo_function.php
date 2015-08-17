<?php 
	function theme_logo(){
		global $wd_data;
		$logo = strlen(trim($wd_data['wd_logo'])) > 0 ? esc_url($wd_data['wd_logo']) : '';
		$default_logo = get_template_directory_uri()."/images/logo.png";
		$textlogo = stripslashes(esc_attr($wd_data['wd_text_logo']));

		//if(is_home() || is_front_page()) {?>
		<h1 class="logo heading-title">
		<?php if( strlen( trim($logo) ) > 0 ){?>
				<a href="<?php  echo home_url();?>"><img src="<?php echo $logo;?>" alt="<?php echo $textlogo ? $textlogo : get_bloginfo('name');?>" title="<?php echo $textlogo ? $textlogo : get_bloginfo('name');?>"/></a>	
		<?php } else {
			if($textlogo){
			?>
				<a href="<?php  echo home_url();?>" title="<?php echo $textlogo;?>"><?php echo $textlogo;?></a>		
			<?php }else{ ?>
				<a href="<?php  echo home_url();?>"><img src="<?php echo $default_logo; ?>"  alt="<?php echo get_bloginfo('name');?>" title="<?php echo get_bloginfo('name');?>"/></a>
			<?php
			}
		}?>	
		</h1>
	<?php /*} else { ?>
		<span class="logo">
			<?php if( strlen( trim($logo) ) > 0 ){?>
				<a href="<?php  echo home_url();?>"><img src="<?php echo $logo;?>" alt="<?php echo $textlogo ? $textlogo : get_bloginfo('name');?>"  title="<?php echo $textlogo ? $textlogo : get_bloginfo('name');?>"/></a>	
			<?php } else {
				if($textlogo){
			?>
					<a href="<?php  echo home_url();?>" title="<?php echo $textlogo;?>"><?php echo $textlogo;?></a>		
			<?php }else{?>
					<a href="<?php  echo home_url();?>"><img src="<?php echo $default_logo; ?>"  alt="<?php echo get_bloginfo('name');?>" title="<?php echo get_bloginfo('name');?>" /></a>
			<?php  }
			} ?>
		</span>
	<?php }
	*/
	}
	
	function theme_icon(){
		global $wd_data;
		$icon = $wd_data['wd_icon'];
		if( strlen(trim($icon)) > 0 ):?>
			<link rel="shortcut icon" href="<?php echo esc_url($icon);?>" />
		<?php endif;
	}
?>