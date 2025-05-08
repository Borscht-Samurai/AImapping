<?php get_header(); ?>

<body <?php body_class('page-front-page'); ?>>

<style>
/* フロントページのメイン画像スタイル */
.frontpage-image-section {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 60px;
    margin-bottom: 60px;
    text-align: center;
}

.frontpage-image-container {
    max-width: 100%;
    text-align: center;
    display: flex;
    justify-content: center;
    margin: 0 auto;
}

.frontpage-main-image {
    max-width: 100%;
    height: auto;
    margin: 0 auto;
    display: block;
}

/* 新しいdiv boxのスタイル */
.new-box-section {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 50px auto;
}

.new-box {
    width: 1110px;
    height: 865px;
    background-color: #E7E7E7;
    display: flex;
    flex-direction: row;
}

.left-box {
    width: 405px;
    height: 865px;
    background-color: #E7E7E7;
    padding: 60px 40px;
    display: flex;
    flex-direction: column;
}

.left-box h2 {
    font-size: 40px;
    color: #333;
    margin-bottom: 30px;
    font-weight: 500;
}

.left-box p {
    font-size: 16px;
    line-height: 160%; /* 行間を160%に変更 */
    color: #333;
    margin-bottom: 40px;
}

.start-free-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    color: white; /* テキストの文字色を白に設定 */
    width: 260px; /* ボタンの幅を260pxに設定 */
    height: 60px; /* ボタンの高さを60pxに設定 */
    font-size: 23px; /* 文字サイズを23pxに変更 */
    border-radius: 50px; /* 両サイドを円弧に変更 */
    background: linear-gradient(90deg, #A5FDF7 0%, #FF966C 100%); /* グラデーション背景 */
    cursor: pointer;
    border: none;
    transition: all 0.3s;
    box-shadow: 6px 6px 12px #c5c5c5, -6px -6px 12px #ffffff;
    margin-top: 0px;
    text-decoration: none;
    text-align: center;
}

.start-free-button:active {
    color: white; /* アクティブ状態でもテキスト色を白に保持 */
    box-shadow: inset 4px 4px 12px #c5c5c5, inset -4px -4px 12px #ffffff;
}

.right-box {
    width: 705px;
    height: 865px;
    background-color: #E7E7E7;
}

/* カテゴリーセクションのマージンを調整 */
.categories {
    margin: 0 20px;
}
</style>

<main class="site-main">
    <!-- フロントページ画像セクション -->
    <section class="frontpage-image-section">
        <div class="frontpage-image-container">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/frontpage-1.1.png'); ?>" alt="フロントページ画像" class="frontpage-main-image">
        </div>
    </section>

    <!-- グラデーションセクション -->
    <section class="gradient-box-section">
        <div class="gradient-box"></div>
    </section>

    <!-- 新しいdiv boxセクション -->
    <section class="new-box-section">
        <div class="new-box">
            <div class="left-box">
                <h2>Projects</h2>
                <p>Our portfolio showcases a range of projects, from cozy living rooms to luxurious bedrooms, and everything in between. We have worked on residential projects, commercial spaces, and hospitality interiors, and have experience working with a variety of design styles.</p>
                <a href="#" class="start-free-button">無料ではじめる</a>
            </div>
            <div class="right-box"></div>
        </div>
    </section>

    <!-- 新しいセクション - もっと見るボタンの下のボックス -->
    <section class="aqua-box-section" style="margin-top: 20px; background-color: #A5FDF7; width: 100%; height: 252px; display: flex; justify-content: center; align-items: center;">
        <div class="container" style="text-align: left; padding: 20px; margin-left: 20px; max-width: 100%; box-sizing: border-box;">
            <h2 style="font-weight: bold; font-size: 34px; margin-bottom: -10px;">イベントを登録する</h2>
            <p>全国のAIクリエイターとつながり、<br>新しいプロジェクトを始めましょう</p>
            <a href="<?php echo esc_url(home_url('/register')); ?>" class="btn btn-primary" style="background-color: #FF966C; color: white; padding: 10px 20px; border-radius: 50px; text-decoration: none; border: none; display: inline-block; width: 208px; height: 35px; font-size: 15px; text-align: center; line-height: 35px;">新規登録をする</a>
        </div>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/9_Mindset_3D_Metal_Calendar.png'); ?>" alt="カレンダー" style="max-width: 100%; height: auto; margin-left: 120px; margin-top: -90px;" />
        <style>
            @media screen and (max-width: 768px) {
                .aqua-box-section .container {
                    margin-left: 20px !important;
                    padding: 15px !important;
                }
                .aqua-box-section h2 {
                    font-size: 28px !important;
                }
                .aqua-box-section br {
                    display: none;
                }
            }
            @media screen and (max-width: 480px) {
                .aqua-box-section .container {
                    margin-left: 10px !important;
                    padding: 10px !important;
                }
                .aqua-box-section h2 {
                    font-size: 24px !important;
                }
            }
        </style>
    </section>

    <!-- カテゴリー一覧 -->
    <section class="categories"> <?php // スタイルタグでマージンを設定済み ?>
        <div class="container">
            <h2 style="font-size: 40px;">Category</h2> <?php // TODO: インラインスタイルを削除し、CSSクラスに移行することを推奨します ?>
            <div class="categories-grid">
                <?php
                $categories = get_recruitment_categories();
                foreach ($categories as $slug => $name) :
                    $term = get_term_by('slug', $slug, 'recruitment_category');
                    if ($term) :
                ?>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-<?php echo esc_attr(get_category_icon($slug)); ?>"></i>
                        </div>
                        <h3><?php echo esc_html($name); ?></h3>
                        <p><?php echo esc_html($term->description); ?></p>
                    </div>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
</body>
</rewritten_file>