<?php
$title = isset( $attributes['title'] ) ? $attributes['title'] : 'آموزش طراحی سایت حرفه‌ای';
$description = isset( $attributes['description'] ) ? $attributes['description'] : '';
$image = isset( $attributes['imageUrl'] ) ? $attributes['imageUrl'] : '';
$url = isset( $attributes['videoUrl'] ) ? $attributes['videoUrl'] : '#';
$duration = isset( $attributes['duration'] ) ? $attributes['duration'] : '';
?>
<article class="ostadi-media-card"><a class="ostadi-media-card__image" href="<?php echo esc_url( $url ); ?>"><?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>"><?php endif; ?><span class="ostadi-play" aria-hidden="true">▶</span><?php if ( $duration ) : ?><span class="ostadi-duration"><?php echo esc_html( $duration ); ?></span><?php endif; ?></a><div class="ostadi-media-card__body"><h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a></h3><p><?php echo esc_html( $description ); ?></p></div></article>
