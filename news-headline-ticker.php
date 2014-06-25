<?php
/*
Plugin Name: News Headline Ticker
Plugin URI: http://www.e2soft.com/wordpress-plugin/news-headline-ticker
Description: News Headline Ticker is a wordpress plugin to show your recent news headline as typing style slider on your website!  Use this shortcode <strong>[News-Ticker]</strong> in the post/page" where you want to display news head line.
Version: 1.1.1
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

function newsHeadLineTkr()
{
	return headLinePost();
}
add_shortcode('News-Ticker', 'headLinePost');

foreach ( glob( plugin_dir_path( __FILE__ )."lib/*.php" ) as $nhtfile )
    include_once $nhtfile;