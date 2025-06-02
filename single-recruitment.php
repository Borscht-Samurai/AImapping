<?php
get_header();

// メタ情報の取得
while (have_posts()) :
    the_post();
    $event_date = get_post_meta(get_the_ID(), 'event_date', true);
    $event_is_online = get_post_meta(get_the_ID(), 'event_is_online', true);
    $event_location = get_post_meta(get_the_ID(), 'event_location', true);
?>

<!-- グラデーションセクション -->
<section class="gradient-box-section">
    <div class="gradient-box">
        <div class="gradient-box-content">
            <!-- タイトル -->
            <h1 class="recruitment-title"><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<!-- 2つのボックスセクション -->
<section class="two-boxes-section">
    <div class="left-box">
        <article class="recruitment-container">
            <!-- タイトル -->
            <h1 class="recruitment-title"><?php the_title(); ?></h1>

            <!-- アカウント情報 -->
            <style>
                .author-info {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }
                .author-name {
                    font-size: 15px;
                    font-weight: bold;
                }
                .author-link {
                    text-decoration: none;
                    color: inherit;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    transition: opacity 0.3s;
                }
                .author-link:hover {
                    opacity: 0.7;
                }

                /* コメントセクションのスタイル */
                .comments-section {
                    margin-top: 30px;
                    padding: 20px;
                    background-color: #E7E7E7;
                    border-radius: 10px;
                }

                .comments-title {
                    font-size: 18px;
                    margin-bottom: 20px;
                    color: #333;
                }

                .comment-form-container {
                    margin-bottom: 30px;
                }

                .comment-form textarea {
                    width: 100%;
                    min-height: 100px;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    margin-bottom: 10px;
                    resize: vertical;
                    background-color: white;
                }

                .submit-comment {
                    background-color: #FF966C;
                    color: white;
                    border: none;
                    padding: 8px 20px;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                }

                .submit-comment:hover {
                    background-color: #ff8552;
                }

                .login-to-comment {
                    text-align: center;
                    padding: 20px;
                    background-color: white;
                    border-radius: 5px;
                }

                .login-to-comment a {
                    color: #FF966C;
                    text-decoration: none;
                }

                .comments-list {
                    margin-top: 20px;
                }

                .comment-item {
                    background-color: white;
                    padding: 15px;
                    border-radius: 8px;
                    margin-bottom: 15px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                }

                .comment-author {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    margin-bottom: 10px;
                }

                .comment-avatar {
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                }

                .comment-author-name {
                    font-weight: bold;
                    color: #333;
                }

                .comment-date {
                    color: #666;
                    font-size: 0.9em;
                    margin-left: auto;
                }

                .comment-content {
                    margin: 10px 0;
                    color: #333;
                }

                .comment-actions {
                    display: flex;
                    gap: 10px;
                    margin-top: 10px;
                    justify-content: flex-end;
                }

                .edit-comment,
                .delete-comment {
                    background: none;
                    border: 1px solid #ddd;
                    padding: 5px 15px;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: all 0.3s;
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                .edit-comment {
                    color: #666;
                }

                .delete-comment {
                    color: #ff4444;
                    border-color: #ff4444;
                }

                .edit-comment:hover {
                    background-color: #f0f0f0;
                }

                .delete-comment:hover {
                    background-color: #fff0f0;
                }

                .edit-textarea {
                    width: 100%;
                    min-height: 80px;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    margin: 10px 0;
                    resize: vertical;
                }

                .edit-actions {
                    display: flex;
                    gap: 10px;
                    justify-content: flex-end;
                    margin-top: 10px;
                }

                .save-edit,
                .cancel-edit {
                    padding: 5px 15px;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                }

                .save-edit {
                    background-color: #FF966C;
                    color: white;
                    border: none;
                }

                .cancel-edit {
                    background-color: #f0f0f0;
                    color: #666;
                    border: 1px solid #ddd;
                }

                .save-edit:hover {
                    background-color: #ff8552;
                }

                .cancel-edit:hover {
                    background-color: #e5e5e5;
                }
            </style>
            <div class="author-info">
                <?php 
                $post_author_id = get_the_author_meta('ID');
                $current_user_id = get_current_user_id();
                
                // 投稿者のプロフィールページURLを生成
                $profile_url = add_query_arg('user_id', $post_author_id, home_url('/user/'));
                
                // 投稿者が自分の投稿を見ている場合は user_id パラメータを付けない
                if (is_user_logged_in() && $post_author_id == $current_user_id) {
                    $profile_url = home_url('/user/');
                }
                ?>
                <a href="<?php echo esc_url($profile_url); ?>" class="author-link">
                    <?php
                    // <?php echo get_avatar($post_author_id, 40, '', '', array('class' => 'author-avatar')); ?>
                    <?php
                    $avatar_img = '';
                    $custom_avatar_id = get_user_meta($post_author_id, 'custom_avatar', true);
                    if ($custom_avatar_id) {
                        // wp_get_attachment_image を使い、CSSでサイズを指定
                        $avatar_img = wp_get_attachment_image($custom_avatar_id, 'thumbnail', false, array('class' => 'author-avatar', 'style' => 'width:40px;height:40px;border-radius:50%;object-fit:cover;'));
                    }
                    // カスタムアバターがない場合は、get_avatar() にフォールバック
                    if (empty($avatar_img)) {
                        $avatar_img = get_avatar($post_author_id, 40, '', '', array('class' => 'author-avatar'));
                    }
                    echo $avatar_img;
                    ?>
                    <span class="author-name"><?php the_author(); ?></span>
                </a>
            </div>

            <!-- イベント詳細テキスト -->
            <div class="content-box">
                <div class="content-wrapper">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- 開催情報 -->
            <div class="event-info-box">
                <h3 class="event-info-title">開催情報</h3>
                <div class="event-details">
                    <div class="event-detail-item">
                        <p class="event-detail-label">
                            <i class="fas fa-calendar"></i>開催日時
                        </p>
                        <p class="event-detail-value"><?php echo esc_html(date_i18n('Y年n月j日 H:i', strtotime($event_date))); ?></p>
                    </div>

                    <div class="event-detail-item">
                        <p class="event-detail-label">
                            <i class="fas fa-map-marker-alt"></i>開催形式
                        </p>
                        <p class="event-detail-value"><?php echo $event_is_online == '1' ? 'オンライン' : 'オフライン'; ?></p>
                    </div>

                    <?php if (!$event_is_online || ($event_is_online == '0' && !empty($event_location))) : ?>
                    <div class="event-detail-item">
                        <p class="event-detail-label">
                            <i class="fas fa-location-dot"></i>開催場所
                        </p>
                        <p class="event-detail-value"><?php echo esc_html($event_location); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- いいねボタンセクション -->
                <div class="like-button-section">
                    <button class="like-button <?php echo user_liked_post(get_the_ID()) ? 'active' : ''; ?>" data-post-id="<?php echo get_the_ID(); ?>">
                        <i class="<?php echo user_liked_post(get_the_ID()) ? 'fas' : 'far'; ?> fa-heart"></i>
                        <span class="like-count"><?php echo get_post_likes(get_the_ID()); ?></span>
                    </button>
                </div>

                <!-- SNSシェアセクション -->
                <div class="social-share-section">
                    <div class="social-share-line"></div>
                    <div class="social-share-icons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social-icon twitter-icon"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.threads.net/" target="_blank" class="social-icon threads-icon"><i class="fas fa-at"></i></a>
                        <a href="#" onclick="navigator.clipboard.writeText('<?php echo esc_url(get_permalink()); ?>');alert('URLをコピーしました');return false;" class="social-icon"><i class="fas fa-share-alt"></i></a>
                    </div>
                    <div class="social-share-line"></div>
                </div>

                <!-- コメントセクション -->
                <div class="comments-section">
                    <h3 class="comments-title">コメント</h3>
                    
                    <!-- コメント投稿フォーム -->
                    <?php if (is_user_logged_in()) : ?>
                    <div class="comment-form-container">
                        <form id="comment-form" class="comment-form">
                            <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                            <textarea name="comment_content" placeholder="コメントを入力してください" required></textarea>
                            <button type="submit" class="submit-comment">コメントを投稿</button>
                        </form>
                    </div>
                    <?php else : ?>
                    <div class="login-to-comment">
                        <p>コメントを投稿するには<a href="<?php echo wp_login_url(get_permalink()); ?>">ログイン</a>してください。</p>
                    </div>
                    <?php endif; ?>

                    <!-- コメント一覧 -->
                    <div id="comments-list" class="comments-list">
                        <?php
                        $comments = get_comments(array(
                            'post_id' => get_the_ID(),
                            'status' => 'approve',
                            'order' => 'ASC'
                        ));

                        foreach ($comments as $comment) :
                            $comment_user_id = $comment->user_id;
                            $current_user_id = get_current_user_id();
                            $can_edit = is_user_logged_in() && $current_user_id === intval($comment_user_id);
                        ?>
                        <div class="comment-item" data-comment-id="<?php echo $comment->comment_ID; ?>">
                            <div class="comment-author">
                                <?php
                                $avatar_img = '';
                                $custom_avatar_id = get_user_meta($comment_user_id, 'custom_avatar', true);
                                if ($custom_avatar_id) {
                                    $avatar_img = wp_get_attachment_image($custom_avatar_id, 'thumbnail', false, array('class' => 'comment-avatar', 'style' => 'width:30px;height:30px;border-radius:50%;object-fit:cover;'));
                                }
                                if (empty($avatar_img)) {
                                    $avatar_img = get_avatar($comment_user_id, 30, '', '', array('class' => 'comment-avatar'));
                                }
                                echo $avatar_img;
                                ?>
                                <span class="comment-author-name"><?php echo get_comment_author($comment); ?></span>
                                <span class="comment-date"><?php echo get_comment_date('Y年n月j日 H:i', $comment); ?></span>
                            </div>
                            <div class="comment-content">
                                <p><?php echo esc_html($comment->comment_content); ?></p>
                            </div>
                            <?php if ($can_edit) : ?>
                            <div class="comment-actions">
                                <button class="edit-comment" data-comment-id="<?php echo $comment->comment_ID; ?>">
                                    <i class="fas fa-edit"></i> 編集
                                </button>
                                <button class="delete-comment" data-comment-id="<?php echo $comment->comment_ID; ?>">
                                    <i class="fas fa-trash"></i> 削除
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 編集・削除ボタンセクション（投稿者本人のみ表示） -->
                <?php if (is_user_logged_in() && get_current_user_id() === get_the_author_meta('ID')) : ?>
                <div class="post-edit-delete-section">
                    <a href="<?php echo esc_url(home_url('/new-post?post_id=' . get_the_ID())); ?>" class="edit-button">
                        <i class="fas fa-edit"></i> 編集
                    </a>
                    <?php
                    $delete_url = add_query_arg(
                        array(
                            'action' => 'delete_post',
                            'post_id' => get_the_ID(),
                            'nonce' => wp_create_nonce('delete_post_' . get_the_ID())
                        ),
                        admin_url('admin-post.php')
                    );
                    ?>
                    <a href="<?php echo esc_url($delete_url); ?>" class="delete-button" onclick="return confirm('この投稿を削除してもよろしいですか？');">
                        <i class="fas fa-trash"></i> 削除
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </article>
    </div>
    <div class="right-box">
        <div class="google-adsense-box">
            <!-- ここにコンテンツを追加 -->
        </div>

        <!-- カテゴリーセクション -->
        <div class="categories-sidebar">
            <h3 class="categories-title">Categories</h3>
            <ul class="categories-list">
                <?php
                // データベースから実際のカテゴリーを取得
                $categories = get_terms(array(
                    'taxonomy' => 'recruitment_category',
                    'hide_empty' => false, // 投稿がないカテゴリーも表示
                    'orderby' => 'name', // 名前順で並び替え
                    'order' => 'ASC'
                ));

                if (!empty($categories) && !is_wp_error($categories)) :
                    foreach ($categories as $category) :
                        // カテゴリーのリンクを生成
                        $category_link = add_query_arg(array(
                            'category' => $category->term_id
                        ), home_url('/recruitment'));
                ?>
                    <li class="category-item">
                        <a href="<?php echo esc_url($category_link); ?>" class="category-link">
                            <?php echo esc_html($category->name); ?>
                        </a>
                    </li>
                <?php
                    endforeach;
                else :
                    // カテゴリーが存在しない場合のメッセージ
                    echo '<li class="no-categories">カテゴリーがありません</li>';
                endif;
                ?>
            </ul>
        </div>

        <!-- 応援ボタンセクション -->
        <div class="support-button-section">
            <a href="<?php echo esc_url(home_url('/chip')); ?>" class="support-button">
                運営にチップを送る <i class="fas fa-coffee"></i>
            </a>
        </div>
    </div>
</section>

<?php
endwhile;
get_footer();
?>

<script>
jQuery(document).ready(function($) {
    // コメント投稿
    $('#comment-form').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'add_recruitment_comment',
                post_id: formData.get('post_id'),
                comment_content: formData.get('comment_content'),
                nonce: '<?php echo wp_create_nonce('add_recruitment_comment'); ?>'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('コメントの投稿に失敗しました。');
                }
            },
            error: function() {
                alert('エラーが発生しました。');
            }
        });
    });

    // コメント編集
    $('.edit-comment').on('click', function() {
        const commentId = $(this).data('comment-id');
        const commentItem = $(this).closest('.comment-item');
        const commentContent = commentItem.find('.comment-content p').text();
        
        // 編集フォームを表示
        commentItem.find('.comment-content').html(`
            <textarea class="edit-textarea">${commentContent}</textarea>
            <div class="edit-actions">
                <button class="save-edit">保存</button>
                <button class="cancel-edit">キャンセル</button>
            </div>
        `);
    });

    // 編集の保存
    $(document).on('click', '.save-edit', function() {
        const commentItem = $(this).closest('.comment-item');
        const commentId = commentItem.data('comment-id');
        const newContent = commentItem.find('.edit-textarea').val();

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'edit_recruitment_comment',
                comment_id: commentId,
                comment_content: newContent,
                nonce: '<?php echo wp_create_nonce('edit_recruitment_comment'); ?>'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('コメントの編集に失敗しました。');
                }
            },
            error: function() {
                alert('エラーが発生しました。');
            }
        });
    });

    // 編集のキャンセル
    $(document).on('click', '.cancel-edit', function() {
        location.reload();
    });

    // コメント削除
    $('.delete-comment').on('click', function() {
        if (!confirm('このコメントを削除してもよろしいですか？')) {
            return;
        }

        const commentId = $(this).data('comment-id');
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'delete_recruitment_comment',
                comment_id: commentId,
                nonce: '<?php echo wp_create_nonce('delete_recruitment_comment'); ?>'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('コメントの削除に失敗しました。');
                }
            },
            error: function() {
                alert('エラーが発生しました。');
            }
        });
    });
});
</script>