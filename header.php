<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index.php</title>
  <?php wp_head(); ?>
</head>
<body>
  <header class="header">
    <span class="header-title"><a href="<?php echo home_url(); ?>">TechNote</a></span>
    <ul>
      <li><a href="<?php echo home_url(); ?>">Top</a></li>
      <li><a href="<?php echo home_url('/blog'); ?>">カテゴリー</a></li>
      <li><a href="<?php echo home_url('/form'); ?>">contact form</a></li>
    </ul>
  </header>