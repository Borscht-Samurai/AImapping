<?php get_header(); ?>

<main class="site-main">
    <!-- フロントページ画像セクション -->
    <section class="frontpage-image-section">
        <div class="frontpage-image-container">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/frontpage-1.1.png'); ?>" alt="フロントページ画像" class="frontpage-main-image">
        </div>
    </section>

    <!-- グラデーションセクション -->
    <section class="frontpage-gradient-line-section">
        <div class="gradient-box"></div>
    </section>

    <!-- 新しいdiv boxセクション -->
    <section class="new-box-section">
        <div class="new-box-top">
            <div class="left-box-top">
                <h2 class="new-box-title">AIクリエイターの<br>出会いの場を探す</h2>
                <p class="new-box-description">
                    同じ地域のAIクリエイターと直接会って<br>話せる。オンラインでは得られない、そ<br>の場の空気感や熱量が新しいインスピ<br>レーションを生み出します。
                </p>
                <a href="<?php echo is_user_logged_in() ? home_url('/recruitment/') : home_url('/register/'); ?>" class="start-free-button"><?php echo is_user_logged_in() ? '募集をみる' : '無料ではじめる'; ?></a>
                <div class="picnic-container">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/picnic1.png'); ?>" alt="Picnic" class="picnic-image">
                    <p class="picnic-text">＠ピクニック</p>
                </div>
            </div>
            <div class="right-box-top">
                <div class="exchange-container">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/exchange.png'); ?>" alt="Exchange" class="exchange-image">
                    <p class="exchange-text">＠交流会</p>
                </div>
            </div>
        </div>
    </section>

    <!-- frontpage-2画像 左揃え配置 -->
    <div class="frontpage-image-wrapper frontpage-2-wrapper">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/frontpage-2.png'); ?>" alt="フロントページ画像2" class="frontpage-image frontpage-2-image">
    </div>
    <!-- frontpage-3画像 中央揃え配置 -->
    <div class="frontpage-image-container frontpage-3-container">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/frontpage-3.png'); ?>" alt="フロントページ画像3" class="frontpage-image frontpage-3-image">
    </div>
    <!-- frontpage-4画像 中央揃え配置 -->
    <div class="frontpage-image-container frontpage-4-container">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/frontpage-4.png'); ?>" alt="フロントページ画像4" class="frontpage-image frontpage-4-image">
    </div>

</main>

<?php get_footer(); ?>