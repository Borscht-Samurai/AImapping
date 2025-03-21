<?php
/**
 * Template Name: 新規投稿
 * Description: 新規投稿作成用のテンプレート
 */

get_header();
?>

<div class="container">
    <div class="new-post-form neumorphism">
        <h1 class="page-title">新規イベントの投稿</h1>
        
        <?php if (is_user_logged_in()) : ?>
            <form id="new-post-form" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                <?php wp_nonce_field('new_post_action', 'new_post_nonce'); ?>
                
                <div class="form-group">
                    <label for="post_title">イベントタイトル <span class="required">*</span></label>
                    <input type="text" id="post_title" name="post_title" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="post_content">イベント内容 <span class="required">*</span></label>
                    <textarea id="post_content" name="post_content" required class="form-control" rows="5"></textarea>
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
                    <label for="location_detail">開催場所の詳細</label>
                    <input type="text" id="location_detail" name="location_detail" class="form-control">
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">イベントを投稿する</button>
                </div>
            </form>

            <script>
            jQuery(document).ready(function($) {
                $('#location_type').change(function() {
                    if ($(this).val() === 'offline') {
                        $('#location_detail_group').show();
                    } else {
                        $('#location_detail_group').hide();
                    }
                });
            });
            </script>
        <?php else : ?>
            <p class="login-required">イベントを投稿するにはログインが必要です。</p>
            <a href="<?php echo esc_url(home_url('/login')); ?>" class="login-link">ログインする</a>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
