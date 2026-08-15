<?php get_header(); ?>
<main class="content-area">
    <div class="container">
        <article class="content-wrap">
            <?php while ( have_posts() ) : the_post(); ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <div class="card-meta"><span><?php echo esc_html( get_the_date() ); ?></span><span><?php the_category( ', ' ); ?></span></div>
                <div class="entry-content"><?php the_content(); ?></div>
            <?php endwhile; ?>
        </article>
    </div>
</main>
<?php get_footer(); ?>
