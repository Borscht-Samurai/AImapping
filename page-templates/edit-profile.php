<?php
/**
 * Template Name: プロフィール編集
 */

// ログインしていない場合はログインページにリダイレクト
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login/'));
    exit;
}

get_header();

// 現在のユーザー情報を取得
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$profile_data = get_user_profile_data($user_id);

// プロフィール画像を取得
$custom_avatar_id = $profile_data['custom_avatar'];
$profile_image = $custom_avatar_id ? wp_get_attachment_image_url($custom_avatar_id, 'thumbnail') : get_avatar_url($user_id, array('size' => 150));
?>

<!-- グラデーションセクション -->
<section class="gradient-box-section">
    <div class="gradient-box">
        <div class="gradient-box-content">
            <h1 class="profile-title">プロフィール編集</h1>
        </div>
    </div>
</section>

<!-- プロフィール編集フォーム -->
<section class="profile-edit-section">
    <div class="profile-container">
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data" class="profile-edit-form">
            <input type="hidden" name="action" value="edit_profile">
            <?php wp_nonce_field('profile_edit_action', 'profile_edit_nonce'); ?>

            <!-- プロフィール画像 -->
            <div class="form-group">
                <label for="custom_avatar">プロフィール画像</label>
                <div class="avatar-preview">
                    <img src="<?php echo esc_url($profile_image); ?>" alt="現在のプロフィール画像" id="avatar-preview">
                </div>
                <input type="file" id="custom_avatar" name="custom_avatar" accept="image/*">
            </div>

            <!-- 役職 -->
            <div class="form-group">
                <label for="role">Current role</label>
                <input type="text" id="role" name="role" value="<?php echo esc_attr($profile_data['role']); ?>" placeholder="例: Software Engineer">
            </div>

            <!-- 自己紹介 -->
            <div class="form-group">
                <label for="description">自己紹介</label>
                <textarea id="description" name="description" rows="5"><?php echo esc_textarea($profile_data['description']); ?></textarea>
            </div>

            <!-- SNSリンク -->
            <div class="form-group">
                <label for="twitter_url">Twitter URL</label>
                <input type="url" id="twitter_url" name="twitter_url" value="<?php echo esc_url($profile_data['twitter_url']); ?>">
            </div>

            <div class="form-group">
                <label for="facebook_url">Facebook URL</label>
                <input type="url" id="facebook_url" name="facebook_url" value="<?php echo esc_url($profile_data['facebook_url']); ?>">
            </div>

            <div class="form-group">
                <label for="instagram_url">Instagram URL</label>
                <input type="url" id="instagram_url" name="instagram_url" value="<?php echo esc_url($profile_data['instagram_url']); ?>">
            </div>

            <div class="form-group">
                <label for="youtube_url">YouTube URL</label>
                <input type="url" id="youtube_url" name="youtube_url" value="<?php echo esc_url($profile_data['youtube_url']); ?>">
            </div>

            <!-- 送信ボタン -->
            <div class="form-actions">
                <button type="submit" class="submit-button">保存する</button>
                <a href="<?php echo esc_url(home_url('/user/')); ?>" class="cancel-button">キャンセル</a>
            </div>
        </form>
    </div>
</section>

<style>
/* プロフィール編集ページのスタイル */
.profile-edit-section {
    max-width: 1288px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-container {
    background-color: #E7E7E7;
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2rem;
}

.profile-edit-form {
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.form-group input[type="url"],
.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

.avatar-preview {
    width: 150px;
    height: 150px;
    margin-bottom: 1rem;
    border-radius: 50%;
    overflow: hidden;
}

.avatar-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.submit-button,
.cancel-button {
    padding: 0.8rem 2rem;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: background-color 0.3s;
}

.submit-button {
    background-color: #FF966C;
    color: white;
}

.submit-button:hover {
    background-color: #ff8552;
}

.cancel-button {
    background-color: #ccc;
    color: #333;
}

.cancel-button:hover {
    background-color: #bbb;
}
</style>

<script>
jQuery(document).ready(function($) {
    // プロフィール画像のプレビュー
    $('#custom_avatar').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#avatar-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?php get_footer(); ?>