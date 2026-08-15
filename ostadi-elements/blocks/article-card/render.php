<?php
$post_id = ! empty( $attributes['postId'] ) ? absint( $attributes['postId'] ) : get_the_ID();
$post = get_post( $post_id );
if ( ! $post ) return;
setup_postdata( $post );
?>
<article class="ostadi-card ostadi-article-card">
<?php if ( has_post_thumbnail( $post ) ) : ?><a class="ostadi-card__image" href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo get_the_post_thumbnail( $post, 'large' ); ?></a><?php endif; ?>
<div class="ostadi-card__body"><span class="ostadi-badge"><?php echo esc_html( get_the_category( $post->ID )[0]->name ?? 'آموزش' ); ?></span><h3><a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt( $post ), 20 ) ); ?></p><div class="ostadi-card__meta"><span><?php echo esc_html( get_the_date( '', $post ) ); ?></span><span>مطالعه مقاله</span></div></div></article>
<?php wp_reset_postdata(); ?>
