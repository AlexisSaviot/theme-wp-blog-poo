<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>
</head>

<body>
    <header>
        <div class="blog-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                $image = wp_get_attachment_image_src($custom_logo_id, 'full');
                ?>
                <img src="<?php echo $image[0]; ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
            </a>
        </div>
        <div class="navbar-container">
                <div class="searchbox">
                    <?php get_search_form() ?>
                </div>
            <nav class="navbar navbar-expand-lg">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <?php wp_nav_menu([
                        'menu' => 'navmenu',
                        'container' => false,
                        'menu_class' => 'navbar-nav',
                        'theme_location' => 'header',
                    ]); ?>
                </div>
            </nav>
        </div>
    </header>
    <div class="container">