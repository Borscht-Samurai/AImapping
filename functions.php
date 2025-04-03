<?php
if (!defined('ABSPATH')) exit;

// テーマサポート機能の追加
function aimapping_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    register_nav_menus(array(
        'primary' => 'メインメニュー',
        'footer'  => 'フッターメニュー',
    ));
}
add_action('after_setup_theme', 'aimapping_setup');

// スタイルシートとスクリプトの読み込み
function aimapping_scripts() {
    wp_enqueue_style('aimapping-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    wp_enqueue_style('google-fonts-noto-sans-jp', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap', array(), null);
    wp_enqueue_script('aimapping-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0.0', true);
    
    // AJAX URLとnonceをJavaScriptに渡す
    wp_localize_script('aimapping-script', 'aimapping_ajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('aimapping_like_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'aimapping_scripts');

// カスタム投稿タイプの登録
function aimapping_register_post_types() {
    register_post_type('recruitment', array(
        'labels' => array(
            'name' => '募集',
            'singular_name' => '募集',
            'add_new' => '新規募集を追加',
            'add_new_item' => '新規募集を追加',
            'edit_item' => '募集を編集',
            'view_item' => '募集を表示',
            'search_items' => '募集を検索',
            'not_found' => '募集が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に募集はありません',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments'),
        'menu_icon' => 'dashicons-groups',
        'rewrite' => array('slug' => 'recruitment'),
        'show_in_rest' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
    ));
}
add_action('init', 'aimapping_register_post_types');

// カスタムタクソノミーの登録
function aimapping_register_taxonomies() {
    register_taxonomy('recruitment_category', 'recruitment', array(
        'labels' => array(
            'name' => '募集カテゴリー',
            'singular_name' => '募集カテゴリー',
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'recruitment-category'),
    ));
}
add_action('init', 'aimapping_register_taxonomies');

// ウィジェットエリアの登録
function aimapping_widgets_init() {
    register_sidebar(array(
        'name' => 'サイドバー',
        'id' => 'sidebar-1',
        'description' => 'メインのサイドバーウィジェットエリア',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'aimapping_widgets_init');

// イベント日付を取得する関数
function get_event_date() {
    $event_date = get_post_meta(get_the_ID(), 'event_date', true);
    if ($event_date) {
        return date_i18n('Y年n月j日', strtotime($event_date));
    }
    return '';
}

// イベント場所を取得する関数
function get_event_location() {
    $location = get_post_meta(get_the_ID(), 'event_location', true);
    $is_online = get_post_meta(get_the_ID(), 'event_is_online', true);
    if ($is_online === '1') {
        return 'オンライン開催';
    }
    return !empty($location) ? esc_html($location) : '場所未定';
}

// カテゴリーアイコンを取得する関数
function get_category_icon($slug) {
    $icons = array(
        'study' => 'book',
        'online' => 'video',
        'project' => 'project-diagram',
        'meetup' => 'users',
        'workshop' => 'chalkboard-teacher',
        'hackathon' => 'code',
        'default' => 'calendar-alt'
    );
    return isset($icons[$slug]) ? $icons[$slug] : $icons['default'];
}

// 募集カテゴリーのリストを取得する関数
function get_recruitment_categories() {
    return array(
        'study' => '勉強会',
        'online' => 'オンライン交流',
        'project' => 'プロジェクト協力者募集',
        'meetup' => '交流会',
        'workshop' => 'ワークショップ',
        'hackathon' => 'ハッカソン'
    );
}

// 投稿の閲覧数を取得する関数
function get_post_views($post_id) {
    $views = get_post_meta($post_id, 'post_views', true);
    return $views ? number_format($views) : '0';
}

// 投稿のいいね数を取得する関数
function get_post_likes($post_id) {
    $likes = get_post_meta($post_id, 'post_likes', true);
    return $likes ? number_format($likes) : '0';
}

// 閲覧数をカウントアップする関数
function increment_post_views() {
    if (is_single()) {
        $post_id = get_the_ID();
        $views = get_post_meta($post_id, 'post_views', true);
        $views = $views ? $views + 1 : 1;
        update_post_meta($post_id, 'post_views', $views);
    }
}
add_action('wp_head', 'increment_post_views');

// AJAX URLとnonceをJavaScriptに渡す
function add_ajax_url() {
    ?>
    <script>
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        var aimapping_ajax = {
            nonce: '<?php echo wp_create_nonce('aimapping_like_nonce'); ?>'
        };
    </script>
    <?php
}
add_action('wp_head', 'add_ajax_url');

// いいねボタンのAJAX処理
function handle_like_button() {
    // nonceの検証
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'aimapping_like_nonce')) {
        wp_send_json_error('セキュリティチェックに失敗しました。');
    }

    if (!isset($_POST['post_id'])) {
        wp_send_json_error('投稿IDが指定されていません。');
    }

    $post_id = intval($_POST['post_id']);
    $user_id = get_current_user_id();
    
    // ユーザーごとのいいね状態を保存するメタキー
    $liked_posts = get_user_meta($user_id, 'liked_posts', true);
    if (!is_array($liked_posts)) {
        $liked_posts = array();
    }

    // いいねの状態を確認
    $is_liked = in_array($post_id, $liked_posts);
    
    // いいね数を取得
    $likes = get_post_meta($post_id, 'post_likes', true);
    $likes = $likes ? intval($likes) : 0;

    if ($is_liked) {
        // いいねを取り消す
        $likes = max(0, $likes - 1);
        $liked_posts = array_diff($liked_posts, array($post_id));
    } else {
        // いいねを追加
        $likes++;
        $liked_posts[] = $post_id;
    }

    // いいね数を更新
    update_post_meta($post_id, 'post_likes', $likes);
    // ユーザーのいいね状態を更新
    update_user_meta($user_id, 'liked_posts', $liked_posts);

    wp_send_json_success(array(
        'likes' => number_format($likes),
        'is_liked' => !$is_liked
    ));
}
add_action('wp_ajax_handle_like', 'handle_like_button');
add_action('wp_ajax_nopriv_handle_like', 'handle_like_button');

// カスタムフィールド（募集）メタボックス
function add_event_meta_boxes() {
    add_meta_box('recruitment_details', '募集詳細', 'render_event_meta_box', 'recruitment', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_event_meta_boxes');

function render_event_meta_box($post) {
    wp_nonce_field('event_meta_box', 'event_meta_box_nonce');
    $event_date = get_post_meta($post->ID, 'event_date', true);
    $event_location = get_post_meta($post->ID, 'event_location', true);
    $event_is_online = get_post_meta($post->ID, 'event_is_online', true);
    ?>
    <p><label for="event_date">開催日時：</label>
    <input type="datetime-local" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>"></p>
    <p><label for="event_is_online">開催形式：</label>
    <select id="event_is_online" name="event_is_online">
        <option value="0" <?php selected($event_is_online, '0'); ?>>オフライン</option>
        <option value="1" <?php selected($event_is_online, '1'); ?>>オンライン</option>
    </select></p>
    <p><label for="event_location">開催場所：</label>
    <input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>"></p>
    <?php
}

function save_event_meta_box($post_id) {
    if (!isset($_POST['event_meta_box_nonce'])) return;
    if (!wp_verify_nonce($_POST['event_meta_box_nonce'], 'event_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    $fields = array('event_date', 'event_location', 'event_is_online');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_recruitment', 'save_event_meta_box');

// 新規投稿フォームの処理
function handle_new_post_submission() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['new_post_nonce'])) {
        return;
    }

    // nonce検証
    if (!wp_verify_nonce($_POST['new_post_nonce'], 'new_post_action')) {
        wp_die('不正なアクセスです。');
    }

    // ユーザーログインチェック
    if (!is_user_logged_in()) {
        wp_redirect(home_url('/login'));
        exit;
    }

    // 必須項目のチェック
    $required_fields = array('post_title', 'post_content', 'post_category', 'event_date', 'location_type');
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            wp_die('必須項目が入力されていません。');
        }
    }

    // 投稿データの準備
    $post_data = array(
        'post_title'    => sanitize_text_field($_POST['post_title']),
        'post_content'  => wp_kses_post($_POST['post_content']),
        'post_status'   => 'publish',
        'post_type'     => 'recruitment',
        'post_author'   => get_current_user_id()
    );

    // 投稿を作成
    $post_id = wp_insert_post($post_data);

    if (!is_wp_error($post_id)) {
        // イベントメタ情報を保存
        update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
        update_post_meta($post_id, 'event_is_online', $_POST['location_type'] === 'online' ? '1' : '0');
        
        if ($_POST['location_type'] === 'offline' && !empty($_POST['location_detail'])) {
            update_post_meta($post_id, 'event_location', sanitize_text_field($_POST['location_detail']));
        } elseif ($_POST['location_type'] === 'online') {
            update_post_meta($post_id, 'event_location', 'オンライン開催');
        }

        // カテゴリーを設定
        if (!empty($_POST['post_category'])) {
            $category_slug = sanitize_text_field($_POST['post_category']);
            $term = get_term_by('slug', $category_slug, 'recruitment_category');
            if ($term) {
                wp_set_object_terms($post_id, $term->term_id, 'recruitment_category');
            } else {
                // カテゴリーが存在しない場合は新規作成
                $new_term = wp_insert_term($category_slug, 'recruitment_category', array('slug' => $category_slug));
                if (!is_wp_error($new_term)) {
                    wp_set_object_terms($post_id, $new_term['term_id'], 'recruitment_category');
                }
            }
        }

        // リダイレクト
        wp_redirect(get_permalink($post_id));
        exit;
    } else {
        wp_die('投稿の作成に失敗しました。');
    }
}
add_action('template_redirect', 'handle_new_post_submission');

// 投稿タイプを変更する関数
function convert_event_to_recruitment() {
    global $wpdb;
    
    // 投稿タイプの変更
    $wpdb->query(
        $wpdb->prepare(
            "UPDATE {$wpdb->posts} SET post_type = 'recruitment' WHERE post_type = 'event'"
        )
    );
    
    // タクソノミーの変更
    $wpdb->query(
        $wpdb->prepare(
            "UPDATE {$wpdb->term_taxonomy} SET taxonomy = 'recruitment_category' WHERE taxonomy = 'event_category'"
        )
    );
    
    // パーマリンク構造を更新
    flush_rewrite_rules();
}

// アクティベーション時に実行
function theme_activation() {
    convert_event_to_recruitment();
}
add_action('after_switch_theme', 'theme_activation');

// 手動実行用のアクションフック
add_action('init', function() {
    if (isset($_GET['convert_posts']) && current_user_can('manage_options')) {
        convert_event_to_recruitment();
        wp_redirect(remove_query_arg('convert_posts'));
        exit;
    }
});

// 検索フィルターの処理
function aimapping_filter_query($query) {
    // メインクエリでなければ処理しない
    if (!$query->is_main_query()) {
        return;
    }

    // 募集アーカイブページの場合の処理
    if ($query->is_post_type_archive('recruitment') || $query->is_tax('recruitment_category')) {
        // 検索フィルターに関連するメタクエリを初期化
        $meta_query = array();

        // 期限切れの募集を非表示にする（既存のfilter_expired_recruitmentsの内容と統合）
        $meta_query[] = array(
            'relation' => 'OR',
            array(
                'key' => 'event_date',
                'value' => current_time('mysql'),
                'compare' => '>=',
                'type' => 'DATETIME'
            ),
            array(
                'key' => 'event_date',
                'compare' => 'NOT EXISTS'
            )
        );

        // カテゴリーフィルター
        if (isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] != 0) {
            $tax_query = array(
                array(
                    'taxonomy' => 'recruitment_category',
                    'field'    => 'term_id',
                    'terms'    => intval($_GET['category']),
                ),
            );
            $query->set('tax_query', $tax_query);
        }

        // 開催形式フィルター（オンライン/オフライン）
        if (isset($_GET['location']) && !empty($_GET['location'])) {
            if ($_GET['location'] === 'online') {
                $meta_query[] = array(
                    'key'     => 'event_is_online',
                    'value'   => '1',
                    'compare' => '='
                );
            } elseif ($_GET['location'] === 'offline') {
                $meta_query[] = array(
                    'key'     => 'event_is_online',
                    'value'   => '0',
                    'compare' => '='
                );
            }
        }

        // 開催場所フィルター（オフラインの場合のみ適用）
        if (isset($_GET['event_location']) && !empty($_GET['event_location'])) {
            // オフライン且つ特定の開催場所を指定する場合の条件
            $location_meta_query = array(
                'relation' => 'AND',
                array(
                    'key'     => 'event_is_online',
                    'value'   => '0',
                    'compare' => '='
                ),
                array(
                    'key'     => 'event_location',
                    'value'   => $_GET['event_location'],
                    'compare' => '='
                )
            );
            
            $meta_query[] = $location_meta_query;
        }

        // メタクエリを設定
        if (!empty($meta_query)) {
            $query->set('meta_query', $meta_query);
        }

        // 並び順の設定
        if (isset($_GET['orderby']) && !empty($_GET['orderby'])) {
            switch($_GET['orderby']) {
                case 'date':
                    $query->set('orderby', 'date');
                    $query->set('order', 'DESC');
                    break;
                case 'views':
                    $query->set('meta_key', 'post_views');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'DESC');
                    break;
                case 'likes':
                    $query->set('meta_key', 'post_likes');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'DESC');
                    break;
            }
        }
    }
}
add_action('pre_get_posts', 'aimapping_filter_query');

// 募集一覧のクエリを修正して期限切れの募集を非表示にする
function filter_expired_recruitments($query) {
    // この関数の機能はaimapping_filter_query関数に統合されたため、空にします
    return;
}
add_action('pre_get_posts', 'filter_expired_recruitments');

// コメント編集用のAJAXハンドラー
function handle_update_comment() {
    // セキュリティチェック
    if (!check_ajax_referer('update_comment_nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce');
        return;
    }

    $comment_id = intval($_POST['comment_id']);
    $content = wp_kses_post($_POST['content']);
    $comment = get_comment($comment_id);

    // 権限チェック
    if (!$comment || $comment->user_id != get_current_user_id()) {
        wp_send_json_error('Permission denied');
        return;
    }

    // コメントを更新
    $updated = wp_update_comment(array(
        'comment_ID' => $comment_id,
        'comment_content' => $content
    ));

    if ($updated) {
        wp_send_json_success(array(
            'content' => apply_filters('comment_text', $content)
        ));
    } else {
        wp_send_json_error('Update failed');
    }
}
add_action('wp_ajax_update_comment', 'handle_update_comment');

// コメント削除用のAJAXハンドラー
function handle_delete_comment() {
    // セキュリティチェック
    if (!check_ajax_referer('delete_comment_nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce');
        return;
    }

    $comment_id = intval($_POST['comment_id']);
    $comment = get_comment($comment_id);

    // 権限チェック
    if (!$comment || $comment->user_id != get_current_user_id()) {
        wp_send_json_error('Permission denied');
        return;
    }

    // コメントを削除
    $deleted = wp_delete_comment($comment_id, true);

    if ($deleted) {
        wp_send_json_success();
    } else {
        wp_send_json_error('Delete failed');
    }
}
add_action('wp_ajax_delete_comment', 'handle_delete_comment');

// コメント投稿をログインユーザーのみに制限
function restrict_comment_posting() {
    if (!is_user_logged_in()) {
        wp_die('コメントを投稿するにはログインが必要です。', 'ログインが必要です', array('response' => 403));
    }
}
add_action('pre_comment_on_post', 'restrict_comment_posting');

// ユーザー登録処理など（ここはそのまま）


// --- 募集管理画面カスタマイズ ここから ---

// 募集の管理画面一覧に開催日のカラムを追加
function add_recruitment_columns($columns) {
    $new_columns = array();
    $date_column = null;

    // 'date' カラム（公開日時）を一時的に保持し、元の配列から削除
    if (isset($columns['date'])) {
        $date_column = $columns['date'];
        unset($columns['date']);
    }

    foreach ($columns as $key => $title) {
        $new_columns[$key] = $title;
        // 'title' カラムの直後に 'event_date' カラムを挿入
        if ($key === 'title') {
            $new_columns['event_date'] = '開催日時';
        }
    }

    // 保持していた 'date' カラムを配列の末尾に追加（公開日時を最後に表示）
    if ($date_column !== null) {
        $new_columns['date'] = $date_column;
    }

    return $new_columns;
}
add_filter('manage_recruitment_posts_columns', 'add_recruitment_columns');

// 開催日のカラムに内容を表示
function custom_recruitment_column($column, $post_id) {
    // 追加した 'event_date' カラムの場合のみ処理
    if ($column === 'event_date') {
        // 'event_date' メタデータを取得
        $event_date = get_post_meta($post_id, 'event_date', true);
        if (!empty($event_date)) {
            // datetime-local形式 ('YYYY-MM-DDTHH:MM') の値をパースしてフォーマット
            try {
                // DateTime オブジェクトを作成
                $datetime = new DateTime($event_date);
                // WordPress の日付・時刻フォーマット設定に従って表示
                echo esc_html($datetime->format(get_option('date_format') . ' ' . get_option('time_format')));
            } catch (Exception $e) {
                // 日付文字列のパースに失敗した場合（予期せぬ形式など）は、元の値をそのまま表示
                echo esc_html($event_date);
            }
        } else {
            // メタデータが未設定の場合はハイフンを表示
            echo '—';
        }
    }
}
// 'manage_{post_type}_posts_custom_column' アクションフックを使用
add_action('manage_recruitment_posts_custom_column', 'custom_recruitment_column', 10, 2);

// 開催日でソート可能にする
function recruitment_sortable_columns($columns) {
    // 'event_date' カラムをソート可能として登録
    $columns['event_date'] = 'event_date';
    return $columns;
}
// 'manage_edit-{post_type}_sortable_columns' フィルターフックを使用
add_filter('manage_edit-recruitment_sortable_columns', 'recruitment_sortable_columns');

// 開催日でのソート処理
function recruitment_custom_orderby($query) {
    // 管理画面のメインクエリ、かつ recruitment 投稿タイプの場合のみ処理
    if (!is_admin() || !$query->is_main_query() || $query->get('post_type') !== 'recruitment') {
        return;
    }

    // クエリの 'orderby' パラメータが 'event_date' の場合
    if ($query->get('orderby') === 'event_date') {
        // ソートの基準となるメタキーを 'event_date' に設定
        $query->set('meta_key', 'event_date');
        // メタデータの値を日時 (DATETIME) として比較するように設定
        // 'YYYY-MM-DDTHH:MM' 形式は DATETIME として扱えるため、正確なソートが可能
        $query->set('orderby', 'meta_value_datetime');
    }
}
// 'pre_get_posts' アクションフックでクエリを変更
add_action('pre_get_posts', 'recruitment_custom_orderby');

// --- 募集管理画面カスタマイズ ここまで ---

/**
 * ログイン失敗時のリダイレクト先をカスタムログインページに変更する
 */
function custom_login_failed_redirect( $username ) {
    // リファラー（フォームが送信されたページ）を取得
    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

    // カスタムログインページのURLを取得
    // '/login/' の部分は、実際のログインページのパーマリンク（スラッグ）に合わせて変更してください
    $custom_login_page_url = home_url('/login/'); // ← ここの '/login/' を確認・修正してください

    // リファラーがカスタムログインページであり、ユーザー名またはパスワードが入力されている場合
    // (ユーザー名とパスワードの空チェックは authenticate フックで行うため、ここではチェックしない)
    if ( !empty($referrer) && strpos($referrer, $custom_login_page_url) !== false ) {
        // カスタムログインページに 'login=failed' パラメータを付けてリダイレクト
        // wp_redirect() は exit しないので、後続の処理を防ぐために exit を呼び出す
        wp_redirect( add_query_arg('login', 'failed', $custom_login_page_url) );
        exit;
    }
    // それ以外の場合はデフォルトの動作（wp-login.phpでのエラー表示）に任せる可能性があるが、
    // 通常はこのテンプレートから送信されるはずなので、リダイレクトされる想定
}
add_action( 'wp_login_failed', 'custom_login_failed_redirect', 10, 1 ); // 優先度を指定

/**
 * ユーザー名・パスワードが空の場合のリダイレクト処理
 */
function custom_login_empty_redirect( $user, $username, $password ) {
    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

    // カスタムログインページのURLを取得
    // '/login/' の部分は、実際のログインページのパーマリンク（スラッグ）に合わせて変更してください
    $custom_login_page_url = home_url('/login/'); // ← ここの '/login/' を確認・修正してください

    // リファラーがカスタムログインページの場合のみ処理
    if ( !empty($referrer) && strpos($referrer, $custom_login_page_url) !== false ) {
        // ユーザー名またはパスワードが空の場合
        if ( empty($username) || empty($password) ) {
            // wp_authenticate() が WP_Error を返すようにすると、wp_login_failed フックが呼ばれる
            // ここでエラーオブジェクトを生成し、wp_login_failed フック側でリダイレクトさせる
            $error = new WP_Error();
            // エラーコードは何でもよいが、 'empty_fields' など分かりやすいものが推奨される
            $error->add('empty_fields', __('<strong>エラー</strong>: ユーザー名とパスワードの両方を入力してください。', 'textdomain')); // textdomain はテーマに合わせて変更
            // wp_login_failed フックにエラーオブジェクトを渡すために、ユーザー引数を上書きする
            // （通常は $username を渡すが、WP_Error オブジェクトを渡すことで login_failed 側で処理を分岐できるかもしれないが、
            //   wp_login_failed フックの引数は $username 固定のため、この方法は使えない）

            // 代わりに、ここで直接リダイレクトする
             wp_redirect( add_query_arg('login', 'failed', $custom_login_page_url) );
             exit;

            // return $error; // これを返すと wp-login.php のエラー表示になる
        }
    }
    // ユーザー名・パスワードが入力されていれば、通常の認証処理へ
    return $user;
}
// authenticate フックは認証プロセスの一番最初に行われるため、優先度をデフォルトより少し後 (例: 30) に設定
// 他のプラグイン（例：セキュリティ系）が authenticate フックを使っている場合、競合しないように調整が必要
add_filter( 'authenticate', 'custom_login_empty_redirect', 30, 3 );

