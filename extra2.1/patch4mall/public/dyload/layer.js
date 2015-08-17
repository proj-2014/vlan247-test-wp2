

function layer(p){    	
     this.id = "id of layer";
     this.npath = p;  
     this.$ctx = $(p);
     this.res = $(p).html();
     this.args = {};
		  
     var fn_action = new Array() ;
      
     this.add_action = function(tag, fn_to_add, priority, accepted_args){
		var flag = false; 
		for(var i=0; i<fn_action.length && !flag; i++){
		    if(fn_action[i].tag === tag){
			 fn_action[i].fn.push(fn_to_add);
			 flag = true;
		    }
		    else continue;
		}
		
		if( i==fn_action.length && !flag){
			  fn_action[i] = {};
			  fn_action[i].tag = tag;
			  fn_action[i].fn = [];
			  fn_action[i].fn.push(fn_to_add);
		}         
		
     };
     
     this.do_action = function(tag, value){
	    for(var i=0; i<fn_action.length; i++)
		if(fn_action[i].tag == tag){
			  for(var j=0; j<fn_action[i].fn.length; j++)
			      fn_action[i].fn[j](value);
		}
		else continue;
     };

     var fn_behavior = new Array();
     
     this.add_behavior = function(evt, selector, fn_to_add){
	    var item = {};
	    
	    for(var i=0; i<fn_behavior.length; i++){
		  item = fn_behavior[i];
		  if(item.evt === evt && item.fn_to_add==fn_to_add && item.selector==selector)
		      break;
	     }
	     
	    if(i==fn_behavior.length){
		  item.evt = evt;
		  item.fn_to_add = fn_to_add;
		  item.selector = selector;
		  fn_behavior.push(item);
	    }
 
            
	    this.$ctx.on(evt, selector, fn_to_add);
      }
     
     /* 
     var ly_init = function(){
	  alert("in layer. ly_init now ");
	  // init data

	  // init actions


	  // init events
	  var behav = {} ;
	  for(var i=0; i<fn_behavior.length; i++){
	       behav = fn_behavior[i];                  
	       $ctx.on(behav.evt,  behav.sel, behav.chg_img);
	  }
     }
     */     
}

function dispatch(env){
    	
              alert("in dispatch now");               
              var i=0, j=0;
              var map = env.map;
              var wrap = env.wrap;
              
              for(j=0; j<wrap.length; j++){
                       if(wrap[j].type == 0)
                          wrap[j].fn();
              }
              
              for(i=0; i<map.length; i++){              	
                      var tmp = map[i];
                      var ly = new layer(tmp.path);
                      env.lys.push(ly);
                      tmp.rend(ly);
              }
              
              for(j=0; j<wrap.length; j++){
                       if(wrap[j].type == 1)
                          wrap[j].fn();
              }
              
              for(i=0; i<map.length; i++){              	
                      var tmp = map[i];
                      var ly = env.lys[i];
                      tmp.echo(ly);
              }
              
              for(j=0; j<wrap.length; j++){
                       if(wrap[j].type == 2)
                          wrap[j].fn();
              }
    }
    

