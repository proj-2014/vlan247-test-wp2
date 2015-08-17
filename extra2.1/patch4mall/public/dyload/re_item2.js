
//====================  20150805  V8.0 

function rend(lyPage){

  console.log("hello , this is dyload/ re_item.js");
  $.getScript("/extra2.1/patch4mall/public/dyload/layer.js")
       .done(function() {				      
            $(document).ready(function(){ render(lyPage); });
	});


}

// only for test data  20150813
function dataSet(lyPage){
  
      var data = {};
      //data.url = window.location.href;
      
      //data = _item[5];
      var idx = parseInt(20*Math.random());
      var item = _items[idx];

      data.summary = {};
      data.imgs = [];
      data.tabs = {};
      
      data.summary.title = item.title;
      data.summary.price = item.price;
      data.summary.sku = item.sku;
      
      var str = item.description;
      //data.tabs.desc = str.replace( /src=".*?(img-id="(.{8})".*?>)/g, 'src="'+_photos[RegExp.$2]+'" ' + RegExp.$1 );
      data.tabs.desc = str.replace( /src=".*?(img-id="(.{8})".*?>)/g, function(){
                           var args = arguments;
                           var url = _photos[args[2]];
                           console.log("current args is : " + args[1] + args[2]);
                           return  'src="' + url + '" ' +  args[1];
                      });

      //console.log("after RegExp, the description is " + data.tabs.desc);

      
      var tmp = item.gallery.replace(/\s|\[|\]/g, "").split(',');
      for(var i=0; i<tmp.length; i++){
          console.log("item gallery has: " + i + " ---- "+tmp[i]);
          data.imgs[i]= _photos[tmp[i]];   
      } 
  
      //console.log( " in dataSet , data imgs is :" + JSON.stringify(data.imgs)); 
      return data;
}



// ==============================================================================
//                         Rend & Echo  Area  
// ==============================================================================
 


function render(lyPage)
{

    var env = {
	 url : window.location.href,
	 pkey : window.location.href,
	 //pdata : JSON.parse(localStorage.getItem(window.location.href)),
         pdata : {
                    summary:{title: "Testing product 1002", sdec: "this is the short description"},
                    tabs: {desc: " Hello this is the desc in tabs, thanks" },
                    imgs: [
//                            "https://lh3.googleusercontent.com/-n_uAAv3yQjc/Va7tJCiHJDI/AAAAAAAAAJs/8yIvExy2UD8/3-54d430b6Nce70cd8e.jpg" //,
                            "http://img14.360buyimg.com/n0/jfs/t538/143/1393133195/200553/435fa728/54d430b2Ndd9c8907.jpg",
                            "http://img14.360buyimg.com/n0/jfs/t775/325/749000432/216969/8008012f/54d430b6Nce70cd8e.jpg",
                            "http://img14.360buyimg.com/n0/jfs/t484/116/1403674785/178337/934c9d68/54d430b8Nd84c2b9e.jpg",
                            "http://img14.360buyimg.com/n0/jfs/t511/202/1419770639/148358/2c39ecf2/54d430bbNef502130.jpg",
                            "http://img14.360buyimg.com/n0/jfs/t598/330/1394579032/165637/fce797d4/54d430bdN8fcbb167.jpg"
                          ]
                 },
         map : [],
         wrap: [],
	 lys : []
        
    };
   
    // add for test 20150814
    env.pdata = dataSet(lyPage);
    // add end

// -------------------------------------------------------------------------

      var rend_imgs = function(ly){
    	
      alert("now in rend_imgs");
      var data = env.pdata.imgs; 
      var strImg = '<a data-rel="prettyPhoto[product-gallery]" title="product-img" class="woocommerce-main-image zoom" itemprop="image" href=""><img width="500" height="500" title="product-img" alt="product-img" class="attachment-shop_single wp-post-image" src=""></a>';
      strImg = strImg.replace(/href=""/, 'href="'+data[0]+'"');
      strImg = strImg.replace(/src=""/, 'src="'+data[0]+'"');
    
      var strJs = '';
      var strUl = '';

      if(data.length > 2){
      	  var strLis = '';
          strUl = '<div class="thumbnails list_carousel columns-3"><div class="caroufredsel_wrapper" style="display: block; text-align: left; float: none; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: auto; margin: 0px 0px 15px; overflow: hidden; position: relative; width: 350px; height: 272px;"><ul class="product_thumbnails" style="text-align: left; float: none; position: absolute; top: 0px; right: auto; bottom: auto; left: 0px; margin: 0px; width: 420px; height: 70px;"></ul></div><div class="slider_control"><a href="#" class="prev hidden" id="product_thumbnails_prev" style="display: none;">&lt;</a><a href="#" class="next hidden" id="product_thumbnails_next" style="display: none;">&gt;</a></div></div>' ;

          //var strLi = '<li style="width: 70px;"><a data-rel="prettyPhoto[product-gallery]" title="product-img" class="" href=""><img width="60" height="60" alt="product-img" class="attachment-shop_thumbnail" src=""></a></li>';

          //var strLi = '<li style="width: 70px;"><a rel="useZoom: \'zoom1\', smallImage: \'http\'" title="product-img" class="last pop_cloud_zoom cloud-zoom-gallery" href=""><img width="60" height="60" alt="product-img" class="attachment-shop_thumbnail" src=""></a></li>';
          //var strLi = '<li style="width: 70px;"><a rel="useZoom: \'zoom1\', smallImage: \'http\'" title="product-img" class="last " href=""><img width="60" height="60" alt="product-img" class="attachment-shop_thumbnail" src=""></a></li>';
          var strLi = '<li style="width: 70px;"><a  title="product-img" class="last " href=""><img width="60" height="60" alt="product-img" class="attachment-shop_thumbnail" src=""></a></li>';
          

          
          for(var i=0; i<data.length; i++){
                tmp = strLi;
                tmp = tmp.replace(/http/, data[i]);
                tmp = tmp.replace(/href=""/, 'href="'+data[i]+'"');
                tmp = tmp.replace(/src=""/, 'src="'+data[i]+'"');
                if(i==0) tmp = tmp.replace(/class=""/, 'class="first" ');
                strLis = strLis + tmp;
          }

          console.log(strLis);
          strUl = strUl.replace(/<\/ul>/, strLis + '</ul>');

          strJs = '	<script language="javascript" type="text/javascript">jQuery(function() {jQuery(".product_thumbnails").carouFredSel({responsive: true,width	: "100%",height	:"auto"	,scroll	: 1,swipe	: { onMouse: false, onTouch: true },items	: {width		: 70,height		: 70,visible	: {	min		: 1,max	: 4		}	},auto	: false,prev	: "#product_thumbnails_prev",next	: "#product_thumbnails_next"	});	});	</script> ';

      }
      
      ly.res = strImg + strUl + strJs;
    }
    
   
    var echo_imgs = function(ly){
        alert("now in echo imgs");	
    	ly.$ctx.html(ly.res);
/*
        ly.$ctx.on("click", "li img", function(e){ 
                        //alert("catch click event now");  
                        e.preventDefault();
                        var src = $(e.target).attr("src");
                        ly.$ctx.find("img.attachment-shop_single").attr("src",src);
                     });
*/
     
        var imgSwitch_handle = function(e){
               e.preventDefault();
               var src = $(e.target).attr("src");
               ly.$ctx.find("img.attachment-shop_single").attr("src",src);

        };

        ly.add_behavior("click","li img", imgSwitch_handle);

        console.log("in echo_img, li style is: " + $("ul.product_thumbnails li").attr("style"));
        /*
        ly.add_behavior("click","li img", function(e){
                e.preventDefault();
                var src = $(e.target).attr("src");
                ly.$ctx.find("img.attachment-shop_single").attr("src",src);

        });
        */
    }
    
    var echo_summary = function(ly){
    	
    	var data = env.pdata.summary;
        ly.$ctx.find(".entry-title").html(data.title);
        ly.$ctx.find(".std p").html(data.sdec);  
    }
    
    var echo_tabs = function(ly){
    	var data = env.pdata.tabs;
        ly.$ctx.find("#tab-description").html(data.desc);
        ly.$ctx.find("#tab-description img").css({"display":"block"});
        alert("aleady in echo_tabs function now , will test Behavior2");

    }

    var rend_test_action = function(ly){
        fn_act02_01 = function(){
             alert("hello , this is in action act02, fn_act02_01");
        }
        fn_act01_01 = function(){
             alert("hello , this is in action act01, fn_act01_01, and will do act02 now");
             ly.do_action("act02");
        }        

        fn_act01_02 = function(){
             alert("hello , this is in action act01, fn_act01_02, and will add act02 now");
             ly.add_action("act02", fn_act02_01);
        }
        //alert("will add action now ");
        //ly.add_action("act01", fn_act01_02, 10, 1);
        //ly.add_action("act01", fn_act01_01);

        //alert("will do action now ");
        //ly.do_action("act01");

    }

    var rend_related = function(ly){

         var str = ly.$ctx.find('div.caroufredsel_wrapper').html();

         str = str.replace(/class="products"/, 'class="products2"');
         ly.res = str;
         //console.log( " now in rend_related, str is : " + ly.res);
         


    }    

    var echo_related = function(ly){


           //ly.$ctx.find('ul.products').remove();
           //ly.$ctx.find('div.caroufredsel_wrapper').html(ly.res);
           /*
           ly.$ctx.find('div.caroufredsel_wrapper').remove();
           ly.$ctx.prepend(ly.res);

           $.getScript("/wp-content/plugins/wd_quickshop/js/jquery.carouFredSel-6.2.1.min.js")
                  .done(function() {				      
                        console.log(" will config caroufredsel now");
                        ly.$ctx.find('ul.products2').carouFredSel({
                            responsive:  true,
                            debug       : true,
			    auto        : false,
			    scroll      : 1,
                            swipe : { onMouse: true, onTouch: true },
			    items       : {
				   visible : 4, 
				   width   : 283,
				   height  : 'auto'
                                   //height  : 246 
				 },
			    width       : "100%",
			    height      : "auto",
                            prev : '#wd_single_related_prev',
                            next : '#wd_single_related_next'                  
           
	  
                          });
	           });
             */

         //ly.$ctx.find('ul.products li').attr('height', 246);
         //ly.$ctx.find('ul.products').css({'height': 246,'overflow': 'hidden'});
         ly.$ctx.find('.related_wrapper').css({'height': 283, 'overflow': 'hidden'});
         var small_size = "http://test03.vlan/wp-content/uploads/2013/12/500x500-160x160.gif";
         ly.$ctx.find('ul.products  img').attr('src', small_size);
         $.getScript("/wp-content/plugins/wd_quickshop/js/jquery.carouFredSel-6.2.1.min.js")
         //$.getScript("/extra2.1/patch4mall/public/jquery.carouFredSel-6.2.1.js")
                  .done(function() {				      
            
			  $(window).load(function(){  
                                 
                                var reset = function(){
  
                                   var fn_after = function(data){
                                      var txt = "";
	                               data.items.visible.each(function() {                     
                                      txt += "=====" + $(this).attr("class").split(" ")[0] + "$$$$";
	                              console.log("Now showing images:" + txt );
                                   });
                                  }


				   $(window).unbind('resize orientationchange');
                                   ly.$ctx.find('ul.products').trigger('destroy',true);
                            
				   ly.$ctx.find('ul.products').carouFredSel({
					    responsive:  true,
                                            //direction   : "up",
					    debug       : true,
					    auto        : false,
					    scroll      : {
                                                    items:   4, 
                                                    onAfter : fn_after  
                                                 },
                                           
                                             
					    swipe : { onMouse: true, onTouch: true },
					    items       : {
						   visible : 4, 
						   width   : 283,
						   height  : 'auto'
						   //height  : 246 
						 },
                                            
					    width       : "100%",
					    height      : 387,
					    prev : '#wd_single_related_prev',
					    next : '#wd_single_related_next'                  
				      });
                                  }
                                  console.log("now in $(window) load fun, setTiemout 1000 now then reset");
                                  setTimeout(reset, 1000);
				});

                  });


          // var style = ly.$ctx.find('div.caroufredsel_wrapper').attr('style');
          //style = style.replace(/height.*px/, 'height: 369px');
          //ly.$ctx.find('div.caroufredsel_wrapper').attr('style', style);

          //console.log(ly.$ctx.find('ul.products').html());
          //ly.$ctx.find('ul.products').carouFredSel({
  
          var nodes = document.getElementsByTagName('script');
/*
	re = /carouFredSel/;
	for(var i=0; i<nodes.length;i++){
	     src = nodes[i].getAttribute('src');
	  if(re.test(src)) {    
                   nodes[i].onload = nodes[i].onreadystatechange = function () {
                           console.log("now carouFredsel have loaded");   
                           }
               console.log(" have carouFredSel script");
          }
        }
*/
         
    }

// ==============================================================================
//                         Wrap  Area  
// ==============================================================================
 
       
    var fn_wrap = function(){
         alert("in fn_wrap. fire before rend   ");
         return true;
    }
    
    var fn_wrap2 = function(){
         alert("in fn_wrap. fire after rend before echo   ");
         return true;
    }

    var data_bind = function(){
    	  alert("in data_bin. this function already mv the rend and echo by layers  ");
  
    }

// ==============================================================================
//                         Control  Area  
// ==============================================================================
    
    var rend = function(ly) {  console.log("in rend " + ly.npath); };
    var echo = function(ly) {  console.log("in echo: " + ly.npath ); };
    
    //alert("in rendpage now"); 
    
    
    env.map = [
          { "path": "div#content .images:first", "rend": rend_imgs, "echo": echo_imgs },
          { "path": "div.summary.entry-summary", "rend": rend, "echo": echo_summary },
          { "path": "div#multitabs-detail", "rend":rend_test_action, "echo":echo_tabs },
          { "path": "div.related.products", "rend": rend_related,  "echo":echo_related }
        ];
 
    env.wrap = [
      { "fn": fn_wrap,  "type": 0, "filter": null },
      { "fn": fn_wrap2, "type": 1, "filter": "div #tab-wd_custom" },
      { "fn": data_bind, "type": 0, "filter": null}
    ];

    dispatch(env);
}
            
