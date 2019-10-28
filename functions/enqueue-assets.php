<?php

add_action('wp_enqueue_scripts', 'wst_styles_and_scripts');
function wst_styles_and_scripts()
{
	wp_enqueue_script('GSAP', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js', array(), '2.1.2', true);

	wp_enqueue_script('scrollmagic', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js', array(), '2.0.7', true);

	wp_enqueue_script('scroll-anim', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.js', array('scrollmagic', 'GSAP'), '2.0.7', true);

	wp_enqueue_script('scroll-indicators', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/debug.addIndicators.min.js', array('scrollmagic'), '2.0.7', true);

	wp_enqueue_script('css-plugin', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/plugins/CSSPlugin.min.js', array('GSAP'), '2.1.3', true);

	wp_enqueue_script('css-rule', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/plugins/CSSRulePlugin.min.js', array('GSAP', 'css-plugin'), '2.1.3', true);


	wp_enqueue_script('animation-js', THEME_JS . '/animation.min.js', ['GSAP', 'scrollmagic', 'css-plugin', 'css-rule'], '1.0.0', true);

	wp_enqueue_script('custom-js', THEME_JS . '/custom.min.js', ['jquery'], '1.0.0', true);

	wp_enqueue_script('matchHeight-js', THEME_JS . '/matchHeight.min.js', ['jquery'], '1.0.0', true);

	wp_enqueue_script('slick-js', THEME_JS . '/slick.min.js', ['jquery'], '1.0.0', true);

	wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css', array(), '3.5.7');

	wp_enqueue_script('fancybox-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', ['jquery'], '3.5.7', true);


	if (is_archive() or is_home() or is_search()) {
		wp_enqueue_script('selectric-js', THEME_JS . '/selectric.min.js', ['jquery'], '1.13.0', true);
	}
}