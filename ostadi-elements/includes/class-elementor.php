<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Elements_Elementor {
    public function __construct() {
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
    }
    public function register_category( $elements_manager ) {
        $elements_manager->add_category( 'ostadi', array('title'=>'المان‌های استادی','icon'=>'fa fa-graduation-cap') );
    }
    public function register_widgets( $widgets_manager ) {
        if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }
        $widgets = array(
            'class-section-heading.php'=>'Ostadi_Widget_Section_Heading',
            'class-article-card.php'=>'Ostadi_Widget_Article_Card',
            'class-article-grid.php'=>'Ostadi_Widget_Article_Grid',
            'class-article-carousel.php'=>'Ostadi_Widget_Article_Carousel',
            'class-category-list.php'=>'Ostadi_Widget_Category_List',
            'class-hero.php'=>'Ostadi_Widget_Hero',
            'class-home-layout.php'=>'Ostadi_Widget_Home_Layout',
            'class-video-card.php'=>'Ostadi_Widget_Video_Card',
            'class-video-grid.php'=>'Ostadi_Widget_Video_Grid',
            'class-video-carousel.php'=>'Ostadi_Widget_Video_Carousel',
            'class-podcast-card.php'=>'Ostadi_Widget_Podcast_Card',
            'class-podcast-grid.php'=>'Ostadi_Widget_Podcast_Grid',
            'class-podcast-carousel.php'=>'Ostadi_Widget_Podcast_Carousel',
            'class-course-card.php'=>'Ostadi_Widget_Course_Card',
            'class-course-carousel.php'=>'Ostadi_Widget_Course_Carousel',
        );
        foreach ( $widgets as $file => $class ) {
            require_once OSTADI_ELEMENTS_DIR . 'widgets/' . $file;
            $widgets_manager->register( new $class() );
        }
    }
}
