<?php
/*
*	Template Name: Archive Template
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
				<div class="col-main span24">
					<div class="main-content" id="main">

						<div class="archive-content entry-content">
							<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ):?>
								<h1 class="heading-title page-title archive-title"><?php the_title();?></h1>
							<?php endif;?>
							
								<div class="gama">		
									<div class='span24'>
										<div class="alpha omega"><?php the_content();?></div>
									</div>				
										<div class="span12">
											<div class="alpha">
												<h4 class="heading-title"><?php _e('The Latest 30 Posts', 'wpdance'); ?></h4>
												<ul class="sitemap-archive">
													<?php query_posts( 'posts_per_page=30' ); ?>
													<?php while ( have_posts() ) { the_post(); ?>
														<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> - <?php the_time('Y.m.d'); ?> - <?php _e( 'Comments', 'wpdance' ); ?> (<?php echo $post->comment_count; ?>)</li>
													<?php } ?>            
												</ul><!-- Latest Posts -->
											</div>
										</div>
										
										<div class="span6">
											<div class="alpha">
												<h4 class="heading-title"><?php _e('Categories', 'wpdance'); ?></h4>
												<ul class='sitemap-archive'>
													<?php wp_list_categories('title_li=&show_count=true'); ?>
												</ul>
											</div>
										</div><!-- Categories -->
										
										<div class="span6">
											<div class="alpha">
												<h4 class="heading-title"><?php _e('Monthly Archives', 'wpdance'); ?></h4>
												<ul class='sitemap-archive'>
													<?php wp_get_archives('type=monthly&show_post_count=true'); ?>
												</ul>
											</div>
										</div><!-- Monthly Archives -->
								</div>		
						</div>
					</div>
				</div>
			</div><!-- #content -->
		</div><!-- #container -->


<?php get_footer(); ?>
