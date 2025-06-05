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
  </main>
  <?php get_footer(); ?>
