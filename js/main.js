$(window).load(function(){
	onResize();
});

$(function(){
	
	$('.scroller').each(function(){
		var scroller = $(this);
		var options = {};

		if(scroller.hasClass('gallery-scroller') || scroller.data('scroll-all') === true) options.scrollAll = true;
		if(scroller.data('auto-scroll') === true ) options.autoScroll = true;
		if(scroller.data('callback')) {
			scroller.bind('onChange', function(e, nextItem){
				var func = window[scroller.data('callback')];
				func($(this), nextItem);
			});
		}
		scroller.scroller(options);
	});

	$('a[href^=#]').click(function(){
		var target = $($(this).attr('href'));
		var offsetTop = (target.length != 0) ? target.offset().top : 0;
		$('body, html').animate({scrollTop: offsetTop}, 500);
		return false;
	});

	$('.overlay-btn').hover(function(){
		$('.overlay', this).fadeIn();
	}, function(){
		$('.overlay', this).fadeOut();
	});
	
	
	$('.lightbox-overlay, .lightbox .close-btn').live('click', function(){
		$('.lightbox').fadeOut(function(){
			$('.lightbox-overlay').fadeOut('slow');	
			$('.lightbox').html('');
		});						 
	});
	
	$('.lightbox-btn').live('click', function(){
		loadPopup($(this).attr('href'));
		return false;
	});
	
	$('.img-link').hover(function(){
		$('.overlay', this).fadeTo(200, 0.5);
	}, function(){
		$('.overlay', this).fadeOut();
	});
	
	$('.fade-btn').hover(function(){
		$(this).fadeTo(200, 0.6);
	}, function(){
		$(this).fadeTo(200, 1);
	});

	$('.display-type-btn').click(function(){
		var displayType = $(this).data('display-type');
		var navigation = $(this).parent();
		$('a', navigation).removeClass('current');
		$(this).addClass('current');
		$('.posts').hide();
		$('.posts[data-display-type='+displayType+']').fadeIn();
	});

	$('> p, > h1, > h2, > h3, > h4, > h5, > h6', $('#single .post-content')).each(function(){
		if($('.size-large, .size-full', this).length !== 0){
			$(this).addClass('large-image');
		} else if($('.size-medium', this).length > 1){
			$(this).addClass('small-images');
		} else {
			$(this).addClass('text');
		}
	});

	$('.share-popup-btn').click(function(){
		var url = $(this).attr('href');
		var width = 640;
		var height = 305;
		var left = ($(window).width() - width) / 2;
		var top = ($(window).height() - height) / 2;
		window.open(url, 'sharer', 'toolbar=0,status=0,width='+width+',height='+height+',left='+left+', top='+top);
		return false;
	});

	$('.tooltip-btn').click(function(){
		var tooltip = $('.tooltip', this);
		tooltip.fadeToggle();
		$('input[type=text]', tooltip).select();
		return false;
	});

	$('.has-tooltip').click(function(){
		$('.tooltip', this).fadeIn();
	}, function(){
		$('.tooltip', this).fadeOut();
	});

	if($('.fancybox').length !== 0){
		$('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', themeUrl+'/css/jquery.fancybox.css') );
		$.getScript(themeUrl + '/js/plugins/jquery.fancybox.min.js', function(){
			$('.fancybox').fancybox();
		});
	}

	if($('.equal-height').length !== 0){
		
		var currTallest = 0,
		currRowStart = 0,
		rowDivs = new Array(),
		topPos = 0;

		$('.equal-height').each(function() {

			var element = $(this);
			topPos = element.position().top;

			if (currRowStart != topPos) {

				// we just came to a new row.  Set all the heights on the completed row
				for (i = 0 ; i < rowDivs.length ; i++) {
					rowDivs[currentDiv].height(currTallest);
				}

				rowDivs.length = 0;
				currRowStart = topPos;
				currTallest = element.height();
				rowDivs.push(element);

			} else {

			// another div on the current row.  Add it to the list and check if it's taller
			rowDivs.push(element);
				currTallest = (currTallest < element.height()) ? (element.height()) : (currTallest);
			}

			// do the last row
			for (i = 0 ; i < rowDivs.length ; i++) {
				rowDivs[i].height(currTallest);
			}

		});
	}
	$(window).resize(function(){
		onResize();					  
	});
	onResize();	
});

$.fn.preload = function() {
    this.each(function(){
        $('<img/>')[0].src = themeUrl + this;
    });
}

function loadPopup(url){
	
	$('.lightbox-overlay').fadeIn('slow', function(){
		$('html,body').animate({scrollTop: $('.lightbox-overlay').offset().top}, 800);
		$('.lightbox').html('<div class="loader align-center"><img src="'+themeUrl+'/images/misc/ajax_loader.gif" /></div>');
		$('.lightbox').delay(100).fadeIn();
		$.get(url, function(data) {
			$('.lightbox').fadeOut(function(){
				$('.lightbox')
					.html(data)
					.delay(200)
					.fadeIn();
			});
			
		});
	});		
}

function onResize(){
	// var windowHeight = $(window).height();
	// var windowWidth = $(window).width();
	// var docHeight = $(document).height();
	// var docWidth = $(document).width();
	//$('.lightbox').css({'top': ($('.lightbox').parent().height() - $('.lightbox').height() )/ 2 });
}

function onEditorChange(scroller, nextItem){
	var scrollWidth = scroller.width();
	var halfWidth = scrollWidth / 2;
	var pagination = $('.scroller-pagination', scroller);
	var paginationWidth = paginationWidth();
	var nextId = nextItem.data('id');
	var btn = $('li a[data-id="'+nextId+'"]', pagination);
	var btnPosition = btn.position();
	var btnLeft = btnPosition.left + (btn.width() / 2);
	
	if( btnLeft > halfWidth && btnLeft < (paginationWidth - halfWidth) ){
		pagination.animate({left: -(btnLeft)+ halfWidth});
	} else if (btnLeft > (paginationWidth - halfWidth) ) {
		pagination.animate({left: -paginationWidth + scrollWidth});
	} else {
		pagination.animate({left: 0});
	}

	function paginationWidth(){
		var width = 0;
		$('li', pagination).each(function(){
			width += $(this).width();
		});
		return width;
	}

}

if (!(window.console && console.log)) {
    (function() {
        var noop = function() {};
        var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'markTimeline', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'];
        var length = methods.length;
        var console = window.console = {};
        while (length--) {
            console[methods[length]] = noop;
        }
    }());
}