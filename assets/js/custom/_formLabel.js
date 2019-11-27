(function($) {
	$('.gform_fields input').each(function() {
		if ($(this).val() != '' && $(this).attr('id') != '') {
			$('.gform_fields li label[for="' + $(this).attr('id') + '"]').addClass(
				'is-active'
			)
		}
	});
	if ($('#input_17_7_1')) {
		if ($('#input_17_7_1').val() != '')
			$('#field_17_7 label.gfield_label_before_complex').addClass('is-active')
	}
	if ($('#input_14_7_1')) {
		if ($('#input_14_7_1').val() != '')
			$('#field_14_7 label.gfield_label_before_complex').addClass('is-active')
	}

	$('.gform_fields li label[for="input_8_10"]').addClass('is-active');
	$('.gform_fields li label[for="input_8_11"]').addClass('is-active');
	$('.gform_fields input, textarea').focus(function() {
		$('.gform_fields li label[for="' + $(this).attr('id') + '"]').addClass(
			'is-active'
		)
	});
	$('.ginput_container_address input').focus(function() {
		$(this)
			.parent()
			.parent()
			.prev('.gfield_label_before_complex')
			.addClass('is-active')
	});
	$('.account-info__info a.green-link').on('click', function(e) {
		e.preventDefault()
		var form_id = $(this).attr('id');
		$('.' + form_id + '__form').toggle()
	})
})(jQuery)
