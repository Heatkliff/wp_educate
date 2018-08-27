<?php
add_theme_support('post-thumbnails');
set_post_thumbnail_size(150, 150, TRUE);

function get_form_home()
{
    $form = "
<div class=\"form\">
    <form>
        <div class=\"label\">Sign up for our newsletter</div>
        <input type=\"email\" placeholder=\"Enter a valid email address\">
        <input type=\"submit\" value=\"\">
        <hr>
    </form>
</div>
";
    echo $form;

}

function true_loadmore_scripts()
{
    wp_enqueue_script('jquery'); // скорее всего он уже будет подключен, это на всякий случай
    wp_enqueue_script('true_loadmore', get_stylesheet_directory_uri() . '/js/loadmore.js', array('jquery'));

    if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

    wp_enqueue_script('main_script', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'));
}

add_action('wp_enqueue_scripts', 'true_loadmore_scripts');
add_action('admin_enqueue_scripts', 'true_loadmore_scripts');

function true_load_posts()
{

    $args = unserialize(stripslashes($_POST['query']));
    $args['paged'] = $_POST['page'] + 1; // следующая страница
    $args['post_status'] = 'publish';

    query_posts($args);
    if (have_posts()) : ?>

        <div class="posts">
        <?php while (have_posts()) : the_post(); ?>
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
                <?php the_excerpt(); ?>
            </div>
        <?php endwhile;

    endif;
    die();
}


add_action('wp_ajax_loadmore', 'true_load_posts');
add_action('wp_ajax_nopriv_loadmore', 'true_load_posts');

register_sidebar(array(
    'name' => 'Footer Links',
    'id' => 'footer-links',
    'description' => 'Links',
    'before_widget' => '<div id="footer-links">',
    'after_widget' => '</div>',
    'before_title' => '<h2>',
    'after_title' => '</h2>',
));
register_sidebar(array(
    'name' => 'Footer Following Links',
    'id' => 'footer-follow',
    'description' => 'Following Links',
    'before_widget' => '<div id="footer-follow">',
    'after_widget' => '</div>',
    'before_title' => '<h2>',
    'after_title' => '</h2>',
));

function new_excerpt_more($more)
{
    global $post;
    return '';
}

add_filter('excerpt_more', 'new_excerpt_more');

function randomPosts()
{
    query_posts('orderby=rand&showposts=3');
    if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="random-post">
            <a title="<?php the_title(); ?>"
               href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
            <br>
            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </div>
    <?php endwhile; endif;
}

function my_comments_callback($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;

    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">

            <div class="comment-content"><?php comment_text(); ?></div>

            <p><?php echo "Comment authors age: " . get_comment_meta($comment->comment_ID, 'age', true); ?></p>

            <div class="reply">
                <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply <span>&darr;</span>', 'twentyeleven'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </div>
        </article>
    </li>
    <?php
}

function get_form_comment()
{
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $fields = array(
        'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name') . '</label> ' . ($req ? '<span class="required">*</span>' : '') .
            '<input id="author" name="author" type="text" placeholder="Name" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
        'email' => '<p class="comment-form-email"><label for="email">' . __('Email') . '</label> ' . ($req ? '<span class="required">*</span>' : '') .
            '<input id="email" name="email" type="text" placeholder="E-mail" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
    );

    $comments_args = array(
        'fields' => $fields,
        'label_submit' => 'Send My Comment'
    );
    if (wp_get_current_user()->data->user_nicename)
        echo "<div class='icon-account'><div class=\"name-acc\">" . substr(wp_get_current_user()->data->user_nicename, 0, 1) . "</div></div>";
    comment_form($comments_args);
}


function educate_wp_num_comments($post_id)
{
    $count_comment = wp_count_comments($post_id);
    if ($count_comment->all == 0) {
        echo "Have not comments";
    } elseif ($count_comment->all == 1) {
        echo "1 comment";
    } elseif ($count_comment->all > 1) {
        echo $count_comment->all . " comments";
    }
}


function bottom_commentfield($fields)
{
    $comment_field = $fields['comment'];
    unset($fields['comment']);
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter('comment_form_fields', 'bottom_commentfield');

function get_comments_block($id_post_comment)
{
    ?>
    <div class="comments-in-post">
    <div class="num-comments"><?php educate_wp_num_comments($id_post_comment) ?></div>
    <?php $comments = get_comments(array('post_id' => $id_post_comment, 'offset' => 10));
    foreach ($comments as $comment) {
        echo "<div class='one-comment'>";
        echo "<div class='icon-account'><div class=\"name-acc\">" . substr($comment->comment_author, 0, 1) . "</div></div>"
            . "<div class='name-author'>" . $comment->comment_author . "</div> <div class='comment-post'>" . $comment->comment_content . "</div>";
        echo "</div>";
    }
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $fields = array(
        'author' => '<p class="comment-form-author">' . ($req ? '<span class="required">*</span>' : '') .
            '<input id="author" name="author" type="text" placeholder="Name" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
        'email' => '<p class="comment-form-email">' . ($req ? '<span class="required">*</span>' : '') .
            '<input id="email" name="email" type="text" placeholder="Email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
    );

    $comments_args = array(
        'fields' => $fields
    );
    echo "<div class='form-comment'>";
    if (wp_get_current_user()->data->user_nicename)
        echo "<div class='icon-account'><div class=\"name-acc\">" . substr(wp_get_current_user()->data->user_nicename, 0, 1) . "</div></div>";
    comment_form($comments_args, $id_post_comment);
    echo "</div>";
}


add_action( 'widgets_init', 'right_sidebar' );

function right_sidebar() {
    register_sidebar(
        array(
            'id' => 'right_sidebar',
            'name' => __( 'Right sidebar' ),
            'description' => __( 'Sidebar in pages' )
        )
    );
}






$true_page = 'Education_option';

function educate_options() {
	global $true_page;
	add_options_page( 'Theme options', 'Education_option', 'manage_options', $true_page, 'true_option_page');
}
add_action('admin_menu', 'educate_options');

function true_option_page(){
	global $true_page;
	?><div class="wrap">
		<h2>Theme option</h2>
		<form method="POST" action="options.php">
			<?php

			settings_fields('educate_options');
			do_settings_sections($true_page);
			true_image_uploader_field('educate_options[banner]', get_option('educate_options')['banner']);
			?>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
			</p>
		</form>
	</div><?php
}

function true_option_settings() {
	global $true_page;
	register_setting( 'educate_options', 'educate_options', 'true_validate_settings' ); // educate_options

	add_settings_section( 'true_section_1', 'View page', '', $true_page );

	$true_field_params = array(
		'type'      => 'radio',
		'id'      => 'sidebar',
		'vals'		=> array( 'val1' => 'Used pages with sidebar', 'val2' => 'Used pages without sidebar')
	);
	add_settings_field( 'sidebar', 'Used view page', 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );

}
add_action( 'admin_init', 'true_option_settings' );



function true_option_display_settings($args) {
	extract( $args );

	$option_name = 'educate_options';

	$o = get_option( $option_name );

	switch ( $type ) {
		case 'text':
			$o[$id] = esc_attr( stripslashes($o[$id]) );
			echo "<input class='regular-text' type='text' id='$id' name='" . $option_name . "[$id]' value='$o[$id]' />";
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
		break;
		case 'checkbox':
			$checked = ($o[$id] == 'on') ? " checked='checked'" :  '';
			echo "<label><input type='checkbox' id='$id' name='" . $option_name . "[$id]' $checked /> ";
			echo ($desc != '') ? $desc : "";
			echo "</label>";
		break;
		case 'select':
			echo "<select id='$id' name='" . $option_name . "[$id]'>";
			foreach($vals as $v=>$l){
				$selected = ($o[$id] == $v) ? "selected='selected'" : '';
				echo "<option value='$v' $selected>$l</option>";
			}
			echo ($desc != '') ? $desc : "";
			echo "</select>";
		break;
		case 'radio':
			echo "<fieldset>";
			foreach($vals as $v=>$l){
				$checked = ($o[$id] == $v) ? "checked='checked'" : '';
				echo "<label><input type='radio' name='" . $option_name . "[$id]' value='$v' $checked />$l</label><br />";
			}
			echo "</fieldset>";
		break;


	}
}

function true_image_uploader_field( $name, $value = '', $w = 150, $h = 150) {
	$default = '/wp-content/themes/education_theme/assets/no_image.png';
	if( $value ) {
		$image_attributes = wp_get_attachment_image_src( $value, array($w, $h) );
		$src = $image_attributes[0];
	} else {
		$src = $default;
	}
	echo '
	<div>
		<img data-src="' . $default . '" src="' . $src . '" width="' . $w . 'px" height="' . $h . 'px" />
		<div>
			<input type="hidden" name="' . $name . '" value="' . $value . '" />
			<button type="button" class="upload_image_button button">Загрузить</button>
			<button type="button" class="remove_image_button button">&times;</button>
		</div>
	</div>
	';
}