<?php get_header(); ?>
	<div id="content">
	<?php tie_breadcrumbs() ?>
		<?php $category_id = get_query_var('cat') ; ?>
		<div class="page-head">
			<h2 class="page-title">
				<?php printf( __( 'Category Archives: %s', 'tie' ), '<span>' . single_cat_title( '', false ) . '</span>' );	?>
			</h2>
			<?php if( tie_get_option( 'category_rss' ) ): ?>
			<a class="rss-cat-icon ttip" title="<?php _e( 'Feed Subscription', 'tie' ); ?>" href="<?php echo get_category_feed_link($category_id) ?>"><?php _e( 'Feed Subscription', 'tie' ); ?><</a>
			<?php endif; ?>
			<div class="stripe-line"></div>

			<?php
			if( tie_get_option( 'category_desc' ) ):	
				$category_description = category_description();
				if ( ! empty( $category_description ) )
				echo '<div class="clear"></div><div class="archive-meta">' . $category_description . '</div>';
			endif;
			?>
		</div>
		
		<div id="grid">
		<?php get_template_part( 'loop', 'category' );	?>
		</div><!-- .grid /-->
		<?php if ($wp_query->max_num_pages > 1) tie_pagenavi(); ?>
		
	</div> <!-- .content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>