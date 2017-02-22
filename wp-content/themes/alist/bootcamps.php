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

                            <div class="about-edu">
                                <h3><?php the_title(); ?></h3>
                               <div class="bootcamps-hightlights">
                                   <?php
                                $type = 'page';
                                $args = array(
                                    'post_type' => $type,
                                    'post_status' => 'publish',
                                    'posts_per_page' => 1,
                                    'caller_get_posts' => 1,
                                    'category_name' => 'sat_prep_module'
                                );
                                $my_query = null;
                                $my_query = new WP_Query($args);
                                if ($my_query->have_posts()) {
                                    while ($my_query->have_posts()) : $my_query->the_post();
                                        //$feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                                                 ?>
                                   <h3><?php the_title(); ?></h3>

                                    <div class="highlights-content">
                                        <?php the_content(); ?>
                                    </div><!--highlights-content-->
                                <?php
                                       wp_reset_query();
                                   endwhile;
                               }
                               ?>  
                                    
                                    <div class="highlights-content-dates">
                                        <?php
                                $type = 'page';
                                $args = array(
                                    'post_type' => $type,
                                    'post_status' => 'publish',
                                    'posts_per_page' => 1,
                                    'caller_get_posts' => 1,
                                    'category_name' => 'upcoming_boot_dates'
                                );
                                $my_query = null;
                                $my_query = new WP_Query($args);
                                if ($my_query->have_posts()) {
                                    while ($my_query->have_posts()) : $my_query->the_post();
                                        //$feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                                    ?>
                                        <h5><?php the_title();?></h5>
                                   <?php
                                   the_content();            
                                    ?>
                                    </div><!--highlights-content-->
                                     <?php
                            wp_reset_query();
                        endwhile;
                    }
                    ?>  
                                    <div class="clearfix"></div><!--clearfix-->
                                </div><!--bootcamps-hightlights-->
                                <div class="signup-caption">
                                   <?php 
                                the_content();
                                   ?>
                                   </div><!--signup-caption-->
                        </div><!--about-edu-->
                        </div><!--inner-pages-content-->
                        <div class="clearfix"></div><!--clearfix-->
                              <?php get_template_part('testimonials');?>
                        <br><?php
                             edit_post_link(
                                        sprintf(
                                                /* translators: %s: Name of current post */
                                                __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                                        ), '<span class="edit-link">', '</span>'
                                );
                                ?>
                        <div class="clearfix"></div><!--clearfix-->
                    </div><!--inner-page-content-->
                </div><!--main-content-->

          
