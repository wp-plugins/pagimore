(function($){
	$.fn.extend({
		pagiMore: function(options){
			var defaults = {
				// Default settings
				animate: true,
				showDates: true
			};
			var options = $.extend(defaults, options);
			return this.each(function(){
				// Options shotcut
				var o = options;
				
				// Hide dates
				$('.pagiMore-date').hide();
				
				// Get width
				var pagiMoreWidth = $('#pagiMore').css('width');
				
				// Remove px from value
				var pagiMoreWidth = pagiMoreWidth.substring(0, pagiMoreWidth.length-2);
				
				// Calculate total width
				var totalWidth = 0;
				$('.pageItem').each(function() {
					totalWidth += $(this).outerWidth(true);
				});
				
				// Set ul width
				$('#pagiMore ul').width(totalWidth);
				
				// Only init pagination slider when it's needed
				if (totalWidth > pagiMoreWidth){
				
					// Total number of pages
					var totalPages = $('.pageItem').size();
					
					// Calculate current position ( starts counting at 0 )
					var currentPage = $('li').index($('.current'));
					
					var scrollPosition = (currentPage / (totalPages - 1)) * 100;
					
					// Fixing date position in IE8
					function ie8DateFix(){
						if ($.browser.msie && parseInt($.browser.version) == 8){
							var minusMargin = pagiMoreContent.scrollLeft()*-1;
							var pageItemWidth = $('.pageItem').outerWidth(true);
							var dateWidth = $('.pagiMore-date').css('width');
							var dateWidth = dateWidth.substring(0, dateWidth.length-2);
							var margin = (dateWidth/2)-(pageItemWidth/2);
						
							$('.pagiMore-date').css('margin-left', minusMargin - margin+'px');
						
						}
					}
					
					// Fixing date postion in Safari
					function safariDateFix(){
						if($.browser.safari) {
							var minusMargin = pagiMoreContent.scrollLeft()*-1;
							var pageItemWidth = $('.pageItem').outerWidth(true);
							var dateWidth = $('.pagiMore-date').css('width');
							var dateWidth = dateWidth.substring(0, dateWidth.length-2);
							var margin = (dateWidth/2)-(pageItemWidth/2);
							
							$('.pagiMore-date').css('margin-left', minusMargin - margin+'px');
						}
					}
					
					function handleSliderChange(e, ui){
						var pagiMoreContent = $("#pagiMoreContent");
						var maxScroll = pagiMoreContent.attr('scrollWidth') - pagiMoreContent.width();
						if (o.animate == true){
							pagiMoreContent.animate({
								scrollLeft: ui.value * (maxScroll / 100)
							});
						}else{
							pagiMoreContent.scrollLeft(ui.value * (maxScroll / 100));
						}
						
						// Fixing date postion in Safari
						if($.browser.safari) {
							var pageItemWidth = $('.pageItem').outerWidth(true);
							var dateWidth = $('.pagiMore-date').css('width');
							var dateWidth = dateWidth.substring(0, dateWidth.length-2);
							var margin = (dateWidth/2)-(pageItemWidth/2);
							
							$('.pagiMore-date').css('margin-left', '-'+ui.value * (maxScroll / 100)-margin+'px');
						}
						
						// Fixing date position in IE8
						if ($.browser.msie && parseInt($.browser.version) == 8){
							var pageItemWidth = $('.pageItem').outerWidth(true);
							var dateWidth = $('.pagiMore-date').css('width');
							var dateWidth = dateWidth.substring(0, dateWidth.length-2);
							var margin = (dateWidth/2)-(pageItemWidth/2);
							
							$('.pagiMore-date').css('margin-left', '-'+ui.value * (maxScroll / 100)-margin+'px');
						}
					}
					
					function handleSliderSlide(e, ui){
						var pagiMoreContent = $("#pagiMoreContent");
						var maxScroll = pagiMoreContent.attr('scrollWidth') - pagiMoreContent.width();
						if (e.eventPhase == 3) {
							pagiMoreContent.scrollLeft(ui.value * (maxScroll / 100));
						}
						safariDateFix();
						ie8DateFix();
					}
					
					$('#pagiMoreSlider').slider({
						change: 		handleSliderChange,
						slide: 			handleSliderSlide,
						max: 			  100,
						value:			scrollPosition,
						animate: 		o.animate
					});
					
					// Start offset
					var pagiMoreContent = $("#pagiMoreContent");
					var maxScroll = pagiMoreContent.attr('scrollWidth') - pagiMoreContent.width();
					var divPosition = $('#pagiMoreSlider').slider('option', 'value') * (maxScroll / 100);
					pagiMoreContent.scrollLeft(divPosition);
				}
				
				if (o.showDates == true){
					// Never show dates if browser is Opera (ugly bug)
					if(!$.browser.opera) {
						// Show dates on rollover and hide them again on rollout
						$('.pageItem').hover(function(){
							$('.pagiMore-date', this).fadeIn('fast');
						},
						function(){
							$('.pagiMore-date', this).fadeOut('fast');
						});
					}
					safariDateFix();
					ie8DateFix();
				}
			});
		}
	});
})(jQuery);