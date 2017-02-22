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

get_header(); ?>

<div class="main-body">
    <div class="main-content">
        <div class="clearfix"></div><!--clearfix-->
        <div class="inner-page-content full-width">
<div class="breadcrumb">
            <ul>
            <?php
                if (function_exists('bcn_display')) {
                    bcn_display();
                }
            ?>
            </ul>
        </div><!--breadcrumb-->
                    <?php woocommerce_content(); ?>
             <div class="clearfix"></div><!--clearfix-->
        </div>
        <?php
        $type = 'testimonials';
        $cat = 'testimonial_parent_students';
        $successStory = '/parents-students/success-stories/';
        ?>
        <div class="client-testimonials woocommerce-testimonials">
            <div id="testimonials-slider" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="container">
                <div class="row">
                    <div class="carousel-inner" role="listbox">
                       <?php
                            $s=0;
                            $type = 'testimonials';
                            $args = array(
                                'post_type' => $type,
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                                'caller_get_posts' => 1,
                                'category_name' => $cat,
                            );
                            $my_query = null;
                            $my_query = new WP_Query($args);
                            if ($my_query->have_posts()) {
                                while ($my_query->have_posts()) : $my_query->the_post();
                                $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                                if ($s == 0) {
                                  $class = "active";
                                } else {
                                    $class = "";
                                } $s++;
                        ?> 
                            <div class="item <?php echo $class; ?>">
                                <div class="testimonials-content">
                                    <h3><?php the_title(); ?></h3>
                                    <br><?php edit_post_link(sprintf(('Edit')));?>
                                        <?php the_content();?>
                                </div><!--testimonials-content-->
                            </div><!--item-->
                        <?php
                                wp_reset_query();
                                endwhile;
                            }
                        ?>     
                    </div><!--carousel-inner-->
                </div><!--row-->
            </div><!--container-->

            <!-- Controls -->
            <div class="testimonials-carousel-control">
                <a class="left carousel-control" href="#testimonials-slider" role="button" data-slide="prev">
                    <img src="<?php echo bloginfo('template_directory'); ?>/images/arrow-left.png" alt="">
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#testimonials-slider" role="button" data-slide="next">
                    <img src="<?php echo bloginfo('template_directory'); ?>/images/arrow-right.png" alt="">
                    <span class="sr-only">Next</span>
                </a>
            </div><!--testimonials-carousel-control-->

            <!-- Indicators -->
            
            <ol class="carousel-indicators">
                <?php  $s=0;
            $type = 'testimonials';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => $cat,
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
              if ($s == 0) {
                            $class = "active";
                        } else {
                            $class = "";
                        } 
                        ?> 
                <li data-target="#testimonials-slider" data-slide-to="<?php echo $s;?>" class="<?php echo $class?>">
                    <img src="<?php echo $feat_image; ?>" alt="">
                </li>
                
                <?php $s++;
                    wp_reset_query();
                endwhile;
            }
            ?>
            </ol>
            </div><!--carousel slide-->
            <a href="<?php echo get_settings('home').$successStory; ?>" class="default-btn">See All Success Stories</a>
        </div><!--client-testimonials-->
                        <div class="clearfix"></div>
                        <?php //get_template_part('testimonials');?>
            <br><?php
                            /* edit_post_link(
                                        sprintf(
                                                /* translators: %s: Name of current post */
                                              //  __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                                        //), '<span class="edit-link">', '</span>'
                              //  );*/
                                ?>
                         
                    </div><!--inner-page-content-->
                    
                </div><!--main-content-->
            </div><!--main-body-->

<?php get_footer(); ?>
