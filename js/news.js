jQuery(function () {
	jQuery('#newsTrack').newsTickerWP();
	
	jQuery('#newsTickerWrapper').css('margin-top', '-' + (jQuery('#newsTickerWrapper').height() + 20) + 'px');

	jQuery('a[href="#release-history"]').toggle(function () {	
		jQuery('#newsTickerWrapper').animate({
			marginTop: '0px'
		}, 600, 'linear');
	}, function () {
		jQuery('#newsTickerWrapper').animate({
			marginTop: '-' + (jQuery('#newsTickerWrapper').height() + 20) + 'px'
		}, 600, 'linear');
	});	
	
	jQuery('#download a').mousedown(function () {
		_gaq.push(['_trackEvent', 'download-button', 'clicked'])		
	});
});