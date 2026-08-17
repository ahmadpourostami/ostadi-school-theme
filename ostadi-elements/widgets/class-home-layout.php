<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Widget_Home_Layout extends \Elementor\Widget_Base {
    public function get_name() { return 'ostadi-home-layout'; }
    public function get_title() { return 'صفحه اصلی استادی'; }
    public function get_icon() { return 'eicon-home'; }
    public function get_categories() { return array( 'ostadi' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'محتوا' ) );
        $this->add_control( 'title', array( 'label' => 'عنوان اصلی', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'جدیدترین مقالات آموزشی' ) );
        $this->add_control( 'subtitle', array( 'label' => 'زیرعنوان', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'دانش، مهارت و تجربه را از بهترین منابع بیاموزید' ) );
        $this->add_control( 'hero_image', array( 'label' => 'تصویر مقاله ویژه', 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'hero_title', array( 'label' => 'عنوان مقاله ویژه', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'چگونه با وردپرس یک سایت حرفه‌ای بسازیم؟' ) );
        $this->add_control( 'hero_excerpt', array( 'label' => 'توضیح مقاله ویژه', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'در این مقاله با مراحل کامل راه‌اندازی سایت با وردپرس آشنا می‌شوید.' ) );
        $this->end_controls_section();
    }

    private function posts( $args = array() ) {
        return new WP_Query( wp_parse_args( $args, array( 'post_type' => 'post', 'posts_per_page' => 4, 'post_status' => 'publish' ) ) );
    }

    private function card( $post ) {
        $image = get_the_post_thumbnail_url( $post, 'medium_large' );
        $cat = get_the_category( $post->ID );
        $cat_name = ! empty( $cat ) ? $cat[0]->name : 'آموزش';
        ob_start(); ?>
        <article class="ostadi-home-card">
            <?php if ( $image ) : ?><a class="ostadi-home-card__image" href="<?php echo esc_url( get_permalink( $post ) ); ?>"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $post ) ); ?>"></a><?php endif; ?>
            <div class="ostadi-home-card__body">
                <span class="ostadi-badge"><?php echo esc_html( $cat_name ); ?></span>
                <h3><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></h3>
                <p><?php echo esc_html( wp_trim_words( get_the_excerpt( $post ), 16 ) ); ?></p>
                <div class="ostadi-home-card__meta"><span><?php echo esc_html( get_the_date( '', $post ) ); ?></span><span>مطالعه مقاله ←</span></div>
            </div>
        </article>
        <?php return ob_get_clean();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $latest = $this->posts( array( 'posts_per_page' => 6 ) );
        $popular = $this->posts( array( 'posts_per_page' => 3, 'orderby' => 'comment_count' ) );
        $newest = $this->posts( array( 'posts_per_page' => 4 ) );
        $hero_post = $latest->have_posts() ? $latest->posts[0] : null;
        $hero_image = ! empty( $s['hero_image']['url'] ) ? $s['hero_image']['url'] : ( $hero_post ? get_the_post_thumbnail_url( $hero_post, 'large' ) : '' );
        $hero_title = ! empty( $s['hero_title'] ) ? $s['hero_title'] : ( $hero_post ? get_the_title( $hero_post ) : '' );
        $hero_link = $hero_post ? get_permalink( $hero_post ) : '#';
        ?>
        <div class="ostadi-home-layout" dir="rtl">
            <header class="ostadi-home-heading">
                <div class="ostadi-home-heading__icon">▣</div>
                <h1><?php echo esc_html( $s['title'] ); ?></h1>
                <p><?php echo esc_html( $s['subtitle'] ); ?></p>
            </header>
            <section class="ostadi-home-top">
                <div class="ostadi-home-feature">
                    <div class="ostadi-home-feature__media">
                        <?php if ( $hero_image ) : ?><img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( $hero_title ); ?>"><?php endif; ?>
                        <span class="ostadi-badge">آموزش وردپرس</span>
                    </div>
                    <div class="ostadi-home-feature__body">
                        <span class="ostadi-badge">آموزش طراحی سایت</span>
                        <h2><?php echo esc_html( $hero_title ); ?></h2>
                        <p><?php echo esc_html( $s['hero_excerpt'] ); ?></p>
                        <div class="ostadi-home-feature__meta"><span>۸ دقیقه مطالعه</span><span>۱۲ مرداد ۱۴۰۳</span><span>احمد پوراستمی</span></div>
                        <a class="ostadi-button" href="<?php echo esc_url( $hero_link ); ?>">ادامه مطلب ←</a>
                    </div>
                </div>
                <aside class="ostadi-home-popular">
                    <div class="ostadi-home-section-title"><h2>محبوب‌ترین مطالب</h2><span>♨</span></div>
                    <?php while ( $popular->have_posts() ) : $popular->the_post(); $img = get_the_post_thumbnail_url( get_the_ID(), 'medium' ); ?>
                        <a class="ostadi-home-popular__item" href="<?php the_permalink(); ?>">
                            <?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt=""><?php endif; ?>
                            <span><strong><?php the_title(); ?></strong><small><?php echo esc_html( get_the_date() ); ?></small></span>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </aside>
            </section>
            <nav class="ostadi-home-filters" aria-label="دسته‌بندی مقالات">
                <span>نمایش:</span><a class="is-active" href="#latest">همه</a><a href="#latest">طراحی سایت</a><a href="#latest">برنامه‌نویسی</a><a href="#latest">هوش مصنوعی</a><a href="#latest">آموزش</a><div class="ostadi-home-view">▦　☷</div>
            </nav>
            <section class="ostadi-home-columns" id="latest">
                <div class="ostadi-home-panel ostadi-home-panel--latest">
                    <div class="ostadi-home-section-title"><h2>مقالات جدید</h2><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">مشاهده همه ←</a></div>
                    <?php while ( $newest->have_posts() ) : $newest->the_post(); ?>
                        <article class="ostadi-home-list-card"><span class="ostadi-home-list-card__date"><?php echo esc_html( get_the_date() ); ?></span><?php if ( has_post_thumbnail() ) : ?><img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ); ?>" alt=""><?php endif; ?><div><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 13 ) ); ?></p></div></article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
                <div class="ostadi-home-panel">
                    <div class="ostadi-home-section-title"><h2>آخرین مقالات</h2><a href="#latest">مشاهده همه ←</a></div>
                    <div class="ostadi-home-grid"><?php while ( $latest->have_posts() ) : $latest->the_post(); echo $this->card( get_post() ); endwhile; wp_reset_postdata(); ?></div>
                </div>
                <div class="ostadi-home-panel ostadi-home-panel--featured">
                    <div class="ostadi-home-section-title"><h2>جدیدترین</h2><a href="#latest">← همه</a></div>
                    <?php $featured = $this->posts( array( 'posts_per_page' => 1 ) ); while ( $featured->have_posts() ) : $featured->the_post(); ?>
                        <a class="ostadi-home-big-card" href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) : ?><img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>" alt=""><?php endif; ?><h3><?php the_title(); ?></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p></a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </section>
        </div>
        <?php
    }
}
