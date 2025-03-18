<?php
if (!defined('ABSPATH')) exit;

// テーマサポート機能の追加
function aimapping_setup() {
    // タイトルタグのサポート
    add_theme_support('title-tag');
    
    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');
    
    // カスタムロゴのサポート
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // メニューの登録
    register_nav_menus(array(
        'primary' => 'メインメニュー',
        'footer'  => 'フッターメニュー',
    ));
}
add_action('after_setup_theme', 'aimapping_setup');

// スタイルシートとスクリプトの読み込み
function aimapping_scripts() {
    // メインのスタイルシート
    wp_enqueue_style('aimapping-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    
    // カスタムスクリプト
    wp_enqueue_script('aimapping-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'aimapping_scripts');

// カスタム投稿タイプの登録
function aimapping_register_post_types() {
    // イベント投稿タイプ
    register_post_type('event', array(
        'labels' => array(
            'name' => 'イベント',
            'singular_name' => 'イベント',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-calendar-alt',
        'rewrite' => array('slug' => 'events'),
    ));
}
add_action('init', 'aimapping_register_post_types');

// カスタムタクソノミーの登録
function aimapping_register_taxonomies() {
    // イベントカテゴリー
    register_taxonomy('event_category', 'event', array(
        'labels' => array(
            'name' => 'イベントカテゴリー',
            'singular_name' => 'イベントカテゴリー',
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'event-category'),
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

// カスタムテンプレートの登録
function aimapping_add_page_templates($templates) {
    $templates['page-templates/login-template.php'] = 'ログインページ';
    $templates['page-templates/register-template.php'] = '会員登録ページ';
    $templates['page-templates/new-post-template.php'] = '新規投稿ページ';
    $templates['page-templates/edit-post-template.php'] = '投稿編集ページ';
    $templates['page-templates/edit-profile.php'] = 'プロフィール編集ページ';
    return $templates;
}
add_filter('theme_page_templates', 'aimapping_add_page_templates');

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
    
    if ($is_online) {
        return 'オンライン開催';
    }
    return $location ? esc_html($location) : '場所未定';
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

// いいねボタンのAJAX処理
function handle_like_button() {
    if (!isset($_POST['post_id'])) {
        wp_send_json_error('投稿IDが指定されていません。');
    }

    $post_id = intval($_POST['post_id']);
    $likes = get_post_meta($post_id, 'post_likes', true);
    $likes = $likes ? $likes + 1 : 1;
    update_post_meta($post_id, 'post_likes', $likes);

    wp_send_json_success(array(
        'likes' => number_format($likes)
    ));
}
add_action('wp_ajax_handle_like', 'handle_like_button');
add_action('wp_ajax_nopriv_handle_like', 'handle_like_button');

// カスタムフィールドの追加
function add_event_meta_boxes() {
    add_meta_box(
        'event_details',
        'イベント詳細',
        'render_event_meta_box',
        'event',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_event_meta_boxes');

// イベント詳細メタボックスのレンダリング
function render_event_meta_box($post) {
    wp_nonce_field('event_meta_box', 'event_meta_box_nonce');

    $event_date = get_post_meta($post->ID, 'event_date', true);
    $event_location = get_post_meta($post->ID, 'event_location', true);
    $event_is_online = get_post_meta($post->ID, 'event_is_online', true);
    ?>
    <p>
        <label for="event_date">開催日時：</label>
        <input type="datetime-local" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>">
    </p>
    <p>
        <label for="event_is_online">開催形式：</label>
        <select id="event_is_online" name="event_is_online">
            <option value="0" <?php selected($event_is_online, '0'); ?>>オフライン</option>
            <option value="1" <?php selected($event_is_online, '1'); ?>>オンライン</option>
        </select>
    </p>
    <p>
        <label for="event_location">開催場所：</label>
        <input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>">
    </p>
    <?php
}

// メタボックスの保存
function save_event_meta_box($post_id) {
    if (!isset($_POST['event_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['event_meta_box_nonce'], 'event_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('event_date', 'event_location', 'event_is_online');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_event', 'save_event_meta_box');

// カスタムユーザー登録処理
function aimapping_custom_registration() {
    if (isset($_POST['user_email']) && isset($_POST['user_login']) && isset($_POST['user_pass'])) {
        $user_email = sanitize_email($_POST['user_email']);
        $user_login = sanitize_user($_POST['user_login']);
        $user_pass = $_POST['user_pass'];
        $user_pass_confirm = $_POST['user_pass_confirm'];

        // バリデーション
        $errors = array();

        if (!is_email($user_email)) {
            $errors[] = '有効なメールアドレスを入力してください。';
        }

        if (username_exists($user_login)) {
            $errors[] = 'このユーザー名は既に使用されています。';
        }

        if (email_exists($user_email)) {
            $errors[] = 'このメールアドレスは既に登録されています。';
        }

        if ($user_pass !== $user_pass_confirm) {
            $errors[] = 'パスワードが一致しません。';
        }

        if (strlen($user_pass) < 8) {
            $errors[] = 'パスワードは8文字以上で入力してください。';
        }

        if (empty($errors)) {
            $user_id = wp_create_user($user_login, $user_pass, $user_email);

            if (!is_wp_error($user_id)) {
                // ユーザーロールの設定
                $user = new WP_User($user_id);
                $user->set_role('subscriber');

                // ログイン処理
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);

                // リダイレクト
                wp_redirect(home_url('/user'));
                exit;
            } else {
                wp_redirect(add_query_arg('register', 'failed', home_url('/register')));
                exit;
            }
        } else {
            // エラーメッセージをセッションに保存
            if (!session_id()) {
                session_start();
            }
            $_SESSION['register_errors'] = $errors;
            wp_redirect(add_query_arg('register', 'failed', home_url('/register')));
            exit;
        }
    }
}
add_action('init', 'aimapping_custom_registration');

// 登録エラーメッセージの表示
function aimapping_show_register_errors() {
    if (!session_id()) {
        session_start();
    }

    if (isset($_SESSION['register_errors'])) {
        echo '<div class="auth-error">';
        foreach ($_SESSION['register_errors'] as $error) {
            echo '<p>' . esc_html($error) . '</p>';
        }
        echo '</div>';
        unset($_SESSION['register_errors']);
    }
}
add_action('aimapping_before_register_form', 'aimapping_show_register_errors');

// 募集投稿タイプの登録
function register_recruitment_post_type() {
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
    ));

    // 募集カテゴリーの登録
    register_taxonomy('recruitment_category', 'recruitment', array(
        'labels' => array(
            'name' => '募集カテゴリー',
            'singular_name' => '募集カテゴリー',
            'search_items' => 'カテゴリーを検索',
            'all_items' => 'すべてのカテゴリー',
            'edit_item' => 'カテゴリーを編集',
            'update_item' => 'カテゴリーを更新',
            'add_new_item' => '新規カテゴリーを追加',
            'new_item_name' => '新規カテゴリー名',
            'menu_name' => 'カテゴリー'
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'recruitment-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'register_recruitment_post_type');

// 募集投稿用のカスタムフィールドを追加
function add_recruitment_meta_boxes() {
    add_meta_box(
        'recruitment_details',
        '募集詳細',
        'render_recruitment_meta_box',
        'recruitment',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_recruitment_meta_boxes');

// 募集詳細メタボックスのレンダリング
function render_recruitment_meta_box($post) {
    wp_nonce_field('recruitment_meta_box', 'recruitment_meta_box_nonce');

    $deadline = get_post_meta($post->ID, 'recruitment_deadline', true);
    $event_date = get_post_meta($post->ID, 'recruitment_event_date', true);
    $location_type = get_post_meta($post->ID, 'recruitment_location_type', true);
    $location = get_post_meta($post->ID, 'recruitment_location', true);
    ?>
    <p>
        <label for="recruitment_deadline">募集期限：</label>
        <input type="date" id="recruitment_deadline" name="recruitment_deadline" value="<?php echo esc_attr($deadline); ?>">
    </p>
    <p>
        <label for="recruitment_event_date">開催日時：</label>
        <input type="datetime-local" id="recruitment_event_date" name="recruitment_event_date" value="<?php echo esc_attr($event_date); ?>">
    </p>
    <p>
        <label for="recruitment_location_type">開催形式：</label>
        <select id="recruitment_location_type" name="recruitment_location_type">
            <option value="online" <?php selected($location_type, 'online'); ?>>オンライン</option>
            <option value="offline" <?php selected($location_type, 'offline'); ?>>オフライン</option>
            <option value="hybrid" <?php selected($location_type, 'hybrid'); ?>>ハイブリッド</option>
        </select>
    </p>
    <p>
        <label for="recruitment_location">開催場所：</label>
        <input type="text" id="recruitment_location" name="recruitment_location" value="<?php echo esc_attr($location); ?>" placeholder="オンラインの場合はURLを入力">
    </p>
    <?php
}

// メタボックスの保存
function save_recruitment_meta_box($post_id) {
    if (!isset($_POST['recruitment_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['recruitment_meta_box_nonce'], 'recruitment_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'recruitment_deadline',
        'recruitment_event_date',
        'recruitment_location_type',
        'recruitment_location'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_recruitment', 'save_recruitment_meta_box'); 