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
            <div class="container-content">
                <div class="isee-ssat-content">
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?>
                </div>
            </div><!--inner-pages-content-->
            <div class="clearfix"></div><!--clearfix-->
        </div>
        <div class="clearfix"></div><!--clearfix-->
        <div class="container-full-width">
            <div class="container">
                <div class="inner-pages-content">
                    <div class="about-text">
                         <?php
                                    $type = 'page';
                                    $args = array(
                                        'post_type' => $type,
                                        'post_status' => 'publish',
                                        'posts_per_page' => 1,
                                        'caller_get_posts' => 1,
                                        'category_name' => 'about_test'
                                    );
                                    $my_query = null;
                                    $my_query = new WP_Query($args);
                                    if ($my_query->have_posts()) {
                                        while ($my_query->have_posts()) : $my_query->the_post();
                                            ?>
                                            <h3><?php the_title() ?></h3>
                                            <br> <?php edit_post_link(sprintf(('Edit')));?>
                                             

                                            <?php
                                            the_content();
                                            wp_reset_query();
                                        endwhile;
                                    }
                                    ?>
                        <div class="clearfix"></div><!--clearfix-->
                        <div class="sample-content">
                           
                                <?php
                                    $type = 'page';
                                    $args = array(
                                        'post_type' => $type,
                                        'post_status' => 'publish',
                                        'posts_per_page' => -1,
                                        'caller_get_posts' => 1,
                                        'category_name' => 'test_sections'
                                    );
                                    $my_query = null;
                                    $my_query = new WP_Query($args);
                                    if ($my_query->have_posts()) {
                                        while ($my_query->have_posts()) : $my_query->the_post();
                                            ?>
                                                <div class="featured-studies">
                                                            <h6><?php the_title(); ?></h6>
                                                            <br><?php edit_post_link(sprintf(('Edit')));?>
                                                            <?php the_content(); ?>
                                                        </div><!--col-lg-6 col-sm-6-->

                                                        <?php
                                                        
                                                        wp_reset_query();
                                                    endwhile;
                                                }
                                                ?>     <!--col-lg-6 col-sm-6-->
                        </div><!--sample-content-->
                        <div class="clearfix"></div><!--clearfix-->
                        <div class="redesigned-test">
                            <?php
                                    $type = 'page';
                                    $args = array(
                                        'post_type' => $type,
                                        'post_status' => 'publish',
                                        'posts_per_page' => -1,
                                        'caller_get_posts' => 1,
                                        'category_name' => 'redesigned-test-facts'
                                    );
                                    $my_query = null;
                                    $my_query = new WP_Query($args);
                                    if ($my_query->have_posts()) {
                                        while ($my_query->have_posts()) : $my_query->the_post();
                                            ?>
                            <h5><?php the_title();?></h5><br> <?php edit_post_link(sprintf(('Edit')));?>
                                            
                       <?php
                                    the_content();


                                    wp_reset_query();
                                endwhile;
                            }
                            ?>  
                        </div><!--redesigned-test-->
                        <div class="clearfix"></div><!--clearfix-->
                        <div class="test-breakdown">
                             <div class="table-responsive">

                                <?php
                                $type = 'page';
                                $args = array(
                                    'post_type' => $type,
                                    'post_status' => 'publish',
                                    'posts_per_page' => 1,
                                    'caller_get_posts' => 1,
                                    'category_name' => 'test_breakdown'
                                );
                                $my_query = null;
                                $my_query = new WP_Query($args);
                                if ($my_query->have_posts()) {
                                    while ($my_query->have_posts()) : $my_query->the_post();
                                        ?>
                                        <h5><?php the_title() ?></h5>
                                        <?php edit_post_link(sprintf(('Edit')));?>
                                        <div class="table-responsive">
                                            <?php
                                            the_content();
                                            wp_reset_query();
                                        endwhile;
                                    }
                                    ?> 
                            </div><!--table-responsive-->
                        </div><!--test-breakdown-->
                        <div class="clearfix"></div><!--clearfix-->
                        </div><!--about-text-->
                        <div class="clearfix"></div><!--clearfix-->
                            <div class="consider-taking">
                                <?php
                                $type = 'page';
                                $args = array(
                                    'post_type' => $type,
                                    'post_status' => 'publish',
                                    'posts_per_page' => -1,
                                    'caller_get_posts' => 1,
                                    'category_name' => 'taking-the-act'
                                );
                                $my_query = null;
                                $my_query = new WP_Query($args);
                                if ($my_query->have_posts()) {
                                    while ($my_query->have_posts()) : $my_query->the_post();
                                        edit_post_link(sprintf(('Edit')));
                                        the_content();
                                        wp_reset_query();
                                    endwhile;
                                    }
                                ?>
                            </div><!--consider-taking-->
                        <div class="clearfix"></div><!--clearfix-->
                    </div>
                </div><!--inner-pages-content-->
                
                <br>
                <?php
                 edit_post_link(
                            sprintf(
                                    /* translators: %s: Name of current post */
                                    __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                            ), '<span class="edit-link">', '</span>'
                    );
                ?>                
            </div>
        </div>
        <?php get_template_part('testimonials');?>        
    </div>
</div><!--main-body-->
