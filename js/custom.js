jQuery(document).ready(function($){
	var $container = $('#manson');
	// initialize
	$container.imagesLoaded( function() {
		$container.masonry({
		  columnWidth: '.item',
		  itemSelector: '.item'
		});
	});
	
	var $pgwSlider = $('.pgwSlider');
	$pgwSlider.imagesLoaded( function() {
		$pgwSlider.pgwSlider({
			intervalDuration : slider_speed.vars
		});
	});		
	
});