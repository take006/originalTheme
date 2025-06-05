<?php 
/* Template Name: frontページ*/
get_header(); 
?>
  <main>
    <h1>front-page</h1>
    <section class="search-section">
      <form method="get" action="<?php echo home_url('/'); ?>">
        <input type="text" name="s" placeholder="記事を検索..." class="search-input">
        <button type="submit" class="search-button">検索</button>
      </form>
    </section>
    <section id ="todo">
      <ul>
        <li><input type="checkbox">よく検索されるタグをこの辺にに表示する</li>
        <li><input type="checkbox">ピックアップ記事を１つ表示する</li>
        <li><input type="checkbox">コンタクトフォームの実装</li>
        <li><input type="checkbox">プライバシーポリシーの実装</li>
        <li><input type="checkbox">開発情報の記載（information）</li>
      </ul>
    </section>
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
    <?php 
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    $args = array(
      'post_type' => 'post',
      'posts_per_page' => 6,
      'paged' => $paged,
    );

    $the_query = new WP_Query($args);
    ?>

    <section id="article">
      <h2>新着記事</h2>
      <div class="articles-wrapper">
        <?php 
        if ($the_query->have_posts()) :
          while ($the_query->have_posts()) :
            $the_query->the_post();
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
                    echo '<span class="category-item">' . esc_html($category->name) . '</span>';
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

      <!-- ページネーション -->
      <div class="pagination">
        <?php
        echo paginate_links(array(
          'total' => $the_query->max_num_pages,
          'current' => $paged,
          'mid_size' => 1,
          'prev_text' => '« 前へ',
          'next_text' => '次へ »',
        ));
        ?>
      </div>
    </section>

  </main>
  <?php get_footer(); ?>
