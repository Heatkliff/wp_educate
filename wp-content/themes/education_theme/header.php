<!DOCTYPE html>
<html>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title>
        <?php echo wp_get_document_title(); ?>
    </title>

    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
    <link rel="stylesheet" href="/wp-content/themes/education_theme/css/style-ed.css" type="text/css" />

    <?php wp_head(); ?>
</head>

<body>
<header class="header">
    <?php wp_nav_menu(array('$menu_id'=>'','$menu_class'=>''))?>
</header>