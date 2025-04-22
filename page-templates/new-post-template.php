<?php
/**
 * Template Name: 新規投稿
 * Description: 新規投稿作成用のテンプレート
 */

// WordPressメディアアップローダーのスクリプトを読み込み
wp_enqueue_media();

get_header();
?>

<main class="site-main">
    <!-- グラデーションセクション -->
    <section class="gradient-box-section">
        <div class="gradient-box">
            <div class="gradient-box-content">
                <h1 class="recruitment-title" style="color: white;">新規イベントの投稿</h1>
            </div>
        </div>
    </section>

    <div class="container" style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
        <?php if (is_user_logged_in()) : ?>
            <form id="new-post-form" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data" style="max-width: 800px; margin: 0 auto; padding: 2rem 0;">
                <?php wp_nonce_field('new_post_action', 'new_post_nonce'); ?>

                <div class="form-group">
                    <label for="post_title">イベントタイトル <span class="required">*</span></label>
                    <input type="text" id="post_title" name="post_title" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="post_content">イベント内容 <span class="required">*</span></label>
                    <textarea id="post_content" name="post_content" required class="form-control" rows="5"></textarea>
                    <div class="media-buttons" style="margin-top: 10px;">
                        <button type="button" id="insert-media-button" class="btn btn-secondary" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                            <i class="fas fa-image" style="margin-right: 5px;"></i>画像を挿入
                        </button>
                    </div>
                    <p class="form-hint" style="margin-top: 5px; font-size: 0.85rem; color: #666;">イベント内容に画像を挿入できます。ボタンをクリックして画像をアップロードしてください。</p>
                </div>

                <div class="form-group">
                    <label for="post_category">カテゴリー <span class="required">*</span></label>
                    <select id="post_category" name="post_category" required class="form-control">
                        <option value="">選択してください</option>
                        <?php
                        $categories = get_recruitment_categories();
                        foreach ($categories as $slug => $name) :
                        ?>
                            <option value="<?php echo esc_attr($slug); ?>"><?php echo esc_html($name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="event_date">開催日時 <span class="required">*</span></label>
                    <input type="datetime-local" id="event_date" name="event_date" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="location_type">開催形式 <span class="required">*</span></label>
                    <select id="location_type" name="location_type" required class="form-control">
                        <option value="">選択してください</option>
                        <option value="online">オンライン</option>
                        <option value="offline">オフライン</option>
                    </select>
                </div>

                <div class="form-group" id="location_detail_group" style="display: none;">
                    <label for="location_detail">開催場所 (都道府県)</label>
                    <select id="location_detail" name="location_detail" class="form-control">
                        <option value="">選択してください</option>
                        <option value="北海道">北海道</option>
                        <option value="青森県">青森県</option>
                        <option value="岩手県">岩手県</option>
                        <option value="宮城県">宮城県</option>
                        <option value="秋田県">秋田県</option>
                        <option value="山形県">山形県</option>
                        <option value="福島県">福島県</option>
                        <option value="茨城県">茨城県</option>
                        <option value="栃木県">栃木県</option>
                        <option value="群馬県">群馬県</option>
                        <option value="埼玉県">埼玉県</option>
                        <option value="千葉県">千葉県</option>
                        <option value="東京都">東京都</option>
                        <option value="神奈川県">神奈川県</option>
                        <option value="新潟県">新潟県</option>
                        <option value="富山県">富山県</option>
                        <option value="石川県">石川県</option>
                        <option value="福井県">福井県</option>
                        <option value="山梨県">山梨県</option>
                        <option value="長野県">長野県</option>
                        <option value="岐阜県">岐阜県</option>
                        <option value="静岡県">静岡県</option>
                        <option value="愛知県">愛知県</option>
                        <option value="三重県">三重県</option>
                        <option value="滋賀県">滋賀県</option>
                        <option value="京都府">京都府</option>
                        <option value="大阪府">大阪府</option>
                        <option value="兵庫県">兵庫県</option>
                        <option value="奈良県">奈良県</option>
                        <option value="和歌山県">和歌山県</option>
                        <option value="鳥取県">鳥取県</option>
                        <option value="島根県">島根県</option>
                        <option value="岡山県">岡山県</option>
                        <option value="広島県">広島県</option>
                        <option value="山口県">山口県</option>
                        <option value="徳島県">徳島県</option>
                        <option value="香川県">香川県</option>
                        <option value="愛媛県">愛媛県</option>
                        <option value="高知県">高知県</option>
                        <option value="福岡県">福岡県</option>
                        <option value="佐賀県">佐賀県</option>
                        <option value="長崎県">長崎県</option>
                        <option value="熊本県">熊本県</option>
                        <option value="大分県">大分県</option>
                        <option value="宮崎県">宮崎県</option>
                        <option value="鹿児島県">鹿児島県</option>
                        <option value="沖縄県">沖縄県</option>
                    </select>
                </div>

                <div class="form-actions" style="text-align: center; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">イベントを投稿する</button>
                </div>
            </form>

            <script>
            jQuery(document).ready(function($) {
                // 開催形式の変更時の処理
                $('#location_type').change(function() {
                    if ($(this).val() === 'offline') {
                        $('#location_detail_group').show();
                    } else {
                        $('#location_detail_group').hide();
                    }
                });

                // メディアアップローダーの初期化
                var mediaUploader;

                $('#insert-media-button').click(function(e) {
                    e.preventDefault();

                    // メディアアップローダーが既に存在する場合は再利用
                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }

                    // メディアアップローダーの作成
                    mediaUploader = wp.media({
                        title: 'イベント内容に挿入する画像を選択',
                        button: {
                            text: '画像を挿入'
                        },
                        multiple: false
                    });

                    // 画像選択時の処理
                    mediaUploader.on('select', function() {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();
                        var imgTag = '<img src="' + attachment.url + '" alt="' + attachment.title + '" class="img-fluid" style="max-width: 100%; height: auto; margin: 10px 0;" />';

                        // カーソル位置に画像タグを挿入
                        var textArea = $('#post_content');
                        var cursorPos = textArea.prop('selectionStart');
                        var textBefore = textArea.val().substring(0, cursorPos);
                        var textAfter = textArea.val().substring(cursorPos);

                        // テキストエリアに画像タグを挿入
                        textArea.val(textBefore + imgTag + textAfter);
                    });

                    // メディアアップローダーを開く
                    mediaUploader.open();
                });
            });
            </script>
        <?php else : ?>
            <div style="text-align: center; padding: 2rem 0;">
                <p class="login-required" style="margin-bottom: 1.5rem; font-size: 1.1rem;">イベントを投稿するにはログインが必要です。</p>
                <a href="<?php echo esc_url(home_url('/login')); ?>" class="btn btn-primary">ログインする</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
