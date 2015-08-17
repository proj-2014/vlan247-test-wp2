<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 */
?>
		<?php do_action( 'wd_before_body_end' ); ?>
		
	</div><!-- #main -->
<?php 
	global $page_datas;
	$footer_layout = '';
	if(strcmp($page_datas['page_layout'],'wide') == 0){
		if($page_datas['footer_layout'] == '0') { 
			$footer_layout = 'class="wd_box"'; 
		} else { 
			$footer_layout = ' class="wd_'.$page_datas['footer_layout'].'"'; 
		}
	}	
?>	
	<div id="footer" <?php echo $footer_layout; ?> role="contentinfo">
	
		<div class="footer-container">
		
			<?php do_action( 'wd_footer_init' ); ?>
			
		</div>
		
	</div><!-- #footer -->
	
	<?php do_action( 'wd_before_footer_end' ); ?>
	
</div><!-- #wrapper -->
<?php global $wd_data; ?>
<?php if($wd_data['wd_before_body_end_code'] != 'null') echo stripslashes(trim($wd_data['wd_before_body_end_code']));?>
<?php if($wd_data['wd_google_analytic_code'] != 'null') echo stripslashes(trim($wd_data['wd_google_analytic_code']));?>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>