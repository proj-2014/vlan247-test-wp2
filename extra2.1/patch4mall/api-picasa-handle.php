<?PHP


class ApiPicasaHandler {

    function get() {
           
    }
    
    function post_xhr() {
        
        global $mydb ; 
       
        if( eregi( '^/api/picasa/save_albums.*', $_SERVER['REQUEST_URI']))
        {              
              echo $_POST['albums'];

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

        }     
        if( eregi( '^/api/picasa/save_photos.*', $_SERVER['REQUEST_URI']))
        {
                //echo $_POST['photos']; 
                
                $photosArray = $_POST['photos'];
                $photos = json_decode($photosArray, true);
                $rows = count($photos);
                for( $i=0; $i<$rows; $i++)
                {
                    $ph_id =$photos[$i]['ph_id'];
                    $ph_width = $photos[$i]['ph_width'];
                    $ph_height = $photos[$i]['ph_height'];
                    $ph_type = $photos[$i]['ph_type'];
                    $ph_src = $photos[$i]['ph_src'];                    
                    $ph_title = $photos[$i]['ph_title'];
                    $str = 'INSERT INTO photos ( ph_id, ph_width, ph_height, ph_type, ph_src, ph_title) VALUES ("'. $ph_id . '",' . $ph_width . ',' . $ph_height . ',"' . $ph_type .'","' . $ph_src . '","' . $ph_title . '")';
                    //$str = 'call save_picasa_photos("'. $ph_id . '",' . $ph_width . ',' . $ph_height . ',"' . $ph_type .'","' . $ph_src . '","' . $ph_title . '")';
                    debug_out("ithem: ".$i.$str); 
                    $mydb->query($str);
                } 
               

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
         
    }
}


?>
