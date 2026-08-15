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
        $this->add_control( 'count', array( 'label' => 'تعداد مقاله', 'type' => Controls_Manager::NUMBER, 'min' => 1, 'max' => 12, 'default' => 4 ) );
        $this->add_control( 'columns', array( 'label' => 'تعداد ستون', 'type' => Controls_Manager::SELECT, 'default' => '4', 'options' => array( '2' => '۲', '3' => '۳', '4' => '۴' ) ) );
        $this->add_control( 'category', array( 'label' => 'نامک دسته (اختیاری)', 'type' => Controls_Manager::TEXT ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $args = array( 'post_type' => 'post', 'posts_per_page' => absint( $s['count'] ) );
        if ( ! empty( $s['category'] ) ) $args['category_name'] = sanitize_title( $s['category'] );
        $q = new WP_Query( $args );
        echo '<div class="ostadi-article-grid ostadi-cols-' . esc_attr( $s['columns'] ) . '">';
        while ( $q->have_posts() ) { $q->the_post();
            echo '<article class="ostadi-card ostadi-article-card">';
            if ( has_post_thumbnail() ) echo '<a class="ostadi-card__image" href="' . esc_url( get_permalink() ) . '">' . get_the_post_thumbnail( get_the_ID(), 'large' ) . '</a>';
            echo '<div class="ostadi-card__body"><span class="ostadi-badge">' . esc_html( get_the_category()[0]->name ?? 'آموزش' ) . '</span><h3><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3><p>' . esc_html( wp_trim_words( get_the_excerpt(), 18 ) ) . '</p><div class="ostadi-card__meta"><span>' . esc_html( get_the_date() ) . '</span><span>مطالعه</span></div></div></article>';
        }
        echo '</div>';
        wp_reset_postdata();
    }
}
