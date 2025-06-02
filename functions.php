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
    wp_enqueue_script('aimapping-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);

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
    // データベースから実際のカテゴリーを取得
    $categories = get_terms(array(
        'taxonomy' => 'recruitment_category',
        'hide_empty' => false,
    ));

    // カテゴリーが存在する場合は、slug => name の配列を作成して返す
    if (!empty($categories) && !is_wp_error($categories)) {
        $category_list = array();
        foreach ($categories as $category) {
            $category_list[$category->slug] = $category->name;
        }
        return $category_list;
    }

    // カテゴリーが存在しない場合は、デフォルトのカテゴリーリストを返す
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

// ユーザーが投稿にいいねしたかどうかを確認する関数
function user_liked_post($post_id) {
    if (!is_user_logged_in()) {
        return false;
    }

    $user_id = get_current_user_id();
    $liked_posts = get_user_meta($user_id, 'liked_posts', true);

    if (!is_array($liked_posts)) {
        return false;
    }

    return in_array($post_id, $liked_posts);
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

    // ログイン状態の確認
    if (!is_user_logged_in()) {
        wp_send_json_error(array(
            'message' => 'いいねを付けるにはログインが必要です。',
            'require_login' => true
        ));
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

    // 編集モードかチェック
    $edit_mode = isset($_POST['edit_mode']) && $_POST['edit_mode'] == '1';
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    if ($edit_mode && $post_id > 0) {
        // 投稿が存在するかチェック
        $post = get_post($post_id);
        if (!$post || $post->post_type !== 'recruitment') {
            wp_die('指定された投稿が存在しません。');
        }

        // 投稿者か管理者かチェック
        if (get_current_user_id() !== $post->post_author && !current_user_can('administrator')) {
            wp_die('この投稿を編集する権限がありません。');
        }

        // 投稿データの準備
        $post_data = array(
            'ID'            => $post_id,
            'post_title'    => sanitize_text_field($_POST['post_title']),
            'post_content'  => wp_kses_post($_POST['post_content']),
        );

        // 投稿を更新
        $updated = wp_update_post($post_data);

        if (!is_wp_error($updated)) {
            // イベントメタ情報を保存
            update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
            update_post_meta($post_id, 'event_is_online', $_POST['location_type'] === 'online' ? '1' : '0');

            if ($_POST['location_type'] === 'offline' && !empty($_POST['location_detail'])) {
                update_post_meta($post_id, 'event_location', sanitize_text_field($_POST['location_detail']));
            } elseif ($_POST['location_type'] === 'online') {
                update_post_meta($post_id, 'event_location', 'オンライン開催');
            } else {
                delete_post_meta($post_id, 'event_location');
            }

            // カテゴリーを設定
            if (!empty($_POST['post_category'])) {
                $category_slug = sanitize_text_field($_POST['post_category']);
                $term = get_term_by('slug', $category_slug, 'recruitment_category');
                if ($term) {
                    wp_set_object_terms($post_id, $term->term_id, 'recruitment_category');
                } else {
                    // カテゴリーが存在しない場合は新規作成
                    // カテゴリー名を取得（POSTデータまたはデフォルトカテゴリーリストから）
                    $category_name = '';
                    if (!empty($_POST['post_category_name'])) {
                        $category_name = sanitize_text_field($_POST['post_category_name']);
                    } else {
                        $default_categories = array(
                            'study' => '勉強会',
                            'online' => 'オンライン交流',
                            'project' => 'プロジェクト協力者募集',
                            'meetup' => '交流会',
                            'workshop' => 'ワークショップ',
                            'hackathon' => 'ハッカソン'
                        );
                        $category_name = isset($default_categories[$category_slug]) ? $default_categories[$category_slug] : $category_slug;
                    }

                    $new_term = wp_insert_term($category_name, 'recruitment_category', array('slug' => $category_slug));
                    if (!is_wp_error($new_term)) {
                        wp_set_object_terms($post_id, $new_term['term_id'], 'recruitment_category');
                    }
                }
            }

            // リダイレクト
            wp_redirect(get_permalink($post_id));
            exit;
        } else {
            wp_die('投稿の更新に失敗しました。');
        }
    } else {
        // 新規投稿モード
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
                    // カテゴリー名を取得（POSTデータまたはデフォルトカテゴリーリストから）
                    $category_name = '';
                    if (!empty($_POST['post_category_name'])) {
                        $category_name = sanitize_text_field($_POST['post_category_name']);
                    } else {
                        $default_categories = array(
                            'study' => '勉強会',
                            'online' => 'オンライン交流',
                            'project' => 'プロジェクト協力者募集',
                            'meetup' => '交流会',
                            'workshop' => 'ワークショップ',
                            'hackathon' => 'ハッカソン'
                        );
                        $category_name = isset($default_categories[$category_slug]) ? $default_categories[$category_slug] : $category_slug;
                    }

                    $new_term = wp_insert_term($category_name, 'recruitment_category', array('slug' => $category_slug));
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

// カスタムアバターを表示するためのフィルター
function custom_avatar_filter($avatar, $id_or_email, $size, $default, $alt) {
    // ユーザーIDを取得
    $user_id = 0;
    if (is_numeric($id_or_email)) {
        $user_id = (int) $id_or_email;
    } elseif (is_string($id_or_email)) {
        $user = get_user_by('email', $id_or_email);
        if ($user) {
            $user_id = $user->ID;
        }
    } elseif (is_object($id_or_email)) {
        if (!empty($id_or_email->user_id)) {
            $user_id = (int) $id_or_email->user_id;
        } elseif (!empty($id_or_email->comment_author_email)) {
            $user = get_user_by('email', $id_or_email->comment_author_email);
            if ($user) {
                $user_id = $user->ID;
            }
        }
    }

    // ユーザーIDが取得できた場合、カスタムアバターを確認
    if ($user_id > 0) {
        $custom_avatar_id = get_user_meta($user_id, 'custom_avatar', true);
        if ($custom_avatar_id) {
            $image_size = array($size, $size); // get_avatar に渡されたサイズを使用
            $image = wp_get_attachment_image_src($custom_avatar_id, $image_size);
            if ($image) {
                // キャッシュ対策としてタイムスタンプを追加
                $timestamp = get_user_meta($user_id, 'avatar_updated', true);
                $cache_buster = $timestamp ? "?v={$timestamp}" : '';
                $avatar = sprintf(
                    '<img alt="%s" src="%s%s" class="avatar avatar-%d photo" height="%d" width="%d" loading="lazy" />',
                    esc_attr($alt),
                    esc_url($image[0]),
                    $cache_buster,
                    (int) $size,
                    (int) $size,
                    (int) $size
                );
            }
        }
    }

    return $avatar;
}
add_filter('get_avatar', 'custom_avatar_filter', 10, 5);

// プロフィール画像が更新されたときにタイムスタンプを更新
function update_avatar_timestamp($user_id) {
    update_user_meta($user_id, 'avatar_updated', time());
}
add_action('profile_update', 'update_avatar_timestamp');
add_action('user_register', 'update_avatar_timestamp');

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

/**
 * 投稿削除機能のハンドラー
 */
function handle_delete_post() {
    // リクエストチェック
    if (!isset($_GET['action']) || $_GET['action'] !== 'delete_post' || !isset($_GET['post_id']) || !isset($_GET['nonce'])) {
        return;
    }

    $post_id = intval($_GET['post_id']);
    $nonce = $_GET['nonce'];

    // nonceの検証
    if (!wp_verify_nonce($nonce, 'delete_post_' . $post_id)) {
        wp_die('不正なアクセスです。');
    }

    // 投稿が存在するか確認
    $post = get_post($post_id);
    if (!$post) {
        wp_die('指定された投稿が存在しません。');
    }

    // 投稿者か管理者か確認
    if (get_current_user_id() !== $post->post_author && !current_user_can('administrator')) {
        wp_die('この投稿を削除する権限がありません。');
    }

    // 投稿を削除
    $deleted = wp_delete_post($post_id, true);

    if ($deleted) {
        // 削除成功時は一覧ページにリダイレクト
        wp_redirect(home_url('/recruitment'));
        exit;
    } else {
        // 削除失敗時はエラーメッセージを表示
        wp_die('投稿の削除に失敗しました。');
    }
}
add_action('admin_post_delete_post', 'handle_delete_post');
add_action('admin_post_nopriv_delete_post', 'handle_delete_post');

/**
 * ページテンプレートでコメント数を取得しようとした場合にエラーを回避する
 */
function fix_comment_count_error($count, $post_id) {
    if (is_page_template('page-templates/new-post-template.php') || is_page_template('page-templates/edit-post-template.php')) {
        return 0;
    }
    return $count;
}
add_filter('get_comments_number', 'fix_comment_count_error', 10, 2);

/**
 * カスタムページテンプレートを登録する
 */
function register_custom_page_templates($templates) {
    // テンプレートの配列に追加
    $templates['page-templates/contact-template.php'] = 'お問い合わせページ';
    $templates['page-templates/login-template.php'] = 'ログインページ';
    $templates['page-templates/register-template.php'] = '会員登録ページ';
    $templates['page-templates/new-post-template.php'] = '新規投稿';
    $templates['page-templates/edit-post-template.php'] = '投稿編集ページ';
    $templates['page-templates/edit-profile.php'] = 'プロフィール編集ページ';
    $templates['page-templates/privacy-policy-template.php'] = 'プライバシーポリシー';
    $templates['page-templates/terms-of-service-template.php'] = '利用規約';

    return $templates;
}
add_filter('theme_page_templates', 'register_custom_page_templates');

/**
 * カスタムテンプレートの読み込みパスを修正
 */
function locate_template_in_subfolders($template) {
    global $post;

    if (is_null($post)) {
        return $template;
    }

    // 現在のテンプレート名を取得
    $current_template = get_post_meta($post->ID, '_wp_page_template', true);

    // テンプレートが指定されていない場合は処理しない
    if (!$current_template || $current_template == 'default') {
        return $template;
    }

    // page-templates ディレクトリ内のテンプレートを探す
    if (strpos($current_template, 'page-templates/') === 0) {
        $file = get_template_directory() . '/' . $current_template;

        if (file_exists($file)) {
            return $file;
        }
    }

    return $template;
}
add_filter('page_template', 'locate_template_in_subfolders');

/**
 * 特定のスラッグのページに特定のテンプレートを強制的に適用
 */
function force_template_for_specific_pages($template) {
    global $post;

    if (is_null($post)) {
        return $template;
    }

    // お問い合わせページ（スラッグ: contact）
    if (is_page() && $post->post_name === 'contact') {
        $contact_template = get_template_directory() . '/page-templates/contact-template.php';
        if (file_exists($contact_template)) {
            return $contact_template;
        }
    }

    // ログインページ（スラッグ: login）
    if (is_page() && $post->post_name === 'login') {
        $login_template = get_template_directory() . '/page-templates/login-template.php';
        if (file_exists($login_template)) {
            return $login_template;
        }
    }

    // 会員登録ページ（スラッグ: register）
    if (is_page() && $post->post_name === 'register') {
        $register_template = get_template_directory() . '/page-templates/register-template.php';
        if (file_exists($register_template)) {
            return $register_template;
        }
    }

    // 新規投稿ページ（スラッグ: new-post）
    if (is_page() && $post->post_name === 'new-post') {
        $new_post_template = get_template_directory() . '/page-templates/new-post-template.php';
        if (file_exists($new_post_template)) {
            return $new_post_template;
        }
    }

    // プライバシーポリシーページ（スラッグ: privacy）
    if (is_page() && $post->post_name === 'privacy') {
        $privacy_template = get_template_directory() . '/page-templates/privacy-policy-template.php';
        if (file_exists($privacy_template)) {
            return $privacy_template;
        }
    }

    // 利用規約ページ（スラッグ: terms）
    if (is_page() && $post->post_name === 'terms') {
        $terms_template = get_template_directory() . '/page-templates/terms-of-service-template.php';
        if (file_exists($terms_template)) {
            return $terms_template;
        }
    }

    // Chipページ（スラッグ: chip）
    if (is_page() && $post->post_name === 'chip') {
        $chip_template = get_template_directory() . '/page-templates/page-chip.php';
        if (file_exists($chip_template)) {
            return $chip_template;
        }
    }

    return $template;
}
add_filter('template_include', 'force_template_for_specific_pages', 99);

/**
 * Ajax で追加の投稿を読み込む
 */
function load_more_posts() {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    
    if (!$user_id) {
        wp_send_json_error();
        return;
    }
    
    $args = array(
        'post_type' => 'recruitment',
        'posts_per_page' => 6,
        'author' => $user_id,
        'paged' => $page,
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => 3 // 最初の3件は既に表示されているため
    );
    
    $query = new WP_Query($args);
    $html = '';
    
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'card');
        }
        $html = ob_get_clean();
        wp_reset_postdata();
    }
    
    wp_send_json_success(array(
        'html' => $html,
        'is_last_page' => $query->max_num_pages <= $page
    ));
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

/**
 * Ajax URL を JavaScript に渡す
 */
function enqueue_ajax_url() {
    wp_enqueue_script('wp-api');
    wp_localize_script('wp-api', 'wpApiSettings', array(
        'ajaxUrl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_url');

/**
 * 著者アーカイブページのテンプレートを強制的に指定
 */
function force_author_template($template) {
    // 著者アーカイブページの場合
    if (is_author()) {
        // 現在のユーザーと表示中の著者が同じ場合は、userページにリダイレクト
        $current_user_id = get_current_user_id();
        $author = get_queried_object();
        
        if (is_user_logged_in() && $current_user_id === $author->ID) {
            wp_redirect(home_url('/user/'));
            exit;
        }
        
        // それ以外の場合は author.php を使用
        $author_template = get_template_directory() . '/author.php';
        if (file_exists($author_template)) {
            return $author_template;
        }
    }
    
    // ユーザーページの場合
    if (is_page('user')) {
        if (!is_user_logged_in()) {
            wp_redirect(home_url('/login/'));
            exit;
        }
        $user_template = get_template_directory() . '/page-user.php';
        if (file_exists($user_template)) {
            return $user_template;
        }
    }
    
    return $template;
}
add_filter('template_include', 'force_author_template', 99);

/**
 * ユーザーメタデータの保存
 */
function save_user_profile_data($user_id, $data) {
    // プロフィール画像
    if (isset($data['custom_avatar'])) {
        update_user_meta($user_id, 'custom_avatar', $data['custom_avatar']);
    }

    // 基本情報
    if (isset($data['description'])) {
        update_user_meta($user_id, 'description', sanitize_textarea_field($data['description']));
    }

    // 役職
    if (isset($data['role'])) {
        update_user_meta($user_id, 'role', sanitize_text_field($data['role']));
    }

    // SNSリンク
    $sns_fields = array('twitter_url', 'facebook_url', 'instagram_url', 'youtube_url');
    foreach ($sns_fields as $field) {
        if (isset($data[$field])) {
            update_user_meta($user_id, $field, esc_url_raw($data[$field]));
        }
    }
}

/**
 * ユーザーメタデータの取得
 */
function get_user_profile_data($user_id) {
    $profile_data = array(
        'custom_avatar' => get_user_meta($user_id, 'custom_avatar', true),
        'description' => get_user_meta($user_id, 'description', true),
        'role' => get_user_meta($user_id, 'role', true),
        'twitter_url' => get_user_meta($user_id, 'twitter_url', true),
        'facebook_url' => get_user_meta($user_id, 'facebook_url', true),
        'instagram_url' => get_user_meta($user_id, 'instagram_url', true),
        'youtube_url' => get_user_meta($user_id, 'youtube_url', true)
    );

    return $profile_data;
}

/**
 * プロフィール編集フォームの処理
 */
function handle_profile_edit() {
    // セキュリティチェック
    if (!isset($_POST['profile_edit_nonce']) || !wp_verify_nonce($_POST['profile_edit_nonce'], 'profile_edit_action')) {
        wp_die('セキュリティチェックに失敗しました。');
    }

    // ユーザーがログインしているか確認
    if (!is_user_logged_in()) {
        wp_redirect(home_url('/login/'));
        exit;
    }

    $user_id = get_current_user_id();

    // アカウント名（display_name）の更新
    if (isset($_POST['display_name']) && !empty($_POST['display_name'])) {
        wp_update_user(array(
            'ID' => $user_id,
            'display_name' => sanitize_text_field($_POST['display_name'])
        ));
    }

    // プロフィール画像の処理
    if (isset($_FILES['custom_avatar']) && $_FILES['custom_avatar']['size'] > 0) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $attachment_id = media_handle_upload('custom_avatar', 0);
        if (!is_wp_error($attachment_id)) {
            update_user_meta($user_id, 'custom_avatar', $attachment_id);
        }
    }

    // 基本情報の処理
    if (isset($_POST['description'])) {
        update_user_meta($user_id, 'description', $_POST['description']);
    }

    // 役職の処理
    if (isset($_POST['role'])) {
        update_user_meta($user_id, 'role', sanitize_text_field($_POST['role']));
    }

    // SNSリンクの処理
    $sns_fields = array('twitter_url', 'facebook_url', 'instagram_url', 'youtube_url');
    foreach ($sns_fields as $field) {
        if (isset($_POST[$field])) {
            update_user_meta($user_id, $field, esc_url_raw($_POST[$field]));
        }
    }

    // データを保存
    save_user_profile_data($user_id, array(
        'custom_avatar' => get_user_meta($user_id, 'custom_avatar', true),
        'description' => get_user_meta($user_id, 'description', true),
        'role' => get_user_meta($user_id, 'role', true),
        'twitter_url' => get_user_meta($user_id, 'twitter_url', true),
        'facebook_url' => get_user_meta($user_id, 'facebook_url', true),
        'instagram_url' => get_user_meta($user_id, 'instagram_url', true),
        'youtube_url' => get_user_meta($user_id, 'youtube_url', true)
    ));

    // リダイレクト
    wp_redirect(home_url('/user/'));
    exit;
}
add_action('admin_post_edit_profile', 'handle_profile_edit');

/**
 * フォロー機能のスタブ関数
 */
function is_following_user($user_id) {
    if (!is_user_logged_in()) {
        return false;
    }
    
    $current_user_id = get_current_user_id();
    $following = get_user_meta($current_user_id, 'following', true);
    
    if (!is_array($following)) {
        return false;
    }
    
    return in_array($user_id, $following);
}

/**
 * フォロー/フォロー解除のアクション処理
 */
function handle_follow_unfollow() {
    if (!isset($_GET['action']) || !isset($_GET['user_id']) || !isset($_GET['nonce'])) {
        wp_redirect(home_url());
        exit;
    }

    $action = $_GET['action'];
    $user_id = intval($_GET['user_id']);
    $nonce = $_GET['nonce'];

    if (!wp_verify_nonce($nonce, ($action === 'follow_user' ? 'follow_' : 'unfollow_') . $user_id)) {
        wp_die('不正なアクセスです。');
    }

    if (!is_user_logged_in()) {
        wp_redirect(home_url('/login/'));
        exit;
    }

    $current_user_id = get_current_user_id();
    $following = get_user_meta($current_user_id, 'following', true);
    
    if (!is_array($following)) {
        $following = array();
    }

    if ($action === 'follow_user') {
        if (!in_array($user_id, $following)) {
            $following[] = $user_id;
        }
    } else {
        $following = array_diff($following, array($user_id));
    }

    update_user_meta($current_user_id, 'following', $following);

    // リダイレクト先のURLを生成
    $redirect_url = add_query_arg('user_id', $user_id, home_url('/profile/'));
    wp_redirect($redirect_url);
    exit;
}
add_action('admin_post_follow_user', 'handle_follow_unfollow');
add_action('admin_post_unfollow_user', 'handle_follow_unfollow');

/**
 * メッセージ機能のスタブ関数
 */
function send_message_to_user($recipient_id, $message) {
    // この関数は将来的にメッセージ機能を実装する際に使用します
    return true;
}

// コメント関連の処理を追加
function add_recruitment_comment() {
    check_ajax_referer('add_recruitment_comment', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error('ログインが必要です。');
        return;
    }

    $post_id = intval($_POST['post_id']);
    $comment_content = sanitize_textarea_field($_POST['comment_content']);

    $comment_data = array(
        'comment_post_ID' => $post_id,
        'comment_content' => $comment_content,
        'user_id' => get_current_user_id(),
        'comment_author' => wp_get_current_user()->display_name,
        'comment_author_email' => wp_get_current_user()->user_email,
        'comment_type' => 'recruitment_comment',
        'comment_approved' => 1
    );

    $comment_id = wp_insert_comment($comment_data);

    if ($comment_id) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_add_recruitment_comment', 'add_recruitment_comment');

function edit_recruitment_comment() {
    check_ajax_referer('edit_recruitment_comment', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error('ログインが必要です。');
        return;
    }

    $comment_id = intval($_POST['comment_id']);
    $comment_content = sanitize_textarea_field($_POST['comment_content']);
    $comment = get_comment($comment_id);

    if (!$comment || $comment->user_id != get_current_user_id()) {
        wp_send_json_error('権限がありません。');
        return;
    }

    $updated = wp_update_comment(array(
        'comment_ID' => $comment_id,
        'comment_content' => $comment_content
    ));

    if ($updated) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_edit_recruitment_comment', 'edit_recruitment_comment');

function delete_recruitment_comment() {
    check_ajax_referer('delete_recruitment_comment', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error('ログインが必要です。');
        return;
    }

    $comment_id = intval($_POST['comment_id']);
    $comment = get_comment($comment_id);

    if (!$comment || $comment->user_id != get_current_user_id()) {
        wp_send_json_error('権限がありません。');
        return;
    }

    $deleted = wp_delete_comment($comment_id, true);

    if ($deleted) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_delete_recruitment_comment', 'delete_recruitment_comment');

/**
 * アカウント削除処理
 */
function handle_account_deletion() {
    if (!isset($_POST['delete_account_nonce']) || !wp_verify_nonce($_POST['delete_account_nonce'], 'delete_account_action')) {
        wp_die('不正なリクエストです。');
    }

    if (!is_user_logged_in()) {
        wp_redirect(home_url('/login/'));
        exit;
    }

    $user_id = get_current_user_id();
    
    // ユーザーに関連する投稿やコメントを削除
    $user_posts = get_posts(array('author' => $user_id, 'post_type' => 'any', 'numberposts' => -1));
    foreach ($user_posts as $post) {
        wp_delete_post($post->ID, true);
    }
    
    // ユーザーのコメントを削除
    $user_comments = get_comments(array('user_id' => $user_id));
    foreach ($user_comments as $comment) {
        wp_delete_comment($comment->comment_ID, true);
    }
    
    // カスタムアバター画像を削除
    $custom_avatar_id = get_user_meta($user_id, 'custom_avatar', true);
    if ($custom_avatar_id) {
        wp_delete_attachment($custom_avatar_id, true);
    }
    
    // ユーザーメタデータを削除
    delete_user_meta($user_id, 'role');
    delete_user_meta($user_id, 'description');
    delete_user_meta($user_id, 'twitter_url');
    delete_user_meta($user_id, 'facebook_url');
    delete_user_meta($user_id, 'instagram_url');
    delete_user_meta($user_id, 'youtube_url');
    delete_user_meta($user_id, 'custom_avatar');
    
    // ユーザーを削除
    wp_delete_user($user_id);
    
    // ログアウトしてホームページにリダイレクト
    wp_logout();
    wp_redirect(home_url('/'));
    exit;
}
add_action('admin_post_delete_account', 'handle_account_deletion');

