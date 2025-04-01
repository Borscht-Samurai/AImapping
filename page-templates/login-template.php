<?php
/**
 * Template Name: ログインページ
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <h1 class="auth-title">ログイン</h1>
                
                <?php
                // エラーメッセージの表示
                if (isset($_GET['login']) && $_GET['login'] == 'failed') {
                    echo '<div class="auth-error">ログインに失敗しました。メールアドレスとパスワードを確認してください。</div>';
                }
                ?>

                <form class="auth-form" action="<?php echo esc_url(wp_login_url(home_url())); ?>" method="post">
                    <div class="form-group">
                        <label for="user_login">メールアドレス</label>
                        <input type="email" name="log" id="user_login" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="user_pass">パスワード</label>
                        <input type="password" name="pwd" id="user_pass" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="rememberme" value="forever">
                            <span>ログイン状態を保持する</span>
                        </label>
                        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="forgot-password">パスワードをお忘れですか？</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">ログイン</button>
                </form>

                <div class="auth-separator">
                    <span>または</span>
                </div>

                <div class="social-login">
                    <a href="<?php echo esc_url(home_url('/wp-login.php?loginSocial=google')); ?>" class="btn btn-social btn-google">
                        <i class="fab fa-google"></i>
                        Googleでログイン
                    </a>
                </div>

                <div class="auth-footer">
                    <p>アカウントをお持ちでない方は<a href="<?php echo esc_url(home_url('/register1')); ?>">新規登録</a>へ</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?> 