<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Elements_Assets {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'frontend_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_assets' ) );
    }

    public function frontend_assets() {
        wp_enqueue_style(
            'ostadi-elements',
            OSTADI_ELEMENTS_URL . 'assets/css/ostadi-elements.css',
            array(),
            OSTADI_ELEMENTS_VERSION
        );
    }

    public function editor_assets() {
        wp_enqueue_style(
            'ostadi-elements-editor',
            OSTADI_ELEMENTS_URL . 'assets/css/ostadi-elements.css',
            array(),
            OSTADI_ELEMENTS_VERSION
        );
    }
}
