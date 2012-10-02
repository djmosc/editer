$.fn.scroller = function(options) {
	
	var defaults = {
		autoScroll: false,
		scrollAll: false,
		customAnimation: false
	};

	options = $.extend({}, defaults, options);
	
	
	var scroller = $(this);
	var currItem = $('.scroll-item:eq(0)', scroller);
	if($('.scroll-item', scroller).hasClass('current')){
		currItem = $('.scroll-item.current', scroller);
	}
	var speed = 1000;
	var canScroll = true;
	var canAutoScroll = true;
	var firstLoad = true;
	var totalItems = $('.scroll-item', scroller).size();

	function gotoItem(id){
		var nextItem = $('.scroll-item[data-id='+id+']', scroller);
		var nextI = nextItem.index();
		var currI = currItem.index();
		var scrollWidth = nextItem.outerWidth(true);

		if(canScroll && (firstLoad || currItem !== nextItem) && !$('.scroll-item', scroller).is(':animated') && !$('.scroll-items-container', scroller).is(':animated')){
			var initX = scrollWidth;
			canScroll = false;
			if(currI < nextI){
				initX = -scrollWidth / 2;
			}
			if(options.customAnimation) {
				if(!firstLoad){
					currItem.fadeOut(500).removeClass('current');
					nextItem.show().addClass('current');
					
					var i = 0;
					var slideItems = $('.animate.slide', nextItem);
					if(currI < nextI){
						slideItems = $($('.animate.slide', nextItem).get().reverse());
					}

					var fadeItems = $('.animate.fade', nextItem);

					slideItems.each(function(){
						var initPosX = $(this).css('right');
						var item = $(this);
						item.css({'right': initX, opacity: 0});
						setTimeout(function(){
							item.animate({'right': initPosX, opacity: 1}, {duration: 2000 - (i * 100), easing: 'easeOutBack'});
						}, i * 100);
						i++;
					});
					fadeItems.hide();
					setTimeout(function(){
						$('.animate.fade', nextItem).fadeIn(function(){
							currItem = nextItem;
							canScroll = true;
						});
					}, 2000 + (i * 100));



				} else {
					currItem = nextItem;
					canScroll = true;
				}
			} else {
				if(!firstLoad){
					currItem.animate({'left': -initX}, speed, function(){
						$(this).removeClass('current');
					});
					nextItem.css({'left': initX}).addClass('current').animate({'left': 0}, speed, function(){
						currItem = nextItem;
						canScroll = true;
					});
				} else {
					currItem = nextItem;
					canScroll = true;
				}
			}
			$('.scroller-navigation li', scroller).removeClass('current');
			$('.scroller-navigation li a[data-id='+nextItem.data('id')+']', scroller).parent().addClass('current');
			
			scroller.trigger('onChange', [nextItem]);
			
		}
	}
	
	function gotoNextItem(){
		if(canAutoScroll){
			var nextItem = currItem.next();
			if(nextItem.length === 0){
				nextItem = $('.scroll-item:eq(0)', scroller);
			}
			gotoItem(nextItem.data('id'));
		}
	}
	
	function init(){
		$('.scroller-navigation a', scroller).on('click', function(){
			gotoItem($(this).data('id'));
		});
		
		$('.prev-btn', scroller).on('click', function(){
			var prevItem = currItem.prev();
			if(prevItem.length === 0){
				var lastI = totalItems - 1;
				prevItem = $('.scroll-item:eq('+lastI+')', scroller);
			}
			gotoItem(prevItem.data('id'));
		});
		
		$('.next-btn', scroller).on('click', function(){
			var nextItem = currItem.next();
			if(nextItem.length === 0){
				nextItem = $('.scroll-item:eq(0)', scroller);
			}
			gotoItem(nextItem.data('id'));
		});
		
		if(options.autoScroll){
			var scrollInterval;
			scroller.hover(function(){
				canAutoScroll = false;
			}, function(){
				canAutoScroll = true;
			});
			scrollInterval = setInterval(gotoNextItem, 10000);
		}
		var initId = currItem.data('id');
		gotoItem(initId);
		firstLoad = false;
	}
	
	init();
	return this;
};