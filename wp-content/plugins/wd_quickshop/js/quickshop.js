/**
 * WD QuickShop
 *
 * @license commercial software
 * @copyright (c) 2013 Codespot Software JSC - WPDance.com. (http://www.wpdance.com)
 */



(function($) {

	// disable QuickShop:
	if(jQuery('body').innerWidth() < 768)
		EM_QUICKSHOP_DISABLED = true;

	jQuery.noConflict();
	qs = null;
	jQuery(function ($) {
			//insert quickshop popup
			 $('#em_quickshop_handler').prettyPhoto({
				deeplinking: false
				,opacity: 0.9
				,social_tools: false
				,default_width: jQuery('body').innerWidth()/8*5
				,default_height: "innerHeight" in window ? ( window.innerHeight - 150 ) : (document.documentElement.offsetHeight - 150)
				//,default_height: window.innerHeight - 150
				,theme: 'pp_woocommerce'
				,changepicturecallback : function(){
					$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added');//.append('<input type="button" value="+" id="add1" class="plus" />').prepend('<input type="button" value="-" id="minus1" class="minus" />');
					$('.pp_inline').find('form.variations_form').wc_variation_form();
					$('.pp_inline').find('form.variations_form .variations select').change();	
					
					var _li_count = jQuery('.qs-thumbnails > li').length;
					if( _li_count > 0 ){
						_li_count = Math.min(_li_count,4);
					}else{
						_li_count = 4;
					}

					jQuery('.qs-thumbnails').carouFredSel({		
						responsive: true
						,width	: _li_count*25 + '%'
						,height	: 88
						,scroll	: 1
						,swipe	: { onMouse: false, onTouch: true }	
						,items	: {
							width		: 85
							,height		: 85
							,visible	: {
								min		: 1
								,max	: 4
							}
						}
						,auto	: false
						,prev	: '#qs_thumbnails_prev'
						,next	: '#qs_thumbnails_next'								
					});
					
					if(jQuery.cookie("woocommerce_current_currency") !== undefined){
						fx.rates           = wc_currency_converter_params.rates;
						fx.base            = wc_currency_converter_params.base;
						fx.settings.from   = wc_currency_converter_params.currency;
						var to_currency = jQuery.cookie("woocommerce_current_currency"); 
						var currency_position = wc_currency_converter_params.currency_pos;
						var currency_codes    = jQuery.parseJSON( wc_currency_converter_params.currencies );
						var price_object = jQuery('.pp_woocommerce span.amount');
						jQuery('.pp_woocommerce span.amount').each(function(){
							var original_code = jQuery(this).attr("data-original");
							if (typeof original_code == 'undefined' || original_code == false) {
								jQuery(this).attr("data-original", jQuery(this).html());
							}
							var original_price = jQuery(this).attr("data-price");
							if (typeof original_price == 'undefined' || original_price == false) {
								original_price = jQuery(this).text();
								
								// Small hack to prevent errors with $ symbols
								jQuery( '<del></del>' + original_price ).find('del').remove();								
								// Remove formatting
								original_price = original_price.replace( wc_currency_converter_params.thousand_sep, '' );
								original_price = original_price.replace( wc_currency_converter_params.decimal_sep, '.' );
								original_price = original_price.replace(/[^0-9\.]/g, '');
								original_price = parseFloat( original_price );
								
								jQuery(this).attr("data-price", original_price);
							}
							price = fx( original_price ).to( to_currency ).toFixed(2);
							//console.log(original_price);
							//console.log(price);
							if ( currency_codes[ to_currency ] ) {

								if ( currency_position == 'left' ) {

									jQuery(this).html( currency_codes[ to_currency ] + price );

								} else if ( currency_position == 'right' ) {

									jQuery(this).html( price + " " + currency_codes[ to_currency ] );

								} else if ( currency_position == 'left_space' ) {

									jQuery(this).html( currency_codes[ to_currency ] + " " + price );

								} else if ( currency_position == 'right_space' ) {

									jQuery(this).html( price + " " + currency_codes[ to_currency ] );

								}

							} else {

								jQuery(this).html( price + " " + to_currency );

							}
						});	
					}
				}
			});
		
		function hide_element( jquery_obj ){
			TweenMax.to( jquery_obj , 0.4, {	css:{
													//visibility: 'invisible'
													opacity : 0
													,display : 'none'
												}			
											,ease:Power2.easeInOut
										}
						);
		}
		
		
		// quickshop init
		function _qsJnit() {
			var selectorObj = arguments[0];
			var listprod = $(selectorObj.itemClass);	// selector chon tat ca cac li chua san pham tren luoi
			var baseUrl = '';
			
			var qsHandlerImg = $('#em_quickshop_handler img');
			var qsHandler = $('#em_quickshop_handler');

			$.each(listprod, function (index, value) {
				var _ul_prods = $(value).parents("ul.products");
				if( !_ul_prods.hasClass('no_quickshop') ){

					// show quickshop handle when hover product image
					$(value).live('mouseover', function () {
						var o = $(this).offset();
						var qs_btn = $('#em_quickshop_handler');
						var _ajax_uri = _qs_ajax_uri + "?ajax=true&action=load_product_content&product_id="+jQuery(value).siblings(selectorObj.inputClass).val();
						qsHandler.attr('href', _ajax_uri );
                        var temp = 0 ;
                        //if(jQuery("div#wpadminbar").length > 0) {
                        //    temp = jQuery("div#wpadminbar").height();
                        //}
						TweenMax.to( qsHandler , 0.1, {	css:{
																top: Math.round(o.top + ( $(this).height() - qs_btn.height() )/2 - temp ) +'px'
																,left:  Math.round(o.left+( $(this).width() - qs_btn.width() )/2)+'px'
																,opacity : 1
																,display : 'block'
															}			
															,ease:Linear.linear
													}
									);

					});
					$(value).live('mouseout', function (event) {
						var _to_element = event.relatedTarget || event.toElement;

						if( typeof _to_element !== "null" && typeof _to_element !== "undefined" ){
							if( $(_to_element).length > 0 ){
								var _cur_id = $(_to_element).attr('id');
								if( typeof _cur_id !== "undefined" ){
									if( _cur_id != "em_quickshop_handler" && _cur_id != "qs_inner1" && _cur_id != "qs_inner2" ){
										hide_element(qsHandler);
									}else{
										$(value).find('.product-main-link').trigger('mouseover');
									}
								}else{
									hide_element(qsHandler);
								}
							}else{
								hide_element(qsHandler);
							}
						}else{
							hide_element(qsHandler);


						}
					});
					
				}
			});

			//fix bug image disapper when hover
			qsHandler.live('mouseover', function () {
				$(this).show().css('opacity','1');
			}).live('click', function (event) {		
				hide_element(qsHandler);
				
				event.preventDefault();
			});
			$('#real_quickshop_handler').click(function(event){
				event.preventDefault();
			});

			$('.wd_quickshop.product').live('mouseover',function(){
				if( !$(this).hasClass('active') ){
					$(this).addClass('active');
					$('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').CloudZoom({});							
				}
			});
			
			//fix bug group 0 qty, and out of stock
			$('.wd_quickshop.product form button.single_add_to_cart_button').live('click',function(){
				
				if($('.wd_quickshop.product form table.group_table').length > 0){
					$('.wd_quickshop.product').prev('ul.woocommerce-error').remove();
					temp = 0;
					
					$('.wd_quickshop.product form table.group_table').find('input.qty').each(function(i,value){
						var td_cur = $(value).closest( "td" );
						
						if($(value).val() > temp && !td_cur.next().hasClass('wd_product_out-of-stock'))
							temp = $(value).val();
					});
					if(temp == 0) {
						$('.wd_quickshop.product').before( $( "<ul class=\'woocommerce-error\'><li>Please choose the quantity of items you wish to add to your cart…</li></ul>" ) );
						return false;
					}	
				}
			});
			
		}

		if (typeof EM_QUICKSHOP_DISABLED == 'undefined' || !EM_QUICKSHOP_DISABLED)
		
			/*************** Disable QS in Main Menu *****************/
			jQuery('ul.menu').find('ul.products').addClass('no_quickshop');
			//jQuery('div.custom-product-shortcode').find('ul.products').addClass('no_quickshop');
			/*************** Disable QS in Main Menu *****************/		
		
			_qsJnit({
				itemClass		: '.products li.product.type-product.status-publish .product_thumbnail_wrapper, .custom_category_shortcode .images' //selector for each items in catalog product list,use to insert quickshop image
				,inputClass		: 'input.hidden_product_id' //selector for each a tag in product items,give us href for one product
			});
			qs = _qsJnit;
	});
})(jQuery);

