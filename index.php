<?php get_header(); ?>
<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <div class="eyebrow">مدرسه آنلاین استادی</div>
                <h1>یادگیری حرفه‌ای، ساده و هدفمند</h1>
                <p>یک تجربه آموزشی مدرن برای دوره‌ها، مطالب تخصصی و مسیر رشد مهارت‌های شما.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/courses/' ) ); ?>">شروع یادگیری</a>
                    <a class="btn btn-light" href="#latest">مطالب جدید</a>
                </div>
            </div>
            <div class="hero-card">
                <strong>مدرسه استادی</strong>
                <p>محیطی برای یادگیری مستمر و دسترسی منظم به محتوای آموزشی باکیفیت.</p>
                <div class="stat-grid">
                    <div class="stat"><strong>+۱۰۰</strong><span>مطلب آموزشی</span></div>
                    <div class="stat"><strong>+۲۰</strong><span>دوره تخصصی</span></div>
                </div>
            </div>
        </div>
    </section>
    <section class="section" id="latest">
        <div class="container">
            <div class="section-head"><div><h2 class="section-title">آخرین مطالب</h2><p class="section-desc">جدیدترین آموزش‌ها و مقالات مدرسه استادی</p></div></div>
            <div class="cards">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <article class="card"><div class="card-body"><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p><div class="card-meta"><span><?php echo esc_html( get_the_date() ); ?></span><span><?php the_category( ', ' ); ?></span></div></div></article>
                <?php endwhile; else : ?>
                    <article class="card"><div class="card-body"><h3>به‌زودی مطالب آموزشی</h3><p>اولین محتوای مدرسه استادی را منتشر کنید.</p></div></article>
                <?php endif; ?>
            </div>
            <?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => 'قبلی', 'next_text' => 'بعدی' ) ); ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>
