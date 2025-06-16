<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>archive.php</title>
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/reset.css">
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/color.css">
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/header.css">
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/footer.css">
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/archive.css">
  <link rel="stylesheet" href="../../wp-content/themes/originalTheme/assets/css/pagenation.css">
</head>
<body>
  <?php get_header(); ?>

  <main class="archive-container">
    <section class="search-section">
      <form method="get" action="<?php echo home_url('/'); ?>">
        <input type="text" name="s" placeholder="記事を検索..." class="search-input">
        <button type="submit" class="search-button">検索</button>
      </form>
    </section>

    <section class="archive-section">
      <h1 class="archive-title">
        <?php if (is_category()) : ?>
          「<?php single_cat_title(); ?>」カテゴリーの記事一覧
        <?php elseif (is_tag()) : ?>
          「<?php single_tag_title(); ?>」タグの記事一覧
        <?php elseif (is_tax('series')) : ?>
          「<?php single_term_title(); ?>」シリーズの記事一覧
        <?php else : ?>
          記事一覧
        <?php endif; ?>
      </h1>

      <?php if (have_posts()) : ?>
        <div class="post-list">
          <?php while (have_posts()) : the_post(); ?>
            <article class="post-item">
              <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) : ?>
                  <div class="post-thumbnail">
                    <?php the_post_thumbnail('medium'); ?>
                  </div>
                <?php endif; ?>
                <h2 class="post-title"><?php the_title(); ?></h2>
                <p class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
              </a>
            </article>
          <?php endwhile; ?>
        </div>
      <?php else : ?>
        <p>記事が見つかりませんでした。</p>
      <?php endif; ?>
    </section>

    <!-- ページネーション -->
    <?php get_template_part('template-parts/pagination'); ?>
  </main>

  <?php get_footer(); ?>
</body>
</html>
