<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Elements_Elementor {
    public function __construct() {
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
    }

    public function register_category( $elements_manager ) {
        $elements_manager->add_category( 'ostadi', array(
            'title' => 'المان‌های استادی',
            'icon'  => 'fa fa-graduation-cap',
        ) );
    }

    public function register_widgets( $widgets_manager ) {
        if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

        require_once OSTADI_ELEMENTS_DIR . 'widgets/class-section-heading.php';
        require_once OSTADI_ELEMENTS_DIR . 'widgets/class-article-card.php';
        require_once OSTADI_ELEMENTS_DIR . 'widgets/class-article-grid.php';
        require_once OSTADI_ELEMENTS_DIR . 'widgets/class-category-list.php';

        $widgets_manager->register( new Ostadi_Widget_Section_Heading() );
        $widgets_manager->register( new Ostadi_Widget_Article_Card() );
        $widgets_manager->register( new Ostadi_Widget_Article_Grid() );
        $widgets_manager->register( new Ostadi_Widget_Category_List() );
    }
}
