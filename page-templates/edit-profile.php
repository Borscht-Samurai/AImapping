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
            <div class="floating-label-container">
                <input type="text" id="role" name="role" value="<?php echo esc_attr($profile_data['role']); ?>" placeholder=" ">
                <label for="role">Current role</label>
            </div>

            <!-- 自己紹介 -->
            <div class="floating-label-container">
                <textarea id="description" name="description" rows="5" placeholder=" "><?php echo esc_textarea($profile_data['description']); ?></textarea>
                <label for="description">自己紹介</label>
            </div>

            <!-- SNSリンク -->
            <div class="floating-label-container">
                <input type="url" id="twitter_url" name="twitter_url" value="<?php echo esc_url($profile_data['twitter_url']); ?>" placeholder=" ">
                <label for="twitter_url">Twitter URL</label>
            </div>

            <div class="floating-label-container">
                <input type="url" id="facebook_url" name="facebook_url" value="<?php echo esc_url($profile_data['facebook_url']); ?>" placeholder=" ">
                <label for="facebook_url">Facebook URL</label>
            </div>

            <div class="floating-label-container">
                <input type="url" id="instagram_url" name="instagram_url" value="<?php echo esc_url($profile_data['instagram_url']); ?>" placeholder=" ">
                <label for="instagram_url">Instagram URL</label>
            </div>

            <div class="floating-label-container">
                <input type="url" id="youtube_url" name="youtube_url" value="<?php echo esc_url($profile_data['youtube_url']); ?>" placeholder=" ">
                <label for="youtube_url">YouTube URL</label>
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

/* ニューモーフィズムデザインのための新しいスタイル */
.floating-label-container {
    position: relative;
    margin-bottom: 1.5rem;
}

.floating-label-container input[type="text"],
.floating-label-container input[type="url"],
.floating-label-container textarea {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 15px;
    background: #E7E7E7;
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
    font-size: 16px;
    transition: all 0.3s ease;
}

.floating-label-container input[type="text"]:focus,
.floating-label-container input[type="url"]:focus,
.floating-label-container textarea:focus {
    outline: none;
    box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.1),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
}

.floating-label-container label {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    background-color: transparent;
    padding: 0 5px;
    color: #666;
    font-size: 16px;
    transition: all 0.3s ease;
    pointer-events: none;
}

.floating-label-container textarea ~ label {
    top: 20px;
    transform: none;
}

.floating-label-container input:focus ~ label,
.floating-label-container textarea:focus ~ label,
.floating-label-container input:not(:placeholder-shown) ~ label,
.floating-label-container textarea:not(:placeholder-shown) ~ label {
    top: -10px;
    font-size: 14px;
    color: #FF966C;
    background-color: #E7E7E7;
}

/* ファイル入力のカスタマイズ */
.form-group input[type="file"] {
    display: none;
}

.form-group .file-upload-label {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 15px;
    background: #E7E7E7;
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-group .file-upload-label:hover {
    box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.1),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
}

/* ボタンのニューモーフィズムスタイル */
.submit-button,
.cancel-button {
    padding: 0.8rem 2rem;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
}

.submit-button {
    background-color: #FF966C;
    color: white;
}

.submit-button:hover {
    box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.1),
                inset -5px -5px 10px rgba(255, 255, 255, 0.1);
}

.cancel-button {
    background-color: #E7E7E7;
    color: #333;
}

.cancel-button:hover {
    box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.1),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
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

    // 入力フィールドの初期状態を設定
    const inputFields = $('.floating-label-container input, .floating-label-container textarea');
    
    inputFields.each(function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        }
    });

    // 入力フィールドのフォーカス/ブラー時の処理
    inputFields.on('focus blur', function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        } else {
            $(this).removeClass('has-value');
        }
    });

    // フォーム送信時にフォーカスを外す
    $('.profile-edit-form').on('submit', function() {
        document.activeElement.blur();
    });
});
</script>

<?php get_footer(); ?>