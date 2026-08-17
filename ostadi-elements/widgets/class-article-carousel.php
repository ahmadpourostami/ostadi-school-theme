<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Article_Carousel extends Widget_Base {
    public function get_name() { return 'ostadi-article-carousel'; }
    public function get_title() { return 'کاروسل مقالات استادی'; }
    public function get_icon() { return 'eicon-posts-carousel'; }
    public function get_categories() { return array( 'ostadi' ); }
    protected function register_controls() {
        $this->start_controls_section('content',array('label'=>'محتوا'));
        $this->add_control('title',array('label'=>'عنوان بخش','type'=>Controls_Manager::TEXT,'default'=>'آخرین مقالات'));
        $this->add_control('count',array('label'=>'تعداد مقاله','type'=>Controls_Manager::NUMBER,'min'=>1,'max'=>20,'default'=>6));
        $this->add_control('category',array('label'=>'دسته‌بندی','type'=>Controls_Manager::SELECT2,'options'=>$this->categories()));
        $this->end_controls_section();
        $this->start_controls_section('style',array('label'=>'استایل','tab'=>Controls_Manager::TAB_STYLE));
        $this->add_control('cards',array('label'=>'تعداد کارت در دسکتاپ','type'=>Controls_Manager::SELECT,'default'=>'3','options'=>array('2'=>'۲','3'=>'۳','4'=>'۴')));
        $this->end_controls_section();
    }
    private function categories(){ $out=array(''=>'همه دسته‌ها'); foreach(get_categories(array('hide_empty'=>false)) as $c){$out[$c->term_id]=$c->name;} return $out; }
    protected function render(){
        $s=$this->get_settings_for_display(); $args=array('post_type'=>'post','post_status'=>'publish','posts_per_page'=>max(1,absint($s['count']))); if(!empty($s['category'])){$args['cat']=absint($s['category']);} $q=new WP_Query($args);
        $id='ostadi-ac-'.esc_attr($this->get_id());
        echo '<section class="ostadi-carousel ostadi-article-carousel" id="'.$id.'" data-ostadi-carousel data-per-view="'.esc_attr($s['cards']?:'3').'" dir="rtl">';
        echo '<div class="ostadi-carousel__head"><h2>'.esc_html($s['title']).'</h2><div class="ostadi-carousel__nav"><button type="button" data-carousel-prev aria-label="قبلی">‹</button><button type="button" data-carousel-next aria-label="بعدی">›</button></div></div><div class="ostadi-carousel__viewport"><div class="ostadi-carousel__track">';
        while($q->have_posts()){ $q->the_post(); $cat=get_the_category(); echo '<article class="ostadi-carousel-card"><a class="ostadi-carousel-card__image" href="'.esc_url(get_permalink()).'">'.(has_post_thumbnail()?get_the_post_thumbnail(get_the_ID(),'large'): '').'</a><div class="ostadi-carousel-card__body"><span class="ostadi-badge">'.esc_html($cat?$cat[0]->name:'آموزش').'</span><h3><a href="'.esc_url(get_permalink()).'">'.esc_html(get_the_title()).'</a></h3><p>'.esc_html(wp_trim_words(get_the_excerpt(),15)).'</p><div class="ostadi-carousel-card__meta"><span>'.esc_html(get_the_date()).'</span><span>مطالعه مقاله ←</span></div></div></article>'; }
        wp_reset_postdata(); echo '</div></div><div class="ostadi-carousel__dots" data-carousel-dots></div></section>';
    }
}
