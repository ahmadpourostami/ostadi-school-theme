<?php
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Article_Grid extends Widget_Base {
    public function get_name() { return 'ostadi-article-grid'; }
    public function get_title() { return 'شبکه مقالات استادی'; }
    public function get_icon() { return 'eicon-posts-grid'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'count', array( 'label' => 'تعداد مقاله', 'type' => Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 6 ) );
        $this->add_responsive_control( 'columns', array( 'label' => 'تعداد ستون', 'type' => Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴' ) ) );
        $this->add_control( 'category', array( 'label' => 'دسته‌بندی', 'type' => Controls_Manager::SELECT2, 'options' => $this->get_categories_list(), 'default' => '' ) );
        $this->add_control( 'show_image', array( 'label' => 'نمایش تصویر', 'type' => Controls_Manager::SWITCHER, 'label_on' => 'بله', 'label_off' => 'خیر', 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_excerpt', array( 'label' => 'نمایش خلاصه', 'type' => Controls_Manager::SWITCHER, 'label_on' => 'بله', 'label_off' => 'خیر', 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_date', array( 'label' => 'نمایش تاریخ', 'type' => Controls_Manager::SWITCHER, 'label_on' => 'بله', 'label_off' => 'خیر', 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style', array( 'label' => 'استایل', 'tab' => Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_radius', array( 'label' => 'گردی کارت', 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .ostadi-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'gap', array( 'label' => 'فاصله کارت‌ها', 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 24 ), 'selectors' => array( '{{WRAPPER}} .ostadi-article-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'badge_color', array( 'label' => 'رنگ برچسب', 'type' => Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ostadi-badge' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    private function get_categories_list() {
        $items = array( '' => 'همه دسته‌ها' );
        foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) { $items[ $cat->term_id ] = $cat->name; }
        return $items;
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $args = array( 'post_type' => 'post', 'posts_per_page' => max( 1, absint( $s['count'] ) ) );
        if ( ! empty( $s['category'] ) ) { $args['cat'] = absint( $s['category'] ); }
        $q = new WP_Query( $args );
        $columns = ! empty( $s['columns'] ) ? $s['columns'] : '3';
        echo '<div class="ostadi-article-grid ostadi-cols-' . esc_attr( $columns ) . '">';
        if ( ! $q->have_posts() ) { echo '<p class="ostadi-elements-note">مقاله‌ای برای نمایش پیدا نشد.</p>'; }
        while ( $q->have_posts() ) { $q->the_post();
            echo '<article class="ostadi-card ostadi-article-card">';
            if ( 'yes' === $s['show_image'] && has_post_thumbnail() ) { echo '<a class="ostadi-card__image" href="' . esc_url( get_permalink() ) . '">' . get_the_post_thumbnail( get_the_ID(), 'large' ) . '</a>'; }
            echo '<div class="ostadi-card__body"><span class="ostadi-badge">' . esc_html( get_the_category()[0]->name ?? 'آموزش' ) . '</span><h3><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
            if ( 'yes' === $s['show_excerpt'] ) { echo '<p>' . esc_html( wp_trim_words( get_the_excerpt(), 18 ) ) . '</p>'; }
            if ( 'yes' === $s['show_date'] ) { echo '<div class="ostadi-card__meta"><span>' . esc_html( get_the_date() ) . '</span><span>مطالعه</span></div>'; }
            echo '</div></article>';
        }
        echo '</div>';
        wp_reset_postdata();
    }
}
