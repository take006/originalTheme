<?php 
/* Template Name: homeページ*/
get_header(); 
?>
  <main>
    <h1>home.php(blog)</h1>
    <p>タグを選択したら動的に読み込みがかかって一意するタグ、カテゴリーの記事がいちらんで表示されるようにする</p>
    <section class="search-section">
      <form method="get" action="<?php echo home_url('/'); ?>">
        <input type="text" name="s" placeholder="記事を検索..." class="search-input">
        <button type="submit" class="search-button">検索</button>
      </form>
    </section>
    <!-- <section id ="todo">
      <ul>
        <li>✓よく検索されるタグをこの辺にに表示する</li>
        <li>ピックアップ記事を１つ表示する</li>
        <li>コンタクトフォームの実装</li>
        <li>プライバシーポリシーの実装</li>
        <li>開発情報の記載（information）</li>
      </ul>
    </section> -->
    <section id="tag">
      <div class="category-scroll-wrapper">
        <div class="category-scroll">
          <?php
            $categories = get_categories();
            foreach ( $categories as $category ) {
              $cat_link = get_category_link( $category->term_id );
              echo '<a href="' . esc_url( $cat_link ) . '" class="category-item">' . esc_html( $category->name ) . '</a>';
            }
          ?>
        </div>
      </div>
      <div class="tag-scroll-wrapper">
        <div class="tag-scroll">
          <?php
            $tags = get_tags();
            foreach ( $tags as $tag ) {
              $tag_link = get_tag_link( $tag->term_id );
              echo '<a href="' . esc_url( $tag_link ) . '" class="tag-item">' . esc_html( $tag->name ) . '</a>';
            }
          ?>
        </div>
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
                <?php if ( has_post_thumbnail() ) : ?>
                  <div class="thumb"><?php the_post_thumbnail('thumbnail'); ?></div>
                <?php else: ?>
                  <div class="thumb no-image">No Image</div>
                <?php endif; ?>

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
        <div class="more-button-wrapper">
          <a href="<?php echo esc_url( get_category_link( get_category_by_slug('wordpress')->term_id ) ); ?>" class="more-button">もっと見る</a>
        </div>
      <?php endif; wp_reset_postdata(); ?>
    </section>
  </main>
  <?php get_footer(); ?>
