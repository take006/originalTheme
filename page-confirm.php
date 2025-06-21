<?php 
/*
Template Name: confirmページ
*/
session_start();
get_header();

if(empty($_SESSION['form'])) {
    wp_redirect(home_url('/form'));
    exit;
}

$form = $_SESSION['form'];

if($_SERVER['REQUEST_METHOD'] === 'POST'
&& isset($_POST['confirm_form_nonce'])
&& wp_verify_nonce($_POST['confirm_form_nonce'], 'contact_confirm')) {

  $to = get_option('admin_email');
  $subject = 'お問い合わせ' . $form['title'];
  $body = <<<EOT
  以下の内容でお問い合わせを受け付けました。
  お名前: {$form['name']}
  メール: {$form['email']}
  電話番号: {$form['phone']}
  タイトル： {$form['title']}
  内容: {$form['message']}
  EOT;
  $headers = ['Content-Type: text/plain; charset=UTF-8'];
  wp_mail($to, $subject, $body, $headers);
  unset($_SESSION['form']);
  wp_redirect(home_url('/thanks'));
  exit;
}
?>

<main>
  <h1 style="color:gray;">confirm.php</h1>
  <section id="contact-confirm">
    <h2>確認画面</h2>
    <form method="post" action="">
      <?php wp_nonce_field('contact_confirm', 'confirm_form_nonce'); ?>
      <table>
        <tr>
          <td><label for="name">お名前</label></td>
          <td><?php echo esc_html($form['name']); ?></td>
        </tr>
        <tr>
          <td><label for="email">メールアドレス</label></td>
          <td><?php echo esc_html($form['email']); ?></td>
        </tr>
        <tr>
          <td><label for="phone">電話番号</label></td>
          <td><?php echo esc_html($form['phone']); ?></td>
        </tr>
        <tr>
          <td><label for="title">タイトル</label></td>
          <td><?php echo esc_html($form['title']); ?></td>
        </tr>
        <tr>
          <td><label for="message">内容</label></td>
          <td><?php echo nl2br(esc_html($form['message'])); ?></td>
        </tr>
      </table>

      <p>上記の内容で送信しますか？</p>
      <button type="submit">送信する</button>
      <a href="<?php echo home_url('/form'); ?>">戻る</a>
    </form>
  </section>
</main>

<?php get_footer(); ?>