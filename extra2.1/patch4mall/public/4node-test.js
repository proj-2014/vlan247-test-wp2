
window.$=window.jQuery; 

$(document).ready(test);

function test() {
    
        //alert("now in test");
 }

 Behavior2.Class("MoreText", "span.more-expand", { 
      click: { //event mapping
          'a.more':'more', //selector: function name
          'a.less':'less'
      }
      //$ctx is a single 'span.more-expand' span.
      //that is a special object to which you bind event functions defined above
      //this function is executed once per every 'span.more-expand' span
  }, function ($ctx, that) {
  
      //these variables are 'global' to all your event handler functions 
      //they are also private
      var $pruned = $ctx.find("span.pruned");
      var $all = $ctx.find("span.all");
  
      that.more = function (e) { //event handler for click on 'a.more'
          e.preventDefault();
          $pruned.hide();
          $all.show();
      };
      that.less = function(e){ //event handler for click on 'a.less'
          e.preventDefault();
          $pruned.show();
          $all.hide();
      };
  });

	Behavior2.Class('desc', 'div#wrap', {
	  click: {
	    'p.ppp': 'hide'
	  }
	}, function($ctx, that) {
	  console.log('hello this is that');
          alert("now in Behavior function");
	  var $ele;    
	  $ele = $ctx.find("h2");
	  that.hide = function(e) {
            alert("now in hide");
	    e.preventDefault();
	    $target = $(e.currentTarget);
	    $ele.remove();
	    $target.hide();
	    //alert("remove");
	    return Behavior2.contentChanged();
	    };
	});


Behavior2.Class('testAJAX', 'div.testajax', {
  click: {
    'a.more-link': 'addImage'
  }
}, function($ctx, that) {
	console.log('hello this is that');
  var ajax;    
  ajax = function(method) {
      
      var $postid = 444;
      return $.ajax({
        url: "/node/hello",
        //dataType: 'json',
        method: method,
        //data: 'action=get_featured&postid=' + $postid, 
        success: function (str) {
                     if (str)
                         alert(str);
                 }
      });
    };
  that.addImage = function(e) {
    alert("now in addImage");
  	e.preventDefault();
    ajax('get');
    $target = $(e.currentTarget);
    //$target.hide();
    return Behavior2.contentChanged();
  };
    
   });
