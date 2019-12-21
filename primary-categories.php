<?php
namespace Primary_Categories;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
 * Plugin Name: Primary Categories
 * Description: Enables user to select a primary category for posts and custom posts types and display posts based on their primary categories.
 * Plugin URI: http://jacobmckinney.com/primary-categories
 * Author: Jacob McKinney
 * Version: 0.1.0
 * Author URI: http://jacobmckinney.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright 2020 Jacob McKinney
 */

if ( ! class_exists( 'Primary_Categories' ) ) {
    class Primary_Categories {
        /** @var null|Primary_Categories */
        protected static $_instance = null;

        public function __construct() {
            $this->define_constants();
            $this->includes();
        }

        /**
         * Includes plugin files
         */
        public function includes() {
            // include files containing meta box and shortcode
            include PC_PLUGIN_PATH . 'classes/class-pc-meta-box.php';
            include PC_PLUGIN_PATH . 'classes/class-pc-shortcode.php';
        }

        /**
         * Defines plugin constants
         */
        public function define_constants() {
            define( 'PC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
        }

        /**
         * Ensures only one instance of Primary_Categories is loaded or can be loaded.
         *
         * @return Primary_Categories|null
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
     * @return Primary_Categories|null
     * @since  1.0.0
     *
     */
    function primary_categories() {
        return Primary_Categories::instance();
    }

    primary_categories();
}
