<?php function dynamicCSS()
{ ?>
<style type="text/css">
.newsTickerWP-wrapper.has-js {
	-webkit-border-radius:<?php $nht_border_radius = get_option('nht_border_radius'); if(!empty($nht_border_radius)) {echo $nht_border_radius;} else {echo "15";}?>px;
	-moz-border-radius: <?php $nht_border_radius = get_option('nht_border_radius'); if(!empty($nht_border_radius)) {echo $nht_border_radius;} else {echo "15";}?>px;
	border-radius: <?php $nht_border_radius = get_option('nht_border_radius'); if(!empty($nht_border_radius)) {echo $nht_border_radius;} else {echo "15";}?>px;
	background-color:<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "#DEE77C";}?>;
}
.newsTickerWP {
	background-color:<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "DEE77C";}?>;
}
.newsTitle {
	color:<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "DEE77C"."000";}?>;
	background-color:<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "DEE77C";}?>;
}
.newsTitle span{
	color:<?php $nht_label_color = get_option('nht_label_color'); if(!empty($nht_label_color)) {echo $nht_label_color;} else {echo "000";}?>;
}
.newsContent {
	color:<?php $nht_text_color = get_option('nht_text_color'); if(!empty($nht_text_color)) {echo $nht_text_color;} else {echo "CCC";}?>;
	background-color:<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "DEE77C";}?>;
}
.newsContent a {
	color:<?php $nht_text_color = get_option('nht_text_color'); if(!empty($nht_text_color)) {echo $nht_text_color;} else {echo "1F527B";}?>; 
}
.newsContent a:hover {
	color:<?php $nht_hover_color = get_option('nht_hover_color'); if(!empty($nht_hover_color)) {echo $nht_hover_color;} else {echo "0D3059";}?> !important;
}
.newsSwipe {
	background-color:<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "DEE77C";}?>;
}
.newsSwipe span {
	background-color:<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "DEE77C";}?>;
	border-bottom:1px solid <?php $nht_text_color = get_option('nht_text_color'); if(!empty($nht_text_color)) {echo $nht_text_color;} else {echo "1F527B";}?>;
}
.hideJs {
	display: none; 
}
.no-newsTrack {
	color:<?php $nht_bg_color = get_option('nht_bg_color'); if(!empty($nht_bg_color)) {echo $nht_bg_color;} else {echo "DEE77C";}?>;
}
.nhtColor {
	display:none !important;
}
</style>
<?php 
}
add_action('wp_footer','dynamicCSS', 100);

?>
