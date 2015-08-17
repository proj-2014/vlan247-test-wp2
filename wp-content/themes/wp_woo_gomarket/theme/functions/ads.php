<?php
/* Print ads in header */
if(!function_exists ('printHeaderAds')){
	function printHeaderAds(){
		$headerAdsType 		= get_option(THEME_SLUG.'headerAdsType');
		$headerAdsImg	 	= esc_url(get_option(THEME_SLUG.'headerAdsImg'));
		$headerAdsUrl 		= esc_url(get_option(THEME_SLUG.'headerAdsUrl'));
		$headerAdsTitle 	= stripslashes(esc_attr(get_option(THEME_SLUG.'headerAdsTitle')));
		$headerAdsCode 		= stripslashes(htmlspecialchars_decode(get_option(THEME_SLUG.'headerAdsCode')));
		$headerAdsEnable 	= get_option(THEME_SLUG.'headerAdsEnable');
		if( strcmp($headerAdsEnable,'Disable') == 0 ){
			return;
		}		
		if(strcmp('code',$headerAdsType)==0){
			echo $headerAdsCode;
		}
		elseif(strcmp('banner',$headerAdsType)==0){
			strlen($headerAdsUrl) <= 0 ? $headerAdsUrl = "#" : $headerAdsUrl;
			if(strlen($headerAdsImg) <= 0) {
				$headerAdsImg = get_template_directory_uri().'/images/advertisement.png'; 
			}
			echo "<p class=\"hidden-phone\"><a href='{$headerAdsUrl}' target=\"_blank\"><img src='{$headerAdsImg}' title ='{$headerAdsTitle}' alt ='{$headerAdsTitle}'/></a></p>";
		}else{
			echo "<img class=\"hidden-phone\" src=\"";
			get_template_directory_uri();
			echo "/images/advertisement.png\"/ alt=\"your ads here\">";
		}
	}
}

?>