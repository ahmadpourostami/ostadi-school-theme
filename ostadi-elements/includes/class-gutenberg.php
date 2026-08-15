<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Elements_Gutenberg {
    public function __construct() {
        add_action( 'init', array( $this, 'register_blocks' ) );
    }

    public function register_blocks() {
        $blocks = array(
            'section-heading',
            'article-card',
            'article-grid',
            'category-list',
            'hero',
            'video-card',
        );

        foreach ( $blocks as $block ) {
            register_block_type( OSTADI_ELEMENTS_DIR . 'blocks/' . $block );
        }
    }
}
