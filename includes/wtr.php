<?php
/*
Plugin Name: What to Read Taxonomies
Plugin URI: http://what-to-read-next.com
Description: Create Taxonomies for What to Read.
Version: 0.1
Author: Kim Woodbridge
Author URI: http://kimwoodbridge.com
License: GPL v2 or higher
License URI: License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'book',
    array(
      'labels' => array(
        'name' => __( 'Books' ),
        'singular_name' => __( 'Book' )
      ),
      'public' => true,
      'has_archive' => true,
'supports' => array(
            'title',
            'excerpt',
            'custom-fields',
            'revisions',
            'thumbnail'
        )
    )
  );
}
add_action( 'init', 'create_book_taxonomies', 10 );
// create three taxonomies, genres, series and writers for the post type "book"
function create_book_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Genres' ),
		'all_items'         => __( 'All Genres' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Edit Genre' ),
		'update_item'       => __( 'Update Genre' ),
		'add_new_item'      => __( 'Add New Genre' ),
		'new_item_name'     => __( 'New Genre Name' ),
		'menu_name'         => __( 'Genre' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);
	register_taxonomy( 'genre', array( 'book' ), $args );

 // Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Subgenres', 'taxonomy general name' ),
		'singular_name'              => _x( 'Subgenre', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Subgenres' ),
		'popular_items'              => __( 'Popular Subgenres' ),
		'all_items'                  => __( 'All Subgenres' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Subgenre' ),
		'update_item'                => __( 'Update Subgenre' ),
		'add_new_item'               => __( 'Add New Subgenre' ),
		'new_item_name'              => __( 'New Subgenre Name' ),
		'separate_items_with_commas' => __( 'Separate Subgenres with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Subgenres' ),
		'choose_from_most_used'      => __( 'Choose from the most used Subgenres' ),
		'not_found'                  => __( 'No Subgenres found.' ),
		'menu_name'                  => __( 'Subgenres' ),
	);
	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'subgenre' ),
	);
	register_taxonomy( 'subgenre', 'book', $args );
	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Writers', 'taxonomy general name' ),
		'singular_name'              => _x( 'Writer', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Writers' ),
		'popular_items'              => __( 'Popular Writers' ),
		'all_items'                  => __( 'All Writers' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Writer' ),
		'update_item'                => __( 'Update Writer' ),
		'add_new_item'               => __( 'Add New Writer' ),
		'new_item_name'              => __( 'New Writer Name' ),
		'separate_items_with_commas' => __( 'Separate writers with commas' ),
		'add_or_remove_items'        => __( 'Add or remove writers' ),
		'choose_from_most_used'      => __( 'Choose from the most used writers' ),
		'not_found'                  => __( 'No writers found.' ),
		'menu_name'                  => __( 'Writers' ),
	);
	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writer' ),
	);
	register_taxonomy( 'writer', 'book', $args );
    
    // Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Series', 'taxonomy general name' ),
		'singular_name'              => _x( 'Series', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Series' ),
		'popular_items'              => __( 'Popular Series' ),
		'all_items'                  => __( 'All Series' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Series' ),
		'update_item'                => __( 'Update Series' ),
		'add_new_item'               => __( 'Add New Series' ),
		'new_item_name'              => __( 'New Series Name' ),
		'separate_items_with_commas' => __( 'Separate Series with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Series' ),
		'choose_from_most_used'      => __( 'Choose from the most used Series' ),
		'not_found'                  => __( 'No Series found.' ),
		'menu_name'                  => __( 'Series' ),
	);
	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'series' ),
	);
	register_taxonomy( 'series', 'book', $args );
    
 // Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Awards', 'taxonomy general name' ),
		'singular_name'              => _x( 'Award', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Awards' ),
		'popular_items'              => __( 'Popular Awards' ),
		'all_items'                  => __( 'All Awards' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Awards' ),
		'update_item'                => __( 'Update Awards' ),
		'add_new_item'               => __( 'Add New Award' ),
		'new_item_name'              => __( 'New Award Name' ),
		'separate_items_with_commas' => __( 'Separate Awards with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Awards' ),
		'choose_from_most_used'      => __( 'Choose from the most used Awards' ),
		'not_found'                  => __( 'No Awards found.' ),
		'menu_name'                  => __( 'Awards' ),
	);
	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'award' ),
	);
	register_taxonomy( 'award', 'book', $args );
}

