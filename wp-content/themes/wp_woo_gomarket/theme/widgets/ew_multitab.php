<?php
/**
 * EM WordPress Video Widget
 */
if(!class_exists('WP_Widget_Ew_multitab')){
	class WP_Widget_Ew_multitab extends WP_Widget {

		function WP_Widget_Ew_multitab() {
			$widget_ops = array( 'classname' => 'widget_multitab', 'description' => __( "WD - Multi Tabs",'wpdance' ) );
			$this->WP_Widget('multitab', __('WD - MultiTab','wpdance'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract( $args );
			global $wpdb; // call global for use in function

			$title_recent = empty( $instance['title_recent'] ) ? __( 'Latest News','wpdance' ) : $instance['title_recent'];
			$title_comment = empty( $instance['title_comment'] ) ? __( 'Comments','wpdance' ) : $instance['title_comment'];

			$num_recent = empty( $instance['num_recent'] ) ? 5 : absint($instance['num_recent']);
			$num_comment = empty( $instance['num_comment'] ) ? 5 : absint($instance['num_comment']);
			

			$thumbnail_width = 60;
			$thumbnail_height = 60;
			$_thumb_size = array(60,60);

			echo $before_widget;
			wp_reset_query();
			//add_image_size('tabs-post-thumbnail',$thumbnail_width,$thumbnail_height,true);
	?>
		<div class="container-tabs">
			<div id="tabs-post-sidebar" class="tabs-post-sidebar">
				<ul class="nav nav-tabs wd-widget-multitabs">
					<li class="first"><a href="#recent-tab"><span><span><?php echo esc_attr($title_recent); ?></span></span></a></li>
					<li class="last"><a href="#comment-tab"><span><span><?php echo esc_attr($title_comment); ?></span></span></a></li>     				
				</ul>
			

				<!-- Recent Tab -->
				<div class="tab-content">
				
					<?php $r = new WP_Query(array('posts_per_page' => $num_recent, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));?>
					<div id="recent-tab" class="tab-post-content tab-pane">
					<div class='top-left'><div class='top-right'></div></div>
						<?php if ($r->have_posts()) {$i = 0; ?>
						<div class="contentcenter">
						<ul class="recent-post-list tabs-post-list">
						<?php  while ($r->have_posts()) { 
								global $post;
								$r->the_post();
							?>
									<li <?php if($i==0) echo "class='first'";else if($i == $r->post_count - 1) echo "class='last'";?>>
										<div class="image">
											<a class="thumbnail" href="<?php the_permalink(); ?>">
												<?php 
													if ( has_post_thumbnail() ) {
														the_post_thumbnail('prod_tini_thumb',array('title' => esc_attr(get_the_title()),'alt' => esc_attr(get_the_title()) ));
													} 
												?>
											</a>
											<span class="shadow"></span>
										</div>
										<div class="content">
											<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
											<span class="wpt-author-time">
												<span class="author"><i class="icon-user custom-icon"></i><?php the_author(); ?></span>
												<span class="time"><i class="icon-calendar custom-icon"></i><?php the_time(get_option( 'date_format' )); ?></span>
												<span class="comment-number"><i class="icon-comments-alt custom-icon"></i><?php comments_number( '0 Comments','1 Comment','% Comments'); ?></span>
											</span>
										</div>
									</li>
						<?php $i++;} ?>
						</ul>
						</div>
						<?php }?>
						<?php wp_reset_query(); ?>
						<div class='bot-left'><div class='bot-right'></div></div>
					</div><!-- End #recent-tab -->

					<!-- Comment Tab -->
					<?php
					$recent_comments = get_comments( array(
						'number'    => $num_comment,
						'status'    => 'approve'
					) );?>
					<div id="comment-tab" class="tab-post-content tab-pane">
					<div class='top-left'><div class='top-right'></div></div>
					<?php
					if(count($recent_comments)){$i = 0;
					?>	<div class="contentcenter">
						<ul class="tabs-comments-list">
						<?php  
							foreach ($recent_comments as $comment) { $GLOBALS['comment'] = $comment;
								switch ( $comment->comment_type ) :
									case '':
									$class = "";
									if($i == 0)
										$class .= "first ";
									if(++$i == count($recent_comments))
										$class .= "last";
							?>
									<li <?php if($class) echo "class='$class'";?>>
										<div class="avarta"><a href="<?php comment_link() ; ?>"><?php echo get_avatar( $comment, 58,get_bloginfo('template_url') . '/images/mycustomgravatar.png'  ); ?></a></div>
										<div class="detail">
											<div class="comment-author vcard">
												<?php printf( __( '%s', 'wpdance' ), sprintf( '<cite class="fn"><a href="%1$s" rel="external nofollow" class="url">%2$s</a></cite>', get_comment_author_url(),get_comment_author() ) ); ?>:
											</div><!-- .comment-author .vcard -->
											<blockquote class="comment-body"><?php echo  string_limit_words(get_comment_text(),10); ?></blockquote>
											<div class="comment-meta"><span><?php _e("in","wpdance")?> <a href="<?php echo esc_url(get_permalink( $comment->comment_post_ID ));?>"><?php echo esc_attr(get_the_title( $comment->comment_post_ID ));?></a></span></div>
										</div>
									</li>
								<?php
										break;
									case 'pingback'  :
									case 'trackback' :
										break;
								endswitch;		
								?>
						<?php } ?>
						</ul>
						</div>
					<?php }?>
					<?php wp_reset_query(); ?>
					<div class='bot-left'><div class='bot-right'></div></div>
					</div><!-- End #comment-multi-tab -->
				</div>
			</div>
		</div>
		
		
  
			<?php 
				$rand_id = rand();
				$random_id = "accordion-".$rand_id;
			?>
			<div class="accordion-tabs wd-widget-multitabs-accordion" id="<?php echo $random_id;?>" style="display:none;">
				
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" href="#collapseTwo-<?php echo $rand_id;?>" data-parent="#<?php echo $random_id;?>" data-toggle="collapse"><span><span><?php echo esc_attr($title_recent); ?></span></span></a>
					</div>
					<div class="accordion-body collapse" id="collapseTwo-<?php echo $rand_id;?>">
						<div class="accordion-inner">
						</div>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" href="#collapseThree-<?php echo $rand_id;?>" data-parent="#<?php echo $random_id;?>" data-toggle="collapse"><span><span><?php echo esc_attr($title_comment); ?></span></span></a>
					</div>
					<div class="accordion-body collapse" id="collapseThree-<?php echo $rand_id;?>">
						<div class="accordion-inner">
						</div>
					</div>
				</div>
			</div>	
			
			<script type="text/javascript">
			//<![CDATA[
				 jQuery(function() {
					var windowWidth = jQuery(window).width();	
					jQuery( ".tabs-post-sidebar" ).tabs({ fx: { opacity: 'toggle', duration:'slow'} }).addClass( "ui-tabs-vertical ui-helper-clearfix" );						
					jQuery(window).resize(function() {
						windowWidth = jQuery(window).width();
						if( jQuery.browser.msie &&  parseInt( jQuery.browser.version, 10 ) == 7 ){
							jQuery.debounce(1000, function() {
								if(windowWidth >=200 && windowWidth <= 768){
									jQuery(".widget_multitab > .accordion-tabs").each(function(index,value){
										recentHtml = jQuery(value).siblings('.container-tabs').find('#recent-tab').html();
										cmtHtml = jQuery(value).siblings('.container-tabs').find('#comment-tab').html();
										jQuery(value).find('#collapseTwo-<?php echo $rand_id;?>').children().html(recentHtml);
										jQuery(value).find('#collapseThree-<?php echo $rand_id;?>').children().html(cmtHtml);
										jQuery(value).siblings('.container-tabs').hide();
										jQuery(value).show().collapse({
											toggle : false
										});
									});
								}else if( windowWidth >= 768 ){
									jQuery(".widget_multitab > .accordion-tabs").each(function(index,value){
										jQuery(value).hide().siblings('.container-tabs').show();
									});
									
								}
							});
						}else{
							if(windowWidth >=200 && windowWidth <= 768){
								jQuery(".widget_multitab > .accordion-tabs").each(function(index,value){
									recentHtml = jQuery(value).siblings('.container-tabs').find('#recent-tab').html();
									cmtHtml = jQuery(value).siblings('.container-tabs').find('#comment-tab').html();
									jQuery(value).find('#collapseTwo-<?php echo $rand_id;?>').children().html(recentHtml);
									jQuery(value).find('#collapseThree-<?php echo $rand_id;?>').children().html(cmtHtml);
									jQuery(value).siblings('.container-tabs').hide();
									jQuery(value).show().collapse({
										toggle : false
									});
								});
							}else if( windowWidth >= 768 ){
								jQuery(".widget_multitab > .accordion-tabs").each(function(index,value){
									jQuery(value).hide().siblings('.container-tabs').show();
									//jQuery("#right-sidebar").css("height","auto");
								});
								
							}
						}
						

					});

					
					if(windowWidth >=200 && windowWidth <= 768){
						jQuery(".widget_multitab > .accordion-tabs").each(function(index,value){
							recentHtml = jQuery(value).siblings('.container-tabs').find('#recent-tab').html();
							cmtHtml = jQuery(value).siblings('.container-tabs').find('#comment-tab').html();
							jQuery(value).find('#collapseTwo-<?php echo $rand_id;?>').children().html(recentHtml);
							jQuery(value).find('#collapseThree-<?php echo $rand_id;?>').children().html(cmtHtml);
							jQuery(value).siblings('.container-tabs').hide();
							jQuery(value).show().collapse({
								toggle : false
							});
						});
					}	
					
				 });
			//]]>	 
			</script>
		

	<?php


			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
				$instance = $old_instance;
				$instance['title_recent'] = strip_tags($new_instance['title_recent']);
				$instance['title_comment'] = strip_tags($new_instance['title_comment']);
			   
				$instance['num_recent'] = strip_tags($new_instance['num_recent']);
				$instance['num_comment'] = strip_tags($new_instance['num_comment']);
			   

				// $instance['thumbnail_width'] = strip_tags($new_instance['thumbnail_width']);
				// $instance['thumbnail_height'] = strip_tags($new_instance['thumbnail_height']);

				return $instance;
		}

		function form( $instance ) {
				//Defaults
				$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
				
				$title_recent = isset($instance['title_recent']) ? esc_attr( $instance['title_recent'] ) : '';
				$title_recent = (strlen(trim($title_recent)) <= 0 ? 'Latest' : $title_recent);
				
				$title_comment = isset($instance['title_comment']) ? esc_attr( $instance['title_comment'] ) : '';
				$title_comment = (strlen(trim($title_comment)) <= 0 ? 'Comments' : $title_comment);

				$num_comment = isset($instance['num_comment']) ? absint($instance['num_comment']) : 5;
				$num_recent = isset($instance['num_recent']) ? absint($instance['num_recent']) : 5;
				
				$num_comment = ($num_comment <= 0 ? 5 : $num_comment);
				$num_recent = ($num_recent <= 0 ? 5 : $num_recent);				
	?>
				<p><label for="<?php echo $this->get_field_id('title_recent'); ?>"><?php _e( 'Title for latest tab','wpdance' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title_recent'); ?>" name="<?php echo $this->get_field_name('title_recent'); ?>" type="text" value="<?php echo $title_recent; ?>" /></p>

				<p><label for="<?php echo $this->get_field_id('title_comment'); ?>"><?php _e( 'Title for comment tab','wpdance' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title_comment'); ?>" name="<?php echo $this->get_field_name('title_comment'); ?>" type="text" value="<?php echo $title_comment; ?>" /></p>

				<p><label for="<?php echo $this->get_field_id('num_recent'); ?>"><?php _e( 'The number of latest post','wpdance' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('num_recent'); ?>" name="<?php echo $this->get_field_name('num_recent'); ?>" type="text" value="<?php echo $num_recent; ?>" /></p>

				<p><label for="<?php echo $this->get_field_id('num_comment'); ?>"><?php _e( 'The number of comment','wpdance' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('num_comment'); ?>" name="<?php echo $this->get_field_name('num_comment'); ?>" type="text" value="<?php echo $num_comment; ?>" /></p>

	<?php
		}
	}
}
?>
