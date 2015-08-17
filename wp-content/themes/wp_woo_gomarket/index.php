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
		<div id="main" class="index-page">
			<div id="content" class="container" role="main">
				<div id="left-sidebar" class="span6">
					<div class="left-sidebar-content omega">
					<?php
						if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'primary-widget-area' ); ?>
							</ul>
					<?php endif; ?>
					</div>
				</div><!-- end right sidebar -->
						
				
				<div id="main_content" class="span18">
					<div class="alpha">
						<?php get_template_part( 'content' );?>
					</div>
					<div class="page_navi">
						<div class="nav-content"><div class="wp-pagenavi"><?php ew_pagination();?></div></div>
						<?php wp_reset_query();?>
					</div>
				</div><!-- end content -->
				
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>