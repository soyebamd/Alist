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

                        <!-- start Partner Organization loop -->
                        <div class="flex flex-just-cent" style="width: 100%; margin-top: 1%; margin-bottom: 1%;"><a class="default-btn" style="color: #fff; text-decoration: none; margin-top: 1%; margin-bottom: 1%;" href="/schools-and-non-profits/institutional-case-studies-and-results/">Case Studies &amp; Results</a></div>
                        <h3><a href="/schools-and-non-profits/testimonials"><strong>→   SEE WHAT SCHOOLS &amp; NONPROFITS ARE SAYING!</strong></a></h3>
                        <div class="imgwrp-cont">
                        <ul class="flex flex-wrap flex-just-spar">
                            <?php
                                $type = 'page';
                                $args = array(
                                    'post_type' => $type,
                                    'post_status' => 'publish',
                                    'posts_per_page' => -1,
                                    'caller_get_posts' => 1,
                                    'orderby' => 'post_title',
                                    'category_name' => 'Leveling the Playing Field'
                                );
                                $my_query = null;
                                $my_query = new WP_Query($args);
                                if ($my_query->have_posts()) {
                                    while ($my_query->have_posts()) : $my_query->the_post();
                                        $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page','secondary-image',NULL,'medium');
                                        list($width, $height, $type, $attr) = getimagesize($feat_image);
                                    ?>
                                    <li style="width: 20%">
                                    <?php
                                        if ($feat_image) { ?>
                                            <a href="<?php echo the_permalink(); ?>"><img class="alignnone" src="<?php echo $feat_image; ?>"  alt=""/></a>
                                    <?php
                                        }
                                    ?>
                                    </li>
             
                                    <?php
                                        endwhile;
                                    }
                                        wp_reset_query();
                                    ?> 
                        </ul>
                        </div>
                        <!-- end Partner Organization loop -->
                        </div>
            </div>
</div>


            </div>
                </div><!--inner-pages-content-->
                <div class="clearfix"></div><!--clearfix-->
            </div>
</div>

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
