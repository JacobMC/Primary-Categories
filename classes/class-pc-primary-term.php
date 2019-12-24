<?php
namespace Primary_Categories\PC_Primary_Term;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class PC_Primary_Term
 *
 * Handles the primary categories meta box
 *
 * @package Primary_Categories\PC_Prim`ary_Term
 */
class PC_Primary_Term {
    /** @var null|PC_Primary_Term */
    protected static $_instance = null;

    /**
     * Hook into WordPress
     */
    public function init() {}

    /**
     * Ensures only one instance of PC_Primary_Term is loaded or can be loaded.
     *
     * @return PC_Primary_Term|null
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
 * @return PC_Primary_Term|null
 * @since  1.0.0
 *
 */
function pc_primary_term() {
    return PC_Primary_Term::instance();
}

pc_primary_term()->init();