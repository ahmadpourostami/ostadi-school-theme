<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Widget_Course_Card extends \Elementor\Widget_Base {
    public function get_name() { return 'ostadi-course-card'; }
    public function get_title() { return 'کارت دوره'; }
    public function get_icon() { return 'eicon-kit-details'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'title', array( 'label' => 'عنوان دوره', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'آموزش جامع طراحی سایت' ) );
        $this->add_control( 'teacher', array( 'label' => 'نام مدرس', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'مدرس دوره' ) );
        $this->add_control( 'price', array( 'label' => 'قیمت', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '۲۹۹٬۰۰۰ تومان' ) );
        $this->add_control( 'level', array( 'label' => 'سطح', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'مقدماتی تا پیشرفته' ) );
        $this->add_control( 'image', array( 'label' => 'تصویر دوره', 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'url', array( 'label' => 'لینک دوره', 'type' => \Elementor\Controls_Manager::URL ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $url = ! empty( $s['url']['url'] ) ? $s['url']['url'] : '#';
        ?>
        <article class="ostadi-course-card">
            <a class="ostadi-course-card__image" href="<?php echo esc_url( $url ); ?>"><?php if ( ! empty( $s['image']['url'] ) ) : ?><img src="<?php echo esc_url( $s['image']['url'] ); ?>" alt="<?php echo esc_attr( $s['title'] ); ?>"><?php endif; ?></a>
            <div class="ostadi-course-card__body"><span class="ostadi-badge"><?php echo esc_html( $s['level'] ); ?></span><h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $s['title'] ); ?></a></h3><p><?php echo esc_html( $s['teacher'] ); ?></p><div class="ostadi-course-card__footer"><strong><?php echo esc_html( $s['price'] ); ?></strong><a href="<?php echo esc_url( $url ); ?>">مشاهده دوره ←</a></div></div>
        </article>
        <?php
    }
}
