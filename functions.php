<?php

/**
 * Foundation
 *
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */
require_once 'init.php';
require_once 'functions/helper-functions.php';
require_once 'functions/enqueue-assets.php';
require_once 'functions/widget-areas.php';

if (!class_exists('Timber')) {
	add_action('admin_notices', function () {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
	});

	add_filter('template_include', function ($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array('templates', 'views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site
{
	/** Add timber support. */
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'theme_supports'));
		add_filter('timber/context', array($this, 'add_to_context'));
		add_filter('timber/twig', array($this, 'add_to_twig'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));
		add_action('init', array($this, 'register_roles'));
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types()
	{ }
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies()
	{ }
	/** This is where you can register custom role. */
	public function register_roles()
	{
		$userroles = array("plan1_subscriber" => "Plan A Subscriber", "plan2_subscriber" => "Plan B Subscriber");
		foreach ($userroles as $key => $val) :
			if (!get_role($userrole)) {
				add_role(
					$key,
					__($val),
					array(
						'read'         => true,  // true allows this capability
						'edit_posts'   => true,
						'delete_posts' => false, // Use false to explicitly deny
					)
				);
			}
		endforeach;
	}
	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context($context)
	{
		$post               = new TimberPost();
		$context['post']    = $post;
		$context['current_user'] = new Timber\User();
		$context['menu'] = new Timber\Menu('main-menu');
		$context['footer_menu'] = new Timber\Menu();
		$context['site'] = $this;
		$context['options'] = get_fields('options');
		return $context;
	}

	public function theme_supports()
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support('menus');
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo($text)
	{
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig($twig)
	{
		$twig->addExtension(new Twig_Extension_StringLoader());
		$twig->addFilter(new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}
}
if (function_exists('acf_add_options_page')) {

	acf_add_options_page();
}

new StarterSite();

//hide admin bar from all user
show_admin_bar(false);

//auto login after register and redirect to the corresponding class
add_action('gform_user_registered', 'wpc_gravity_registration_autologin',  999, 4);
/**
 * Auto login after registration.
 */
function wpc_gravity_registration_autologin($user_id, $user_config, $entry, $password)
{
	$user = get_userdata($user_id);
	$user_login = $user->user_login;
	$user_password = $password;
	#$user->set_role(get_option('default_role', 'subscriber'));
	wp_signon(array(
		'user_login' => $user_login,
		'user_password' =>  $user_password,
		'remember' => false

	));
	#wp_redirect(site_url( "/the-lab/" ));
	#exit();
}

// Save the users' Stripe customer ID after a payment is made via a subscription Stripe feed.
add_action('gform_stripe_customer_after_create', 'save_stripe_customer_id', 99999);
function save_stripe_customer_id($customer)
{
	if (is_user_logged_in()) {
		$user_id = get_current_user_id();
		GFCommon::log_debug(__METHOD__ . '(): Adding customer id ' . $customer->id . ' to user ' . $user_id);
		update_user_meta($user_id, 'stripe_customer_id', $customer->id);
	}
}
// Gets the current Stripe customer ID to change the billing details on. Tests if the user has an ID and is signed in.
add_filter('gform_stripe_customer_id', 'get_stripe_customer_id', 99999);
function get_stripe_customer_id($customer_id)
{
	if (is_user_logged_in() &&  get_user_meta(get_current_user_id(), 'stripe_customer_id', true) != '') {
		$user_id = get_current_user_id();
		$customer_id = get_user_meta($user_id, 'stripe_customer_id', true);
	}
	return $customer_id;
}

// Make a form that has a Stripe Product and Services feed, and make sure no payment is made.
add_filter('gform_stripe_charge_authorization_only', 'stripe_charge_authorization_only', 99999, 2);
function stripe_charge_authorization_only($authorization_only, $feed)
{
	$feed_name  = rgars($feed, 'meta/feedName');
	// The name associated with the Stripe feed.
	if ($feed_name == 'Update Billing') {
		return true;
	}
	return $authorization_only;
}

#add_filter("gform_field_value_email_address", "populate_email");
function populate_email()
{
	global $current_user;
	get_currentuserinfo();
	$useremail = $current_user->user_email;
	return $useremail;
}

//once its actually cancelled at the end of the period, downgrade users role
add_action('gform_post_payment_callback', 'remove_user_privileges', 10, 3);
function remove_user_privileges($entry, $action, $result)
{
	if (!$result && rgar($action, 'type') == 'cancel_subscription' && strtolower($entry['payment_status']) == 'cancelled') {
		//$entry here is the original entry used to subscribe (form 2). not the cancel $entry.
		cancel_user_role($entry);
		$user_id = get_current_user_id();
		$fnd_entry_id = get_user_meta($user_id, 'fnd_entry_id', true);
		if ($fnd_entry_id == "") {
			$site_url = get_site_url();
			wp_delete_user($user_id);
			wp_redirect($site_url);
			exit;
		}
	}
}

function cancel_user_role($entry)
{
	$user_id = get_current_user_id();
	$u = new WP_User($user_id);
	$payment_amnt = $entry["payment_amount"];
	$package_details = "";
	foreach ($entry as $entry_val) :
		if (strpos($entry_val, $payment_amnt) !== FALSE && strpos($entry_val, "|") !== FALSE) {
			$package_details = $entry_val;
			break;
		}

	endforeach;
	$package_details = explode("|", $package_details);
	$user_package_id = $package_details[0];
	if ($user_package_id != "") {
		if ($user_package_id == "Plan2")
			$user_role = "plan2_subscriber";
		else
			$user_role = "plan1_subscriber";

		if (get_role($user_role))
			$u->remove_role($user_role);
	}
}

//assign role after successfull transaction
add_action("gform_user_registered", "completed_package_registration", 10, 4);
add_action("gform_user_updated", "completed_package_registration", 10, 4);

function completed_package_registration($user_id, $config, $entry, $user_pass)
{

	if ((strtolower($entry["payment_status"]) == "active" ||  strtolower($entry["payment_status"]) == "paid") && $entry["status"] == "active") {
		error_log(print_r($entry["id"], true));
		$stripe_customer_id = gform_get_meta($entry["id"], 'stripe_customer_id');
		update_user_meta($user_id, 'stripe_customer_id', $stripe_customer_id);
		update_user_meta($user_id, 'fnd_entry_id', $entry["id"]);
	}
}

//process the subscription cancelling
add_action('wp_ajax_fnd_gaddon_cancel_subscription', 'fnd_cancel_subscription_function');
function fnd_cancel_subscription_function()
{
	check_ajax_referer('gaddon_cancel_subscription', 'gaddon_cancel_subscription');
	$entry_id = $_POST['entry_id'];
	$user_id = get_current_user_id();
	$u = new WP_User($user_id);
	$entry = GFAPI::get_entry($entry_id);
	$form  = GFAPI::get_form($entry['form_id']);
	$feed  = gf_stripe()->get_payment_feed($entry, $form);

	if (empty($feed)) {
		return;
	}

	if (is_array($feed) && rgar($feed, 'addon_slug') == 'gravityformsstripe') {
		gf_stripe()->cancel_subscription($entry, $feed);
		//destroy old entry id so they cant cancel twice... not sure its necessary
		update_user_meta($user_id, 'user_entry_id', '');
		delete_user_meta($user_id, 'user_package_id');
		delete_user_meta($user_id, 'user_entry_txn_type');
		delete_user_meta($user_id, 'user_entry_pmt_status');
		#do not downgrade user now
		#cancel_user_rolr($entry_id);
		#$u->set_role( 'subscriber' );
		die('1');
	} else {
		die('0');
	}
}

//user can cancel subscription
add_action('gform_after_submission_15', 'fnd_cancel_subscription', 10, 2);
function fnd_cancel_subscription($entry, $form)
{
	if (isset($_REQUEST["plan"]) && $_REQUEST[""] != "plan") {
		//get original current users entry id from form 2. NOT this entry id!
		$user_id = get_current_user_id();
		$entry_id = get_user_meta($user_id, 'fnd_entry_id', true);
		//now cancel that entry's subscription
		$old_entry = GFAPI::get_entry($entry_id);
		$feed = is_wp_error($old_entry) || !function_exists('gf_stripe') ? false : gf_stripe()->get_payment_feed($old_entry);

		if (is_array($feed) && rgar($feed, 'addon_slug') == 'gravityformsstripe' && gf_stripe()->cancel($old_entry, $feed)) {
			gf_stripe()->cancel_subscription($old_entry, $feed);

			//destroy old entry id so they cant cancel twice... not sure its necessary
			update_user_meta($user_id, 'fnd_entry_id', '');
			update_user_meta($user_id, 'user_old_paid_plan', $_REQUEST["plan"]);

			//set meta to unsubscribed till period ends. in limbo state
			update_user_meta($user_id, 'subscribed_till_end', 'yes');
		}
	}
}
//logout normal user to homepage
add_action('wp_logout', 'auto_redirect_after_logout');
function auto_redirect_after_logout()
{
	wp_redirect(home_url());
	exit();
}