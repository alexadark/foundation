<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */
//echo wpb_get_post_views(get_the_ID());

$context = Timber::context();
$timber_post = Timber::query_post();
$context['post'] = $timber_post;

global $post;

$cat = get_the_category();
$catids = array();
foreach($cat as $item){
	$catids[] = $item->cat_ID;
}
$args = array(
	'post_type' => 'post',
	'post__not_in' => array($post->ID),
	'posts_per_page' => 3,
	'cat' => implode(',', $catids),
);

$context['same_cat'] = Timber::get_posts($args);
$context['current_cat_permalink'] = get_category_link($catids[0]);

$related_posts = get_posts(
    array(
        'post_type' => 'post',
        'post__not_in' => array($post->ID),
        'posts_per_page' => -1,
        'cat' => implode(',', $catids),
    )
);
$context['related_posts'] = sizeof($related_posts);

if (post_password_required($timber_post->ID)) {
	Timber::render('single-password.twig', $context);
} else {
	Timber::render(array('single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single.twig'), $context);
}
