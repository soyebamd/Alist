<div class="main-body">
    <div class="main-content">
        <?php get_template_part('sidebar'); ?>
        <?php
            $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
            if(!$feat_image){
                $parents = get_post_ancestors( $post->ID );
                $pid = ($parents) ? $parents[count($parents)-1]: $post->ID;
                $feat_image = wp_get_attachment_url(get_post_thumbnail_id($pid));
            }
            if($feat_image){
        ?>
            <div class="inner-banner">
                <div class="inner-caption" style="background-image: url(<?php echo $feat_image;
                ; ?>)">
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
        <div class="inner-pages-content container-content container-outer-wrap">
            <div class="container-content container">
                <?php the_content(); ?>
            </div>
        </div>
        <div class="clearfix"></div><!--clearfix-->
        <div class="what-can-do what-can-do__outer-wrap">
            <h3>What Can A-List Help You With?</h3>
            <ul class="flex flex-wrap flex-just-spar">
                <?php
                $type = 'page';
                $args = array(
                    'post_type' => $type,
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'caller_get_posts' => 1,
                    'category_name' => 'alist_do_for_you_uk',
                    'orderby' => 'menu_order'
                );
                $my_query = null;
                $my_query = new WP_Query($args);
                if ($my_query->have_posts()) {
                    while ($my_query->have_posts()) : $my_query->the_post();
                        //$feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                        $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page', 'secondary-image');
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <div class="img-circle">
                                    <div class="icon-circle">
                                        <img src="<?php echo $feat_image; ?>" alt="">
                                    </div><!--icon-circle-->
                                </div><!--img-circle-->
                                <span><?php the_title(); ?></span>
                            </a>
                            <?php edit_post_link(sprintf(('Edit'))); ?>
                        </li>
                        <?php
                        wp_reset_query();
                    endwhile;
                }
                ?>

            </ul>
            <div class="clearfix"></div><!--clearfix-->
            <a href="<?php echo get_settings('home'); ?>/uk/meet-our-team/" class="default-btn">Find A Tutor</a>
            <div class="clearfix"></div><!--clearfix-->
        </div><!--what-can-do-->
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
    </div><!--inner-page-content-->


</div><!--main-body-->
