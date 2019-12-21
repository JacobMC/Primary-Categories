<?php
namespace Primary_Categories\PC_Meta_Box;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class PC_Meta_Box
 *
 * Handles the primary categories meta box
 *
 * @package Primary_Categories\PC_Meta_Box
 */
class PC_Meta_Box {
    /** @var null|PC_Meta_Box */
    protected static $_instance = null;

    /**
     * Hook into WordPress
     */
    public function init() {
        add_action( 'add_meta_boxes', [ $this, 'meta_box' ] );
        add_action( 'save_post', [ $this, 'field_data' ] );
    }

    /**
     * Adds the primary category meta box
     */
    public function meta_box() {
        // Retrieve all post types and add meta box to all post types, including custom post types
    	$post_types = get_post_types();
    
    	foreach ( $post_types as $post_type ) {
    		// Skip the "page" post type
    		if ( $post_type == 'page' ) {
    			continue;
    		}
    
    		add_meta_box (
    			'primary_category',
    			'Primary Category',
    			[ $this, 'meta_box_content' ],
    			$post_type,
    			'side',
    			'high'
    		);
    	}
    }

    /**
     * Adds meta box content
     */
    public function meta_box_content() {
        global $post;

    	$primary_category = '';
    
    	// Retrieve data from primary_category custom field 
    	$current_selected = get_post_meta( $post->ID, 'primary_category', true );
    
    	// Set variable so that select element displays the set primary category on page load
    	if ( $current_selected != '' ) {
    		$primary_category = $current_selected;
    	}
    
    	// Get list of categories associated with post
    	$post_categories = get_the_category();
    
    	$html = '<select name="primary_category" id="primary_category">';
    
    	// Load each associated category into select element and display set primary category on page load
    	foreach( $post_categories as $category ) {
    		$html .= '<option value="' . $category->name . '" ' . selected( $primary_category, $category->name, false ) . '>' . $category->name . '</option>';
    	}
    
    	$html .= '</select>';
    
    	echo $html;
    }

    /**
     * Handles saving meta box data
     */
    public function field_data() {
        global $post;

    	if ( isset( $_POST[ 'primary_category' ] ) ) {
    		$primary_category = sanitize_text_field( $_POST[ 'primary_category' ] );
    		update_post_meta( $post->ID, 'primary_category', $primary_category );
    	}
    }

    /**
     * Ensures only one instance of PC_Meta_Box is loaded or can be loaded.
     *
     * @return PC_Meta_Box|null
     * @since  1.0.0
     *
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}

/**
 * Global function
 *
 * @return PC_Meta_Box|null
 * @since  1.0.0
 *
 */
function pc_meta_box() {
    return PC_Meta_Box::instance();
}

pc_meta_box()->init();