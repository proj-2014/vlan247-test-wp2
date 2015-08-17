<?php 
class AdminThemeGOMARKET extends AdminTheme
{
	public function __construct(){
		define('THEME_EXTENDS_ADMIN_AJAX', THEME_EXTENDS_ADMIN . '/ajax');
		parent::__construct();
	}
	
}
?>