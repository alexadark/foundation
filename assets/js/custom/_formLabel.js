(function($) {
	$('.gform_fields input').each(function () {
	    if( $(this).val() !="" && $(this).attr("id")!="" ){
	    	$('.gform_fields li label[for="' + $(this).attr("id") + '"]').addClass('is-active');
	    }
  });
 $('.gform_fields li label[for="input_8_10"]').addClass('is-active');
 $('.gform_fields li label[for="input_8_11"]').addClass('is-active');
  $('.gform_fields input, textarea').focus(function () {
    $('.gform_fields li label[for="' + $(this).attr("id") + '"]').addClass('is-active');
  });
  $('.ginput_container_address input').focus(function () {
    $(this).parent().parent().prev('.gfield_label_before_complex').addClass('is-active');
  });
  $('.account-info__info a.green-link').on( "click", function(e) {
     e.preventDefault();
     var form_id = $(this).attr("id");
     $('.'+form_id+'__form').toggle();
  });
  $('.cancel-link.green-link').on( "click", function(e) {
    // e.preventDefault();     
     //$('.account-lb.cancel-lb').css({"opacity":"1","height":"auto"});
  });
  $('.button--green.close-plan-popup').on( "click", function(e) {
     //e.preventDefault();     
     //$('.account-lb.cancel-lb').css({"opacity":"0","height":"0"});
     //$(this).parent().parent().parent().css({"opacity":"0","height":"0"});
  });
  $('.upgrade-link.green-link').on( "click", function(e) {
     //e.preventDefault();     
     //$('.account-lb.upgrade-lb').show();
     //$('.account-lb.upgrade-lb').css({"opacity":"1","height":"auto"});
  });
	$('.dlm-nf-download-link a').text('download now');
	// $('.report .gfrom_button').html(
	// 	'Download Now <img src="../img/dl-green,svg"/>'
	// );
})(jQuery);
