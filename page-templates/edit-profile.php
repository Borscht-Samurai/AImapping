
<?php
/**
 * Template Name: プロフィール編集ページ
 */

// ログインしていないユーザーはログインページにリダイレクト
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

get_header();

// 現在のユーザー情報を取得
$current_user = wp_get_current_user();
?>

<main class="site-main">
    <div class="container">
        <div class="profile-edit-container">
            <h1 class="form-title">プロフィール編集</h1>

            <?php
            // プロフィール更新処理
            if (isset($_POST['update_profile'])) {
                // NonceチェックとCSRF対策
                if (!isset($_POST['profile_nonce_field']) || !wp_verify_nonce($_POST['profile_nonce_field'], 'profile_nonce_action')) {
                    echo '<div class="form-message error">セキュリティチェックに失敗しました。</div>';
                } else {
                    // バリデーション
                    $errors = array();

                    if (empty($_POST['display_name'])) {
                        $errors[] = '表示名は必須です。';
                    }

                    if (!empty($_POST['user_email']) && !is_email($_POST['user_email'])) {
                        $errors[] = 'メールアドレスが正しくありません。';
                    }

                    if (!empty($_POST['user_url']) && !filter_var($_POST['user_url'], FILTER_VALIDATE_URL)) {
                        $errors[] = 'URLが正しくありません。';
                    }

                    // SNSリンクのバリデーション
                    $social_networks = array('twitter', 'facebook', 'instagram', 'github');
                    foreach ($social_networks as $network) {
                        if (!empty($_POST[$network]) && !filter_var($_POST[$network], FILTER_VALIDATE_URL)) {
                            $errors[] = $network . 'のURLが正しくありません。';
                        }
                    }

                    // パスワード変更のバリデーション
                    if (!empty($_POST['new_password'])) {
                        if (strlen($_POST['new_password']) < 8) {
                            $errors[] = '新しいパスワードは8文字以上で設定してください。';
                        }

                        if ($_POST['new_password'] !== $_POST['confirm_password']) {
                            $errors[] = '新しいパスワードと確認用パスワードが一致しません。';
                        }
                    }

                    // エラーがなければプロフィールを更新
                    if (empty($errors)) {
                        // ユーザー情報更新用の配列
                        $user_data = array(
                            'ID' => $current_user->ID,
                            'display_name' => sanitize_text_field($_POST['display_name']),
                        );

                        // メールアドレスが変更されている場合
                        if (!empty($_POST['user_email']) && $_POST['user_email'] !== $current_user->user_email) {
                            $user_data['user_email'] = sanitize_email($_POST['user_email']);
                        }

                        // パスワードが入力されている場合
                        if (!empty($_POST['new_password'])) {
                            $user_data['user_pass'] = $_POST['new_password'];
                        }

                        // ユーザー情報を更新
                        $user_id = wp_update_user($user_data);

                        if (is_wp_error($user_id)) {
                            echo '<div class="form-message error">ユーザー情報の更新に失敗しました: ' . $user_id->get_error_message() . '</div>';
                        } else {
                            // プロフィール情報を更新
                            update_user_meta($current_user->ID, 'description', wp_kses_post($_POST['description']));

                            if (!empty($_POST['user_url'])) {
                                update_user_meta($current_user->ID, 'user_url', esc_url_raw($_POST['user_url']));
                            }

                            // 役職を更新
                            if (isset($_POST['role'])) {
                                update_user_meta($current_user->ID, 'role', sanitize_text_field($_POST['role']));
                            }

                            // SNSリンクを更新
                            foreach ($social_networks as $network) {
                                if (isset($_POST[$network])) {
                                    if (!empty($_POST[$network])) {
                                        update_user_meta($current_user->ID, $network, esc_url_raw($_POST[$network]));
                                    } else {
                                        delete_user_meta($current_user->ID, $network);
                                    }
                                }
                            }

                            // プロフィール画像のアップロード処理
                            if (!empty($_FILES['profile_image']['name'])) {
                                require_once(ABSPATH . 'wp-admin/includes/image.php');
                                require_once(ABSPATH . 'wp-admin/includes/file.php');
                                require_once(ABSPATH . 'wp-admin/includes/media.php');

                                // ファイルサイズと形式のチェック
                                $file = $_FILES['profile_image'];
                                $file_size = $file['size']; // バイト単位
                                $max_size = 500 * 1024; // 500KB

                                // ファイル形式のチェック
                                $file_type = wp_check_filetype($file['name']);
                                $allowed_types = array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png');

                                // デバッグ情報
                                echo '<!-- ファイル情報: ' . print_r($file, true) . ' -->';
                                echo '<!-- ファイルタイプ: ' . $file_type['type'] . ' -->';
                                echo '<!-- ファイルサイズ: ' . $file_size . ' バイト -->';

                                if ($file_size > $max_size) {
                                    echo '<div class="form-message error">プロフィール画像のサイズが大きすぎます。500KB以下のファイルを選択してください。</div>';
                                } elseif (!in_array($file_type['type'], $allowed_types)) {
                                    echo '<div class="form-message error">プロフィール画像は、JPGまたはPNG形式のみをアップロードできます。</div>';
                                } else {
                                    // アップロードディレクトリを取得
                                    $upload_dir = wp_upload_dir();

                                    // カスタムアバターが既に存在する場合は削除
                                    $old_avatar_id = get_user_meta($current_user->ID, 'custom_avatar', true);
                                    if ($old_avatar_id) {
                                        wp_delete_attachment($old_avatar_id, true);
                                    }

                                    // 新しいアバターをアップロード
                                    $avatar_id = media_handle_upload('profile_image', 0);

                                    if (is_wp_error($avatar_id)) {
                                        echo '<div class="form-message error">プロフィール画像のアップロードに失敗しました: ' . $avatar_id->get_error_message() . '</div>';
                                    } else {
                                        update_user_meta($current_user->ID, 'custom_avatar', $avatar_id);
                                        echo '<div class="form-message success">プロフィール画像が更新されました。</div>';
                                    }
                                }
                            }

                            // プロフィール背景画像のアップロード処理
                            if (!empty($_FILES['profile_header_bg']['name'])) {
                                require_once(ABSPATH . 'wp-admin/includes/image.php');
                                require_once(ABSPATH . 'wp-admin/includes/file.php');
                                require_once(ABSPATH . 'wp-admin/includes/media.php');

                                // ファイルサイズと形式のチェック
                                $file = $_FILES['profile_header_bg'];
                                $file_size = $file['size']; // バイト単位
                                $max_size = 1024 * 1024; // 1MB

                                // ファイル形式のチェック
                                $file_type = wp_check_filetype($file['name']);
                                $allowed_types = array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png');

                                // デバッグ情報
                                echo '<!-- 背景画像情報: ' . print_r($file, true) . ' -->';
                                echo '<!-- 背景画像タイプ: ' . $file_type['type'] . ' -->';
                                echo '<!-- 背景画像サイズ: ' . $file_size . ' バイト -->';

                                if ($file_size > $max_size) {
                                    echo '<div class="form-message error">背景画像のサイズが大きすぎます。1MB以下のファイルを選択してください。</div>';
                                } elseif (!in_array($file_type['type'], $allowed_types)) {
                                    echo '<div class="form-message error">背景画像は、JPGまたはPNG形式のみをアップロードできます。</div>';
                                } else {
                                    // 既存の背景画像があれば削除
                                    $old_header_bg_id = get_user_meta($current_user->ID, 'profile_header_bg', true);
                                    if ($old_header_bg_id) {
                                        wp_delete_attachment($old_header_bg_id, true);
                                    }

                                    // 新しい背景画像をアップロード
                                    $header_bg_id = media_handle_upload('profile_header_bg', 0);

                                    if (is_wp_error($header_bg_id)) {
                                        echo '<div class="form-message error">背景画像のアップロードに失敗しました: ' . $header_bg_id->get_error_message() . '</div>';
                                    } else {
                                        update_user_meta($current_user->ID, 'profile_header_bg', $header_bg_id);
                                        echo '<div class="form-message success">背景画像が更新されました。</div>';
                                    }
                                }
                            }

                            // プロフィール画像や背景画像がアップロードされていない場合の成功メッセージ
                            if (empty($_FILES['profile_image']['name']) && empty($_FILES['profile_header_bg']['name'])) {
                                echo '<div class="form-message success">プロフィールが更新されました。</div>';
                            }

                            // 最新のユーザー情報を取得
                            $current_user = get_userdata($current_user->ID);
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
            ?>

            <form class="profile-form" method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('profile_nonce_action', 'profile_nonce_field'); ?>

                <div class="form-section">
                    <h2>基本情報</h2>

                    <div class="form-group">
                        <label for="display_name">表示名 <span class="required">*</span></label>
                        <input type="text" id="display_name" name="display_name" class="form-control" value="<?php echo esc_attr($current_user->display_name); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_email">メールアドレス <span class="required">*</span></label>
                        <input type="email" id="user_email" name="user_email" class="form-control" value="<?php echo esc_attr($current_user->user_email); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">自己紹介</label>
                        <textarea id="description" name="description" class="form-control" rows="5"><?php echo esc_textarea(get_user_meta($current_user->ID, 'description', true)); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="user_url">ウェブサイト</label>
                        <input type="url" id="user_url" name="user_url" class="form-control" value="<?php echo esc_url($current_user->user_url); ?>">
                    </div>

                    <div class="form-group">
                        <label for="role">役職</label>
                        <input type="text" id="role" name="role" class="form-control" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'role', true)); ?>" placeholder="例: Software Engineer">
                    </div>
                </div>

                <div class="form-section">
                    <h2>プロフィール画像</h2>

                    <div class="form-group">
                        <div class="current-avatar">
                            <?php echo get_avatar($current_user->ID, 100); ?>
                        </div>
                        <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*">
                        <p class="form-hint">500KB以下のJPG、PNG形式のみ。</p>
                    </div>
                </div>

                <div class="form-section">
                    <h2>プロフィール背景画像</h2>

                    <div class="form-group">
                        <?php
                        $header_bg_id = get_user_meta($current_user->ID, 'profile_header_bg', true);
                        if ($header_bg_id) :
                            $header_bg_url = wp_get_attachment_image_url($header_bg_id, 'large');
                        ?>
                        <div class="current-header-bg">
                            <img src="<?php echo esc_url($header_bg_url); ?>" alt="現在の背景画像" style="max-width: 100%; height: auto; border-radius: 8px;">
                        </div>
                        <?php endif; ?>
                        <input type="file" id="profile_header_bg" name="profile_header_bg" class="form-control" accept="image/*">
                        <p class="form-hint">プロフィールページのヘッダー背景画像を設定します。アップロードしない場合はデフォルトのグラデーションが表示されます。</p>
                    </div>
                </div>

                <div class="form-section">
                    <h2>SNSリンク</h2>

                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input type="url" id="twitter" name="twitter" class="form-control" value="<?php echo esc_url(get_user_meta($current_user->ID, 'twitter', true)); ?>" placeholder="https://twitter.com/yourusername">
                    </div>

                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input type="url" id="instagram" name="instagram" class="form-control" value="<?php echo esc_url(get_user_meta($current_user->ID, 'instagram', true)); ?>" placeholder="https://instagram.com/yourusername">
                    </div>

                </div>

                <div class="form-section">
                    <h2>パスワード変更</h2>
                    <p class="section-info">変更する場合のみ入力してください。</p>

                    <div class="form-group">
                        <label for="new_password">新しいパスワード</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" minlength="8">
                        <p class="form-hint">8文字以上で設定してください。</p>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">パスワード（確認）</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="update_profile" class="btn btn-primary">プロフィールを更新</button>
                    <a href="<?php echo esc_url(home_url('/user')); ?>" class="btn btn-secondary">キャンセル</a>
                </div>
            </form>

            <div class="account-actions">
                <h3>アカウント管理</h3>
                <p>アカウントを削除すると、すべての投稿やコメントも削除されます。この操作は取り消せません。</p>
                <button id="delete-account-btn" class="btn btn-danger">アカウントを削除</button>

                <div id="delete-account-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-modal">&times;</span>
                        <h3>アカウントを削除しますか？</h3>
                        <p>この操作は取り消せません。すべての投稿、コメント、データが削除されます。</p>
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <input type="hidden" name="action" value="delete_account">
                            <?php wp_nonce_field('delete_account_nonce', 'delete_account_nonce_field'); ?>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-danger">削除する</button>
                                <button type="button" class="btn btn-secondary cancel-delete">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // アカウント削除モーダル
        const deleteBtn = document.getElementById('delete-account-btn');
        const modal = document.getElementById('delete-account-modal');
        const closeModal = document.querySelector('.close-modal');
        const cancelDelete = document.querySelector('.cancel-delete');

        if (deleteBtn && modal) {
            deleteBtn.addEventListener('click', function() {
                modal.style.display = 'block';
            });

            if (closeModal) {
                closeModal.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }

            if (cancelDelete) {
                cancelDelete.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }

        // パスワード一致確認
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        if (newPasswordInput && confirmPasswordInput) {
            function validatePassword() {
                if (newPasswordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity('パスワードが一致しません');
                } else {
                    confirmPasswordInput.setCustomValidity('');
                }
            }

            newPasswordInput.addEventListener('change', validatePassword);
            confirmPasswordInput.addEventListener('keyup', validatePassword);
        }
    });
</script>

<?php get_footer(); ?>