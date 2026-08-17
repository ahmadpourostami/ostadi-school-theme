<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Ostadi_Widget_Video_Card extends \Elementor\Widget_Base {
    public function get_name(){return 'ostadi-video-card';}
    public function get_title(){return 'کارت نمایش ویدئو';}
    public function get_icon(){return 'eicon-video-camera';}
    public function get_categories(){return array('ostadi');}
    protected function register_controls(){
        $this->start_controls_section('content',array('label'=>'محتوا'));
        $this->add_control('title',array('label'=>'عنوان','type'=>\Elementor\Controls_Manager::TEXT,'default'=>'آموزش طراحی سایت حرفه‌ای'));
        $this->add_control('description',array('label'=>'توضیح کوتاه','type'=>\Elementor\Controls_Manager::TEXTAREA,'default'=>'یک ویدئوی آموزشی برای یادگیری سریع‌تر.'));
        $this->add_control('image',array('label'=>'تصویر بندانگشتی','type'=>\Elementor\Controls_Manager::MEDIA));
        $this->add_control('video_url',array('label'=>'آدرس فایل ویدئو','type'=>\Elementor\Controls_Manager::URL,'description'=>'آدرس مستقیم MP4/WebM. ویدئو داخل همان کارت پخش می‌شود.'));
        $this->add_control('duration',array('label'=>'مدت زمان','type'=>\Elementor\Controls_Manager::TEXT,'default'=>'۱۲:۳۰'));
        $this->end_controls_section();
    }
    protected function render(){
        $s=$this->get_settings_for_display(); $url=!empty($s['video_url']['url'])?$s['video_url']['url']:''; $poster=!empty($s['image']['url'])?$s['image']['url']:'';
        echo '<article class="ostadi-media-card"><div class="ostadi-media-card__image">';
        if($poster)echo '<img src="'.esc_url($poster).'" alt="'.esc_attr($s['title']).'">';
        if($url)echo '<button type="button" class="ostadi-play ostadi-video-inline-trigger" data-ostadi-video="'.esc_url($url).'" data-poster="'.esc_url($poster).'" aria-label="پخش ویدئو">▶</button>';
        if(!empty($s['duration']))echo '<span class="ostadi-duration">'.esc_html($s['duration']).'</span>';
        echo '</div><div class="ostadi-media-card__body"><h3>'.esc_html($s['title']).'</h3><p>'.esc_html($s['description']).'</p></div></article>';
    }
}
