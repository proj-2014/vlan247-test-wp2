<?php 
if(!class_exists('WP_Widget_Recent_Post_Slider')){
	class WP_Widget_Recent_Post_Slider extends WP_Widget {
    	function WP_Widget_Recent_Post_Slider() {
				$widget_ops = array('description' => 'This widget show recent posts by slider.' );

				$this->WP_Widget('recent_post_slider', 'WD - Recent Posts [Slider]', $widget_ops);
		}
	  
		function widget($args, $instance){
			global $wpdb; // call global for use in function
			
			
			$cache = wp_cache_get('recent_post_slider', 'widget');			
			
			if ( ! is_array( $cache ) )
				$cache = array();

			if ( isset( $cache[$args['widget_id']] ) ) {
				echo $cache[$args['widget_id']];
				return;
			}

			ob_start();			
			
			extract($args); // gives us the default settings of widgets
			
			$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent','wpdance') : $instance['title']);
			
			$link = empty( $instance['link'] ) ? '#' : esc_url($instance['link']);
			$link = ( isset($link) && strlen($link) > 0 ) ? $link : "#" ;
			
			$_limit = absint($instance['limit']) == 0 ? 5 : absint($instance['limit']);
			
			echo $before_widget; // echos the container for the widget || obtained from $args
			if($title){
				echo $before_title . $title . $after_title;
			}
			wp_reset_query();	
			$num_count = count(query_posts("showposts={$_limit}&ignore_sticky_posts=1"));	
			echo '<div class="recent_list_carousel">';
			if(have_posts())	{
				$id_widget = 'recent-'.rand(0,1000).time();
				echo '<ul class="wd_recent_posts_'.$id_widget.'">';
				$i = 0;
				while(have_posts()) {the_post();global $post;
					?>
					<li class="item<?php //if($i == 0) echo ' first';?><?php //if(++$i == $num_count) echo ' last';?>">
						<div class="detail">
							<div class="author"><?php _e('POST BY','wpdance');?> <?php the_author_posts_link();?></div>
							<div class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpdance' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php echo esc_attr(get_the_title()); ?>
								</a>
								<p class="entry-desc">
									<?php echo the_excerpt_max_words(4,$post),'...';?>
								</p>
							</div>
							<div class="post_thumbnail">
								<a href="<?php the_permalink(); ?>">
								<?php if(has_post_thumbnail()){ ?>
									<?php the_post_thumbnail(array(240,240),array('title'=>get_the_title()));?>	
								<?php } else { ?>	
									<img alt="<?php the_title(); ?>" height="240" width="240" title="<?php the_title();?>" src="<?php echo get_template_directory_uri(); ?>/images/no-image-blog.gif"/>
								<?php } ?>
								</a>
							</div>
							<!--<p class="entry-meta">
								<span class="entry-date-day"><?php echo get_the_date('d') ?></span>
								<span class="entry-date-month"><?php echo get_the_date('M') ?></span>
							</p>-->
							
							<!--<div class="entry-meta">
								<div class="author-info">
									<span class="entry-date"><?php //echo get_the_date('F d, Y') ?></span>
								</div><!-- .author-info -->
							<!--</div> --><!-- .entry-meta -->
							
						</div><!-- .detail -->
						
					</li>
				
					
				<?php }
				echo '</ul>';
				echo '<div class="clearfix"></div>';
				echo '<div class="wd_recent_control"><a class="prev" title="prev" id="wd_recent_posts_prev_'.$id_widget.'" href="#">&lt;</a>';
				echo '<a class="next" title="next" id="wd_recent_posts_next_'.$id_widget.'" href="#" >&gt;</a> </div>';
			}
			echo '</div>';
?>			
			<script type="text/javascript" language="javascript">
		//<![CDATA[
			jQuery(document).ready(function() {
				
				var li_widget = jQuery('.wd_recent_posts_<?php echo $id_widget;?>').parent().parent('li');
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
				jQuery('.widget_recent_post_slider').each(function( i, value ) {
					if(jQuery(value).find('ul.wd_recent_posts_<?php echo $id_widget;?>').parent('.caroufredsel_wrapper').length > 0 )
						return;
					//jQuery(value).addClass('slider_' + i);
					//var _next = jQuery(value).find('ul.wd_recent_posts_<?php echo $id_widget;?>').siblings('.wd_recent_control').children('.next');
					//var _prev = jQuery(value).find('ul.wd_recent_posts_<?php echo $id_widget;?>').siblings('.wd_recent_control').children('.prev');
					jQuery(value).find('ul.wd_recent_posts_<?php echo $id_widget;?>').siblings('.wd_recent_control').addClass('control_' + i);
					jQuery(value).find('ul.wd_recent_posts_<?php echo $id_widget;?>').siblings('.wd_recent_control').addClass('control_' + i);
					
					jQuery(value).find('ul.wd_recent_posts_<?php echo $id_widget;?>').carouFredSel({
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
					,prev    : '.control_' + i +' #wd_recent_posts_prev_<?php echo $id_widget; ?>'
					,next    : '.control_' + i+' #wd_recent_posts_next_<?php echo $id_widget; ?>'
					});
					
				});
				//window.setTimeout( function(){
				//		jQuery('.widget_recent_post_slider' + temp_class  +' .wd_recent_posts_<?php echo $id_widget;?>').carouFredSel(_slider_datas);
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
<?php		
			wp_reset_query();
			
			echo $after_widget; // close the container || obtained from $args
			$content = ob_get_clean();

			if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;

			echo $content;

			wp_cache_set('recent_post_slider', $cache, 'widget');			
			
		}

		
		function update($new_instance, $old_instance) {
			return $new_instance;
		}

		
		function form($instance) {        

			//Defaults
			$instance = wp_parse_args( (array) $instance, array( 'title' => 'From Our Blog','link'=>'#','limit'=>4) );
			$title = esc_attr( $instance['title'] );
			$limit = absint( $instance['limit'] );
			$link = esc_url( $instance['link'] );
			?>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title','wpdance' ); ?> : </label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e( 'Title Link','wpdance' ); ?> : </label>
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" /></p>			
			
			<p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Limit','wpdance' ); ?> : </label>
			<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></p>
			
	<?php
		   
		}
	}
}
?>