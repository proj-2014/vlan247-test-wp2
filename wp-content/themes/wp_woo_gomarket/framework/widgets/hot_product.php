<?php 
// Create widget tabs post
if(!class_exists('WP_Widget_Hot_Product')){
	class WP_Widget_Hot_Product extends WP_Widget {
		function WP_Widget_Hot_Product() {
			$widget_ops = array( 'classname' => 'widget_hot_product', 'description' => __( "Show Hot Products",'wpdance' ) );
			$this->WP_Widget('hot_product', __('WD - Hot Products','wpdance'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters('widget_title', empty($instance['title_popular']) ? __('Hot Products','wpdance') : $instance['title_popular']);
			$num_popular = empty( $instance['num_popular'] ) ? 5 : absint($instance['num_popular']);
			
			$post_type = "product";
			
			$thumbnail_width = 60;
			$thumbnail_height = 60;

			$output = $before_widget;
			if ( $title )
				$output .= $before_title . $title . $after_title;
			
			echo $output;
			wp_reset_query();
			
			$popular=new wp_query(array('post_type' => 'product','posts_per_page' => $num_popular,'post_status'=>'publish','ignore_sticky_posts'=> 1, 'order' => 'DESC'));
			global $post,$product;
	?>
			<?php if($popular->post_count>0){
				$i = 0;
				$id_widget = 'hot_product-'.rand(0,1000).time();
			?>
			<ul class="popular-post-list<?php echo $id_widget;?>">
				<?php while ($popular->have_posts()) : $popular->the_post();?>
				<li>
					<div class="wd_hot_product_wrapper">
						<div class="image image-style">
							<a class="thumbnail" href="<?php echo get_permalink($post->ID); ?>">
								<?php  
									if ( has_post_thumbnail() ) {
										the_post_thumbnail('wd_hot_product',array('title' => esc_attr(get_the_title()),'alt' => esc_attr(get_the_title()) ));
									} 
								?>
							</a>		
							<span class="shadow"></span>
						</div><!-- .image -->
						<?php $product = get_product( $popular->post ); ?>
						<div class="detail">
							<p class="hot_pr_sku"><?php echo $product->get_sku(); ?></p>
							<p class="title"><a  href="<?php echo get_permalink($post->ID); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></p>
							<?php //the_excerpt();?>
							<?php woocommerce_template_loop_price(); ?>
						</div>
					</div>
				</li>
				<?php endwhile;?>
			</ul>
			<?php			
				echo '<div class="clearfix"></div>';
				echo '<div class="wd_hot_control"><a class="prev" title="prev" id="wd_hot_product_prev_'.$id_widget.'" href="#">&lt;</a>';
				echo '<a class="next" title="next" id="wd_hot_product_next_'.$id_widget.'" href="#" >&gt;</a> </div>';
			 }?>
			
			<script type="text/javascript" language="javascript">
		//<![CDATA[
			jQuery(document).ready(function() {
				
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
		//			,prev    : '#wd_recent_posts_prev_<?php echo $id_widget; ?>'
		//			,next    : '#wd_recent_posts_next_<?php echo $id_widget; ?>'
				};
				
				jQuery('.widget_hot_product').each(function( i, value ) {
					if(jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').parent('.caroufredsel_wrapper').length > 0 )
						return;
					
					jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').siblings('.wd_hot_control').addClass('control_' + i);
					jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').siblings('.wd_hot_control').addClass('control_' + i);
					
					jQuery(value).find('ul.popular-post-list<?php echo $id_widget;?>').carouFredSel({
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
					,prev    : '.control_' + i +' #wd_hot_product_prev_<?php echo $id_widget; ?>'
					,next    : '.control_' + i+' #wd_hot_product_next_<?php echo $id_widget; ?>'
					});
					
				});
				//window.setTimeout( function(){
				//		jQuery('.widget_hot_product' + temp_class  +' .wd_recent_posts_<?php echo $id_widget;?>').carouFredSel(_slider_datas);
				//},2000);	
				
				/*
				jQuery('window').bind('resize',jQuery.debounce( 250, function(){	
					_slider_config = get_layout_config(jQuery('.upsells.products').width(),_visible_items);
						_upsell_item_width = jQuery(window).width() < 600 ? 300 : 183;
						_slider_datas.items.width = _upsell_item_width;
						jQuery('#_upsell_ul_001').trigger('configuration ',["items.width", 300, true]);
						jQuery('#_upsell_ul_001').trigger('destroy',true);
						jQuery('#_upsell_ul_001').carouFredSel(_slider_datas);
				}));				
				*/
			});	
		//]]>	
		</script>
			
			
			<?php wp_reset_query(); ?>
			
	<?php
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
				$instance = $old_instance;
				$instance['title_popular'] = strip_tags($new_instance['title_popular']);
				$instance['num_popular'] = absint($new_instance['num_popular']);
				return $instance;
		}

		function form( $instance ) {
				//Defaults
				$instance = wp_parse_args( (array) $instance, array( 'title_popular' => 'Popular' , 'num_popular' => 5 ) );
				$title_popular = esc_attr( $instance['title_popular'] );
				$num_popular = absint( $instance['num_popular'] );

	?>
				<p><label for="<?php echo $this->get_field_id('title_popular'); ?>"><?php _e( 'Title for popular tab:','wpdance' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title_popular'); ?>" name="<?php echo $this->get_field_name('title_popular'); ?>" type="text" value="<?php echo $title_popular; ?>" /></p>

				<p><label for="<?php echo $this->get_field_id('num_popular'); ?>"><?php _e( 'The number of popular post','wpdance' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('num_popular'); ?>" name="<?php echo $this->get_field_name('num_popular'); ?>" type="text" value="<?php echo $num_popular; ?>" /></p>
				

	<?php
		}
	}
}
?>