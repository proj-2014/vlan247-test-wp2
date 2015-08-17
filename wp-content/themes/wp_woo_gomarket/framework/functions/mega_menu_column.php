<?php
if(!function_exists ('wd_mega_menu_column')){
	function wd_mega_menu_column(){
		if(!isset($_POST['vertical_one_column'])){
			return;
		}
		$menu_file = THEME_CSS.'menu.less';
		try{
			ob_start();
			?>	
			@vertical_one_column_width:<?php echo $_POST['vertical_one_column'];?>px;
			@vertical_two_column_width:((@vertical_one_column_width)*2);
			@vertical_three_column_width:((@vertical_one_column_width)*3);
			@vertical_fourth_column_width:((@vertical_one_column_width)*4);
						
			.vertical-menu > .menu > li.columns-2 > ul.sub-menu {
				width:@vertical_two_column_width;
			}

			.vertical-menu > .menu > li.columns-3 > ul.sub-menu {
				width:@vertical_three_column_width;
			}

			.vertical-menu > .menu > li.columns-4 > ul.sub-menu {
				width:@vertical_fourth_column_width;
			}	
	<?php		
			$file = @fopen($menu_file, 'w');
			if( $file != false ){
				@fwrite($file, ob_get_contents()); 
				@fclose($file); 
				return 1;
			} else {
				return;
			}	
			ob_end_clean();
		}catch(Excetion $e){
			return -1;
		}
	}
}
add_action( 'wp_ajax_mega_menu_column', 'wd_mega_menu_column' );
?>