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
            <div class="inner-pages-content">
                <div class="test-subject">
                    <h3><?php the_title(); ?></h3>
                    <?php
                    the_content();
                    ?>
                    <div class="clearfix"></div><!--clearfix-->


                </div>  
            </div>
            <div class="exceptional-educators">
                <div class="container">
                    <div class="row">
                        
                        <ul>
                            <?php
                            $type = 'except_educators';
                            $args = array(
                                'post_type' => $type,
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                                'caller_get_posts' => 1,
                                'category_name' => 'professional-consultants'// professional-consultants
                            );
                            $my_query = null;
                            $my_query = new WP_Query($args);
                            if ($my_query->have_posts()) {
                                while ($my_query->have_posts()) : $my_query->the_post();
                                    //$feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                                    $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'team_thumb');
         
                                    ?>
                                    <li>
                                        <a href="<?php the_permalink();?>">
                                            <img src="<?php if($feat_image[0]){ echo $feat_image[0];} else {echo bloginfo('template_directory'); ?>/images/map-pin.png <?php }?>" alt="">  
                                            <label><?php the_title(); ?></label>
                                        </a>
                                    </li>
                                    <?php
                                    wp_reset_query();
                                endwhile;
                            }
                            ?>

                        </ul>
                    </div><!--row-->
                   <?php get_template_part('testimonials'); ?>
                    <br>
                    <?php
                             edit_post_link(
                                        sprintf(
                                                /* translators: %s: Name of current post */
                                                __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                                        ), '<span class="edit-link">', '</span>'
                                );
                                ?>
                </div><!--container-->
            </div><!--exceptional-educators-->
       

    </div><!--main-content-->

</div><!--main-body-->
