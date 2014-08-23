$(function($){		
	$.supersized({
		// Functionality
		slide_interval      :   5000,		// Length between transitions
		transition          :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
		transition_speed	:	2000,		// Speed of transition
												   
		// Components							
		slide_links			:	'false',
		slides 				:  	[			// Slideshow Images
                                    {image : 'http://imageshack.us/a/img823/2505/jx3u.jpg'},
                                    {image : 'http://imageshack.us/a/img21/5773/9bpi.jpg'},
                                    {image : 'http://imageshack.us/a/img89/9380/gquy.jpg'},
                                    {image : 'http://imageshack.us/a/img196/6865/o1u5.jpg'}
								]
	});
});