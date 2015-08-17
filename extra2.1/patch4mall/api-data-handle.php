<?PHP


class ApiDataHandler {

    function get() {
           
    }
    
    function post_xhr() {
        
        global $mydb ; 
       
        if( eregi( '^/api/data/pagedata.*', $_SERVER['REQUEST_URI']))
        {              
              //echo $_POST['url'].$_POST['search'].$_POST['args'];
              $rdata = json_encode($_POST);
              echo json_encode($_POST) ;
        
              //$data_test = '{"images":"http://www.ruanyifeng.com/blog/upload/2010/02/bg2010021101.jpg",

              //global $mydb;
              //$mydb->query('call p5("'.$rdata.'", @result)'); 


               /* 
		$albumsArray = $_POST['albums'];
		$albums = json_decode($albumsArray, true);
		$rows = count($albums);
		for( $i=0; $i<$rows; $i++) 
		{
		    $al_id =$albums[$i]['al_id'];
		    $al_num = $albums[$i]['al_num'];
		    $al_title = $albums[$i]['al_title'];
		    $al_feature = $albums[$i]['al_feature'];

		    $str = 'INSERT INTO albums ( al_id, al_num, al_title, al_feature) VALUES ("'. $al_id . '",' . $al_num . ',"' . $al_title . '","' . $al_feature . '")';
		    //$str = 'call save_picasa_albums("'+ $al_id +'",'+ $al_num +',"'+ $al_title +'","'+ $al_feature +'")';
		    $mydb->query($str);
		}  
               */

        }     

        // -----------------------------------------------------------------------
        // follow is add for front query picasa albums and photos ,  20150623
        
        if( eregi( '^/api/picasa/query_albums.*', $_SERVER['REQUEST_URI']))
        {
              
               $str= "select * from albums" ;
               $mydb->query($str);
               $albums = $mydb->get_results(null, OBJECT);

               echo json_encode($albums);
               //$len = $albums.length;
               //debug_out("query albums is: ".json_encode($albums));
        }

       // =======================================================================
       // follow is add for get the itemdata of product , test in 20150814 

       if( eregi( '^/api/data/itemdata.*', $_SERVER['REQUEST_URI']))
        {
              
               $mydb->query("SET NAMES 'utf8'");  
               $str= "select * from raw_items " ;
               $mydb->query($str);
               $items = $mydb->get_results(null, OBJECT);

               echo json_encode($items);
               $len = $items.length;
               //debug_out("query items is: ". json_encode($items));
        } 
       // and follow is for get hte photodata  for imgAll, test in 20150814
        if( eregi( '^/api/data/photodata.*', $_SERVER['REQUEST_URI']))
        { 
             /*
              debug_out("hello debug");
              $test->arg1 ='111';
              $test->arg2 ='112';
              $test->arg3 ='113';
              $test->arg4 ='114';
             $att= array('a'=>1, 'b'=>2);
             debug_out( json_encode($att));
             debug_out( json_encode($test));
             debug_out("test arg1 is: " . $test->arg1);  

              $str= "select *  from raw_photobucket where id>3371" ;
               $mydb->query("SET NAMES 'utf8'"); 
               $mydb->query($str);
               $p = $mydb->get_results(null, OBJECT);
               debug_out( json_encode($p));

               if(preg_match('/\w:/', $result)){
                   $resutl = preg_replace('/(\w+):/is', '"$1":', $result);
               }

            echo json_encode($p); 
            */
               $str= "select *  from raw_photobucket" ;
               $mydb->query("SET NAMES 'utf8'");
               $mydb->query($str);
               $photos = $mydb->get_results(null, OBJECT);
               //debug_out(" the head of $photos is : " . substr($photos,0, 50));
               echo json_encode($photos);
        }  
    }
}


?>
