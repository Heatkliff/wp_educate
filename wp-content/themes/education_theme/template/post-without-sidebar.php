<?php
$id_post_comment = '' ?>
<div class="banner">
    <?php if (get_the_post_thumbnail(null, "large", '')){
        the_post_thumbnail('large');
    }else{

    }
        ?>
</div>
    <div class="notation">
        <div class="category">
            <?php

            $categories = get_the_category();
            if ($categories[0]) {
                echo '<a href="' . get_category_link($categories[0]->term_id) . '">' . $categories[0]->name . '</a>';
            }
            ?>
        </div>
        <h1><?php the_title(); ?></h1>
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <?php
            $id_post_comment = get_the_ID();
            the_content(); ?>

        <?php endwhile; endif; ?>
        <div class="sharing-post">
            <div class="label-share">Share</div>
            <div class="facebook-icon">f</div>
            <div class="twitter-icon">t</div>
            <div class="instagram-icon">O</div>
        </div>
    </div>
    <div class="random-posts">
        <div class="posts">
            <div class="label-rand">You may also like</div>

            <?php randomPosts(); ?>
        </div>
    </div>
<?php get_comments_block($id_post_comment) ?>