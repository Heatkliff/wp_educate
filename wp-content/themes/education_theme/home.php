<?php
/*
    Template Name: Home
*/
?>
<?php get_header(); ?>

    <div class="banner">
        <?php
        $src = wp_get_attachment_image_src(get_option('educate_options')['banner'],"large");?>
        <img src="<?=$src[0] ?>" alt="">

    </div>
    <div class="container">
        <div class="content">
<!--            <div class="content-home-post">-->
<!--                --><?php //if (have_posts()): while (have_posts()): the_post(); ?>
<!--                    --><?php //var_dump(the_content()) ?>
<!--                    --><?php //the_content(); ?>
<!--                --><?php //endwhile; endif; ?>
<!--            </div>-->
            <div class="posts">
                <?php
                $posts = 0;
                $temp = $wp_query;
                $wp_query = null;
                $wp_query = new WP_Query();
                $wp_query->query('showposts=6' . '&paged=' . $paged);
                while ($wp_query->have_posts()) :
                $wp_query->the_post(); ?>
                <?php if ($posts == 4) {
                ?></div>
        </div><?php
        get_form_home();
        ?>
        <div class="content">
            <div class="posts"><?php

                } ?>
                <div class="one-post">
                    <?php the_post_thumbnail('medium'); ?>
                    <div class="content-heading-home">
                        <?php

                        $categories = get_the_category();
                        if ($categories[0]) {
                            echo '<a href="' . get_category_link($categories[0]->term_id) . '">' . $categories[0]->name . '</a>';
                        }
                        ?>
                    </div>
                    <h2><a href="<?php the_permalink(); ?>" title="Read more"><?php the_title(); ?></a></h2>
                    <?php
                    new_excerpt_more(the_excerpt());
                    $posts++ ?>
                </div>

                <?php endwhile;
                global $wp_query;
                ?>
            </div>
            <?php if (  $wp_query->max_num_pages > 1 ) : ?>
                <script>
                    var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                    var true_posts = '<?php echo serialize($wp_query->query_vars); ?>';
                    var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
                    var max_pages = '<?php echo $wp_query->max_num_pages; ?>';
                </script>
                <div id="true_loadmore">Load more</div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php get_footer(); ?>