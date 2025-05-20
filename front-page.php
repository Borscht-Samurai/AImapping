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
        <div class="new-box">
            <div class="left-box">
                <h2>Projects</h2>
                <p>Our portfolio showcases a range of projects, from cozy living rooms to luxurious bedrooms, and everything in between. We have worked on residential projects, commercial spaces, and hospitality interiors, and have experience working with a variety of design styles.</p>
                <a href="#" class="start-free-button">無料ではじめる</a>
                <div class="picnic-container">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/picnic.png'); ?>" alt="Picnic" class="picnic-image">
                    <p class="picnic-text">＠ピクニック</p>
                </div>
            </div>
            <div class="right-box">
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