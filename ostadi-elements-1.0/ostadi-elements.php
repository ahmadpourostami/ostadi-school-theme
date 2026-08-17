<?php
/**
 * Plugin Name: Ostadi Elements
 * Description: المان‌های فارسی و RTL برای سایت اساتید آموزشی؛ پادکست، ویدئو، مقالات، Gutenberg و Elementor.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Text Domain: ostadi-elements
 */
if (!defined('ABSPATH')) exit;
define('OSTADI_ELEMENTS_VERSION','1.0.0');
define('OSTADI_ELEMENTS_FILE',__FILE__);
define('OSTADI_ELEMENTS_DIR',plugin_dir_path(__FILE__));
define('OSTADI_ELEMENTS_URL',plugin_dir_url(__FILE__));
require_once OSTADI_ELEMENTS_DIR.'includes/class-content-types.php';
require_once OSTADI_ELEMENTS_DIR.'includes/class-assets.php';
require_once OSTADI_ELEMENTS_DIR.'includes/class-gutenberg.php';
require_once OSTADI_ELEMENTS_DIR.'includes/class-elementor.php';
register_activation_hook(__FILE__,function(){(new Ostadi_Elements_Content_Types())->register();flush_rewrite_rules();});
register_deactivation_hook(__FILE__,'flush_rewrite_rules');
add_action('plugins_loaded',function(){
 new Ostadi_Elements_Content_Types(); new Ostadi_Elements_Assets(); new Ostadi_Elements_Gutenberg(); new Ostadi_Elements_Elementor();
});
