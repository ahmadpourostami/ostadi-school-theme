<?php
$title = isset( $attributes['title'] ) ? $attributes['title'] : 'آخرین مطالب آموزشی';
$description = isset( $attributes['description'] ) ? $attributes['description'] : '';
?>
<div class="ostadi-section-heading"><div><h2><?php echo esc_html( $title ); ?></h2><?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?></div></div>
