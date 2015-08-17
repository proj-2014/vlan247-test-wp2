
window.$=window.jQuery; 

function test(){
  
    alert("helelo");

}
    


Behavior2.Class('desc', 'div#multitabs-detail', {
	  click: {
            '.tab-content': 'hide'
	  }
	}, function($ctx, that) {
	  console.log('hello this is that');
          //alert("now in Behavior function");
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

