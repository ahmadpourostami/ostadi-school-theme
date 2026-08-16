<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Elements_Content_Types {
    public function __construct() {
        add_action( 'init', array( $this, 'register_content_types' ) );
    }

    public function register_content_types() {
        $this->register_video();
        $this->register_podcast();
    }

    private function register_video() {
        register_post_type( 'ostadi_video', array(
            'labels' => array( 'name' => 'ویدئوها', 'singular_name' => 'ویدئو', 'add_new' => 'افزودن ویدئو', 'add_new_item' => 'افزودن ویدئوی جدید', 'edit_item' => 'ویرایش ویدئو', 'new_item' => 'ویدئوی جدید', 'view_item' => 'مشاهده ویدئو', 'search_items' => 'جستجوی ویدئوها' ),
            'public' => true, 'show_in_rest' => true, 'menu_icon' => 'dashicons-video-alt3',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ), 'has_archive' => true,
            'rewrite' => array( 'slug' => 'videos' ),
        ) );
        register_taxonomy( 'ostadi_video_category', 'ostadi_video', array( 'labels' => array( 'name' => 'دسته‌بندی ویدئو', 'singular_name' => 'دسته‌بندی ویدئو' ), 'public' => true, 'show_in_rest' => true, 'hierarchical' => true, 'rewrite' => array( 'slug' => 'video-category' ) ) );
        register_taxonomy( 'ostadi_video_tag', 'ostadi_video', array( 'labels' => array( 'name' => 'برچسب ویدئو', 'singular_name' => 'برچسب ویدئو' ), 'public' => true, 'show_in_rest' => true, 'hierarchical' => false, 'rewrite' => array( 'slug' => 'video-tag' ) ) );
    }

    private function register_podcast() {
        register_post_type( 'ostadi_podcast', array(
            'labels' => array( 'name' => 'پادکست‌ها', 'singular_name' => 'پادکست', 'add_new' => 'افزودن پادکست', 'add_new_item' => 'افزودن پادکست جدید', 'edit_item' => 'ویرایش پادکست', 'new_item' => 'پادکست جدید', 'view_item' => 'مشاهده پادکست', 'search_items' => 'جستجوی پادکست‌ها' ),
            'public' => true, 'show_in_rest' => true, 'menu_icon' => 'dashicons-microphone',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ), 'has_archive' => true,
            'rewrite' => array( 'slug' => 'podcasts' ),
        ) );
        register_taxonomy( 'ostadi_podcast_category', 'ostadi_podcast', array( 'labels' => array( 'name' => 'دسته‌بندی پادکست', 'singular_name' => 'دسته‌بندی پادکست' ), 'public' => true, 'show_in_rest' => true, 'hierarchical' => true, 'rewrite' => array( 'slug' => 'podcast-category' ) ) );
        register_taxonomy( 'ostadi_podcast_tag', 'ostadi_podcast', array( 'labels' => array( 'name' => 'برچسب پادکست', 'singular_name' => 'برچسب پادکست' ), 'public' => true, 'show_in_rest' => true, 'hierarchical' => false, 'rewrite' => array( 'slug' => 'podcast-tag' ) ) );
    }
}
