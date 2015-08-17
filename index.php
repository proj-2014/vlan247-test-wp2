<?php

define('EXTRAPATH', dirname(__FILE__) . '/extra2.1/');
define('COMMONPATH', EXTRAPATH . 'common/');

// patch , for fix the bug tha wordpress cannot been require in functions  ----20150715
$wp_flag = false;
// patch end 

// patch , for fix the bug that exist file cannot use the common args such as EXTRAPATH , route all files   ----20150808
//$wp_exist = false;
// need nginx rewrite all php, this bug  just hold now ,future fix it.
// patch end 

/*
// this part rewrite as follow , pls check it . 
if($_SERVER["HTTP_HOST"]=="test01.tmp0230.ml" || $_SERVER["HTTP_HOST"]=="test01.vlan")
{
   
    require("extra/handler.php");
    require("extra/aop.php");

    Toro::serve(array(
	"/hello" => "HelloHandler",
	"/api/picasa/(.*)" => "ApiPicasaHandler",
	"/api/(.*)" => "ApiHandler",
	"/tpl/admin/(.*)" => "TplAdminHandler",
	"/tpl/(.*)" => "TplHandler",
	"/(.*)" => "DefaultHandler"
	));
	      
}*/
if($_SERVER["HTTP_HOST"]=="test01.tmp0230.ml"|| $_SERVER["HTTP_HOST"]=="test01.vlan" )
{

     define('PATCHPATH', EXTRAPATH . 'patch4remal/');
     require_once(COMMONPATH . 'init.php');
     require_once(PATCHPATH . 'patch.php');
   
     //$mydb = new ezSQL_mysql(MYDB_USER,  MYDB_PASSWORD, MYDB_NAME, MYDB_HOST);
     $mydb = new ezSQL_mysql('root', 'root', 'db_test_extra', 'localhost');

     Toro::serve(array(
	"/hello" => "HelloHandler",
	"/api/picasa/(.*)" => "ApiPicasaHandler",
	"/api/(.*)" => "ApiHandler",
	"/tpl/admin/(.*)" => "TplAdminHandler",
	"/tpl/(.*)" => "TplHandler",
	"/(.*)" => "DefaultHandler"
	));

} 
else if($_SERVER["HTTP_HOST"]=="test02.tmp0230.ml" || $_SERVER["HTTP_HOST"]=="test02.vlan" )
{

     define('PATCHPATH', EXTRAPATH . 'patch4the7/');
     require_once(COMMONPATH . 'init.php');
     require_once(PATCHPATH . 'patch.php');
   
     //$mydb = new ezSQL_mysql(MYDB_USER,  MYDB_PASSWORD, MYDB_NAME, MYDB_HOST);
     $mydb = new ezSQL_mysql('root', 'root', 'db_test_extra2', 'localhost');

     Toro::serve(array(
	"/hello" => "HelloHandler",
	"/tpl/admin/(.*)" => "TplAdminHandler",
	"/(.*)" => "DefaultHandler"
	)); 
} 
else if($_SERVER["HTTP_HOST"]=="test03.tmp0230.ml" || $_SERVER["HTTP_HOST"]=="test03.vlan" )
{

     define('PATCHPATH', EXTRAPATH . 'patch4mall/');
     require_once(COMMONPATH . 'init.php');
     require_once(PATCHPATH . 'patch.php');
   
     //$mydb = new ezSQL_mysql(MYDB_USER,  MYDB_PASSWORD, MYDB_NAME, MYDB_HOST);
     $mydb = new ezSQL_mysql('root', 'root', 'db_test_extra3', 'localhost');

     Toro::serve(array(
	"/hello" => "HelloHandler",
        "/api/picasa/(.*)" => "ApiPicasaHandler",
	"/tpl/admin/(.*)" => "TplAdminHandler"   ,
        "/tpl/test/(.*)" => "TplTestHandler"  ,
        "/api/data/(.*)" => "ApiDataHandler" ,
	"/(.*)" => "DefaultHandler"   
	)); 

} 
else if($_SERVER["HTTP_HOST"]=="test04.tmp0230.ml" || $_SERVER["HTTP_HOST"]=="test04.vlan" )
{

     define('PATCHPATH', EXTRAPATH . 'patch4mall-2/');
     require_once(COMMONPATH . 'init.php');
     require_once(PATCHPATH . 'patch.php');
   
     //$mydb = new ezSQL_mysql(MYDB_USER,  MYDB_PASSWORD, MYDB_NAME, MYDB_HOST);
     $mydb = new ezSQL_mysql('root', 'root', 'db_test_extra4', 'localhost');

     Toro::serve(array(
	"/hello" => "HelloHandler",
        "/api/picasa/(.*)" => "ApiPicasaHandler",
	"/tpl/admin/(.*)" => "TplAdminHandler"   ,
        "/tpl/test/(.*)" => "TplTestHandler"  ,
        "/api/data/(.*)" => "ApiDataHandler" ,
	"/(.*)" => "DefaultHandler"   
	)); 

} 

//d($_SERVER["HTTP_HOST"]);

// patch for character seting in ezSQL  ----20150814
$mydb->query("SET NAMES 'utf8'");
// patch , for fix the bug tha wordpress cannot been require in functions  ----20150715
if($wp_flag)
    require_once "wp-index.php";
    //echo $wp_flag;
// patch end

?>

