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
        $this->add_control( 'count', array( 'label' => 'تعداد اپیزود', 'type' => Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 6 ) );
        $this->add_responsive_control( 'columns', array( 'label' => 'تعداد ستون', 'type' => Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴' ) ) );
        $this->add_control( 'category', array( 'label' => 'دسته‌بندی پادکست', 'type' => Controls_Manager::SELECT2, 'options' => $this->get_categories_list() ) );
        $this->add_control( 'source', array( 'label' => 'منبع', 'type' => Controls_Manager::SELECT, 'default' => 'cpt', 'options' => array( 'cpt' => 'پادکست‌های استادی', 'manual' => 'دستی' ) ) );
        $this->add_control( 'items', array( 'label' => 'اپیزودهای دستی', 'type' => Controls_Manager::REPEATER, 'fields' => array(
            array( 'name' => 'title', 'label' => 'عنوان اپیزود', 'type' => Controls_Manager::TEXT, 'default' => 'عنوان اپیزود پادکست' ),
            array( 'name' => 'host', 'label' => 'مدرس / گوینده', 'type' => Controls_Manager::TEXT, 'default' => 'استاد' ),
            array( 'name' => 'image', 'label' => 'کاور', 'type' => Controls_Manager::MEDIA ),
            array( 'name' => 'url', 'label' => 'فایل صوتی', 'type' => Controls_Manager::URL ),
            array( 'name' => 'duration', 'label' => 'مدت', 'type' => Controls_Manager::TEXT, 'default' => '24:10' ),
        ), 'title_field' => '{{{ title }}}', 'condition' => array( 'source' => 'manual' ) ) );
        $this->end_controls_section();
        $this->start_controls_section( 'style', array( 'label' => 'استایل', 'tab' => Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'gap', array( 'label' => 'فاصله کارت‌ها', 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 24 ), 'selectors' => array( '{{WRAPPER}} .ostadi-podcast-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'radius', array( 'label' => 'گردی کارت', 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'default' => array( 'size' => 18 ), 'selectors' => array( '{{WRAPPER}} .ostadi-podcast-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'accent', array( 'label' => 'رنگ تأکیدی', 'type' => Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ostadi-podcast-card__play' => 'background-color: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    private function get_categories_list() {
        $items = array( '' => 'همه دسته‌ها' );
        foreach ( get_terms( array( 'taxonomy' => 'ostadi_podcast_category', 'hide_empty' => false ) ) as $term ) {
            if ( ! is_wp_error( $term ) ) { $items[ $term->term_id ] = $term->name; }
        }
        return $items;
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $columns = ! empty( $s['columns'] ) ? $s['columns'] : '3';
        echo '<section class="ostadi-podcast-grid-wrap">';
        if ( ! empty( $s['title'] ) ) { echo '<h2 class="ostadi-podcast-grid__title">' . esc_html( $s['title'] ) . '</h2>'; }
        echo '<div class="ostadi-podcast-grid ostadi-cols-' . esc_attr( $columns ) . '">';

        if ( 'manual' === $s['source'] ) {
            foreach ( (array) $s['items'] as $item ) {
                $this->render_item( $item['title'] ?? '', $item['host'] ?? '', $item['image']['url'] ?? '', $item['url']['url'] ?? '', $item['duration'] ?? '' );
            }
        } else {
            $args = array( 'post_type' => 'ostadi_podcast', 'posts_per_page' => max( 1, absint( $s['count'] ) ) );
            if ( ! empty( $s['category'] ) ) {
                $args['tax_query'] = array( array( 'taxonomy' => 'ostadi_podcast_category', 'field' => 'term_id', 'terms' => absint( $s['category'] ) ) );
            }
            $q = new WP_Query( $args );
            while ( $q->have_posts() ) {
                $q->the_post();
                $duration = get_post_meta( get_the_ID(), '_ostadi_podcast_duration', true );
                $host = get_post_meta( get_the_ID(), '_ostadi_podcast_host', true );
                $url = get_post_meta( get_the_ID(), '_ostadi_podcast_url', true );
                $this->render_item( get_the_title(), $host, get_the_post_thumbnail_url( get_the_ID(), 'large' ), $url, $duration );
            }
            wp_reset_postdata();
        }

        echo '</div></section>';
        $this->render_player_script();
    }

    private function render_item( $title, $host, $image, $url, $duration ) {
        echo '<article class="ostadi-podcast-card ostadi-card">';
        echo '<div class="ostadi-podcast-card__media">';
        if ( $image ) { echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $title ) . '">'; }
        if ( $url ) {
            echo '<button type="button" class="ostadi-podcast-card__play" aria-label="پخش ' . esc_attr( $title ) . '" data-ostadi-podcast-play><span aria-hidden="true">▶</span></button>';
            echo '<audio class="ostadi-podcast-card__audio" preload="none" src="' . esc_url( $url ) . '"></audio>';
        }
        if ( $duration ) { echo '<span class="ostadi-podcast-card__duration">' . esc_html( $duration ) . '</span>'; }
        echo '</div>';
        echo '<div class="ostadi-card__body">';
        if ( $host ) { echo '<div class="ostadi-card__meta">' . esc_html( $host ) . '</div>'; }
        echo '<h3 class="ostadi-card__title">' . esc_html( $title ) . '</h3>';
        echo '</div></article>';
    }

    private function render_player_script() {
        static $printed = false;
        if ( $printed ) { return; }
        $printed = true;
        echo '<script>(function(){if(window.ostadiPodcastPlayerReady)return;window.ostadiPodcastPlayerReady=true;document.addEventListener("click",function(e){var b=e.target.closest("[data-ostadi-podcast-play]");if(!b)return;e.preventDefault();var card=b.closest(".ostadi-podcast-card"),audio=card&&card.querySelector(".ostadi-podcast-card__audio");if(!audio)return;document.querySelectorAll(".ostadi-podcast-card__audio").forEach(function(a){if(a!==audio){a.pause();a.currentTime=0;var ob=a.closest(".ostadi-podcast-card");if(ob){var x=ob.querySelector("[data-ostadi-podcast-play]");if(x)x.classList.remove("is-playing");}}});if(audio.paused){audio.play().then(function(){b.classList.add("is-playing");}).catch(function(){});}else{audio.pause();b.classList.remove("is-playing");}});document.addEventListener("play",function(e){if(!e.target.matches(".ostadi-podcast-card__audio"))return;var c=e.target.closest(".ostadi-podcast-card"),b=c&&c.querySelector("[data-ostadi-podcast-play]");if(b)b.classList.add("is-playing");},true);document.addEventListener("pause",function(e){if(!e.target.matches(".ostadi-podcast-card__audio"))return;var c=e.target.closest(".ostadi-podcast-card"),b=c&&c.querySelector("[data-ostadi-podcast-play]");if(b)b.classList.remove("is-playing");},true);})();</script>';
    }
}
