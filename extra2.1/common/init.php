<?PHP

// ==========================================
// init global db handler


require_once("lib/ezSQL/shared/ez_sql_core.php");
require_once("lib/ezSQL/mysql/ez_sql_mysql.php");

//$mydb = new ezSQL_mysql(MYDB_USER,  MYDB_PASSWORD, MYDB_NAME, MYDB_HOST);
//$mydb->get_var("SELECT count(*) FROM test_wp01_users");

//$mydb = new ezSQL_mysql('root', 'root', 'db_test_extra', 'localhost');


// ===========================================
// add some code for log and debug 

$file = EXTRAPATH ."/debug_out.txt";
function debug_out($content) {
    global $file;
    file_put_contents($file, "-----------".$content."\n",FILE_APPEND);
}

// add debug tool kint when kint-debuger no exist ,  20150808
//if(!file_exists(EXTRAPATH . "../wp-content/plugins/kint-debugger/Kint.class.php"))
//    require_once("lib/kint/Kint.class.php");

// ==========================================
//  add for template support , Twig
require_once("lib/Twig/Autoloader.php"); 


Twig_Autoloader::register();  
$loader = new Twig_Loader_Filesystem(PATCHPATH . 'tpl');
//$loader = new Twig_Loader_Filesystem('/temp/test/phproot/wordpress/extra2/patch4the7/tpl');


//$loader = new Twig_Loader_Filesystem(array($templateDir1, $templateDir2));
//$loader->addPath($templateDir3);
//$loader->prependPath($templateDir4);
$twig = new Twig_Environment($loader, array(
             'cache' => PATCHPATH . 'tpl/compilation_cache',
             'auto_reload' => true
            ));
//$twig = new Twig_Environment($loader);


// ===========================================
// add Handlers :
 
require_once("lib/Toro/toro.php");
//require_once(PATCHPATH . "patch.php");

class HelloHandler {
    function get() {
      echo "Hello, world";
    
    }
}

class DefaultHandler {

    function __construct() {
        //ToroHook::add("before_handler", function() { echo "Before  <>  ";echo "test aaa"; });
        //ToroHook::add("after_handler", function() { echo "After  <>  "; echo $_SERVER['REQUEST_URI']; });
    }

   function get()  {

      // patch , for fix the bug tha wordpress cannot been require in functions  ----20150715
      // include("wp-index.php");
      global $wp_flag;
      $wp_flag = true ;
      // patch end 
    }

   function get_xhr() {
   
      global $wp_flag;
      $wp_flag = true ;

   }   

   function post() {
    
      global $wp_flag;
      $wp_flag = true ;
   }
   
  function post_xhr() {
   
      global $wp_flag;
      $wp_flag = true ;

  } 
}


?>

