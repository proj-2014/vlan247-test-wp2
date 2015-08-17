<?php
/*
*	Template Name: Contact Template
*/
get_header(); ?>
		<div class="top-page">
			<?php if( isset($page_datas['hide_breadcrumb']) && absint($page_datas['hide_breadcrumb']) == 0 ) dimox_breadcrumbs(); ?>
			<div class="wd_map"><?php echo do_shortcode(get_post_meta( get_the_ID(), 'google_map', true )); ?></div>
		</div>
		<div class="slideshow-wrapper main-slideshow <?php echo strcmp($page_datas['page_layout'],'wide') == 0 ? "wide" : "container"; ?>">
			<div class="slideshow-sub-wrapper <?php echo strcmp($page_datas['page_layout'],'wide') == 0 ? "wide-wrapper" : "span24"; ?>">
				<?php
					global $page_datas;
					
					$_layout_config = explode("-",$page_datas['page_column']);
					$_left_sidebar = (int)$_layout_config[0];
					$_right_sidebar = (int)$_layout_config[2];
					$_main_class = ( $_left_sidebar + $_right_sidebar ) == 2 ? "span12" : ( ( $_left_sidebar + $_right_sidebar ) == 1 ? "span18" : "span24" );		
				?>
			</div>
		</div>
		
		<div id="container" class="page-template default-template">
			<div id="content" class="container" role="main">
			
				<div id="main">
				<?php if( $_left_sidebar && !wp_is_mobile() ): ?>
						<div id="left-sidebar" class="span6 hidden-phone">
							<div class="left-sidebar-content omega">
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
						<div class="main-content <?php if($_left_sidebar) echo "alpha";?> <?php if($_right_sidebar) echo "omega"?>">
							
							
							<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ):?>
								<h1 class="heading-title page-title"><?php the_title();?></h1>
							<?php endif;?>
							
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<div class="entry-content-post">
									<?php the_content(); ?>
									<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wpdance' ), 'after' => '</div>' ) ); ?>
								</div><!-- .entry-content -->
								<footer class="entry-meta">
									<?php edit_post_link( __( 'Edit', 'wpdance' ), '<span class="edit-link">', '</span>' ); ?>
								</footer><!-- .entry-meta -->
							</article><!-- #post -->					
						</div>
					</div><!-- end content -->
					
				<?php if( $_right_sidebar ): ?>
					<div id="right-sidebar" class="span6">
						<div class="right-sidebar-content alpha">
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
					
				</div>	
				
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>