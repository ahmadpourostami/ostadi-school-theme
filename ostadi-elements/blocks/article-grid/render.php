<?php
$count = max( 1, min( 12, absint( $attributes['count'] ?? 4 ) ) );
$columns = in_array( (string) ( $attributes['columns'] ?? '4' ), array( '2','3','4' ), true ) ? (string) $attributes['columns'] : '4';
$args = array( 'post_type' => 'post', 'posts_per_page' => $count );
if ( ! empty( $attributes['category'] ) ) $args['category_name'] = sanitize_title( $attributes['category'] );
$q = new WP_Query( $args );
?>
<div class="ostadi-article-grid ostadi-cols-<?php echo esc_attr( $columns ); ?>">
<?php while ( $q->have_posts() ) : $q->the_post(); ?>
<article class="ostadi-card ostadi-article-card"><?php if ( has_post_thumbnail() ) : ?><a class="ostadi-card__image" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a><?php endif; ?><div class="ostadi-card__body"><span class="ostadi-badge"><?php echo esc_html( get_the_category()[0]->name ?? 'آموزش' ); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p><div class="ostadi-card__meta"><span><?php echo esc_html( get_the_date() ); ?></span><span>مطالعه</span></div></div></article>
<?php endwhile; wp_reset_postdata(); ?>
</div>
