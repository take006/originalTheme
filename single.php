  <?php get_header(); ?>
  <main>
    <nav class="breadcrumb">
      <a href="<?php echo home_url(); ?>">ホーム</a> &gt;
      <?php
        $category = get_the_category();
        if ($category) {
            $cat_link = get_category_link($category[0]->term_id);
            echo '<a href="' . esc_url($cat_link) . '">' . esc_html($category[0]->name) . '</a> &gt; ';
        }
      ?>
      <span><?php the_title(); ?></span>
    </nav>

    <h1 style="color:gray;">single.php</h1>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article>
        <div class="article-title">
          <!-- タイトル -->
          <h1><?php the_title(); ?></h1>
          <!-- 投稿日 -->
          <div class="article-date">
            <p>投稿日: <?php the_time('Y年n月j日'); ?></p>
            <p>更新日: <?php the_modified_date('Y年n月j日'); ?></p>
          </div>
        </div>
        <div class="article-content">
        <!-- シリーズ表示 -->
        <?php
        $series_terms = get_the_terms(get_the_ID(), 'series');
        if (!empty($series_terms) && !is_wp_error($series_terms)) {
            echo '<div class="post-series">';
            echo 'シリーズ：';
            foreach ($series_terms as $term) {
                echo '<a href="' . get_term_link($term) . '">' . esc_html($term->name) . '</a> ';
            }
            echo '</div>';
        }
        ?>
        <div class="post-category">
        <?php
          $categories = get_the_category();
          if ( $categories ) {
              echo '<div class="post-tags">'; // タグと同じクラスを使用
              echo '<span>カテゴリー：</span>';
              foreach ( $categories as $category ) {
                  echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" 
                            class="tag-button">' . esc_html( $category->name ) . '</a>';
              }
              echo '</div>';
          }
        ?>
        </div>
        <div class="post-tags">
          <span>タグ：</span>
          <?php
            $post_tags = get_the_tags();
            if ($post_tags) {
              foreach($post_tags as $tag) {
                echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-button">' . $tag->name . '</a> ';
              }
            }
          ?>
        </div>

          <!-- アイキャッチ画像 -->
          <?php if (has_post_thumbnail()) : ?>
          <div class="post-thumbnail">
            <?php the_post_thumbnail('large'); ?>
          </div>
          <?php endif; ?>
          <!-- 本文 -->
           
          <section id="article-index">
            <h3>目次</h3>
          </section>

          <div class="entry-content">
            <?php the_content(); ?>
          </div>
        </div>
      </article>
    <?php endwhile; endif; ?>

    <section id="quiz">
      <?php
        $related_quiz_id = get_post_meta(get_the_ID(), 'related_quiz_id', true);

        if ($related_quiz_id) {
            $question = get_post_meta($related_quiz_id, 'quiz_question', true);
            $choices = explode(',', get_post_meta($related_quiz_id, 'quiz_choices', true));
            $answer_index_raw = get_post_meta($related_quiz_id, 'quiz_answer', true);
            $answer_index = trim($answer_index_raw); // ← 余計なスペースを除去
            $explanation = get_post_meta($related_quiz_id, 'quiz_explanation', true);
            ?>

            <div class="quiz-box">
                <h3>問題に挑戦っ！</h3>
                <p><strong>問題：</strong> <?php echo esc_html($question); ?></p>
                <form id="quiz-form" class="quiz-form" data-answer="<?php echo esc_attr($answer_index); ?>" data-explanation="<?php echo esc_attr($explanation); ?>">
                    <?php foreach ($choices as $index => $choice): ?>
                        <label>
                            <input type="radio" name="quiz-choice" value="<?php echo $index; ?>">
                            <?php echo esc_html(trim($choice)); ?>
                        </label><br>
                    <?php endforeach; ?>
                    <button type="button" id="quiz-submit">回答する</button>
                    <button type="button" id="quiz-reset">やり直す</button>
                </form>

                <div id="quiz-result" class="mt-4 text-lg font-semibold"></div>
            </div>

      <?php } ?>
    </section>

    <!-- 関連記事のセクション -->
    <section id="related-article">
      <?php
        // --- 関連記事（同じカテゴリーの記事を表示） ---
        $categories = get_the_category( get_the_ID() );

        if ( $categories ) {
            $category_ids = array();
            foreach ( $categories as $category ) {
                $category_ids[] = $category->term_id;
            }

            $related_args = array(
                'category__in'   => $category_ids,
                'post__not_in'   => array( get_the_ID() ),
                'posts_per_page' => 4,
                'ignore_sticky_posts' => 1,
            );

            $related_query = new WP_Query( $related_args );

            if ( $related_query->have_posts() ) : ?>
                <div class="related-posts">
                    <h3 class="section-title">関連記事</h3>
                    <ul class="post-list">
                        <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                            <li class="post-item">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="thumb"><?php the_post_thumbnail('thumbnail'); ?></div>
                                    <?php else: ?>
                                        <div class="thumb no-image">No Image</div>
                                    <?php endif; ?>
                                    <div class="text"><?php the_title(); ?></div>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif;

            wp_reset_postdata();
          }

          // --- おすすめ記事（タグ pickup の記事を表示） ---
          $pickup_args = array(
              'tag' => 'pickup',
              'posts_per_page' => 4,
          );

          $pickup_query = new WP_Query( $pickup_args );

          if ( $pickup_query->have_posts() ) : ?>
              <div class="pickup-posts">
                  <h3 class="section-title">おすすめ記事</h3>
                  <ul class="post-list">
                      <?php while ( $pickup_query->have_posts() ) : $pickup_query->the_post(); ?>
                          <li class="post-item">
                              <a href="<?php the_permalink(); ?>">
                                  <?php if ( has_post_thumbnail() ) : ?>
                                      <div class="thumb"><?php the_post_thumbnail('thumbnail'); ?></div>
                                  <?php else: ?>
                                      <div class="thumb no-image">No Image</div>
                                  <?php endif; ?>
                                  <div class="text"><?php the_title(); ?></div>
                              </a>
                          </li>
                      <?php endwhile; ?>
                  </ul>
              </div>
          <?php endif;

          wp_reset_postdata();
      ?>
    </section>
  </main>
  <?php get_footer(); ?>
