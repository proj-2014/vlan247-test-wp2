<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $woocommerce, $product;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', 8 ),
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= apply_filters( 'woocommerce_cross_sells_columns', 4 );

if ( $products->have_posts() ) : ?>

	<div class="cross-sells">
	
		<h2><?php _e( 'You may be interested in', 'wpdance' ) ?></h2>
		<div class="cross_wrapper">
			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
			<div class="cross_control">
				<a id="product_cross_prev" class="prev" href="#">&lt;</a>
				<a id="product_cross_next" class="next" href="#">&gt;</a>
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
				var _slider_config = get_layout_config(jQuery('.cross-sells').width(),_visible_items);
				_crosssell_item_width = _slider_config[0];
				_container_width = _slider_config[1];
				_visible_items = _slider_config[2];
				_slider_datas = {				
					responsive: true
					,width	: '100%'//_container_width
					,height	: 'auto'
					,scroll	: 1
					,swipe	: { onMouse: true, onTouch: true }	
					,items	: {
						width		: _crosssell_item_width
						,height		: 'auto'	//	optionally resize item-height
						,visible	: _visible_items
					}
					,auto	: false
					,prev	: '#product_cross_prev'
					,next	: '#product_cross_next'								
				};
				jQuery('.cross_wrapper > ul > li.first').removeClass('first');
				jQuery('.cross_wrapper > ul > li.last').removeClass('last');
				jQuery('.cross_wrapper > ul').eq(0).attr('id','_cross_ul_001');
				jQuery('#_cross_ul_001').carouFredSel(_slider_datas);	
				
				jQuery('window').on('resize orientationchange',jQuery.debounce( 250, function(){	
					_slider_config = get_layout_config(jQuery('.cross-sells').width(),_visible_items);
						_crosssell_item_width = jQuery(window).width() < 600 ? 300 : 183;
						_slider_datas.items.width = _crosssell_item_width;
						_slider_datas.items.visible = _slider_config[2];
						jQuery('#_cross_ul_001').trigger('configuration ',["items.width", _slider_config[0], true]);
						jQuery('#_cross_ul_001').trigger('destroy',true);
						jQuery('#_cross_ul_001').carouFredSel(_slider_datas);
				}));				
				
			});	
		//]]>	
		</script>
		
	</div>

<?php endif;

wp_reset_query();