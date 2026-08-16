<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Podcast_Grid extends Widget_Base {
    public function get_name() { return 'ostadi-podcast-grid'; }
    public function get_title() { return 'شبکه پادکست استادی'; }
    public function get_icon() { return 'eicon-headphones'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'title', array( 'label' => 'عنوان بخش', 'type' => Controls_Manager::TEXT, 'default' => 'پادکست‌های آموزشی' ) );
        $this->add_responsive_control( 'columns', array( 'label' => 'تعداد ستون', 'type' => Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴' ) ) );
        $this->add_control( 'items', array( 'label' => 'اپیزودها', 'type' => Controls_Manager::REPEATER, 'fields' => array(
            array( 'name' => 'title', 'label' => 'عنوان اپیزود', 'type' => Controls_Manager::TEXT, 'default' => 'عنوان اپیزود پادکست' ),
            array( 'name' => 'host', 'label' => 'مدرس / گوینده', 'type' => Controls_Manager::TEXT, 'default' => 'استاد' ),
            array( 'name' => 'image', 'label' => 'کاور', 'type' => Controls_Manager::MEDIA ),
            array( 'name' => 'url', 'label' => 'لینک اپیزود', 'type' => Controls_Manager::URL ),
            array( 'name' => 'duration', 'label' => 'مدت', 'type' => Controls_Manager::TEXT, 'default' => '24:10' ),
        ), 'title_field' => '{{{ title }}}' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style', array( 'label' => 'استایل', 'tab' => Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'gap', array( 'label' => 'فاصله کارت‌ها', 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 24 ), 'selectors' => array( '{{WRAPPER}} .ostadi-podcast-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'radius', array( 'label' => 'گردی کارت', 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'default' => array( 'size' => 18 ), 'selectors' => array( '{{WRAPPER}} .ostadi-podcast-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'accent', array( 'label' => 'رنگ تأکیدی', 'type' => Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ostadi-podcast-card__play' => 'background-color: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $columns = ! empty( $s['columns'] ) ? $s['columns'] : '3';
        echo '<section class="ostadi-podcast-grid-wrap">';
        if ( ! empty( $s['title'] ) ) { echo '<h2 class="ostadi-podcast-grid__title">' . esc_html( $s['title'] ) . '</h2>'; }
        echo '<div class="ostadi-podcast-grid ostadi-cols-' . esc_attr( $columns ) . '">';
        foreach ( (array) $s['items'] as $item ) {
            $title = $item['title'] ?? '';
            $host = $item['host'] ?? '';
            $image = $item['image']['url'] ?? '';
            $url = $item['url']['url'] ?? '#';
            $duration = $item['duration'] ?? '';
            echo '<article class="ostadi-podcast-card ostadi-card">';
            echo '<a class="ostadi-podcast-card__media" href="' . esc_url( $url ) . '">';
            if ( $image ) { echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $title ) . '">'; }
            echo '<span class="ostadi-podcast-card__play" aria-hidden="true">▶</span>';
            if ( $duration ) { echo '<span class="ostadi-podcast-card__duration">' . esc_html( $duration ) . '</span>'; }
            echo '</a><div class="ostadi-card__body">';
            if ( $host ) { echo '<div class="ostadi-card__meta">' . esc_html( $host ) . '</div>'; }
            echo '<h3 class="ostadi-card__title"><a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a></h3></div></article>';
        }
        echo '</div></section>';
    }
}
