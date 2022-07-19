<?php get_header(); ?>

<?php
global $post;
$post_model = new PostModel($post->ID, 'single');
?>

<div class="row">
    <div class="single-title col-lg-9">
        <h6><?php echo $post_model->category; ?></h6>
        <h1 class="card-title">
            <?php echo $post_model->title; ?>
        </h1>

        <div class="row">
            <div class="single-primary col-4">
                <?php
                $single_sidebar = get_sidebar('single-sidebar');
                if (!isset($single_sidebar)) :
                ?>
                    <aside>
                        <?php dynamic_sidebar('single-sidebar') ?>
                    </aside>
                <?php endif; ?>
            </div>

            <div class="single-secondary col-lg-6">
                <p class="card-text">
                    <?php echo $post_model->content; ?>
                </p>
            </div>
        </div>
        <div class="single-slider-box">
            <?php
                $slider = $post_model->slider;
                global $core_theme;
                $attributes = ['app-slider' => json_encode($slider)];
                echo $core_theme->loadAngularApp('slider', $attributes, true);
            ?>
        </div>
        <div class="singlepagination">
            <?php
            previous_post_link('<strong>%link</strong>');
            next_post_link('<strong>%link</strong>');
            ?>
        </div>
    </div>

    <div class="single-tertiary col-3">

        <?php
        $blog_sidebar = get_sidebar('blog-sidebar');
        if (!isset($blog_sidebar)) :
        ?>
            <aside>
                <?php dynamic_sidebar('blog-sidebar') ?>
            </aside>
        <?php endif; ?>

    </div>

</div>

<?php get_footer(); ?>