<?php
// ================================
// single.php (Single post template)
// ================================
?>
<?php get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            <div class="container">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-hero">
                        <?php the_post_thumbnail('hero-image'); ?>
                    </div>
                <?php endif; ?>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>

                    <div class="entry-meta">
                        <span class="posted-on">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </span>
                        <span class="byline">by <?php the_author(); ?></span>

                        <?php if (has_category()) : ?>
                            <span class="categories">
                                in <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
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

                <?php if (has_tag()) : ?>
                    <footer class="entry-footer">
                        <div class="tags">
                            <?php the_tags('Tags: ', ', '); ?>
                        </div>
                    </footer>
                <?php endif; ?>
            </div>
        </article>

        <?php
        // Post navigation
        the_post_navigation(array(
            'prev_text' => '<span class="nav-subtitle">Previous:</span> %title',
            'next_text' => '<span class="nav-subtitle">Next:</span> %title',
        ));

        // Comments
        if (comments_open() || get_comments_number()) {
            echo '<div class="container">';
            comments_template();
            echo '</div>';
        }
        ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>