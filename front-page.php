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
                <h2 style="width: 277.19px; height: 76px; font-family: 'Montserrat'; font-style: normal; font-weight: 500; font-size: 29.5667px; line-height: 130%; letter-spacing: -0.147834px; color: #535353; flex: none; order: 0; align-self: stretch; flex-grow: 0;">AIクリエイターの<br>出会いの場を探す</h2>
                <p style="width: 277.19px; height: 120px; font-family: 'Montserrat'; font-style: normal; font-weight: 400; font-size: 14.7834px; line-height: 160%; display: flex; align-items: center; color: #535353; flex: none; order: 1; align-self: stretch; flex-grow: 0;">
                    同じ地域のAIクリエイターと直接会って話せる。オンラインでは得られない、その場の空気感や熱量が新しいインスピレーションを生み出します。
                </p>
                <a href="#" class="start-free-button">無料ではじめる</a>
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

</main>

<?php get_footer(); ?>