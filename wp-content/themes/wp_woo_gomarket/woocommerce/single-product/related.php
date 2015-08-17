<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$related = $product->get_related('10');

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> -1,//$posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related,
	'post__not_in'			=> array($product->id)
) );
	

$products = new WP_Query( $args );
$woocommerce_loop['columns'] 	= $columns;

if ( $products->have_posts() ) : ?>

	<?php
	
		global $wd_data;
		//add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );	
		remove_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',4);		
		//remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
		remove_action ('woocommerce_after_shop_loop_item','add_short_content',5);
	?>

	<div class="related products">

		<h2 class="heading-title"><?php echo $related_title = sprintf( __( '%s','wpdance' ), stripslashes(esc_html($wd_data['wd_prod_related_title'])) ); ?></h2>
		<div class="related_wrapper">
		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>
					
			<?php endwhile; // end of the loop. ?>
		<?php woocommerce_product_loop_end(); ?>
		<div class="clearfix"></div>
		<?php if($products->post_count >= 3) : ?>
		<div class="wd_single_related_control">
			<a class="prev" id="wd_single_related_prev" href="#">&lt;</a>
			<a class="next" id="wd_single_related_next" href="#" >&gt;</a> 
		</div>
		<?php endif; ?>
		</div>
	</div>

	<?php
	
		//remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		add_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',4);			
		//add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );	
		add_action ('woocommerce_after_shop_loop_item','add_short_content',5);
	?>
	<?php
		$_post_count = count($products->posts);
		$_post_count = $_post_count > 4 ? 4 : $_post_count;
	
	?>	
<script type="text/javascript" language="javascript">
	//<![CDATA[
	jQuery(document).ready(function() {
		var _visible_items = <?php echo $_post_count; ?>;
		var _slider_config = get_layout_config(jQuery('.related.products').width(),_visible_items);
		_related_item_width = _slider_config[0];
		_container_width = _slider_config[1];
		_visible_items = _slider_config[2];
		_slider_datas = {				
			responsive: true
			,width	: '100%'
			,height	: 'auto'
			,scroll  : {
				items	: 1,
			}
			,debug	 : true
			,auto    : false
			,swipe	: { onMouse: true, onTouch: true }	
			,items   : { 
				width		: _related_item_width
				,height		: 'auto'
				,visible	:  _visible_items		
			}	
			,prev    : '#wd_single_related_prev'
			,next    : '#wd_single_related_next'
		};
		//jQuery('div.related ul.products').carouFredSel(_slider_datas);
		jQuery("div.related ul.products").carouFredSel(_slider_datas);

		jQuery(window).bind('resize orientationchange',jQuery.debounce( 250, function(){	
				_slider_config = get_layout_config(jQuery('.related.products').width(),_visible_items);
				_upsell_item_width = jQuery(window).width() < 600 ? 300 : 183;
				_slider_datas.items.width = _upsell_item_width;
				_slider_datas.items.visible = _slider_config[2];
				_slider_datas.prev    ='#wd_single_related_prev';
				_slider_datas.next    = '#wd_single_related_next';
				jQuery('div.related ul.products').trigger('configuration ',["items.width", 300, true]);
				jQuery('div.related ul.products').trigger('destroy',true);
				jQuery('div.related ul.products').carouFredSel(_slider_datas);
		}));				
		
	});	
	//]]>	
</script>	
<?php endif;

wp_reset_postdata();
