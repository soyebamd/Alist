<div class="main-body">
    <div class="main-content">
         <?php get_template_part('sidebar');
         ?>
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
    <div class="clearfix"></div><!--clearfix-->
            <div class="inner-pages-content location-container">                          
                <div class="content-container preparation-instructions">
                    <h2><?php the_title(); ?></h2>
                    <?php the_content();?>
        </div><!--inner-page-content-->
        <div class="clearfix"></div><!--clearfix-->
         
        
    </div><!--main-content-->
    <div class="clearfix"></div>
    <?php get_template_part('testimonials');?>
    <div class="clearfix"></div><!--clearfix-->
    <div class="alist-location">
        <div class="locations-container">
        <?php
        $type = 'page';
        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'caller_get_posts' => 1,
            'category_name' => 'city-map'
        );
        $my_query = null;
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
            while ($my_query->have_posts()) : $my_query->the_post();
                the_content();
                edit_post_link(sprintf(('Edit')));
                wp_reset_query();
            endwhile;
        }
        ?>    
        </div><!--locations-container-->
    </div>
    
    <br><?php
                             edit_post_link(
                                        sprintf(
                                                /* translators: %s: Name of current post */
                                                __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                                        ), '<span class="edit-link">', '</span>'
                                );
                                ?>
            </div><!--main-body-->
</div>
