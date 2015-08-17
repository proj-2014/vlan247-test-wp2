<?php
if(!function_exists ('wd_product_search_form')){
	function wd_product_search_form(){
		//do_action( 'get_product_search_form'  );
		//$search_form_template = locate_template( 'product-searchform.php' );
		//if ( '' != $search_form_template  ) {
       //     require $search_form_template;
       //     return;
        //}
		$args = array(
			'number'     => '',
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => true,
			'include'    => array()
		);
		$product_categories = get_terms( 'product_cat', $args ); 
		//print_r($product_categories);
		$categories_show = '<option value="">'.__('All Categories','wpdance').'</option>';
		$check = '';
		if(is_search()){
			if(isset($_GET['term']) && $_GET['term']!=''){
				$check = $_GET['term'];	
			}
		}
		$checked = '';
		foreach($product_categories as $category){
			if(isset($category->slug)){
				if(trim($category->slug) == trim($check)){
					$checked = 'selected="selected"';
				}
				$categories_show  .= '<option '.$checked.' value="'.$category->slug.'">'.$category->name.'</option>';
				$checked = '';
			}
		}
		$form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		 <select class="wd_search_product" name="term">'.$categories_show.'</select>
		 <div class="wd_search_form">
			 <label class="screen-reader-text" for="s">' . __( 'Search for:', 'wpdance' ) . '</label>
			 <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search for products', 'wpdance' ) . '" />
			 <input type="submit" title="Search" id="searchsubmit" value="'. esc_attr__( 'Search', 'wpdance' ) .'" />
			 <input type="hidden" name="post_type" value="product" />
			 <input type="hidden" name="taxonomy" value="product_cat" />
		 </div>
		</form>';
		//$form .='<script type="text/javascript">
		//		jQuery("select.wd_search_product").select2();
		//</script>';
		echo $form;
		//remove_filter( 'get_product_search_form');
	//	if ( $echo  ){
	//		echo apply_filters( 'get_product_search_form', $form );
	//	} else {
	//		return apply_filters( 'get_product_search_form', $form );
	//	}	 
	}
	//add_filter( 'get_search_form', 'wd_product_search_form' );
}	
?>