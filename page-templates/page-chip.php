<?php
/**
 * Template Name: Chip Page
 * Description: 応援するボタンから遷移するChipページのテンプレート
 */

get_header();
?>

<section class="chip-page-section">
    <div class="chip-header">
        <h1 class="chip-title">Chip</h1>
    </div>
    <div class="two-boxes-section">
        <div class="left-box">
            <div class="chip-container">
                <div class="chip-main-title">AI Mappingにチップをおくる</div>
                <div class="chip-main-desc">
                    AI Mappingを「いいね」と思ったあなたの気持ちを、<br>小さなご支援と共に。これからの利用の大きな力になります。
                </div>
                <div class="chip-options-grid">
                    <div class="chip-option-card">
                        <div class="chip-icon">🥤</div>
                        <div class="chip-amount">￥100</div>
                    </div>
                    <div class="chip-option-card">
                        <div class="chip-icon">☕</div>
                        <div class="chip-amount">￥500</div>
                    </div>
                    <div class="chip-option-card">
                        <div class="chip-icon">🍔</div>
                        <div class="chip-amount">￥1000</div>
                    </div>
                    <div class="chip-option-card">
                        <div class="chip-icon">♡</div>
                        <div class="chip-amount">任意</div>
                    </div>
                </div>
                <div class="chip-buttons">
                    <button class="chip-btn confirm">確認</button>
                    <button class="chip-btn cancel">キャンセル</button>
                </div>
            </div>
        </div>
        <div class="right-box">
            <div class="google-adsense-box">
                <div class="adsense-dummy">Googleアドセンス入れます？</div>
            </div>
            <div class="categories-sidebar" style="margin-top: 30px;">
                <h3 class="categories-title">Categories</h3>
                <ul class="categories-list">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'recruitment_category',
                        'hide_empty' => false,
                        'orderby' => 'name',
                        'order' => 'ASC'
                    ));
                    if (!empty($categories) && !is_wp_error($categories)) :
                        foreach ($categories as $category) :
                            $category_link = add_query_arg(array(
                                'category' => $category->term_id
                            ), home_url('/recruitment'));
                    ?>
                        <li class="category-item">
                            <a href="<?php echo esc_url($category_link); ?>" class="category-link">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                    <?php
                        endforeach;
                    else :
                        echo '<li class="no-categories">カテゴリーがありません</li>';
                    endif;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap');

.chip-page-section {
    padding: 0;
    background-color: #E7E7E7;
    min-height: 100vh;
}
.chip-header {
    margin: 0 0 0 20px;
}
.chip-title {
    font-size: 160px;
    line-height: 1;
    margin: 0;
    text-align: left;
    font-weight: 500;
    font-family: 'Poppins', sans-serif;
    letter-spacing: -0.08em;
}
.two-boxes-section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}
.left-box {
    background-color: #E7E7E7;
    border-radius: 10px;
    padding: 0 0 0 40px;
    display: flex;
    align-items: flex-start;
}
.chip-container {
    width: 100%;
    max-width: 500px;
    margin-top: 40px;
}
.chip-main-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 10px;
    text-align: left;
    font-family: 'Noto Sans JP', sans-serif;
}
.chip-main-desc {
    font-size: 1rem;
    color: #666;
    margin-bottom: 40px;
    text-align: left;
}
.chip-options-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 40px;
}
.chip-option-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 140px;
    font-size: 1.3rem;
    cursor: pointer;
    transition: box-shadow 0.2s;
}
.chip-option-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}
.chip-icon {
    font-size: 2.5rem;
    margin-bottom: 10px;
}
.chip-amount {
    font-size: 1.1rem;
    font-weight: 500;
}
.chip-buttons {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-top: 20px;
}
.chip-btn {
    width: 100%;
    padding: 18px 0;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: bold;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: background 0.2s, color 0.2s;
}
.chip-btn.confirm {
    background: #000;
    color: #fff;
}
.chip-btn.cancel {
    background: #fff;
    color: #000;
}
.chip-btn.cancel:hover {
    background: #f0f0f0;
}
.right-box {
    background-color: #E7E7E7;
    border-radius: 10px;
    padding: 20px;
    width: 340px;
    min-width: 260px;
    max-width: 400px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.google-adsense-box {
    width: 100%;
    margin-bottom: 30px;
}
.adsense-dummy {
    background: #FF966C;
    color: #fff;
    border-radius: 8px;
    padding: 24px 16px;
    font-size: 1rem;
    text-align: left;
    min-height: 80px;
    display: flex;
    align-items: center;
}
.categories-sidebar {
    background-color: #E7E7E7;
    padding: 0;
    width: 100%;
}
.categories-title {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
}
.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.category-item {
    margin-bottom: 8px;
}
.category-link {
    display: block;
    padding: 6px 0;
    color: #222;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.2s;
}
.category-link:hover {
    color: #FF966C;
}
.no-categories {
    color: #999;
    font-style: italic;
}
@media (max-width: 900px) {
    .chip-title {
        font-size: 80px;
    }
    .two-boxes-section {
        grid-template-columns: 1fr;
        gap: 0;
    }
    .right-box {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        margin-top: 40px;
    }
    .left-box {
        padding-left: 0;
        justify-content: center;
    }
    .chip-container {
        margin: 0 auto;
    }
}
</style>

<?php get_footer(); ?> 