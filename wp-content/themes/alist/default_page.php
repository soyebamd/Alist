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
                <div class="inner-caption <?php echo $innerBannerClass; ?>" style="background-image: url(<?php echo $feat_image; ?>)">
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
                <div class="container-content container-outer-wrap">
                    <div class="isee-ssat-content container">
                        <h3><?php the_title(); ?></h3>
                        <?php the_content(); ?>
                    </div>
                </div><!--inner-pages-content-->
                <div class="clearfix"></div><!--clearfix-->
            </div>
            <?php get_template_part('location-map'); ?>
            <?php get_template_part('map'); ?>
            <div class="clearfix"></div>
            <?php get_template_part('testimonials'); ?>
            <br /><?php
            edit_post_link(
                sprintf(
                    /* translators: %s: Name of current post */
                    __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                    ), '<span class="edit-link">', '</span>'
                );
                ?>
            </div><!--inner-page-content-->
        </div><!--main-body-->
        <?php get_footer(); ?>
