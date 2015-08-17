<?php
/**
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 */

//remove default hook
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'wd_list_template_loop_add_to_cart', 10 );

//add filter hook
add_filter('woocommerce_widget_cart_product_title','add_sku_after_title',100000000000000000000000000000,2);
//add tab to prod page
add_filter( 'woocommerce_product_tabs', 'wd_addon_product_tabs',13 );
//add new tab to prod page
add_filter( 'woocommerce_product_tabs', 'wd_addon_custom_tabs',12 );
//add add-to-cart text
//add_filter( "single_add_to_cart_text", "update_add_to_cart_text", 10, 1 );
//set default columns
add_filter('loop_shop_columns', 'loop_columns');


/**********************Breadcumns Woocommerce Page***********************/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
add_action( 'wd_before_main_content', 'dimox_shop_breadcrumbs', 10, 0 );
/**********************End Breadcumns Woocommerce Page***********************/

/***************** Begin Content Product *******************/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
//add sale,featured and off save label
add_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );			
add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );	

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
//add_action( 'woocommerce_after_shop_loop_item', 'wd_list_template_loop_add_to_cart', 10 );
add_action ('woocommerce_after_shop_loop_item','open_div_style',1);
add_action ('woocommerce_after_shop_loop_item','get_product_categories',2);
add_action ('woocommerce_after_shop_loop_item','add_product_title',3);
add_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',4);
add_action ('woocommerce_after_shop_loop_item','add_short_content',5);
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 7 );
add_action ('woocommerce_after_shop_loop_item','close_div_style',12);
add_action( 'wp' , 'remove_excerpt_from_list' , 20);
/************************ End Content Product *********************/

/***************** Begin Content Single Product *******************/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 14 );
//add_action( 'woocommerce_single_product_summary', 'wd_template_single_review', 14 );
add_action( 'woocommerce_single_product_summary', 'wd_template_single_availability', 16 );
add_action( 'woocommerce_single_product_summary', 'wd_template_single_sku', 18 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 25 );
//add_action( 'woocommerce_single_product_summary', 'wd_template_single_content', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 29 );

add_action( 'woocommerce_after_single_product_summary', 'wd_product_ad_banner', 5 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );	
add_action( 'woocommerce_after_single_product_summary', 'wd_upsell_display', 15 );
/***************** End Content Single Product *********************/

/***************** Begin Checkout Page *******************/
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'wd_after_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
//add_action( 'woocommerce_review_order_before_submit', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_after_checkout_form', 'wd_checkout_add_on_js', 10 );
add_action( 'woocommerce_before_checkout_registration_form', 'wd_checkout_fields_form', 10 );
/***************** End Checkout Page *********************/

/***************** Begin Product-image *******************/
add_action( 'woocommerce_product_thumbnails', 'wd_template_shipping_return', 30 );
/***************** End Product-image *********************/

	
//custom hook
function wd_list_template_loop_add_to_cart(){
	echo "<div class='list_add_to_cart'>";
	woocommerce_template_loop_add_to_cart();
	echo "</div>";
}

function remove_excerpt_from_list(){
	if(class_exists('woocommerce') && (is_tax( 'product_cat' ) || is_shop() )){
		remove_action( 'woocommerce_after_shop_loop_item_title', 'wd_list_template_loop_add_to_cart', 10 );
		remove_action ('woocommerce_after_shop_loop_item','add_short_content',5);
		add_action( 'woocommerce_after_shop_loop_item', 'wd_list_template_loop_add_to_cart', 8 );
		//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 9);
	} else {
		add_action( 'woocommerce_after_shop_loop_item_title', 'wd_list_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'wd_list_template_loop_add_to_cart', 8 );
	}
}

function add_short_content(){
	global $product;
	$content = get_the_content($product);
	$rs = '';
	$rs .= '<div class="product_short_content">';
	//$rs .= strip_tags(substr($content,0,60));
	$rs .= wp_trim_words( strip_tags($content), $num_words = 8, $more = null );
	$rs .= '</div>';
	echo apply_filters('the_content', $rs);
}
function get_product_categories(){
	global $product;
	$rs = '';
	$rs .= '<div class="wd_product_categories">';
	$product_categories = wp_get_post_terms(get_the_ID($product),'product_cat');
	$count = count($product_categories);
	if ( $count > 0 ){
		foreach ( $product_categories as $term ) {
		$rs.= '<a href="'.get_term_link($term->slug,$term->taxonomy).'">'.$term->name . "</a>, ";

		}
		$rs = substr($rs,0,-2);
	}
	$rs .= '</div>';
	echo $rs;
}




function wd_template_loop_product_thumbnail(){
	/*global $product,$post;
	$_prod_galleries = $product->get_gallery_attachment_ids( );
	echo "<div class='product-image-front'>";
	echo woocommerce_get_product_thumbnail();
	echo '</div>';
	if( is_array($_prod_galleries) && count($_prod_galleries) > 0 ){
		echo "<div class='product-image-back'>";
		echo wp_get_attachment_image( $_prod_galleries[0],'shop_catalog' );
		echo '</div>';
	}*/
	global $product,$post;
	$_prod_galleries = $product->get_gallery_attachment_ids( );
	
	$_front_classes = "product-image-front";
	if ( !has_post_thumbnail() ){
		$_front_classes = $_front_classes . " default-thumb";
	}	
	
	echo "<div class='{$_front_classes}'>";
	echo woocommerce_get_product_thumbnail();
	echo '</div>';
	if( is_array($_prod_galleries) && count($_prod_galleries) > 0 ){
		echo "<div class='product-image-back'>";
		echo wp_get_attachment_image( $_prod_galleries[0],'shop_catalog' );
		echo '</div>';
	}
}


//open a div to wrap all product meta
function open_div_style(){
	echo "<div class=\"product-meta-wrapper\">";
}
//close div product meta wrapper
function close_div_style(){
	echo "</div>";
}

function add_product_title(){
	global $post, $product,$product_datas;
	$_uri = esc_url(get_permalink($post->ID));
	echo "<h3 class=\"heading-title product-title\">";
	echo "<a href='{$_uri}'>". esc_attr(get_the_title()) ."</a>";
	echo "</h3>";
}


function add_label_to_product_list(){
	global $post, $product,$product_datas;
	echo '<div class="product_label">';
	if ($product->is_on_sale()){ 
		if( $product->regular_price > 0 ){
			$_off_percent = (1 - round($product->get_price() / $product->regular_price, 2))*100;
			$_off_price = round($product->regular_price - $product->get_price(), 0);
			$_price_symbol = get_woocommerce_currency_symbol();
			echo "<span class=\"onsale show_off product_label\">".__( 'Sale','wpdance' )."<span class=\"off_number\">{$_price_symbol}{$_off_price}</span></span>";	
		}else{
			echo "<span class=\"onsale product_label\">".__( 'Sale','wpdance' )."</span>";
		}
	}
	if ($product->is_featured()){
		echo "<span class=\"featured product_label\">".__( 'Featured','wpdance' )."</span>";
	}
	echo "</div>";
}

function add_sku_to_product_list(){
	global $product, $woocommerce_loop;
	echo "<span class=\"product_sku\">" . esc_attr($product->get_sku()) . "</span>";
}


function wd_template_loop_product_big_thumbnail(){
	global $product,$post;	
	$thumb = get_post_thumbnail_id($post->ID);
	$_prod_galleries = $product->get_gallery_attachment_ids( );
	?>
		<!--<div class="product-image-big-layout">
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('prod_midium_thumb_1',array('class' => 'big_layout')); 
				} 				
			?>
		</div>-->	
		<div class="product-image-front">			
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('prod_midium_thumb_1',array('class' => 'big_layout') ); 
				} 				 
			?>
		</div>
		<?php
		if( is_array($_prod_galleries) && count($_prod_galleries) > 0 ):
			$_image_src = wp_get_attachment_image_src( $_prod_galleries[0],'full' );
		?>	
			<div class="product-image-back">
			<?php 
				echo wp_get_attachment_image( $_prod_galleries[0], 'prod_midium_thumb_1', false, array('class' => 'big_layout') );
			?>
			</div>
		<?php		
			endif;
		?>		
	<?php	
}


function custom_product_thumbnail(){
	global $product,$post;
	$thumb = get_post_thumbnail_id($post->ID);
	$_prod_galleries = $product->get_gallery_attachment_ids( );					
	?>
		<div class="product-image-front">			
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('prod_midium_thumb_2',array('class' => 'big_layout') ); 
				} 				 
			?>
		</div>		
	<?php
		if( is_array($_prod_galleries) && count($_prod_galleries) > 0 ):
			$_image_src = wp_get_attachment_image_src( $_prod_galleries[0],'full' );
	?>	
			<div class="product-image-back">
				<?php 
					echo wp_get_attachment_image( $_prod_galleries[0], 'prod_midium_thumb_2', false, array('class' => 'big_layout') );
					//print_thumbnail($_image_src[0],true,get_the_title($post->ID), 366, 360,'big_layout');
				?>
			</div>
	<?php		
		endif;
	?>	
	<?php					
}



function add_sku_after_title($title,$product){
	$prod_uri = "<a href='".get_permalink( $product->id )."'>";
	$_sku_string = "</a>{$prod_uri}<span class=\"product_sku\">{$product->get_sku()}</span>";
	return $title.$_sku_string;
}




function wd_addon_product_tabs( $tabs = array() ){
		global $product, $post,$wd_data;
		// Description tab - shows product content
		if ( $post->post_content )
			$tabs['description'] = array(
				'title'    => __( 'Description', 'wpdance' ),
				'priority' => 10,
				'callback' => 'woocommerce_product_description_tab'
			);

		
		// Reviews tab - shows comments
		if ( comments_open() && $wd_data['wd_prod_review'] )
			$tabs['reviews'] = array(
				'title'    => sprintf( __( 'Reviews (%d)', 'wpdance' ), get_comments_number( $post->ID ) ),
				'priority' => 90,
				'callback' => 'comments_template'
			);

		$tabs['tags'] = array(
				'title'    => sprintf( __( 'Product Tags', 'wpdance' ) ),
				'priority' => 80,
				'callback' => 'product_tags_template'
		);			
		if ( $product->has_attributes() || ( get_option( 'woocommerce_enable_dimension_product_attributes' ) == 'yes' && ( $product->has_dimensions() || $product->has_weight() ) ) )
			$tabs['additional_information'] = array(
				'title'    => __( 'Additional Information', 'wpdance' ),
				'priority' => 20,
				'callback' => 'woocommerce_product_additional_information_tab'
			);	
		return $tabs;
}

function wd_addon_custom_tabs ( $tabs = array() ){
	global $wd_data;
	if($wd_data['wd_prod_customtab']) {
		$tabs['wd_custom'] = array(
			'title'    =>  sprintf( __( '%s','wpdance' ), stripslashes(esc_html($wd_data['wd_prod_customtab_title'])) )
			,'priority' => 70
			,'callback' => "print_custom_tabs"
		);
		return $tabs; 
	}
}

function print_custom_tabs(){
	global $wd_data;
	echo stripslashes(htmlspecialchars_decode($wd_data['wd_prod_customtab_content']));
}


function product_tags_template(){
	global $product, $post;
	$_terms = wp_get_post_terms( $product->id, 'product_tag');
	
	echo '<div class="tagcloud">';
	
	$_include_tags = '';
	if( count($_terms) > 0 ){
		echo '<span class="tag_heading">Tags:</span>';
		foreach( $_terms as $index => $_term ){
			$_include_tags .= ( $index == 0 ? "{$_term->term_id}" : ",{$_term->term_id}" ) ;
		}
		wp_tag_cloud( array('taxonomy' => 'product_tag', 'include' => $_include_tags ) );
	} else {
		echo '<p>No Tags for this product</p>';
	}
	
	echo "</div>\n";	
	
}

/// end new tabs




function wd_template_single_review(){
	global $product;

	if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
		return;		
		
	if ( $rating_html = $product->get_rating_html() ) {
		echo "<div class=\"review_wrapper\">";
		echo $rating_html; 
		echo '<span class="review_count">'.$product->get_rating_count()," ";
		_e("Review(s)",'wpdance');
		echo "</span>";
		echo '<span class="add_new_review"><a href="#review_form" class="inline show_review_form" title="Review for '. esc_attr($product->get_title()) .' ">' . __( 'Add Your Review', 'wpdance' ) . '</a></span>';
		echo "</div>";
	}else{
		echo '<p><span class="add_new_review"><a href="#review_form" class="inline show_review_form" title="Review for '. esc_attr($product->get_title()) .' ">' . __( 'Be the first to review this product', 'wpdance' ) . '</a></span></p>';

	}

	
}

function wd_template_single_mail() {
	echo '<a href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site '.site_url().'" title="Share by Email">
				Email to a Friend
			</a>';
}
function wd_template_single_content() {
	global $product;
	echo '<div class="wd_product_content">';
	echo get_the_content($product->ID);
	echo '</div>';
}



function wd_template_shipping_return(){
	global $wd_data;
?>
	<div class="return-shipping">
        <div class="title-quick">
            <h6 class="title-quickshop">
				<?php 
					echo $title = sprintf( __( '%s','wpdance' ), stripslashes(esc_attr($wd_data['wd_prod_ship_return_title'])) );
				?>
			</h6>
        </div>
        <div class="content-quick">
            <?php echo stripslashes($wd_data['wd_prod_ship_return_content']);?>
        </div>
	</div>
<?php
}



	function wd_output_related_products() {
		woocommerce_related_products( 5, 5 );
	}






function wd_template_single_availability(){
	global $product;
	$_product_stock = get_product_availability($product);
?>	
	<p class="availability stock <?php echo esc_attr($_product_stock['class']);?>"><span class="wd_availability"><?php _e('availability:','wpdance'); ?></span><span><?php echo esc_attr($_product_stock['availability']);?></span></p>	
<?php	
	
}	

function wd_template_single_sku(){
	global $product, $post;
	echo "<p class='wd_product_sku'>".__("sku: ","wpdance")."<span class=\"product_sku\">" . esc_attr($product->get_sku()) . "</span></p>";
}	

function wd_template_single_rating(){
	global $product, $post;
	echo $product->get_rating_html();
}



function button_add_to_card(){
	global $wd_data,$product;
	$_layout_config = explode("-",$wd_data['wd_layout_style']);
	$_left_sidebar = (int)$_layout_config[0];
	$_right_sidebar = (int)$_layout_config[2];
	$temp_class = '';
	if($_left_sidebar || $_right_sidebar) {
		if($product->product_type == 'variable') { 
			$temp_class= ' variable_hidden';
		}
		if($product->product_type == 'external') { ?>
			<!--<p class="cart"><a href="<?php echo esc_url($product->get_product_url()); ?>" rel="nofollow" class="single_add_to_cart_button button alt hidden-phone"><?php echo apply_filters('single_add_to_cart_text',$product->get_button_text(), 'external'); ?></a></p>-->
			<p class="cart"><a href="<?php echo esc_url($product->get_product_url()); ?>" rel="nofollow" class="single_add_to_cart_button button alt hidden-phone"><?php echo $product->get_button_text(); ?></a></p>
		<?php  } else {
			echo '<button type="button" class="virtual single_add_to_cart_button button alt hidden-phone'.$temp_class.'">';
			echo apply_filters('single_add_to_cart_text', __( 'Add to cart', 'wpdance' ), $product->product_type); 
			echo '</button>';
		}
	}	
}


function wd_product_ad_banner(){
		if ( is_active_sidebar( 'product-ad-banner-widget-area' ) ) :
			echo '<div class="product-ad-banner-widget-area">';
				echo '<ul class="xoxo">';
					dynamic_sidebar( 'product-ad-banner-widget-area' ); 
				echo '</ul>';
			echo '</div>';
		endif; 						
}

function wd_upsell_display( $posts_per_page = '-1', $columns = 5, $orderby = 'rand' ){
	wc_get_template( 'single-product/up-sells.php', array(
				'posts_per_page'  => 15,
				'orderby'    => 'rand',
				'columns'    => 15
		) );
}







if ( ! function_exists( 'dimox_shop_breadcrumbs' ) ) {

	/**
	 * Output the WooCommerce Breadcrumb
	 *
	 * @access public
	 * @return void
	 */
	function dimox_shop_breadcrumbs( $args = array() ) {

		$defaults = apply_filters( 'woocommerce_breadcrumb_defaults', array(
			'delimiter'   => '<span class="brn_arrow">&#47;</span>',
			'wrap_before' => '<nav class="woocommerce-breadcrumb" data-itemprop="breadcrumb">',
			'wrap_after'  => '</nav>',
			'before'      => '',
			'after'       => '',
			'home'        => _x( 'Home', 'breadcrumb', 'wpdance' ),
		) );

		$args = wp_parse_args( $args, $defaults );
		
		$breadcrumbs = new WC_Breadcrumb();

		if ( $args['home'] ) {
			$breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
		}

		$args['breadcrumb'] = $breadcrumbs->generate();

		wc_get_template( 'global/breadcrumb.php', $args );
	}
}

if ( ! function_exists( 'wd_checkout_fields_form' ) ) {
	function wd_checkout_fields_form($checkout){
		$checkout->checkout_fields['account']    = array(
			'account_username' => array(
				'type' => 'text',
				'label' => __('Account username', 'wpdance'),
				'placeholder' => _x('Username', 'placeholder', 'wpdance')
				),
			'account_password' => array(
				'type' => 'password',
				'label' => __('Account password', 'wpdance'),
				'placeholder' => _x('Password', 'placeholder', 'wpdance'),
				'class' => array('form-row-first')
				),
			'account_password-2' => array(
				'type' => 'password',
				'label' => __('Account password', 'wpdance'),
				'placeholder' => _x('Comfirm Password', 'placeholder', 'wpdance'),
				'class' => array('form-row-last'),
				'label_class' => array('hidden')
				)
		);
	}
}


function update_add_to_cart_text( $button_text ){
	return $button_text = __('Add to Cart','wpdance');
}
function update_single_product_wrapper_class( $_wrapper_class ){
	return $_wrapper_class = "without_related";
}



if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 5; // 5 products per row
	}
}


if ( ! function_exists( 'wd_checkout_add_on_js' ) ) {
	function wd_checkout_add_on_js(){
?>
	<script type='text/javascript'>
		jQuery(document).ready(function() {
			jQuery('input.checkout-method').on('change',function(event){
				if( jQuery(this).val() == 'account' && jQuery(this).is(":checked") ){
					jQuery('.accordion-createaccount').removeClass('hidden');
					jQuery('#collapse-login-regis').find('input.next_co_btn').attr('rel','accordion-account');
					
				}else{
					jQuery('.accordion-createaccount').addClass('hidden');
					jQuery('#collapse-login-regis').find('input.next_co_btn').attr('rel','accordion-billing');				
				}
			});
			jQuery('input.checkout-method').trigger('change');
			
			jQuery('.next_co_btn').on('click',function(){
				var _next_id = '#'+jQuery(this).attr('rel');
				jQuery('.accordion-group').not(_next_id).find('.accordion-body').each(function(index,value){
					if( jQuery(value).hasClass('in') )
						jQuery(value).siblings('.accordion-heading').children('a.accordion-toggle').trigger('click');
				});
				if( !jQuery(_next_id).find('.accordion-body').hasClass('in') ){	
					jQuery(_next_id).find('.accordion-body').siblings('.accordion-heading').children('a.accordion-toggle').trigger('click');
				}
			});    
		
		});
	</script>
<?php	
	}
}
?>