<div class="main-body">
    <div class="main-content">
         <?php get_template_part('sidebar');?>
     <?php $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));?>
        <?php if ($feat_image) { ?>
            <div class="inner-banner">
                <div class="inner-caption" style="background-image: url(<?php
                echo $feat_image;
                ;
                ?>)">
                </div><!--inner-caption-->
            </div><!--inner-banner-->
        <?php } ?>
        <div class="clearfix"></div><!--clearfix-->
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
            <div class="inner-pages-content">

                <div class="container-content">
                    <?php  the_content(); ?>
                    
                </div><!--container-content-->
            </div><!--inner-pages-content-->
            <div class="clearfix"></div><!--clearfix-->
             <?php get_template_part('testimonials'); ?>
            <br>
        <br><?php
                             edit_post_link(
                                        sprintf(
                                                /* translators: %s: Name of current post */
                                                __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                                        ), '<span class="edit-link">', '</span>'
                                );
                                ?>
    </div><!--main-content-->
            </div><!--main-body-->
            
            
