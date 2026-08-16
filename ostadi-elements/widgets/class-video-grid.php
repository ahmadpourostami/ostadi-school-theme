<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Video_Grid extends Widget_Base {

    public function get_name() {
        return 'ostadi-video-grid';
    }

    public function get_title() {
        return 'شبکه ویدئو استادی';
    }

    public function get_icon() {
        return 'eicon-video-playlist';
    }

    public function get_categories() {
        return array( 'ostadi' );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content',
            array( 'label' => 'محتوا' )
        );

        $this->add_control(
            'title',
            array(
                'label' => 'عنوان بخش',
                'type' => Controls_Manager::TEXT,
                'default' => 'ویدئوهای آموزشی',
            )
        );

        $this->add_control(
            'count',
            array(
                'label' => 'تعداد ویدئو',
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 24,
                'default' => 6,
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label' => 'تعداد ستون',
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => array(
                    '1' => '۱',
                    '2' => '۲',
                    '3' => '۳',
                    '4' => '۴',
                ),
            )
        );

        $this->add_control(
            'category',
            array(
                'label' => 'دسته‌بندی ویدئو',
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_categories_list(),
            )
        );

        $this->add_control(
            'source',
            array(
                'label' => 'منبع',
                'type' => Controls_Manager::SELECT,
                'default' => 'cpt',
                'options' => array(
                    'cpt' => 'ویدئوهای استادی',
                    'manual' => 'دستی',
                ),
            )
        );

        $this->add_control(
            'manual_items',
            array(
                'label' => 'ویدئوهای دستی',
                'type' => Controls_Manager::REPEATER,
                'fields' => array(
                    array(
                        'name' => 'title',
                        'label' => 'عنوان',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'ویدئوی آموزشی',
                    ),
                    array(
                        'name' => 'image',
                        'label' => 'تصویر',
                        'type' => Controls_Manager::MEDIA,
                    ),
                    array(
                        'name' => 'url',
                        'label' => 'لینک ویدئو',
                        'type' => Controls_Manager::URL,
                    ),
                    array(
                        'name' => 'duration',
                        'label' => 'مدت',
                        'type' => Controls_Manager::TEXT,
                        'default' => '12:30',
                    ),
                ),
                'title_field' => '{{{ title }}}',
                'condition' => array( 'source' => 'manual' ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style',
            array(
                'label' => 'استایل',
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'gap',
            array(
                'label' => 'فاصله کارت‌ها',
                'type' => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range' => array(
                    'px' => array( 'min' => 0, 'max' => 60 ),
                ),
                'default' => array( 'size' => 24 ),
                'selectors' => array(
                    '{{WRAPPER}} .ostadi-video-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'radius',
            array(
                'label' => 'گردی کارت',
                'type' => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range' => array(
                    'px' => array( 'min' => 0, 'max' => 40 ),
                ),
                'default' => array( 'size' => 18 ),
                'selectors' => array(
                    '{{WRAPPER}} .ostadi-video-card' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    private function get_categories_list() {
        $items = array( '' => 'همه دسته‌ها' );
        $terms = get_terms(
            array(
                'taxonomy' => 'ostadi_video_category',
                'hide_empty' => false,
            )
        );

        if ( is_wp_error( $terms ) ) {
            return $items;
        }

        foreach ( $terms as $term ) {
            $items[ $term->term_id ] = $term->name;
        }

        return $items;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = ! empty( $settings['columns'] ) ? $settings['columns'] : '3';
        $source = ! empty( $settings['source'] ) ? $settings['source'] : 'cpt';

        echo '<section class="ostadi-video-grid-wrap">';

        if ( ! empty( $settings['title'] ) ) {
            echo '<h2 class="ostadi-video-grid__title">' . esc_html( $settings['title'] ) . '</h2>';
        }

        echo '<div class="ostadi-video-grid ostadi-cols-' . esc_attr( $columns ) . '">';

        if ( 'manual' === $source ) {
            $manual_items = ! empty( $settings['manual_items'] ) ? $settings['manual_items'] : array();

            foreach ( $manual_items as $item ) {
                $title = isset( $item['title'] ) ? $item['title'] : '';
                $image = isset( $item['image']['url'] ) ? $item['image']['url'] : '';
                $url = isset( $item['url']['url'] ) ? $item['url']['url'] : '#';
                $duration = isset( $item['duration'] ) ? $item['duration'] : '';

                $this->render_item( $title, $image, $url, $duration );
            }
        } else {
            $args = array(
                'post_type' => 'ostadi_video',
                'post_status' => 'publish',
                'posts_per_page' => ! empty( $settings['count'] ) ? absint( $settings['count'] ) : 6,
            );

            if ( ! empty( $settings['category'] ) ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'ostadi_video_category',
                        'field' => 'term_id',
                        'terms' => absint( $settings['category'] ),
                    ),
                );
            }

            $query = new WP_Query( $args );

            while ( $query->have_posts() ) {
                $query->the_post();

                $post_id = get_the_ID();
                $duration = get_post_meta( $post_id, '_ostadi_video_duration', true );
                $url = get_post_meta( $post_id, '_ostadi_video_url', true );

                if ( empty( $url ) ) {
                    $url = get_permalink( $post_id );
                }

                $this->render_item(
                    get_the_title(),
                    get_the_post_thumbnail_url( $post_id, 'large' ),
                    $url,
                    $duration
                );
            }

            wp_reset_postdata();
        }

        echo '</div></section>';
    }

    private function render_item( $title, $image, $url, $duration ) {
        echo '<article class="ostadi-video-card ostadi-card">';
        echo '<a class="ostadi-video-card__media" href="' . esc_url( $url ) . '">';

        if ( $image ) {
            echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $title ) . '">';
        }

        echo '<span class="ostadi-video-card__play" aria-hidden="true">▶</span>';

        if ( $duration ) {
            echo '<span class="ostadi-video-card__duration">' . esc_html( $duration ) . '</span>';
        }

        echo '</a>';
        echo '<div class="ostadi-card__body">';
        echo '<h3 class="ostadi-card__title"><a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a></h3>';
        echo '</div>';
        echo '</article>';
    }
}
