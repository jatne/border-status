<?php

namespace border_status\Vendor;

if ( ! class_exists( '\border_status\Vendor\Vendor' ) ) {

    class Loader {

        private static $_instance;

        /**
         * Create and return instance
         *
         * @return Loader
         */
        public static function instance() {
            if ( null === self::$_instance ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Class constructor
         *
         * @return void
         */
        public function __construct() {
            self::$_instance = $this;

            $this->init();
        }

        /**
         * Class initialization
         *
         * @return void
         */
        public function init() {
            $this->loadACF();
        }

        /**
         * Checking if ACF is active, if not adding included version
         *
         * @return void
         */
        private function loadACF() {
          if ( !\class_exists( '\ACF' ) ) {
            // Define path and URL to the ACF plugin.
            define( 'WPK_ACF_PATH', get_stylesheet_directory() . '/includes/acf/' );
            define( 'WPK_ACF_URL', get_stylesheet_directory_uri() . '/includes/acf/' );

            // Include the ACF plugin.
            include_once( WPK_ACF_PATH . 'acf.php' );
          }
        }

    } /* end class */

} /* end if class_exists */
