<!DOCTYPE html>
<html>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo wp_get_document_title(); ?>
    </title>

    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
    <link rel="stylesheet" href="/wp-content/themes/education_theme/css/style-ed.css" type="text/css" />

    <?php wp_head(); ?>
</head>

<body>
<header class="header">
    <div class="logo"><a href="<?php bloginfo('url')?>"><?php bloginfo('name')?></a></div>
    <div id="menu" class="educate_menu">
    <?php wp_nav_menu(array('$menu_id'=>'','$menu_class'=>''))?>
    </div>
    <div id="btn"><span>&#9776</span></div>


</header>