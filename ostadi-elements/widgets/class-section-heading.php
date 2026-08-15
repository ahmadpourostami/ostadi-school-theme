<?php
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Section_Heading extends Widget_Base {
    public function get_name() { return 'ostadi-section-heading'; }
    public function get_title() { return 'عنوان بخش استادی'; }
    public function get_icon() { return 'eicon-heading'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'title', array( 'label' => 'عنوان', 'type' => Controls_Manager::TEXT, 'default' => 'آخرین مطالب آموزشی' ) );
        $this->add_control( 'description', array( 'label' => 'توضیح کوتاه', 'type' => Controls_Manager::TEXTAREA, 'default' => 'یادگیری، رشد و توسعه مهارت‌های شما' ) );
        $this->add_control( 'icon', array( 'label' => 'آیکن', 'type' => Controls_Manager::ICONS ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        echo '<div class="ostadi-section-heading">';
        if ( ! empty( $s['icon']['value'] ) ) { echo '<span class="ostadi-section-heading__icon">'; \Elementor\Icons_Manager::render_icon( $s['icon'], array( 'aria-hidden' => 'true' ) ); echo '</span>'; }
        echo '<div><h2>' . esc_html( $s['title'] ) . '</h2>';
        if ( ! empty( $s['description'] ) ) echo '<p>' . esc_html( $s['description'] ) . '</p>';
        echo '</div></div>';
    }
}
