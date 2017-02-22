<div class="main-body">
    <div class="main-content">
        <?php
            get_template_part('sidebar');
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
        <div class="content-container text-center pmid">
            <h3><?php the_title(); ?></h3>
            <h6><?php the_excerpt();  ?></h6>
            <div class="clearfix"></div><!--parents-banner-->
        </div><!--content-container-->
        <div class="clearfix"></div><!--clearfix-->
            <?php if( '' === the_content()) : ?>
            <div class="inner-pages-content">
                <div class="content-container text-center">
                    <div class="getstarted-section text-center secMid">
                        <?php the_content();?>
                    </div><!--getstarted-section-->
                </div><!--content-container-->
            </div>
            <?php endif ?>
            <div class="mrg25 w100 roundBox train-consult__list-outer-wrap">
                <h6>WE CAN PROVIDE</h6>
                    <ul class="w100 flex flex-wrap flex-just-spar flex-dir-col flex-align-cent train-consult__list-wrap">
                        <li>
                            <a href="/schools-and-non-profits/professional-development-for-educators/"><span><img src="/wp-content/uploads/2016/08/provide_05.png" alt="Teacher Training" title="Teacher Training"></span></a>
                            <p><a href="/schools-and-non-profits/professional-development-for-educators/">Teacher Training</a></p>
                        </li>
                        <li>
                            <a href="/schools-and-non-profits/online-content-test-assessment-portal/"><span><img src="/wp-content/uploads/2016/10/icon-49-1.png" alt="Online Platform Assessment/Analytics" title="Online Platform Assessment/Analytics"></span></a>
                            <p><a href="/schools-and-non-profits/online-content-test-assessment-portal/">Online Platform Assessment/Analytics</a></p>
                        </li>
                        <li>
                            <a href="/training-and-consulting/online-act-sat-instructional-videos/"><span><img src="/wp-content/uploads/2016/10/icon-52-1.png" alt="Online ACT/SAT Instructional Videos" title="Online ACT/SAT Instructional Videos"></span></a>
                            <p><a href="/training-and-consulting/online-act-sat-instructional-videos/">Online ACT/SAT Instructional Videos</a></p>
                        </li>
                        <li>
                            <a href="/training-and-consulting/workforce-development/"><span><img src="/wp-content/uploads/2016/10/icon-50-1.png" alt="Workforce Development" title="Workforce Development"></span></a>
                            <p><a href="/training-and-consulting/workforce-development/">Workforce Development</a></p>
                        </li>
                        <li>
                            <a href="/schools-and-non-profits/professional-development-for-educators/institutional-college-advising/"><span><img src="/wp-content/uploads/2016/07/provide_01.png" alt="Counselor Training" title="Counselor Training"></span></a>
                            <p><a href="/schools-and-non-profits/professional-development-for-educators/institutional-college-advising/">Counselor Training</a></p>
                        </li>
                                                                   
                </ul>
                <div class="w100 mrgb25 flex flex-just-cent"><a class="default-btn" href="/training-and-consulting/get-started/">Get Started</a></div>
            </div>
            <div class="clearfix"></div><!--clearfix-->
            <?php get_template_part('map'); ?>
            <?php get_template_part('testimonials');?>
            <?php
                edit_post_link(
                    sprintf(
                        __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                    ), '<span class="edit-link">', '</span>'
                );
            ?>
         </div><!--inner-page-content-->
         
    
</div><!--main-body-->
