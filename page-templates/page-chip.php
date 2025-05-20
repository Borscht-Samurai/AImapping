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
                        <img src="<?php echo get_template_directory_uri(); ?>/images/fluent_drink-bottle-20-regular.png" alt="ドリンク" class="chip-icon-img">
                        <div class="chip-amount">￥100</div>
                    </div>
                    <div class="chip-option-card">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/coffee.png" alt="コーヒー" class="chip-icon-img">
                        <div class="chip-amount">￥500</div>
                    </div>
                    <div class="chip-option-card">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/setdrink.png" alt="ハンバーガーセット" class="chip-icon-img">
                        <div class="chip-amount">￥1000</div>
                    </div>
                    <div class="chip-option-card">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/hurt.png" alt="ハート" class="chip-icon-img">
                        <div class="chip-amount">任意</div>
                    </div>
                </div>
                <div class="chip-buttons">
                    <button class="chip-btn confirm">確認</button>
                    <button class="chip-btn cancel" onclick="window.history.back()">キャンセル</button>
                </div>
            </div>
        </div>
        <div class="right-box">
            <div class="google-adsense-box">
                <div class="adsense-dummy">Googleアドセンス入れます？</div>
            </div>
            <div class="categories-sidebar">
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
            <div class="support-button-section">
                <a href="<?php echo esc_url(home_url('/chip')); ?>" class="support-button">
                    運営にチップを送る <i class="fas fa-coffee"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?> 