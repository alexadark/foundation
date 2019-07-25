<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */
global $wp;
$category_id =  get_category( get_query_var( 'cat' ) );

$templates = array('archive.twig', 'index.twig');

$context = Timber::context();

$context['current_url'] = home_url( $wp->request );
$context['active_cat'] = $category_id->slug;

$context['title'] = 'Archive';
if (is_day()) {
	$context['title'] = 'Archive: ' . get_the_date('D M Y');
} else if (is_month()) {
	$context['title'] = 'Archive: ' . get_the_date('M Y');
} else if (is_year()) {
	$context['title'] = 'Archive: ' . get_the_date('Y');
} else if (is_tag()) {
	$context['title'] = single_tag_title('', false);
} else if (is_category()) {
	$context['title'] = single_cat_title('', false);
	array_unshift($templates, 'archive-' . get_query_var('cat') . '.twig');
} else if (is_post_type_archive()) {
	$context['title'] = post_type_archive_title('', false);
	array_unshift($templates, 'archive-' . get_post_type() . '.twig');
}
$term = get_queried_object();
$context['cat_subtitle'] = get_field('category_subtitle', $term);
$context['cats'] = get_categories();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type' => 'post',
    'category_name' => $category_id->slug,
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $paged
);
if(isset($_GET['sort'])) {
    init_post_views();
    echo $category_id->slug;
    if ($_GET['sort'] == 'recent') {

        $args = array(
            'post_type' => 'post',
            'category_name' => $category_id->slug,
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged
        );
    } else {
        $args = array(
            'post_type' => 'post',
            'category_name' => $category_id->slug,
            'meta_key' => 'wpb_post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'paged' => $paged
        );

    }
} else {
//    $context['posts'] = new Timber\PostQuery();
}
    $context['posts'] = new Timber\PostQuery($args);



Timber::render($templates, $context);