<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce, $woocommerce_loop;

$upsells = $product->get_upsells(10);

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => 5,//=$posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);


$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= $columns;

if ( $products->have_posts() ) : ?>

	<?php global $wd_data; ?>

	<div class="upsells products">

		<h2 class="heading-title"><?php echo $_upsell_title = sprintf( __( '%s','wpdance' ), stripslashes(esc_attr($wd_data['wd_prod_upsell_title'])) ); ?></h2>

		<div class="upsell_wrapper">
		
			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<div class="upsell_control">
				<a id="product_upsell_prev" class="prev" href="#">&lt;</a>
				<a id="product_upsell_next" class="next" href="#">&gt;</a>
			</div>				
			
		</div>
		
		<?php
			$_post_count = count($products->posts);
			$_post_count = $_post_count > 4 ? 4 : $_post_count;
		
		?>
		
		<script type="text/javascript" language="javascript">
		//<![CDATA[
			jQuery(document).ready(function() {
				var _visible_items = <?php echo $_post_count; ?>;
				var _slider_config = get_layout_config(jQuery('.upsells.products').width(),_visible_items);
				console.log(_slider_config);
				_upsell_item_width = _slider_config[0];
				_container_width = _slider_config[1];
				_visible_items = _slider_config[2];
				_slider_datas = {				
					responsive: true
					,width	: '100%'//_container_width
					,height	: 'auto'
					,scroll	: 1
					,swipe	: { onMouse: false, onTouch: true }	
					,items	: {
						width		: _upsell_item_width
						,height		: 'auto'	//	optionally resize item-height
						,visible	: _visible_items
					}
					,auto	: false
					,prev	: '#product_upsell_prev'
					,next	: '#product_upsell_next'								
				};
				jQuery('.upsell_wrapper > ul > li.first').removeClass('first');
				jQuery('.upsell_wrapper > ul > li.last').removeClass('last');
				jQuery('.upsell_wrapper > ul').eq(0).attr('id','_upsell_ul_001');
				jQuery('#_upsell_ul_001').carouFredSel(_slider_datas);	
				
				jQuery('#_upsell_ul_001').bind('wd_change_window_upsell',jQuery.debounce( 200, function(){	
					_slider_config = get_layout_config(jQuery('.upsells.products').width(),_visible_items);
					_upsell_item_width = jQuery(window).width() < 600 ? 300 : 183;
					_slider_datas.items.width = _upsell_item_width;
					_slider_datas.items.visible = _slider_config[2];
					_slider_datas.prev    ='#product_upsell_prev';
					_slider_datas.next    = '#product_upsell_next';
					jQuery('#_upsell_ul_001').trigger('configuration ',["items.width", 300, true]);
					jQuery('#_upsell_ul_001').trigger('destroy',true);
					jQuery('#_upsell_ul_001').carouFredSel(_slider_datas);
				}));				
				
				jQuery(window).bind('orientationchange',jQuery.debounce( 250, function(){
					jQuery('#_upsell_ul_001').trigger('wd_change_window_upsell');
				}));
				jQuery(window).resize(function(){
					jQuery('#_upsell_ul_001').trigger('wd_change_window_upsell');
				});
			});	
		//]]>	
		</script>		
		
	</div>

<?php endif;
wp_reset_postdata();
