
//====================  20150805  V8.0 

function rend(lyPage){

  console.log("hello , this is dyload/ re_page.js");
  $.getScript("/extra2.1/patch4mall/public/dyload/layer.js")
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
  
    var w_wrap = function() {  console.log("in wrap: ");}
    

// --------------------------------------------

    env.map = [
          { "path": "div#test", "rend":m_rend, "echo":m_echo }
        ];
 
    
    env.wrap = [
      { "fn": w_wrap,  "type": 0, "filter": null }
    ];
    
    dispatch(env);

   }
