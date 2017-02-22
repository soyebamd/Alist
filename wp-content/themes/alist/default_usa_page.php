<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<div class="main-body">
    <div class="main-content">
        <?php
        get_template_part('sidebar');
        ?>
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
                <div class="inner-caption" style="background-image: url(<?php echo $feat_image; ?>);">
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
            <div class="inner-pages-content">
                <div class="container-content container-outer-wrap">
                    <div class="isee-ssat-content container">
                        <?php the_content(); ?>
                    </div>
                </div><!--inner-pages-content-->
                <div class="clearfix"></div><!--clearfix-->
            </div>
            <div class="us-city__nav-outer-wrap">
                <ul class="us-city__list-wrap">
                    <li class="us-city__list-item" style="background-image: url('<?php echo bloginfo('template_directory'); ?>/images/a-list-boston.jpg');">
                        <a href="utility__absolute-link" href="/locations/los-angeles"></a>
                        <a class="us-city__btn-link" href="/locations/boston">A-List Boston</a>
                    </li>
                    <li class="us-city__list-item" style="background-image: url('<?php echo bloginfo('template_directory'); ?>/images/alist-new-york-city.jpg');">
                        <a href="utility__absolute-link" href="/locations/los-angeles"></a>
                        <a class="us-city__btn-link" href="/locations/new-york">A-List New York City</a>
                    </li>
                    <li class="us-city__list-item" style="background-image: url('<?php echo bloginfo('template_directory'); ?>/images/alist-los-angeles.jpg');">
                        <a href="utility__absolute-link" href="/locations/los-angeles"></a>
                        <a class="us-city__btn-link" href="/locations/los-angeles">A-List Los Angeles</a>
                    </li>
                    <li class="us-city__list-item" style="background-image: url('<?php echo bloginfo('template_directory'); ?>/images/alist-new-jersey.jpg');">
                        <a href="utility__absolute-link" href="/locations/los-angeles"></a>
                        <a class="us-city__btn-link" href="/locations/new-jersey">A-List New Jersey</a>
                    </li>
                    <li class="us-city__list-item" style="background-image: url('<?php echo bloginfo('template_directory'); ?>/images/a-list-long-island.jpg');">
                        <a href="utility__absolute-link" href="/locations/los-angeles"></a>
                        <a class="us-city__btn-link" href="/locations/long-island">A-List Long Island</a>
                    </li>
                    <li class="us-city__list-item" style="background-image: url('<?php echo bloginfo('template_directory'); ?>/images/a-list-westchester.jpg');">
                        <a href="utility__absolute-link" href="/locations/los-angeles"></a>
                        <a class="us-city__btn-link" href="/locations/westchester">A-List Westchester</a>
                    </li>
                    <li class="us-city__list-item" style="background-image: url('<?php echo bloginfo('template_directory'); ?>/images/alist-connecticut.jpg');">
                        <a href="utility__absolute-link" href="/locations/los-angeles"></a>
                        <a class="us-city__btn-link" href="/locations/connecticut">A-List Connecticut</a>
                    </li>
                    <li class="us-city__list-item" style="background-image: url('<?php echo bloginfo('template_directory'); ?>/images/alist-online.jpg');">
                        <a href="utility__absolute-link" href="/a-list-online"></a>
                        <a class="us-city__btn-link" href="/a-list-online">A-List Online</a>
                    </li>
                </ul>
                <div class="us-city__tagline-wrap">
                    <p >What began as a mission to introduce a new vision of education to a handful of students in 2005 has grown to serve more than 70,000 students and educators a year through our tutoring, school and nonprofit programs. </p>
                </div>
            </div>
            <?php get_template_part('map'); ?>
            <div class="clearfix"></div>
            <?php get_template_part('testimonials'); ?>
            <?php
            edit_post_link(
                sprintf(
                    /* translators: %s: Name of current post */
                    __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                    ), '<span class="edit-link">', '</span>'
                );
                ?>
            </div><!--inner-pages-content-->
        </div><!--main-body-->
        <?php get_footer(); ?>
