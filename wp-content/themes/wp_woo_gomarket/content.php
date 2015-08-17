<?php
/**
 * The template for displaying Content.
 *
 * @package WordPress
 * @subpackage Gomarket
 * @since WD_Responsive
 */
?>
<?php
	global $wd_data;
?>
<ul class="list-posts">
	<?php	
	$count=0;
	if(have_posts()) : while(have_posts()) : the_post(); global $post;$count++;global $wp_query;
			if($count == 1) 
				$_sub_class =  " first";
			if($count == $wp_query->post_count) 
				$_sub_class = " last" 
		?>
		<li <?php post_class("home-features-item".$_sub_class);?>>
			
			
			<div class="post-info-thumbnail">
				<?php if( $wd_data['wd_blog_thumbnail'] == 1 ) : ?>
					<div class="thumbnail ">
						<?php 
							$video_url = get_post_meta( $post->ID, THEME_SLUG.'url_video', true);
							if( $video_url!= ''){
								echo get_embbed_video( $video_url, 280, 246 );
							}
							else{
								?>
								<div class="image">
									<a class="thumb-image" href="<?php the_permalink() ; ?>">
									<?php 
										if ( has_post_thumbnail($post->ID) ) {
										//$image = wp_get_attachment_image_src(get_post_thumbnail_id(),'thumbnail-blog', true);
											the_post_thumbnail('blog_thumb',array('class' => 'thumbnail-blog'));
											//the_post_thumbnail('blog_thumb',array('class' => 'thumbnail-effect-2')); 
										} else { ?>
											<img alt="<?php the_title(); ?>" title="<?php the_title();?>" src="<?php echo get_template_directory_uri(); ?>/images/no-image-blog.gif"/>
									<?php	}										
									?>										
									</a>
									
								</div>
								<?php
							}
						?>	
					</div>
					
				<?php endif;?>
			</div><!-- end post info -->
			
			<div class="post-info-content">
			<div class="post-title">
		
					<a class="post-title heading-title" href="<?php the_permalink() ; ?>"><h2 class="heading-title"><?php the_title(); ?></h2></a>
					<?php edit_post_link( __( 'Edit', 'wpdance' ), '<span class="wd-edit-link hidden-phone">', '</span>' ); ?>
					
					
			</div>
			<?php if( $wd_data['wd_blog_time'] == 1 ) : ?>	
				<div class="time">
					<span class="entry-date"><?php echo get_the_date('M d, Y') ?></span><br/>
				</div>
			<?php endif;?>
			
			<?php if( $wd_data['wd_blog_excerpt'] == 1 ) : ?>
				<p class="short-content"><?php /*the_content();*/the_excerpt_max_words(160,$post); ?></p>
			<?php endif; ?>
			
			<?php if( $wd_data['wd_blog_author'] == 1 ) : ?>
				<div class="author">
					Post by <?php the_author_posts_link(); ?> 
				</div>
			<?php endif;?>
			
			<?php if( $wd_data['wd_blog_comment_number'] == 1 ) : ?>	
				<span class="comments-count"> <?php //if( $archive_page_config['show_comment_count_phone'] != 1 ) echo " hidden-phone";?>
					<?php $comments_count = wp_count_comments($post->ID);  echo $comments_count->approved; ?> comment(s)
				</span>
			<?php endif;?>
			
			<?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) && $wd_data['wd_blog_categories'] == 1 ) : // Hide category text when not supported ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'wpdance' ) );
					if ( $categories_list ):
				?>
				<span class="cat-links">
					<?php printf( __( '<span class="%1$s">Categories: </span> %2$s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );?>
				</span>
				<?php endif; // End if categories ?>
			<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' ) ?>
			
			
			
				
			
			<?php wp_link_pages(); ?>

								
			
			<?php if( $wd_data['wd_blog_readmore'] == 1 ) : ?>
				<a title="Readmore" class="read-more"  href="<?php the_permalink() ; ?>"><span><?php _e('Read more','wpdance'); ?></span></a>
			<?php endif;?>
				
			</div><!-- end post ... -->
		</li>
	<?php						
	endwhile;
	else : echo "<div class=\"alpha omega\"><div class=\"alert alert-error alpha omega\">Sorry. There are no posts to display</div></div>";
	endif;	
	?>	
</ul>