<?php
if(!defined('ABSPATH'))exit;
class Ostadi_Elements_Assets{
 public function __construct(){add_action('wp_enqueue_scripts',[$this,'front']);add_action('elementor/editor/after_enqueue_styles',[$this,'editor']);}
 public function front(){wp_enqueue_style('ostadi-elements-1',OSTADI_ELEMENTS_URL.'assets/css/frontend.css',[],OSTADI_ELEMENTS_VERSION);wp_enqueue_script('ostadi-elements-1',OSTADI_ELEMENTS_URL.'assets/js/frontend.js',[],OSTADI_ELEMENTS_VERSION,true);}
 public function editor(){wp_enqueue_style('ostadi-elements-1-editor',OSTADI_ELEMENTS_URL.'assets/css/frontend.css',[],OSTADI_ELEMENTS_VERSION);}
}
