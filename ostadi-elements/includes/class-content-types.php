<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Elements_Content_Types {
    public function __construct() {
        add_action( 'init', array( $this, 'register_content_types' ) );
        add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
        add_action( 'save_post_ostadi_video', array( $this, 'save_video_meta' ) );
        add_action( 'save_post_ostadi_podcast', array( $this, 'save_podcast_meta' ) );
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

    public function register_meta_boxes() {
        add_meta_box( 'ostadi_video_details', 'اطلاعات ویدئو', array( $this, 'render_video_meta_box' ), 'ostadi_video', 'normal', 'high' );
        add_meta_box( 'ostadi_podcast_details', 'اطلاعات پادکست', array( $this, 'render_podcast_meta_box' ), 'ostadi_podcast', 'normal', 'high' );
    }

    public function render_video_meta_box( $post ) {
        wp_nonce_field( 'ostadi_video_details', 'ostadi_video_nonce' );
        $url = get_post_meta( $post->ID, '_ostadi_video_url', true );
        $duration = get_post_meta( $post->ID, '_ostadi_video_duration', true );
        echo '<p><label for="ostadi_video_url"><strong>لینک ویدئو</strong></label></p>';
        echo '<input type="url" class="widefat" id="ostadi_video_url" name="ostadi_video_url" value="' . esc_attr( $url ) . '" placeholder="https://..." />';
        echo '<p><label for="ostadi_video_duration"><strong>مدت زمان</strong></label></p>';
        echo '<input type="text" class="regular-text" id="ostadi_video_duration" name="ostadi_video_duration" value="' . esc_attr( $duration ) . '" placeholder="12:30" />';
    }

    public function render_podcast_meta_box( $post ) {
        wp_nonce_field( 'ostadi_podcast_details', 'ostadi_podcast_nonce' );
        $url = get_post_meta( $post->ID, '_ostadi_podcast_url', true );
        $duration = get_post_meta( $post->ID, '_ostadi_podcast_duration', true );
        $host = get_post_meta( $post->ID, '_ostadi_podcast_host', true );
        echo '<p><label for="ostadi_podcast_url"><strong>لینک یا فایل صوتی</strong></label></p>';
        echo '<input type="url" class="widefat" id="ostadi_podcast_url" name="ostadi_podcast_url" value="' . esc_attr( $url ) . '" placeholder="https://..." />';
        echo '<p><label for="ostadi_podcast_duration"><strong>مدت زمان</strong></label></p>';
        echo '<input type="text" class="regular-text" id="ostadi_podcast_duration" name="ostadi_podcast_duration" value="' . esc_attr( $duration ) . '" placeholder="24:10" />';
        echo '<p><label for="ostadi_podcast_host"><strong>مدرس / گوینده</strong></label></p>';
        echo '<input type="text" class="widefat" id="ostadi_podcast_host" name="ostadi_podcast_host" value="' . esc_attr( $host ) . '" placeholder="نام مدرس یا گوینده" />';
    }

    public function save_video_meta( $post_id ) {
        if ( ! isset( $_POST['ostadi_video_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ostadi_video_nonce'] ) ), 'ostadi_video_details' ) ) { return; }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
        if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
        $url = isset( $_POST['ostadi_video_url'] ) ? esc_url_raw( wp_unslash( $_POST['ostadi_video_url'] ) ) : '';
        $duration = isset( $_POST['ostadi_video_duration'] ) ? sanitize_text_field( wp_unslash( $_POST['ostadi_video_duration'] ) ) : '';
        update_post_meta( $post_id, '_ostadi_video_url', $url );
        update_post_meta( $post_id, '_ostadi_video_duration', $duration );
    }

    public function save_podcast_meta( $post_id ) {
        if ( ! isset( $_POST['ostadi_podcast_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ostadi_podcast_nonce'] ) ), 'ostadi_podcast_details' ) ) { return; }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
        if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
        $url = isset( $_POST['ostadi_podcast_url'] ) ? esc_url_raw( wp_unslash( $_POST['ostadi_podcast_url'] ) ) : '';
        $duration = isset( $_POST['ostadi_podcast_duration'] ) ? sanitize_text_field( wp_unslash( $_POST['ostadi_podcast_duration'] ) ) : '';
        $host = isset( $_POST['ostadi_podcast_host'] ) ? sanitize_text_field( wp_unslash( $_POST['ostadi_podcast_host'] ) ) : '';
        update_post_meta( $post_id, '_ostadi_podcast_url', $url );
        update_post_meta( $post_id, '_ostadi_podcast_duration', $duration );
        update_post_meta( $post_id, '_ostadi_podcast_host', $host );
    }
}
