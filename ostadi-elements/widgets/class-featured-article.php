<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Featured_Article extends \Elementor\Widget_Base {
    public function get_name() { return 'ostadi-featured-article'; }
    public function get_title() { return 'مقاله ویژه استادی'; }
    public function get_icon() { return 'eicon-posts-group'; }
    public function get_categories() { return array( 'ostadi-elements' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'title', array( 'label' => 'عنوان', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'عنوان مقاله ویژه' ) );
        $this->add_control( 'excerpt', array( 'label' => 'توضیح', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'توضیح کوتاه درباره مقاله و محتوای آموزشی آن.' ) );
        $this->add_control( 'image', array( 'label' => 'تصویر', 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'badge', array( 'label' => 'برچسب', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ویژه' ) );
        $this->add_control( 'button_text', array( 'label' => 'متن دکمه', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'مطالعه مقاله' ) );
        $this->add_control( 'link', array( 'label' => 'لینک', 'type' => \Elementor\Controls_Manager::URL ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $image = ! empty( $s['image']['url'] ) ? $s['image']['url'] : '';
        $link = ! empty( $s['link']['url'] ) ? $s['link']['url'] : '#';
        ?>
        <article class="ostadi-featured-article">
            <div class="ostadi-featured-article__media">
                <?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $s['title'] ); ?>"><?php endif; ?>
                <?php if ( $s['badge'] ) : ?><span class="ostadi-badge ostadi-featured-article__badge"><?php echo esc_html( $s['badge'] ); ?></span><?php endif; ?>
            </div>
            <div class="ostadi-featured-article__body">
                <h3><?php echo esc_html( $s['title'] ); ?></h3>
                <p><?php echo esc_html( $s['excerpt'] ); ?></p>
                <a class="ostadi-button" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $s['button_text'] ); ?></a>
            </div>
        </article>
        <?php
    }
}
