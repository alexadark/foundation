(function($) {
	$('.gform_fields input, textarea').focus(function() {
		$(this)
			.parent()
			.prev()
			.addClass('is-active');
	});
	$('.dlm-nf-download-link a').text('download now');
	// $('.report .gfrom_button').html(
	// 	'Download Now <img src="../img/dl-green,svg"/>'
	// );
})(jQuery);
