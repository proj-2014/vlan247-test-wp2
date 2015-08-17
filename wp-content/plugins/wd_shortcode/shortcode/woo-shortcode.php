<?php
/**
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 */

	if(!function_exists('wd_custom_product_function')){
		function wd_custom_product_function($atts,$content){
			extract(shortcode_atts(array(
				'id' => 0
				,'sku' => ''
				,'title' => ''
			),$atts));
			
			
			if (empty($atts)) return;
			
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
		
			wp_reset_query(); 
			
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 1,
				'no_found_rows' => 1,
				'post_status' => 'publish',
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
			);

			if(isset($atts['sku']) && strlen(trim($atts['sku'])) > 0){
				$args['meta_query'][] = array(
					'key' => '_sku',
					'value' => $atts['sku'],
					'compare' => '='
				);
			}

			if(isset($atts['id'])){
				$args['p'] = $atts['id'];
			}

			ob_start();

			$products = new WP_Query( $args );

			if ( $products->have_posts() ) : ?>
				<div class="custom-product-shortcode">
				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						
						<?php		
						//start product-content.Copy from core code
							
						global $product, $woocommerce_loop;
						$old_loop = $woocommerce_loop;
						// Store loop count we're currently on
						if ( empty( $woocommerce_loop['loop'] ) )
							$woocommerce_loop['loop'] = 0;

						// Store column count for displaying the grid
						if ( empty( $woocommerce_loop['columns'] ) )
							$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

						// Ensure visibility
						if ( ! $product->is_visible() )
							return;

						// Increase loop count
						$woocommerce_loop['loop']++;

						// Extra post classes
						$classes = array();
						if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
							$classes[] = 'first';
						if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
							$classes[] = 'last';
						?>
						<li <?php post_class( $classes ); ?>>
							
							<div>

								<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

								<div class="product_thumbnail_wrapper">
									
									
								
									<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">

										<?php
											/**
											 * woocommerce_before_shop_loop_item_title hook
											 *
											 * @hooked woocommerce_show_product_loop_sale_flash - 10
											 * @hooked woocommerce_template_loop_product_thumbnail - 10
											 */
											do_action( 'woocommerce_before_shop_loop_item_title' );
										?>

										<?php
											/**
											 * woocommerce_after_shop_loop_item_title hook
											 *
											 * @hooked woocommerce_template_loop_price - 10
											 */
											do_action( 'woocommerce_after_shop_loop_item_title' );
										?>

									</a>
								
								</div>
								
								<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
							
							</div>
						</li>
						
						<?php //end of copy ?>
						
					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				</div>
			<?php endif;
			$woocommerce_loop = $old_loop;
			wp_reset_postdata();
			
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';
		}
	}
	add_shortcode('custom_product','wd_custom_product_function');
	
	
	
	if(!function_exists('wd_custom_products_function')){
		function wd_custom_products_function($atts,$content){
			extract(shortcode_atts(array(
				'ids' => 0
				,'skus' => ''
			),$atts));
			

			if (empty($atts)) return;
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
		
			global $woocommerce_loop;
			wp_reset_query(); 

			extract(shortcode_atts(array(
				'columns' 	=> '4',
				'orderby'   => 'title',
				'order'     => 'asc'
				), $atts));

			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => -1,
				'meta_query' => array(
					array(
						'key' 		=> '_visibility',
						'value' 	=> array('catalog', 'visible'),
						'compare' 	=> 'IN'
					)
				)
			);

			if(isset($atts['skus']) && strlen(trim($atts['skus'])) > 0) {
				$skus = explode(',', $atts['skus']);
				$skus = array_map('trim', $skus);
				$args['meta_query'][] = array(
					'key' 		=> '_sku',
					'value' 	=> $skus,
					'compare' 	=> 'IN'
				);
			}

			if(isset($atts['ids'])){
				$ids = explode(',', $atts['ids']);
				$ids = array_map('trim', $ids);
				$args['post__in'] = $ids;
			}

			ob_start();
			
			$_old_woocommerce_loop_columns = $woocommerce_loop['columns'];
			
			//$products = new WP_Query( $args );
			$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
			
			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<div class="custom-products-shortcode">
				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php woocommerce_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				</div>
			<?php endif;
			
			wp_reset_postdata();
			$woocommerce_loop['columns'] = $_old_woocommerce_loop_columns;
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';			
			
		}
	}	
	
	
	add_shortcode('custom_products','wd_custom_products_function');

	
	/*
	*	columns : 3 or 4
	*	layout : small or big
	*	per_page : 4 to 12
	*	title : ""
	*	desc : ""
	*	show nav thumb : 1
	* 	show thumb : 1
	*	show title : 1
	* 	show sku : 1
	*	show price
	*	show label
	* 	item slide : 1
	*/
	

	
	if(!function_exists('wd_featured_product_slider_function')){
		function wd_featured_product_slider_function($atts,$content){
			wp_reset_query(); 
			
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1	
				,'show_categories'	=> 1	
				,'show_short_content' => 1
			),$atts));
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
		
			global $woocommerce_loop,$wd_data;
			if(!(int)$show_image){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
					add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );
				}
			}
			if(!(int)$show_categories)
				remove_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2 );
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 3 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 4 );
			if(!(int)$show_short_content)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_short_content',5 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );				
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );				
			
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					),
					array(
						'key' => '_featured',
						'value' => 'yes'
					)
				)
			);

			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();
			if(isset($wd_data['wd_prod_cat_column']) && absint($wd_data['wd_prod_cat_column']) > 0 ){
				$_old_wd_prod_cat_column = $wd_data['wd_prod_cat_column'];
				$wd_data['wd_prod_cat_column'] = $columns;
			} 
			
			$_old_woocommerce_loop_columns = $woocommerce_loop['columns'];
			$products = new WP_Query( $args );

			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>" data_column="<?php echo $columns; ?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav):?>
						<div class="slider_control">
							<a title="prev" id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a title="next" id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						"use strict";
						// Using custom configuration
						var is_mobile = 0;
						<?php if(wp_is_mobile()): ?>
							is_mobile = 1;
						<?php endif;?>
						var temp_visible = <?php echo $columns;?>;
						if(is_mobile && jQuery(window).width() >= 768 && jQuery(window).width() <= 1024){
							temp_visible = temp_visible - 1;
							
						}
						if(is_mobile && jQuery(window).width() < 768){
							//temp_visible = '{ min		: 1,max	: <?php echo $columns;?>}';
							temp_visible = 1;
						}
						var _slider_config_feature3 = new Array(283,'100%',temp_visible);
						if(is_mobile == 0){
							_slider_config_feature3 = get_layout_config(jQuery(window).width(),temp_visible);
						}
						var _slider_datas =	
						{
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo wp_is_mobile() ? 300 : 140 ;?>
								,height: 'auto'
								,visible: _slider_config_feature3[2]
															
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { /*onMouse: true, */onTouch: true }		
							,scroll				: <?php if( !wp_is_mobile() ) : ?>
													{ /*items : <?php echo $columns;?>,*/
													duration : 1000
													, pauseOnHover:true
													, easing : "easeOutSine"}
													<?php else :?>
														1
													<?php endif;?>
							,width				: '100%'
							,height				: '100%'
							,circular			: true
							,infinite			: true
							,auto				: false
							<?php if($show_nav):?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						};
						
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul").carouFredSel(_slider_datas);	
						var temp = jQuery("#<?php echo $_random_id;?>").closest(".tabbable").addClass('has_slider');
						
						jQuery(temp).bind('tabs_change',jQuery.debounce( 250, function(event, id){
							var my_id = '<?php echo $_random_id;?>';
							if(id == my_id){
								var _slider_config_feature1 = get_layout_config(jQuery(window).width(),temp_visible);
								var _item_width = jQuery(window).width() < 600 ?  300: 380;
								_slider_datas.items.width = _item_width;
								_slider_datas.items.visible = _slider_config_feature1[2];
								setTimeout(function(){
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products li").show();
									jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('visibility','visible');
									jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('height','auto');
									jQuery(temp).children('.tab-content').removeClass('wd_loading');
								},200);
							}
						} ));
						jQuery('#<?php echo $_random_id?>').bind('wd_change_window_feature',jQuery.debounce( 200, function(){	
							
							var _slider_config_feature2= get_layout_config(jQuery(window).width(),temp_visible);
							var _item_width = jQuery(window).width() < 600 ? 300 : 380;
							_slider_datas.items.width = _item_width;
							_slider_datas.items.visible = _slider_config_feature2[2];
							_slider_datas.prev    = '#<?php echo $_random_id;?>_prev'
							_slider_datas.next    = '#<?php echo $_random_id;?>_next'	
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('configuration ',["items.width", 300, true]);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('destroy',true);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
						}));
						jQuery(window).resize(function(){
							jQuery('#<?php echo $_random_id?>').trigger('wd_change_window_feature');
						});
					});
				//]]>	
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed
			add_action ('woocommerce_after_shop_loop_item','open_div_style',1);
			add_action ('woocommerce_after_shop_loop_item','get_product_categories',2);
			add_action ('woocommerce_after_shop_loop_item','add_product_title',3);
			add_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',4);
			add_action( 'woocommerce_after_shop_loop_item', 'add_short_content', 5 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );			
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );	
			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );			
			}
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			//end
			$woocommerce_loop['columns'] = $_old_woocommerce_loop_columns;
			if(isset($_old_wd_prod_cat_column) && absint($_old_wd_prod_cat_column > 0 )){
				$wd_data['wd_prod_cat_column'] = $_old_wd_prod_cat_column  ;
			}
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('featured_product_slider','wd_featured_product_slider_function');


	if(!function_exists('wd_featured_by_category_function')){
		function wd_featured_by_category_function($cat_slug = '',$per_page = 1){
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			wp_reset_query(); 
			$args = array(
				'post_type'	=> 'product'
				,'post_status' => 'publish'
				,'ignore_sticky_posts'	=> 1
				,'posts_per_page' => $per_page
				,'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
					,array(
						'key' => '_featured',
						'value' => 'yes'
					)
				)
				,'tax_query' 			=> array(
					array(
						'taxonomy' 		=> 'product_cat',
						'terms' 		=> array( esc_attr($cat_slug) ),
						'field' 		=> 'slug',
						'operator' 		=> 'IN'
					)
				)
			);
			wp_reset_query(); 
			$products = new WP_Query( $args );
			if( $products->have_posts() ){
				global $post;
				$products->the_post();
				$product = get_product( $post->ID );
				return $product;
			}
			return NULL;
		}
	}
			

	function wd_order_by_rating_post_clauses( $args ) {

		global $wpdb;

		$args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

		$args['join'] .= "
			LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

		$args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}	
	

	/*
	*	columns : 3 or 4
	*	layout : small or big
	*	per_page : 4 to 12
	*	title : ""
	*	desc : ""
	*	product_tag : tag of prods
	*	show nav thumb : 1
	* 	show thumb : 1
	*	show title : 1
	* 	show sku : 1
	*	show price
	*	show label
	* 	item slide : 1
	*/
	

	
	if(!function_exists('wd_popular_product_slider_function')){
		function wd_popular_product_slider_function($atts,$content){
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			global $woocommerce_loop, $woocommerce,$wd_data;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1
                ,'show_categories' 	=> 1
				,'show_short_content' => 1				
			),$atts));
			
			if(!(int)$show_image){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
					add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );
				}
			}
			if(!(int)$show_categories)
				remove_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2 );
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 3 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 4 );
			if(!(int)$show_short_content)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_short_content', 5 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );				
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );				
			
			wp_reset_query(); 
			
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'orderby' => 'date',
				'order' => 'desc',				
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
			);
		
			
			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();

	  	add_filter( 'posts_clauses', 'wd_order_by_rating_post_clauses' );

		$products = new WP_Query( $args );

		remove_filter( 'posts_clauses', 'wd_order_by_rating_post_clauses' );
			
			if(isset($wd_data['wd_prod_cat_column']) && absint($wd_data['wd_prod_cat_column']) > 0 ){
				$_old_wd_prod_cat_column = $wd_data['wd_prod_cat_column'];
				$wd_data['wd_prod_cat_column'] = $columns;
			} 
			
			$_old_woocommerce_loop_columns = $woocommerce_loop['columns'];
			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>" data_column="<?php echo $columns; ?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav):?>
						<div class="slider_control">
							<a title="prev" id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a title="next" id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						"use strict";
						// Using custom configuration
						var is_mobile = 0;
						<?php if(wp_is_mobile()): ?>
							is_mobile = 1;
						<?php endif;?>
						var temp_visible = <?php echo $columns;?>;
						if(is_mobile && jQuery(window).width() >= 768 && jQuery(window).width() <= 1024){
							temp_visible = temp_visible - 1;
							
						}
						if(is_mobile && jQuery(window).width() < 768){
							//temp_visible = '{ min		: 1,max	: <?php echo $columns;?>}';
							temp_visible = 1;
						}
						var _slider_config_feature3 = new Array(283,'100%',temp_visible);
						if(is_mobile == 0){
							_slider_config_feature3 = get_layout_config(jQuery(window).width(),temp_visible);
						} 
						var _slider_datas =	
						{
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo wp_is_mobile() ? 300 : 140 ;?>
								,height: 'auto'
								,visible: _slider_config_feature3[2]
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { /*onMouse: true, */onTouch: true }		
							,scroll				: <?php if( !wp_is_mobile() ) : ?>
													{ /*items : <?php echo $columns;?>,*/
													duration : 1000
													, pauseOnHover:true
													, easing : "easeOutSine"}
													<?php else :?>
														1
													<?php endif;?>
							,width				: '100%'
							,height				: '100%'
							,circular			: true
							,infinite			: true
							,auto				: false
							<?php if($show_nav):?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						};
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul").carouFredSel(_slider_datas);	
						var temp = jQuery("#<?php echo $_random_id;?>").closest(".tabbable").addClass('has_slider');
						jQuery(temp).bind('tabs_change',jQuery.debounce( 250, function(event, id){
							var my_id = '<?php echo $_random_id;?>';
							if(id == my_id){
								var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
								var _item_width = jQuery(window).width() < 600 ?  300: 200;
								_slider_datas.items.width = _item_width;
								_slider_datas.items.visible =  _slider_config[2];
								jQuery("#<?php echo $_random_id?> ul.products").trigger('configuration ',["items.width", 200, true]);
								setTimeout(function(){
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products li").show();
									jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('height','auto');
									jQuery(temp).children('.tab-content').removeClass('wd_loading');
								},200);
							}
						} ));	
						jQuery('#<?php echo $_random_id?>').bind('wd_change_window_popular',jQuery.debounce( 200, function(){	
							var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
							var _item_width = jQuery(window).width() < 600 ? 300 : 380;
							_slider_datas.items.width = _item_width;
							_slider_datas.items.visible = _slider_config[2];
							_slider_datas.prev    = '#<?php echo $_random_id;?>_prev'
							_slider_datas.next    = '#<?php echo $_random_id;?>_next'	
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('configuration ',["items.width", 300, true]);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('destroy',true);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
						}));
						jQuery(window).resize(function(){
							jQuery('#<?php echo $_random_id?>').trigger('wd_change_window_popular');
						});		
					});
				//]]>	
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed
			add_action ('woocommerce_after_shop_loop_item','open_div_style',1);
			add_action ('woocommerce_after_shop_loop_item','get_product_categories',2);
			add_action ('woocommerce_after_shop_loop_item','add_product_title',3);
			add_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',4);
			add_action ('woocommerce_after_shop_loop_item','add_short_content',5);
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );			
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );	
			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );			
			}
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			//end
			if(isset($_old_wd_prod_cat_column) && absint($_old_wd_prod_cat_column > 0 )){
				$wd_data['wd_prod_cat_column'] = $_old_wd_prod_cat_column  ;
			}
			$woocommerce_loop['columns'] = $_old_woocommerce_loop_columns ;
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('popular_product_slider','wd_popular_product_slider_function');




	/*
	*	columns : 3 or 4
	*	layout : small or big
	*	per_page : 4 to 12
	*	title : ""
	*	desc : ""
	*	product_tag : tag of prods
	*	show nav thumb : 1
	* 	show thumb : 1
	*	show title : 1
	* 	show sku : 1
	*	show price
	*	show label
	* 	item slide : 1
	*/
	

	
	if(!function_exists('wd_recent_product_slider_function')){
		function wd_recent_product_slider_function($atts,$content){
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			global $woocommerce_loop, $woocommerce,$wd_data;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1
                ,'show_categories' 	=> 1
				,'show_short_content' => 1	
			),$atts));
			
			if(!(int)$show_image){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
					add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );
				}
			}
			if(!(int)$show_categories)
				remove_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2 );
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 3 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 4 );
			if(!(int)$show_short_content)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_short_content', 5 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );				
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );				

			
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'orderby' => 'date',
				'order' => 'desc',				
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
			);
		
			wp_reset_query(); 
			
			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();

			$products = new WP_Query( $args );
			if(isset($wd_data['wd_prod_cat_column']) && absint($wd_data['wd_prod_cat_column']) > 0 ){
				$_old_wd_prod_cat_column = $wd_data['wd_prod_cat_column'];
				$wd_data['wd_prod_cat_column'] = $columns;
			}
			$_old_woocommerce_loop_columns = $woocommerce_loop['columns'];
			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>" data_column="<?php echo $columns; ?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav):?>
						<div class="slider_control">
							<a title="prev" id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a title="next" id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						"use strict";
						// Using custom configuration
						var is_mobile = 0;
						<?php if(wp_is_mobile()): ?>
							is_mobile = 1;
						<?php endif;?>
						var temp_visible = <?php echo $columns;?>;
						if(is_mobile && jQuery(window).width() >= 768 && jQuery(window).width() <= 1024){
							temp_visible = temp_visible - 1;
							
						}
						if(is_mobile && jQuery(window).width() < 768){
							//temp_visible = '{ min		: 1,max	: <?php echo $columns;?>}';
							temp_visible = 1;
						}
						var _slider_config_feature3 = new Array(283,'100%',temp_visible);
						if(is_mobile == 0){
							_slider_config_feature3 = get_layout_config(jQuery(window).width(),temp_visible);
						}
						var _slider_datas =	
						{
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo wp_is_mobile() ? 300 : 140 ;?>
								,height: 'auto'
								,visible: _slider_config_feature3[2]							
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { /*onMouse: true, */onTouch: true }		
							,scroll				: <?php if( !wp_is_mobile() ) : ?>
													{ /*items : <?php echo $columns;?>,*/
													duration : 1000
													, pauseOnHover:true
													, easing : "easeOutSine"}
													<?php else :?>
														1
													<?php endif;?>
							,width				: '100%'
							,height				: '100%'
							,circular			: true
							,infinite			: true
							,auto				: false
							<?php if($show_nav):?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						};
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul").carouFredSel(_slider_datas);	
						var temp = jQuery("#<?php echo $_random_id;?>").closest(".tabbable").addClass('has_slider');
						jQuery(temp).bind('tabs_change',jQuery.debounce( 250, function(event, id){
							var my_id = '<?php echo $_random_id;?>';
							if(id == my_id){
								var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
								var _item_width = jQuery(window).width() < 600 ?  300: 200;
								_slider_datas.items.width = _item_width;
								_slider_datas.items.visible = _slider_config[2];
								setTimeout(function(){
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products li").show();
									//jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('visibility','visible');
									jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('height','auto');
									jQuery(temp).children('.tab-content').removeClass('wd_loading');
								},200);
							}
						} ));	
						jQuery('#<?php echo $_random_id?>').bind('wd_change_window_recent',jQuery.debounce( 200, function(){	
							var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
							var _item_width = jQuery(window).width() < 600 ? 300 : 380;
							_slider_datas.items.width = _item_width;
							_slider_datas.items.visible = _slider_config[2];
							_slider_datas.prev    = '#<?php echo $_random_id;?>_prev'
							_slider_datas.next    = '#<?php echo $_random_id;?>_next'	
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('configuration ',["items.width", 300, true]);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('destroy',true);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
						}));
						jQuery(window).resize(function(){
							jQuery('#<?php echo $_random_id?>').trigger('wd_change_window_recent');
						});			
					});
				//]]>	
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed
			add_action ('woocommerce_after_shop_loop_item','open_div_style',1);
			add_action ('woocommerce_after_shop_loop_item','get_product_categories',2);
			add_action ('woocommerce_after_shop_loop_item','add_product_title',3);
			add_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',4);
			add_action ('woocommerce_after_shop_loop_item','add_short_content',5);
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );			
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );	
			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );			
			}
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			//end
			$woocommerce_loop['columns'] = $_old_woocommerce_loop_columns ;
			if(isset($_old_wd_prod_cat_column) && absint($_old_wd_prod_cat_column > 0 )){
				$wd_data['wd_prod_cat_column'] = $_old_wd_prod_cat_column  ;
			}
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('recent_product_slider','wd_recent_product_slider_function');




		/*
	*	columns : 3 or 4
	*	layout : small or big
	*	per_page : 4 to 12
	*	title : ""
	*	desc : ""
	*	product_tag : tag of prods
	*	show nav thumb : 1
	* 	show thumb : 1
	*	show title : 1
	* 	show sku : 1
	*	show price
	*	show label
	* 	item slide : 1
	*/
	

	
	if(!function_exists('wd_best_selling_product_slider_function')){
		function wd_best_selling_product_slider_function($atts,$content){
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			global $woocommerce_loop, $woocommerce,$wd_data;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'show_heading_title' => 1
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1		
				,'show_categories' 	=> 1
				,'show_short_content' => 1				
			),$atts));
			
			if(!(int)$show_image){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
					add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );
				}
			}
			if(!(int)$show_categories)
				remove_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2 );
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 3 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 4 );
			if(!(int)$show_short_content)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_short_content', 5 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );						
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'order' => 'desc',		
				'meta_key' 		 => 'total_sales',
				'orderby' 		 => 'meta_value_num',				
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
			);
		
			wp_reset_query(); 
			
			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();

			$products = new WP_Query( $args );
			if(isset($wd_data['wd_prod_cat_column']) && absint($wd_data['wd_prod_cat_column']) > 0 ){
				$_old_wd_prod_cat_column = $wd_data['wd_prod_cat_column'];
				$wd_data['wd_prod_cat_column'] = $columns;
			} 
			
			$_old_woocommerce_loop_columns = $woocommerce_loop['columns'];	
			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>" data_column="<?php echo $columns; ?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0 && $show_heading_title == 1)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0 && $show_heading_title == 1)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav):?>
						<div class="slider_control">
							<a title="prev" id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a title="next" id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						"use strict";
						// Using custom configuration
						var is_mobile = 0;
						<?php if(wp_is_mobile()): ?>
							is_mobile = 1;
						<?php endif;?>
						var temp_visible = <?php echo $columns;?>;
						if(is_mobile && jQuery(window).width() >= 768 && jQuery(window).width() <= 1024){
							temp_visible = temp_visible - 1;
							
						}
						if(is_mobile && jQuery(window).width() < 768){
							//temp_visible = '{ min		: 1,max	: <?php echo $columns;?>}';
							temp_visible = 1;
						}
						var _slider_config_feature3 = new Array(283,'100%',temp_visible);
						if(is_mobile == 0){
							_slider_config_feature3 = get_layout_config(jQuery(window).width(),temp_visible);
						} 
						var _slider_datas =	
						{
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo wp_is_mobile() ? 300 : 140 ;?>
								,height: 'auto'
								,visible: _slider_config_feature3[2]				
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { /*onMouse: true, */onTouch: true }		
							,scroll				: <?php if( !wp_is_mobile() ) : ?>
													{ /*items : <?php echo $columns;?>,*/
													duration : 1000
													, pauseOnHover:true
													, easing : "easeOutSine"}
													<?php else :?>
														1
													<?php endif;?>
							,width				: '100%'
							,height				: '100%'
							,circular			: true
							,infinite			: true
							,auto				: false
							<?php if($show_nav):?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						};
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul").carouFredSel(_slider_datas);	
						var temp = jQuery("#<?php echo $_random_id;?>").closest(".tabbable").addClass('has_slider');
						jQuery(temp).bind('tabs_change',jQuery.debounce( 250, function(event, id){
							var my_id = '<?php echo $_random_id;?>';
							
							if(id == my_id){
								var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
								var _item_width = jQuery(window).width() < 600 ?  300: 200;
								_slider_datas.items.width = _item_width;
								_slider_datas.items.visible = _slider_config[2];
								//jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products").trigger('destroy',true);
								//jQuery("#<?php echo $_random_id?> ul.products").trigger('configuration ',["items.width", 200, true]);
								setTimeout(function(){
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products li").show();
									//jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('visibility','visible');
									jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('height','auto');
									jQuery(temp).children('.tab-content').removeClass('wd_loading');
								},200);
							}
						} ));
						jQuery('#<?php echo $_random_id?>').bind('wd_change_window_best_selling',jQuery.debounce( 200, function(){	
							var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
							var _item_width = jQuery(window).width() < 600 ? 300 : 380;
							_slider_datas.items.width = _item_width;
							_slider_datas.items.visible = _slider_config[2];
							_slider_datas.prev    = '#<?php echo $_random_id;?>_prev'
							_slider_datas.next    = '#<?php echo $_random_id;?>_next'	
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('configuration ',["items.width", 300, true]);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('destroy',true);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
						}));
						jQuery(window).resize(function(){
							jQuery('#<?php echo $_random_id?>').trigger('wd_change_window_best_selling');
						});
					});
				//]]>	
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed
			add_action ('woocommerce_after_shop_loop_item','open_div_style',1);
			add_action ('woocommerce_after_shop_loop_item','get_product_categories',2);
			add_action ('woocommerce_after_shop_loop_item','add_product_title',3);
			add_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',4);
			add_action ('woocommerce_after_shop_loop_item','add_short_content',5);
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );			
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );	
			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );			
			}
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			//end
			$woocommerce_loop['columns'] = $_old_woocommerce_loop_columns;
			if(isset($_old_wd_prod_cat_column) && absint($_old_wd_prod_cat_column > 0 )){
				$wd_data['wd_prod_cat_column'] = $_old_wd_prod_cat_column  ;
			}
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('best_selling_product_slider','wd_best_selling_product_slider_function');
	
	
	if(!function_exists('wd_best_selling_product_by_category_slider_function')){
		function wd_best_selling_product_by_category_slider_function($atts,$content){
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			global $woocommerce_loop, $woocommerce,$wd_data;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'show_heading_title' => 1
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1		
				,'show_categories' 	=> 1
				,'show_short_content' => 1		
				,'cat_slug'			=> ''			
			),$atts));
			
			if($cat_slug=='' && has_term( $cat_slug, 'product_cat', 'product' )){
				echo 'cxc';
				return;
			}
			
			if(!(int)$show_image){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
					add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );
				}
			}
			if(!(int)$show_categories)
				remove_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2 );
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 3 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 4 );
			if(!(int)$show_short_content)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_short_content', 5 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );						
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'order' => 'desc',		
				'meta_key' 		 => 'total_sales',
				'orderby' 		 => 'meta_value_num',				
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
				,'tax_query' 			=> array(
					array(
						'taxonomy' 		=> 'product_cat',
						'terms' 		=> array( esc_attr($cat_slug) ),
						'field' 		=> 'slug',
						'operator' 		=> 'IN'
					)
				)
			);
			wp_reset_query(); 
			
			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();

			$products = new WP_Query( $args );
			if(isset($wd_data['wd_prod_cat_column']) && absint($wd_data['wd_prod_cat_column']) > 0 ){
				$_old_wd_prod_cat_column = $wd_data['wd_prod_cat_column'];
				$wd_data['wd_prod_cat_column'] = $columns;
			} 
			$_old_woocommerce_loop_columns = $woocommerce_loop['columns'];	
			$woocommerce_loop['columns'] = $columns;
			
			remove_action( 'woocommerce_before_shop_loop_item_title', 'custom_product_thumbnail', 10 );
			
			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>" data_column="<?php echo $columns;?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0 && $show_heading_title == 1)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0 && $show_heading_title == 1)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav && $products->post_count > $columns):?>
						<div id="column_<?php echo $columns.$_random_id;?>"  class="slider_control">
							<a title="prev" id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a title="next" id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						"use strict";
						// Using custom configuration
						var is_mobile = 0;
						<?php if(wp_is_mobile()): ?>
							is_mobile = 1;
						<?php endif;?>
						var temp_visible = <?php echo $columns;?>;
						if(is_mobile && jQuery(window).width() >= 768 && jQuery(window).width() <= 1024){
							temp_visible = temp_visible - 1;
							
						}
						if(is_mobile && jQuery(window).width() < 768){
							//temp_visible = '{ min		: 1,max	: <?php echo $columns;?>}';
							temp_visible = 1;
						}
						var _slider_config_feature3 = new Array(283,'100%',temp_visible);
						if(is_mobile == 0){
							_slider_config_feature3 = get_layout_config(jQuery(window).width(),temp_visible);
						} 
						var _slider_datas =	
						{
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo wp_is_mobile() ? 300 : 200 ;?>
								,height: 'auto'
								,visible: _slider_config_feature3[2]						
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { /*onMouse: true, */onTouch: true }		
							,scroll				: <?php if( !wp_is_mobile() ) : ?>
													{ /*items : <?php echo $columns;?>,*/
													duration : 1000
													, pauseOnHover:true
													, easing : "easeOutSine"}
													<?php else :?>
														1
													<?php endif;?>
							,width				: '100%'
							,height				: '100%'
							,circular			: true
							,infinite			: true
							,auto				: false
							<?php if($show_nav):?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						};
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul.products").carouFredSel(_slider_datas);	
						var temp = jQuery("#<?php echo $_random_id?>").closest(".tabbable").addClass('has_slider');
						jQuery(temp).bind('tabs_change',jQuery.debounce( 250, function(event, id){
							var my_id = '<?php echo $_random_id;?>';
							if(id == my_id){
								var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
								var _item_width = jQuery(window).width() < 600 ?  300: 200;
								_slider_datas.items.width = _item_width;
								_slider_datas.items.visible = _slider_config[2];
								//jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products").trigger('destroy',true);
								//jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products").trigger('configuration ',["items.width", 200, true]);
								setTimeout(function(){
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products").carouFredSel(_slider_datas);	
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products li").show(0);
									//jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('visibility','visible');
									jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('height','auto');
									jQuery(temp).children('.tab-content').removeClass('wd_loading');
								},200);
							}
						} ));	
						jQuery('#<?php echo $_random_id?>').bind('wd_change_window_best_selling_cat',jQuery.debounce( 200, function(){	
							var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
							var _item_width = jQuery(window).width() < 600 ? 300 : 380;
							_slider_datas.items.width = _item_width;
							_slider_datas.items.visible = _slider_config[2];
							_slider_datas.prev    = '#<?php echo $_random_id;?>_prev'
							_slider_datas.next    = '#<?php echo $_random_id;?>_next'	
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('configuration ',["items.width", 300, true]);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('destroy',true);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
						}));
						jQuery(window).resize(function(){
							jQuery('#<?php echo $_random_id?>').trigger('wd_change_window_best_selling_cat');
						});
					});
				//]]>	
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed
			add_action ('woocommerce_after_shop_loop_item','open_div_style',1);
			add_action ('woocommerce_after_shop_loop_item','get_product_categories',2);
			add_action ('woocommerce_after_shop_loop_item','add_product_title',3);
			add_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',4);
			add_action ('woocommerce_after_shop_loop_item','add_short_content',5);
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );			
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );	
			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );			
			}
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			//end
			$woocommerce_loop['columns'] = $_old_woocommerce_loop_columns;
			$wd_data['wd_prod_cat_column'] = $_old_wd_prod_cat_column  ;
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('best_selling_product_by_category_slider','wd_best_selling_product_by_category_slider_function');
	
	
	
	
	
	
	
	
	if(!function_exists('wd_recent_product_by_categories_slider_function')){
		function wd_recent_product_by_categories_slider_function($atts,$content){
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			global $woocommerce_loop, $woocommerce,$wd_data;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1
                ,'show_categories' 	=> 1
				,'show_short_content' => 1
				,'cat_slug'			=> ''		
			),$atts));
			
			
			if($cat_slug=='' && has_term( $cat_slug, 'product_cat', 'product' )){
				echo 'cxc';
				return;
			}
			
			if(!(int)$show_image){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
					add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );
				}
			}
			if(!(int)$show_categories)
				remove_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2 );
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 3 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 4 );
			if(!(int)$show_short_content)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_short_content', 5 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );				
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );				

			
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'orderby' => 'date',
				'order' => 'desc',				
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
				,'tax_query' 			=> array(
					array(
						'taxonomy' 		=> 'product_cat',
						'terms' 		=> array( esc_attr($cat_slug) ),
						'field' 		=> 'slug',
						'operator' 		=> 'IN'
					)
				)
			);
		
			wp_reset_query(); 
			
			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();

			$products = new WP_Query( $args );
			if(isset($wd_data['wd_prod_cat_column']) && absint($wd_data['wd_prod_cat_column']) > 0 ){
				$_old_wd_prod_cat_column = $wd_data['wd_prod_cat_column'];
				$wd_data['wd_prod_cat_column'] = $columns;
			} 
			$_old_woocommerce_loop_columns = $woocommerce_loop['columns'];
			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>" data_column="<?php echo $columns; ?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav):?>
						<div class="slider_control">
							<a title="prev" id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a title="next" id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						"use strict";
						// Using custom configuration
						var is_mobile = 0;
						<?php if(wp_is_mobile()): ?>
							is_mobile = 1;
						<?php endif;?>
						var temp_visible = <?php echo $columns;?>;
						if(is_mobile && jQuery(window).width() >= 768 && jQuery(window).width() <= 1024){
							temp_visible = temp_visible - 1;
							
						}
						if(is_mobile && jQuery(window).width() < 768){
							//temp_visible = '{ min		: 1,max	: <?php echo $columns;?>}';
							temp_visible = 1;
						}
						var _slider_config_feature3 = new Array(283,'100%',temp_visible);
						if(is_mobile == 0){
							_slider_config_feature3 = get_layout_config(jQuery(window).width(),temp_visible);
						} 
						var _slider_datas =	
						{
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo wp_is_mobile() ? 300 : 140 ;?>
								,height: 'auto'
								,visible: _slider_config_feature3[2]					
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { /*onMouse: true, */onTouch: true }		
							,scroll				: <?php if( !wp_is_mobile() ) : ?>
													{ /*items : <?php echo $columns;?>,*/
													duration : 1000
													, pauseOnHover:true
													, easing : "easeOutSine"}
													<?php else :?>
														1
													<?php endif;?>
							,width				: '100%'
							,height				: '100%'
							,circular			: true
							,infinite			: true
							,auto				: false
							<?php if($show_nav):?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						};
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul").carouFredSel(_slider_datas);	
						var temp = jQuery("#<?php echo $_random_id;?>").closest(".tabbable").addClass('has_slider');
						jQuery(temp).bind('tabs_change',jQuery.debounce( 250, function(event, id){
							var my_id = '<?php echo $_random_id;?>';
							if(id == my_id){
								var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
								var _item_width = jQuery(window).width() < 600 ?  300: 200;
								_slider_datas.items.width = _item_width;
								_slider_datas.items.visible = _slider_config[2];
								//jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products").trigger('destroy',true);
								jQuery("#<?php echo $_random_id?> ul.products").trigger('configuration ',["items.width", 200, true]);
									setTimeout(function(){
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
									jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner ul.products li").show();
									//jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('visibility','visible');
									jQuery("#<?php echo $_random_id?>").closest(".tab-pane").css('height','auto');
									jQuery(temp).children('.tab-content').removeClass('wd_loading');
								},200);
							}
						} ));
						jQuery('#<?php echo $_random_id?>').bind('wd_change_window_recent_cat',jQuery.debounce( 200, function(){	
							var _slider_config = get_layout_config(jQuery(window).width(),temp_visible);
							var _item_width = jQuery(window).width() < 600 ? 300 : 380;
							_slider_datas.items.width = _item_width;
							_slider_datas.items.visible = _slider_config[2];
							_slider_datas.prev    = '#<?php echo $_random_id;?>_prev'
							_slider_datas.next    = '#<?php echo $_random_id;?>_next'	
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('configuration ',["items.width", 300, true]);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").trigger('destroy',true);
							jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner  ul.products").carouFredSel(_slider_datas);	
						}));
						jQuery(window).resize(function(){
							jQuery('#<?php echo $_random_id?>').trigger('wd_change_window_recent_cat');
						});
					});
				//]]>	
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed
			add_action ('woocommerce_after_shop_loop_item','open_div_style',1);
			add_action ('woocommerce_after_shop_loop_item','get_product_categories',2);
			add_action ('woocommerce_after_shop_loop_item','add_product_title',3);
			add_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',4);
			add_action ('woocommerce_after_shop_loop_item','add_short_content',5);
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );			
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );	
			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );			
			}
			
			add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			//end
			$woocommerce_loop['columns']= $_old_woocommerce_loop_columns;
			if(isset($_old_wd_prod_cat_column) && absint($_old_wd_prod_cat_column > 0 )){
				$wd_data['wd_prod_cat_column'] = $_old_wd_prod_cat_column  ;
			}
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('recent_product_by_categories_slider','wd_recent_product_by_categories_slider_function');
	
?>