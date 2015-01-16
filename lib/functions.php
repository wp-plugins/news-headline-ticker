<?php
function registernhtPage() {
	add_submenu_page( 'edit.php?post_type=headline', 'News Headline Settings', 'Ticker Settings', 'manage_options', 'news-headline', 'newsHeadLineFunction' ); 
}
add_action('admin_menu', 'registernhtPage');

function newsHeadLineFunction() {
	
	echo '<div class="newsWrap">';
		echo '<h1>Headline Newsticker Configurations</h1>';
?>
   <div id="nhtLeft">  
    <form method="post" action="options.php"><?php wp_nonce_field('update-options'); ?>
		        
		<div class="inside">
        <h3>Insert your text & background color</h3>
			<table class="form-table">
				<tr>
					<th><label for="nht_border_radius">Border Radius</label></th>
					<td><input type="text" name="nht_border_radius" value="<?php $nht_border_radius = get_option('nht_border_radius'); if(!empty($nht_border_radius)) {echo $nht_border_radius;} else {echo "15";}?>">px;</td>
				</tr>
				<tr>
					<th><label for="nht_bg_color">Background Color <span>*</span></label></th>
					<td>#<input type="text" name="nht_bg_color" value="<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "DEE77C";}?>"></td>
				</tr>
				<tr>
					<th><label for="nht_text_color">Text Color <span>*</span></label></th>
					<td>#<input type="text" name="nht_text_color" value="<?php $nht_text_color = get_option('nht_text_color'); if(!empty($nht_text_color)) {echo $nht_text_color;} else {echo "CCC";}?>"></td>
				</tr>
				<tr>
					<th><label for="nht_hover_color">Text Hover Color</label></th>
					<td>#<input type="text" name="nht_hover_color" value="<?php $nht_hover_color = get_option('nht_hover_color'); if(!empty($nht_hover_color)) {echo $nht_hover_color;} else {echo "1F527B";}?>"></td>
				</tr>
				<tr>
					<th><label for="nht_label_color">Label Text Color</label></th>
					<td>#<input type="text" name="nht_label_color" value="<?php $nht_label_color = get_option('nht_label_color'); if(!empty($nht_label_color)) {echo $nht_label_color;} else {echo "FFF";}?>"></td>
				</tr>
		</table>
	
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="nht_border_radius, nht_bg_color, nht_text_color, nht_label_name, nht_hover_color, nht_label_color" />
		<p class="submit"><input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" /></p>
	</form>      
  </div>
  </div>
 
  
  <div id="nhtRight">
  
  <div class="nhtWidget">
  		<h3>Need Responsive Web Design?</h3>
  		<a href="http://www.e2soft.com" title="Web Design Company" target="_blank"><img src="<?php bloginfo('url' ); echo"/wp-content/plugins/news-headline-ticker/img/responsive-web-design.png"; ?>" alt="Web Design Company" /></a>
  </div>
<div class="clrFix"></div>
 
  <div class="nhtWidget">
  <?php
	$urls_total = array("http://www.e2soft.com/web-design/","http://www.e2soft.com/web-development/","http://www.e2soft.com/web-hosting/","http://www.e2soft.com/portfolio");
	$random_urls = array_rand($urls_total);
  ?>
	<iframe class="border_1" src="<?php echo $urls_total["$random_urls"]; ?>" width="320" height="300">
	</iframe>
	</div>
	
  </div>
<div class="clrFix"></div>
<?php		
	echo '</div>';
}