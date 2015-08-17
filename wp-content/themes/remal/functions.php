<?php	
$themename = "Remal";
$themefolder = "remal";

define ('theme_name', $themename );
define ('theme_ver' , 1 );

// Notifier Info
$notifier_name = $themename;
$notifier_url = "http://themes.tielabs.com/xml/".$themefolder.".xml";

//Docs Url
$docs_url = "http://themes.tielabs.com/docs/".$themefolder;

// Constants for the theme name, folder and remote XML url
define( 'MTHEME_NOTIFIER_THEME_NAME', $themename );
define( 'MTHEME_NOTIFIER_THEME_FOLDER_NAME', $themefolder );
define( 'MTHEME_NOTIFIER_XML_FILE', $notifier_url );
define( 'MTHEME_NOTIFIER_CACHE_INTERVAL', 43200 );


// Custom Functions 
include (TEMPLATEPATH . '/custom-functions.php');

// Get Functions
include (TEMPLATEPATH . '/functions/theme-functions.php');
include (TEMPLATEPATH . '/functions/tie-likes.php');
include (TEMPLATEPATH . '/functions/tie-views.php');
include (TEMPLATEPATH . '/functions/common-scripts.php');
include (TEMPLATEPATH . '/functions/banners.php');
include (TEMPLATEPATH . '/functions/widgetize-theme.php');
include (TEMPLATEPATH . '/functions/default-options.php');

if ( tie_get_option( 'grid_pagination' ) == 'infinite' && tie_get_option( 'on_home' ) == 'grid' )
	include (TEMPLATEPATH . '/functions/infinite-scroll.php');

// tie-Panel
include (TEMPLATEPATH . '/panel/mpanel-ui.php');
include (TEMPLATEPATH . '/panel/mpanel-functions.php');
include (TEMPLATEPATH . '/panel/shortcodes/shortcode.php');
include (TEMPLATEPATH . '/panel/post-options.php');
include (TEMPLATEPATH . '/panel/page-options.php');
include (TEMPLATEPATH . '/panel/notifier/update-notifier.php');

// 
include (TEMPLATEPATH . '/includes/pagenavi.php');
include (TEMPLATEPATH . '/includes/breadcrumbs.php');
include (TEMPLATEPATH . '/includes/wp_list_comments.php');
include (TEMPLATEPATH . '/includes/widgets.php');


if ( ! isset( $content_width ) ) $content_width = 600;


// with activate istall option
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {

	if( !get_option('tie_active') ){
		tie_save_settings( $default_data );
		update_option( 'tie_active' , theme_ver );
	}
}

// ================= add for some modify  20150601 ===================

function custom_loginlogo() {
    echo '<style type="text/css"> h1 a {background-image: url('.get_bloginfo('template_directory').'/images/logo.png) !important; } </style>';
    }
add_action('login_head', 'custom_loginlogo');


function custom_loginlogo_url($url) {
    return 'http://www.china-source.tk'; //�ڴ���������Ҫ���ӵ���URL��ַ
}
add_filter( 'login_headerurl', 'custom_loginlogo_url' );


?>
