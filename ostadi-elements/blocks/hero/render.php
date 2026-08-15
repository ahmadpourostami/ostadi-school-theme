<?php
$eyebrow = isset( $attributes['eyebrow'] ) ? $attributes['eyebrow'] : 'مدرسه استادی';
$title = isset( $attributes['title'] ) ? $attributes['title'] : 'آموزش حرفه‌ای، ساده و هدفمند';
$description = isset( $attributes['description'] ) ? $attributes['description'] : '';
$button_text = isset( $attributes['buttonText'] ) ? $attributes['buttonText'] : 'شروع یادگیری';
$button_url = isset( $attributes['buttonUrl'] ) ? $attributes['buttonUrl'] : '#';
$image = isset( $attributes['imageUrl'] ) ? $attributes['imageUrl'] : '';
?>
<section class="ostadi-hero"><div class="ostadi-hero__content"><span class="ostadi-badge"><?php echo esc_html( $eyebrow ); ?></span><h1><?php echo esc_html( $title ); ?></h1><p><?php echo esc_html( $description ); ?></p><a class="ostadi-button" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_text ); ?> <span aria-hidden="true">←</span></a></div><?php if ( $image ) : ?><div class="ostadi-hero__media"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>"></div><?php endif; ?></section>
