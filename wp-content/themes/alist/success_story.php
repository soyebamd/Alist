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
                  <div class="icon-list__outer-wrap">
                    <ul class="icon-list__inner-wrap list-wrap-20">
                      <li>
                          <div class="icon-list__item-wrap">
                          <a href="/parents-and-students/testimonials/"><img src="<?php echo get_template_directory_uri(); ?>/images/parents-student-testimonials.png" alt=""></a>
                          </div>
                          <p><a class="utility__strip-link-style" href="/parents-and-students/testimonials/">Parent &amp; Student Testimonials</a></p>
                      </li>
                      <li>
                          <div class="icon-list__item-wrap">
                            <a href="/schools-and-non-profits/testimonials/"><img src="<?php echo get_template_directory_uri(); ?>/images/what-schools-nonprofits-are-saying.png" alt=""></a>
                          </div>
                          <p><a class ="utility__strip-link-style" href="/schools-and-non-profits/testimonials/">What Schools &amp; Nonprofits are Saying</a></p>
                      </li>
                      <li>
                          <div class="icon-list__item-wrap">
                          <a href="/parents-and-students/act-sat-score-improvements/"><img src="<?php echo get_template_directory_uri();?>/images/sat-score-improvements.png" alt=""></a>
                          </div> 
                          <p><a class="utility__strip-link-style" href="/parents-and-students/act-sat-score-improvements/">ACT/SAT&nbsp;Score Improvements</a></p>
                      </li>
                      <li>
                        <div class="icon-list__item-wrap">
                          <a href="/parents-and-students/advising-admissions/college-advising-and-essays/"><img src="<?php echo get_template_directory_uri();?>/images/college-acceptances.png" alt=""></a>
                        </div>
                        <p><a class="utility__strip-link-style" href="/parents-and-students/advising-admissions/college-advising-and-essays/">College Acceptances</a></p>
                      </li>
                      <li>
                        <div class="icon-list__item-wrap">
                          <a href="/schools-and-non-profits/institutional-case-studies-and-results/"><img src="<?php echo get_template_directory_uri();?>/images/institutional-program-results.png" alt=""></a>
                        </div>
                        <p><a class="utility__strip-link-style" href="/schools-and-non-profits/institutional-case-studies-and-results/">Institutional Program Results</a></p>
                      </li>
                    </ul>
                </div>
                <div class="flex flex-just-spar utility__container-sec-inner">
                  <a class="default-btn" href="/parents-and-students/write-a-testimonial/" style="width: 345px !important;">Students and Parents: Write a Testimonial</a>
<a class="default-btn" href="/schools-and-non-profits/write-a-testimonial/" style="width: 345px !important;">Schools and Nonprofits: Write a Testimonial</a></div>
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
