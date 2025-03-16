<?php
/**
 * comment-template.php - コメント表示テンプレート
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/*
 * コメントコールバック関数
 */
function aimapping_comment_callback($comment, $args, $depth) {
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent', $comment); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar($comment, 60); ?>
                    <div class="comment-author-info">
                        <?php
                        printf('<cite class="fn">%s</cite>', get_comment_author_link($comment));
                        ?>
                        <div class="comment-metadata">
                            <time datetime="<?php echo get_comment_time('c'); ?>">
                                <?php
                                printf(
                                    _x('%1$s %2$s', '1: date, 2: time', 'aimapping'),
                                    get_comment_date('Y年n月j日'),
                                    get_comment_time('H:i')
                                );
                                ?>
                            </time>
                            <?php edit_comment_link(__('編集', 'aimapping'), ' <span class="edit-link">', '</span>'); ?>
                        </div>
                    </div>
                </div>
                
                <?php if ('0' == $comment->comment_approved) : ?>
                    <p class="comment-awaiting-moderation"><?php _e('コメントは承認待ちです。', 'aimapping'); ?></p>
                <?php endif; ?>
            </div>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <?php
            comment_reply_link(
                array_merge(
                    $args,
                    array(
                        'add_below' => 'div-comment',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div class="reply">',
                        'after'     => '</div>',
                    )
                )
            );
            ?>
        </article>
    </<?php echo $tag; ?>>
    <?php
}

/*
 * コメントフォーム上部のテキスト
 */
function aimapping_comment_form_top() {
    if (!is_user_logged_in()) {
        echo '<p class="comment-notes">' . __('メールアドレスが公開されることはありません。', 'aimapping') . '</p>';
    }
}
add_action('comment_form_top', 'aimapping_comment_form_top');

/*
 * コメントフォームのカスタマイズ
 */
function aimapping_comment_form_defaults($defaults) {
    $defaults['title_reply'] = __('コメントを残す', 'aimapping');
    $defaults['title_reply_to'] = __('%s に返信する', 'aimapping');
    $defaults['cancel_reply_link'] = __('キャンセル', 'aimapping');
    $defaults['label_submit'] = __('コメントを投稿', 'aimapping');
    
    $defaults['comment_field'] = sprintf(
        '<div class="comment-form-comment form-group"><label for="comment">%s</label><textarea id="comment" name="comment" class="form-control" rows="5" required></textarea></div>',
        _x('コメント', 'noun', 'aimapping')
    );
    
    // ログイン中のユーザーには名前とメールアドレスのフィールドを表示しない
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $defaults['logged_in_as'] = sprintf(
            '<p class="logged-in-as">%s</p>',
            sprintf(
                __('%1$s としてログイン中です。<a href="%2$s">ログアウト</a>', 'aimapping'),
                $user->display_name,
                wp_logout_url(apply_filters('the_permalink', get_permalink()))
            )
        );
    }
    
    return $defaults;
}
add_filter('comment_form_defaults', 'aimapping_comment_form_defaults');