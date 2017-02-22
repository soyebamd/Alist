<div class="main-body">
    <div class="main-content">
        <?php
            get_template_part('sidebar');
            $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
            if(!$feat_image){
                $parents = get_post_ancestors( $post->ID );
                $pid = ($parents) ? $parents[count($parents)-1]: $post->ID;
                $feat_image = wp_get_attachment_url(get_post_thumbnail_id($pid));
            }
            if($feat_image){
        ?>
                <div class="clearfix"></div><!--clearfix-->
            <div class="inner-banner">
                <div class="inner-caption" style="background-image: url(<?php echo $feat_image;
                ; ?>)">
                </div><!--inner-caption-->
            </div><!--inner-banner-->
        <?php } ?>
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
        <!-- needed end -->

 
       <div class="inner-pages-content">
            <div class="clearfix"></div><!--clearfix-->
            <div class="inner-pages-content container-outer-wrap">
                <div class="text-center pmid container">
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?>
                    <div class="clearfix"></div><!--parents-banner-->
                </div><!--content-container-->
            </div><!--inner-pages-content-->
            <div class="clearfix"></div><!--clearfix-->
            <div class="four-column2 mrg25 w100 profess-develop__list-outer-wrap container-outer-wrap">
                <ul class="w100 container">
                    <?php
                    //$type = 'parents_students';
                    $type = 'page';
                    $args = array(
                        'post_type' => $type,
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'caller_get_posts' => 1,
                        'category_name' => 'prof_development_sub_pages_turkey'
                    );
                    $my_query = null;
                    $my_query = new WP_Query($args);
                    if ($my_query->have_posts()) {
                        while ($my_query->have_posts()) : $my_query->the_post();
                            //$feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                            $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page', 'secondary-image');
                            ?>
                            <li>
                                <img src="<?php echo $feat_image; ?>" alt="">
                                <a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a>                         
                                <?php
                                if ( has_excerpt( $post->ID ) ) {
                                    the_excerpt();
                                } else {
                                    the_content();
                                }
                                edit_post_link(sprintf(('Edit')));
                                ?>
                            </li>
                            <?php
                            wp_reset_query();
                        endwhile;
                    }
                    ?> 
                </ul>
                <div class="w100 mrgb25 flex flex-just-cent">
                    <a href="<?php echo get_settings('home')?>/schools-and-non-profits/get-started/" class="default-btn">Get Started</a>            
                </div>
            </div>
        </div><!--inner-page-content-->
        <?php get_template_part('testimonials'); ?>
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
