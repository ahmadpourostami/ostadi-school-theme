<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Ostadi_Widget_Podcast_Card extends \Elementor\Widget_Base {
    public function get_name(){return 'ostadi-podcast-card';}
    public function get_title(){return 'کارت پخش پادکست';}
    public function get_icon(){return 'eicon-headphones';}
    public function get_categories(){return array('ostadi');}
    protected function register_controls(){
        $this->start_controls_section('content',array('label'=>'محتوا'));
        $this->add_control('title',array('label'=>'عنوان اپیزود','type'=>\Elementor\Controls_Manager::TEXT,'default'=>'چطور یک مسیر یادگیری حرفه‌ای بسازیم؟'));
        $this->add_control('episode',array('label'=>'شماره قسمت','type'=>\Elementor\Controls_Manager::TEXT,'default'=>'قسمت ۱۲'));
        $this->add_control('host',array('label'=>'مدرس / گوینده','type'=>\Elementor\Controls_Manager::TEXT,'default'=>'احمد پوراستمی'));
        $this->add_control('image',array('label'=>'کاور پادکست','type'=>\Elementor\Controls_Manager::MEDIA));
        $this->add_control('audio_url',array('label'=>'فایل صوتی','type'=>\Elementor\Controls_Manager::URL,'description'=>'فقط فایل صوتی را انتخاب کنید؛ پخش داخل همین صفحه انجام می‌شود و به برگه جدید نمی‌رود.'));
        $this->add_control('duration',array('label'=>'مدت زمان','type'=>\Elementor\Controls_Manager::TEXT,'default'=>'۱۸:۲۴'));
        $this->end_controls_section();
    }
    protected function render(){
        $s=$this->get_settings_for_display(); $url=!empty($s['audio_url']['url'])?$s['audio_url']['url']:'';
        echo '<article class="ostadi-podcast-card ostadi-podcast-card--reference">';
        echo '<div class="ostadi-podcast-card__media">'.(!empty($s['image']['url'])?'<img src="'.esc_url($s['image']['url']).'" alt="'.esc_attr($s['title']).'">':'<div class="ostadi-podcast-card__icon">♫</div>').'</div>';
        echo '<div class="ostadi-podcast-card__content"><span>'.esc_html($s['episode']).'</span><h3>'.esc_html($s['title']).'</h3><div class="ostadi-podcast-wave" aria-hidden="true">'.str_repeat('<i></i>',24).'</div><div class="ostadi-card__meta"><span>'.esc_html($s['host']).'</span><span>'.esc_html($s['duration']).'</span></div></div>';
        if($url)echo '<button class="ostadi-podcast-card__play" type="button" data-ostadi-audio="'.esc_url($url).'" aria-label="پخش پادکست">▶</button>';
        echo '</article>';
    }
}
