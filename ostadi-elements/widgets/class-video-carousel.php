<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Video_Carousel extends Widget_Base {
    public function get_name(){return 'ostadi-video-carousel';}
    public function get_title(){return 'کاروسل ویدئوهای استادی';}
    public function get_icon(){return 'eicon-video-playlist';}
    public function get_categories(){return array('ostadi');}
    protected function register_controls(){
        $this->start_controls_section('content',array('label'=>'محتوا'));
        $this->add_control('title',array('label'=>'عنوان بخش','type'=>Controls_Manager::TEXT,'default'=>'ویدئوهای آموزشی'));
        $this->add_control('count',array('label'=>'تعداد ویدئو','type'=>Controls_Manager::NUMBER,'min'=>1,'max'=>20,'default'=>6));
        $this->add_control('category',array('label'=>'دسته‌بندی','type'=>Controls_Manager::SELECT2,'options'=>$this->categories()));
        $this->end_controls_section();
    }
    private function categories(){ $out=array(''=>'همه دسته‌ها'); $terms=get_terms(array('taxonomy'=>'ostadi_video_category','hide_empty'=>false)); if(!is_wp_error($terms)){foreach($terms as $t){$out[$t->term_id]=$t->name;}} return $out; }
    protected function render(){
        $s=$this->get_settings_for_display(); $args=array('post_type'=>'ostadi_video','post_status'=>'publish','posts_per_page'=>max(1,absint($s['count']))); if(!empty($s['category'])){$args['tax_query']=array(array('taxonomy'=>'ostadi_video_category','field'=>'term_id','terms'=>absint($s['category'])));} $q=new WP_Query($args);
        echo '<section class="ostadi-carousel ostadi-video-carousel" data-ostadi-carousel data-per-view="3" dir="rtl"><div class="ostadi-carousel__head"><h2>'.esc_html($s['title']).'</h2><div class="ostadi-carousel__nav"><button type="button" data-carousel-prev>‹</button><button type="button" data-carousel-next>›</button></div></div><div class="ostadi-carousel__viewport"><div class="ostadi-carousel__track">';
        while($q->have_posts()){ $q->the_post(); $id=get_the_ID(); $url=get_post_meta($id,'_ostadi_video_url',true); $duration=get_post_meta($id,'_ostadi_video_duration',true); $img=get_the_post_thumbnail_url($id,'large'); echo '<article class="ostadi-carousel-card ostadi-video-carousel-card"><div class="ostadi-carousel-card__image ostadi-video-carousel-card__media">'.($img?'<img src="'.esc_url($img).'" alt="'.esc_attr(get_the_title()).'">':'').'<button type="button" class="ostadi-play ostadi-video-inline-trigger" data-ostadi-video="'.esc_url($url).'" data-poster="'.esc_url($img).'" aria-label="پخش ویدئو">▶</button>'.($duration?'<span class="ostadi-duration">'.esc_html($duration).'</span>':'').'</div><div class="ostadi-carousel-card__body"><span class="ostadi-badge">ویدئو</span><h3>'.esc_html(get_the_title()).'</h3><p>'.esc_html(wp_trim_words(get_the_excerpt(),12)).'</p></div></article>'; }
        wp_reset_postdata(); echo '</div></div><div class="ostadi-carousel__dots" data-carousel-dots></div></section>';
    }
}
