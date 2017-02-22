<div class="main-body">
    <div class="main-content">
        <?php get_template_part('sidebar'); ?>
        <?php $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>

        <div class="uk-banner" style="background-image: url(<?php echo $feat_image; ?>)">
            <?php the_excerpt(); ?>  <div class="clearfix"></div><!--clearfix-->
            <a href="<?php get_settings('home'); ?>/uk/get-started" class="default-btn">Start My Journey</a>
        </div><!--uk-banner-->
        <div class="clearfix"></div><!--clearfix-->

        <div class="parents-partners">
            <?php
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => 2,
                'caller_get_posts' => 1,
                'category_name' => 'uk_home_links'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                $count = 1;
                while ($my_query->have_posts()) : $my_query->the_post();
                    ?>
                    <div class="parents-content parents-partners-int__subheader-wrap">
                        <h5><?php the_title(); ?></h5>
                           <?php the_content(); ?>
                           <?php edit_post_link(sprintf(('Edit'))); ?>
                    </div><!--parents-content-->

                    <?php
                    $count++;
                    wp_reset_query();
                endwhile;
            }
            ?>
        </div><!--parents-partners-->
        <div class="clearfix"></div><!--clearfix-->
        <div class="about-alist-education">
            <?php $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page', 'third-image'); ?>
            <img src="<?php echo $feat_image; ?>" alt="" class="img-responsive">
        </div><!--about-alist-education-->
        <div class="clearfix"></div><!--clearfix-->
        <div class="exceptional-sat">
            <h3>Highly Trained SAT & ACT Tutors and Expert US University Advisors</h3>
            <ul>
                <?php
                $type = 'page';
                $args = array(
                    'post_type' => $type,
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'caller_get_posts' => 1,
                    'category_name' => 'expert_sat'
                );
                $my_query = null;
                $my_query = new WP_Query($args);
                if ($my_query->have_posts()) {
                    while ($my_query->have_posts()) : $my_query->the_post();
                        $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                        ?>

                        <li>
                            <img src="<?php echo $feat_image; ?>" alt="">
                            <h5><?php the_title(); ?></h5>
                            <?php the_content(); ?>
                            <?php edit_post_link(sprintf(('Edit'))); ?>
                        </li>

                        <?php
                        wp_reset_query();
                    endwhile;
                }
                ?>
            </ul>
            <div class="clearfix"></div><!--clearfix-->
            <div class="utility__mar-bumb-top-bottom">
                <a href="/uk/get-started" class="default-btn">Get Started</a>
            </div>
        </div><!--exceptional-sat-->
        <div class="clearfix"></div><!--clearfix-->
        <!--<div class="client-testimonials uk-testimonials">-->
        <?php get_template_part('testimonials'); ?>
        <!--</div>-->
        <div class="clearfix"></div><!--clearfix-->
        <div class="about-alist-education">
            <?php the_content(); ?>
        </div><!--about-alist-education-->
        <br><?php
        edit_post_link(
                sprintf(
                        /* translators: %s: Name of current post */
                        __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                ), '<span class="edit-link">', '</span>'
        );
        ?>
        <div class="clearfix"></div><!--clearfix-->
        <div class="bottom-border"></div><!--bottom-border-->
        <div class="clearfix"></div><!--clearfix-->

    </div><!--main-content-->
</div><!--main-body-->
