<?php

/*-----------------------------------------------------------------------------------*/
# Get Theme Options
/*-----------------------------------------------------------------------------------*/
function tie_get_option( $name ) {
	$get_options = get_option( 'tie_options' );
	
	if( !empty( $get_options[$name] ))
		return $get_options[$name];
		
	return false ;
}

/*-----------------------------------------------------------------------------------*/
# Setup Theme
/*-----------------------------------------------------------------------------------*/
add_action( 'after_setup_theme', 'tie_setup' );
function tie_setup() {
	global $default_data;
	
	add_theme_support( 'automatic-feed-links' );
	load_theme_textdomain( 'tie', get_template_directory() . '/languages' );

	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'tie' )
	) );
	
}

/*-----------------------------------------------------------------------------------*/
# Post Formats
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) )
	add_theme_support( 'post-formats', array('aside', 'gallery', 'image', 'link', 'quote', 'video', 'audio' ) );
	
/*-----------------------------------------------------------------------------------*/
# Post Thumbinals
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) ) 
	add_theme_support( 'post-thumbnails' );

if ( function_exists( 'add_image_size' ) ){
	add_image_size( 'tie-small', 55, 55, true );
	add_image_size( 'tie-w1', 190, 0 , false );
	add_image_size( 'tie-w2', 280, 0 , false );
	add_image_size( 'tie-w3', 445, 0 , false );
	add_image_size( 'tie-post', 600, 0 , false );
}

/*-----------------------------------------------------------------------------------*/
# Get Post Width  
/*-----------------------------------------------------------------------------------*/
function tie_post_width(){
	global $tie_blog;

	if( is_singular() || tie_get_option( 'on_home' ) != 'grid' || isset( $tie_blog ))
		return $size = 'post';
	
	$width = tie_get_option( 'post_width' );
	if( !empty( $width ) )
		return $size = 'w'.$width ;
	else return $size = 'w3';
	
}


/*-----------------------------------------------------------------------------------*/
# Get Post Video  
/*-----------------------------------------------------------------------------------*/
function tie_vedio(){
	global $post, $tie_blog;
	
	$get_meta = get_post_custom($post->ID);
		
	if( !empty( $get_meta["tie_video_self_url"][0] )){
		echo do_shortcode('[video src="'.$get_meta["tie_video_self_url"][0].'"][/video]');
	}
	elseif( isset( $get_meta["tie_video_url"][0] ) && !empty( $get_meta["tie_video_url"][0] ) ){
		$video_url = $get_meta["tie_video_url"][0];
		$video_link = @parse_url($video_url);
		if ( $video_link['host'] == 'www.youtube.com' || $video_link['host']  == 'youtube.com' ) {
			parse_str( @parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
			$video =  $my_array_of_vars['v'] ;
			$video_code ='<iframe width="600" height="325" src="http://www.youtube.com/embed/'.$video.'?rel=0&wmode=opaque" frameborder="0" allowfullscreen></iframe>';
		}
		elseif( $video_link['host'] == 'www.vimeo.com' || $video_link['host']  == 'vimeo.com' ){
			$video = (int) substr(@parse_url($video_url, PHP_URL_PATH), 1);
			$video_code='<iframe width="600" height="325" src="http://player.vimeo.com/video/'.$video.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		}
		elseif( $video_link['host'] == 'www.youtu.be' || $video_link['host']  == 'youtu.be' ){
			$video = substr(@parse_url($video_url, PHP_URL_PATH), 1);
			$video_code ='<iframe width="600" height="325" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
		}elseif( $video_link['host'] == 'www.dailymotion.com' || $video_link['host']  == 'dailymotion.com' ){
			$video = substr(@parse_url($video_url, PHP_URL_PATH), 7);
			$video_id = strtok($video, '_');
			$video_code='<iframe frameborder="0" width="600" height="325" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe>';
		}
	}
	elseif( isset( $get_meta["tie_embed_code"][0] ) ){
		$embed_code = $get_meta["tie_embed_code"][0];
		$video_code = htmlspecialchars_decode( $embed_code);
	}
	if( isset($video_code) ) echo $video_code;
}


/*-----------------------------------------------------------------------------------*/
# Get Post Audio  
/*-----------------------------------------------------------------------------------*/
function tie_audio(){
	global $post;
	$get_meta = get_post_custom($post->ID);
	if ( version_compare( $GLOBALS['wp_version'], '3.6-alpha', '<' ) ){
	?>
  <script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery("#jquery_jplayer_<?php echo $post->ID ?>").jPlayer({
        ready: function () {
          jQuery(this).jPlayer("setMedia", {
            mp3: "<?php echo $get_meta["tie_audio_mp3"][0] ?>",
            m4a: "<?php echo $get_meta["tie_audio_m4a"][0] ?>",
            oga: "<?php echo $get_meta["tie_audio_oga"][0] ?>"
          });
        },
		cssSelectorAncestor: "#jp_container_<?php echo $post->ID ?>",
        supplied: "m4a, oga, mp3"
      });
    });
  </script>
<div id="jquery_jplayer_<?php echo $post->ID ?>" class="jp-jplayer"></div>
	<div id="jp_container_<?php echo $post->ID ?>" class="jp-audio">
	<?php	if ( has_post_thumbnail($post->ID) ){ ?>
		<div class="post-media">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>">
			<?php tie_thumb( tie_post_width() ); ?>
			</a>
		</div>
	<?php } ?>
		<div class="jp-type-single">
			<div class="jp-gui jp-interface">
	  			<div class="jp-progress">
				  <div class="jp-seek-bar">
					<div class="jp-play-bar"><span></span></div>
				  </div>
				</div>
				
				<a href="javascript:;" class="jp-play" tabindex="1">play</a>
				<a href="javascript:;" class="jp-pause" tabindex="1">pause</a>
				
				<div class="jp-volume-bar">
				  <div class="jp-volume-bar-value"><span class="handle"></span></div>
				</div>
		
				<a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a>
				<a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a>
			</div>

			<div class="jp-no-solution">
				<span>Update Required</span>
				To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
			</div>
		</div>
</div>
  <?php
	}
	else {
		if ( has_post_thumbnail($post->ID) ){ ?>
		<div class="post-media">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>">
			<?php tie_thumb( tie_post_width() ); ?>
			</a>
		</div>
		<?php }
		echo do_shortcode('[audio ogg="'.$get_meta["tie_audio_oga"][0].'" mp3="'.$get_meta["tie_audio_mp3"][0].'" m4a="'.$get_meta["tie_audio_m4a"][0].'"][/audio]');
	}
}



/*-----------------------------------------------------------------------------------*/
# Get Post Gallery  
/*-----------------------------------------------------------------------------------*/
function tie_gallery(){
	global $post, $tie_blog;
	
	if( is_singular() || tie_get_option( 'on_home' ) != 'grid' || isset( $tie_blog )){
		$size  = 'post' ;
	}else{
		if( tie_post_width() == 'w2' ){
			$size  = 'w2' ;
		}
		elseif( tie_post_width() == 'w3' ){
			$size  = 'w3' ;
		}
		else {
			$size  = 'w1' ;
		}
	}
		
	$speed = 7000 ;
	$time = 600;
	$effect = 'animation: "fade",';
	
		
	?>
	<?php 
		$custom = get_post_custom($post->ID);
		$slider = unserialize( $custom["post_gallery"][0] );
		$number = count($slider);
		$imgaes = array();
		if( $slider ){
		foreach( $slider as $slide ){
			$image = wp_get_attachment_image_src( $slide['id'] , 'tie-'.$size  );
			$imgaes[] = array( $image[0] , $image[1] ,  $image[2]);
		}?>
		
	<div class="flexslider">
		<ul class="slides">
		<?php foreach( $imgaes as $image ): ?>			  
		<li><img src="<?php echo $image[0] ?>" alt="" /></li>
		<?php endforeach; ?>
		</ul>
	</div>
		<?php }?>
	<script>
	jQuery(document).ready(function() {
		jQuery('#content').imagesLoaded(function(){

		  jQuery('.flexslider').flexslider({
			<?php echo $effect  ?>
			slideshowSpeed: <?php echo $speed ?>,
			animationSpeed: <?php echo $time ?>,
			randomize: false,
			controlNav: false,
			pauseOnHover: true,
			smoothHeight : true,
			start: function(slider) {
				var slide_control_width = 100/<?php echo $number; ?>;
				jQuery('.flex-control-nav li').css('width', slide_control_width+'%');
				jQuery('#main-content #grid').isotope();
			},
			after: function() {
				jQuery('#main-content #grid').isotope();
			}
		  });
		  
		});
	});
	</script>
<?php 
}

/*-----------------------------------------------------------------------------------*/
# Load More posts  
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_nopriv_tie_load_more', 'tie_home_load');
add_action('wp_ajax_tie_load_more', 'tie_home_load');
function tie_home_load(){
	$exc_home_cats = tie_get_option( 'exc_home_cats' );
	if( $_REQUEST["isHome"] == 1  && $exc_home_cats ){
		foreach($exc_home_cats as $cat)	$string .= '-' .$cat.",";
		$string = substr($string, 0, -1);
		if( !empty( $string ))
		$exc_home = '&cat='.$string;
	}
 	query_posts($_REQUEST['query'].$exc_home.'&post_status=publish&paged='.$_REQUEST['page']);
	get_template_part( 'loop', 'index' );
    die;
}


/*-----------------------------------------------------------------------------------*/
# For Empty Widgets Titles 
/*-----------------------------------------------------------------------------------*/
function tie_widget_title($title){
	if( empty( $title ) )
		return ' ';
	else return $title;
}
add_filter('widget_title', 'tie_widget_title');


/*-----------------------------------------------------------------------------------*/
# Get post commentes 
/*-----------------------------------------------------------------------------------*/
function tie_get_commentes(){
	global $post ;

	if( tie_get_option( 'show_comments' ) ){
	$number = tie_get_option( 'num_comments' ) ;
	if( empty($number) ) $number =  3 ;

	$comments = get_comments('post_id='.$post->ID.'&status=approve&number='.$number);
	foreach ($comments as $comment) { echo $comment->ID; ?>
	<li>
		<?php echo get_avatar( $comment, 30 ); ?>
		<a href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>">
		<?php echo strip_tags($comment->comment_author); ?>: <?php echo wp_html_excerpt( $comment->comment_content, 40 ); ?>... </a>
	</li>
<?php }
	}
}

/*-----------------------------------------------------------------------------------*/
# If the menu doesn't exist
/*-----------------------------------------------------------------------------------*/
function tie_nav_fallback(){
	echo '<div class="menu-alert">'.__( 'You can use WP menu builder to build menus' , 'tie' ).'</div>';
}


/*-----------------------------------------------------------------------------------*/
# Mobile Menus
/*-----------------------------------------------------------------------------------*/
function tie_alternate_menu( $args = array() ) {			
	$output = '';
		
	@extract($args);						
			
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {	
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );						
		$menu_items = wp_get_nav_menu_items( $menu->term_id );				
		$output = "<div class='menu-mob'><select id='". $id. "'>";
		$output .= "<option value='' selected='selected'>" . __('Go to...', 'tie') . "</option>";
		foreach ( (array) $menu_items as $key => $menu_item ) {
		    $title = $menu_item->title;
		    $url = $menu_item->url;
				    
		    if ( $menu_item->menu_item_parent ) {
				$title = ' - ' . $title;
		    }
		    $output .= "<option value='" . $url . "'>" . $title . '</option>';
		}
		$output .= '</select></div>';
	}
	return $output;							
}
	
	
/*-----------------------------------------------------------------------------------*/
# Custom Dashboard login page logo
/*-----------------------------------------------------------------------------------*/
function tie_login_logo(){
	if( tie_get_option('dashboard_logo') )
    echo '<style  type="text/css"> h1 a {  background-image:url('.tie_get_option('dashboard_logo').')  !important; } </style>';  
}  
add_action('login_head',  'tie_login_logo'); 


/*-----------------------------------------------------------------------------------*/
# Custom Gravatar
/*-----------------------------------------------------------------------------------*/
function tie_custom_gravatar ($avatar) {
	$tie_gravatar = tie_get_option( 'gravatar' );
	if($tie_gravatar){
		$custom_avatar = tie_get_option( 'gravatar' );
		$avatar[$custom_avatar] = "Custom Gravatar";
	}
	return $avatar;
}
add_filter( 'avatar_defaults', 'tie_custom_gravatar' ); 


/*-----------------------------------------------------------------------------------*/
# Custom Favicon
/*-----------------------------------------------------------------------------------*/
function tie_favicon() {
	$default_favicon = get_template_directory_uri()."/favicon.ico";
	$custom_favicon = tie_get_option('favicon');
	$favicon = (empty($custom_favicon)) ? $default_favicon : $custom_favicon;
	echo '<link rel="shortcut icon" href="'.$favicon.'" title="Favicon" />';
}
add_action('wp_head', 'tie_favicon');



/*-----------------------------------------------------------------------------------*/
# Exclude pages From Search
/*-----------------------------------------------------------------------------------*/
function tie_search_filter($query) {
	if( $query->is_search ){
		if ( tie_get_option( 'search_exclude_pages' ) && !is_admin() ){
			$query->set('post_type', 'post');
		}
		if ( tie_get_option( 'search_cats' ))
			$query->set( 'cat', tie_get_option( 'search_cats' ) && !is_admin() );
	}
	return $query;
}
add_filter('pre_get_posts','tie_search_filter');



/*-----------------------------------------------------------------------------------*/
#Author Box
/*-----------------------------------------------------------------------------------*/
function tie_author_box($avatar = true , $social = true ){
	if( $avatar ) : ?>
	<div class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'MFW_author_bio_avatar_size', 60 ) ); ?>
	</div><!-- #author-avatar -->
	<?php endif; ?>
		<div class="author-description">
			<?php the_author_meta( 'description' ); ?>
		</div><!-- #author-description -->
	<?php  if( $social ) :	?>	
		<div class="author-social">
			<?php if ( get_the_author_meta( 'url' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'url' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( " 's site", 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_site.png" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'twitter' ) ) : ?>
			<a class="ttip" href="http://twitter.com/<?php the_author_meta( 'twitter' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Twitter', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_twitter.png" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'facebook' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'facebook' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Facebook', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_facebook.png" alt="" /></a>
			<?php endif ?>
			<?php if ( get_the_author_meta( 'google' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'google' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Google+', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_google.png" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'linkedin' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'linkedin' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> <?php _e( '  on Linkedin', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_linkedin.png" alt="" /></a>
			<?php endif ?>				
			<?php if ( get_the_author_meta( 'flickr' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'flickr' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Flickr', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_flickr.png" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'youtube' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'youtube' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on YouTube', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_youtube.png" alt="" /></a>
			<?php endif ?>
			<?php if ( get_the_author_meta( 'pinterest' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'pinterest' ); ?>" title="<?php the_author_meta( 'display_name' ); ?><?php _e( '  on Pinterest', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_pinterest.png" alt="" /></a>
			<?php endif ?>

		</div>
	<?php endif; ?>
	<div class="clear"></div>
	<?php
}


/*-----------------------------------------------------------------------------------*/
# Social 
/*-----------------------------------------------------------------------------------*/
function tie_get_social($newtab='yes', $icon_size='32', $tooltip='ttip'){
	$social = tie_get_option('social');
	@extract($social);
		
	if ($newtab == 'yes') $newtab = "target=\"_blank\"";
	else $newtab = '';
		
	$icons_path =  get_template_directory_uri().'/images/socialicons';
		
		?>
		<div class="social-icons">
		<?php
		// RSS
		if ( !tie_get_option('rss_icon') ){
			if ( tie_get_option('rss_url') != '' && tie_get_option('rss_url') != ' ' ) $rss = tie_get_option('rss_url') ;
			else $rss = get_bloginfo('rss2_url'); 
				?><a class="<?php echo $tooltip; ?>" title="Rss" href="<?php echo $rss ; ?>" <?php echo $newtab; ?>><img src="<?php echo $icons_path; ?>/rss<?php echo '_'.$icon_size; ?>.png" alt="RSS"  /></a><?php 
		}
		
		// Google+
		if ( !empty( $google_plus ) && $google_plus != '' && $google_plus != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Google+" href="<?php echo $google_plus; ?>" <?php echo $newtab; ?>><img src="<?php echo $icons_path; ?>/google_plus<?php echo '_'.$icon_size; ?>.png" alt="Google+"  /></a><?php 
		}
		// Facebook
		if ( !empty( $facebook ) && $facebook != '' && $facebook != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Facebook" href="<?php echo $facebook; ?>" <?php echo $newtab; ?>><img src="<?php echo $icons_path; ?>/facebook<?php echo '_'.$icon_size; ?>.png" alt="Facebook"  /></a><?php 
		}
		// Twitter
		if ( !empty( $twitter ) && $twitter != '' && $twitter != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="Twitter" href="<?php echo $twitter; ?>" <?php echo $newtab; ?>><img src="<?php echo $icons_path; ?>/twitter<?php echo '_'.$icon_size; ?>.png" alt="Twitter"  /></a><?php
		}		
		// Pinterest
		if ( !empty( $Pinterest ) && $Pinterest != '' && $Pinterest != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="Pinterest" href="<?php echo $Pinterest; ?>" <?php echo $newtab; ?>><img src="<?php echo $icons_path; ?>/pinterest<?php echo '_'.$icon_size; ?>.png" alt="MySpace"  /></a><?php
		}
		// MySpace
		if ( !empty( $myspace ) && $myspace != '' && $myspace != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="MySpace" href="<?php echo $myspace; ?>" <?php echo $newtab; ?>><img src="<?php echo $icons_path; ?>/myspace<?php echo '_'.$icon_size; ?>.png" alt="MySpace"  /></a><?php
		}
		// dribbble
		if ( !empty( $dribbble ) && $dribbble != '' && $dribbble != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Dribbble" href="<?php echo $dribbble; ?>" <?php echo $newtab; ?>><img src="<?php echo $icons_path; ?>/dribbble<?php echo '_'.$icon_size; ?>.png" alt="dribbble"  /></a><?php
		}
		// LinkedIN
		if ( !empty( $linkedin ) && $linkedin != '' && $linkedin != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="LinkedIn" href="<?php echo $linkedin; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/linkedin<?php echo '_'.$icon_size; ?>.png" alt="LinkedIn"  /></a><?php
		}
		// Flickr
		if ( !empty( $flickr ) && $flickr != '' && $flickr != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="Flickr" href="<?php echo $flickr; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/flickr<?php echo '_'.$icon_size; ?>.png" alt="Flickr"  /></a><?php
		}
		// Picasa
		if ( !empty( $picasa ) && $picasa != '' && $picasa != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Picasa" href="<?php echo $picasa; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/picasa<?php echo '_'.$icon_size; ?>.png" alt="Picasa"  /></a><?php
		}
		// YouTube
		if ( !empty( $youtube ) && $youtube != '' && $youtube != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Youtube" href="<?php echo $youtube; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/youtube<?php echo '_'.$icon_size; ?>.png" alt="YouTube"  /></a><?php
		}
		// Skype
		if ( !empty( $skype ) && $skype != '' && $skype != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Skype" href="<?php echo $skype; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/skype<?php echo '_'.$icon_size; ?>.png" alt="Skype"  /></a><?php
		}
		// Digg
		if ( !empty( $digg ) && $digg != '' && $digg != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Digg" href="<?php echo $digg; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/digg<?php echo '_'.$icon_size; ?>.png" alt="Digg"  /></a><?php
		}
		// Reddit 
		if ( !empty( $reddit ) && $reddit != '' && $reddit != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Reddit" href="<?php echo $reddit; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/reddit<?php echo '_'.$icon_size; ?>.png" alt="Reddit"  /></a><?php
		}
		// stumbleuponUpon 
		if ( !empty( $stumbleupon ) && $stumbleupon != '' && $stumbleupon != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="StumbleUpon" href="<?php echo $stumbleupon; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/stumbleupon<?php echo '_'.$icon_size; ?>.png" alt="stumbleuponUpon"  /></a><?php
		}
		// Tumblr 
		if ( !empty( $tumblr ) && $tumblr != '' && $tumblr != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Tumblr" href="<?php echo $tumblr; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/tumblr<?php echo '_'.$icon_size; ?>.png" alt="Tumblr"  /></a><?php
		}
		// Vimeo
		if ( !empty( $vimeo ) && $vimeo != '' && $vimeo != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Vimeo" href="<?php echo $vimeo; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/vimeo<?php echo '_'.$icon_size; ?>.png" alt="Vimeo"  /></a><?php
		}
		// Blogger
		if ( !empty( $blogger ) && $blogger != '' && $blogger != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Blogger" href="<?php echo $blogger; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/blogger<?php echo '_'.$icon_size; ?>.png" alt="Blogger"  /></a><?php
		}
		// Wordpress
		if ( !empty( $wordpress ) && $wordpress != '' && $wordpress != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="WordPress" href="<?php echo $wordpress; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/wordpress<?php echo '_'.$icon_size; ?>.png" alt="Wordpress"  /></a><?php
		}
		// Last.fm
		if ( !empty( $lastfm ) && $lastfm != '' && $lastfm != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Last.fm" href="<?php echo $lastfm; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/lastfm<?php echo '_'.$icon_size; ?>.png" alt="Last.fm"  /></a><?php
		}
		// sharethis
		if ( !empty( $sharethis ) && $sharethis != '' && $sharethis != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="ShareThis" href="<?php echo $sharethis; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/sharethis<?php echo '_'.$icon_size; ?>.png" alt="sharethis"  /></a><?php
		}
		// behance
		if ( !empty( $behance ) && $behance != '' && $behance != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Behance" href="<?php echo $behance; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/behance<?php echo '_'.$icon_size; ?>.png" alt="behance"  /></a><?php
		}
		// instagram
		if ( !empty( $instagram ) && $instagram != '' && $instagram != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="instagram" href="<?php echo $instagram; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/instagram<?php echo '_'.$icon_size; ?>.png" alt="instagram"  /></a><?php
		}
		// paypal
		if ( !empty( $paypal ) && $paypal != '' && $paypal != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="paypal" href="<?php echo $paypal; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/paypal<?php echo '_'.$icon_size; ?>.png" alt="paypal"  /></a><?php
		}
		// spotify
		if ( !empty( $spotify ) && $spotify != '' && $spotify != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="spotify" href="<?php echo $spotify; ?>" <?php echo $newtab; ?>><img  src="<?php echo $icons_path; ?>/spotify<?php echo '_'.$icon_size; ?>.png" alt="spotify"  /></a><?php
		}
 ?>
	</div>
<?php
}


/*-----------------------------------------------------------------------------------*/
# Change The Default WordPress Excerpt Length
/*-----------------------------------------------------------------------------------*/
function tie_excerpt_length( $length ) {

	if( tie_get_option( 'exc_length' ) )
		return tie_get_option( 'exc_length' );
	else return 55;
	
}
add_filter( 'excerpt_length', 'tie_excerpt_length', 999 );


/*-----------------------------------------------------------------------------------*/
# Read More Functions
/*-----------------------------------------------------------------------------------*/
function tie_remove_excerpt( $more ) {
	return ' ...';
}
add_filter('excerpt_more', 'tie_remove_excerpt');



/*-----------------------------------------------------------------------------------*/
# Page Navigation
/*-----------------------------------------------------------------------------------*/
function tie_pagenavi(){
	global $tie_blog , $wp_query , $paged;
		if( tie_get_option( 'grid_pagination' ) == 'button' && tie_get_option( 'on_home' ) == 'grid' && empty($tie_blog) ){
			if( $wp_query->max_num_pages > $paged ){?>
			<a id="load-more" href="#"><?php _e( 'Load More Posts' , 'tie' ) ?></a>
	<?php	}
		}else{
	?>
		<div class="pagination">
			<?php tie_get_pagenavi(); ?>
		</div>
	<?php	
	}
}


/*-----------------------------------------------------------------------------------*/
# Tie Excerpt
/*-----------------------------------------------------------------------------------*/
function tie_excerpt($text, $chars = 120) {
	$text = $text." ";
	$text = mb_substr( $text , 0 , $chars , 'UTF-8');
	$text = $text."...";
	return $text;
}


/*-----------------------------------------------------------------------------------*/
# Queue Comments reply js
/*-----------------------------------------------------------------------------------*/
function comments_queue_js(){
if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
  wp_enqueue_script( 'comment-reply' );
}
add_action('wp_print_scripts', 'comments_queue_js');


/*-----------------------------------------------------------------------------------*/
# Remove recent comments_ style
/*-----------------------------------------------------------------------------------*/
function tie_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'tie_remove_recent_comments_style' );


/*-----------------------------------------------------------------------------------*/
# Get the thumbnail
/*-----------------------------------------------------------------------------------*/
function get_large_thumb(){
	global $post ;
	if ( has_post_thumbnail($post->ID) ){
		$image_id = get_post_thumbnail_id($post->ID);  
		$image_url = wp_get_attachment_image_src($image_id,'full');  
		return $image_url = $image_url[0];
	}
}


/*-----------------------------------------------------------------------------------*/
# tie Thumb
/*-----------------------------------------------------------------------------------*/
function tie_thumb( $size = 'small' ){
	global $post;
	$image_id = get_post_thumbnail_id($post->ID);  
	$image_url = wp_get_attachment_image($image_id, 'tie-'.$size , false, array( 'alt'   => get_the_title() ,'title' =>  ''  ));  
	echo $image_url;
}


/*-----------------------------------------------------------------------------------*/
# tie Thumb SRC
/*----------------------------------------------------------------------------------*/

function tie_thumb_src( $size = 'small' ){
	global $post;

	$image_id = get_post_thumbnail_id($post->ID);  
	$image_url = wp_get_attachment_image_src( $image_id, 'tie-'.$size );  
	return $image_url[0];
	
}

/*-----------------------------------------------------------------------------------*/
# tie Thumb
/*-----------------------------------------------------------------------------------*/
function tie_slider_img_src( $image_id , $size = 'w1' ){
	global $post;
	
	$image_url = wp_get_attachment_image_src($image_id, 'tie-'.$size  );  
	return $image_url[0];
	
}

/*-----------------------------------------------------------------------------------*/
# Add user's social accounts
/*-----------------------------------------------------------------------------------*/
add_action( 'show_user_profile', 'tie_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'tie_show_extra_profile_fields' );
function tie_show_extra_profile_fields( $user ) { ?>
	<h3><?php _e( 'Social Networking', 'tie' ) ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="google">Google + URL</label></th>
			<td>
				<input type="text" name="google" id="google" value="<?php echo esc_attr( get_the_author_meta( 'google', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="twitter">Twitter Username</label></th>
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="facebook">FaceBook URL</label></th>
			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="linkedin">linkedIn URL</label></th>
			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="flickr">Flickr URL</label></th>
			<td>
				<input type="text" name="flickr" id="flickr" value="<?php echo esc_attr( get_the_author_meta( 'flickr', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="youtube">YouTube URL</label></th>
			<td>
				<input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="pinterest">Pinterest URL</label></th>
			<td>
				<input type="text" name="pinterest" id="pinterest" value="<?php echo esc_attr( get_the_author_meta( 'pinterest', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>

	</table>
<?php }

## Save user's social accounts
add_action( 'personal_options_update', 'tie_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'tie_save_extra_profile_fields' );
function tie_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;
	update_user_meta( $user_id, 'google', $_POST['google'] );
	update_user_meta( $user_id, 'pinterest', $_POST['pinterest'] );
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
	update_user_meta( $user_id, 'flickr', $_POST['flickr'] );
	update_user_meta( $user_id, 'youtube', $_POST['youtube'] );
}


/*-----------------------------------------------------------------------------------*/
# Get templates 
/*-----------------------------------------------------------------------------------*/
function tie_include($template){
	include ( get_template_directory() . '/includes/'.$template.'.php' );
}


/*-----------------------------------------------------------------------------------*/
# Get Feeds 
/*-----------------------------------------------------------------------------------*/

function tie_get_feeds( $feed , $number = 10 ){
	include_once(ABSPATH . WPINC . '/feed.php');

	$rss = @fetch_feed( $feed );
	if (!is_wp_error( $rss ) ){
		$maxitems = $rss->get_item_quantity($number); 
		$rss_items = $rss->get_items(0, $maxitems); 
	}
	if ($maxitems == 0) {
		$out = "<ul><li>". __( 'No items.', 'tie' )."</li></ul>";
	}else{
		$out = "<ul>";
		
		foreach ( $rss_items as $item ) : 
			$out .= '<li><a href="'. esc_url( $item->get_permalink() ) .'" title="'.  __( "Posted ", "tie" ).$item->get_date("j F Y | g:i a").'">'. esc_html( $item->get_title() ) .'</a></li>';
		endforeach;
		$out .='</ul>';
	}
	
	return $out;
}


/*-----------------------------------------------------------------------------------*/
# Tie Wp Footer
/*-----------------------------------------------------------------------------------*/
add_action('wp_footer', 'tie_wp_footer');
function tie_wp_footer() { 
	if ( tie_get_option('footer_code')) echo htmlspecialchars_decode( stripslashes(tie_get_option('footer_code') )); 
} 


/*-----------------------------------------------------------------------------------*/
# News In Picture
/*-----------------------------------------------------------------------------------*/
function tie_last_news_pic($order , $numberOfPosts = 12 , $cats = 1 ){
	global $post;
	$orig_post = $post;
	
	if( $order == 'random')
		$lastPosts = get_posts(	$args = array('numberposts' => $numberOfPosts, 'orderby' => 'rand', 'category' => $cats ));
	else
		$lastPosts = get_posts(	$args = array('numberposts' => $numberOfPosts, 'category' => $cats ));
		get_posts('category='.$cats.'&numberposts='.$numberOfPosts);
	
		foreach($lastPosts as $post): setup_postdata($post); ?>

		<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>
			<div class="post-thumbnail">
				<a class="ttip" title="<?php the_title();?>" href="<?php the_permalink(); ?>" ><?php tie_thumb(); ?></a>
			</div><!-- post-thumbnail /-->
		<?php endif; ?>

	<?php endforeach;
	$post = $orig_post;
	//wp_reset_query();	
}


/*-----------------------------------------------------------------------------------*/
# Get Most Racent posts
/*-----------------------------------------------------------------------------------*/
function tie_last_posts($numberOfPosts = 5 , $thumb = true){
	global $post;
	$orig_post = $post;
	
	$lastPosts = get_posts('numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li>
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php tie_thumb(); ?></a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
	<span class="date"><?php the_time(get_option('date_format')); ?></span>
</li>
<?php endforeach; 
	$post = $orig_post;
	//wp_reset_query();
}


/*-----------------------------------------------------------------------------------*/
# Get Most Racent posts from Category
/*-----------------------------------------------------------------------------------*/
function tie_last_posts_cat($numberOfPosts = 5 , $thumb = true , $cats = 1){
	global $post;
	$orig_post = $post;

	$lastPosts = get_posts('category='.$cats.'&numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li>
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php tie_thumb(); ?></a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
	<span class="date"><?php the_time(get_option('date_format'));  ?></span>
</li>
<?php endforeach;
	$post = $orig_post;
	//wp_reset_query();
}


/*-----------------------------------------------------------------------------------*/
# Get Random posts 
/*-----------------------------------------------------------------------------------*/
function tie_random_posts($numberOfPosts = 5 , $thumb = true){
	global $post;
	$orig_post = $post;

	$lastPosts = get_posts('orderby=rand&numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li>
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php tie_thumb(); ?></a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<span class="date"><?php the_time(get_option('date_format')); ?></span>
</li>
<?php endforeach;
	$post = $orig_post;
	//wp_reset_query();
}


/*-----------------------------------------------------------------------------------*/
# Get Popular posts 
/*-----------------------------------------------------------------------------------*/
function tie_popular_posts($pop_posts = 5 , $thumb = true){

	global $post;
	$orig_post = $post;
	$i = 0;
	$cat_query3 = new WP_Query(array('posts_per_page' => $pop_posts, 'orderby' => 'comment_count' , 'post_status' => 'publish'));
	while ( $cat_query3->have_posts() ) : $cat_query3->the_post(); $i++; ?>
<li>
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php tie_thumb(); ?></a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<span class="date"><?php the_time(get_option('date_format'));  ?></span>
</li>
<?php
	if( $i == $pop_posts ) break;
	endwhile;
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
# Get Most commented posts 
/*-----------------------------------------------------------------------------------*/
function tie_most_commented($comment_posts = 5 , $avatar_size = 50){
$comments = get_comments('status=approve&number='.$comment_posts);
foreach ($comments as $comment) { echo $comment->ID; ?>
	<li>
		<div class="post-thumbnail">
			<?php echo get_avatar( $comment, $avatar_size ); ?>
		</div>
		<a href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>">
		<?php echo strip_tags($comment->comment_author); ?>: <?php echo wp_html_excerpt( $comment->comment_content, 60 ); ?>... </a>
	</li>
<?php } 
}


/*-----------------------------------------------------------------------------------*/
# Get Social Counter
/*-----------------------------------------------------------------------------------*/
function tie_remote_get( $url ) {
	$request = wp_remote_retrieve_body( wp_remote_get( $url , array( 'timeout' => 18 , 'sslverify' => false ) ) );
	return $request;
}

function tie_followers_count() {
	$twitter_username 		= tie_get_option('twitter_username');
	$twitter['page_url'] = 'http://www.twitter.com/'.$twitter_username;
	$twitter['followers_count'] = get_transient('twitter_count');
	if( empty( $twitter['followers_count']) ){
		try {

			$consumerKey 			= tie_get_option('twitter_consumer_key');
			$consumerSecret			= tie_get_option('twitter_consumer_secret');

			$token = get_option('tie_TwitterToken');
		 
			// getting new auth bearer only if we don't have one
			if(!$token) {
				// preparing credentials
				$credentials = $consumerKey . ':' . $consumerSecret;
				$toSend = base64_encode($credentials);
		 
				// http post arguments
				$args = array(
					'method' => 'POST',
					'httpversion' => '1.1',
					'blocking' => true,
					'headers' => array(
						'Authorization' => 'Basic ' . $toSend,
						'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
					),
					'body' => array( 'grant_type' => 'client_credentials' )
				);
		 
				add_filter('https_ssl_verify', '__return_false');
				$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);
		 
				$keys = json_decode(wp_remote_retrieve_body($response));
		 
				if($keys) {
					// saving token to wp_options table
					update_option('tie_TwitterToken', $keys->access_token);
					$token = $keys->access_token;
				}
			}
			
			// we have bearer token wether we obtained it from API or from options
			$args = array(
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => array(
					'Authorization' => "Bearer $token"
				)
			);
		 
			add_filter('https_ssl_verify', '__return_false');
			$api_url = "https://api.twitter.com/1.1/users/show.json?screen_name=$twitter_username";
			$response = wp_remote_get($api_url, $args);
		 
			if (!is_wp_error($response)) {
				$followers = json_decode(wp_remote_retrieve_body($response));
				$twitter['followers_count'] = $followers->followers_count;
			} 
			
		} catch (Exception $e) {
			$twitter['followers_count'] = 0;
		}
		if( !empty( $twitter['followers_count'] ) ){
			set_transient( 'twitter_count' , $twitter['followers_count'] , 1200);
			if( get_option( 'followers_count') != $twitter['followers_count'] ) 
				update_option( 'followers_count' , $twitter['followers_count'] );
		}
			
		if( $twitter['followers_count'] == 0 && get_option( 'followers_count') )
			$twitter['followers_count'] = get_option( 'followers_count');
				
		elseif( $twitter['followers_count'] == 0 && !get_option( 'followers_count') )
			$twitter['followers_count'] = 0;
	}
	return $twitter;
}


function tie_facebook_fans( $page_link ){
	$face_link = @parse_url($page_link);

	if( $face_link['host'] == 'www.facebook.com' || $face_link['host']  == 'facebook.com' ){
		$fans = get_transient('fans_count');
		if( empty( $fans ) ){
			try {
				$page_name = substr(@parse_url($page_link, PHP_URL_PATH), 1);
				$data = @json_decode(tie_remote_get("http://graph.facebook.com/".$page_name));
				$fans = $data->likes;
			} catch (Exception $e) {
				$fans = 0;
			}
				
			if( !empty($fans) ){
				set_transient( 'fans_count' , $fans , 1200);
				if ( get_option( 'fans_count') != $fans )
					update_option( 'fans_count' , $fans );
			}
				
			if( $fans == 0 && get_option( 'fans_count') )
				$fans = get_option( 'fans_count');
					
			elseif( $fans == 0 && !get_option( 'fans_count') )
				$fans = 0;
		}	
		return $fans;
	}
}


function tie_youtube_subs( $channel_link ){
	$youtube_link = @parse_url($channel_link);

	if( $youtube_link['host'] == 'www.youtube.com' || $youtube_link['host']  == 'youtube.com' ){
		$subs = get_transient('youtube_count');
		if( empty( $subs ) ){
			try {
				if (strpos( strtolower($channel_link) , "channel") === false)
					$youtube_name = substr(@parse_url($channel_link, PHP_URL_PATH), 6);
				else
					$youtube_name = substr(@parse_url($channel_link, PHP_URL_PATH), 9);

				$json = @tie_remote_get("http://gdata.youtube.com/feeds/api/users/".$youtube_name."?alt=json");
				$data = json_decode($json, true); 
				$subs = $data['entry']['yt$statistics']['subscriberCount']; 
			} catch (Exception $e) {
				$subs = 0;
			}
			
			if( !empty($subs) ){
				set_transient( 'youtube_count' , $subs , 1200);
				if( get_option( 'youtube_count') != $subs )
					update_option( 'youtube_count' , $subs );
			}
				
			if( $subs == 0 && get_option( 'youtube_count') )
				$subs = get_option( 'youtube_count');
					
			elseif( $subs == 0 && !get_option( 'youtube_count') )
				$subs = 0;
		}
		return $subs;
	}
}

function tie_vimeo_count( $page_link ) {
	$vimeo_link = @parse_url($page_link);

	if( $vimeo_link['host'] == 'www.vimeo.com' || $vimeo_link['host']  == 'vimeo.com' ){
		$vimeo = get_transient('vimeo_count');
		if( empty( $vimeo ) ){
			try {
				$page_name = substr(@parse_url($page_link, PHP_URL_PATH), 10);
				@$data = @json_decode(tie_remote_get( 'http://vimeo.com/api/v2/channel/' . $page_name  .'/info.json'));
			
				$vimeo = $data->total_subscribers;
			} catch (Exception $e) {
				$vimeo = 0;
			}

			if( !empty($vimeo) ){
				set_transient( 'vimeo_count' , $vimeo , 1200);
				if( get_option( 'vimeo_count') != $vimeo )
					update_option( 'vimeo_count' , $vimeo );
			}
				
			if( $vimeo == 0 && get_option( 'vimeo_count') )
				$vimeo = get_option( 'vimeo_count');
					
			elseif( $vimeo == 0 && !get_option( 'vimeo_count') )
				$vimeo = 0;
		}
		return $vimeo;
	}

}

function tie_dribbble_count( $page_link ) {
	$dribbble_link = @parse_url($page_link);

	if( $dribbble_link['host'] == 'www.dribbble.com' || $dribbble_link['host']  == 'dribbble.com' ){
		$dribbble = get_transient('dribbble_count');
		if( empty( $dribbble ) ){
			try {
				$page_name = substr(@parse_url($page_link, PHP_URL_PATH), 1);
				@$data = @json_decode(tie_remote_get( 'http://api.dribbble.com/' . $page_name));
			
				$dribbble = $data->followers_count;
			} catch (Exception $e) {
				$dribbble = 0;
			}

			if( !empty($dribbble) ){
				set_transient( 'dribbble_count' , $dribbble , 1200);
				if( get_option( 'dribbble_count') != $dribbble )
					update_option( 'dribbble_count' , $dribbble );
			}
				
			if( $dribbble == 0 && get_option( 'dribbble_count') )
				$dribbble = get_option( 'dribbble_count');
					
			elseif( $dribbble == 0 && !get_option( 'dribbble_count') )
				$dribbble = 0;
		}
		return $dribbble;
	}

}


/*-----------------------------------------------------------------------------------*/
# Google Map Function
/*-----------------------------------------------------------------------------------*/
function tie_google_maps($src , $width = 610 , $height = 440) {
	return '<div class="google-map"><iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&amp;output=embed"></iframe></div>';
}


/*-----------------------------------------------------------------------------------*/
# Login Form
/*-----------------------------------------------------------------------------------*/
function tie_login_form( $login_only  = 0 ) {
	global $user_ID, $user_identity, $user_level;
	
	if ( $user_ID ) : ?>
		<?php if( empty( $login_only ) ): ?>
		<div id="user-login">
			<p class="welcome-text"><?php _e( 'Welcome' , 'tie' ) ?> <strong><?php echo $user_identity ?></strong> .</p>
			<span class="author-avatar"><?php echo get_avatar( $user_ID, $size = '85'); ?></span>
			<ul>
				<li><a href="<?php echo home_url() ?>/wp-admin/"><?php _e( 'Dashboard' , 'tie' ) ?> </a></li>
				<li><a href="<?php echo home_url() ?>/wp-admin/profile.php"><?php _e( 'Your Profile' , 'tie' ) ?> </a></li>
				<li><a href="<?php echo wp_logout_url(); ?>"><?php _e( 'Logout' , 'tie' ) ?> </a></li>
			</ul>
			<div class="author-social">
				<?php if ( get_the_author_meta( 'url' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'url' , $user_ID); ?>" title="<?php echo $user_identity ?> <?php _e( " 's site", 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_site.png" alt="" /></a>
				<?php endif ?>	
				<?php if ( get_the_author_meta( 'twitter' , $user_ID) ) : ?>
				<a class="ttip" href="http://twitter.com/<?php the_author_meta( 'twitter' ); ?>" title="<?php echo $user_identity ?><?php _e( '  on Twitter', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_twitter.png" alt="" /></a>
				<?php endif ?>	
				<?php if ( get_the_author_meta( 'facebook' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'facebook' ); ?>" title="<?php echo $user_identity ?><?php _e( '  on Facebook', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_facebook.png" alt="" /></a>
				<?php endif ?>
				<?php if ( get_the_author_meta( 'google' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'google' ); ?>" title="<?php echo $user_identity ?><?php _e( '  on Google+', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_google.png" alt="" /></a>
				<?php endif ?>	
				<?php if ( get_the_author_meta( 'linkedin' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'linkedin' , $user_ID); ?>" title="<?php echo $user_identity ?><?php _e( '  on Linkedin', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_linkedin.png" alt="" /></a>
				<?php endif ?>				
				<?php if ( get_the_author_meta( 'flickr' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'flickr' , $user_ID); ?>" title="<?php echo $user_identity ?><?php _e( '  on Flickr', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_flickr.png" alt="" /></a>
				<?php endif ?>	
				<?php if ( get_the_author_meta( 'youtube' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'youtube' , $user_ID); ?>" title="<?php echo $user_identity ?><?php _e( '  on YouTube', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_youtube.png" alt="" /></a>
				<?php endif ?>
				<?php if ( get_the_author_meta( 'pinterest' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'pinterest' , $user_ID); ?>" title="<?php echo $user_identity ?><?php _e( '  on Pinterest', 'tie' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_pinterest.png" alt="" /></a>
				<?php endif ?>	
			</div>
			<div class="clear"></div>
		</div>
		<?php endif; ?>
	<?php else: ?>
		<div id="login-form">
			<form action="<?php echo home_url() ?>/wp-login.php" method="post">
				<p id="log-username"><input type="text" name="log" id="log" value="<?php _e( 'Username' , 'tie' ) ?>" onfocus="if (this.value == '<?php _e( 'Username' , 'tie' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Username' , 'tie' ) ?>';}"  size="33" /></p>
				<p id="log-pass"><input type="password" name="pwd" id="pwd" value="<?php _e( 'Password' , 'tie' ) ?>" onfocus="if (this.value == '<?php _e( 'Password' , 'tie' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Password' , 'tie' ) ?>';}" size="33" /></p>
				<input type="submit" name="submit" value="<?php _e( 'Log in' , 'tie' ) ?>" class="login-button" />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> <?php _e( 'Remember Me' , 'tie' ) ?></label>
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
			</form>
			<ul class="login-links">
				<?php if ( get_option('users_can_register') ) : ?><?php echo wp_register() ?><?php endif; ?>
				<li><a href="<?php echo home_url() ?>/wp-login.php?action=lostpassword"><?php _e( 'Lost your password?' , 'tie' ) ?></a></li>
			</ul>
		</div>
	<?php endif;
}


/*-----------------------------------------------------------------------------------*/
# Get Og Image of post
/*-----------------------------------------------------------------------------------*/
function tie_og_image() {
	global $post ;
	
	if ( function_exists("has_post_thumbnail") && has_post_thumbnail() )
		$post_thumb = tie_thumb_src('', 660 ,330) ;
	elseif( get_post_format() == 'video' ){
		$get_meta = get_post_custom($post->ID);
		$video_url = $get_meta["tie_video_url"][0];
		$video_link = @parse_url($video_url);
		if ( $video_link['host'] == 'www.youtube.com' || $video_link['host']  == 'youtube.com' ) {
			parse_str( @parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
			$video =  $my_array_of_vars['v'] ;
			$post_thumb ='http://img.youtube.com/vi/'.$video.'/0.jpg';
		}
		elseif( $video_link['host'] == 'www.vimeo.com' || $video_link['host']  == 'vimeo.com' ){
			$video = (int) substr(@parse_url($video_url, PHP_URL_PATH), 1);
			$url = 'http://vimeo.com/api/v2/video/'.$video.'.php';;
			$contents = @file_get_contents($url);
			$thumb = @unserialize(trim($contents));
			$post_thumb = $thumb[0][thumbnail_large];
		}
	}
	
	if( isset($post_thumb) )
		echo '<meta property="og:image" content="'. $post_thumb .'" />';
}


/*-----------------------------------------------------------------------------------*/
# Add category ID to post class
/*-----------------------------------------------------------------------------------*/
function tie_category_id_class($classes) {
	global $post;
	foreach((get_the_category($post->ID)) as $category)
		$classes[] = 'cat_'.$category->cat_ID;
		return $classes;
}
add_filter('post_class', 'tie_category_id_class');
	
	
/*-----------------------------------------------------------------------------------*/
# HomePage Categories Filter
/*-----------------------------------------------------------------------------------*/
function tie_categories_filter() {
	if( tie_get_option( 'enable_filter' ) && tie_get_option( 'on_home' ) == 'grid' ):
		$exc_home_cats = tie_get_option( 'exc_home_cats' );
		if( $exc_home_cats )
			$comma_cats_separated = @implode(",", $exc_home_cats );
		$categories = get_categories('exclude='.$comma_cats_separated); ?>

<ul id="filters">
  <li class="current all-items"><a href="#" data-filter="*"><?php _e( 'All' , 'tie' ) ?></a></li>
<?php
  foreach($categories as $category) { ?>
    <li><a href="#" data-filter=".cat_<?php echo $category->term_id ?>"><?php echo $category->name ?></a></li>
<?php } ?>
</ul>
<?php
	endif;
}



/*-----------------------------------------------------------------------------------*/
# Add Class to Gallery shortcode for lightbox
/*-----------------------------------------------------------------------------------*/
if( !tie_get_option( 'disable_gallery_shortcode' ) )
add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );

function my_post_gallery( $output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;

    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";
	
	$images_class ='';
	if( isset($attr['link']) && 'file' == $attr['link'] )
		$images_class = "gallery-images";
	
    $output = apply_filters('gallery_style', "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;           }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div id='$selector' class='$images_class gallery galleryid-{$id}'>");

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                $link
            </{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    $output .= "
            <br style='clear: both;' />
        </div>\n";

    return $output;
}
	
	
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
function tie_fix_shortcodes($content){   
    $array = array (
        '[raw]' => '', 
        '[/raw]' => '', 
        '<p>[raw]' => '', 
        '[/raw]</p>' => '', 
        '[/raw]<br />' => '', 
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'tie_fix_shortcodes');


/*-----------------------------------------------------------------------------------*/
# Creates a nicely formatted and more specific title element text for output
/*-----------------------------------------------------------------------------------*/	
function tie_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'tie' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'tie_wp_title', 10, 2 );


/*-----------------------------------------------------------------------------------*/
# Check if the current page is wp-login.php or wp-register.php
/*-----------------------------------------------------------------------------------*/
function tie_is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

/*-----------------------------------------------------------------------------------*/
# Show dropcap and highlight shortcodes in excerpts 
/*-----------------------------------------------------------------------------------*/
function tie_remove_shortcodes($text = '') {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = str_replace("[dropcap]","",$text);
		$text = str_replace("[/dropcap]","",$text);
		$text = str_replace("[highlight]","",$text);
		$text = str_replace("[/highlight]","",$text);

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[&hellip;]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
add_filter( 'get_the_excerpt', 'tie_remove_shortcodes', 1);
	

/*-----------------------------------------------------------------------------------*/
# WP 3.6.0
/*-----------------------------------------------------------------------------------*/
// For old theme versions Video shortcode
function tie_video_fix_shortcodes($content){   
	$v = '/(\[(video)\s?.*?\])(.+?)(\[(\/video)\])/';
	$content = preg_replace( $v , '[embed]$3[/embed]' , $content);
    return $content;
}
add_filter('the_content', 'tie_video_fix_shortcodes', 0);

//To prevent wordpress from importing mediaelement css file
function tie_audio_video_shortcode(){
	if( !is_admin()){
		return false;
	}
}
add_filter('wp_audio_shortcode_library', 'tie_audio_video_shortcode');
add_filter('wp_video_shortcode_library', 'tie_audio_video_shortcode');

//Responsive Videos
function tie_video_width_shortcode( $html ){
	$width1 = 'width: 100%';
	return preg_replace('/width: ([0-9]*)px/',$width1,$html);
}
add_filter('wp_video_shortcode', 'tie_video_width_shortcode');
?>