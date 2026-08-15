<?php
/**
 * Ostadi School theme functions.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function ostadi_school_setup() {
    load_theme_textdomain( 'ostadi-school', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-height' => true, 'flex-width' => true ) );
    register_nav_menus( array( 'primary' => __( 'منوی اصلی', 'ostadi-school' ) ) );
}
add_action( 'after_setup_theme', 'ostadi_school_setup' );

function ostadi_school_assets() {
    wp_enqueue_style( 'ostadi-school-style', get_stylesheet_uri(), array(), '1.0.0' );
    wp_enqueue_script( 'ostadi-school-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'ostadi_school_assets' );

function ostadi_school_widgets() {
    register_sidebar( array(
        'name' => __( 'سایدبار اصلی', 'ostadi-school' ),
        'id' => 'sidebar-1',
        'description' => __( 'ابزارک‌های سایدبار سایت.', 'ostadi-school' ),
        'before_widget' => '<section class="widget">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'ostadi_school_widgets' );
