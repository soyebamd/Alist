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
                    <?php get_template_part('sidebar');
                    ?>
                      <div class="inner-pages-content">
                        <div class="container-content container-outer-wrap">
                            <div class="isee-ssat-content container">
                              <h3><?php the_title(); ?></h3>
                              <?php the_content(); ?>
                                               </div>
                            </div><!--inner-pages-content-->
                            <div class="clearfix"></div><!--clearfix-->
                        </div>
                        <?php get_template_part('map'); ?>
                        <div class="clearfix"></div>
                        <?php get_template_part('testimonials');?>
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

<?php get_footer(); ?>
