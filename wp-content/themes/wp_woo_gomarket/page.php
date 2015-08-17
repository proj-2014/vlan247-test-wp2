<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 */	
get_header(); 
?>
		<div class="slideshow-wrapper main-slideshow <?php echo strcmp($page_datas['main_slider_layout'],'wide') == 0 ? "wd_wide" : "wd_box"; ?>">
			<div class="slideshow-sub-wrapper <?php echo strcmp($page_datas['main_slider_layout'],'wide') == 0 ? "wide-wrapper" : "span24"; ?>">
				<?php
					global $page_datas,$post;
					show_page_slider();
					$_layout_config = explode("-",$page_datas['page_column']);
					$_left_sidebar = (int)$_layout_config[0];
					$_right_sidebar = (int)$_layout_config[2];
					$_main_class = ( $_left_sidebar + $_right_sidebar ) == 2 ? "span12" : ( ( $_left_sidebar + $_right_sidebar ) == 1 ? "span18" : "span24" );		
					$column_layout = '';
					if($_left_sidebar == 1 && $_right_sidebar == 1){
						$column_layout = ' has_sidebar left_right_lo';
					}elseif($_left_sidebar == 1) {
						$column_layout = ' has_sidebar left_lo';
					}elseif($_right_sidebar == 1) {
						$column_layout = ' has_sidebar right_lo';
					} else {
						$column_layout = ' no_sidebar fullwidth_lo';
					}
				
				?>
			</div>
		</div>
		
		<?php if( isset($page_datas['hide_breadcrumb']) && absint($page_datas['hide_breadcrumb']) == 0 ) :?>
			<div class="top-page">
				<?php dimox_breadcrumbs(); ?>
			</div>
		<?php endif;?>
		
		<?php 
			$main_content_layout = '';
			$banner_layout = "";
			if(strcmp($page_datas['page_layout'],'wide') == 0){
				if($page_datas['main_content_layout'] == '0') { 
					$main_content_layout = "wd_box"; 
				} else { 
					$main_content_layout = 'wd_'.$page_datas['main_content_layout']; 
				}
				if($page_datas['banner_layout'] == '0') {  
					$banner_layout = "wd_box";
				} else {  
					$banner_layout = 'wd_'.$page_datas['banner_layout'];
				}
			}
		?>
		<?php if(isset($page_datas['hide_banner']) && absint($page_datas['hide_banner']) == 0  ):?>
			<div class="banner-page <?php echo $banner_layout;?>">
				<div class="container">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'banner-widget-area' ); ?>
					</ul>
				</div>
			</div>
		<?php endif;?>
		
		<div id="container" class="page-template default-template <?php echo $main_content_layout; ?>">
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
					
				</div>	
				
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>