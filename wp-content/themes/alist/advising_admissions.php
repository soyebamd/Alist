<div class="main-body">
    <div class="main-content">
        <?php get_template_part('sidebar');
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
        <div class="inner-pages-content">
            <div class="container-content">
                <div class="isee-ssat-content">
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?>
                </div>
            </div><!--inner-pages-content-->
            <div class="clearfix"></div><!--clearfix-->
        </div>
            <div class="clearfix"></div><!--clearfix-->
            <?php get_template_part('6_col_icon_center_text_services_include'); ?>
            <div class="success-banner">
                <div class="success-banner-content">
                    <div class="helping-caption">
                        <p>Helping Students Get Into Their Top-Choice Schools</p>
                        <a href="<?php get_settings('home'); ?>/success-stories/" class="default-btn">Success Stories</a>
                    </div><!--helping-caption-->
                    <div class="success-infograph">
                        <?php $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page','third-image');?>
                        <img src=" <?php echo $feat_image ;?>" alt="">
                    </div><!--success-infograph-->
                </div><!--success-banner-content-->
            </div><!--success-banner-->
            <div class="clearfix"></div><!--clearfix-->
            <div class="inner-pages-content">
                <div class="container-content">
                   <div class="clearfix"></div><!--clearfix-->
                    <p class="utility__center-text utility__mar-bumb-top-bottom">Interested in getting started with A-List’s advising and admissions services? Complete our <a href="/parents-and-students/get-started/">get started form</a> to provide us with more information about your student. An A-List representative will contact you to answer any questions about our program and to get you <a href="/parents-and-students/college-advisors/">matched with the right advisor</a>.</p>
                    <a href="/parents-and-students/get-started/" class="default-btn btn-001">Get Started</a>
                    <p class="utility__center-text utility__mar-bumb-top-bottom">Are you an international student looking to study in the U.S.? Our admissions experts are readily available to help international clients through every step of the U.S. college admissions process. Learn more by visiting our <a href="/uk/">UK</a>, <a href="/uae/">Middle East</a>, <a href="/turkey/">Turkey</a>, and <a href="/china/">Shanghai</a> pages.</p>
               </div><!--container-content-->
            </div><!--inner-pages-content-->
            <div class="clearfix"></div><!--clearfix-->
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

