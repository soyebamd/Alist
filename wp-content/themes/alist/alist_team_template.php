<?php
/**
* Template name: Team Member
*/
include(locate_template('header.php'));
$category = get_the_category();
$firstCategory = $category[0]->cat_name;
?>
<div class="main-body">
    <div class="main-content">
        <?php include(locate_template('sidebar.php'));?>
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

            <div class="container container-content ">
                <div class="team-box">
                    <h3 style="text-align:left; width:;"><?php the_title();?></h3>
                    <div class="team-img">
                        <?php  
                           $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'team_thumb');
                        ?>
                        <img src="<?php if($feat_image[0]){ echo $feat_image[0];} else {echo bloginfo('template_directory'); ?>/images/map-pin.png <?php }?>" alt=""> 
                    </div><!--team-img-->
                    <div class="team-content">
                        <p><?php the_content();?></p>
                    </div>
                </div><!--team-content-->

            </div><!--team-box-->
          <div class="clearfix"></div><!--clearfix-->
        </div>
            <?php //get_template_part('map');?>
            <?php include(locate_template('testimonials.php')); ?>
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