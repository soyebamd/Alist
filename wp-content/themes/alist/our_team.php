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
        <div class="inner-pages-content container-outer-wrap">
            <div class="test-subject container">
                <h3><?php the_title(); ?></h3>
                <?php the_content(); ?>
                <div class="clearfix"></div><!--clearfix-->
            </div>  
        </div>
        <?php
        $type = 'page';
        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'caller_get_posts' => 1,
            'orderby' => 'post_title',
            'category_name' => 'our-management'// our management
        );
        $my_query = null;
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) { ?>
            <div class="exceptional-educators white-bg">
                <h3>Management & Administration</h3>
                    <ul>
                    <?php
                        while ($my_query->have_posts()) : $my_query->the_post();
                            $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'team_thumb');
                    ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php
                                if ($feat_image[0]) {
                                    echo $feat_image[0];
                                } else {
                                    echo bloginfo('template_directory');
                                    ?>/images/map-pin.png <?php } ?>" alt="">  
                                <label><?php the_title(); ?></label>
                                <?php
                                if (has_excerpt()) {
                                    the_excerpt();
                                }
                                ?>
                            </a>
                        </li>
                    <?php
                        endwhile;
                        wp_reset_query();
                    ?>     
                    </ul>
            </div><div class="clearfix"></div>
            <?php }// our management endif ?>
<!--//////////////////////////////////////Complete Team//////////////////////////////////-->
        <?php
        $type = 'page';
        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'caller_get_posts' => 1,
            'orderby' => 'post_title',
            'category_name' => 'except_educators'// our management
        );
        $my_query = null;
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) { ?>
            <div class="exceptional-educators">
                <h3>Tutors & Instructors</h3>
                    <ul>
                    <?php
                        while ($my_query->have_posts()) : $my_query->the_post();
                            $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'team_thumb');
                    ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php
                                if ($feat_image[0]) {
                                    echo $feat_image[0];
                                } else {
                                    echo bloginfo('template_directory');
                                    ?>/images/map-pin.png <?php } ?>" alt="">  
                                <label><?php the_title(); ?></label>
                                <?php
                                if (has_excerpt()) {
                                    the_excerpt();
                                }
                                ?>
                            </a>
                        </li>
                    <?php
                        endwhile;
                        wp_reset_query();
                    ?>     
                    </ul>
            </div><div class="clearfix"></div>
            <?php }// our management endif ?>
    </div><!--main-body-->
