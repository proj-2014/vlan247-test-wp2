

jQuery(document).ready(function(){

     alert("4api-picasa.js is ok");
     init();
});

// ---------------------------------------
function init() {
    //document.createElement("<a>
    //alert("here is addSomething");
    
 
    $("body").append('<div id="4picasa"> </div>');
    $("#4picasa").append('<br /> <label> input the user id: </label> <input type="text" name="user-id" readonly value="100185453518721246261" id="uid">');
    $("#4picasa").append('<br /> <label> get and save albums: </label> <input type="button" name="get-albums" value="get albums"  id="get-albums">');
    $("#4picasa").append('<br /> <label> get and save photos: </label> <input type="button" name="get-photos" value="get photos" id="get-photos">');

    $("#get-albums").click(function(){  
                alert(" will get and save albums "); 
                save_albums(" "); 
            });
    $("#get-photos").click(function(){  
                alert(" will get and save photos "); 
                for(var i=0; i<al_ids.length; i++)
                    save_photos(al_ids[i]);
           });

}

// ---------------------------------------
// for picasa  
var al_ids = [];

function save_albums(uid) {

        uid = '100185453518721246261';
	//var jurl = "http://picasaweb.google.com/data/feed/api/user/112389034152258078738?kind=album&access=public&alt=json";
        var jurl = "http://picasaweb.google.com/data/feed/api/user/" + uid + "?kind=album&access=public&alt=json";
        jurl = jurl + "&callback=?"

	var albums = [];
        al_ids = [];
        
	jQuery.getJSON(jurl, function(data){
		  if(data.feed.entry) {
		      var entry = data.feed.entry;
		      
		      for (var item=0; item<entry.length; item++) {
			  element = entry[item];
			  al_id = element["gphoto$id"]["$t"];
			  al_num = element["gphoto$numphotos"]["$t"];
			  al_title = element["title"]["$t"];
			  al_feature = element["media$group"]["media$content"][0]["url"];
			  
			  var str = '{"al_id":"'+ al_id + '", "al_num":' + al_num + ',"al_title":"' + al_title +'","al_feature":"'+ al_feature +'"}';
	   
                          al_ids.push(al_id);
			  var obj = eval('(' + str + ')');
			  //var obj = JSON.parse(str);
			  albums.push(obj);        
		      }
		      //alert(albums[0].al_id);
		  } 
              
                  if( albums.length >0 ) {

		      var jsonAlbums = JSON.stringify(albums);
		      var ajax_url = "/api/picasa/save_albums" ;
                      alert("to url is: "+ ajax_url);
	              //alert(jsonAlbums);
	    
		      jQuery.ajax({   
			    url:ajax_url, 
			    type:'POST',   
			    data:{"albums":jsonAlbums},  
                            dataType:"json",
			    //contentType:"application/json; charset=utf-8",
			    success:function(data){   
                                 alert(JSON.stringify(data));
			    }  
		      });  
		  }       


	}).fail(function() {
	     alert('User not found! Please try again!');
	});


}

//------------------------------


function save_photos(al_id) {
    
    vuser = '100185453518721246261';  //"112389034152258078738";
    //al_id = "6157825214333559265";
    //alert("save al_id: " + al_id); 
    //http://picasaweb.google.com/data/feed/api/user/112389034152258078738/albumid/6157825214333559265?alt=json
    al_url = "http://picasaweb.google.com/data/feed/api/user/" + vuser + "/albumid/" + al_id + "?alt=json" ;
    al_url = al_url + "&callback=?";
    
   var photos = [];
   jQuery.getJSON(al_url, function(data) {
           if(data.feed.entry) {
                   var entry = data.feed.entry;
          
                   for (var item=0; item<entry.length; item++) {
                       element = entry[item];
                       ph_id = element["gphoto$id"]["$t"];
                       ph_width = element["gphoto$width"]["$t"];                           
                       ph_height = element["gphoto$height"]["$t"];
                       ph_type = element["content"]["type"];
                       ph_src = element["content"]["src"];                           
                       ph_title = element["title"]["$t"];
                       
                       var str = '{"ph_id":"' + ph_id + '","ph_width":' + ph_width + ',"ph_height":' + ph_height + ',"ph_type":"' + ph_type + '","ph_src":"' + ph_src + '","ph_title":"' + ph_title + '"}';
                       //alert(item + ":" + str);
                   
                       var obj = eval('(' + str + ')');
                       photos.push(obj);
                   }       
          }
          //alert(photos[0].ph_id);
          
          if( photos.length >0 ) {

                      var jsonPhotos = JSON.stringify(photos);
                      var ajax_url2 = "/api/picasa/save_photos" ;
                      //alert("to url is: "+ ajax_url2);
                      //alert(jsonAlbums);

                      jQuery.ajax({
                            url:ajax_url2,
                            type:'POST',
                            data:{"photos":jsonPhotos},
                            dataType:"json",
                            //contentType:"application/json; charset=utf-8",
                            success:function(data){
                                 //alert(JSON.stringify(data));
                            }
                      });
           }


      });

}



