<?php 
if(!function_exists ('wd_hot_product')){
	function wd_hot_product($atts,$content = null) {
		extract(shortcode_atts(array(
			'title'			=>	''
			,'number'		=>	'4'
		),$atts));
		$post_type = "product";
		
		$thumbnail_width = 60;
		$thumbnail_height = 60;

		wp_reset_query();
		
		$popular=new wp_query(array('post_type' => 'product','posts_per_page' => $number,'post_status'=>'publish','ignore_sticky_posts'=> 1, 'order' => 'DESC'));
		global $post,$product;
?>
		<?php if($popular->post_count>0){
			$i = 0;
			$id_widget = 'hot_product-'.rand(0,1000).time();
			$count = 1;
			ob_start();
		?>
		<div class="wd_hot_product wd_hot_loading">
			<div class="wd_heading">
				<h5>hot products</h5>
				<div class="wd_number_real"><span>1/<?php echo $popular->post_count;?></span></div>
			</div>
			<ul class="products popular-post-list<?php echo $id_widget;?>">
				<?php while ($popular->have_posts()) : $popular->the_post();?>
				<li class="post-<?php echo $post->ID;?> product type-product status-publish henry">
					<div class="wd_number"><span><?php echo $count; ?>/<?php echo $popular->post_count;?></span></div>
					<div class="wd_product_wrapper">
						<div class="product_thumbnail_wrapper image image-style">
							<a class="thumbnail" href="<?php echo get_permalink($post->ID); ?>">
								<?php  
									if ( has_post_thumbnail() ) {
										the_post_thumbnail('wd_hot_product',array('title' => esc_attr(get_the_title()),'alt' => esc_attr(get_the_title()) ));
									} 
								?>
							</a>		
							<span class="shadow"></span>
							<?php 
								global $wd_data;
								if(!isset($wd_data['wd_catelog_mod']) || (isset($wd_data['wd_catelog_mod']) && $wd_data['wd_catelog_mod'] == 1)){
							?>
							<div class='list_add_to_cart'>
							<?php woocommerce_template_loop_add_to_cart(); ?>
							</div>
							<?php 
								}
							?>
						</div><!-- .image -->
						<?php $product = get_product( $popular->post ); ?>
						<div class="product-meta-wrapper detail">
							<p class="hot_pr_sku"><?php echo $product->get_sku(); ?></p>
							<p class="title"><a  href="<?php echo get_permalink($post->ID); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></p>
							<?php //the_excerpt();?>
							<?php woocommerce_template_loop_price(); ?>
						</div>
						<input type='hidden' value='<?php echo $product->id; ?>' class='hidden_product_id product_hidden_<?php echo $product->id; ?>'>
					</div>	
				</li>
				<?php $count++;?>
				<?php endwhile;?>
			</ul>
			<?php			
				echo '<div class="clearfix"></div>';
				echo '<div class="wd_hot_control"><a class="prev" title="prev" id="wd_hot_product_prev_'.$id_widget.'" href="#">&lt;</a>';
				echo '<a class="next" title="next" id="wd_hot_product_next_'.$id_widget.'" href="#" >&gt;</a> </div>';
			 }?>
		</div>
		<script type="text/javascript" language="javascript">
	//<![CDATA[
		jQuery(document).ready(function() {
			jQuery('.wd_hot_product').removeClass('wd_hot_loading');
			var li_widget = jQuery('.popular-post-list<?php echo $id_widget;?>').parent().parent('li');
			var temp_class = '';
			if(li_widget.hasClass('first')){ 
				temp_class = '.first';
			}
			
			_slider_datas = {				
				responsive: true
				,width	: 240
				,height	: 'auto'
				,scroll  : {
					items	: 1,
				}
				,debug	 : true
				,auto    : false
				,swipe	: { onMouse: true, onTouch: true }	
				,items   : { 
					width		: 240
					,height		: 'auto'
					,visible	: {
						min		: 1
						,max	: 1
					}						
				}	
				,scroll	: 	{
							items	: 1
							,onAfter : function( data ) {
								var temp = jQuery('.wd_hot_product .wd_number').html();
								jQuery('.wd_hot_product .wd_number_real').html(temp);
							}
				}
			};
			jQuery('.wd_hot_product').each(function( i, value ) {
				if(jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').parent('.caroufredsel_wrapper').length > 0 )
					return;
				
				jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').siblings('.wd_hot_control').addClass('control_' + i);
				jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').siblings('.wd_hot_control').addClass('control_' + i);
				
				_slider_datas.prev    = '.control_' + i +' #wd_hot_product_prev_<?php echo $id_widget; ?>';
				_slider_datas.next    = '.control_' + i+' #wd_hot_product_next_<?php echo $id_widget; ?>';
				
				jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').carouFredSel(_slider_datas);
				
			});
			
			
			jQuery('window').bind('resize',jQuery.debounce( 250, function(){
				jQuery('.wd_hot_product').each(function( i, value ) {
					jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').trigger('configuration ',["items.width", 300, true]);
					jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').trigger('destroy',true);
					jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').carouFredSel(_slider_datas);
				});
			}));				
			
		});	
	//]]>	
	</script>
	<?php 
		$ret_html = ob_get_contents();
		ob_end_clean();
	?>	
		<?php wp_reset_query(); ?>
	
<?php
	return $ret_html;
	}		
}
add_shortcode('hot_product','wd_hot_product');
?>