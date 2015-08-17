<?php

// this file is path to the wordpress themes without aop, means need to modify some code in original files

// add to the end of the theme file   /wp-content/themes/wp_woo_gomarket/functions.php with the follow code :
//       require_once ( ABSPATH . '/extra2.1/patch4mall/modify/myfunctions.php');




//add_action("wp_head", "head_js");

add_action('wp_footer', 'foot_js', 99);

function foot_js()
{
    //if(is_home()){
	 	  
        //$head_js = '<script type="text/javascript" src="/extra2.1/common/public/js/jquery-1.9.1.js"></script> ';
	//echo $head_js;

        //wp_enqueue_script("jquery");
	
        echo "<script type='text/javascript'> window.$=window.jQuery; </script> ";

        $head_js = '<script type="text/javascript" src="/extra2.1/common/public/js/underscore.min.js"></script> ';
	echo $head_js;
		  
        $head_js = '<script type="text/javascript" src="/extra2.1/common/public/js/behavior.js"></script> ';
	echo $head_js;
	 
        //$head_js = '<script type="text/javascript" src="/extra2.1/patch4mall/public/4node-api.js"></script> ';
	//echo $head_js;
 
        $head_js = '<script type="text/javascript" src="/extra2.1/patch4mall/public/4api-data.js"></script> ';
	echo $head_js;

/**/	 
    // }	
}

    add_filter( 'avatar_defaults', 'newgravatar' );  

     

    function newgravatar ($avatar_defaults) {  

        $myavatar = get_bloginfo('template_directory') . '/images/wpdaxue-gravatar.jpg';  

        $avatar_defaults[$myavatar] = "WordPress ";  

        return $avatar_defaults;  

    }
// test debug tool kint 
//d($_SERVER);

?>
