
//====================  20150805  V8.0 

function rend(lyPage){

  console.log("hello , this is dyload/ re_home.js");
  $.getScript("/extra2.1/patch4mall-2/public/dyload/layer.js")
       .done(function() {				      
            $(document).ready(function(){ render(lyPage); });
	});


}


// ======================================================

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
                            "https://lh3.googleusercontent.com/-n_uAAv3yQjc/Va7tJCiHJDI/AAAAAAAAAJs/8yIvExy2UD8/3-54d430b6Nce70cd8e.jpg"
                         ]
                 },
         map : [],
         wrap : [],
	 lys : []
    };

// -------------------------------------------


    var m_rend = function(ly) {  console.log("in rend " + ly.npath); };
    var m_echo = function(ly) {  console.log("in echo: " + ly.npath ); };
  
    var w_wrap = function() {  console.log("in wrap: ");};
    
    var m_echo_featured = function(ly) { 
         var small_size = '/wp-content/uploads/2013/12/500x500-60x60.gif';
         console.log("ly.$ctx.find img " + ly.$ctx.find('img'));
         ly.$ctx.find('img').attr('src', small_size); 
  
         ly.$ctx.css('height',662);
    };
   
    var m_echo_popular = function(ly) {
         var small_size = '/wp-content/uploads/2013/12/500x500-160x160.gif';
         console.log("ly.$ctx.find img " + ly.$ctx.find('img'));
         ly.$ctx.find('img').attr('src', small_size); 
  


    };
 
    var m_echo_custom = function(ly){
         // no yeah finish  ....
         var small_size = '/wp-content/uploads/2013/12/500x500-160x160.gif';
         console.log("ly.$ctx.find img " + ly.$ctx.find('img'));
         ly.$ctx.find('img').attr('src', small_size); 

    };


// --------------------------------------------

    env.map = [
          { "path": "div.featured_product_slider_content", "rend": m_rend, "echo":m_echo_featured },
          { "path": "div.wd_popular_product_wrapper" , "rend":m_rend, "echo":m_echo_popular },
         { "path": "div.custom_category_shortcode_grid", "rend":m_rend, "echo":m_echo_custom},
          { "path": "div#test", "rend":m_rend, "echo":m_echo }
        ];
 
    
    env.wrap = [
      { "fn": w_wrap,  "type": 0, "filter": null }
    ];
    
    dispatch(env);

}

