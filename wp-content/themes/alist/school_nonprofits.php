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
            <div class="inner-pages-content container-outer-wrap">

                <div class="school-instruction container">
                    <?php the_content();?>
                    
                    
                </div><!--school-instruction-->
                <div class="clearfix"></div><!--clearfix-->
            </div><!--inner-pages-content-->
            <div class="clearfix"></div><!--clearfix-->
            <div class="casestudies-result container-outer-wrap">
                <div class="inner-pages-content light-light-gray-bg container">
                    <!-- <h2>Case Studies & Results</h2>
                    <p class="utility__center-text">A-List's professional development and direct instruction programs have a proven record of success. We have trained hundreds of teachers and helped countless schools and educational organizations develop and run their own successful SAT and ACT courses. Each institution comes to A-List with a unique set of needs; we customize our programs to best serve each organization and its students.</p>
                    <p>A-List's students increase their score by more than three times the National Average!</p>
                    <p class="red utility__center-text">The average national score improvement from PSAT to SAT is 55 points.</p>
                    <p class="red utility__center-text">In 2012, students who completed an A-List SAT program had average score improvements of 43 points for reading, 51 points for math and 67 points for writing, for an average total score improvement of 167 points.</p> -->
                    <?php
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => 'case_study'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                             ?>
                    <?php the_content(); ?> 
                    <br> <?php edit_post_link(sprintf(('Edit')));?>
                    
                    <?php
                            wp_reset_query();
                        endwhile;
                    }
                    ?>  
                </div><!--inner-pages-content-->
            </div><!--casestudies-result-->
            <div class="clearfix"></div><!--clearfix-->
            <div class="school-organization container-outer-wrap">
                <div class="inner-pages-content container">
                    <h2>Why Bring A-List to Your School or Organization</h2>
                    <?php
                    $type = 'page';
                    $args = array(
                        'post_type' => $type,
                        'post_status' => 'publish',
                        'posts_per_page' => 1,
                        'caller_get_posts' => 1,
                        'category_name' => 'why_bring-alist'
                    );
                    $my_query = null;
                    $my_query = new WP_Query($args);
                    if ($my_query->have_posts()) {
                        while ($my_query->have_posts()) : $my_query->the_post();
                            the_content();
                            wp_reset_query();
                        endwhile;
                    }
                    ?>
                    <p class="red utility__center-text"><strong>Interested in learning more or getting started with A-List’s School & Nonprofit offerings? Complete our get started form to provide us with more information about your student. An A-List representative will be in touch about getting started.</strong></p>
                </div><!--inner-pages-content-->
                <div class="clearfix"></div>
                <!--clearfix-->
                <div class="orgn-note">
                    <a class="default-btn" href="<?php get_settings('home'); ?>/schools-and-non-profits/get-started/">Get Started</a>
                </div>
            </div><!--school-organization-->
            <div class="clearfix"></div><!--clearfix-->
             <?php get_template_part('testimonials');?><br>
            <?php
                             edit_post_link(
                                        sprintf(
                                                /* translators: %s: Name of current post */
                                                __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                                        ), '<span class="edit-link">', '</span>'
                                );
                                ?>
        </div><!--inner-page-content-->
  
            </div><!--main-body-->
