<?php

function wst_search_form($form)
{
	$form = '<section class="search"><form role="search" method="get" id="search-form" action="' . home_url('/') . '" >
    <label class="screen-reader-text" for="s">' . __('',  'domain') . '</label>
     <input type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="What are you looking for?" />

     </form></section>';
	return $form;
}

add_filter('get_search_form', 'wst_search_form');




/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function wst_add_slug_body_class($class)
{
	global $post;
	$class[] = $post->post_name . '-page';
	return $class;
}
add_filter('body_class', 'wst_add_slug_body_class');

//Filter search results

function searchfilter($query)
{

	if ($query->is_search && !is_admin()) {
		$query->set('post_type', array('post', 'service'));
	}

	return $query;
}

add_filter('pre_get_posts', 'searchfilter');


//Number of posts in search results
function change_wp_search_size($query)
{
	if ($query->is_search) // Make sure it is a search page
		$query->query_vars['posts_per_page'] = -1;


	return $query; // Return our modified query variables
}
add_filter('pre_get_posts', 'change_wp_search_size'); // Hook our custom function onto the request filter

function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    wpb_set_post_views($post_id);
}
add_action( 'wp_head', 'wpb_track_post_views');

function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}

function select_sort_dropdown($current){
    if(isset($_GET['sort'])) {
        if($current == $_GET['sort'])
            echo 'selected';
    }
}
function select_cat_dropdown($active_cat, $current_cat){
    echo $active_cat .' - '. $current_cat;
    if($active_cat == $current_cat) {
        echo ' selected';
    }
}
function init_post_views(){
    $post_ids = get_posts(array(
        'post_type'     =>'post',
        'fields'        => 'ids',
        'showposts'     => -1
    ));
    foreach($post_ids as $post_id){
        wpb_get_post_views($post_id);
    }
}