<?php get_header(); ?>

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
    display: flex;
    align-items: center;
    padding-left: 20px; /* 左側に20pxのパディングを追加 */
}

.exchange-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start; /* 左寄せに設定 */
}

.exchange-image {
    margin: 50px 0 15px 0; /* 上に50px、下に15pxのマージンを追加 */
    max-width: 100%;
    height: auto;
}

.exchange-text {
    font-family: 'Noto Sans JP', sans-serif;
    font-weight: 400;
    font-size: 18px;
    line-height: 160%;
    color: #333;
    margin: 0 0 10px 0; /* 下に50pxのマージンを追加 */
}

/* ピクニック画像のスタイル */
.picnic-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start; /* 左寄せに設定 */
    margin-top: 30px; /* 無料ではじめるボタンとの間隔 */
}

.picnic-image {
    margin: 50px 0 15px 0; /* 上に50px、下に15pxのマージンを追加 */
    max-width: 100%;
    height: auto;
}

.picnic-text {
    font-family: 'Noto Sans JP', sans-serif;
    font-weight: 400;
    font-size: 18px;
    line-height: 160%;
    color: #333;
    margin: 0 0 10px 0;
}

/* グラデーションセクション */
.gradient-box-section {
    width: calc(100% - 10px); /* マージン分を引く */
    margin: 0 5px;
    padding: 0;
    position: relative;
    z-index: 1;
    margin-top: 10px;
    box-sizing: border-box;
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
    <div class="frontpage-2-image-wrapper" style="width:1110px; margin: 0 auto 40px auto; display:flex; justify-content:flex-start;">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/frontpage-2.png'); ?>" alt="フロントページ画像2" style="max-width:100%; height:auto; display:block; margin-left:15px;">
    </div>
    <!-- frontpage-3画像 中央揃え配置 -->
    <div style="width:100%; display:flex; justify-content:center; align-items:center; margin-top:50px; margin-bottom:40px;">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/frontpage-3.png'); ?>" alt="フロントページ画像3" style="max-width:1110px; width:100%; height:auto; display:block;">
    </div>

</main>

<?php get_footer(); ?>