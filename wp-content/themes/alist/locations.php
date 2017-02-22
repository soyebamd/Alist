<div class="main-body location-content">
    <?php
    $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    if ($feat_image) {
        ?>
        <div class="inner-banner">

            <div class="inner-caption" style="background-image: url(<?php
            echo $feat_image;
            ;
            ?>)">
            </div><!--inner-caption-->
        </div><!--inner-banner-->
    <?php } ?>
    <div class="breadcrumb">
        <ul>
            <?php
            if (function_exists('bcn_display')) {
                bcn_display();
            }
            ?>    
        </ul>
    </div><!--breadcrumb-->
    <div class="clearfix"></div><!--clearfix-->
    <div class="alist-locations">
        <?php the_content(); ?>
    </div><!--alist-locations-->
    <?php get_template_part('map'); ?>
    <div class="clearfix"></div><!--clearfix-->
    <div class="alist-locations">

        <?php the_excerpt(); ?>
    </div><!--alist-locations-->
    <div class="clearfix"></div><!--clearfix--> 

    <?php get_template_part('testimonials'); ?>

    <br><?php
    edit_post_link(
            sprintf(
                    /* translators: %s: Name of current post */
                    __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
            ), '<span class="edit-link">', '</span>'
    );
    ?>
    <div class="clearfix"></div><!--clearfix-->

</div><!--main-body-->