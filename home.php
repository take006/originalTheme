<?php 
/* Template Name: homeページ*/
get_header(); 
?>
  <main>
    <h1 style="color:gray;">home.php(blog)</h1>
    <p>タグを選択したら動的に読み込みがかかって一意するタグ、カテゴリーの記事がいちらんで表示されるようにする</p>
    <section class="search-section">
      <form method="get" action="<?php echo home_url('/'); ?>">
        <input type="text" name="s" placeholder="記事を検索..." class="search-input">
        <button type="submit" class="search-button">検索</button>
      </form>
    </section>

    <section id="category">
      <?php
      function custom_category_tree($parent_id = 0) {
          $args = array(
              'parent'     => $parent_id,
              'hide_empty' => false,
              'orderby'    => 'name',
              'order'      => 'ASC',
          );

          $categories = get_categories($args);

          if ($categories) {
              echo '<ul>';
              foreach ($categories as $category) {
                  $category_link = esc_url(get_category_link($category->term_id));
                  $category_name = esc_html($category->name);

                  echo '<li><a href="' . $category_link . '">' . $category_name . '</a>';

                  // 子カテゴリーがあれば再帰的に表示
                  custom_category_tree($category->term_id);

                  echo '</li>';
              }
              echo '</ul>';
          }
      }
      ?>

      <!-- 呼び出し部分 -->
      <div class="category-tree">
          <?php custom_category_tree(); ?>
      </div>

    </section>

    <section id="article"> 
      <h2>WordPress</h2>
      <div class="articles-wrapper">

        <?php
        // カテゴリー「WordPress」の記事を最大6件取得
        $args = array(
          'category_name' => 'wordpress', // カテゴリースラッグ
          'posts_per_page' => 6
        );
        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) :
          while ($the_query->have_posts()) : $the_query->the_post();
        ?>
            <article class="article-item">
              <a href="<?php the_permalink(); ?>">
                <div class="text-wrapper">
                  <h3><?php the_title(); ?></h3>
                  <div>
                    <p class="post-date"><?php the_time(get_option('date_format')); ?></p>
                    <?php
                    $categories = get_the_category();
                    if ( !empty($categories) ) {
                      echo '<span class="category-item">' . esc_html($categories[0]->name) . '</span>';
                    }
                    ?>
                  </div>
                </div>
              </a>
            </article>
        <?php
          endwhile;
        endif;
        wp_reset_postdata();
        ?>
      </div>

      <?php
      // 「もっと見る」ボタン表示条件（6件以上あるかチェック）
      $check_args = array(
        'category_name' => 'wordpress',
        'posts_per_page' => -1
      );
      $check_query = new WP_Query($check_args);
      if ( $check_query->found_posts > 6 ) :
      ?>
        <button class="type-more"><a href="<?php echo esc_url( get_category_link( get_category_by_slug('wordpress')->term_id ) ); ?>" class="more-button">もっと見る</a></button>
      <?php endif; wp_reset_postdata(); ?>
    </section>
  </main>
  <?php get_footer(); ?>
