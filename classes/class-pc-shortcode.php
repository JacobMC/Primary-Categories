<?php
namespace Primary_Categories\PC_Shortcode;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class PC_Shortcode
 *
 * Handles the primary-category shortcode
 *
 * @package Primary_Categories\PC_Shortcode
 */
class PC_Shortcode {
    /** @var null|PC_Shortcode */
    protected static $_instance = null;

    /**
     * Hooks into WordPress
     */
    public function init() {
        add_shortcode( 'primary-category', array( $this, 'pc_display' ) );
    }

    /**
     * Handles displaying the shortcode
     *
     * @param $atts
     */
    public function pc_display( $atts ) {
        // Set valid shortcode attributes
    	$a = shortcode_atts( array(
    		'name' => 'uncategorized'
    	), $atts );
    
    	// Set query args to display any post type with a primary category set to name attribute from shortcode
    	$pc_query_args = array( 
    		'post_type'     => 'any', 
    		'meta_key'      => 'primary_category', 
    		'meta_value'    => $a['name'] 
    	);
    
    	// Create custom query
    	$pc_query = new WP_Query( $pc_query_args );
    
    	// Loop through posts returned by query
    	if( $pc_query->have_posts() ) {
    		echo '<ul>';
    	
    		while ( $pc_query->have_posts() ) {
    			$pc_query->the_post();
    			echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    		}
    
    		echo '</ul>';
    	} else {
    	    echo "Sorry, there are no posts with that primary category.";
    	}
    
    	// reset postdata
    	wp_reset_postdata();
    }

    /**
     * Ensures only one instance of PC_Shortcode is loaded or can be loaded.
     *
     * @return PC_Shortcode|null
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
 * @return PC_Shortcode|null
 * @since  1.0.0
 *
 */
function pc_shortcode() {
    return PC_Shortcode::instance();
}

pc_shortcode()->init();