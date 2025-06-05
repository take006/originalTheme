<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>page.php</title>
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/reset.css">
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/color.css">
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/header.css">
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/footer.css">
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/archive.css">
</head>
<body>
  <?php get_header(); ?>

  <main>
    <h1>page.php</h1>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article>
        <!-- アイキャッチ画像 -->
        <?php if (has_post_thumbnail()) : ?>
          <div class="post-thumbnail">
            <?php the_post_thumbnail('large'); ?>
          </div>
        <?php endif; ?>
        <!-- タイトル -->
        <h1><?php the_title(); ?></h1>
        <div class="post-information">
          <!-- 投稿日 -->
          <p>投稿日: <?php the_time('Y年n月j日'); ?></p>
          <!-- カテゴリー -->
          <p>カテゴリー: <?php the_category(', '); ?></p>

          <!-- タグ -->
          <p>タグ: <?php the_tags('', ', '); ?></p>
        </div>
        <hr>

        <!-- 本文 -->
        <div class="entry-content">
          <?php the_content(); ?>
        </div>

      </article>
    <?php endwhile; endif; ?>
  </main>

  <?php get_footer(); ?>
</body>
</html>
