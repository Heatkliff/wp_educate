<?php
/*
    Template Name: Heading Template
Template Post Type: post, page, product
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
            <div class="posts">
                <?php if (have_posts()): while (have_posts()): the_post(); ?>
                
                <div class="one-post">
                    <?php  $thumb_id = get_post_thumbnail_id();
                    $thumb_url = wp_get_attachment_image_src($thumb_id,'high', true);
                    ?>
                    <div class="img-pre-post" style="background-image: url('<?php echo $thumb_url[0]?>'")></div>
                    <div class="content-heading-home">
                        <?php
                        $categories = get_the_category();
                        if ($categories[0]) {
                            echo '<a href="' . get_category_link($categories[0]->term_id) . '">' . $categories[0]->name . '</a>';
                        }
                        ?>
                    </div>
                    <h2><a href="<?php the_permalink(); ?>" title="Read more"><?php the_title(); ?></a></h2>
                    <!--                    --><?php
                    new_excerpt_more(the_excerpt());
                    $posts++ ?>
                </div>

                <?php endwhile; endif; ?>
            </div>

            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php get_footer(); ?>