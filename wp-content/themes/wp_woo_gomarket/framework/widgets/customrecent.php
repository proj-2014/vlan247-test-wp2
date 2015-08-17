<?php 
if(!class_exists('WP_Widget_Customrecent')){
	class WP_Widget_Customrecent extends WP_Widget {
    	function WP_Widget_Customrecent() {
				$widget_ops = array('description' => 'This widget show recent post in each category you select.' );

				$this->WP_Widget('customrecent', 'WD - Recent Posts', $widget_ops);
		}
	  
		function widget($args, $instance){
			global $wpdb; // call global for use in function
			
			$cache = wp_cache_get('customrecent', 'widget');			
			
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
			wp_reset_postdata();	
			rewind_posts();			
			
			$num_count = count(query_posts("showposts={$_limit}&ignore_sticky_posts=1&post_type=post"));	
			if(have_posts())	{
				$id_widget = 'recent-'.rand(0,1000);
				echo '<ul class="recentposts">';
				$i = 0;
				while(have_posts()) {the_post();global $post;
					?>
					<li class="item<?php if($i == 0) echo ' first';?><?php if(++$i == $num_count) echo ' last';?>">
						<div class="post_thumbnail">
							<a href="<?php the_permalink(); ?>">
							<?php if(has_post_thumbnail()){ ?>
								<?php the_post_thumbnail(array(70,70),array('title'=>get_the_title()));?>	
							<?php } else { ?>	
								<img alt="<?php the_title(); ?>" height="70" width="70" title="<?php the_title();?>" src="<?php echo get_template_directory_uri(); ?>/images/no-image-blog.gif"/>
							<?php } ?>
							</a>
						</div>
						<div class="detail">
							<div class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpdance' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php echo esc_attr(get_the_title()); ?>
								</a>
							</div>
							<p class="entry-meta">
								<span class="entry-date-day"><?php echo get_the_date('d') ?></span>
								<span class="entry-date-month"><?php echo get_the_date('M') ?></span>
							</p>
							<!--<span class="author"><?php _e('By','wpdance');?> <?php the_author_posts_link();?></span>-->
						</div><!-- .detail -->
						
					</li>
				
					
				<?php }
				echo '</ul>';
			}
			wp_reset_query();
			
			echo $after_widget; // close the container || obtained from $args
			$content = ob_get_clean();

			if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;

			echo $content;

			wp_cache_set('customrecent', $cache, 'widget');			
			
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