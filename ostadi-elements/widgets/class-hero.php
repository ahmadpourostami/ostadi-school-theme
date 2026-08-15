<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Widget_Hero extends \Elementor\Widget_Base {
    public function get_name() { return 'ostadi-hero'; }
    public function get_title() { return 'هیرو استادی'; }
    public function get_icon() { return 'eicon-banner'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'eyebrow', array( 'label' => 'برچسب', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'مدرسه استادی' ) );
        $this->add_control( 'title', array( 'label' => 'عنوان', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'آموزش حرفه‌ای، ساده و هدفمند' ) );
        $this->add_control( 'description', array( 'label' => 'توضیحات', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'سایت آموزشی خود را با المان‌های آماده و حرفه‌ای بسازید.' ) );
        $this->add_control( 'button_text', array( 'label' => 'متن دکمه', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'شروع یادگیری' ) );
        $this->add_control( 'button_url', array( 'label' => 'لینک دکمه', 'type' => \Elementor\Controls_Manager::URL ) );
        $this->add_control( 'image', array( 'label' => 'تصویر', 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $url = ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '#';
        ?>
        <section class="ostadi-hero">
            <div class="ostadi-hero__content">
                <?php if ( ! empty( $s['eyebrow'] ) ) : ?><span class="ostadi-badge"><?php echo esc_html( $s['eyebrow'] ); ?></span><?php endif; ?>
                <h1><?php echo esc_html( $s['title'] ); ?></h1>
                <p><?php echo esc_html( $s['description'] ); ?></p>
                <?php if ( ! empty( $s['button_text'] ) ) : ?><a class="ostadi-button" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $s['button_text'] ); ?> <span aria-hidden="true">←</span></a><?php endif; ?>
            </div>
            <?php if ( ! empty( $s['image']['url'] ) ) : ?><div class="ostadi-hero__media"><img src="<?php echo esc_url( $s['image']['url'] ); ?>" alt="<?php echo esc_attr( $s['title'] ); ?>"></div><?php endif; ?>
        </section>
        <?php
    }
}
