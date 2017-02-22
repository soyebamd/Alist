<div class="main-body">
    <div class="main-content">
        <?php
        get_template_part('sidebar');
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
        <div class="inner-page-content container-outer-wrap utility__pad-bump-top-btm-mdm utility__no-pad-btm">
            <div class="w100 graphPanel_1 container">
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div><!--graphPanel_1-->
            <?php
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => 'case_study_result'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    echo the_content();
                    edit_post_link(sprintf(('Edit')));
                    wp_reset_query();
                endwhile;
            }
            ?>
            <?php
            //$type = 'parents_students';
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'caller_get_posts' => 1,
                'category_name' => 'school&nonprofit_map'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                    ?>
                    <div class="educators-banner w100">
                        <img src="<?php echo $feat_image; ?>" alt="">
                    </div><!--educators-banner-->
                    <div class="clearfix"></div><!--clearfix-->
                    <div class="inner-pages-content">
                        <div class="content-container text-center">
                            <div class="getstarted-section text-center secMid">
                                <?php the_content(); ?>
                                <div class="w100"><a class="default-btn" href="<?php echo get_settings('home') ?>/schools-nonprofits/get-started/">Get Started</a></div>    
                            </div><!--getstarted-section-->
                        </div><!--content-container-->
                    </div><!--inner-pages-content-->
                    <?php
                    edit_post_link(sprintf(('Edit')));
                    wp_reset_query();
                endwhile;
            }
            ?>
        </div><!--inner-page-content-->
        <?php get_template_part('testimonials'); ?><br>
        <?php
        edit_post_link(
                sprintf(
                        /* translators: %s: Name of current post */
                        __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                ), '<span class="edit-link">', '</span>'
        );
        ?>
    </div><!--main-content-->
</div><!--main-body-->
