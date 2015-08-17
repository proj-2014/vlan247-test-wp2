<?php 
	if(!function_exists('features_function')){
		function features_function($atts,$content){
			extract(shortcode_atts(array(
				'slug'				=>		''
				,'id'				=>		0
				,'title'			=>		'yes'
				,'thumbnail'		=>		'yes'
				,'excerpt'			=>		'yes'
				,'content'			=>		'yes'
				
			),$atts));
			
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "features-by-woothemes/woothemes-features.php", $_actived ) ) {
				return;
			}
			
			if( absint($id) > 0 ){
				$_feature = woothemes_get_features( array('id' => $id ));
			}elseif( strlen(trim($slug)) > 0 ){
				$_feature = get_page_by_path($slug, OBJECT, 'feature');
				if( !is_null($_feature) ){
					$_feature = woothemes_get_features( array('id' => $_feature->ID ));
				}else{
					return;
				}
			}else{
				return;
				//invalid input params.
			}
			
			//nothing found
			if( !is_array($_feature) && count($_feature) <= 0 ){
				return;
			}else{
				global $post;
				$_feature = $_feature[0];
				$post = $_feature;
				setup_postdata( $post ); 
			}
			
			//handle features
			
			ob_start();
			?>

				<div id="post-<?php the_ID(); ?>" <?php post_class('shortcode')?>>
					
					<?php if( strcmp(trim($title),'yes') == 0 ) :?>
						<h3 class="feature_title heading_title">
							<a href="<?php echo esc_url($_feature->url);?>"><?php the_title(); ?></a>
						</h3>
					<?php endif;?>
					<div class="feature_content_wrapper">	
					<?php if( strcmp(trim($thumbnail),'yes') == 0 ) :?>
						<div class="feature_thumbnail">
							<?php 
								if( has_post_thumbnail() ) : 
									the_post_thumbnail( 'woo_shortcode', array( 'alt' => esc_attr(get_the_title()), 'title' => esc_attr(get_the_title()) ) );
								endif;
							?>
						</div>
					<?php endif;?>
					
					<?php if( strcmp(trim($excerpt),'yes') == 0 ) :?>
						<div class="feature_excerpt">
							<?php the_excerpt(); ?>
						</div>
					<?php endif;?>
					
					<?php if( strcmp(trim($content),'yes') == 0 ) :?>
						<div class="feature_content ">
							<?php the_content(); ?>
						</div>
					<?php endif;?>
					</div>
				
				</div>

			<?php
			$output = ob_get_contents();
			ob_end_clean();
			rewind_posts();
			wp_reset_query();
			return $output;
		}
	}
	add_shortcode('feature','features_function');
?>