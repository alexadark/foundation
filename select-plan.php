<?php
//Template Name: Select Plan

$context   = Timber::get_context();
$templates = array('select-plan.twig');
if( isset($_GET["email_address"]) && $_GET["email_address"]!="" ){
	$context["email_address"] = $_GET["email_address"];
}
if( isset($_GET["first_name"]) && $_GET["first_name"]!="" ){
	$context["first_name"] = $_GET["first_name"];
}
if( isset($_GET["last_name"]) && $_GET["last_name"]!="" ){
	$context["last_name"] = $_GET["last_name"];
}
if( isset($_GET["phone"]) && $_GET["phone"]!="" ){
	$context["phone"] = $_GET["phone"];
}
Timber::render($templates, $context);