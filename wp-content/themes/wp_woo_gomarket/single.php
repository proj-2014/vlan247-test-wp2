<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 */

get_header(); ?>
		<div class="top-page">
			<?php dimox_breadcrumbs();?>
		</div>
		<div id="container">
			<div id="content" class="container single-blog">
				<div id="left-sidebar" class="span6 hidden-phone">
					<div class="left-sidebar-content alpha omega">
					<?php
						if ( is_active_sidebar( 'blog-widget-area' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'blog-widget-area' ); ?>
							</ul>
					<?php endif; ?>
					</div>
				</div><!-- end left sidebar -->
				
				<div id="main" class="span18">
					<div class="main-content alpha omega">
						<div class="single-content">
							<?php	
								if(have_posts()) : while(have_posts()) : the_post(); 
								global $post,$wd_data;										
								?>
									<div <?php post_class("single-post");?>>
										<?php if($wd_data['wd_top_blog_code'] != 'null') echo stripslashes($wd_data['wd_top_blog_code']);?>
													
										<?php //edit_post_link( __( 'Edit', 'wpdance' ), '<span class="wd-edit-link hidden-phone">', '</span>' ); ?>	
										
										
										
										<div class="post-title">
											<div class="navi-prev"><?php previous_post_link('%link', 'Previous'); ?> </div>
											<h1 class="heading-title"><?php the_title(); ?></h1>
											<div class="navi-next"><?php next_post_link('%link', 'Next'); ?></div>
										</div>
										<div class="post-info-meta">
											<?php if( absint($wd_data['wd_blog_details_time']) == 1 ) : ?>			
												<div class="time">
													<span class="entry-date"><?php echo get_the_date('l,F d, Y') ?></span>
												</div>
											<?php endif; ?>

																																

										
											<?php if( absint($wd_data['wd_blog_details_author']) == 1 ) : ?>	
												<div class="author">	
													<?php _e('Posted by','wpdance'); ?> <?php the_author_posts_link(); ?> 
												</div>
											<?php endif; ?>
											<?php if( absint($wd_data['wd_blog_details_comment']) == 1 ) : ?>
												<span class="comments-count">
													<?php $comments_count = wp_count_comments($post->ID); echo $comments_count->approved;?> comment(s)
												</span>
											<?php endif; ?>
											
											<!--Category List-->
											<?php if( $wd_data['wd_blog_details_categories'] == 1 ) : ?>
												<?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) : // Hide category text when not supported ?>
												<?php
													/* translators: used between list items, there is a space after the comma */
													$categories_list = get_the_category_list( __( ', ', 'wpdance' ) );
														if ( $categories_list ):
													?>
													<div class="categories">
														<span class="cat-links">
															<?php printf( __( '<span class="%1$s heading-title"></span> %2$s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );?>
														</span>
													</div>
													<?php endif; // End if categories ?>
												<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' ) ?>	
												
											<?php endif;?>		
											
											<div class="short-content"><?php the_content(); ?></div>
											<?php wp_link_pages(); ?>
											<div class="tags_social">
												<?php if( absint($wd_data['wd_blog_details_tags']) == 1 ) : ?>
													<?php if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) : // Hide tag text when not supported ?>
													<?php
														/* translators: used between list items, there is a space after the comma */
														$tags_list = get_the_tag_list('',', ','');
														 
														if ( $tags_list ):
														?>
															<div class="tags">
																<span class="tag-title"><?php _e('Tags','wpdance');?></span>
																<span class="tag-links">
																	<?php //_e( '<span class="entry-utility-prep entry-utility-prep-tag-links"></span>'.$tags_list, 'wpdance' );  ?>
																	<?php printf( __( '<span class="%s"></span>: %s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
																	$show_sep = true; ?>
																</span>
															</div>
														<?php endif; // End if $tags_list ?>
													<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'post_tag' ) ?>
												<?php endif; ?>	
												<?php if( absint($wd_data['wd_blog_details_socialsharing']) == 1 ) : ?>
													<div class="share-list">
														<span class="social-label"><?php _e("share this post",'wpdance');?></span>
														<a class="digg" rel="nofollow" target="_blank" href="http://digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('','', false)) ?>" title="Digg"></a>	
														<a class="twitter" title="<?php _e('Twitter','wpdance');?>" href="http://twitter.com/home?status=Share <?php the_permalink(); ?>" target="_blank"></a>
														<a class="stumbleupon" rel="nofollow" target="_blank" href="http://www.stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('','', false)) ?>" title="StumbleUpon"></a>
														<a class="del" rel="nofollow" target="_blank" href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('','', false)) ?>" title="Delicious"></a>
														<a class="reddit" rel="nofollow" target="_blank" href="http://reddit.com/submit?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('','', false)) ?>" title="Reddit"></a>
														<a class="facebook" title="<?php _e('Facebook','wpdance');?>" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&title=<?php echo urlencode(get_the_title()) ?>" target="_blank"></a>
														<!--<a class="pin" title="<?php _e('Pin This','wpdance');?>" target="_blank" data-pin-config="above" href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" data-pin-do="buttonPin" ></a>	-->
														<!--<a class="plus" title="<?php _e('Plus This','wpdance');?>" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>&amp;title=<?php echo urlencode(get_the_title()) ?>"></a>-->
													</div>
												<?php endif;?>
											</div>
											<?php if( absint($wd_data['wd_blog_details_authorbox']) == 1 ) : ?>
												<div id="entry-author-info">
													<div class="author-inner">
														
														<div id="author-description">
															<div id="author-avatar" class="image-style">
																<div class="thumbnail">
																	<?php echo get_avatar( get_the_author_meta( 'user_email' ), 96,get_bloginfo('template_url') . '/images/mycustomgravatar.png' ); ?>
																</div>
															</div><!-- #author-avatar -->		
															<div class="author-desc">		
																<span class="author-name"><?php the_author_posts_link();?></span>
																<?php the_author_meta( 'description' ); ?>
																<span class="view-all-author-posts">
																	<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
																		<?php _e("View all posts by",'wpdance');echo " ";the_author_meta( 'display_name' ); ?>
																	</a>
																</span>
															</div>
														</div><!-- #author-description -->
													</div><!-- #author-inner -->
												</div><!-- #entry-author-info -->
											<?php endif; ?>	
											<?php if( absint($wd_data['wd_blog_details_related']) == 1 ) : ?>
												<?php 
													get_template_part( 'templates/related_posts' );
												?>
											<?php endif;?>
											
											<?php comments_template( '', true );?>	
										</div>	
										
										
										
									
										<?php if($wd_data['wd_bottom_blog_code'] != 'null') echo stripslashes($wd_data['wd_bottom_blog_code']);?>	
									</div>
									
									
									
									
									
								<?php						
								endwhile;
								endif;	
								wp_reset_query();
							?>	
						</div>
					</div>
				</div>
							
					
				
			</div><!-- #content -->
			
		</div><!-- #container -->
<?php get_footer(); ?>