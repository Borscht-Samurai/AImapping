<?php
/**
 * Template Name: 新規投稿
 * Description: 新規投稿作成用のテンプレート
 */

get_header();
?>

<div class="container">
    <div class="new-post-form neumorphism">
        <h1 class="page-title">新規投稿</h1>
        
        <?php if (is_user_logged_in()) : ?>
            <form id="new-post-form" method="post" action="">
                <?php wp_nonce_field('new_post_action', 'new_post_nonce'); ?>
                
                <div class="form-group">
                    <label for="post_title">募集タイトル</label>
                    <input type="text" id="post_title" name="post_title" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="post_content">募集内容</label>
                    <textarea id="post_content" name="post_content" required class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="post_category">カテゴリー</label>
                    <select id="post_category" name="post_category" required class="form-control">
                        <option value="">選択してください</option>
                        <option value="study">勉強会</option>
                        <option value="online">オンライン交流</option>
                        <option value="project">プロジェクト協力者募集</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="event_date">開催日時</label>
                    <input type="datetime-local" id="event_date" name="event_date" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="location_type">開催場所</label>
                    <select id="location_type" name="location_type" required class="form-control">
                        <option value="">選択してください</option>
                        <option value="online">オンライン</option>
                        <option value="offline">オフライン</option>
                    </select>
                </div>

                <div class="form-group" id="location_detail_group" style="display: none;">
                    <label for="location_detail">開催場所の詳細</label>
                    <input type="text" id="location_detail" name="location_detail" class="form-control">
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">投稿する</button>
                </div>
            </form>
        <?php else : ?>
            <p class="login-required">投稿するにはログインが必要です。</p>
            <a href="<?php echo esc_url(home_url('/login')); ?>" class="login-link">ログインする</a>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
