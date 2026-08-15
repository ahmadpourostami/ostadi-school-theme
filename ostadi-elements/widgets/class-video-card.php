<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Widget_Video_Card extends \Elementor\Widget_Base {
    public function get_name() { return 'ostadi-video-card'; }
    public function get_title() { return 'کارت ویدئو'; }
    public function get_icon() { return 'eicon-video-camera'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'title', array( 'label' => 'عنوان', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'آموزش طراحی سایت حرفه‌ای' ) );
        $this->add_control( 'description', array( 'label' => 'توضیح کوتاه', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'یک ویدئوی آموزشی برای یادگیری سریع‌تر.' ) );
        $this->add_control( 'image', array( 'label' => 'تصویر بندانگشتی', 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'video_url', array( 'label' => 'لینک ویدئو', 'type' => \Elementor\Controls_Manager::URL ) );
        $this->add_control( 'duration', array( 'label' => 'مدت زمان', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '۱۲:۳۰' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $url = ! empty( $s['video_url']['url'] ) ? $s['video_url']['url'] : '#';
        ?>
        <article class="ostadi-media-card">
            <a class="ostadi-media-card__image" href="<?php echo esc_url( $url ); ?>">
                <?php if ( ! empty( $s['image']['url'] ) ) : ?><img src="<?php echo esc_url( $s['image']['url'] ); ?>" alt="<?php echo esc_attr( $s['title'] ); ?>"><?php endif; ?>
                <span class="ostadi-play" aria-hidden="true">▶</span>
                <?php if ( ! empty( $s['duration'] ) ) : ?><span class="ostadi-duration"><?php echo esc_html( $s['duration'] ); ?></span><?php endif; ?>
            </a>
            <div class="ostadi-media-card__body"><h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $s['title'] ); ?></a></h3><p><?php echo esc_html( $s['description'] ); ?></p></div>
        </article>
        <?php
    }
}
