<?php

get_header(); ?>
	<?php if( !is_home() && !is_front_page() ):?>
		<div class="top-page">
			<?php dimox_breadcrumbs(); wp_reset_query();?>
		</div>	
	<?php endif;?>		
		<div id="container" class="page-template archive-page">
			<div id="content" class="container" role="main">
				
				<div id="container-main" class="span18">
					<div class="main-content alpha omega">
						<?php			
							if ( is_category() ) {
								echo "<h1 class=\"page-title heading-title archive-title catagory-title site-title\">";
								printf( __( 'Category : %s', 'wpdance' ), single_cat_title( '', false ) );
								echo "</h1>";
							}
							elseif ( is_search() ) {
								echo '<h1 class="search-title page-title site-title">';
								printf( __( 'Search Results for : %s', 'wpdance' ), get_search_query() );
								echo '</h1>';
						 
							}elseif ( is_day() ) {
								echo '<h1 class="page-title archive-title site-title">';
								printf( __( 'Day : %s', 'wpdance' ), get_the_date() );
								echo '</h1>';
							} elseif ( is_month() ) {
								echo '<h1 class="page-title archive-title  site-title">';
								printf( __( 'Month : %s', 'wpdance' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'wpdance' ) ) ); 
								echo '</h1>';
						 
							} elseif ( is_year() ) {
								echo '<h1 class="page-title archive-title site-title">';
								printf( __( 'Year : %s', 'wpdance' ), get_the_date( _x( 'Y', 'yearly archives date format', 'wpdance' ) ) ); 
								echo '</h1>';
						 
							} elseif ( is_single() && !is_attachment() ) {
								echo '<div class="ads-info">';
								echo '<h1 class="post-title single-title site-title">';
								echo $_echo_out_string;
								echo '</h1>';
								$_home_button_text = get_option(THEME_SLUG.'_home_button_text','Learn More');
								$_home_button_link = get_option(THEME_SLUG.'promotion_button_uri','http://wpdance.com');					
								echo '<a class="read_more" href="'.$_home_button_link.'">'.$_home_button_text.'</a>';
								echo "</div>";
							} elseif ( is_page() ) {
								echo '<h1 class="page-title single-title site-title">';
								the_title();
								echo '</h1>';
							} elseif ( is_attachment() ) {
								echo '<h1 class="attachment-title single-title site-title">';
								the_title();
								echo '</h1>';
							} elseif ( is_tag() ) {
								echo '<h1 class="tag-title archive-title site-title">';
								printf( __( 'Tag : %s', 'wpdance' ), single_tag_title( '', false ) );
								echo '</h1>';
						 
							} elseif ( is_author() ) {	
								global $author;
								$userdata = get_userdata($author);
								echo '<h1 class="author-title archive-title site-title">';
								//printf( __( 'Author : %s', 'wpdance' ), "<span class='vcard'><a class='url fn n' href='" . get_author_posts_url( $userdata->ID  ) . "' title='" . esc_attr( $userdata->display_name ) . "' rel='me'>" . $userdata->display_name . "</a></span>" );
								printf( __( 'Author : %s', 'wpdance' ), $userdata->display_name );
								echo '</h1>';
						 
							} elseif ( is_404() ) {
								echo '<h1 class="title-404 page-title site-title">';
								_e( 'OOPS! FILE NOT FOUND', 'wpdance' );
								echo '</h1>';
							} elseif( is_archive() ){
								echo '<h1 class="attachment-title single-title site-title">';
								_e( 'Archive', 'wpdance' );
								echo '</h1>';
							}
						?>

			
						
						<?php	
							get_template_part( 'content', get_post_format() ); 
						?>
						
						<?php 
							global $wp_query;
							
							if($wp_query->max_num_pages > 1) :
						?>
						<div class="page_navi">
							<div class="nav-content"><div class="wp-pagenavi"><?php ew_pagination();?></div></div>
						</div>
						<?php endif; ?>
						<?php wp_reset_query();?>	
					</div>
				</div><!-- end content -->
				
				
				<div id="right-sidebar" class="span6">
					<div class="right-sidebar-content alpha omega">
					<?php
						if ( is_active_sidebar( 'blog-widget-area' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'blog-widget-area' ); ?>
							</ul>
					<?php endif; ?>
					</div>
				</div><!-- end right sidebar -->		
				<?php wp_reset_query();?>
			
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>