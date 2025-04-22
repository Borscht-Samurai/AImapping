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
                    <div class="media-buttons" style="margin-top: 10px; display: flex; gap: 10px;">
                        <button type="button" id="insert-media-button" class="btn btn-secondary" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                            <i class="fas fa-image" style="margin-right: 5px;"></i>画像を挿入
                        </button>
                        <button type="button" id="edit-image-button" class="btn btn-secondary" style="font-size: 0.9rem; padding: 0.5rem 1rem;" disabled>
                            <i class="fas fa-edit" style="margin-right: 5px;"></i>画像を編集
                        </button>
                    </div>
                    <div id="image-preview" style="margin-top: 10px; display: none;">
                        <h4 style="font-size: 1rem; margin-bottom: 5px;">プレビュー</h4>
                        <div id="preview-content" style="border: 1px solid #ddd; padding: 10px; border-radius: 4px; background-color: #f9f9f9;"></div>
                    </div>
                    <p class="form-hint" style="margin-top: 5px; font-size: 0.85rem; color: #666;">イベント内容に画像を挿入できます。ボタンをクリックして画像をアップロードしてください。挿入後の画像はテキスト内で選択して「画像を編集」ボタンでサイズ変更が可能です。</p>
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
                var selectedImageTag = null;
                var selectedImageRange = null;

                // テキストエリアの変更を監視してプレビューを更新
                $('#post_content').on('input selectionchange mouseup keyup', function() {
                    checkForImageTag();
                });

                // テキスト内の画像タグをチェックする関数
                function checkForImageTag() {
                    var textArea = $('#post_content');
                    var content = textArea.val();
                    var cursorPos = textArea.prop('selectionStart');
                    var cursorEnd = textArea.prop('selectionEnd');

                    // 選択範囲がある場合
                    if (cursorPos !== cursorEnd) {
                        var selectedText = content.substring(cursorPos, cursorEnd);
                        var imgTagRegex = /<img[^>]+>/i;

                        if (imgTagRegex.test(selectedText)) {
                            // 画像タグが選択されている場合
                            selectedImageTag = selectedText;
                            selectedImageRange = { start: cursorPos, end: cursorEnd };
                            $('#edit-image-button').prop('disabled', false);

                            // プレビューを表示
                            $('#preview-content').html(selectedText);
                            $('#image-preview').show();
                            return;
                        }
                    }

                    // 画像タグが選択されていない場合
                    selectedImageTag = null;
                    selectedImageRange = null;
                    $('#edit-image-button').prop('disabled', true);
                    $('#image-preview').hide();
                }

                // 画像編集ボタンのクリックイベント
                $('#edit-image-button').click(function() {
                    if (selectedImageTag) {
                        showImageEditDialog(selectedImageTag, selectedImageRange);
                    }
                });

                // 画像編集ダイアログを表示する関数
                function showImageEditDialog(imgTag, range) {
                    // 画像のURLを取得
                    var srcMatch = imgTag.match(/src=['"]([^'"]+)['"]/);
                    if (!srcMatch || !srcMatch[1]) return;

                    var imgSrc = srcMatch[1];

                    // 現在のサイズを取得
                    var widthMatch = imgTag.match(/width:\s*([^;]+);/);
                    var currentWidth = widthMatch ? widthMatch[1] : '50%';

                    // 中央揃えかどうかを取得
                    var isCentered = imgTag.includes('margin: 10px auto; display: block;');

                    // 既存のダイアログがあれば削除
                    $('#image-edit-dialog').remove();

                    // ダイアログのHTMLを作成
                    var dialogHtml = '<div id="image-edit-dialog" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">' +
                        '<div style="background: white; padding: 20px; border-radius: 8px; max-width: 500px; width: 90%;">' +
                            '<h3 style="margin-top: 0; margin-bottom: 15px;">画像サイズを編集</h3>' +
                            '<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px;">' +
                                '<div class="size-option" data-size="small" style="flex: 1; min-width: 120px; border: 2px solid #ddd; border-radius: 4px; padding: 10px; cursor: pointer; text-align: center;">' +
                                    '<img src="' + imgSrc + '" style="max-width: 100%; height: auto; max-height: 100px;" />' +
                                    '<p style="margin: 5px 0 0;">小さい (25%)</p>' +
                                '</div>' +
                                '<div class="size-option" data-size="medium" style="flex: 1; min-width: 120px; border: 2px solid #ddd; border-radius: 4px; padding: 10px; cursor: pointer; text-align: center;">' +
                                    '<img src="' + imgSrc + '" style="max-width: 100%; height: auto; max-height: 100px;" />' +
                                    '<p style="margin: 5px 0 0;">中くらい (50%)</p>' +
                                '</div>' +
                                '<div class="size-option" data-size="large" style="flex: 1; min-width: 120px; border: 2px solid #ddd; border-radius: 4px; padding: 10px; cursor: pointer; text-align: center;">' +
                                    '<img src="' + imgSrc + '" style="max-width: 100%; height: auto; max-height: 100px;" />' +
                                    '<p style="margin: 5px 0 0;">大きい (100%)</p>' +
                                '</div>' +
                            '</div>' +
                            '<div style="display: flex; justify-content: space-between;">' +
                                '<button id="cancel-edit" class="btn btn-secondary" style="padding: 8px 15px;">キャンセル</button>' +
                                '<div style="display: flex; gap: 10px;">' +
                                    '<label style="display: flex; align-items: center;">' +
                                        '<input type="checkbox" id="center-align-edit" ' + (isCentered ? 'checked' : '') + ' style="margin-right: 5px;">' +
                                        '中央揃え' +
                                    '</label>' +
                                    '<button id="update-image" class="btn btn-primary" style="padding: 8px 15px;">更新する</button>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';

                    // ダイアログを追加
                    $('body').append(dialogHtml);

                    // 選択されたサイズを設定
                    var selectedSize;
                    if (currentWidth === '25%') selectedSize = 'small';
                    else if (currentWidth === '50%') selectedSize = 'medium';
                    else if (currentWidth === '100%') selectedSize = 'large';
                    else selectedSize = 'medium';

                    // サイズオプションのクリックイベント
                    $('.size-option').click(function() {
                        $('.size-option').css('border-color', '#ddd');
                        $(this).css('border-color', '#6C63FF');
                        selectedSize = $(this).data('size');
                    });

                    // 現在のサイズを選択
                    $('.size-option[data-size="' + selectedSize + '"]').click();

                    // キャンセルボタン
                    $('#cancel-edit').click(function() {
                        $('#image-edit-dialog').remove();
                    });

                    // 更新ボタン
                    $('#update-image').click(function() {
                        var width;
                        switch(selectedSize) {
                            case 'small':
                                width = '25%';
                                break;
                            case 'medium':
                                width = '50%';
                                break;
                            case 'large':
                                width = '100%';
                                break;
                            default:
                                width = '50%';
                        }

                        var centerAlign = $('#center-align-edit').is(':checked');
                        var alignStyle = centerAlign ? 'margin: 10px auto; display: block;' : 'margin: 10px 0;';

                        // 新しい画像タグを作成
                        var newImgTag = imgTag.replace(/style="[^"]*"/, 'style="width: ' + width + '; height: auto; ' + alignStyle + '"');

                        // テキストエリアの内容を更新
                        var textArea = $('#post_content');
                        var content = textArea.val();
                        var newContent = content.substring(0, range.start) + newImgTag + content.substring(range.end);
                        textArea.val(newContent);

                        // プレビューを更新
                        $('#preview-content').html(newImgTag);

                        // 選択範囲を更新
                        selectedImageTag = newImgTag;
                        selectedImageRange = { start: range.start, end: range.start + newImgTag.length };

                        // ダイアログを閉じる
                        $('#image-edit-dialog').remove();
                    });
                }

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

                        // 画像サイズ選択ダイアログを表示
                        showImageSizeDialog(attachment);
                    });

                    // 画像サイズ選択ダイアログを表示する関数
                    function showImageSizeDialog(attachment) {
                        // 既存のダイアログがあれば削除
                        $('#image-size-dialog').remove();

                        // ダイアログのHTMLを作成
                        var dialogHtml = '<div id="image-size-dialog" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">' +
                            '<div style="background: white; padding: 20px; border-radius: 8px; max-width: 500px; width: 90%;">' +
                                '<h3 style="margin-top: 0; margin-bottom: 15px;">画像サイズを選択</h3>' +
                                '<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px;">' +
                                    '<div class="size-option" data-size="small" style="flex: 1; min-width: 120px; border: 2px solid #ddd; border-radius: 4px; padding: 10px; cursor: pointer; text-align: center;">' +
                                        '<img src="' + attachment.url + '" style="max-width: 100%; height: auto; max-height: 100px;" />' +
                                        '<p style="margin: 5px 0 0;">小さい (25%)</p>' +
                                    '</div>' +
                                    '<div class="size-option" data-size="medium" style="flex: 1; min-width: 120px; border: 2px solid #ddd; border-radius: 4px; padding: 10px; cursor: pointer; text-align: center;">' +
                                        '<img src="' + attachment.url + '" style="max-width: 100%; height: auto; max-height: 100px;" />' +
                                        '<p style="margin: 5px 0 0;">中くらい (50%)</p>' +
                                    '</div>' +
                                    '<div class="size-option" data-size="large" style="flex: 1; min-width: 120px; border: 2px solid #ddd; border-radius: 4px; padding: 10px; cursor: pointer; text-align: center;">' +
                                        '<img src="' + attachment.url + '" style="max-width: 100%; height: auto; max-height: 100px;" />' +
                                        '<p style="margin: 5px 0 0;">大きい (100%)</p>' +
                                    '</div>' +
                                '</div>' +
                                '<div style="display: flex; justify-content: space-between;">' +
                                    '<button id="cancel-insert" class="btn btn-secondary" style="padding: 8px 15px;">キャンセル</button>' +
                                    '<div style="display: flex; gap: 10px;">' +
                                        '<label style="display: flex; align-items: center;">' +
                                            '<input type="checkbox" id="center-align" style="margin-right: 5px;">' +
                                            '中央揃え' +
                                        '</label>' +
                                        '<button id="insert-selected-size" class="btn btn-primary" style="padding: 8px 15px;">挿入する</button>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';

                        // ダイアログを追加
                        $('body').append(dialogHtml);

                        // 選択されたサイズを追跡
                        var selectedSize = 'medium'; // デフォルトは中サイズ

                        // サイズオプションのクリックイベント
                        $('.size-option').click(function() {
                            $('.size-option').css('border-color', '#ddd');
                            $(this).css('border-color', '#6C63FF');
                            selectedSize = $(this).data('size');
                        });

                        // 中サイズをデフォルトで選択
                        $('.size-option[data-size="medium"]').click();

                        // キャンセルボタン
                        $('#cancel-insert').click(function() {
                            $('#image-size-dialog').remove();
                        });

                        // 挿入ボタン
                        $('#insert-selected-size').click(function() {
                            var width;
                            switch(selectedSize) {
                                case 'small':
                                    width = '25%';
                                    break;
                                case 'medium':
                                    width = '50%';
                                    break;
                                case 'large':
                                    width = '100%';
                                    break;
                                default:
                                    width = '50%';
                            }

                            var centerAlign = $('#center-align').is(':checked');
                            var alignStyle = centerAlign ? 'margin: 10px auto; display: block;' : 'margin: 10px 0;';

                            var imgTag = '<img src="' + attachment.url + '" alt="' + attachment.title + '" class="img-fluid" style="width: ' + width + '; height: auto; ' + alignStyle + '" />';

                            // カーソル位置に画像タグを挿入
                            var textArea = $('#post_content');
                            var cursorPos = textArea.prop('selectionStart');
                            var textBefore = textArea.val().substring(0, cursorPos);
                            var textAfter = textArea.val().substring(cursorPos);

                            // テキストエリアに画像タグを挿入
                            textArea.val(textBefore + imgTag + textAfter);

                            // ダイアログを閉じる
                            $('#image-size-dialog').remove();
                        });
                    }

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
