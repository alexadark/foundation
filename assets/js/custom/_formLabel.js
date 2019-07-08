(function($) {
	$('.gform_fields input, textarea').focus(function() {
		$(this)
			.parent()
			.prev()
			.addClass('is-active');
	});
	$('.dlm-nf-download-link a').text('download now');
})(jQuery);
