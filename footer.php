<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <h3><?php bloginfo( 'name' ); ?></h3>
                <p><?php bloginfo( 'description' ); ?></p>
            </div>
            <div>
                <h3>دسترسی سریع</h3>
                <?php if ( has_nav_menu( 'primary' ) ) : ?><?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?><?php endif; ?>
            </div>
            <div>
                <h3>ارتباط با ما</h3>
                <p>برای اطلاع از دوره‌ها و مطالب جدید، همراه مدرسه استادی باشید.</p>
            </div>
        </div>
        <div class="footer-bottom">© <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> — تمامی حقوق محفوظ است.</div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
