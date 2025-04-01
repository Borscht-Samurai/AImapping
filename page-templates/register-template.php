<?php
/**
 * Template Name: 会員登録ページ
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <h1 class="auth-title">新規登録</h1>
                
                <?php
                // エラーメッセージの表示
                if (isset($_GET['register']) && $_GET['register'] == 'failed') {
                    echo '<div class="auth-error">登録に失敗しました。入力内容を確認してください。</div>';
                }
                ?>

                <form class="auth-form" action="<?php echo esc_url(home_url('/wp-login.php?action=register')); ?>" method="post">
                    <div class="form-group">
                        <label for="user_email">メールアドレス</label>
                        <input type="email" name="user_email" id="user_email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="user_login">ユーザー名</label>
                        <input type="text" name="user_login" id="user_login" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="user_pass">パスワード</label>
                        <input type="password" name="user_pass" id="user_pass" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="user_pass_confirm">パスワード（確認）</label>
                        <input type="password" name="user_pass_confirm" id="user_pass_confirm" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="terms" required>
                            <span><a href="<?php echo esc_url(home_url('/terms')); ?>" target="_blank">利用規約</a>に同意する</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">登録する</button>
                </form>

                <div class="auth-separator">
                    <span>または</span>
                </div>

                <div class="social-login">
                    <a href="<?php echo esc_url(home_url('/wp-login.php?registerSocial=google')); ?>" class="btn btn-social btn-google">
                        <i class="fab fa-google"></i>
                        Googleで登録
                    </a>
                </div>

                <div class="auth-footer">
                    <p>すでにアカウントをお持ちの方は<a href="<?php echo esc_url(home_url('/login')); ?>">ログイン</a>へ</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?> 