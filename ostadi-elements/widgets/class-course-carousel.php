<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ostadi_Widget_Course_Carousel extends Widget_Base {
    public function get_name(){return 'ostadi-course-carousel';}
    public function get_title(){return 'کاروسل دوره‌های استادی';}
    public function get_icon(){return 'eicon-carousel';}
    public function get_categories(){return array('ostadi');}
    protected function register_controls(){
        $this->start_controls_section('content',array('label'=>'محتوا'));
        $this->add_control('title',array('label'=>'عنوان بخش','type'=>Controls_Manager::TEXT,'default'=>'دوره‌های آموزشی'));
        $this->add_control('count',array('label'=>'تعداد دوره','type'=>Controls_Manager::NUMBER,'min'=>1,'max'=>20,'default'=>6));
        $this->add_control('source',array('label'=>'منبع دوره','type'=>Controls_Manager::SELECT,'default'=>'auto','options'=>array('auto'=>'دوره‌های سایت','manual'=>'دستی')));
        $this->add_control('items',array('label'=>'دوره‌های دستی','type'=>Controls_Manager::REPEATER,'fields'=>array(
            array('name'=>'title','label'=>'عنوان','type'=>Controls_Manager::TEXT,'default'=>'آموزش جامع طراحی سایت'),
            array('name'=>'teacher','label'=>'مدرس','type'=>Controls_Manager::TEXT,'default'=>'مدرس دوره'),
            array('name'=>'price','label'=>'قیمت','type'=>Controls_Manager::TEXT,'default'=>'۲۹۹٬۰۰۰ تومان'),
            array('name'=>'image','label'=>'تصویر','type'=>Controls_Manager::MEDIA),
            array('name'=>'url','label'=>'لینک','type'=>Controls_Manager::URL),
        ),'title_field'=>'{{{ title }}}','condition'=>array('source'=>'manual')));
        $this->end_controls_section();
    }
    protected function render(){
        $s=$this->get_settings_for_display(); $items=array();
        if('manual'===$s['source']){foreach((array)$s['items'] as $i){$items[]=array('title'=>$i['title']??'','teacher'=>$i['teacher']??'','price'=>$i['price']??'','image'=>$i['image']['url']??'','url'=>$i['url']['url']??'#');}}
        else { $types=array('courses','course'); foreach($types as $type){$q=new WP_Query(array('post_type'=>$type,'post_status'=>'publish','posts_per_page'=>max(1,absint($s['count'])))); if($q->have_posts()){while($q->have_posts()){$q->the_post();$items[]=array('title'=>get_the_title(),'teacher'=>get_post_meta(get_the_ID(),'_tutor_instructor_name',true),'price'=>get_post_meta(get_the_ID(),'_tutor_course_price',true),'image'=>get_the_post_thumbnail_url(get_the_ID(),'large'),'url'=>get_permalink());}wp_reset_postdata();break;}} }
        echo '<section class="ostadi-carousel ostadi-course-carousel" data-ostadi-carousel data-per-view="3" dir="rtl"><div class="ostadi-carousel__head"><h2>'.esc_html($s['title']).'</h2><div class="ostadi-carousel__nav"><button type="button" data-carousel-prev>‹</button><button type="button" data-carousel-next>›</button></div></div><div class="ostadi-carousel__viewport"><div class="ostadi-carousel__track">';
        foreach($items as $i){echo '<article class="ostadi-carousel-card ostadi-course-carousel-card"><a class="ostadi-carousel-card__image" href="'.esc_url($i['url']).'">'.($i['image']?'<img src="'.esc_url($i['image']).'" alt="'.esc_attr($i['title']).'">':'').'</a><div class="ostadi-carousel-card__body"><span class="ostadi-badge">دوره آموزشی</span><h3><a href="'.esc_url($i['url']).'">'.esc_html($i['title']).'</a></h3><p>'.esc_html($i['teacher']).'</p><div class="ostadi-course-card__footer"><strong>'.esc_html($i['price']).'</strong><a href="'.esc_url($i['url']).'">مشاهده دوره ←</a></div></div></article>';}
        echo '</div></div><div class="ostadi-carousel__dots" data-carousel-dots></div></section>';
    }
}
