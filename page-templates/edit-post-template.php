<?php
/**
 * Template Name: 投稿編集ページ
 */

// ログインしていないユーザーはログインページにリダイレクト
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

// 編集対象の投稿IDを取得
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

// 投稿が存在するかチェック
$post = get_post($post_id);
if (!$post || $post->post_type !== 'recruitment') {
    wp_redirect(home_url('/recruitment'));
    exit;
}

// 投稿の著者かどうかチェック（管理者は除く）
if (get_current_user_id() !== $post->post_author && !current_user_can('administrator')) {
    wp_redirect(get_permalink($post_id));
    exit;
}

get_header();
?>

<main class="site-main">
    <div class="container">
        <div class="post-form-container">
            <h1 class="form-title">募集の編集</h1>

            <?php
            // 投稿の更新処理
            if (isset($_POST['update_event'])) {
                // NonceチェックとCSRF対策
                if (!isset($_POST['event_nonce_field']) || !wp_verify_nonce($_POST['event_nonce_field'], 'event_nonce_action')) {
                    echo '<div class="form-message error">セキュリティチェックに失敗しました。</div>';
                } else {
                    // バリデーション
                    $errors = array();

                    if (empty($_POST['event_title'])) {
                        $errors[] = '募集タイトルは必須です。';
                    }

                    if (empty($_POST['event_content'])) {
                        $errors[] = '募集内容は必須です。';
                    }

                    if (empty($_POST['event_date'])) {
                        $errors[] = '開催日時は必須です。';
                    }

                    if ($_POST['event_is_online'] == '0' && empty($_POST['event_location'])) {
                        $errors[] = 'オフラインイベントの場合、開催場所は必須です。';
                    }

                    // カテゴリーが選択されているか
                    if (empty($_POST['event_category'])) {
                        $errors[] = 'カテゴリーを選択してください。';
                    }

                    // エラーがなければ投稿を更新
                    if (empty($errors)) {
                        $post_data = array(
                            'ID'            => $post_id,
                            'post_title'    => sanitize_text_field($_POST['event_title']),
                            'post_content'  => wp_kses_post($_POST['event_content']),
                        );

                        // 投稿を更新
                        $updated = wp_update_post($post_data);

                        if ($updated) {
                            // カスタムフィールドの更新
                            update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
                            update_post_meta($post_id, 'event_is_online', intval($_POST['event_is_online']));

                            if (!empty($_POST['event_location'])) {
                                update_post_meta($post_id, 'event_location', sanitize_text_field($_POST['event_location']));
                            } else {
                                delete_post_meta($post_id, 'event_location');
                            }

                            // カテゴリーの更新
                            if (!empty($_POST['event_category'])) {
                                wp_set_object_terms($post_id, intval($_POST['event_category']), 'recruitment_category');
                            }

                            // アイキャッチ画像の更新
                            if (!empty($_FILES['event_thumbnail']['name'])) {
                                require_once(ABSPATH . 'wp-admin/includes/image.php');
                                require_once(ABSPATH . 'wp-admin/includes/file.php');
                                require_once(ABSPATH . 'wp-admin/includes/media.php');

                                // 既存のアイキャッチ画像を削除
                                $old_thumbnail_id = get_post_thumbnail_id($post_id);
                                if ($old_thumbnail_id) {
                                    wp_delete_attachment($old_thumbnail_id, true);
                                }

                                $attachment_id = media_handle_upload('event_thumbnail', $post_id);

                                if (!is_wp_error($attachment_id)) {
                                    set_post_thumbnail($post_id, $attachment_id);
                                }
                            }

                            echo '<div class="form-message success">募集が更新されました。 <a href="' . get_permalink($post_id) . '">募集ページを表示</a></div>';
                        } else {
                            echo '<div class="form-message error">募集の更新に失敗しました。</div>';
                        }
                    } else {
                        // エラーメッセージの表示
                        echo '<div class="form-message error"><ul>';
                        foreach ($errors as $error) {
                            echo '<li>' . esc_html($error) . '</li>';
                        }
                        echo '</ul></div>';
                    }
                }
            }

            // 現在の投稿データを取得
            $event_title = $post->post_title;
            $event_content = $post->post_content;
            $event_date = get_post_meta($post_id, 'event_date', true);
            $event_is_online = get_post_meta($post_id, 'event_is_online', true);
            $event_location = get_post_meta($post_id, 'event_location', true);

            // 現在のカテゴリーを取得
            $current_categories = wp_get_post_terms($post_id, 'recruitment_category', array('fields' => 'ids'));
            $current_category = !empty($current_categories) ? $current_categories[0] : 0;
            ?>

            <form class="post-form" method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('event_nonce_action', 'event_nonce_field'); ?>

                <div class="form-group">
                    <label for="event_title">募集タイトル <span class="required">*</span></label>
                    <input type="text" id="event_title" name="event_title" class="form-control" value="<?php echo esc_attr($event_title); ?>" required>
                </div>

                <div class="form-group">
                    <label for="event_content">募集内容 <span class="required">*</span></label>
                    <textarea id="event_content" name="event_content" class="form-control" rows="8" required><?php echo esc_textarea($event_content); ?></textarea>
                    <p class="form-hint">募集の詳細、参加条件、持ち物などを記載してください。</p>
                </div>

                <div class="form-row">
                    <div class="form-group form-col">
                        <label for="event_date">開催日時 <span class="required">*</span></label>
                        <input type="datetime-local" id="event_date" name="event_date" class="form-control" value="<?php echo esc_attr($event_date); ?>" required>
                    </div>

                    <div class="form-group form-col">
                        <label for="event_is_online">開催形式 <span class="required">*</span></label>
                        <select id="event_is_online" name="event_is_online" class="form-control">
                            <option value="0" <?php selected($event_is_online, '0'); ?>>オフライン</option>
                            <option value="1" <?php selected($event_is_online, '1'); ?>>オンライン</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="location_group">
                    <label for="event_location">開催場所</label>
                    <input type="text" id="event_location" name="event_location" class="form-control" value="<?php echo esc_attr($event_location); ?>">
                    <p class="form-hint">オフラインイベントの場合は必須です。</p>
                </div>

                <div class="form-group">
                    <label for="event_category">カテゴリー <span class="required">*</span></label>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'recruitment_category',
                        'hide_empty' => false
                    ));

                    if (!empty($categories) && !is_wp_error($categories)) : ?>
                        <select id="event_category" name="event_category" class="form-control" required>
                            <option value="">カテゴリーを選択</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo esc_attr($category->term_id); ?>" <?php selected($current_category, $category->term_id); ?>>
                                    <?php echo esc_html($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php else : ?>
                        <p>カテゴリーがありません。</p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="event_thumbnail">アイキャッチ画像</label>
                    <?php if (has_post_thumbnail($post_id)) : ?>
                        <div class="current-thumbnail">
                            <p>現在の画像：</p>
                            <?php echo get_the_post_thumbnail($post_id, 'thumbnail'); ?>
                        </div>
                    <?php endif; ?>
                    <input type="file" id="event_thumbnail" name="event_thumbnail" class="form-control" accept="image/*">
                    <p class="form-hint">新しい画像をアップロードすると、現在の画像は置き換えられます。</p>
                </div>

                <div class="form-actions">
                    <button type="submit" name="update_event" class="btn btn-primary">更新する</button>
                    <a href="<?php echo get_permalink($post_id); ?>" class="btn btn-secondary">キャンセル</a>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // オンライン/オフライン切り替え時の場所入力欄の表示/非表示
        const eventIsOnline = document.getElementById('event_is_online');
        const locationGroup = document.getElementById('location_group');
        const eventLocation = document.getElementById('event_location');

        function toggleLocationField() {
            if (eventIsOnline.value === '1') {
                locationGroup.style.display = 'none';
                eventLocation.removeAttribute('required');
            } else {
                locationGroup.style.display = 'block';
                eventLocation.setAttribute('required', 'required');
            }
        }

        // 初期表示時に実行
        toggleLocationField();

        // 変更時にも実行
        eventIsOnline.addEventListener('change', toggleLocationField);
    });
</script>

<?php get_footer(); ?>