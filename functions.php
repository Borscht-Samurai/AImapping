<?php
if (!defined('ABSPATH')) exit;

// テーマサポート機能の追加
function aimapping_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
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
    wp_enqueue_script('aimapping-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
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
    ));

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

// カスタムフィールド（イベント）メタボックス
function add_event_meta_boxes() {
    add_meta_box('event_details', 'イベント詳細', 'render_event_meta_box', 'event', 'normal', 'high');
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
add_action('save_post_event', 'save_event_meta_box');

// ユーザー登録処理など（ここはそのまま）

