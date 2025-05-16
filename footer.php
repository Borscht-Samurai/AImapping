    </div><!-- .site-content -->

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-widgets-wrapper">
                <div class="footer-widgets">
                    <div class="footer-widget">
                        <h3>このサイトについて</h3>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/about')); ?>">AIMappingについて</a></li>
                            <li><a href="<?php echo esc_url(home_url('/guide')); ?>">ユーザーガイド</a></li>
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
                        <h3>お問い合わせ</h3>
                        <ul>
                            <li>aimapping21@gmail.com</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 AI_Mapping. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>