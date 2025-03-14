    </div><!-- .site-content -->

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-widgets">
                <div class="footer-widget">
                    <h3>サイトについて</h3>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>">AIMappingとは</a></li>
                        <li><a href="<?php echo esc_url(home_url('/guide')); ?>">使い方ガイド</a></li>
                        <li><a href="<?php echo esc_url(home_url('/faq')); ?>">よくある質問</a></li>
                    </ul>
                </div>
                <div class="footer-widget">
                    <h3>サポート</h3>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>">お問い合わせ</a></li>
                        <li><a href="<?php echo esc_url(home_url('/terms')); ?>">利用規約</a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy')); ?>">プライバシーポリシー</a></li>
                    </ul>
                </div>
                <div class="footer-widget">
                    <h3>フォローする</h3>
                    <div class="social-links">
                        <a href="#" class="social-link twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html> 