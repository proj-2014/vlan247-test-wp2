<?php
/*
*	Template Name: Sitemap Template
*/
get_header(); ?>

<?php global $page_datas;?>
		<div class="slideshow-wrapper main-slideshow <?php echo strcmp($page_datas['page_layout'],'wide') == 0 ? "wide" : "container"; ?>">
			<div class="slideshow-sub-wrapper <?php echo strcmp($page_datas['page_layout'],'wide') == 0 ? "wide-wrapper" : "span24"; ?>">
				<?php show_page_slider(); ?>
			</div>
		</div>
		<div class="top-page">
			<?php if( isset($page_datas['hide_breadcrumb']) && absint($page_datas['hide_breadcrumb']) == 0 ) dimox_breadcrumbs(); ?>
		</div>
		<div id="container" class="page-template default-template">
			<div id="content" class="container" role="main">			
				<div class="col-main span24" id="main">
					<div class="main-content">
							
						
						<div class="sitemap-content entry-content">
							<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ):?>
								<h1 class="heading-title page-title sitemap-title"><?php the_title();?></h1>
							<?php endif;?>
							
							<div class="gama">
								<div class="span24">
									<div class="alpha omega">
										<?php the_content();?>
									</div>
								</div>

										<!--Page-->
										<div class="span6">  
											<div class="alpha">
												<h4 class="heading-title"><?php _e( 'Pages', 'wpdance' ); ?></h4>
												<ul class='sitemap-archive'>
													<?php wp_list_pages( 'depth=0&sort_column=menu_order&title_li=' ); ?>
												</ul>
											</div>
										</div>
						
										<!--Categories-->
										<div class="span6">
											<div class="alpha">
												<h4 class="heading-title"><?php _e('Categories', 'wpdance'); ?></h4>
												<ul class='sitemap-archive'>
													<?php 
													wp_reset_query();	
													wp_list_categories('title_li=&show_count=true'); ?>
												</ul>
											</div>
										</div>
										
										<!--Posts per category-->
										<div class="span12">
											<div class="alpha">
												<h4 class="heading-title"><?php _e( 'Posts per category', 'wpdance' ); ?></h4>
												<?php
										
													$cats = get_categories();
													wp_reset_query();
													foreach ( $cats as $cat ) {
														query_posts( 'cat=' . $cat->cat_ID );
												?>

												<h4><?php echo $cat->cat_name; ?></h4>
												<ul class='sitemap-archive'>
													<?php while ( have_posts() ) { the_post(); ?>
													 <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> - <?php _e( 'Comments', 'wpdance' ); ?> (<?php echo $post->comment_count; ?>)</li>
													 <?php }  ?>
												</ul>
												<?php } ?>
											</div>
										</div>
							</div>			
						</div>
					</div>
				</div>
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>