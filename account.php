<?php

//Template name: Account setup

$context   = Timber::get_context();
$content_blocks_details = get_field('content_blocks');
foreach ($content_blocks_details as $content_blocks_detail) {
	if( $content_blocks_detail["acf_fc_layout"]=="block_booking_form" ){
		$booking_form = $content_blocks_detail["form"];
		break;
	}
}

$context['form_id'] = $booking_form;
$context['top_section'] = true;
if( isset($_REQUEST["plan"]) && $_REQUEST["plan"]!="" ){
	$plan = strtolower($_REQUEST["plan"]);
	if( is_page('account-setup') ){
		if( strpos($plan, "plan2")!==FALSE )
			$context['form_id'] =16;
		else 
			$context['form_id'] =$booking_form;
	} elseif( is_page('upgrade-subscription') ) {
		if( strpos($plan, "plan2")!==FALSE )
			$context['form_id'] =14;
		else 
			$context['form_id'] =$booking_form;
	} else {
		$context['form_id'] =$booking_form;
	}
		$context['top_section'] = false;	
}
$templates = array('account.twig');
Timber::render($templates, $context);