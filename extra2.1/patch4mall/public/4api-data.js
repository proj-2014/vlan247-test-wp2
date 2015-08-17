
window.$=window.jQuery; 

//var fn_alert = new Function(data);

var alert = function(str)
{
    console.log(str);
    //fn_alert(str);
}

function test(){
  
    alert("helelo");
    alert("window.location.pathname is" + window.location.pathname);
    alert("window.location.href is "  +  window.location.href);
    alert("window.location.hash is " + window.location.hash);
    alert("window.location.host is " + window.location.host);
   
    alert("window.location.search is " + window.location.search);
   
    var url = window.location.search ;
    var loc = url.substring(url.lastIndexOf('=')+1, url.length);
    alert(" args is " + loc);


}
    

$(document).ready(function(){

    //test();
    var args = parseQueryString(window.location.href);
    alert(JSON.stringify(args));

    //initData();
      });


// add for load all items data , 20150814
_items = {};
_photos = {};

loadData();   // add 20150814

function loadData(){
    
    _items = JSON.parse(localStorage.getItem("ItemData")); 
    _photos = JSON.parse(localStorage.getItem("PhotoData"));

    var ajax_url = "";
    if(!_items){
    //if(true){
             ajax_url = "/api/data/itemdata";
             jQuery.ajax({   
		    url:ajax_url, 
		    type:'POST',   
		    data:{"page":100},  
		    dataType:"json",
		    //contentType:"application/json; charset=utf-8",
		    success:function(data){   
			 //alert("all items data is : " + JSON.stringify(data));
                         _items = data;
                         localStorage.setItem("ItemData", JSON.stringify(data));
		    }  
	      }); 
        
    }
    if(!_photos){
    //if(true){
             ajax_url = "/api/data/photodata";
             jQuery.ajax({   
		    url:ajax_url, 
		    type:'POST',   
		    data:{"page":100},  
		    dataType:"json",
		    //contentType:"application/json; charset=utf-8",
		    success:function(data){   
                         var str="[";
                         for(var i=0; i<data.length; i++){
                                var id = data[i]['phid'];
                                var url = data[i]['remote'];
                                _photos[id] = url;
                         }
                         localStorage.setItem("PhotoData", JSON.stringify(_photos));
			 //alert("all photos data is: " + JSON.stringify(_photos));
		    }  
	      }); 

    
    }
}

function testData(lyPage){
     
      if(lyPage.re ==""){

      }

}

// ------------------------------------------------------------------------
// -------------------------------------------------------------------------

initData();

function parseQueryString(url) {  
    try{
	    var str = url.split("?")[1], items = str.split("&");  
	    var result = {};  
	    var arr;  
	    for (var i = 0; i < items.length; i++) {  
		arr = items[i].split("=");  
		result[arr[0]] = arr[1];  
	    }  
	    return result;  
    }
    catch(err){
    
        //alert(err);

    }
}  




function initData(){

      var ajax_url = "/api/data/pagedata";

      var path = window.location.pathname;
      var srh = window.location.search;
      var args = parseQueryString(srh);
      var img1 = "https://lh3.googleusercontent.com/-n_uAAv3yQjc/Va7tJCiHJDI/AAAAAAAAAJs/8yIvExy2UD8/3-54d430b6Nce70cd8e.jpg";;
      var img2 = "https://lh3.googleusercontent.com/-U66Y9CdHjDA/Va7tC7OGZNI/AAAAAAAAAJU/NHq2atACL4w/1-54d430b2Ndd9c8907.jpg";
      var img3 = "https://lh3.googleusercontent.com/-1iLb7BDOuU8/Va7s-wy4dsI/AAAAAAAAAJE/ga3OXpZnCwg/2-54d430b6Nce70cd8e.jpg";
      var img4 = "https://lh3.googleusercontent.com/-eFC90MggVEs/Va7s7Ij2ZFI/AAAAAAAAAIs/5UrHrv47dpg/4-54d430b8Nd84c2b9e.jpg";

  
      var pkey = window.location.href;   //path + srh ; 
      var pdata = {};
      
      //url = encodeURIComponent(url);
      //srh = encodeURIComponent(srh);
  
      pdata = JSON.parse(localStorage.getItem(pkey));
      //alert(value);

      if(pdata){
      //if(false){
  
          alert("datas from local Storage is ok  "); // + JSON.stringify(pdata));

      }
      else {
     
	      jQuery.ajax({   
		    url:ajax_url, 
		    type:'POST',   
		    data:{"path":path, "search":srh, "args":args, "img1":img1, "img2":img2, "img3":img3, "img4":img4},  
		    dataType:"json",
		    //contentType:"application/json; charset=utf-8",
		    success:function(data){   
			 alert(JSON.stringify(data));
                         //JSON.parse(data);
                         localStorage.setItem(pkey, JSON.stringify(data));
		    }  
	      }); 
      }
}


           
var controler = function(){
    function layer(p){
    	  this.re = p;
    	  this.url = window.location.href;
    	  this.flag = "success";
    	  this.args = {};
    	  this.list = [];
          this.data = {};
    
    };

    var re_page = /\?(product_cat|post_type)=.+/;
    var re_item = /\?product=.+/;
    var re_home = /(2789|1591)$/;
    
    /*
    var url_map = [
		{"re_filter": re_page, "fn_url": rendPage, "script": "re_page.js" },
		{"re_filter": re_item, "fn_url": rendItem, "script": "re_item.js" } 
	      ];
    */

    var url_map = [
		{"re_filter": re_page,  "script": "re_page.js" },
		{"re_filter": re_item,  "script": "re_item2.js" }, 
                {"re_filter": re_home,  "script": "re_home.js" }

	      ];


    var url_dispatch = function(){
           
    	   
    	   var url = window.location.href;
    	   
    	   var i=0;
    	   
    	   alert("now in url_dispatch");
    	  
         for(i=0; i<url_map.length; i++){
                var tmp = url_map[i];                
                var lyPage = new layer(tmp.re_filter);
                 
                
                //var group = ly.re.exec(url)
                if(lyPage.re.test(lyPage.url)){
			
                          // add  data driver just for test  20150815
			  testData(lyPage);
		 	  // add end 
		    
                           alert("in url_dispatch, fix url now : " + lyPage.re);

                           $.getScript("/extra2.1/patch4mall/public/dyload/"+tmp.script)
				 .done(function() {				      
                                      console.log("will rend soon");
                                      rend(lyPage);
				});
                                 
                	   break;
                }
                                                 
          };
    	 
    };
    
    url_dispatch();

}



controler();

$(document).ready(function(){   
          alert("ready now");
          //rendItem(); 
          //controler();
      });



/*
Behavior2.Class('pic-show', 'div#content .images',{
          click: {

          }
       }, function($ctx, that) {
          
          var $ele;    
	  $ele = $ctx.find("img");

          var pkey = window.location.href;   
          var pdata = {};
          pdata = JSON.parse(localStorage.getItem(pkey));

          var wrapData = function(str){
                   //res = '<img alt="Placeholder" src="'+ str + '">';
                   res = '<img alt="placeholder" src="https://lh3.googleusercontent.com/-n_uAAv3yQjc/Va7tJCiHJDI/AAAAAAAAAJs/8yIvExy2UD8/3-54d430b6Nce70cd8e.jpg" >';

                   return res;
          };

          var map = {
                 "img:first": JSON.stringify(pdata.img1)
              }; 
          var wrap = {
                  "img:first": wrapData
                  //"div #tab-reviews":[{"div #tab-reviews": wrapData},{"div #tab-reviews": wrapData2}]
              };

          var init = function(){
              
              for (var key in wrap){
                    //alert(typeof(wrap[key]));
                    if(typeof(wrap[key]== "function")){
                        map[key] = wrap[key](map[key]);
                    }
                } 

                  for(var key in map){
                       var $p = $ctx.find(key);
                       //$p.html(map[key]);
                       //$p.prop("outHTML", map[key]);
                       $p.after(map[key]);
                       $p.remove();
                  }
                 
                  // $ctx.find("img").remove();
          };     

          init();

      });

Behavior2.Class('desc', 'div#multitabs-detail', {
	  click: {
            '.tab-content': 'hide'
	  }
	}, function($ctx, that) {
	  console.log('hello this is that');
          //alert("now in Behavior function");
 
         // --------------



         // -----------------

	  var $ele;    
	  $ele = $ctx.find("h2");
	  that.hide = function(e) {
           // alert("now in hide");
	    e.preventDefault();
	    $target = $(e.currentTarget);
	    $ele.remove();
	    $target.hide();
	    //alert("remove");
	    return Behavior2.contentChanged();
	    };
	});
*/

// ============================= Test code area ================
function stopDefault(e)
{
     var oEvent=e || event;
     if(oEvent && oEvent.preventDefault)
     {
        oEvent.preventDefault();
     }
     else
     {
        window.event.returnValue = false;
     }
     return false;                                                                                                           }



window.onload = function()
{
  var aTable = document.getElementsByTagName("a");

  alert(" in window .onload now , hook <a> ");
  for (var i=0; i<aTable.length; i++ )
  {
    aTable[i].onclick = function(event)
    {
        alert("title:"+this.innerHMLT+",href:"+this.href);
        //stopDefault(event)
    }
  }
/*  $("div.related.products").find('ul.products').carouFredSel({

                    responsive: true,
                    direction:  "left",
                    auto        : false,
                    scroll      : 1,
                    items       : {
                           visible : 1 ,
                           width   : 244,
                           height  : 278
                         },
                    width       : 790,
                    height      : 400
                });

 */ 

}

