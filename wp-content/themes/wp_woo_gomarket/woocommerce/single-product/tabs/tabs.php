<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );


if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs tabbable tabs-default style2" id="multitabs-detail">
		<ul class="nav nav-tabs">
			<?php
				$active = ' active';
				$last_arr ='';
				foreach ( $tabs as $key => $tab ) : 
				if($tab == end($tabs))
					$last_arr = ' last';
			?>
				
				<li class="<?php echo $key ?>_tab<?php echo $last_arr; echo $active; ?>">
					<a data-toggle="tab" href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
				</li>
			<?php $active = ''; $last_arr ='';?>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content">
			<?php 
				$active_in = 'active in';
				foreach ( $tabs as $key => $tab ) : 
			?>
				<div class="tab-pane fade <?php echo $active_in; ?>" id="tab-<?php echo $key ?>">
					<?php call_user_func( $tab['callback'], $key, $tab ) ?>
				</div>	
			<?php $active_in = ''; ?>
			<?php endforeach; ?>		
		</div>
		
	</div>
	
	

	
<?php endif; ?>