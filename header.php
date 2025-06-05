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
    <a href="<?php echo home_url(); ?>">Top</a>
    <a href="<?php echo home_url('/blog'); ?>">Blog</a>
    <a href="<?php echo home_url('/form'); ?>">contact form</a>
  </header>
