(function() {	
	tinymce.PluginManager.add( 'Wd_shortcodes' , function( editor ){
		editor.addButton('wd_shortcodes_button', {
			type: 'menubutton',
			icon: 'icon wd_shortcodes_button',
			tooltip: 'WPDance Shortcodes',
			classes: 'btn widget wpdance',
			menu:[
					{
						text: "WD Ecommerce shortcode", 
						menu:
						[
							{
								text: "Feature", 
								value: '[feature slug="" id="" title="yes" thumbnail="yes" excerpt="yes" content="yes"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "Testimonial", 
								value: '[testimonial style="" slug="" id=""]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Custom product", 
								value: '[custom_product id="" sku="" title=""]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Custom products", 
								value: '[custom_products ids="" skus="" ]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Custom products category", 
								value: '[custom_products_category category="" per_page="5" title="custom_products_category" orderby="date" order="desc" show_image="1" show_title="1" show_sku="1" show_price="1" show_label="1" show_rating="0" show_categories="0" show_short_content="0"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Custom products category Grid image", 
								value: '[custom_products_category_grid_image category="" style="pink" per_page="4" title="" orderby="date" order="desc"  show_image="1" show_title="1" show_sku="1" show_price="1" show_label="1" show_rating="0" show_categories="0" show_short_content="0" image_url="#"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Custom products category Grid no image", 
								value: '[custom_products_category_grid_noimage category="" per_page="10" columns="4" title="" orderby="date" order="desc" show_heading_title="0" show_image="1" show_title="1" show_sku="1" show_price="1" show_readmore="1" show_label="1" show_rating="0" show_categories="0" show_short_content="0"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Custom products category list slider", 
								value: '[wd_product_category_list_slider category="" style="pink" per_page="10" orderby="date" order="desc" show_image="1" show_title="1" show_sku="1" show_price="1" show_label="1" show_rating="0" show_categories="0" show_short_content="0"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Popular product", 
								value: '[wd_popular_product category="" style="pink" title="" orderby="date" order="desc" show_image="1" show_availability="1" show_readmore="1" show_related="1" show_title="1" show_sku="1" show_price="1" show_label="1" show_rating="0" show_short_content="0"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Feature product slider", 
								value: '[featured_product_slider columns="4" layout="big" per_page="15" title="your title" desc="" show_nav="1" show_icon_nav="0" show_image="1" show_title="1" show_sku="1" show_price="1" show_label="1" show_rating="1" show_product_tag="1" show_categories="0" show_short_content="1"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Popular product slider", 
								value: '[popular_product_slider columns="4" layout="small" per_page="8" title="Enter your title" desc="" show_nav="1" show_icon_nav="1" show_image="1" show_title="1" show_sku="0" show_price="1" show_label="1" show_rating="1" show_categories="0" show_short_content="1"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Recent product slider", 
								value: '[recent_product_slider columns="4" layout="small" per_page="8" title="Enter your title" desc="" show_nav="1" show_icon_nav="1" show_image="1" show_title="1" show_sku="1" show_price="1" show_label="1" show_rating="1" show_categories="1" show_short_content="1"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Best selling product slider", 
								value: '[best_selling_product_slider columns="4" show_heading_title="0" layout="small" per_page="8" title="Enter your title" desc="" product_tag="all-product-tags" show_nav="1" show_icon_nav="1" show_image="1" show_title="1" show_sku="1" show_price="1" show_label="1" show_rating="1" show_categories="1" show_short_content="1"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Best selling product by categories slider", 
								value: '[best_selling_product_by_category_slider cat_slug="" columns="4" layout="small" per_page="8" title="Enter your title" show_heading_title="0" desc="" product_tag="all-product-tags" show_icon_nav="0" show_nav="1" show_image="1" show_title="1" show_sku="1" show_price="1" show_label="1"  show_rating="0" show_categories="0" show_short_content="0" ]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "[WD]Recent product by categories slider", 
								value: '[recent_product_by_categories_slider cat_slug="" columns="4" layout="small" per_page="8" title="" desc=""  product_tag="all-product-tags" show_nav="1" show_icon_nav="0" show_image="1" show_title="1" show_sku="1" show_price="1" show_label="1" show_rating="0" show_categories="0"  show_short_content="0"]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
						]
					}
					,{
						text: "Add line", 
						value: '[add_line height_line="" color="" class=""]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Align", 
						value: '[align  style=""][/align]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Accordion", 
						value: '[accordions][accordion_item title="title"]your_content[/accordion_item][/accordions]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Alert", 
						value: '[ alert style="" close="" ]your_content[ /alert]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Badges", 
						value: '[badge type=""]your_content[/badge]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Banner", 
						value: '[banner link_url="#" bg_image="" bg_color="#df2323" title="" font_size_title="44" title_color="#ffffff" subtitle="" font_size_subtitle="18" subtitle_color="" border_color="" top_padding="173px" left_padding="20px" bottom_padding="10px" right_padding="20px" inner_stroke="0" inner_stroke_color="#fff" sep_padding="20px" sep_color="#fff" label="no" label_text="" label_bg_color="" label_text_color=""]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Buttons", 
						value: '[button size="" link="#" background="" opacity="" color=""]button text[/button]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Checklist", 
						value: '[checklist icon=""]your_content[/checklist]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Code", 
						value: '[code]your_content[/code]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Columns", 
						menu:
						[
							{
								text: "1/2", 
								value: '[one_half]your_content[/one_half]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "1/3", 
								value: '[one_third]your_content[/one_third]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "1/4", 
								value: '[one_fourth]your_content[/one_fourth]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "1/5", 
								value: '[one_fifth]your_content[/one_fifth]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "1/6", 
								value: '[one_sixth]your_content[/one_sixth]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "2/3", 
								value: '[two_third]your_content[/two_third]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "3/4", 
								value: '[three_fourth]your_content[/three_fourth]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "2/5", 
								value: '[two_fifth]your_content[/two_fifth]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "3/5", 
								value: '[three_fifth]your_content[/three_fifth]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "4/5", 
								value: '[four_fifth]your_content[/four_fifth]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "5/6", 
								value: '[five_sixth]your_content[/five_sixth]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "1/2 last", 
								value: '[one_half_last]your_content[/one_half_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "1/3 last", 
								value: '[one_third_last]your_content[/one_third_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "1/4 last", 
								value: '[one_fourth_last]your_content[/one_fourth_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "1/5 last", 
								value: '[one_fifth_last]your_content[/one_fifth_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "1/6 last", 
								value: '[one_sixth_last]your_content[/one_sixth_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "2/3 last", 
								value: '[two_third_last]your_content[/two_third_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "3/4 last", 
								value: '[three_fourth_last]your_content[/three_fourth_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "2/5 last", 
								value: '[two_fifth_last]your_content[/two_fifth_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "3/5 last", 
								value: '[three_fifth_last]your_content[/three_fifth_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "4/5 last", 
								value: '[four_fifth_last]your_content[/four_fifth_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "5/6 last", 
								value: '[five_sixth_last]your_content[/five_sixth_last]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
						]
					}
					,{
						text: "Dropcap", 
						value: '[dropcap color=""]your_text[/dropcap]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Faq", 
						value: '[faq title=""]your_content[/faq]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Google Map", 
						value: '[google_map address="" title="" height="360" zoom="16" map_type="TERRAIN" map_color="" water_color="" road_color=""]your_content[/google_map]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Heading", 
						value: '[heading size=""]your_content[/heading]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Hidden phone", 
						value: '[hidden_phone]your_content[/hidden_phone]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Hr", 
						value: '[hr style="" class=""]your_content[/hr]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Icon", 
						value: '[icon icon=""]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Label", 
						value: '[label type=" "]your_text[/label]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Listing", 
						value: '[ew_listing custom_class="" style_class=""]your_content[/ew_listing]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Menu", 
						value: '[menu menu="" depth="1"]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Progress bar", 
						value: '[progress animated_bars="" striped_bars=""][bar style="" percent_bars=""]Text[/bar][/progress]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Quote", 
						value: '[quote class=""]your_content[/quote]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Recent post", 
						value: '[recent_blogs category="" columns="1" number_posts="4" title="yes" thumbnail="yes" meta="no" excerpt="yes" excerpt_words="30"]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
					,{
						text: "Tabs", 
						menu:
						[
							{
								text: "Tabs style 1", 
								value: '[tabs style="default1"] [/tabs]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "Tabs style 2", 
								value: '[tabs style="default2"] [/tabs]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
							,{
								text: "Tab item", 
								value: '[tab_item title=""]your_content[/tab_item]',
								onclick: function() {
									editor.insertContent(this.value());
								}
							}
						]
					}
					,{
						text: "Tooltip", 
						value: '[tooltip style="" tooltip_content=""]your_content[/tooltip]',
						onclick: function() {
							editor.insertContent(this.value());
						}
					}
				]	
				
		});
	});

})();