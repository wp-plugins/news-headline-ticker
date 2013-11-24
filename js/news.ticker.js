(function($){  
	jQuery.fn.newsTickerWP = function(options) { 
		var opts = jQuery.extend({}, jQuery.fn.newsTickerWP.defaults, options); 

		if (jQuery(this).length == 0) {
			if (window.console && window.console.log) {
				window.console.log('Element does not exist in DOM!');
			}
			else {
				alert('Element does not exist in DOM!');		
			}
			return false;
		}
		
		var newsID = '#' + jQuery(this).attr('id');
		var tagType = jQuery(this).get(0).tagName; 	
		return this.each(function() { 
			var uniqID = getUniqID();
			
			var settings = {				
				position: 0,
				time: 0,
				distance: 0,
				newsArr: {},
				play: true,
				paused: false,
				contentLoaded: false,
				dom: {
					contentID: '#newsContent-' + uniqID,
					titleID: '#newsTitle-' + uniqID,
					titleElem: '#newsTitle-' + uniqID + ' SPAN',
					newsTickerWPID : '#newsTickerWP-' + uniqID,
					wrapperID: '#newsTickerWP-wrapper-' + uniqID,
					revealID: '#newsSwipe-' + uniqID,
					revealElem: '#newsSwipe-' + uniqID + ' SPAN',
					controlsID: '#newsControls-' + uniqID,
					prevID: '#prev-' + uniqID,
					nextID: '#next-' + uniqID,
					playPauseID: '#play-pause-' + uniqID
				}
			};

			if (tagType != 'UL' && tagType != 'OL' && opts.htmlFeed === true) {
				debugError('Cannot use <' + tagType.toLowerCase() + '> type of element for this plugin - must of type <ul> or <ol>');
				return false;
			}

			opts.direction == 'rtl' ? opts.direction = 'right' : opts.direction = 'left';
			
			initialisePage();
			function countSize(obj) {
			    var size = 0, key;
			    for (key in obj) {
			        if (obj.hasOwnProperty(key)) size++;
			    }
			    return size;
			};

			function getUniqID() {
				var newDate = new Date;
				return newDate.getTime();			
			}
			
			function debugError(obj) {
				if (opts.debugMode) {
					if (window.console && window.console.log) {
						window.console.log(obj);
					}
					else {
						alert(obj);			
					}
				}
			}

			function initialisePage() {
				processContent();
				jQuery(newsID).wrap('<div id="' + settings.dom.wrapperID.replace('#', '') + '"></div>');
				jQuery(settings.dom.wrapperID).children().remove();
				jQuery(settings.dom.wrapperID).append('<div id="' + settings.dom.newsTickerWPID.replace('#', '') + '" class="newsTickerWP"><div id="' + settings.dom.titleID.replace('#', '') + '" class="newsTitle"><span><!-- --></span></div><p id="' + settings.dom.contentID.replace('#', '') + '" class="newsContent"></p><div id="' + settings.dom.revealID.replace('#', '') + '" class="newsSwipe"><span><!-- --></span></div></div>');
				jQuery(settings.dom.wrapperID).removeClass('no-js').addClass('newsTickerWP-wrapper has-js ' + opts.direction);
				jQuery(settings.dom.newsTickerWPElem + ',' + settings.dom.contentID).hide();
				if (opts.controls) {
					jQuery(settings.dom.controlsID).live('click mouseover mousedown mouseout mouseup', function (e) {
						var button = e.target.id;
						if (e.type == 'click') {	
							switch (button) {
								case settings.dom.prevID.replace('#', ''):
									settings.paused = true;
									jQuery(settings.dom.playPauseID).addClass('paused');
									manualChangeContent('prev');
									break;
								case settings.dom.nextID.replace('#', ''):
									settings.paused = true;
									jQuery(settings.dom.playPauseID).addClass('paused');
									manualChangeContent('next');
									break;
								case settings.dom.playPauseID.replace('#', ''):
									if (settings.play == true) {
										settings.paused = true;
										jQuery(settings.dom.playPauseID).addClass('paused');
										pausenewsTickerWP();
									}
									else {
										settings.paused = false;
										jQuery(settings.dom.playPauseID).removeClass('paused');
										restartnewsTickerWP();
									}
									break;
							}	
						}
						else if (e.type == 'mouseover' && $('#' + button).hasClass('controls')) {
							jQuery('#' + button).addClass('over');
						}
						else if (e.type == 'mousedown' && $('#' + button).hasClass('controls')) {
							jQuery('#' + button).addClass('down');
						}
						else if (e.type == 'mouseup' && $('#' + button).hasClass('controls')) {
							jQuery('#' + button).removeClass('down');
						}
						else if (e.type == 'mouseout' && $('#' + button).hasClass('controls')) {
							jQuery('#' + button).removeClass('over');
						}
					});
					jQuery(settings.dom.wrapperID).append('<ul id="' + settings.dom.controlsID.replace('#', '') + '" class="newsControls"><li id="' + settings.dom.playPauseID.replace('#', '') + '" class="jnt-play-pause controls"><a href=""><!-- --></a></li><li id="' + settings.dom.prevID.replace('#', '') + '" class="jnt-prev controls"><a href=""><!-- --></a></li><li id="' + settings.dom.nextID.replace('#', '') + '" class="jnt-next controls"><a href=""><!-- --></a></li></ul>');
				}
				if (opts.displayType != 'fade') {
               		jQuery(settings.dom.contentID).mouseover(function () {
               			if (settings.paused == false) {
               				pausenewsTickerWP();
               			}
               		}).mouseout(function () {
               			if (settings.paused == false) {
               				restartnewsTickerWP();
               			}
               		});
				}
				if (!opts.ajaxFeed) {
					setupContentAndTriggerDisplay();
				}
			}

			function processContent() {
				if (settings.contentLoaded == false) {
					if (opts.ajaxFeed) {
						if (opts.feedType == 'xml') {							
							jQuery.ajax({
								url: opts.feedUrl,
								cache: false,
								dataType: opts.feedType,
								async: true,
								success: function(data){
									count = 0;	
									for (var a = 0; a < data.childNodes.length; a++) {
										if (data.childNodes[a].nodeName == 'rss') {
											xmlContent = data.childNodes[a];
										}
									}
									for (var i = 0; i < xmlContent.childNodes.length; i++) {
										if (xmlContent.childNodes[i].nodeName == 'channel') {
											xmlChannel = xmlContent.childNodes[i];
										}		
									}
									for (var x = 0; x < xmlChannel.childNodes.length; x++) {
										if (xmlChannel.childNodes[x].nodeName == 'item') {
											xmlItems = xmlChannel.childNodes[x];
											var title, link = false;
											for (var y = 0; y < xmlItems.childNodes.length; y++) {
												if (xmlItems.childNodes[y].nodeName == 'title') {      												    
													title = xmlItems.childNodes[y].lastChild.nodeValue;
												}
												else if (xmlItems.childNodes[y].nodeName == 'link') {												    
													link = xmlItems.childNodes[y].lastChild.nodeValue; 
												}
												if ((title !== false && title != '') && link !== false) {
												    settings.newsArr['item-' + count] = { type: opts.titleText, content: '<a href="' + link + '">' + title + '</a>' };												    count++;												    title = false;												    link = false;
												}
											}	
										}		
									}			
									if (countSize(settings.newsArr < 1)) {
										debugError('Couldn\'t find any content from the XML feed for the newsTickerWP to use!');
										return false;
									}
									settings.contentLoaded = true;
									setupContentAndTriggerDisplay();
								}
							});							
						}
						else {
							debugError('Code Me!');	
						}						
					}
					else if (opts.htmlFeed) { 
						if(jQuery(newsID + ' LI').length > 0) {
							jQuery(newsID + ' LI').each(function (i) {
								settings.newsArr['item-' + i] = { type: opts.titleText, content: jQuery(this).html()};
							});		
						}	
						else {
							debugError('Couldn\'t find HTML any content for the newsTickerWP to use!');
							return false;
						}
					}
					else {
						debugError('The newsTickerWP is set to not use any types of content! Check the settings for the newsTickerWP.');
						return false;
					}					
				}			
			}

			function setupContentAndTriggerDisplay() {

				settings.contentLoaded = true;
				jQuery(settings.dom.titleElem).html(settings.newsArr['item-' + settings.position].type);
				jQuery(settings.dom.contentID).html(settings.newsArr['item-' + settings.position].content);

				if (settings.position == (countSize(settings.newsArr) -1)) {
					settings.position = 0;
				}
				else {		
					settings.position++;
				}			
				distance = $(settings.dom.contentID).width();
				time = distance / opts.speed;

				revealContent();		
			}

			function revealContent() {
				jQuery(settings.dom.contentID).css('opacity', '1');
				if(settings.play) {	
					var offset = $(settings.dom.titleID).width() + 20;
	
					jQuery(settings.dom.revealID).css(opts.direction, offset + 'px');
					if (opts.displayType == 'fade') {
						jQuery(settings.dom.revealID).hide(0, function () {
							jQuery(settings.dom.contentID).css(opts.direction, offset + 'px').fadeIn(opts.fadeInSpeed, postReveal);
						});						
					}
					else if (opts.displayType == 'scroll') {
					}
					else {
						jQuery(settings.dom.revealElem).show(0, function () {
							jQuery(settings.dom.contentID).css(opts.direction, offset + 'px').show();
							animationAction = opts.direction == 'right' ? { marginRight: distance + 'px'} : { marginLeft: distance + 'px' };
							jQuery(settings.dom.revealID).css('margin-' + opts.direction, '0px').delay(20).animate(animationAction, time, 'linear', postReveal);
						});		
					}
				}
				else {
					return false;					
				}
			};

			function postReveal() {				
				if(settings.play) {		
					jQuery(settings.dom.contentID).delay(opts.pauseOnItems).fadeOut(opts.fadeOutSpeed);
					if (opts.displayType == 'fade') {
						jQuery(settings.dom.contentID).fadeOut(opts.fadeOutSpeed, function () {
							jQuery(settings.dom.wrapperID)
								.find(settings.dom.revealElem + ',' + settings.dom.contentID)
									.hide()
								.end().find(settings.dom.newsTickerWPID + ',' + settings.dom.revealID)
									.show()
								.end().find(settings.dom.newsTickerWPID + ',' + settings.dom.revealID)
									.removeAttr('style');								
							setupContentAndTriggerDisplay();						
						});
					}
					else {
						jQuery(settings.dom.revealID).hide(0, function () {
							jQuery(settings.dom.contentID).fadeOut(opts.fadeOutSpeed, function () {
								jQuery(settings.dom.wrapperID)
									.find(settings.dom.revealElem + ',' + settings.dom.contentID)
										.hide()
									.end().find(settings.dom.newsTickerWPID + ',' + settings.dom.revealID)
										.show()
									.end().find(settings.dom.newsTickerWPID + ',' + settings.dom.revealID)
										.removeAttr('style');								
								setupContentAndTriggerDisplay();						
							});
						});	
					}
				}
				else {
					jQuery(settings.dom.revealElem).hide();
				}
			}

			function pausenewsTickerWP() {				
				settings.play = false;
				jQuery(settings.dom.newsTickerWPID + ',' + settings.dom.revealID + ',' + settings.dom.titleID + ',' + settings.dom.titleElem + ',' + settings.dom.revealElem + ',' + settings.dom.contentID).stop(true, true);
				jQuery(settings.dom.revealID + ',' + settings.dom.revealElem).hide();
				jQuery(settings.dom.wrapperID)
					.find(settings.dom.titleID + ',' + settings.dom.titleElem).show()
						.end().find(settings.dom.contentID).show();
			}

			function restartnewsTickerWP() {				
				settings.play = true;
				settings.paused = false;
				postReveal();	
			}

			function manualChangeContent(direction) {
				pausenewsTickerWP();
				switch (direction) {
					case 'prev':
						if (settings.position == 0) {
							settings.position = countSize(settings.newsArr) -2;
						}
						else if (settings.position == 1) {
							settings.position = countSize(settings.newsArr) -1;
						}
						else {
							settings.position = settings.position - 2;
						}
						jQuery(settings.dom.titleElem).html(settings.newsArr['item-' + settings.position].type);
						jQuery(settings.dom.contentID).html(settings.newsArr['item-' + settings.position].content);						
						break;
					case 'next':
						jQuery(settings.dom.titleElem).html(settings.newsArr['item-' + settings.position].type);
						jQuery(settings.dom.contentID).html(settings.newsArr['item-' + settings.position].content);
						break;
				}
				if (settings.position == (countSize(settings.newsArr) -1)) {
					settings.position = 0;
				}
				else {		
					settings.position++;
				}	
			}
		});  
	};  

	jQuery.fn.newsTickerWP.defaults = {
		speed: 0.10,			
		ajaxFeed: false,
		feedUrl: '',
		feedType: 'xml',
		displayType: 'reveal',
		htmlFeed: true,
		debugMode: true,
		controls: true,
		titleText: 'News Headline',	
		direction: 'ltr',	
		pauseOnItems: 3000,
		fadeInSpeed: 600,
		fadeOutSpeed: 300
	};	
})(jQuery);