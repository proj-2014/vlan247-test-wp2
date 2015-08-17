<?php 
class AdminTheme extends Theme
{
	protected $tabs = array();
	
	protected $arrLayout = array();
		
	public function __construct(){
		$this->constants();
		$this->resetArrLayout();
		$this->initTabs();
		add_action( 'admin_menu', array($this,'generatePanelHtml'));
		//add_action('admin_init',array($this,'loadJSCSS'));
		add_action('admin_enqueue_scripts',array($this,'loadJSCSS'));
		////// load custom field ///////
		require_once THEME_ADMIN.'/custom_fields.php';
		if(file_exists(THEME_EXTENDS_ADMIN.'/custom_fields.php')){
			require_once THEME_EXTENDS_ADMIN.'/custom_fields.php';
			$classCustomFields = 'CustomFields'.strtoupper(substr(THEME_SLUG,0,strlen(THEME_SLUG)-1));
		}
		else{
			$classCustomFields = 'CustomFields';
		}
		$customFields = new $classCustomFields();
		
		////// hook action ajax save config of epanel ///////
		require_once THEME_ADMIN_AJAX.'/epanel.php';
		if(file_exists(THEME_EXTENDS_ADMIN_AJAX.'/epanel.php')){
			require_once THEME_EXTENDS_ADMIN_AJAX.'/epanel.php';
			$epanel = 'AjaxEpanel'.strtoupper(substr(THEME_SLUG,0,strlen(THEME_SLUG)-1));
		}
		else{
			$epanel = 'AjaxEpanel';
		}
		$epanel = new $epanel();
		
		//$this->AddCustomSidebarLayoutTagCat();
	}
	
	public function constants(){
		define('THEME_ADMIN_JS', THEME_ADMIN_URI . '/js');
		define('THEME_ADMIN_CSS', THEME_ADMIN_URI . '/css');
		define('THEME_ADMIN_IMAGES', THEME_ADMIN_URI . '/images');
		define('THEME_ADMIN_AJAX', THEME_ADMIN . '/ajax');
		define('THEME_ADMIN_FUNCTIONS', THEME_ADMIN . '/functions');
		define('THEME_ADMIN_OPTIONS', THEME_ADMIN . '/options');
		define('THEME_ADMIN_METABOXES', THEME_ADMIN . '/metaboxes');
		define('THEME_ADMIN_DOCS', THEME_ADMIN . '/docs');
		define('THEME_ADMIN_TPL', THEME_ADMIN . '/template');
		
		
		// the option name custom sidebar(layout) for category and tag
 		define('MY_CATEGORY_SIDEBAR', THEME_SLUG.'my_category_sidebar_option');
		define('MY_TAG_SIDEBAR', THEME_SLUG.'my_tag_sidebar_option');
	}
	
	protected function setArrLayout($array = array()){
		$this->arrLayout = $array;
	}

	/* Set defaulr value for array layout */
	protected function resetArrLayout(){
		$this->setArrLayout(array(
			'1column'		=>	array(	'image'	=>	'i_1column.png', 		'title'	=>	__('Content - No Sidebar','wpdance')	),
			'2columns-left'	=>	array(	'image'	=>	'i_3columns_right.png', 	'title'	=>	__('Content - Left Sidebar','wpdance')),
			'2columns-right'=>	array(	'image'	=>	'i_3columns_left.png', 'title'	=>	__('Content - Right Sidebar','wpdance')),
		));
		
	}
	
	protected function getArrLayout(){
		return $this->arrLayout;
	}
	
	public function inline_js(){
	?>
	    <script type="text/javascript">
		//<![CDATA[
			template_path = '<?php echo get_template_directory_uri(); ?>';
		//]]>
		</script>
	<?php
	}
	
	public function initTabs(){
		add_action('admin_head', array($this,'inline_js'));
		
		$this->tabs = array(
			array(
				'slug'	=>	'general',
				'name'	=>	'General'
			)
			,array(
				'slug'	=>	'custom-interface',
				'name'	=>	'Custom interface'
			)
			/*,array(
				'slug'	=>	'advertisement',
				'name'	=>	'Advertisement'
			)*/
			,array(
				'slug'	=>	'custom-code-area',
				'name'	=>	'Custom Code Area'
			)
			,array(
				'slug'	=>	'mega-menu',
				'name'	=>	'Mega Menu'
			)			
			,array(
				'slug'	=>	'sidebar-manager',
				'name'	=>	'Custom Sidebar'
			)							
			,array(
				'slug'	=>	'product-category',
				'name'	=>	'Product Category Page'
			)			
			,array(
				'slug'	=>	'product-details',
				'name'	=>	'Product Details Page'
			)
			,array(
				'slug'	=>	'listing-page',
				'name'	=>	'Archive Page'
			)			
			,array(
				'slug'	=>	'customforpostsingle',
				'name'	=>	'Single Post Page'
			)			
		);
	}
	
	public function loadPanelContainer(){
		if(file_exists(THEME_EXTENDS_ADMIN_TPL.'/epanel/panel_container.php'))
			require_once THEME_EXTENDS_ADMIN_TPL.'/epanel/panel_container.php';
		else	
			require_once THEME_ADMIN_TPL.'/epanel/panel_container.php';
	}
	
	public function loadPanel(){
		$this->loadPanelContainer();
	}
	
	public function generatePanelHtml(){
		//add_theme_page(THEME_NAME.' Config', "Theme Options", 'switch_themes', 'wp_admin', array($this,'loadPanel'));
		//add_menu_page(THEME_NAME.' Config'," WPDance", 'switch_themes', 'wp_admin', array($this,'loadPanel'),get_bloginfo('template_directory').'/images/wpdance.png',63);
	}
	
	protected function loadSidebarLeftPanel(){
		if(file_exists(THEME_EXTENDS_ADMIN_TPL.'/epanel/sidebar_left.php'))
			require_once THEME_EXTENDS_ADMIN_TPL.'/epanel/sidebar_left.php';
		else
			require_once THEME_ADMIN_TPL.'/epanel/sidebar_left.php';
	}
	
	protected function loadContentPanel(){
		foreach($this->tabs as $index => $tab){
			if(file_exists(THEME_EXTENDS_ADMIN_TPL.'/epanel/'.$tab['slug'].'.php'))
				require_once THEME_EXTENDS_ADMIN_TPL.'/epanel/'.$tab['slug'].'.php';
			else	
				require_once THEME_ADMIN_TPL.'/epanel/'.$tab['slug'].'.php';
		}
	}
	
	/* Add custom sidebar and layout for tag and category */
	protected function AddCustomSidebarLayoutTagCat(){
		add_filter('edit_category_form', array($this,'generateCategoryFields'),0);
		add_action('edit_tag_form_fields',array($this,'generateTagFields'),0);
		add_filter('edited_terms', array($this,'updateCategoryTagFields'));
		add_filter('deleted_term_taxonomy', array($this,'removeCategoryTagFields'));
	}
	
	/* Generate Custom Sidebar and Layout for category */
	public function generateCategoryFields($tag) {
		require_once THEME_ADMIN_TPL.'/custom_sidebar_layout/category.php';
	}
	
	/* Generate Custom Sidebar and Layout for tag */
	public function generateTagFields($tag) {
		require_once THEME_ADMIN_TPL.'/custom_sidebar_layout/tag.php';
	}
	
	/* Save custom sidebar and layout for category and tag */
	function updateCategoryTagFields($term_id) {
			$tag_extra_fields = get_option(MY_CATEGORY_SIDEBAR);
			$tag_extra_fields[$term_id]['cat_post_sidebar'] = strip_tags($_POST['cat_post_sidebar']);
			$tag_extra_fields[$term_id]['cat_post_layout'] = strip_tags($_POST['cat_post_layout']);
			update_option(MY_CATEGORY_SIDEBAR, $tag_extra_fields);
	}
	
	/* Remove custom sidebar and layout of a tag(category) when it is removed */
	public function removeCategoryTagFields($term_id) {
			$tag_extra_fields = get_option(MY_CATEGORY_SIDEBAR);
			unset($tag_extra_fields[$term_id]);
			update_option(MY_CATEGORY_SIDEBAR, $tag_extra_fields);
	}
	
	protected function showTooltip($title,$content){	
		include THEME_ADMIN_TPL.'/epanel/tooltip.php';
	}
	
	public function loadJSCSS(){
		wp_enqueue_script('jquery');
		wp_enqueue_script("jquery-ui-core");
		wp_enqueue_script("jquery-ui-widget");
		wp_enqueue_script("jquery-ui-tabs");
		wp_enqueue_script("jquery-ui-mouse");
		wp_enqueue_script("jquery-ui-sortable");
		wp_enqueue_script("jquery-ui-slider");
		wp_enqueue_script("jquery-ui-accordion");
		wp_enqueue_script("jquery-effects-core");
		wp_enqueue_script("jquery-effects-slide");
		wp_enqueue_script("jquery-effects-blind");	
		wp_register_script( 'jqueryform', THEME_FRAMEWORK_JS_URI.'/jquery.form.js');
		wp_enqueue_script('jqueryform');
		if(file_exists(THEME_EXTENDS_ADMIN.'/js/tab.js'))
			wp_register_script( 'tab', THEME_EXTENDS_ADMIN_JS.'/tab.js');
		else	
			wp_register_script( 'tab', THEME_ADMIN_JS.'/tab.js');
		wp_enqueue_script('tab');
		
		if(file_exists(THEME_EXTENDS_ADMIN.'/js/shortcode.js'))
			wp_register_script( 'shortcode_js', THEME_EXTENDS_ADMIN_JS.'/shortcode.js');
		else	
			wp_register_script( 'shortcode_js', THEME_ADMIN_JS.'/shortcode.js');
		wp_enqueue_script('shortcode_js');
		
		if(file_exists(THEME_EXTENDS_ADMIN.'/js/page_config.js'))
			wp_register_script( 'page_config_js', THEME_EXTENDS_ADMIN_JS.'/page_config.js');
		else	
			wp_register_script( 'page_config_js', THEME_ADMIN_JS.'/page_config.js');
		wp_enqueue_script('page_config_js');
		
		if(file_exists(THEME_EXTENDS_ADMIN.'/css/style.css'))
			wp_register_style( 'config_css', THEME_EXTENDS_ADMIN_CSS.'/style.css');
		else	
			wp_register_style( 'config_css', THEME_ADMIN_CSS.'/style.css');
		wp_enqueue_style('config_css');
		 

		/// Start Fancy Box
		wp_register_style( 'fancybox_css', THEME_CSS.'/jquery.fancybox.css');
		wp_enqueue_style('fancybox_css');		
		wp_register_script( 'fancybox_js', THEME_JS.'/jquery.fancybox.pack.js');
		wp_enqueue_script('fancybox_js');	
		/// End Fancy Box		
		
		wp_register_style( 'colorpicker', THEME_CSS.'/colorpicker.css');
		wp_enqueue_style('colorpicker');		
		wp_register_script( 'bootstrap-colorpicker', THEME_JS.'/bootstrap-colorpicker.js');
		wp_enqueue_script('bootstrap-colorpicker');	
		
		global $is_admin_menu;
		
		wp_register_style( 'font-awesome', THEME_FRAMEWORK_CSS_URI.'/font-awesome.css');
		wp_enqueue_style('font-awesome');	

	wp_enqueue_script('plupload-all');
	
	wp_enqueue_script('utils');
	wp_enqueue_script('plupload');
	wp_enqueue_script('plupload-html5');
	wp_enqueue_script('plupload-flash');
	wp_enqueue_script('plupload-silverlight');
	wp_enqueue_script('plupload-html4');
	wp_enqueue_script('media-views');
	wp_enqueue_script('wp-plupload');
	
	
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script('media-upload');
	
		
		wp_register_script( 'logo_upload', THEME_ADMIN_JS.'/logo-upload.js');
		//if( !$is_admin_menu )
			wp_enqueue_script('logo_upload');
		
		
	}
}
?>