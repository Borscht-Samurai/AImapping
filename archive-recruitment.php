<?php
// archive-recruitment.php - 募集一覧ページテンプレート
get_header();
?>

<style>
.search-filters {
    background-color: #000000;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 32px;
    font-size: 0.8rem;
}

.search-filters label {
    color: #ffffff;
}

/* ドロップダウンメニューの白色下線デザイン */
.search-filters select,
.search-filters .dropdown-select,
.search-filters select.dropdown-select,
#category,
#orderby,
#location,
#event_location {
    background-color: #000000 !important;
    color: #ffffff !important;
    border: none !important;
    border-bottom: 1px solid #ffffff !important;
    border-radius: 0 !important;
    padding: 8px 16px 8px 0 !important;
    width: 100% !important;
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="6" viewBox="0 0 12 6"><path fill="white" d="M0 0l6 6 6-6z"/></svg>') !important;
    background-repeat: no-repeat !important;
    background-position: right 0.5rem center !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    box-shadow: none !important;
}

.search-filters select:hover,
.search-filters .dropdown-select:hover,
#category:hover,
#orderby:hover,
#location:hover,
#event_location:hover {
    border-bottom: 2px solid #ffffff !important;
    transform: translateY(-2px);
    background-color: #000000 !important;
}

.search-filters select:focus,
.search-filters .dropdown-select:focus,
#category:focus,
#orderby:focus,
#location:focus,
#event_location:focus {
    outline: none !important;
    border-bottom: 2px solid #ffffff !important;
    background-color: #000000 !important;
    box-shadow: none !important;
}

.search-filters select option,
.search-filters .dropdown-select option,
#category option,
#orderby option,
#location option,
#event_location option {
    background-color: #000000 !important;
    color: #ffffff !important;
}

/* 白色下線のボタンデザイン */
.search-underline-btn {
    color: #ffffff !important;
    background-color: #000000 !important;
    background: none !important;
    border: none !important;
    padding: 8px 16px !important;
    position: relative !important;
    cursor: pointer !important;
    font-size: 0.9rem !important;
    transition: all 0.3s ease !important;
    box-shadow: none !important;
}

.search-underline-btn::after {
    content: '' !important;
    position: absolute !important;
    width: 100% !important;
    height: 1px !important;
    bottom: 0 !important;
    left: 0 !important;
    background-color: #ffffff !important;
    transition: all 0.3s ease !important;
}

.search-underline-btn:hover::after {
    height: 2px !important;
}

.search-underline-btn:hover {
    transform: translateY(-2px) !important;
    background-color: #000000 !important;
}
</style>

<main class="site-main">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="archive-header mb-8">
            <h1 class="text-3xl font-bold mb-4">Events</h1>
            <div class="archive-description">
                <p class="text-gray-600">AIを活用するクリエイター同士が集まる募集を探すことができます。</p>
            </div>
        </div>

        <!-- 検索フィルター -->
        <div class="search-filters">
            <form class="filter-form flex flex-wrap gap-4" method="get">
                <div class="filter-group flex-1 min-w-[200px]">
                    <label for="category">カテゴリー：</label>
                    <?php
                    // カテゴリードロップダウンのスタイルを上書きするスクリプトを追加
                    add_action('wp_footer', function() {
                        echo '<script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // ドロップダウンのスタイルを強制的に適用
                                const dropdowns = document.querySelectorAll("#category, #orderby, #location, #event_location");
                                dropdowns.forEach(function(dropdown) {
                                    dropdown.style.backgroundColor = "#000000";
                                    dropdown.style.color = "#ffffff";
                                    dropdown.style.border = "none";
                                    dropdown.style.borderBottom = "1px solid #ffffff";
                                    dropdown.style.borderRadius = "0";
                                    dropdown.style.boxShadow = "none";
                                });
                            });
                        </script>';
                    });

                    wp_dropdown_categories(array(
                        'taxonomy' => 'recruitment_category',
                        'name' => 'category',
                        'selected' => isset($_GET['category']) ? $_GET['category'] : 0,
                        'show_option_all' => 'すべてのカテゴリー',
                        'hide_empty' => true,
                        'class' => 'dropdown-select'
                    ));
                    ?>
                </div>

                <div class="filter-group flex-1 min-w-[200px]">
                    <label for="orderby">並び順：</label>
                    <select name="orderby" id="orderby" class="dropdown-select">
                        <option value="date" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'date'); ?>>新着順</option>
                        <option value="views" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'views'); ?>>閲覧数順</option>
                        <option value="likes" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'likes'); ?>>いいね数順</option>
                    </select>
                </div>

                <div class="filter-group flex-1 min-w-[200px]">
                    <label for="location">開催形式：</label>
                    <select name="location" id="location" class="dropdown-select">
                        <option value="">すべて</option>
                        <option value="online" <?php selected(isset($_GET['location']) ? $_GET['location'] : '', 'online'); ?>>オンライン</option>
                        <option value="offline" <?php selected(isset($_GET['location']) ? $_GET['location'] : '', 'offline'); ?>>オフライン</option>
                    </select>
                </div>

                <div class="filter-group flex-1 min-w-[200px]">
                    <label for="event_location">開催場所：</label>
                    <select name="event_location" id="event_location" class="dropdown-select">
                        <option value="">すべての場所</option>
                        <option value="北海道" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '北海道'); ?>>北海道</option>
                        <option value="青森県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '青森県'); ?>>青森県</option>
                        <option value="岩手県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '岩手県'); ?>>岩手県</option>
                        <option value="宮城県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '宮城県'); ?>>宮城県</option>
                        <option value="秋田県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '秋田県'); ?>>秋田県</option>
                        <option value="山形県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '山形県'); ?>>山形県</option>
                        <option value="福島県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '福島県'); ?>>福島県</option>
                        <option value="茨城県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '茨城県'); ?>>茨城県</option>
                        <option value="栃木県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '栃木県'); ?>>栃木県</option>
                        <option value="群馬県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '群馬県'); ?>>群馬県</option>
                        <option value="埼玉県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '埼玉県'); ?>>埼玉県</option>
                        <option value="千葉県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '千葉県'); ?>>千葉県</option>
                        <option value="東京都" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '東京都'); ?>>東京都</option>
                        <option value="神奈川県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '神奈川県'); ?>>神奈川県</option>
                        <option value="新潟県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '新潟県'); ?>>新潟県</option>
                        <option value="富山県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '富山県'); ?>>富山県</option>
                        <option value="石川県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '石川県'); ?>>石川県</option>
                        <option value="福井県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '福井県'); ?>>福井県</option>
                        <option value="山梨県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '山梨県'); ?>>山梨県</option>
                        <option value="長野県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '長野県'); ?>>長野県</option>
                        <option value="岐阜県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '岐阜県'); ?>>岐阜県</option>
                        <option value="静岡県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '静岡県'); ?>>静岡県</option>
                        <option value="愛知県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '愛知県'); ?>>愛知県</option>
                        <option value="三重県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '三重県'); ?>>三重県</option>
                        <option value="滋賀県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '滋賀県'); ?>>滋賀県</option>
                        <option value="京都府" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '京都府'); ?>>京都府</option>
                        <option value="大阪府" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '大阪府'); ?>>大阪府</option>
                        <option value="兵庫県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '兵庫県'); ?>>兵庫県</option>
                        <option value="奈良県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '奈良県'); ?>>奈良県</option>
                        <option value="和歌山県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '和歌山県'); ?>>和歌山県</option>
                        <option value="鳥取県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '鳥取県'); ?>>鳥取県</option>
                        <option value="島根県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '島根県'); ?>>島根県</option>
                        <option value="岡山県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '岡山県'); ?>>岡山県</option>
                        <option value="広島県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '広島県'); ?>>広島県</option>
                        <option value="山口県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '山口県'); ?>>山口県</option>
                        <option value="徳島県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '徳島県'); ?>>徳島県</option>
                        <option value="香川県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '香川県'); ?>>香川県</option>
                        <option value="愛媛県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '愛媛県'); ?>>愛媛県</option>
                        <option value="高知県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '高知県'); ?>>高知県</option>
                        <option value="福岡県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '福岡県'); ?>>福岡県</option>
                        <option value="佐賀県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '佐賀県'); ?>>佐賀県</option>
                        <option value="長崎県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '長崎県'); ?>>長崎県</option>
                        <option value="熊本県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '熊本県'); ?>>熊本県</option>
                        <option value="大分県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '大分県'); ?>>大分県</option>
                        <option value="宮崎県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '宮崎県'); ?>>宮崎県</option>
                        <option value="鹿児島県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '鹿児島県'); ?>>鹿児島県</option>
                        <option value="沖縄県" <?php selected(isset($_GET['event_location']) ? $_GET['event_location'] : '', '沖縄県'); ?>>沖縄県</option>
                    </select>
                </div>

                <div class="filter-actions flex-1 min-w-[200px] flex items-end">
                    <button type="submit" class="search-underline-btn">検索</button>
                </div>
            </form>
        </div>

        <!-- 募集一覧 -->
        <?php if (have_posts()) : ?>
            <!-- 募集一覧グリッド - style.cssで統一されたクラス使用 -->
            <div class="events-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'card'); ?>
                <?php endwhile; ?>
            </div>

            <!-- ページネーション -->
            <div class="mt-8">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '<i class="fas fa-chevron-left mr-1"></i>前へ',
                    'next_text' => '次へ<i class="fas fa-chevron-right ml-1"></i>',
                    'mid_size' => 2,
                    'class' => 'pagination-neumorphism',
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="text-center py-12 bg-white rounded-lg shadow-neumorphism">
                <p class="text-gray-600 mb-4">該当する募集が見つかりませんでした。</p>
                <a href="<?php echo esc_url(home_url('/recruitment')); ?>" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                    すべての募集を見る
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const locationSelect = document.getElementById('location');
    const eventLocationSelect = document.getElementById('event_location');

    // イベント場所が選択されたら開催形式をオフラインに自動設定
    eventLocationSelect.addEventListener('change', function() {
        if (this.value !== '') {
            locationSelect.value = 'offline';
        }
    });

    // 開催形式がオンラインに変更されたらイベント場所の選択をリセット
    locationSelect.addEventListener('change', function() {
        if (this.value === 'online') {
            eventLocationSelect.value = '';
        }
    });
});
</script>

<?php get_footer(); ?>