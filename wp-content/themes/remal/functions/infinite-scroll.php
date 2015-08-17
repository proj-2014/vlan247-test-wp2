<?php
/*
Infinite Scroll
Automatically loads the next page of posts into the bottom of the initial page.
Version: 2.6.2
Beaver6813, dirkhaim, Paul Irish, benbalter, Glenn Nelson
License GPL3
License URI http://www.gnu.org/licenses/gpl-3.0.html
*/

/*  Copyright 2008-2012 Beaver6813, dirkhaim, Paul Irish, Benjamin J. Balter, Glenn Nelson
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  @copyright 2008-2012
 *  @license GPL v3
 *  @version 2.6.2
 *  @package Infinite Scroll
 *  @author Beaver6813, dirkhaim, Paul Irish, Benjamin J. Balter, Glenn Nelson
 */


class tie_tie_infinite_scroll {

	static $instance;
	public $options;
	public $slug      = 'tie-infinite-scroll'; //plugin slug, generally base filename and in url on wordpress.org
	public $slug_     = 'tie_infinite_scroll'; //slug with underscores (PHP/JS safe)
	public $prefix    = 'tie_infinite_scroll_'; //prefix to append to all options, API calls, etc. w/ trailing underscore
	public $file      = null;

	/**
	 * Construct the primary class and auto-load all child classes
	 */
	function __construct() {
		self::$instance = &$this;
		$this->file    = __FILE__;


		//js
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_js' ) );
		add_action( 'wp_footer', array( &$this, 'footer' ), 100 ); //low priority will load after i18n and script loads

		//404 fix
		add_action( 'wp', array( &$this, 'paged_404_fix' ) );
	}



	/**
	 * Enqueue front-end JS and pass options to json_encoded array
	 */
	function enqueue_js() {
		if (!$this->shouldLoadJavascript()) {
			return;
		}
		wp_enqueue_script( $this->slug , get_template_directory_uri() . '/js/jquery.infinitescroll.js', array( 'jquery' ) , true , true );  

		$defaults = array(
			'loading' => array(
				'msgText'         => '',
				'finishedMsg'     => '<em>' . __('No additional posts.' , 'tie') . '</em>',
				'img'             =>  get_template_directory_uri() . '/images/small-loader.gif'
			),
			'nextSelector'    => '#tie-next-page a',
			'navSelector'     => '.pagination',
			'itemSelector'    => '.item-list',
			'contentSelector' => '#grid',
			'behavior' => 'masonry',
		);
		
		$options = apply_filters( $this->prefix . 'js_options', $defaults );
		wp_localize_script($this->slug, $this->slug_, json_encode($options));


	}

	/**
	 * Load footer template to pass options array to JS
	 */
	function footer() {
		if (!$this->shouldLoadJavascript()) {
			return;
		}
?>
<script type="text/javascript">
// Because the `wp_localize_script` method makes everything a string
tie_infinite_scroll = jQuery.parseJSON(tie_infinite_scroll);

jQuery( tie_infinite_scroll.contentSelector ).infinitescroll( tie_infinite_scroll, function(newElements, data, url) { eval(tie_infinite_scroll.callback); });
</script>
<?php
}




	/**
	 * If we go beyond the last page and request a page that doesn't exist,
	 * force WordPress to return a 404.
	 * See http://core.trac.wordpress.org/ticket/15770
	 */
	function paged_404_fix( ) {
		global $wp_query;

		if ( is_404() || !is_paged() || 0 != count( $wp_query->posts ) )
			return;

		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();

	}

	/**
	 * Determines if the jQuery plugin and corresponding options should
	 * be output onto the page.
	 *
	 * @return bool
	 */
	function shouldLoadJavascript() {
		// Don't need to load the plugin on single pages
		if (is_singular()) {
			return false;
		}

		return true;
	}
}


$tie_infinite_scroll = new tie_tie_infinite_scroll();
