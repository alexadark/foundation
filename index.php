<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context = Timber::context();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
if(isset($_GET['sort'])) {
    init_post_views();
    if ($_GET['sort'] == 'recent') {
        $args = array(
            'post_type' => 'post',
//            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged
        );
    } else {
        $args = array(
            'post_type' => 'post',
//            'posts_per_page' => 6,
            'meta_key' => 'wpb_post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'paged' => $paged
        );

    }
    $context['posts'] = new Timber\PostQuery($args);
} else {
    $context['posts'] = new Timber\PostQuery();
}

$templates = array('index.twig');
global $wp;
$context['current_url'] = home_url( $wp->request );
if( isset($_REQUEST["registration"]) && $_REQUEST["registration"]=="true" && isset($_REQUEST["fname"]) && $_REQUEST["fname"]!="" ){
    $context['welcome_message'] ="Welcome to the foundation site.";
} else {
    $context['welcome_message'] ="";
}

$context['cats'] = get_categories();
Timber::render($templates, $context);