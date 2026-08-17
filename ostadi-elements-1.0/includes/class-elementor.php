<?php
if(!defined('ABSPATH'))exit;
class Ostadi_Elements_Elementor{
 public function __construct(){add_action('elementor/elements/categories_registered',[$this,'cat']);add_action('elementor/widgets/register',[$this,'widgets']);}
 public function cat($m){$m->add_category('ostadi-1',['title'=>'المان‌های استادی ۱.۰','icon'=>'fa fa-graduation-cap']);}
 public function widgets($m){if(!class_exists('\\Elementor\\Widget_Base'))return;require_once OSTADI_ELEMENTS_DIR.'elementor/class-reference-showcase.php';require_once OSTADI_ELEMENTS_DIR.'elementor/class-media-grid.php';$m->register(new Ostadi_Elementor_Reference_Showcase());$m->register(new Ostadi_Elementor_Video_Grid());$m->register(new Ostadi_Elementor_Podcast_Grid());}
}
