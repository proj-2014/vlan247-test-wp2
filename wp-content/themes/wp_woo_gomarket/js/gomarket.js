function em_search_bar(){
	jQuery(".search-input").val('Search');
	searchinput = jQuery(".search-input"),
	searchvalue = searchinput.val();
	searchinput.click(function(){
		if (jQuery(this).val() === searchvalue) jQuery(this).val("");
	});
	searchinput.blur(function(){
		if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
	});
}

if (typeof checkIfTouchDevice != 'function') { 
    function checkIfTouchDevice(){
        touchDevice = !!("ontouchstart" in window) ? 1 : 0; 
		if( jQuery.browser.wd_mobile ) {
			touchDevice = 1;
		}
		return touchDevice;      
    }
}

function get_layout_config( container_width, number_item){
	ret_value = new Array(283,'100%',number_item);
	if( container_width >= 960 ){
		var _num_show = Math.min(number_item,4);
		ret_value[1] = _num_show*25 + "%";
		ret_value[2] = _num_show;
		return ret_value;
	}
	if( container_width > 600 && container_width < 960 ){
		var _num_show = Math.min(number_item,3);
		ret_value[0] = 380;
		ret_value[1] = _num_show*33.3333333333 + "%";
		ret_value[2] = _num_show;
		return ret_value;
	}
	if( container_width <= 600 && container_width > 380 ){
		ret_value[0] = 380;
		var _num_show = Math.min(number_item,2);
		ret_value[1] = _num_show*50 + "%";
		ret_value[2] = _num_show;
		return ret_value;
	}
	if( container_width < 380 ){
		ret_value[2] = 1;
	}
	//ret_value[0] = 380;
	return ret_value;
}

function number_animate(val_){
	var	text	= jQuery(val_),endVal	= 0,currVal	= 0,obj	= {};
	var value = jQuery(val_).text();
	obj.getTextVal = function() {
		return parseInt(currVal, 10);
	};

	obj.setTextVal = function(val) {
		currVal = parseInt(val, 10);
		text.text(currVal);
	};

	obj.setTextVal(0);
	currVal = 0; // Reset this every time
	endVal = value;

	TweenLite.to(obj, 2, {setTextVal: endVal, ease: Power2.easeInOut});
}

function sticky_main_menu( on_touch ){
		var _topSpacing = 0;
		if( jQuery('body').hasClass('logged-in') && jQuery('body').hasClass('admin-bar') && jQuery('#wpadminbar').length > 0 ){
			_topSpacing = jQuery('#wpadminbar').height();
		}
		if( !on_touch && jQuery(window).width() > 768 ){
			jQuery(".header-top").sticky({topSpacing:_topSpacing});
		}
}




function hexToRgb(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function set_header_bottom(){
    var header_bottom_height = jQuery(".header-bottom").outerHeight();
    //console.log(header_bottom_height);
    jQuery(".header-bottom").css("bottom","-"+header_bottom_height+"px");
    jQuery(".main-slideshow").css("min-height",header_bottom_height + "px");
}

function set_cloud_zoom(){
	var clz_width = jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').width();
	var clz_img_width = jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').children('img').width();
	var cl_zoom = jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').not('.on_pc');
	var temp = (clz_width-clz_img_width)/2;
	if(cl_zoom.length > 0 ){
		cl_zoom.data('zoom',null).siblings('.mousetrap').unbind().remove();
		cl_zoom.CloudZoom({ 
			adjustX:temp	
		});
	}
}
function onSizeChange(windowWidth){
	if( windowWidth >= 768 ) {
			jQuery('a.block-control').removeClass('active').hide();
			jQuery('a.block-control').parent().siblings().show();
	}
	if( windowWidth < 768 ) {
			jQuery('a.block-control').removeClass('active').show();
			jQuery('a.block-control').parent().siblings().hide();
	}		

}


function change_cart_items_mobile(){
	var _cart_items = parseInt(jQuery( "#cart_size_value_head" ).text());
	_cart_items = isNaN(_cart_items) ? 0 : _cart_items;
	jQuery('.mobile_cart_container > .mobile_cart_number').text(_cart_items);
}

jQuery(document).ready(function($) {
		"use strict";
        jQuery('body').removeClass('wd_loading');
		var on_touch = checkIfTouchDevice();
		
		if (jQuery.browser.msie && jQuery.browser.version <= 10) {
			jQuery("html").addClass('ie' + parseInt(jQuery.browser.version) + " ie");
		} else {
			if (jQuery("html").attr('id') == 'wd_ie' && jQuery.browser.version == 11) {
				jQuery("html").addClass("ie11 ie");
			}
		}

		/*************** Start Woo Add On *****************/
		jQuery('body').bind( 'adding_to_cart', function() {
			jQuery('.cart_dropdown').addClass('disabled working');
		} );		

        
        //social
        jQuery("ul.social-share > li > a > span").css("position","relative").css('display', 'inline-block').css("left","500px").css("visibility","0");
		jQuery("ul.social-share > li > a > span").each(function(index,value){
			TweenMax.to( jQuery(value),0.0, { css:{left:"0px",opacity:1 },  ease:Power2.easeInOut ,delay:index*0.9});
		});
		      
        
		jQuery('.add_to_cart_button').live('click',function(event){
			var _li_prod = jQuery(this).parent().parent().parent().parent();
			_li_prod.trigger('wd_adding_to_cart');
		});
		
		jQuery('li.product').bind('wd_adding_to_cart', function() {
			jQuery(this).addClass('adding_to_cart').append('<div class="loading-mark-up"><div class="loading-image"></div></div>');
			var _loading_mark_up = jQuery(this).find('.loading-mark-up').css({'width' : jQuery(this).width()+'px','height' : jQuery(this).height()+'px'}).show();
		});
		jQuery('li.product').each(function(index,value){
			jQuery(value).bind('wd_added_to_cart', function() {
				var _loading_mark_up = jQuery(value).find('.loading-mark-up').remove();
				jQuery(value).removeClass('adding_to_cart').addClass('added_to_cart').append('<span class="loading-text"></span>');//Successfully added to your shopping cart
				var _load_text = jQuery(value).find('.loading-text').css({'width' : jQuery(value).width()+'px','height' : jQuery(value).height()+'px'}).delay(1500).fadeOut();
				setTimeout(function(){
					_load_text.hide().remove();
				},1500);
				//delete view cart		
				jQuery('.list_add_to_cart .added_to_cart').remove();
			});	
		});	
		
		
		jQuery('body').bind( 'added_to_cart', function(event) {
			var _added_btn = jQuery('li.product').find('.add_to_cart_button.added').removeClass('added').addClass('added_btn');
			var _added_li = _added_btn.parent().parent().parent().parent();
			_added_li.each(function(index,value){
				jQuery(value).trigger('wd_added_to_cart');
			});
			
			jQuery('.wd_tini_cart_wrapper').addClass('loading-cart');
			
			jQuery.ajax({
				type : 'POST'
				,url : _ajax_uri	
				,data : {action : 'update_tini_cart'}
				,success : function(respones){
					if( jQuery('.shopping-cart-wrapper').length > 0 ){
						jQuery('.shopping-cart-wrapper').html(respones);
						jQuery('.cart_dropdown,.form_drop_down').hide();
						jQuery('body').trigger('mini_cart_change');
						change_cart_items_mobile();
						setTimeout(function(){
							jQuery('.wd_tini_cart_wrapper').removeClass('loading-cart');
						},1000);
						jQuery('body').trigger('cart_widget_refreshed');
						jQuery('body').trigger('cart_page_refreshed');
					}
				}
			});			
		} );			
		jQuery('.cart_dropdown,.form_drop_down').hide();
		change_cart_items_mobile();
		
		jQuery('.wd_tini_cart_wrapper,.wd_tini_account_wrapper').hoverIntent(
			function(){
				jQuery(this).children('.drop_down_container').slideDown(300);
			}
			,function(){
				jQuery(this).children('.drop_down_container').slideUp(300);
			}
		
		);

		jQuery('body').live('mini_cart_change',function(){
			jQuery('.wd_tini_cart_wrapper,.wd_tini_account_wrapper').hoverIntent(
				function(){
					jQuery(this).children('.drop_down_container').slideDown(300);
				}
				,function(){
					jQuery(this).children('.drop_down_container').slideUp(300);
				}
			
			);
		});	
			
			
		jQuery('input.subscribe_email').focus(function(event){
			if( jQuery(this).val() == "enter your email address" ){
				jQuery(this).val("");
			}
		});	
		jQuery('input.subscribe_email').blur(function(event){
			if( jQuery(this).val() == "" ){
				jQuery(this).val("enter your email address");
			}
		});	
        

		
		setTimeout(function () {
			jQuery("div.shipping-calculator-form").show(400);
		}, 1500);
		
		jQuery("select.wd_search_product").select2();
		jQuery("select.deference_color").select2();

        
        /***** W3 Total Cache & Wp Super Cache Fix *****/
        jQuery('body').trigger('added_to_cart');
        /***** End Fix *****/
        
		/***** Start Re-init Cloudzoom on Variation Product  *****/
		jQuery('form.variations_form').live('found_variation',function( event, variation ){
			jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').CloudZoom({}); 
		}).live('reset_image',function(){
			jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').CloudZoom({}); 
		});
		/***** End Re-init Cloudzoom on Variation Product  *****/        
        
        /*************** End Woo Add On *****************/
        
        /*************** Disable QS in Main Menu *****************/
        jQuery('ul.menu').find('ul.products').addClass('no_quickshop');
        /*************** Disable QS in Main Menu *****************/
		
		
		if (jQuery.browser.msie && ( parseInt( jQuery.browser.version, 10 ) == 7 )){
			alert("Your browser is too old to view this interactive experience. You should take the next 30 seconds or so and upgrade your browser! We promise you'll thank us after doing so in having a much better and safer web browsing experience! ");
		}


		em_search_bar();
		var windowWidth = jQuery(window).width();
		
		setTimeout(function () {
			  onSizeChange(windowWidth);
		}, 1000);	
		
        jQuery('a.block-control').click(function(){
            jQuery(this).parent().siblings().slideToggle(300);
            jQuery(this).toggleClass('active');
            return false;
        });
		
		
	
		jQuery('.related-slider').flexslider({
			animation: "slide"
		});
		
		var _bind = 'click';
		if(on_touch & windowWidth >= 768 && windowWidth <= 1024){  // event for ipad
			_bind = 'mouseenter';
		}
		jQuery('.tabbable > ul.nav.nav-tabs > li > a').bind(_bind/*mouseenter click.tab.data-api mousedown*/,function(e){
			if(jQuery(this).parent('li').hasClass('active'))	
				return;
			var temp = jQuery(this).attr('href'); //tab select content
			
			if(jQuery(this).closest('.tabbable').hasClass('has_slider')){ //check co slide trong tab
				var doc = jQuery(temp).find('.featured_product_slider_wrapper');
				if(doc.length > 0 ) {
					jQuery(temp).closest('.tab-content').addClass('wd_loading');
					var doc_column = doc.attr('data_column');	
					var id_shortcode =  doc.attr('id');	

					if(!on_touch || 1){
						var content_height = jQuery(temp).closest('.tab-content').height();	
						jQuery(temp).css('height',content_height);					
			//			jQuery(temp).css('visibility','hidden');
						setTimeout(function(){
							//destroy slider
							jQuery('.tabbable.has_slider #' + id_shortcode).find("ul.products").trigger('destroy',true);		
							
							jQuery(temp).find("ul.products li").hide().filter(':lt('+doc_column+')').show(0); 
							
							jQuery('.tabbable.has_slider').trigger('tabs_change',[id_shortcode]);					
						},200);
					} else {
						//jQuery('.tabbable.has_slider #' + id_shortcode).find("ul.products").trigger('destroy',true);
						//goi tab change
						setTimeout(function(){
							jQuery('.tabbable.has_slider').trigger('tabs_change',[id_shortcode]);	
						},500);
					}
				}
				//return false;
			}
		});

		
		jQuery('li.shortcode').hover(function(){
			jQuery(this).addClass('shortcode_hover')},function(){jQuery(this).removeClass('shortcode_hover');});
		

		//call review form
		jQuery('.wd-review-link').click(function(){
			if(jQuery('.woocommerce-tabs').length > 0){
				jQuery('.woocommerce-tabs li.reviews_tab').children('a').trigger('click');
			}
		}).trigger('click');
		
		////////// Generate Tab System /////////
		if(jQuery('.tabs-style').length > 0){
			jQuery('.tabs-style').each(function(){
				var ul = jQuery('<ul></ul>');
				var divPanel = jQuery('<div></div>');
				var liChildren = jQuery(this).find('li.tab-item');
				var length = liChildren.length;
				divPanel.addClass('panel');
				jQuery(this).find('li.tab-item').each(function(index){
					jQuery(this).children('div').appendTo(divPanel);
					if(index == 0)
						jQuery(this).addClass('first');
					if(index == length - 1)
						jQuery(this).addClass('last');
					jQuery(this).appendTo(ul);
					
				});
				jQuery(this).append(ul);
				jQuery(this).append(divPanel);
				
					jQuery( this ).tabs({ fx: { opacity: 'toggle', duration:'slow'} }).addClass( 'ui-tabs-vertical ui-helper-clearfix' );
				
			});		
		}
		

		
		// Toggle effect for ew_toggle shortcode
		jQuery( '.toggle_container a.toggle_control' ).click(function(){
			if(jQuery(this).parent().parent().parent().hasClass('show')){
				jQuery(this).parent().parent().parent().removeClass('show');
				jQuery(this).parent().parent().parent().addClass('hide');
				jQuery(this).parent().parent().children('.toggle_content ').hide('slow');
			}
			else{
				jQuery(this).parent().parent().parent().addClass('show');
				jQuery(this).parent().parent().parent().removeClass('hide');
				jQuery(this).parent().parent().children('.toggle_content ').show('slow');
			}
				
		});
		
        
        
        //fancy box
        var fancy_wd = jQuery("a.fancybox").fancybox({
			// 'openEffect'	: 'elastic'
			// ,'closeEffect'	: 'elastic'
			// ,'openEasing'   : 'easeOutBack'
			// ,'closeEasing'  : 'easeOutBack'
			// ,'nextEasing'   : 'easeOutBack'
			// ,'prevEasing'	: 'easeOutBack'		
			// 'openSpeed'    : 500
			// ,'openSpeed'	: 500
			// ,'nextSpeed'	: 1000
			// ,'prevSpeed'    : 1000
			'scrolling'	: 'no'
			,'mouseWheel'	: false

			,beforeLoad  : function(){
					tmp_href = this.href;
					if( this.href.indexOf('youtube.com') >= 0 || this.href.indexOf('youtu.be') >= 0 ){
						this.type = 'iframe';
						this.scrolling = 'no';
						//&html5=1&wmode=opaque
						this.href = this.href.replace(new RegExp("watch\\?v=", "i"), 'embed/') + '?autoplay=1';
					}
					else if( this.href.indexOf('vimeo.com') >= 0 ){
						this.type = 'iframe';
						this.scrolling = 'no';					
						//this.href = this.href.replace(new RegExp("([0-9])","i"),'moogaloop.swf?clip_id=$1') + '&autoplay=1';
						var regExp = /http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/;
						var match = this.href.match(regExp);
						this.href = 'http://player.vimeo.com/video/' + match[2] + '?portrait=0&color=ffffff';
					}
					else{
						//this.type = null;
					}
					
					
			}
			,afterClose : function(){
					this.href = tmp_href;
			}		
			,afterShow  : function(){
				jQuery('.fancybox-wrap').wipetouch({
					tapToClick: true, // if user taps the screen, triggers a click event
					wipeLeft: function(result) { 
						jQuery.fancybox.next();
					},
					wipeRight: function(result) {
						jQuery.fancybox.prev();
					}
				});					
				if( jQuery('.fancybox-prev-clone').length <= 0 )
					jQuery('.fancybox-prev').clone().removeClass('fancybox-nav fancybox-prev').addClass('fancybox-prev-clone').appendTo(".fancybox-overlay");
				
				if( jQuery('.fancybox-next-clone').length <= 0 )
					jQuery('.fancybox-next').clone().removeClass('fancybox-nav fancybox-next').addClass('fancybox-next-clone').appendTo(".fancybox-overlay");
				
				if( jQuery('.fancybox-close-clone').length <= 0 )
					jQuery('.fancybox-close').clone().removeClass('fancybox-item fancybox-close').addClass('fancybox-close-clone').appendTo(".fancybox-overlay");
			
				if( jQuery('.fancybox-title-clone').length <= 0 )
					jQuery('.fancybox-title').clone().addClass('fancybox-title-clone').appendTo(".fancybox-overlay");
				else{
					jQuery('.fancybox-title-clone').html( jQuery('.fancybox-wrap').find('.fancybox-title').html() );
				}	
				jQuery('.fancybox-wrap').find('.fancybox-title').hide();				
				
				jQuery('.fancybox-wrap').find('.fancybox-prev').hide();
				jQuery('.fancybox-wrap').find('.fancybox-next').hide();
				jQuery('.fancybox-wrap').find('.fancybox-close').hide();
				
			}			
			
		}); 
        
        jQuery('.fancybox-prev-clone').live('click',function(){
			jQuery('.fancybox-wrap').find('.fancybox-prev').trigger('click');
		});
		jQuery('.fancybox-next-clone').live('click',function(){
			jQuery('.fancybox-wrap').find('.fancybox-next').trigger('click');
		});
		jQuery('.fancybox-close-clone').live('click',function(){
			jQuery('.fancybox-wrap').find('.fancybox-close').trigger('click');
		});
        
        

		jQuery('p:empty').remove();
		
		// button state demo
		jQuery('.btn-loading')
		  .click(function () {
			var btn = jQuery(this)
			btn.button('loading')
			setTimeout(function () {
			  btn.button('reset')
			}, 3000)
		  });
		
		// tooltip 
		jQuery('body').tooltip({
		  selector: "a[rel=tooltip]"
		});
	 

		
		if( jQuery('html').offset().top < 100 ){
			jQuery("#to-top").hide();
		}
		jQuery(window).scroll(function () {
			
			if (jQuery(this).scrollTop() > 100) {
				jQuery("#to-top").fadeIn();
			} else {
				jQuery("#to-top").fadeOut();
			}
		});
		jQuery('.scroll-button').click(function(){
			jQuery('body,html').animate({
			scrollTop: '0px'
			}, 1000);
			return false;
		});			

		
		jQuery('#myTab a').click(function (e) {
			e.preventDefault();
			jQuery(this).tab('show');
		});
	
		

			
		jQuery('.carousel').each(function(index,value){
			jQuery(value).wipetouch({
				tapToClick: false, // if user taps the screen, triggers a click event
				wipeLeft: function(result) { 
					jQuery(value).find('a.carousel-control.right').trigger('click');
					//jQuery(value).carousel('next');
				},
				wipeRight: function(result) {
					jQuery(value).find('a.carousel-control.left').trigger('click');
					//jQuery(value).carousel('prev');
				}
			});	
		});
		
		
		
        set_cloud_zoom();
		// Set menu on top
		//sticky_main_menu( on_touch );
		if( on_touch == 0 ){
			jQuery(window).bind('resize',jQuery.throttle( 250, 
				function(){
					if( !( jQuery.browser.msie &&  parseInt( jQuery.browser.version, 10 ) <= 7 ) ){
						onSizeChange( jQuery(window).width() );
 //                       set_header_bottom();
						set_cloud_zoom();
						menu_change_state( jQuery('body').innerWidth() );	
					}
				})
			);
		}else{
			jQuery(window).bind('orientationchange',function(event) {	
					onSizeChange( jQuery(window).width() );
//                    set_header_bottom();
					set_cloud_zoom();
					menu_change_state( jQuery('body').innerWidth() );				
			});
		}

		
        
		jQuery(".right-sidebar-content > ul > li:first").addClass('first');
		jQuery(".right-sidebar-content > ul > li:last").addClass('last');
		
		
		jQuery(".product_upsells > ul").each(function( index,value ){
			jQuery(value).children("li:last").addClass('last');
		});
		

		jQuery("ul.product_list_widget").each(function(index,value){
			jQuery(value).children("li:first").addClass('first');
			jQuery(value).children("li:last").addClass('last');
		});
		jQuery(".related.products > ul > li:last").addClass('last');
		
		//home_parallax();
		jQuery(document).on('click','div.cart_totals_wrapper form.totals_form a.wd_update_button_visible',function(event){
			event.preventDefault();
			jQuery('.woocommerce form.wd_form_cart .wd_update_button_invisible').trigger('click');	
		});
		jQuery(document).on('click','.cart_totals_wrapper .checkout-button-visible',function(event){
			event.preventDefault();
			jQuery('.checkout-button').trigger('click');	
		});


		jQuery("a.wd-prettyPhoto").prettyPhoto({
			social_tools: false,
			theme: 'pp_default wd_feedback',
			horizontal_padding: 30,
			opacity: 0.9,
			deeplinking: false
			
		});
			
});