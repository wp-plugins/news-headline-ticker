<?php
/*
Plugin Name: News Headline Ticker
Plugin URI: http://www.e2soft.com/wordpress-plugin/news-headline-ticker
Description: News Headline Ticker is a wordpress plugin to show your recent news headline as typing style slider on your website!
Version: 0.1
Author: Hasibul Islam Badsha
Author URI: https://www.odesk.com/o/profiles/users/_~~f23680b391834fd1/
Copyright: 2013 Hasibul Islam Badsha http://www.e2soft.com
License URI: license.txt
*/


#######################	News Headline Ticker ###############################

$pluginName = 'News Headline Ticker';
$version = '0.1';
global $pluginName;
global $version;

//Register Custom Post Type
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
	  'supports'           => array( 'title' )
	);
	register_post_type( 'headline', $customPost );
}
add_action( 'init', 'tickerPostRegister' );


// Register jquery and style files
function registerTkrScript() {
    wp_register_script( 'news', plugins_url('/js/news.js', __FILE__), array('jquery'), $version);
	wp_register_script( 'news.ticker', plugins_url('/js/news.ticker.js', __FILE__), array('jquery'), $version );

    wp_register_style( 'style', plugins_url('/css/tkr.style.css', __FILE__), false, $version, 'all');
}
add_action('init', 'registerTkrScript');

// Use the registered jquery and style files
function enqueueTkrStyle(){
   wp_enqueue_script('news');
   wp_enqueue_script('news.ticker');

   wp_enqueue_style( 'style' );
}
add_action('wp_enqueue_scripts', 'enqueueTkrStyle');

// Custom Post Loop Function 
function headLinePost() 
{
	echo '<ul id="newsTrack" class="hideJs">';
	$headLineArgs = array(
							'post_type' => 'headline',
							'showposts' => 5,
							'orderby' => 'date',
							'order' => 'DESC'
						  );
	$the_query = new WP_Query($headLineArgs);
	while ($the_query->have_posts()) : $the_query->the_post(); 
	?>
	<li class="itemsTick">
    	<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
    </li>
	<?php
	endwhile; 
	wp_reset_query();
	echo '</ul>';
}

function newsHeadLineTkr()
{
	return headLinePost() ;
}

add_shortcode('News-Ticker', 'headLinePost');