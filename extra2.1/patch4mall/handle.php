
<?PHP

require_once("api-picasa-handle.php");
require_once("api-data-handle.php");

// ================================= for tpl handles =============================

class TplAdminHandler { 

    function get() {

        echo "here is tpl handle"; 
        global $twig;
        echo $twig->render('admin.twig', array('name' => 'Admin Panel'));
    }


}

class TplTestHandler { 

    function get() {

        echo "here is tpl handle"; 
        //global $twig;
        //echo $twig->render('test.twig', array('name' => 'Test Panel'));

        global $mydb;
        $bb = 'init value here';
        $str = "CALL p2();";
        //echo $mydb->query($str);
        echo $bb;

        $na = "php-na";
        $sk = 'php-sk';

       global $mydb;
       //$mydb->query('call p3("'.$na.'","'.$sk.'")');
       //$mydb->query('call p3("ceshi-name","ceshi-sk")');

       $out = "php-na";
       

       //global $mydb;
       $mydb->query('call p4(@out);');
       $mydb->query('select @out;');
       $result = $mydb->get_results(null, OBJECT);

       echo $result;
       echo json_encode($result);

       
 
    }


}







?>
