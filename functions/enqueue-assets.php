<?php add_action('wp_enqueue_scripts', 'wst_styles_and_scripts');
function wst_styles_and_scripts()
{
	wp_enqueue_script('custom-js', THEME_JS . '/custom.min.js', ['jquery'], '1.0.0', true);

	// wp_enqueue_script( 'match-height', THEME_JS . 'jquery.matchHeight.min.js', 'jquery', '1.2.0', true );
}