<?php

/*

Plugin Name: What to Read Next Custom Meta Boxes

Plugin URI: http://what-to-read-next.com

Description: Create Meta Boxes for What to Read Next.

Version: 0.1

Author: Kim Woodbridge

Author URI: http://kimwoodbridge.com

License: GPL v2 or higher

License URI: License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/



/**

 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!

 */



// Plugin Folder Path
if ( ! defined( 'WTR_PLUGIN_DIR' ) ) {
	define( 'WTR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

}

define( 'WTR_PLUGIN_DIR', dirname( __FILE__ ) );

if ( ! defined( 'WTR_PLUGIN_URL' ) ) {
	define( 'WTR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

define( 'WTR_PLUGIN_FILE', WTR_ROOT_PATH . 'cmb.php' );

if ( !defined( 'ABSPATH' ) ) {
    wp_die( __( "Sorry, you are not allowed to access this page directly.", 'WTR' ) );
}

/*register_activation_hook( __FILE__, 'wtr_activation_check' );
function wtr_activation_check() {

    $latest = '1.8';

    $theme_info = get_theme_data( TEMPLATEPATH . '/style.css' );

    if ( basename( TEMPLATEPATH ) != 'genesis' ) {
        deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate ourself
        wp_die( sprintf( __( 'Sorry, you can\'t activate unless you have installed %1$sGenesis%2$s', 'WTR' ), '', '' ) );
    }

    
}
*/

add_action( 'wp_enqueue_scripts', 'WTR_register_styles', 15 );
function WTR_register_styles() {
	wp_register_style( 'WTR-styles', WTR_PLUGIN_URL .  'includes/style.css' ) ;
	wp_enqueue_style( 'WTR-styles' );
}

require_once WTR_PLUGIN_DIR . 'includes/wtr.php';
require_once WTR_PLUGIN_DIR . 'includes/functions.php';
require_once( ABSPATH . 'wp-admin/includes/template.php' );


if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}





add_action( 'cmb2_admin_init', 'wtr_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function wtr_register_demo_metabox() {
	$prefix = 'wtr_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Book Information', 'cmb2' ),
		'object_types'  => array( 'book', ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_demo->add_field( array(
		'name'    => __( 'Summary', 'cmb2' ),
		'desc'    => __( 'Summary of Book', 'cmb2' ),
		'id'      => $prefix . 'summary',
		'type'    => 'wysiwyg',
		'options' => array( 'textarea_rows' => 5, ),
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Price', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix . 'price',
		'type' => 'text_money',
       
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'ISBN', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix . 'ISBN',
		'type' => 'text_medium',
		// 'repeatable' => true,
	) );

	

                $cmb_demo->add_field( array(
		'name' => __( 'Publisher', 'cmb2' ),
		'desc' => __( '', 'cmb2' ),
		'id'   => $prefix . 'publisher',
		'type' => 'text_medium',
		// 'repeatable' => true,
	) );
$cmb_demo->add_field( array(
		'name' => __( 'Year of Publication', 'cmb2' ),
		'desc' => __( 'Year of Publication', 'cmb2' ),
		'id'   => $prefix . 'pubdate',
		'type' => 'text_small',
		// 'repeatable' => true,
	) );	
    
$cmb_demo->add_field( array(
		'name' => __( 'Show Goodreads Reviews', 'cmb2' ),
		'desc' => __( 'Show Reviews from Goodreads below image', 'cmb2' ),
		'id'   => $prefix . 'goodreads',
		'type' => 'checkbox',
	) );    
$cmb_demo->add_field( array(
    'name'       => __( 'Date Read', 'cmb2' ),
    'id'         => $prefix . 'dateread',
    'type'       => 'text_date',
'date_format'  => 'M j, Y',
    'attributes' => array(
        // CMB2 checks for datepicker override data here:
        'data-datepicker' => json_encode( array(
            'yearRange' => '1990:'. ( date( 'Y' ) + 10 ),
        ) ),
    ),
) );

$cmb_demo->add_field( array(
		'name' => __( 'My Rating', 'cmb2' ),
		'desc' => __( 'My Rating', 'cmb2' ),
		'id'   => $prefix . 'myrating',
		'type' => 'text_small',
		// 'repeatable' => true,
	) );	

$cmb_demo->add_field( array(
        'name'    => 'Amazon',
        'id'      => 'amazon_status',
        'type'    => 'checkbox',
        
    ) );

$cmb_demo->add_field( array(
        'name'    => 'Indiebound',
        'id'      => 'indie_status',
        'type'    => 'checkbox',
        
    ) );
$cmb_demo->add_field( array(
        'name'    => 'Ebay',
        'id'      => 'ebay_status',
        'type'    => 'checkbox',
        
    ) );

    /**
     * Metabox to conditionally display if the 'status' is set to 'External'.
     */
    $cmb_demo = new_cmb2_box( array(
        'id'           => 'affiliate_conditonal_metabox',
        'title'        => 'Amazon Info',
        'object_types' => array( 'book', ), // Post type
        'show_on_cb' => 'cmb_only_show_for_amazon', // function should return a bool value
    ) );

    $cmb_demo->add_field( array(
        'name'       => 'Link',
        'id'         => 'amazon_url',
        'type'       => 'hidden',
'default' => 'http://www.amazon.com/dp/',
    ) );
 $cmb_demo->add_field( array(
        'name'       => 'Image',
        'id'         => 'amazon_image',
        'type'       => 'file',
'default' => plugins_url( 'images/Amazon49.png' , __FILE__ ),
    ) );
$cmb_demo->add_field( array(
        'name'       => 'ID',
        'id'         => 'amazon_id',
        'type'       => 'text_medium',
'default' => 'projectself-20',
    ) );


/**
 * Only display a metabox if the page's 'status' is 'on'
 * @param  object $cmb CMB2 object
 * @return bool        True/false whether to show the metabox
 */
function cmb_only_show_for_amazon( $cmb_demo ) {
    $status = get_post_meta( $cmb_demo->object_id(), 'amazon_status', 1 );

    // Only show if status is 'on'
    if ($status){
return $status;}
}

$cmb_demo = new_cmb2_box( array(
        'id'           => 'affiliate_conditonal_metabox2',
        'title'        => 'Indie Info',
        'object_types' => array( 'book', ), // Post type
        'show_on_cb' => 'cmb_only_show_for_indiebound', // function should return a bool value
    ) );

    $cmb_demo->add_field( array(
        'name'       => 'Link',
        'id'         => 'indie_url',
        'type'       => 'hidden',
'default' => 'http://www.indiebound.org/book/',
    ) );
 $cmb_demo->add_field( array(
        'name'       => 'Image',
        'id'         => 'indie_image',
        'type'       => 'file',
'default' => plugins_url( 'images/IB-red_49x29.png' , __FILE__ ),
    ) );
$cmb_demo->add_field( array(
        'name'       => 'ID',
        'id'         => 'indie_id',
        'type'       => 'text_medium',
'default' => 'kwbridge',
    ) );




/**
 * Only display a metabox if the page's 'status' is 'on'
 * @param  object $cmb CMB2 object
 * @return bool        True/false whether to show the metabox
 */
function cmb_only_show_for_indiebound( $cmb_demo ) {
    $status2 = get_post_meta( $cmb_demo->object_id(), 'indie_status', 1 );

    // Only show if status is 'on'
    if ($status2){
return $status2;}
}

$cmb_demo = new_cmb2_box( array(
        'id'           => 'affiliate_conditonal_metabox3',
        'title'        => 'Ebay Info',
        'object_types' => array( 'book', ), // Post type
        'show_on_cb' => 'cmb_only_show_for_ebay', // function should return a bool value
    ) );

    $cmb_demo->add_field( array(
        'name'       => 'Link',
        'id'         => 'ebay_url',
        'type'       => 'text',
'default' => '',
    ) );
 $cmb_demo->add_field( array(
        'name'       => 'Image',
        'id'         => 'ebay_image',
        'type'       => 'file',
'default' => plugins_url( 'images/ebay_logo.png' , __FILE__ ),
    ) );
$cmb_demo->add_field( array(
        'name'       => 'ID',
        'id'         => 'ebay_id',
        'type'       => 'hidden',
'default' => 'kwbridge',
    ) );




/**
 * Only display a metabox if the page's 'status' is 'on'
 * @param  object $cmb CMB2 object
 * @return bool        True/false whether to show the metabox
 */
function cmb_only_show_for_ebay( $cmb_demo ) {
    $status3 = get_post_meta( $cmb_demo->object_id(), 'ebay_status', 1 );

    // Only show if status is 'on'
    if ($status3){
return $status3;}
}

// BUYLINKS
/*

	$cmb_group  = new_cmb2_box( array(

		'id'            => 'wtr_buylinks_metabox',

		'title'         => _x('Affiliate Links', 'noun: URLs to book retailers', 'cmb2'),

		'object_types'  => array( 'book', ), // Post type

		'context'       => 'side',

		'priority'      => 'default',	

		'show_names'    => true, // Show field names on the left

		)

	);

		

	$cmb_group->add_field( array(

			'id'          => '_wtr_buylinks',

			'type'        => 'group',

			'description' => __('Add links where readers can purchase your book', 'cmb2'),

			'options'     => array(

				'group_title'   => _x('Affiliate Link', 'noun', 'cmb2') . ' {#}', // {#} gets replaced by row number

				'add_button'    => __('Add Affiliate Link', 'cmb2'),

				'remove_button' => __('Remove Affiliate', 'cmb2'),

				'sortable'      => true, // beta

			),

		)

	);

	

	$cmb_group->add_group_field( '_wtr_buylinks', array(

			'name'    => __('Affiliate', 'cmb2'),

			'id'      => '_wtr_retailerID',

			'type'    => 'select',

			'options'          => array('Amazon' => __( 'Amazon', 'cmb2' ),
'IndieBound'   => __( 'IndieBound', 'cmb2' ),)
          
	) );

$cmb_group->add_group_field( '_wtr_buylinks', array(

			'name'	=> _x('Link', 'noun: URL', 'cmb2'),

			'id'	=> '_wtr_buylink',

			'type'	=> 'text_url',

			'desc' => 'http://www.someWebsite.com/',
                        
	
 

			

		)

	);


  
    $cmb_group->add_group_field( '_wtr_buylinks', array(

			'name'	=> _x('Affiliate Image', 'cmb2'),

			'id'	=> '_wtr_image',

			'type'    => 'file',

			   
	) );
  
   */
$cmb_group  = apply_filters('wtr_buylinks_metabox', $cmb_group );
    
 
}

function save_book_meta( $post_id, $post, $update ) {

    /*
     * In production code, $slug should be set only once in the plugin,
     * preferably as a class property, rather than in each function that needs it.
     */
    $slug = 'book';

    // If this isn't a 'book' post, don't update it.
    if ( $slug != $post->post_type ) {
        return;
    }

    // - Update the post's metadata.

    if ( isset( $_REQUEST['amazon_url'] ) ) {
        update_post_meta( $post_id, 'amazon_url', sanitize_text_field( $_REQUEST['amazon_url'] ) );
    }

    if ( isset( $_REQUEST['amazon_id'] ) ) {
        update_post_meta( $post_id, 'amazon_id', sanitize_text_field( $_REQUEST['amazon_id']) );
    }
	 if ( isset( $_REQUEST['amazon_image'] ) ) {
        update_post_meta( $post_id, 'amazon_image', sanitize_text_field( $_REQUEST['amazon_image']) );
    }
	if ( isset( $_REQUEST['indie_url'] ) ) {
        update_post_meta( $post_id, 'indie_url', sanitize_text_field( $_REQUEST['indie_url']) );
    }

    if ( isset( $_REQUEST['indie_id'] ) ) {
        update_post_meta( $post_id, 'indie_id', sanitize_text_field( $_REQUEST['indie_id']) );
    }
	 if ( isset( $_REQUEST['indie_image'] ) ) {
        update_post_meta( $post_id, 'indie_image', sanitize_text_field( $_REQUEST['indie_image']) );
    }
if ( isset( $_REQUEST['ebay_url'] ) ) {
        update_post_meta( $post_id, 'indie_url', sanitize_text_field( $_REQUEST['indie_url']) );
    }

    if ( isset( $_REQUEST['ebay_id'] ) ) {
        update_post_meta( $post_id, 'indie_id', sanitize_text_field( $_REQUEST['indie_id']) );
    }
	 if ( isset( $_REQUEST['ebay_image'] ) ) {
        update_post_meta( $post_id, 'indie_image', sanitize_text_field( $_REQUEST['indie_image']) );
    }

    // Checkboxes are present if checked, absent if not.
    if ( isset( $_REQUEST['amazon_status'] ) ) {
        update_post_meta( $post_id, 'amazon_status', TRUE );
    } else {
        update_post_meta( $post_id, 'amazon_status', FALSE );
    }
	
	// Checkboxes are present if checked, absent if not.
    if ( isset( $_REQUEST['indie_status'] ) ) {
        update_post_meta( $post_id, 'indie_status', TRUE );
    } else {
        update_post_meta( $post_id, 'indie_status', FALSE );
    }
// Checkboxes are present if checked, absent if not.
    if ( isset( $_REQUEST['ebay_status'] ) ) {
        update_post_meta( $post_id, 'ebay_status', TRUE );
    } else {
        update_post_meta( $post_id, 'ebay_status', FALSE );
    }
}
add_action( 'save_post', 'save_book_meta', 10, 3 );