<?php
//Template name: Account info
$context   = Timber::get_context();
$templates = array('account-info.twig');
$current_user = wp_get_current_user();
$context['successmessage'] ="";
if(isset($_REQUEST["success"]) && $_REQUEST["success"]==1){
	$context['successmessage'] ="Your Information is successfully saved";
}
if( 0 != $current_user->ID ){
	$context['name'] = $current_user->user_firstname." ".$current_user->user_lastname;
	$context['email'] = $current_user->user_email;	
	$entry_id = get_user_meta( $current_user->ID, 'entry_id', true );
	$context['cc_details'] = get_user_meta( $current_user->ID, 'card number', true );
	$context['cc_type'] = get_user_meta( $current_user->ID, 'card type', true );
	$context['address'] = get_user_meta( $current_user->ID, 'address', true );
	$context['city'] = get_user_meta( $current_user->ID, 'city', true );	
	$context['postal'] = get_user_meta( $current_user->ID, 'postal', true );
	$context['state'] = get_user_meta( $current_user->ID, 'state', true );
	$context['country'] = get_user_meta( $current_user->ID, 'country', true );
	$paid_plan = get_user_meta( $current_user->ID, 'user_paid_plan', true );
	$old_paid_plan = get_user_meta( $current_user->ID, 'user_old_paid_plan', true );
	$context['paid_plan'] = $paid_plan;
	if( $paid_plan =="plan1_subscriber" ){		
		$context['paid_plan_id'] = 1;
		$context['upgrade_plan_id'] = 2;
		$context['upgrade_text'] = "If you change your plan you will be billed yearly instead of monthly. Saving $20/yr";
		$context['active_plan_info'] = "PLAN 1 - $10/mo";
		$context['upgrade_plan_info'] = "PLAN 2 - $100/yr";
	} else {
		$context['paid_plan_id'] = 2;
		$context['upgrade_plan_id'] = 1;
		$context['upgrade_text'] = "If you change your plan you will be billed monthly instead of yearly.";
		$context['active_plan_info'] = "PLAN 2 - $100/yr";
		$context['upgrade_plan_info'] = "PLAN 1 - $10/mo";
	}
	$fnd_entry_id = get_user_meta($current_user->ID, 'fnd_entry_id',true);
	if( $fnd_entry_id!="" ){
		$context['no_subscription'] = false;
	} else {
		$context['no_subscription'] = true;
	}
	if( $paid_plan=="" && $old_paid_plan!="" )
		$context['no_subscription'] = true;
	$context['cancel_link'] = site_url('/cancel-subscription/?plan=plan'.$context['paid_plan_id']);
	$context['upgrade_link'] = site_url('/upgrade-subscription/?plan=plan'.$context['upgrade_plan_id']);
	$context['logout_url'] =  wp_logout_url( home_url() );
}
//TODO: same for password and billing with the hidden parts
Timber::render($templates, $context);