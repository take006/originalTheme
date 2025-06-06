<?php
/*
Template Name: formページ
*/
session_start(); // セッション開始（確認画面にデータを渡すため）
get_header();

// POST送信時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['contact_form_nonce'])
    && wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form')) {

    // 入力値をサニタイズ
    $name    = sanitize_text_field($_POST['name']);
    $email   = sanitize_email($_POST['email']);
    $phone   = sanitize_text_field($_POST['phone']);
    $title   = sanitize_text_field($_POST['title']);
    $message = sanitize_textarea_field($_POST['message']);
    $privacy = isset($_POST['privacy']) ? true : false;

    // バリデーション処理
    $errors = [];

    if (empty($name)) {
        $errors['name'] = '※お名前を入力してください。';
    }
    if (empty($email) || !is_email($email)) {
        $errors['email'] = '※有効なメールアドレスを入力してください。';
    }
    if (empty($title)) {
        $errors['title'] = '※タイトルを入力してください。';
    }
    if (empty($message)) {
        $errors['message'] = '※内容を入力してください。';
    }
    if (!isset($_POST['privacy'])) {
        $errors['privacy'] = '※プライバシーポリシーに同意してください。';
    }
    
    // バリデーション通過時：セッションに保存して確認画面へリダイレクト
    if (empty($errors)) {
        $_SESSION['form'] = compact('name', 'email', 'phone', 'title', 'message');
        wp_redirect(home_url('/confirm')); // 確認画面へ
        exit;
    }
}
?>

<main>
  <h1>お問い合わせフォーム</h1>


  <!-- お問い合わせフォーム -->
  <form method="post" action="<?php echo esc_url(get_permalink()); ?>">
    <?php wp_nonce_field('contact_form', 'contact_form_nonce'); ?>

    <table>
      <tr>
        <td><label for="name">お名前 <span style="color:red;">*</span></label></td>
        <td>
          <input type="text" name="name" id="name" value="<?php echo esc_attr($_POST['name'] ?? ''); ?>">
          <?php if (!empty($errors['name'])) : ?>
            <p class="error" style="color:red;"><?php echo esc_html($errors['name']); ?></p>
          <?php endif; ?>
        </td>
      </tr>

      <tr>
        <td><label for="email">メールアドレス <span style="color:red;">*</span></label></td>
        <td>
          <input type="text" name="email" id="email" value="<?php echo esc_attr($_POST['email'] ?? ''); ?>">
          <?php if (!empty($errors['email'])) : ?>
            <p class="error" style="color:red;"><?php echo esc_html($errors['email']); ?></p>
          <?php endif; ?>
        </td>
      </tr>

      <tr>
        <td><label for="phone">電話番号（任意）</label></td>
        <td>
          <input type="text" name="phone" id="phone" value="<?php echo esc_attr($_POST['phone'] ?? ''); ?>">
        </td>
      </tr>

      <tr>
        <td><label for="title">タイトル<span style="color:red;">*</span></label></td>
        <td>
          <input type="text" name="title" id="title" value="<?php echo esc_attr($_POST['title'] ?? ''); ?>">
          <?php if (!empty($errors['title'])) : ?>
            <p class="error" style="color:red;"><?php echo esc_html($errors['title']); ?></p>
          <?php endif; ?>
        </td>
      </tr>

      <tr>
        <td><label for="message">内容<span style="color:red;">*</span></label></td>
        <td>
          <textarea name="message" id="message"><?php echo esc_textarea($_POST['message'] ?? ''); ?></textarea>
          <?php if (!empty($errors['message'])) : ?>
            <p class="error" style="color:red;"><?php echo esc_html($errors['message']); ?></p>
          <?php endif; ?>
        </td>
      </tr>
    </table>

    <div class="send-wrapper"> 
      <p>
        <input type="checkbox" name="privacy" id="privacy" <?php checked(isset($_POST['privacy'])); ?>>
        <label for="privacy">
          <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy-policy'))); ?>" target="_blank" rel="noopener noreferrer">
            プライバシーポリシー
          </a>に同意する（任意）
        </label>
      </p>
      <?php if (isset($errors['privacy'])) : ?>
        <p class="error" style="color:red;"><?php echo esc_html($errors['privacy']); ?></p>
      <?php endif; ?>
      <button type="submit">確認画面へ</button>
    </div>
  </form>
</main>

<?php get_footer(); ?>
