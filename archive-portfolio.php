<?php
// ================================
// archive-portfolio.php (Custom post type archive)
// ================================
?>
<?php get_header(); ?>

<main id="main" class="site-main" role="main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Portfolio</h1>
            <div class="page-description">
                <p>Check out our latest work and projects.</p>
            </div>
        </header>

        <?php if (have_posts()) : ?>
            <div class="portfolio-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-item'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="portfolio-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('portfolio-thumb'); ?>
                                    <div class="portfolio-overlay">
                                        <h3 class="portfolio-title"><?php the_title(); ?></h3>
                                        <?php
                                        $terms = get_the_terms(get_the_ID(), 'portfolio_category');
                                        if ($terms && !is_wp_error($terms)) {
                                            echo '<div class="portfolio-category">';
                                            foreach ($terms as $term) {
                                                echo '<span>' . $term->name . '</span>';
                                            }
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php starter_theme_pagination(); ?>

        <?php else : ?>
            <div class="no-posts">
                <h2>No Portfolio Items Found</h2>
                <p>Sorry, no portfolio items were found.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>