<?php
	global $wd_data;
?>
<div class="related container">
	<span class="title"><?php echo stripslashes(esc_attr($wd_data['wd_blog_details_relatedlabel'])); ?></span>	
	<div class="related_post_slider">
		<ul class="slides">
		<?php
			$_cat_list = get_the_category($post->ID);
			$_cat_list_arr = array();
			foreach($_cat_list as $_cat_item){
				array_push($_cat_list_arr,$_cat_item->term_id);
			}
			$_list_cat_id = implode($_cat_list_arr,",");
			if( !empty( $_cat_list  ))
				$arg=array(
					'post_type' => $post->post_type,
					'cat' => $_list_cat_id,
					'post__not_in' => array($post->ID),
					'posts_per_page' => $wd_data['wd_blog_details_relatednumber']
				);
			else
				$arg=array(
				'post_type' => $post->post_type,
				'post__not_in' => array($post->ID),
				'posts_per_page' => $wd_data['wd_blog_details_relatednumber']
			);
			wp_reset_query();
			$related = new wp_query($arg);$cout = 0;
			if($related->have_posts()) : while($related->have_posts()) : $related->the_post();global $post;$cout++;
				$thumb=get_post_thumbnail_id($post->ID);
				$thumburl=wp_get_attachment_image_src($thumb,'full');
				?>
					<li class="span6 related-item <?php if($cout==1) echo " first";if($cout==$related->post_count) echo " last";?>">
						<div>
							<a class="thumbnail" href="<?php the_permalink(); ?>">
								<?php 
									if ( has_post_thumbnail() ) {
										the_post_thumbnail('blog_thumb',array('class' => 'thumbnail-blog'));
										//the_post_thumbnail( 'related_thumb',array('title' => get_the_title(),'alt' => get_the_title(),'class' => 'thumbnail-effect-1') );
										//the_post_thumbnail( 'related_thumb',array('title' => get_the_title(),'alt' => get_the_title(),'class' => 'thumbnail-effect-2') );
									} 							
								?>
								<div class="thumbnail-shadow"></div>
							</a>
							
							<p class="title"><a title="<?php echo get_the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
							<p class="time"><?php echo get_the_date('l,F d, Y');?></p>
						</div>
					</li>
				<?php
			endwhile;
			else:
				echo "<li class=\"span12 related-404\"><div class=\"alert alert-warning\">Sorry,no post found!</div></li>";
			endif;
			
			wp_reset_query();
		?>
		</ul>
	</div>
</div>
<script type="text/javascript">
	function switch_flex_slider( windowWidth,orgin_slider ){
		if( windowWidth > 981 && jQuery('.related_post_slider ul > li').length > 3 ) { //3 column
			parrent_div = jQuery('.related_post_slider').parent();
			jQuery('.related_post_slider').hide().remove();
			orgin_slider.clone().appendTo(parrent_div);
			//jQuery('.related_post_slider').html(orgin_slider.html());
			item_width = jQuery('.related_post_slider').width()/3;
			return cur_slider = jQuery('.related_post_slider').flexslider({
				animation: "slide"
				,animationLoop: false
				,itemWidth: item_width
				,itemMargin: 0
				,directionNav : true
				,prevText : "Previous"
				,nextText : "Next"
				,move: 1
				,start: function(){
					jQuery('a.flex-next').attr( "title","Next" );
					jQuery('a.flex-prev').attr( "title","Previous" );
				},
			});
		}

		if( windowWidth <= 980 && windowWidth > 481  && jQuery('.related_post_slider ul > li').length > 2 ) { //3 column
			parrent_div = jQuery('.related_post_slider').parent();
			jQuery('.related_post_slider').hide().remove();
			orgin_slider.clone().appendTo(parrent_div);
			item_width = jQuery('.related_post_slider').width()/2;
			return cur_slider = jQuery('.related_post_slider').flexslider({
				animation: "slide"
				,animationLoop: false
				,itemWidth: item_width
				,itemMargin: 0
				,move: 1
				,start: function(){
					jQuery('a.flex-next').attr( "title","Next" );
					jQuery('a.flex-prev').attr( "title","Previous" );
				},
			});
		}
		if( windowWidth <= 480 && windowWidth > 321 && jQuery('.related_post_slider ul > li').length >1 ) { //2 column
			parrent_div = jQuery('.related_post_slider').parent();
			jQuery('.related_post_slider').hide().remove();
			orgin_slider.clone().appendTo(parrent_div);
			item_width = jQuery('.related_post_slider').width();
			return cur_slider = jQuery('.related_post_slider').flexslider({
				animation: "slide"
				,animationLoop: false
				,itemWidth: item_width
				,itemMargin: 0
				,move: 1
				,start: function(){
					jQuery('a.flex-next').attr( "title","Next" );
					jQuery('a.flex-prev').attr( "title","Previous" );
				},
			});

		}		
		if( windowWidth <= 320 ) {  //1 column
			parrent_div = jQuery('.related_post_slider').parent();
			jQuery('.related_post_slider').hide().remove();
			orgin_slider.clone().appendTo(parrent_div);
			return cur_slider = jQuery('.related_post_slider').flexslider({
				animation: "slide"
				,animationLoop: false
				,start: function(){
					jQuery('a.flex-next').attr( "title","Next" );
					jQuery('a.flex-prev').attr( "title","Previous" );
				},
			});
		}
	}
	
	jQuery(document).ready(function() {
		cur_slider = null;
		windowWidth = jQuery(window).width();
		orgin_slider = null;
		if( jQuery('.related_post_slider').length > 0 ){
			orgin_slider = jQuery('.related_post_slider').clone();
			cur_slider = switch_flex_slider(windowWidth,orgin_slider);
		}
		using_mobile = checkIfTouchDevice();
		if( using_mobile == 0 ){
			jQuery(window).bind('resize',function(event) {
				if( jQuery('.related_post_slider').length > 0 ){
					//delete cur_slider; 
					var resize_width = jQuery(window).width();
					if( jQuery.browser.msie && ( parseInt( jQuery.browser.version, 10 ) <= 8 ) ){
					}else{
						cur_slider = switch_flex_slider(resize_width,orgin_slider);
					}
				}
			});
		}else{
			jQuery(window).bind('orientationchange',function(event) {	
				if( jQuery('.related_post_slider').length > 0 ){
					//delete cur_slider; 
					var resize_width = jQuery(window).width();
					if( jQuery.browser.msie && ( parseInt( jQuery.browser.version, 10 ) <= 8 ) ){

					}else{
						cur_slider = switch_flex_slider(resize_width,orgin_slider);
					}
				}
			});
		}											
		
	});	
</script>