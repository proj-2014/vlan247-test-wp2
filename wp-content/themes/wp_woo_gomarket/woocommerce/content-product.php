<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop,$wd_data;//$category_prod_datas;


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;
 
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ){
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product->is_visible() )
	return;	
$_sub_class = "span6";
if( absint($wd_data['wd_prod_cat_column']) > 0 ){
	$_columns = absint($wd_data['wd_prod_cat_column']);
	$_sub_class = "span".(24/$_columns);
}else{
	$_columns = absint($woocommerce_loop['columns']);
	$_sub_class = "span".(24/($_columns));
}	

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
	
//add on column class on cat page	
$classes[] = $_sub_class ;	
?>
<li <?php post_class( $classes ); ?>>
	<div class="wd_product_wrapper">
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
		</a>
			<!--<h3><?php the_title(); ?></h3>-->
			
			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
			
		
		
	</div>
	<?php
		/*
		* woocommerce_after_shop_loop_item hook
		*
		* @hooked open_media_wrapper 							- 1
		* @hooked get_product_categories 						- 2
		* @hooked add_product_title 							- 3
		* @hooked add_sku_to_product_list				 		- 4
		* @hooked add_short_content								- 5
		* @hooked woocommerce_template_loop_price				- 6
		* @hooked woocommerce_template_loop_rating				- 7
		* @hooked wd_list_template_loop_add_to_cart				- 8
		* @hooked close_div_wrapper 							- 12	
		*/ 
		do_action( 'woocommerce_after_shop_loop_item' ); 
	?>
	</div>	
</li>