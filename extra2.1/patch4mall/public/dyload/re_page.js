
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
                    page: 1,
                    num: 10,
                    items: [
                       {"img": "http://img14.360buyimg.com/n0/jfs/t484/116/1403674785/178337/934c9d68/54d430b8Nd84c2b9e.jpg",
                             "title": "demo test", "price": 666 },
                       {"img": "http://img14.360buyimg.com/n0/jfs/t511/202/1419770639/148358/2c39ecf2/54d430bbNef502130.jpg",
                             "title": "also test", "price": 222 }



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
    
    var m_echo_items = function(ly){
         
       ly.$ctx.find("li").each(function(){
                  var str = $(this).attr('class');
                  var re = /^post-(\d+)/;
                  var group = re.exec(str);  
                  var  id = group[1];   
                  console.log("cur id is " + id + " class is "+ str);

                  idx = parseInt(id/10)%2;
                  var src = env.pdata.items[idx].img;
                  $(this).find('img').attr('src', src) ;
                  $(this).find('.product-title a').html(env.pdata.items[idx].title);
                  $(this).find('.product_sku').html(id);
                  $(this).find('.price').html(env.pdata.items[idx].price);
                
             }); 

    }


// --------------------------------------------

    env.map = [
          { "path": "ul.products", "rend":m_rend, "echo":m_echo_items }
        ];
 
    
    env.wrap = [
      { "fn": w_wrap,  "type": 0, "filter": null }
    ];
    
    dispatch(env);

   }
