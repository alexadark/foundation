<?php $current_user = wp_get_current_user();
 $full_name = $current_user->user_firstname." ".$current_user->user_lastname; ?>
<h1 class="hero__title font42 text-center light-pink bold no-margin">
Hi, <?php echo $full_name; ?>
</h1>
	<?php $logout_url = wp_logout_url( site_url("/the-lab") ); ?>
<a href="<?php echo $logout_url; ?>" title="Sign Out">Sign Out</a>
	