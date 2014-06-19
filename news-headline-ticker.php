<?php
/*
Plugin Name: News Headline Ticker
Plugin URI: http://www.e2soft.com/wordpress-plugin/news-headline-ticker
Description: News Headline Ticker is a wordpress plugin to show your recent news headline as typing style slider on your website!  Use this shortcode <strong>[News-Ticker]</strong> in the post/page" where you want to display news head line.
Version: 1.1
Author: S M Hasibul Islam
Author URI: https://www.odesk.com/o/profiles/users/_~~f23680b391834fd1/
Copyright: 2013 S M Hasibul Islam http://www.e2soft.com
License URI: license.txt
*/


#######################	News Headline Ticker ###############################

function tickerPostRegister() {
  $newsLabels = array(
	  'name'               => 'News Headlines',
	  'singular_name'      => 'News Headline',
	  'add_new'            => 'Add New',
	  'add_new_item'       => 'Add New Headline',
	  'edit_item'          => 'Edit Headline',
	  'new_item'           => 'New Headline',
	  'all_items'          => 'All Headlines',
	  'view_item'          => 'View Headline',
	  'search_items'       => 'Search Headlines',
	  'not_found'          => 'No headlines found',
	  'not_found_in_trash' => 'No headlines found in Trash',
	  'parent_item_colon'  => '',
	  'menu_name'          => 'News Headline'
	);
  
	$customPost = array(
	  'labels'             => $newsLabels,
	  'public'             => true,
	  'publicly_queryable' => true,
	  'show_ui'            => true,
	  'show_in_menu'       => true,
	  'query_var'          => true,
	  'rewrite'            => array( 'slug' => 'headline' ),
	  'capability_type'    => 'post',
	  'has_archive'        => true,
	  'hierarchical'       => false,
	  'menu_position'      => null,
	  'supports'           => array( 'title', 'editor', 'thumbnail' )
	);
	register_post_type( 'headline', $customPost );
}
add_action( 'init', 'tickerPostRegister' );

function registerTkrScript()
{
	wp_enqueue_script( 'news', plugins_url('/js/news.js', __FILE__), array('jquery') );
	wp_enqueue_script( 'news-ticker', plugins_url('/js/news-ticker.js', __FILE__), array('jquery') );
	wp_enqueue_style( 'news-style', plugins_url('/css/tkr-style.css', __FILE__) );
}
add_action('wp_enqueue_scripts', 'registerTkrScript');

function nhtAdminStyle()
{
	wp_enqueue_style( 'nht-admin', plugins_url('/css/nht-admin.css', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'nhtAdminStyle' ); 

foreach ( glob( plugin_dir_path( __FILE__ )."css/*.php" ) as $nhtfile )
    include_once $nhtfile;

function headLinePost() 
{
	echo '<ul id="newsTrack" class="hideJs">';
	$headLineArgs = array(
							'post_type' => 'headline',
							'showposts' => 10,
							'orderby' => 'date',
							'order' => 'DESC'
						  );
	$tkrQuery = new WP_Query($headLineArgs);
	while ($tkrQuery->have_posts()) : $tkrQuery->the_post(); 
	?>
	<li class="itemsTick">
    	<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
    </li>
	<?php
	endwhile; 
	wp_reset_query();
	echo '</ul>';
}

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
  	<h3>Hire Me on Odesk.com</h3>
      <!– START Hire Me on oDesk Widget –>
      <script language="JavaScript">
      var odesk_widgets_width = 340;
      var odesk_widgets_height = 250;
      </script>
      <script src="https://www.odesk.com/widgets/providers/v1/large/~01bf79370d989b2033.js"></script>
      <!– END Hire Me on oDesk Widget –>
  </div>
  
  <div class="nhtWidget">
  
  </div>
  
  </div>
  
     
<div class="clrFix"></div>
<?php		
	echo '</div>';
}

function newsHeadLineTkr()
{
	return headLinePost();
}
add_shortcode('News-Ticker', 'headLinePost');