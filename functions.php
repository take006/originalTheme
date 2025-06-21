<?php 

function enqueue_custom_stylesheets() {
    // 基本的なCSSファイル（どのページでも読み込む）
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('reset', get_template_directory_uri() . '/assets/css/reset.css');
    wp_enqueue_style('color', get_template_directory_uri() . '/assets/css/color.css');
    wp_enqueue_style('base', get_template_directory_uri() . '/assets/css/base.css');
    wp_enqueue_style('header', get_template_directory_uri() . '/assets/css/header.css');
    wp_enqueue_style('footer', get_template_directory_uri() . '/assets/css/footer.css');

    // index.phpにのみ読み込むCSSファイル（例: 1〜7）
    if (is_front_page()) {
        wp_enqueue_style('front', get_template_directory_uri() . '/assets/css/front.css');
        wp_enqueue_style('search', get_template_directory_uri() . '/assets/css/search.css');
        wp_enqueue_style('pagenation', get_template_directory_uri() . '/assets/css/pagenation.css');
        wp_enqueue_style('tag', get_template_directory_uri() . '/assets/css/tag.css');
        wp_enqueue_style('category', get_template_directory_uri() . '/assets/css/category.css');
        wp_enqueue_style('archive', get_template_directory_uri() . '/assets/css/archive.css');
    }
    if (is_archive()) {
        wp_enqueue_style('front', get_template_directory_uri() . '/assets/css/front.css');
        wp_enqueue_style('pagenation', get_template_directory_uri() . '/assets/css/pagenation.css');
        wp_enqueue_style('archive', get_template_directory_uri() . '/assets/css/archive.css');
    }

    elseif (is_home()) {
        wp_enqueue_style('blog', get_template_directory_uri() . '/assets/css/blog.css');
        wp_enqueue_style('search', get_template_directory_uri() . '/assets/css/search.css');
        wp_enqueue_style('pagenation', get_template_directory_uri() . '/assets/css/pagenation.css');
        wp_enqueue_style('tag', get_template_directory_uri() . '/assets/css/tag.css');
    }
    // single.phpにのみ読み込むCSSファイル（例: 1, 2, 7〜10）
    elseif (is_single()) {
        wp_enqueue_style('single', get_template_directory_uri() . '/assets/css/single.css');
        wp_enqueue_style('related', get_template_directory_uri() . '/assets/css/related.css');
        wp_enqueue_style('quiz', get_template_directory_uri() . '/assets/css/quiz.css');
    }

    elseif (
        is_page_template('page-form.php') ||
        is_page_template('page-confirm.php') ||
        is_page_template('page-thanks.php')
    ) {
        wp_enqueue_style('contact', get_template_directory_uri() . '/assets/css/contact.css');
    }
    elseif (
        is_page_template('page-agreement.php') ||
        is_page_template('page-company.php') ||
        is_page_template('page-developer.php') ||
        is_page_template('page-privacy-policy.php') ||
        is_page_template('page-service.php')
    ) {
        wp_enqueue_style('page', get_template_directory_uri() . '/assets/css/page.css');
    }
    elseif (
        is_page_template('page-privacy-policy.php') 
    ) {
        wp_enqueue_style('privacy', get_template_directory_uri() . '/assets/css/privacy.css');
    }
    elseif (is_tax('series')) {
    wp_enqueue_style('series', get_template_directory_uri() . '/assets/css/series.css');
}

}
add_action('wp_enqueue_scripts', 'enqueue_custom_stylesheets');


?>

<?php 

// サムネイル画像サポート
function setup_theme() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'setup_theme');

// クイズ投稿タイプ登録
function register_quiz_post_type() {
    register_post_type('quiz', [
        'labels' => [
            'name' => 'クイズ',
            'singular_name' => 'クイズ',
            'add_new' => '新規追加',
            'add_new_item' => '新しいクイズを追加',
            'edit_item' => 'クイズを編集',
            'new_item' => '新しいクイズ',
            'view_item' => 'クイズを表示',
            'search_items' => 'クイズを検索',
            'not_found' => 'クイズが見つかりません',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => ['title'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'register_quiz_post_type');

// メタボックス追加
function add_quiz_meta_boxes() {
    add_meta_box(
        'quiz_meta_box',
        'クイズ詳細',
        'display_quiz_meta_box',
        'quiz',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_quiz_meta_boxes');

// メタボックス表示
function display_quiz_meta_box($post) {
    wp_nonce_field('save_quiz_meta_box', 'quiz_meta_box_nonce');

    $question   = get_post_meta($post->ID, 'quiz_question', true);
    $choices    = explode(',', get_post_meta($post->ID, 'quiz_choices', true));
    $choices    = array_map('trim', $choices);
    $answer     = get_post_meta($post->ID, 'quiz_answer', true);
    $explanation= get_post_meta($post->ID, 'quiz_explanation', true);
    ?>
    <p><label>問題文：</label><br>
    <input type="text" name="quiz_question" value="<?php echo esc_attr($question); ?>" style="width:100%;"></p>

    <p><label>選択肢（カンマ区切り）：</label><br>
    <input type="text" name="quiz_choices" value="<?php echo esc_attr(implode(', ', $choices)); ?>" style="width:100%;"></p>

    <p><label>正解：</label><br>
    <select name="quiz_answer" style="width:100%;">
        <?php foreach ($choices as $index => $label): ?>
            <option value="<?php echo esc_attr($index); ?>" <?php selected($answer, $index); ?>>
                <?php echo esc_html($label); ?>
            </option>
        <?php endforeach; ?>
    </select>
    </p>

    <p><label>解説：</label><br>
    <textarea name="quiz_explanation" rows="5" style="width:100%;"><?php echo esc_textarea($explanation); ?></textarea></p>
    <?php
}

// メタボックス保存
function save_quiz_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['quiz_meta_box_nonce']) || !wp_verify_nonce($_POST['quiz_meta_box_nonce'], 'save_quiz_meta_box')) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['quiz_question'])) {
        update_post_meta($post_id, 'quiz_question', sanitize_text_field($_POST['quiz_question']));
    }
    if (isset($_POST['quiz_choices'])) {
        update_post_meta($post_id, 'quiz_choices', sanitize_text_field($_POST['quiz_choices']));
    }
    if (isset($_POST['quiz_answer'])) {
        update_post_meta($post_id, 'quiz_answer', sanitize_text_field($_POST['quiz_answer']));
    }
    if (isset($_POST['quiz_explanation'])) {
        update_post_meta($post_id, 'quiz_explanation', sanitize_textarea_field($_POST['quiz_explanation']));
    }
}
add_action('save_post', 'save_quiz_meta_box');

// 投稿画面に関連クイズを追加
function add_quiz_relation_meta_box() {
    add_meta_box(
        'related_quiz_box',
        '関連クイズを選択',
        'display_related_quiz_box',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_quiz_relation_meta_box');

function display_related_quiz_box($post) {
    wp_nonce_field('save_related_quiz', 'related_quiz_nonce');
    $selected_quiz_id = get_post_meta($post->ID, 'related_quiz_id', true);

    $quizzes = get_posts([
        'post_type' => 'quiz',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ]);

    echo '<select name="related_quiz_id" style="width:100%">';
    echo '<option value="">-- 選択してください --</option>';
    foreach ($quizzes as $quiz) {
        $sel = ($quiz->ID == $selected_quiz_id) ? ' selected' : '';
        echo '<option value="' . esc_attr($quiz->ID) . '"' . $sel . '>' . esc_html($quiz->post_title) . '</option>';
    }
    echo '</select>';
}

function save_related_quiz_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['related_quiz_nonce']) || !wp_verify_nonce($_POST['related_quiz_nonce'], 'save_related_quiz')) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['related_quiz_id'])) {
        update_post_meta($post_id, 'related_quiz_id', intval($_POST['related_quiz_id']));
    }
}
add_action('save_post', 'save_related_quiz_meta');

// スクリプト読み込み
function mytheme_enqueue_scripts() {
    wp_enqueue_script('quiz-script', get_template_directory_uri() . '/assets/js/quiz.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');



// 「連載シリーズ」タクソノミーを追加
function register_series_taxonomy() {
    register_taxonomy(
        'series', // タクソノミーのスラッグ
        'post',   // 投稿タイプ（'post' を対象に）
        array(
            'label' => '連載シリーズ',
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'rewrite' => array('slug' => 'series')
        )
    );
}
add_action('init', 'register_series_taxonomy');

// 親カテゴリーのみを表示するためのクエリ修正
// カテゴリーページで親カテゴリーのみを表示する
function strict_category_only( $query ) {
    if ( is_admin() || ! $query->is_main_query() || ! is_category() ) {
        return;
    }

    $term = get_queried_object();
    if ( ! ( $term && isset( $term->term_id ) ) ) {
        return;
    }

    // デフォルトの cat クエリをクリア
    $query->set( 'cat', '' );
    $query->set( 'category_name', '' );

    // このカテゴリだけを指定（子は含めない）
    $query->set( 'tax_query', array(
        array(
            'taxonomy'         => 'category',
            'field'            => 'term_id',
            'terms'            => array( $term->term_id ),
            'include_children' => false,
        ),
    ) );
}
add_action( 'pre_get_posts', 'strict_category_only' );
?>
