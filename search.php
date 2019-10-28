<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$templates = array('search-page.twig', 'archive.twig', 'index.twig');

$context          = Timber::context();
$context['title'] = 'Search results for' . get_search_query();
$context['cats'] = get_categories();


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$query =  array( 's' => get_search_query(),'showposts' => 10, 'paged' => $paged );;

if(isset($_GET['cat'])){
    /*context['cat_url'] = urlencode($_GET['cat']);*/
    $context['active_cat'] = $_GET['cat'];
    $query['category_name']= $_GET['cat'];
}

$context['posts'] = new Timber\PostQuery($query);

Timber::render($templates, $context);