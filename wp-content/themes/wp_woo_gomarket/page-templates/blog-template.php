<?php
/**
 *	Template Name: Blog Template
 */	
get_header(); ?>

	<?php
		global $page_datas;
		$_layout_config = explode("-",$page_datas['page_column']);
		$_left_sidebar = (int)$_layout_config[0];
		$_right_sidebar = (int)$_layout_config[2];
		$_main_class = ( $_left_sidebar + $_right_sidebar ) == 2 ? "span12" : ( ( $_left_sidebar + $_right_sidebar ) == 1 ? "span18" : "span24" );		
	?>
		<div class="slideshow-wrapper main-slideshow <?php echo strcmp($page_datas['page_layout'],'wide') == 0 ? "wide" : "container"; ?>">
			<div class="slideshow-sub-wrapper <?php echo strcmp($page_datas['page_layout'],'wide') == 0 ? "wide-wrapper" : "span24"; ?>">
				<?php
					show_page_slider();
				?>
			</div>
		</div>
	<?php if( !is_home() && !is_front_page() ):?>
		<div class="top-page">
			<?php if( isset($page_datas['hide_breadcrumb']) && absint($page_datas['hide_breadcrumb']) == 0 ) dimox_breadcrumbs(); ?>
		</div>	
	<?php endif;?>	
		<div id="container" class="page-template blog-template">
			<div id="content" class="container" role="main">
				
				<div id="main">
				
				<?php if( $_left_sidebar ): ?>
						<div id="left-sidebar" class="span6 hidden-phone">
							<div class="left-sidebar-content alpha omega">
								<?php
									if ( is_active_sidebar( $page_datas['left_sidebar'] ) ) : ?>
										<ul class="xoxo">
											<?php dynamic_sidebar( $page_datas['left_sidebar'] ); ?>
										</ul>
								<?php endif; ?>
							</div>
						</div><!-- end left sidebar -->	
					<?php wp_reset_query();?>
				<?php endif;?>					
				
				<div id="container-main" class="<?php echo $_main_class;?>">
					<div class="main-content <?php if($_left_sidebar || $_right_sidebar) echo "alpha omega"?>">				

						<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ):?>
							<h1 class="heading-title page-title blog-title"><?php the_title();?></h1>
						<?php endif;?>
						
						<div class="page-content">
							<div class="content-inner"><?php the_content();?></div>
						</div>
						
						<?php	
							$count=0;
							global $wp_query;
							query_posts('post_type=post'.'&paged='.get_query_var('page'));						
							get_template_part( 'content', get_post_format() ); 
						?>
						
						<div class="page_navi">
							<div class="nav-content"><div class="wp-pagenavi"><?php ew_pagination();?></div></div>
							<?php wp_reset_query();?>
						</div>
	
					</div>
				</div><!-- end content -->
				
				
				<?php if( $_right_sidebar ): ?>
					<div id="right-sidebar" class="span6">
						<div class="right-sidebar-content alpha omega">
						<?php
							if ( is_active_sidebar( $page_datas['right_sidebar'] ) ) : ?>
								<ul class="xoxo">
									<?php dynamic_sidebar( $page_datas['right_sidebar'] ); ?>
								</ul>
						<?php endif; ?>
						</div>
					</div><!-- end right sidebar -->
					<?php wp_reset_query();?>
				<?php endif;?>		
			
				</div><!-- #main -->
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>