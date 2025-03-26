<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_count = get_comments_number();
            if ($comments_count === '1') {
                echo '1件のコメント';
            } else {
                echo $comments_count . '件のコメント';
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 40,
            ));
            ?>
        </ol>

        <?php
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
            <nav class="comment-navigation">
                <div class="nav-previous"><?php previous_comments_link('前のコメント'); ?></div>
                <div class="nav-next"><?php next_comments_link('次のコメント'); ?></div>
            </nav>
        <?php endif; ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments">コメントは受け付けていません。</p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_user();
    $user_identity = $commenter->display_name;
    
    comment_form(array(
        'title_reply' => 'コメントを残す',
        'label_submit' => 'コメントを送信',
        'logged_in_as' => sprintf('%sとしてログインしています。', esc_html($user_identity)),
    ));
    ?>
</div> 