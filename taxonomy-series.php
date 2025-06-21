<?php get_header(); ?>

<main>
  <section id="series">
    <h1 style="color:gray;"><?php single_term_title(); ?>のシリーズ記事一覧</h1>
    <?php if (have_posts()) : ?>
        <ul>
            <?php while (have_posts()) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
            <?php endwhile; ?>
        </ul>

        <?php the_posts_pagination(); ?>

    <?php else : ?>
        <p>シリーズに該当する記事が見つかりませんでした。</p>
    <?php endif; ?>
  </section>
</main>

<?php get_footer(); ?>
