<?php 
if(!function_exists ('theme_formatter')){
	function theme_formatter($content) {
		$new_content = '';
		$pattern_full = "/<pre class='code'>(.*?)<\/pre>/ims";
		$content = preg_replace($pattern_full, '<pre class="code">'.str_replace(array('<p>','</p>','&lt;br /&gt;','&lt;p&gt;','&lt;/p&gt;'),'',wptexturize(wpautop('$1'))).'</pre>',$content);
		$content = str_replace(array('&lt;br /&gt;'),'',$content);
		return $content;
	}
}
add_filter('the_content', 'theme_formatter', 30);

global $theme_code_token;
$theme_code_token = md5(uniqid(rand()));
$theme_code_matches = array();
function theme_code_before_filter($content) {
	return preg_replace_callback("/(.?)\[(pre|code)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\\2\])?(.?)/s", "theme_code_before_filter_callback", $content);
}

function theme_code_before_filter_callback(&$match) {
	global $theme_code_token, $theme_code_matches;
	$i = count($theme_code_matches);
	
	$theme_code_matches[$i] = $match;
	
	return "\n\n<p>" . $theme_code_token . sprintf("%03d", $i) . "</p>\n\n";
}

function theme_code_after_filter($content) {
	global $theme_code_token;
	
	$content = preg_replace_callback("/<p>\s*" . $theme_code_token . "(\d{3})\s*<\/p>/si", "theme_code_after_filter_callback", $content);
	//$content = preg_replace('/<\/?p>/','', $content);
	//$content = preg_replace('/<p>\[(.*)<\/p>/','[$1',$content);
	$content = preg_replace('/<p><pre (.*)<\/p>/','',$content);
	preg_match_all('/<pre class="code">(.*)<\/pre>/ims',$content,$matches);
	foreach($matches as $match){
		if(!empty($match)){
			$content = str_replace($match[0],str_replace(array('&lt;br /&gt;','&lt;p&gt;','&lt;/p&gt;'),'',$match[0]),$content);
		}
	}
	
	//$content = str_replace(array('&lt;p&gt;','&lt;/p&gt;'),'',$content);
	return $content;
	
	
}
function theme_code_after_filter_callback($match) {
	global $theme_code_matches;
	$i = intval($match[1]);
	$content = $theme_code_matches[$i];
	$content[5]=trim($content[5]);
	
	if (version_compare(PHP_VERSION, '5.2.3') >= 0) {
		$output = htmlspecialchars($content[5], ENT_NOQUOTES, get_bloginfo('charset'), false);
	} else {
		$specialChars = array('&' => '&amp;', '<' => '&lt;', '>' => '&gt;');
		
		$output = strtr(htmlspecialchars_decode($content[5]), $specialChars);
	}
	return '<' . $content[2] . ' class="'. $content[2] .'">' . $output . '</' . $content[2] . '>';
}

add_filter('the_content', 'theme_code_before_filter', 0);
add_filter('the_content', 'theme_code_after_filter', 99);

function mySearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', 'post');
}
return $query;
}

//add_filter('pre_get_posts','mySearchFilter');
?>