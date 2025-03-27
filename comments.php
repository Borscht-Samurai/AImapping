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
            function custom_comment_template($comment, $args, $depth) {
                $GLOBALS['comment'] = $comment;
                $current_user_id = get_current_user_id();
                ?>
                <li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-item mb-4'); ?>>
                    <div class="comment-body bg-gray-50 p-4 rounded-lg">
                        <div class="comment-meta mb-2">
                            <div class="flex items-center gap-2">
                                <?php echo get_avatar($comment, 40, '', '', array('class' => 'rounded-full')); ?>
                                <div>
                                    <div class="font-semibold"><?php echo get_comment_author(); ?></div>
                                    <div class="text-sm text-gray-600">
                                        <?php echo get_comment_date('Y年n月j日 H:i'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="comment-content prose max-w-none mb-2" id="comment-content-<?php comment_ID(); ?>">
                            <?php comment_text(); ?>
                        </div>

                        <?php if ($current_user_id && $current_user_id === intval($comment->user_id)) : ?>
                            <div class="comment-actions flex gap-2">
                                <button 
                                    onclick="editComment(<?php comment_ID(); ?>)"
                                    class="text-sm text-blue-600 hover:text-blue-800 transition-colors"
                                >
                                    <i class="fas fa-edit mr-1"></i>編集
                                </button>
                                <button 
                                    onclick="deleteComment(<?php comment_ID(); ?>)"
                                    class="text-sm text-red-600 hover:text-red-800 transition-colors"
                                >
                                    <i class="fas fa-trash-alt mr-1"></i>削除
                                </button>
                            </div>

                            <!-- 編集フォーム（デフォルトで非表示） -->
                            <form id="edit-form-<?php comment_ID(); ?>" class="hidden mt-4">
                                <textarea 
                                    id="edit-content-<?php comment_ID(); ?>"
                                    class="w-full p-3 border rounded-lg mb-3 min-h-[100px] focus:ring-2 focus:ring-primary focus:border-primary"
                                    rows="4"
                                ><?php echo esc_textarea(get_comment_text()); ?></textarea>
                                <div class="flex gap-2">
                                    <button 
                                        type="button"
                                        onclick="updateComment(<?php comment_ID(); ?>)"
                                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors text-sm flex items-center"
                                    >
                                        <i class="fas fa-check mr-1"></i>更新
                                    </button>
                                    <button 
                                        type="button"
                                        onclick="cancelEdit(<?php comment_ID(); ?>)"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm flex items-center"
                                    >
                                        <i class="fas fa-times mr-1"></i>キャンセル
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </li>
                <?php
            }

            wp_list_comments(array(
                'callback' => 'custom_comment_template',
                'style' => 'ol',
                'short_ping' => true,
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
    // ログインユーザーのみにコメントフォームを表示
    if (is_user_logged_in()) :
        $commenter = wp_get_current_user();
        $user_identity = $commenter->display_name;
        
        comment_form(array(
            'title_reply' => 'コメントを残す',
            'label_submit' => 'コメントを送信',
            'logged_in_as' => sprintf('%sとしてログインしています。', esc_html($user_identity)),
        ));
    else :
    ?>
        <div class="bg-gray-50 p-6 rounded-lg text-center">
            <p class="text-gray-600 mb-4">コメントを投稿するにはログインが必要です。</p>
            <a href="<?php echo esc_url(home_url('/login')); ?>" class="inline-block px-6 py-2 bg-primary text-white rounded-full hover:bg-primary-dark transition-colors">
                ログインする
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- コメント編集・削除用のJavaScript -->
<script>
function editComment(commentId) {
    // コメント本文を非表示
    const contentElement = document.getElementById(`comment-content-${commentId}`);
    contentElement.classList.add('hidden');

    // 編集フォームを表示
    const formElement = document.getElementById(`edit-form-${commentId}`);
    formElement.classList.remove('hidden');

    // テキストエリアにフォーカス
    const textArea = document.getElementById(`edit-content-${commentId}`);
    textArea.focus();

    // テキストエリアの高さを自動調整
    textArea.style.height = 'auto';
    textArea.style.height = textArea.scrollHeight + 'px';

    // テキストエリアの内容が変更されたときに高さを自動調整
    textArea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
}

function cancelEdit(commentId) {
    document.getElementById(`comment-content-${commentId}`).classList.remove('hidden');
    document.getElementById(`edit-form-${commentId}`).classList.add('hidden');
}

function updateComment(commentId) {
    const content = document.getElementById(`edit-content-${commentId}`).value;
    
    if (content.trim() === '') {
        alert('コメントを入力してください。');
        return;
    }
    
    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'update_comment',
            comment_id: commentId,
            content: content,
            nonce: '<?php echo wp_create_nonce("update_comment_nonce"); ?>'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 更新成功後にページをリロード
            window.location.reload();
        } else {
            alert('コメントの更新に失敗しました。');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('エラーが発生しました。');
    });
}

function deleteComment(commentId) {
    if (!confirm('このコメントを削除してもよろしいですか？')) {
        return;
    }

    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'delete_comment',
            comment_id: commentId,
            nonce: '<?php echo wp_create_nonce("delete_comment_nonce"); ?>'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`comment-${commentId}`).remove();
        } else {
            alert('コメントの削除に失敗しました。');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('エラーが発生しました。');
    });
}
</script> 