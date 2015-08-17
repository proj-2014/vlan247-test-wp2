<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post not-found item-list">
		<h2 class="entry-title"><?php _e( 'Not Found', 'tie' ); ?></h2>
		<div class="entry">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'tie' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>

<?php else : ?>
<?php
$count = 0;
$post_width = tie_post_width();
$exc_home_cats = tie_get_option( 'exc_home_cats' );
if( is_home() && $exc_home_cats ) query_posts( array( 'category__not_in' => $exc_home_cats , 'paged' => $paged) ); ?>
<?php while ( have_posts() ) : the_post(); $count++;
	$color = '';
	$get_meta = get_post_custom($post->ID);
	$tie_post_color = $get_meta["tie_post_color"][0];
	if( !empty($tie_post_color)) $color ='custom-color '.$tie_post_color;
?>
	<article <?php post_class('item-list post rtl-item '.$color.' '.$post_width) ?>>
		<div class="post-inner">			
			<?php 
				$format = get_post_format();
				if( false === $format ) { $format = 'standard'; }
			?>
			<?php get_template_part( 'content', $format ); ?>
			<?php if( tie_get_option( 'mini_share' ) ): ?>
			<div class="mini-social">
				<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="mini-facebook" rel="external" target="_blank">Facebook</a>
				<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" class="mini-twitter" rel="external" target="_blank">twitter</a>
				<a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=<?php the_permalink(); ?>&amp;name=<?php the_title(); ?>" class="mini-google" rel="external" target="_blank">google plus</a>
				<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;description=<?php the_title(); ?>&amp;media=<?php echo get_large_thumb() ?>" class="mini-pinterest" rel="external" target="_blank">pinterest</a>
			</div>
			<?php endif; ?>
		</div>
		<?php if( ( tie_get_option( 'show_comments' ) && get_comments_number() ) || tie_get_option( 'show_meta' ) ) : ?> 
		<ul class="post-footer">
		<?php endif; ?>
			<?php if( tie_get_option( 'show_meta' ) ): ?>
			<li>
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'MFW_author_bio_avatar_size', 30 ) ); ?>
				<?php _e( 'by: ' , 'tie' ); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" title="<?php sprintf( esc_attr__( 'View all posts by %s', 'tie' ), get_the_author() ) ?>"><?php echo get_the_author() ?> </a>
				<?php _e( 'in ' , 'tie' ); ?> <?php printf('%1$s', get_the_category_list( ', ' ) ); ?>
				<p><span class="entry-visits"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>"><?php echo tie_views(); ?></a></span>
				<span class="entry-comments"><?php comments_popup_link('0', '1' , '%' ); ?></span>
				<span class="entry-likes"><?php tie_post_likes() ?></span></p>
			</li>
			<?php endif; ?>
			<?php tie_get_commentes() ?>
		<?php if( ( tie_get_option( 'show_comments' ) && get_comments_number() ) || tie_get_option( 'show_meta' ) ) : ?> 
		</ul>
		<?php endif; ?>

	</article><!-- .item-list -->
	<?php 
	if( tie_get_option('banner_within_posts_pos')){
		if( tie_get_option('banner_within_posts_posts') == $count  && !is_paged() ) tie_banner('banner_within_posts' , '<article class="item-list rtl-item ads-posts '.$post_width.'"><div class="post-inner">' , '</div></article>' );
	}else{
		if( tie_get_option('banner_within_posts_posts') == $count ) tie_banner('banner_within_posts' , '<article class="item-list rtl-item ads-posts '.$post_width.'"><div class="post-inner">' , '</div></article>' );
	}
	?>
<?php endwhile;?>
	<?php 
	if( tie_get_option('banner_within_posts_pos')){
		if( tie_get_option('banner_within_posts_posts') > $count  && !is_paged() ) tie_banner('banner_within_posts' , '<article class="item-list rtl-item ads-posts '.$post_width.'"><div class="post-inner">' , '</div></article>' );
	}else{
		if( tie_get_option('banner_within_posts_posts') > $count ) tie_banner('banner_within_posts' , '<article class="item-list rtl-item ads-posts '.$post_width.'"><div class="post-inner">' , '</div></article>' );
	}
	?>
<?php endif; ?>