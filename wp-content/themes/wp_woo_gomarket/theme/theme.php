<?php 
$_template_path = get_template_directory();
require_once $_template_path."/framework/abstract.php";
class Theme extends EWAbstractTheme
{
	public function __construct($options){
		$this->options = $options;
		parent::__construct($options);
		$this->constant($options);
	}

	public function init(){
		parent::init();
		//$this->loadOtherJSCSS($this->options);
		add_action('wp_enqueue_scripts',array($this,'loadOtherJSCSS'));
		$this->loadImageSize();
	}
	
	protected function initArrIncludes(){
		parent::initArrIncludes();
		$this->arrIncludes = array_merge($this->arrIncludes,array('class-tgm-plugin-activation'));
	}

	//overwrite widget	
	protected function initArrWidgets(){
		$this->arrWidgets = array('flickr','hot_product','recent_post_slider','customrecent','ew_video','emads','custompages','twitterupdate','ew_multitab','Recent_Comments_custom','ew_social','productaz','ew_subscriptions');
	}
	
	protected function constant($options){
		parent::constant($options);
		define('THEME_EXTENDS', THEME_DIR.'/theme');
		define('THEME_EXTENDS_FUNCTIONS', THEME_EXTENDS.'/functions');
		define('THEME_EXTENDS_SHORTCODES', THEME_EXTENDS.'/shortcodes');
		define('THEME_EXTENDS_INCLUDES', THEME_EXTENDS.'/includes');
		define('THEME_EXTENDS_WIDGETS', THEME_EXTENDS.'/widgets');
		define('THEME_EXTENDS_ADMIN', THEME_EXTENDS.'/admin');
		define('THEME_EXTENDS_ADMIN_TPL', THEME_EXTENDS_ADMIN.'/template');
		define('THEME_EXTENDS_ADMIN_URI', THEME_URI . '/theme/admin');
		define('THEME_EXTENDS_ADMIN_JS', THEME_EXTENDS_ADMIN_URI . '/js');
		define('THEME_EXTENDS_ADMIN_CSS', THEME_EXTENDS_ADMIN_URI . '/css');
	}
	
	protected function loadImageSize(){
		if ( function_exists( 'add_image_size' ) ) {
		   // Add image size for main slideshow
		   
			add_image_size('blog_thumb',260,260,true); /* image for blog thumbnail */		   
			add_image_size('prod_midium_thumb_1',500,500,true); /* image for slideshow */
			add_image_size('prod_midium_thumb_2',366,360,true); /* image for slideshow */
			add_image_size('prod_small_thumb',141,141,true); /* image for slideshow */
			add_image_size('prod_tini_thumb',75,75,true); /* image for slideshow */
			add_image_size('slider_thumb_wide',150,150,true); /* image for slideshow */
			add_image_size('slideshow_box',960,350,true); /* image for slideshow */
			add_image_size('slideshow_wide',1200,450,true); /* image for slideshow */
			add_image_size('slider',222,48,true); /* image for slideshow */
			add_image_size('slider_thumb_box',100,100,true); /* image for slideshow */
			add_image_size('related_thumb',213,213,true); /* image for slideshow */
			//add_image_size('blog_shortcode',480,320,true); /* image for slideshow */
			add_image_size('blog_shortcode',480,480,true); /* image for slideshow */
			add_image_size('woo_shortcode',72,72,true); /* image for testimonial */
			add_image_size('wd_hot_product',160,160,true); /* image for testimonial */
			
			global $_wd_mega_configs;
			$wd_mega_menu_config = get_option(THEME_SLUG.'wd_mega_menu_config','');
			$wd_mega_menu_config_arr = unserialize($wd_mega_menu_config);
			if( is_array($wd_mega_menu_config_arr) && count($wd_mega_menu_config_arr) > 0 ){
				if ( !array_key_exists('area_number', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['area_number'] = 1;
				}
				if ( !array_key_exists('thumbnail_width', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['thumbnail_width'] = 16;
				}
				if ( !array_key_exists('thumbnail_height', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['thumbnail_height'] = 16;
				}
				if ( !array_key_exists('menu_text', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['menu_text'] = 'Menu';
				}
				if ( !array_key_exists('disabled_on_phone', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['disabled_on_phone'] = 0;
				}		
			}else{
				$wd_mega_menu_config_arr = array(
					'area_number' => 1
					,'thumbnail_width' => 16
					,'thumbnail_height' => 16
					,'menu_text' => 'Menu'
					,'disabled_on_phone' => 0
				);
			}
			$_wd_mega_configs = $wd_mega_menu_config_arr;
			
			add_image_size('wd_menu_thumb',$_wd_mega_configs['thumbnail_width'],$_wd_mega_configs['thumbnail_height'],true); /* image for slideshow */
			
		}
	}
	
	public function loadOtherJSCSS(){
		/// Load Custom JS for theme
		if(!is_admin()){			
			wp_register_script( 'gomarket', THEME_JS.'/gomarket.js',false,false,true);
			wp_enqueue_script('gomarket');
		}
	}
}
?>