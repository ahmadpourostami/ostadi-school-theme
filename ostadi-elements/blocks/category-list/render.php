<?php
$limit = max( 1, min( 20, absint( $attributes['limit'] ?? 6 ) ) );
$terms = get_categories( array( 'hide_empty' => true, 'number' => $limit ) );
?>
<div class="ostadi-category-list">
<?php foreach ( $terms as $term ) : ?><a class="ostadi-category-item" href="<?php echo esc_url( get_category_link( $term ) ); ?>"><span class="ostadi-category-item__icon"><?php echo esc_html( mb_substr( $term->name, 0, 1 ) ); ?></span><span><?php echo esc_html( $term->name ); ?></span><strong><?php echo esc_html( $term->count ); ?></strong></a><?php endforeach; ?>
</div>
