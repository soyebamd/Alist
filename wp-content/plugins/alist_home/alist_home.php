<?php
/**
* Plugin Name: AList Custom Posts
* Plugin URI: http://elegantthemes.com/
* Description: ALIST Custom Post Types.
* Version: 1.0
* Author: Kingtide
* Author URI: https://wordpress.org/
**/

// ALIST Custom Post Types
 

// Alist Home page 
function register_cpt_alist_home_review() {
 
    $labels = array(
        'name' => _x( 'AList_Home', 'alist_home' ),
        'singular_name' => _x( 'AList_Home', 'alist_home' ),
        'add_new' => _x( 'Add New', 'alist_home' ),
        'add_new_item' => _x( 'Add New AList_Home', 'alist_home' ),
        'edit_item' => _x( 'Edit AList_Home Review', 'alist_home' ),
        'new_item' => _x( 'New AList_Home Review', 'alist_home' ),
        'view_item' => _x( 'View AList_Home Review', 'alist_home' ),
        'search_items' => _x( 'Search AList_Home Reviews', 'alist_home' ),
        'not_found' => _x( 'No AList_Home reviews found', 'alist_home' ),
        'not_found_in_trash' => _x( 'No AList_Home reviews found in Trash', 'alist_home' ),
        'parent_item_colon' => _x( 'Parent AList_Home Review:', 'alist_home' ),
        'menu_name' => _x( 'AList Home', 'alist_home' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'alist_home reviews filterable by genre',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-home',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'alist_home', $args );
}
 
add_action( 'init', 'register_cpt_alist_home_review' );
 
/*************** Parents_Students ***************/
function register_cpt_parents_students_review() {
 
    $labels = array(
        'name' => _x( 'Parents_Students', 'parents_students' ),
        'singular_name' => _x( 'Parents_Students', 'parents_students' ),
        'add_new' => _x( 'Add New', 'parents_students' ),
        'add_new_item' => _x( 'Add New Parents_Students', 'parents_students' ),
        'edit_item' => _x( 'Edit Parents_Students Review', 'parents_students' ),
        'new_item' => _x( 'New Parents_Students Review', 'parents_students' ),
        'view_item' => _x( 'View Parents_Students Review', 'parents_students' ),
        'search_items' => _x( 'Search Parents_Students Reviews', 'parents_students' ),
        'not_found' => _x( 'No Parents_Students reviews found', 'parents_students' ),
        'not_found_in_trash' => _x( 'No Parents_Students reviews found in Trash', 'parents_students' ),
        'parent_item_colon' => _x( 'Parent Parents_Students Review:', 'parents_students' ),
        'menu_name' => _x( 'Parents & Students', 'parents_students' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'parents_students reviews filterable by genre',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-users',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'parents_students', $args );
}
 
add_action( 'init', 'register_cpt_parents_students_review' );

/*************** Schools_Nonprofits ***************/
function register_cpt_schools_nonprofits_review() {
 
    $labels = array(
        'name' => _x( 'Schools_Nonprofits', 'schools_nonprofits' ),
        'singular_name' => _x( 'Schools_Nonprofits', 'schools_nonprofits' ),
        'add_new' => _x( 'Add New', 'Schools_Nonprofits' ),
        'add_new_item' => _x( 'Add New Schools_Nonprofits', 'schools_nonprofits' ),
        'edit_item' => _x( 'Edit Schools_Nonprofits Review', 'schools_nonprofits' ),
        'new_item' => _x( 'New Schools_Nonprofits Review', 'schools_nonprofits' ),
        'view_item' => _x( 'View Schools_Nonprofits Review', 'schools_nonprofits' ),
        'search_items' => _x( 'Search Schools_Nonprofits Reviews', 'schools_nonprofits' ),
        'not_found' => _x( 'No Schools_Nonprofits reviews found', 'schools_nonprofits' ),
        'not_found_in_trash' => _x( 'No Schools_Nonprofits reviews found in Trash', 'schools_nonprofits' ),
        'parent_item_colon' => _x( 'Parent Schools_Nonprofits Review:', 'schools_nonprofits' ),
        'menu_name' => _x( 'Schools & Nonprofits', 'schools_nonprofits' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Schools_Nonprofits reviews filterable by genre',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-tools',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'schools_nonprofits', $args );
}
 
add_action( 'init', 'register_cpt_schools_nonprofits_review' );


/*************** Training_Consulting ***************/
function register_cpt_training_consulting_review() {
 
    $labels = array(
        'name' => _x( 'Training_Consulting', 'training_consulting' ),
        'singular_name' => _x( 'Training_Consulting', 'training_consulting' ),
        'add_new' => _x( 'Add New', 'Training_Consulting' ),
        'add_new_item' => _x( 'Add New Training_Consulting', 'training_consulting' ),
        'edit_item' => _x( 'Edit Training_Consulting Review', 'training_consulting' ),
        'new_item' => _x( 'New Training_Consulting Review', 'training_consulting' ),
        'view_item' => _x( 'View Training_Consulting Review', 'training_consulting' ),
        'search_items' => _x( 'Search Training_Consulting Reviews', 'training_consulting' ),
        'not_found' => _x( 'No Training_Consulting reviews found', 'training_consulting' ),
        'not_found_in_trash' => _x( 'No Training_Consulting reviews found in Trash', 'training_consulting' ),
        'parent_item_colon' => _x( 'Parent Training_Consulting Review:', 'training_consulting' ),
        'menu_name' => _x( 'Training & Consulting', 'training_consulting' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'training_consulting reviews filterable by genre',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-settings',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'training_consulting', $args );
}
 
add_action( 'init', 'register_cpt_training_consulting_review' );

/*************** AList_Locations ***************/

function register_cpt_alist_locations_review() {
 
    $labels = array(
        'name' => _x( 'AList_Locations', 'alist_locations' ),
        'singular_name' => _x( 'AList_Locations', 'alist_locations' ),
        'add_new' => _x( 'Add New', 'AList_Locations' ),
        'add_new_item' => _x( 'Add New AList_Locations', 'alist_locations' ),
        'edit_item' => _x( 'Edit AList_Locations Review', 'alist_locations' ),
        'new_item' => _x( 'New AList_Locations Review', 'alist_locations' ),
        'view_item' => _x( 'View AList_Locations Review', 'alist_locations' ),
        'search_items' => _x( 'Search AList_Locations Reviews', 'alist_locations' ),
        'not_found' => _x( 'No AList_Locations reviews found', 'alist_locations' ),
        'not_found_in_trash' => _x( 'No AList_Locations reviews found in Trash', 'alist_locations' ),
        'parent_item_colon' => _x( 'Parent AList_Locations Review:', 'alist_locations' ),
        'menu_name' => _x( 'AList Locations', 'alist_locations' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'alist_locations reviews filterable by genre',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-media',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'alist_locations', $args );
}
 
add_action( 'init', 'register_cpt_alist_locations_review' );

/*************** AList_Cities ***************/

function register_cpt_alist_cities_review() {
 
    $labels = array(
        'name' => _x( 'AList_City', 'alist_city' ),
        'singular_name' => _x( 'AList_City', 'alist_city' ),
        'add_new' => _x( 'Add New', 'alist_city' ),
        'add_new_item' => _x( 'Add New AList_City', 'alist_city' ),
        'edit_item' => _x( 'Edit AList_City Review', 'alist_city' ),
        'new_item' => _x( 'New AList_City Review', 'alist_city' ),
        'view_item' => _x( 'View AList_City Review', 'alist_city' ),
        'search_items' => _x( 'Search AList_City Reviews', 'alist_city' ),
        'not_found' => _x( 'No AList_City reviews found', 'alist_city' ),
        'not_found_in_trash' => _x( 'No AList_City reviews found in Trash', 'alist_city' ),
        'parent_item_colon' => _x( 'Parent AList_City Review:', 'alist_city' ),
        'menu_name' => _x( 'AList Cities', 'alist_city' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'alist_city reviews filterable by genre',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-media',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'alist_city', $args );
}
 
add_action( 'init', 'register_cpt_alist_cities_review' );
