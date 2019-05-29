jQuery(document).ready(function($) {
	$('.slider').slick({
		autoplay: true,
		speed: 1000,
		arrow: false,
		fade: true,
		dots: true,
	});

	$('.resources__slider').slick({
		autoplay: false,
		speed: 1000,
		arrow: true,
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					infinite: true,
				},
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});
});
