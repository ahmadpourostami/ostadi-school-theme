<?php
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Category_List extends Widget_Base {
    public function get_name() { return 'ostadi-category-list'; }
    public function get_title() { return 'دسته‌بندی مقالات استادی'; }
    public function get_icon() { return 'eicon-folder-o'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'limit', array( 'label' => 'تعداد دسته', 'type' => Controls_Manager::NUMBER, 'min' => 1, 'max' => 20, 'default' => 6 ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $terms = get_categories( array( 'hide_empty' => true, 'number' => absint( $s['limit'] ) ) );
        echo '<div class="ostadi-category-list">';
        foreach ( $terms as $term ) {
            echo '<a class="ostadi-category-item" href="' . esc_url( get_category_link( $term ) ) . '"><span class="ostadi-category-item__icon">' . esc_html( mb_substr( $term->name, 0, 1 ) ) . '</span><span>' . esc_html( $term->name ) . '</span><strong>' . esc_html( $term->count ) . '</strong></a>';
        }
        echo '</div>';
    }
}
