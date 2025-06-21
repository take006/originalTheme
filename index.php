  <?php get_header(); ?>
  <main>
    <h1 style="color:gray;">index.php</h1>
    <section class="search-section">
      <form method="get" action="<?php echo home_url('/'); ?>">
        <input type="text" name="s" placeholder="記事を検索..." class="search-input">
        <button type="submit" class="search-button">検索</button>
      </form>
    </section>
  </main>
  <?php get_footer(); ?>
