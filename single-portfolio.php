<?php
// ================================
// single-portfolio.php (Single portfolio item)
// ================================
?>
<?php get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-portfolio'); ?>>
            <div class="container">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="portfolio-hero">
                        <?php the_post_thumbnail('hero-image'); ?>
                    </div>
                <?php endif; ?>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>

                    <?php
                    $terms = get_the_terms(get_the_ID(), 'portfolio_category');
                    if ($terms && !is_wp_error($terms)) {
                        echo '<div class="portfolio-categories">';
                        foreach ($terms as $term) {
                            echo '<span class="category-tag">' . $term->name . '</span>';
                        }
                        echo '</div>';
                    }
                    ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>

                    <?php
                    // Example ACF fields
                    $project_url = get_field('project_url');
                    $client_name = get_field('client_name');
                    $project_date = get_field('project_date');

                    if ($project_url || $client_name || $project_date) :
                    ?>
                        <div class="project-details">
                            <h3>Project Details</h3>

                            <?php if ($client_name) : ?>
                                <div class="detail-item">
                                    <strong>Client:</strong> <?php echo esc_html($client_name); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($project_date) : ?>
                                <div class="detail-item">
                                    <strong>Date:</strong> <?php echo esc_html($project_date); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($project_url) : ?>
                                <div class="detail-item">
                                    <strong>Website:</strong>
                                    <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener">
                                        View Project
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </article>

        <?php
        // Portfolio navigation
        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if ($prev_post || $next_post) :
        ?>
            <nav class="portfolio-navigation">
                <div class="container">
                    <?php if ($prev_post) : ?>
                        <div class="nav-previous">
                            <a href="<?php echo get_permalink($prev_post->ID); ?>">
                                <span class="nav-subtitle">Previous Project</span>
                                <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($next_post) : ?>
                        <div class="nav-next">
                            <a href="<?php echo get_permalink($next_post->ID); ?>">
                                <span class="nav-subtitle">Next Project</span>
                                <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </nav>
        <?php endif; ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>