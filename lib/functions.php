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
  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <div class="inside">
    <h3>Insert your text & background color</h3>
    <table class="form-table">
      <tr>
        <th><label for="nht_effect">Effect Type</label></th>
        <td><select name="nht_effect" id="nht_effect">
            <option value="typing" <?php if( get_option('nht_effect') == 'typing'){ echo 'selected="selected"'; } ?>>Typing</option>
            <option value="fade" <?php if( get_option('nht_effect') == 'fade'){ echo 'selected="selected"'; } ?>>Fade</option>
            <option value="slide" <?php if( get_option('nht_effect') == 'slide'){ echo 'selected="selected"'; } ?>>Slide</option>
          </select></td>
      </tr>
      <tr>
        <th><label for="nht_border_radius">Border Radius</label></th>
        <td><input type="text" name="nht_border_radius" value="<?php $nht_border_radius = get_option('nht_border_radius'); if(!empty($nht_border_radius)) {echo $nht_border_radius;} else {echo "15";}?>">
          px;</td>
      </tr>
      <tr>
        <th><label for="nht_label">Label Text</label></th>
        <td><input type="text" name="nht_label" value="<?php $nht_label = get_option('nht_label'); if(!empty($nht_label)) {echo $nht_label;} else {echo "Breaking News:";}?>"></td>
      </tr>
      <tr>
        <th><label for="nht_label_color">Label Text Color</label></th>
        <td><input type="text" name="nht_label_color" id="scrollbar_color" value="<?php $nht_label_color = get_option('nht_label_color'); if(!empty($nht_label_color)) {echo $nht_label_color;} else {echo "#FFF";}?>" class="color-picker nht_label_color" /></td>
      </tr>
      <tr>
        <th><label for="nht_bg_color">Background Color <span>*</span></label></th>
        <td><input type="text" name="nht_bg_color" id="scrollbar_color" value="<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "#2d81c8";}?>" class="color-picker nht_bg_color" /></td>
      </tr>
      <tr>
        <th><label for="nht_text_color">Text Color <span>*</span></label></th>
        <td><input type="text" name="nht_text_color" id="scrollbar_color" value="<?php $nht_text_color = get_option('nht_text_color'); if(!empty($nht_text_color)) {echo $nht_text_color;} else {echo "#FFF";}?>" class="color-picker nht_text_color" /></td>
      </tr>
      <tr>
        <th><label for="nht_hover_color">Text Hover Color</label></th>
        <td><input type="text" name="nht_hover_color" id="scrollbar_color" value="<?php $nht_hover_color = get_option('nht_hover_color'); if(!empty($nht_hover_color)) {echo $nht_hover_color;} else {echo "#FFF";}?>" class="color-picker nht_hover_color" /></td>
      </tr>
    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="nht_effect, nht_border_radius, nht_label,  nht_label_color, nht_bg_color, nht_text_color, nht_hover_color" />
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" class="button button-primary" />
    </p>
  </form>
</div>
</div>
<div id="nhtRight">
  <div class="nhtWidget">
    <h3>About the Plugin</h3>
    <p><a href="http://www.e2soft.com/" target="_blank"><strong>News Headline Ticker</strong></a> is a wordpress plugin to show your recent news headline as typing style slider on your website!</p>
    <p>You can also make my day by submitting a positive review on <a href="https://wordpress.org/support/view/plugin-reviews/news-headline-ticker" target="_blank"><strong>WordPress.org!</strong> <img src="<?php bloginfo('url' ); echo"/wp-content/plugins/news-headline-ticker/img/review.png"; ?>" alt="review" class="review"/></a></p>
    <p> With your help I can make Simple Fields even better! $5, $10, $50 – any amount is fine! :)
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="82C6LTLMFLUFW">
      <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
      <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
    </form>
    </p>
    <div class="clrFix"></div>
  </div>
  <div class="nhtWidget">
    <h3>vCard Responsive WordPress Theme at low price</h3>
    <a href="http://www.e2soft.com/themes/product/umbra-vcard-responsive-wordpress-theme/" title="vCard Responsive WordPress Theme" target="_blank"><img src="<?php bloginfo('url' ); echo"/wp-content/plugins/news-headline-ticker/img/umbra_screenshot.png"; ?>" alt="vCard Responsive WordPress Theme" /></a>
    <div class="clrFix"></div>
  </div>
  <div class="nhtWidget">
    <div class="clrFix"></div>
    <h3>About the Author</h3>
    <p>My name is <strong>S M Hasibul Islam</strong> and I am a <strong>Web Developer, Expert WordPress Developer</strong>. I am regularly available for interesting freelance projects. If you ever need my help, do not hesitate to get in touch.<br />
      <strong>Email:</strong> info@e2soft.com<br />
      <strong>Website:</strong> <a href="http://www.e2soft.com/">www.e2soft.com</a></p>
    <h3><a href="http://www.e2soft.com/blog/news-headline-ticker/">Help & Support Article</a></h3>
    <?php
	$urls_total = array("http://www.e2soft.com/", "http://www.e2soft.com/web-design/","http://www.e2soft.com/web-development/","http://www.e2soft.com/web-hosting/","http://www.e2soft.com/portfolio");
	$random_urls = array_rand($urls_total);
  ?>
    <iframe class="border_1" src="<?php echo $urls_total["$random_urls"]; ?>"></iframe>
    <div class="clrFix"></div>
  </div>
</div>
<div class="clrFix"></div>
<?php		
	echo '</div>';
}