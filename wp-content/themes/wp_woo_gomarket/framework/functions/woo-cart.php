<?php
if ( ! function_exists( 'wd_tini_cart' ) ) {
	function wd_tini_cart(){
		$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
		if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
			return;
		}
		global $woocommerce;
		$_cart_empty = sizeof( $woocommerce->cart->get_cart() ) > 0 ? false : true ;
		
		ob_start();
		
		?>
		<?php do_action( 'wd_before_tini_cart' ); ?>
		<div class="wd_tini_cart_wrapper">
			<div class="wd_tini_cart_control ">
				
				<span class="cart_size">
					<a href="<?php echo $woocommerce->cart->get_cart_url();?>" title="<?php _e('View your shopping bag','wpdance');?>">
						<span><?php _e('my cart','wpdance');?> </span>
					</a>
					: <!--<span class="cart_subtotal"><?php echo $woocommerce->cart->get_cart_subtotal(); ?></span>
					<span class="cart_division">/</span>-->
					(<span id="cart_size_value_head"><?php echo $woocommerce->cart->cart_contents_count;?></span>)</span>
				
			</div>
			<div class="cart_dropdown drop_down_container">
				
				<?php if ( !$_cart_empty ) : ?>
				<div class="dropdown_body">
					<ul class="cart_list product_list_widget">
							
							<?php
								$_cart_array = $woocommerce->cart->get_cart();
								$_index = 0;
							?>
							
							<?php foreach ( $_cart_array as $cart_item_key => $cart_item ) :
								
								$_product = $cart_item['data'];

								// Only display if allowed
								if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 )
									continue;

								// Get price
								$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();

								$product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );
								?>

								<li class="<?php echo $_cart_li_class = ($_index == 0 ? "first" : ($_index == count($_cart_array) - 1 ? "last" : "")) ?>">
									<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
										<?php echo $_product->get_image(); ?>
									</a>
									<div class="cart_item_wrapper">	
										<div class="wd_cart_item_categories">
										<?php echo $_product->get_categories();?>	
										</div>
										<a class="wd_cart_title" href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
											<?php echo $_product->get_title(); ?>
											<?php //echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>
										</a>
											<?php //echo $woocommerce->cart->get_item_data( $cart_item ); ?>
											<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s',$product_price, $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?>
											<?php
												echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'wpdance' ) ), $cart_item_key );
										?>
									</div>
								</li>

								<?php $_index++; ?>
								
							<?php endforeach; ?>
					</ul><!-- end product list -->
				</div>
				<?php else: ?>
				<div class="size_empty">
					<?php _e('You have no items in your shopping cart.','wpdance');?>
				</div>
				<?php endif; ?>
				<?php if ( !$_cart_empty ) : ?>
					<div class="dropdown_footer">
						<p class="total"><strong><?php _e( 'Subtotal', 'wpdance' ); ?>:</strong> <?php echo $woocommerce->cart->get_cart_subtotal(); ?></p>

						<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
						
						<p class="buttons">
							<a href="<?php echo $woocommerce->cart->get_cart_url();?>"><?php _e('view cart','wpdance');?></a>
						</p>
						
						<p class="buttons">
							<a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="button checkout"><?php _e( 'Checkout', 'wpdance' ); ?></a>
						</p>
						
						

						<!-- <span class="cart_dropdown_subtotal">
							<label for="cart-dropdown-subtotal"><?php _e('checkoutBag subtotal','wpdance');?> : </label>
							<?php echo $woocommerce->cart->get_cart_subtotal(); ?>
						</span>		-->					
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php do_action( 'wd_after_tini_cart' ); ?>
<?php
		$tini_cart = ob_get_clean();
		return $tini_cart;
	}
}

if ( ! function_exists( 'wd_update_tini_cart' ) ) {
	function wd_update_tini_cart() {
		die($_tini_cart_html = wd_tini_cart());
	}
}

add_action('wp_ajax_update_tini_cart', 'wd_update_tini_cart');
add_action('wp_ajax_nopriv_update_tini_cart', 'wd_update_tini_cart');

?>