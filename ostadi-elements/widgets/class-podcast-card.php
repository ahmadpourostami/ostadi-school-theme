<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Widget_Podcast_Card extends \Elementor\Widget_Base {
    public function get_name() { return 'ostadi-podcast-card'; }
    public function get_title() { return 'کارت پادکست'; }
    public function get_icon() { return 'eicon-headphones'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'title', array( 'label' => 'عنوان', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'چطور یک مسیر یادگیری حرفه‌ای بسازیم؟' ) );
        $this->add_control( 'episode', array( 'label' => 'شماره قسمت', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'قسمت ۱۲' ) );
        $this->add_control( 'audio_url', array( 'label' => 'لینک فایل صوتی', 'type' => \Elementor\Controls_Manager::URL ) );
        $this->add_control( 'duration', array( 'label' => 'مدت زمان', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '۱۸ دقیقه' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $url = ! empty( $s['audio_url']['url'] ) ? $s['audio_url']['url'] : '#';
        ?>
        <article class="ostadi-podcast-card">
            <div class="ostadi-podcast-card__icon">♫</div>
            <div class="ostadi-podcast-card__content"><span><?php echo esc_html( $s['episode'] ); ?></span><h3><?php echo esc_html( $s['title'] ); ?></h3><small><?php echo esc_html( $s['duration'] ); ?></small></div>
            <a class="ostadi-podcast-card__play" href="<?php echo esc_url( $url ); ?>" aria-label="پخش پادکست">▶</a>
        </article>
        <?php
    }
}
