<?php
/**
 * Plugin Name: Ostadi Elements
 * Description: مجموعه المان‌های رایگان و فارسی/RTL برای ساخت سایت اساتید با Elementor و Gutenberg.
 * Version: 0.2.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Text Domain: ostadi-elements
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'OSTADI_ELEMENTS_VERSION', '0.2.0' );
define( 'OSTADI_ELEMENTS_FILE', __FILE__ );
define( 'OSTADI_ELEMENTS_DIR', plugin_dir_path( __FILE__ ) );
define( 'OSTADI_ELEMENTS_URL', plugin_dir_url( __FILE__ ) );

require_once OSTADI_ELEMENTS_DIR . 'includes/class-assets.php';
require_once OSTADI_ELEMENTS_DIR . 'includes/class-gutenberg.php';
require_once OSTADI_ELEMENTS_DIR . 'includes/class-elementor.php';
require_once OSTADI_ELEMENTS_DIR . 'includes/class-content-types.php';
require_once OSTADI_ELEMENTS_DIR . 'includes/class-media-fields.php';

add_action( 'plugins_loaded', function() {
    new Ostadi_Elements_Assets();
    new Ostadi_Elements_Gutenberg();
    new Ostadi_Elements_Elementor();
    new Ostadi_Elements_Content_Types();
    new Ostadi_Elements_Media_Fields();
} );
