<?php
/**
 * Template Name: Chip Page
 * Description: 応援するボタンから遷移するChipページのテンプレート
 */

get_header();
?>

<section class="chip-page-section">
    <div class="two-boxes-section">
        <div class="left-box">
            <div class="chip-container">
                <h1 class="chip-title">応援する</h1>
                
                <div class="chip-content">
                    <div class="chip-description">
                        <p>このプロジェクトを応援する</p>
                        <p class="chip-subtitle"><?php the_title(); ?></p>
                    </div>

                    <div class="chip-options">
                        <div class="chip-option">
                            <input type="radio" name="chip-amount" id="chip-100" value="100">
                            <label for="chip-100">100円</label>
                        </div>
                        <div class="chip-option">
                            <input type="radio" name="chip-amount" id="chip-300" value="300">
                            <label for="chip-300">300円</label>
                        </div>
                        <div class="chip-option">
                            <input type="radio" name="chip-amount" id="chip-500" value="500">
                            <label for="chip-500">500円</label>
                        </div>
                        <div class="chip-option">
                            <input type="radio" name="chip-amount" id="chip-1000" value="1000">
                            <label for="chip-1000">1,000円</label>
                        </div>
                        <div class="chip-option custom">
                            <input type="number" name="custom-amount" id="custom-amount" placeholder="その他の金額">
                        </div>
                    </div>

                    <div class="payment-methods">
                        <h3>お支払い方法</h3>
                        <div class="payment-options">
                            <div class="payment-option">
                                <input type="radio" name="payment-method" id="credit-card" value="credit-card">
                                <label for="credit-card">クレジットカード</label>
                            </div>
                            <div class="payment-option">
                                <input type="radio" name="payment-method" id="bank-transfer" value="bank-transfer">
                                <label for="bank-transfer">銀行振込</label>
                            </div>
                        </div>
                    </div>

                    <button class="support-submit-button">
                        応援する <i class="fas fa-coffee"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="right-box">
            <div class="google-adsense-box">
                <!-- ここにコンテンツを追加 -->
            </div>

            <!-- カテゴリーセクション -->
            <div class="categories-sidebar" style="margin-top: 30px;">
                <h3 class="categories-title">Categories</h3>
                <ul class="categories-list">
                    <?php
                    // データベースから実際のカテゴリーを取得
                    $categories = get_terms(array(
                        'taxonomy' => 'recruitment_category',
                        'hide_empty' => false, // 投稿がないカテゴリーも表示
                        'orderby' => 'name', // 名前順で並び替え
                        'order' => 'ASC'
                    ));

                    if (!empty($categories) && !is_wp_error($categories)) :
                        foreach ($categories as $category) :
                            // カテゴリーのリンクを生成
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
                        // カテゴリーが存在しない場合のメッセージ
                        echo '<li class="no-categories">カテゴリーがありません</li>';
                    endif;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
.chip-page-section {
    padding: 40px 20px;
    background-color: #E7E7E7;
    min-height: 100vh;
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
}

.right-box {
    background-color: #E7E7E7;
    border-radius: 10px;
    padding: 20px;
    width: fit-content;
}

.chip-container {
    padding: 30px;
}

.chip-title {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 30px;
    color: #333;
}

.chip-description {
    text-align: center;
    margin-bottom: 30px;
}

.chip-subtitle {
    font-size: 1.2rem;
    color: #666;
    margin-top: 10px;
}

.chip-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}

.chip-option {
    position: relative;
}

.chip-option input[type="radio"] {
    display: none;
}

.chip-option label {
    display: block;
    padding: 15px;
    text-align: center;
    background: #E7E7E7;
    border: 2px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chip-option input[type="radio"]:checked + label {
    background: #4CAF50;
    color: white;
    border-color: #4CAF50;
}

.chip-option.custom {
    grid-column: span 2;
}

.chip-option.custom input {
    width: 100%;
    padding: 15px;
    border: 2px solid #ddd;
    border-radius: 5px;
    text-align: center;
}

.payment-methods {
    margin-bottom: 30px;
}

.payment-methods h3 {
    margin-bottom: 15px;
    color: #333;
}

.payment-options {
    display: grid;
    gap: 10px;
}

.payment-option {
    position: relative;
}

.payment-option input[type="radio"] {
    display: none;
}

.payment-option label {
    display: block;
    padding: 12px;
    background: #E7E7E7;
    border: 2px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-option input[type="radio"]:checked + label {
    background: #4CAF50;
    color: white;
    border-color: #4CAF50;
}

.support-submit-button {
    width: 100%;
    padding: 15px;
    background: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

.support-submit-button:hover {
    background: #45a049;
}

.support-submit-button i {
    margin-left: 8px;
}

.categories-sidebar {
    background-color: #E7E7E7;
    padding: 20px;
    width: 100%;
}

.categories-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: #333;
}

.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-item {
    margin-bottom: 10px;
}

.category-link {
    display: block;
    padding: 8px 12px;
    color: #666;
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-link:hover {
    background-color: #ffffff;
    color: #333;
    transform: translateX(5px);
}

.no-categories {
    color: #999;
    font-style: italic;
}

@media (max-width: 768px) {
    .two-boxes-section {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?> 