<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ostadi_Elements_Media_Fields {
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post_ostadi_video', array( $this, 'save_video' ) );
        add_action( 'save_post_ostadi_podcast', array( $this, 'save_podcast' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    }

    public function add_meta_boxes() {
        add_meta_box( 'ostadi_video_media', 'اطلاعات ویدئو', array( $this, 'video_box' ), 'ostadi_video', 'normal', 'high' );
        add_meta_box( 'ostadi_podcast_media', 'اطلاعات پادکست', array( $this, 'podcast_box' ), 'ostadi_podcast', 'normal', 'high' );
    }

    public function enqueue( $hook ) {
        if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) { return; }
        $screen = get_current_screen();
        if ( ! $screen || ! in_array( $screen->post_type, array( 'ostadi_video', 'ostadi_podcast' ), true ) ) { return; }
        wp_enqueue_media();
    }

    private function field( $label, $name, $value, $type = 'text', $button = '' ) {
        echo '<p><label><strong>' . esc_html( $label ) . '</strong></label><br>';
        echo '<input type="' . esc_attr( $type ) . '" class="widefat ostadi-media-field" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
        if ( $button ) {
            echo '<button type="button" class="button ostadi-media-button" data-target="' . esc_attr( $name ) . '">' . esc_html( $button ) . '</button>';
        }
        echo '</p>';
    }

    public function video_box( $post ) {
        wp_nonce_field( 'ostadi_video_meta', 'ostadi_video_nonce' );
        $url = get_post_meta( $post->ID, '_ostadi_video_url', true );
        $duration = get_post_meta( $post->ID, '_ostadi_video_duration', true );
        $this->field( 'لینک ویدئو', 'ostadi_video_url', $url, 'url', 'انتخاب از رسانه' );
        $this->field( 'مدت زمان', 'ostadi_video_duration', $duration );
    }

    public function podcast_box( $post ) {
        wp_nonce_field( 'ostadi_podcast_meta', 'ostadi_podcast_nonce' );
        $url = get_post_meta( $post->ID, '_ostadi_podcast_url', true );
        $duration = get_post_meta( $post->ID, '_ostadi_podcast_duration', true );
        $host = get_post_meta( $post->ID, '_ostadi_podcast_host', true );
        $this->field( 'فایل / لینک صوتی', 'ostadi_podcast_url', $url, 'url', 'انتخاب فایل صوتی' );
        $this->field( 'مدت زمان', 'ostadi_podcast_duration', $duration );
        $this->field( 'مدرس / گوینده', 'ostadi_podcast_host', $host );
    }

    private function allowed( $post_id, $nonce, $action ) {
        if ( ! isset( $_POST[ $nonce ] ) ) { return false; }
        if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $nonce ] ) ), $action ) ) { return false; }
        if ( ! current_user_can( 'edit_post', $post_id ) ) { return false; }
        return ! wp_is_post_revision( $post_id );
    }

    public function save_video( $post_id ) {
        if ( ! $this->allowed( $post_id, 'ostadi_video_nonce', 'ostadi_video_meta' ) ) { return; }
        $url = isset( $_POST['ostadi_video_url'] ) ? esc_url_raw( wp_unslash( $_POST['ostadi_video_url'] ) ) : '';
        $duration = isset( $_POST['ostadi_video_duration'] ) ? sanitize_text_field( wp_unslash( $_POST['ostadi_video_duration'] ) ) : '';
        update_post_meta( $post_id, '_ostadi_video_url', $url );
        update_post_meta( $post_id, '_ostadi_video_duration', $duration );
    }

    public function save_podcast( $post_id ) {
        if ( ! $this->allowed( $post_id, 'ostadi_podcast_nonce', 'ostadi_podcast_meta' ) ) { return; }
        $url = isset( $_POST['ostadi_podcast_url'] ) ? esc_url_raw( wp_unslash( $_POST['ostadi_podcast_url'] ) ) : '';
        $duration = isset( $_POST['ostadi_podcast_duration'] ) ? sanitize_text_field( wp_unslash( $_POST['ostadi_podcast_duration'] ) ) : '';
        $host = isset( $_POST['ostadi_podcast_host'] ) ? sanitize_text_field( wp_unslash( $_POST['ostadi_podcast_host'] ) ) : '';
        update_post_meta( $post_id, '_ostadi_podcast_url', $url );
        update_post_meta( $post_id, '_ostadi_podcast_duration', $duration );
        update_post_meta( $post_id, '_ostadi_podcast_host', $host );
    }
}
