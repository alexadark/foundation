(function($) {
	const $$ = document.querySelectorAll.bind(document);
	const itemsWithChildrens = $$('.fixed-menu ul li ul .menu-item-has-children');
	var $diff = 0;

	/*$('.fixed-menu__nav >ul').addClass('mainnav');
	$('.menu-item-has-children ul').addClass('dropdown');
	$('.menu-item-has-children ul li').addClass('subs');
	$('.menu-item-has-children').addClass('hassubs');*/

	itemsWithChildrens.forEach(item =>
	item.on('click', e => {
		$diff = jQuery(item).width() - e.offsetX;
			if ($diff <= 5) {
				item.classList.toggle('active');
			} else {
				console.log('click not after' + (jQuery(item).width() +' - '+ e.offsetX) +' = ' + $diff);
			}
		})
	);
})(jQuery);


