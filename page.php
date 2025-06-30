<?php
// ================================
// page.php (Static page template)
// ================================
?>
<?php get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-page'); ?>>
            <div class="container">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="page-hero">
                        <?php the_post_thumbnail('hero-image'); ?>
                    </div>
                <?php endif; ?>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">Pages:',
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>