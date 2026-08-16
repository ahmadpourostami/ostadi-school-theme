<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Video_Grid extends Widget_Base {
    public function get_name() { return 'ostadi-video-grid'; }
    public function get_title() { return 'شبکه ویدئو استادی'; }
    public function get_icon() { return 'eicon-video-playlist'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'title', array( 'label' => 'عنوان بخش', 'type' => Controls_Manager::TEXT, 'default' => 'ویدئوهای آموزشی' ) );
        $this->add_control( 'count', array( 'label' => 'تعداد ویدئو', 'type' => Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 6 ) );
        $this->add_responsive_control( 'columns', array( 'label' => 'تعداد ستون', 'type' => Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴' ) ) );
        $this->add_control( 'source', array( 'label' => 'منبع', 'type' => Controls_Manager::SELECT, 'default' => 'posts', 'options' => array( 'posts' => 'نوشته‌ها', 'manual' => 'دستی' ) ) );
        $this->add_control( 'manual_items', array( 'label' => 'ویدئوهای دستی', 'type' => Controls_Manager::REPEATER, 'fields' => array(
            array( 'name' => 'title', 'label' => 'عنوان', 'type' => Controls_Manager::TEXT, 'default' => 'ویدئوی آموزشی' ),
            array( 'name' => 'image', 'label' => 'تصویر', 'type' => Controls_Manager::MEDIA ),
            array( 'name' => 'url', 'label' => 'لینک ویدئو', 'type' => Controls_Manager::URL ),
            array( 'name' => 'duration', 'label' => 'مدت', 'type' => Controls_Manager::TEXT, 'default' => '12:30' ),
        ), 'title_field' => '{{{ title }}}', 'condition' => array( 'source' => 'manual' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style', array( 'label' => 'استایل', 'tab' => Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'gap', array( 'label' => 'فاصله کارت‌ها', 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 24 ), 'selectors' => array( '{{WRAPPER}} .ostadi-video-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'radius', array( 'label' => 'گردی کارت', 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'default' => array( 'size' => 18 ), 'selectors' => array( '{{WRAPPER}} .ostadi-video-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $columns = ! empty( $s['columns'] ) ? $s['columns'] : '3';
        echo '<section class="ostadi-video-grid-wrap">';
        if ( ! empty( $s['title'] ) ) { echo '<h2 class="ostadi-video-grid__title">' . esc_html( $s['title'] ) . '</h2>'; }
        echo '<div class="ostadi-video-grid ostadi-cols-' . esc_attr( $columns ) . '">';
        if ( 'manual' === $s['source'] ) {
            foreach ( (array) $s['manual_items'] as $item ) { $this->render_item( $item['title'] ?? '', $item['image']['url'] ?? '', $item['url']['url'] ?? '#', $item['duration'] ?? '' ); }
        } else {
            $q = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => max( 1, absint( $s['count'] ) ) ) );
            while ( $q->have_posts() ) { $q->the_post(); $this->render_item( get_the_title(), get_the_post_thumbnail_url( get_the_ID(), 'large' ), get_permalink(), 'ویدئو' ); }
            wp_reset_postdata();
        }
        echo '</div></section>';
    }

    private function render_item( $title, $image, $url, $duration ) {
        echo '<article class="ostadi-video-card ostadi-card">';
        echo '<a class="ostadi-video-card__media" href="' . esc_url( $url ) . '">';
        if ( $image ) { echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $title ) . '">'; }
        echo '<span class="ostadi-video-card__play" aria-hidden="true">▶</span>';
        if ( $duration ) { echo '<span class="ostadi-video-card__duration">' . esc_html( $duration ) . '</span>'; }
        echo '</a><div class="ostadi-card__body"><h3 class="ostadi-card__title"><a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a></h3></div></article>';
    }
}
