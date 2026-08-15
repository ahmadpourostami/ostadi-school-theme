<?php
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Article_Card extends Widget_Base {
    public function get_name() { return 'ostadi-article-card'; }
    public function get_title() { return 'کارت مقاله استادی'; }
    public function get_icon() { return 'eicon-posts-grid'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'post_id', array( 'label' => 'شناسه نوشته', 'type' => Controls_Manager::NUMBER, 'default' => 0 ) );
        $this->add_control( 'show_excerpt', array( 'label' => 'نمایش خلاصه', 'type' => Controls_Manager::SWITCHER, 'default' => 'yes' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $post_id = absint( $s['post_id'] );
        $post = $post_id ? get_post( $post_id ) : get_post();
        if ( ! $post ) return;
        setup_postdata( $post );
        echo '<article class="ostadi-card ostadi-article-card">';
        if ( has_post_thumbnail( $post ) ) echo '<a class="ostadi-card__image" href="' . esc_url( get_permalink( $post ) ) . '">' . get_the_post_thumbnail( $post, 'large' ) . '</a>';
        echo '<div class="ostadi-card__body">';
        $cats = get_the_category( $post->ID );
        if ( ! empty( $cats ) ) echo '<span class="ostadi-badge">' . esc_html( $cats[0]->name ) . '</span>';
        echo '<h3><a href="' . esc_url( get_permalink( $post ) ) . '">' . esc_html( get_the_title( $post ) ) . '</a></h3>';
        if ( 'yes' === $s['show_excerpt'] ) echo '<p>' . esc_html( wp_trim_words( get_the_excerpt( $post ), 20 ) ) . '</p>';
        echo '<div class="ostadi-card__meta"><span>' . esc_html( get_the_date( '', $post ) ) . '</span><span>مطالعه مقاله</span></div>';
        echo '</div></article>';
        wp_reset_postdata();
    }
}
