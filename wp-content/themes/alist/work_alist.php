<style>
.container {
  width: 100% !important;
}
.jobs-container div li{
  background: none !important;
  list-style-type: initial !important;
  margin-bottom: 1% !important;
}
.jobs-container div li:before{
  content: "";
  display: inline-block !important;
  height: 1rem !important;
  width: .5rem !important; 
  margin-right: -3% !important;
}
.jobs-container div{
  padding-left: 8% !important;
  padding-right: 8% !important;
}
.utility__center-text{
  padding: 0 5% !important;
  font-size: 13px !important;
  margin: 2% !important;
  line-height: 1.5 !important;
}
.isee-ssat-content ul {
  float: none !important;
}
.isee-ssat-content p {
  margin: 15px auto 0px !important;
}
.isee-ssat-content h5 {
  margin: 2% auto 0px !important;
}
.jobs-container p {
  font-size: 13px !important;
}
.jobs-container div ul li {
  font-size: 13px !important;
  line-height: 1.3 !important;
}
</style>
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
                <div class="inner-caption" style="background-image: url(<?php echo $feat_image; ?>)">
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

                  <?php the_content(); ?>




 <!-- /////////////////////////////////////////////////////////////////////////////////// -->
                <h5 class="utility__center-text red">Available Positions</h5>
                 <ul class="list-style-block-icon">
                    <?php query_posts('category_name="alist-jobs"'. '&order=DEC'); ?>
                    <?php if ( have_posts() ) :while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
                    <!-- Get slug for the anchor tag but title OK for <p> Tag  -->
                      <li>
                        <a href="#<?php echo $post->post_name;
                          ?>"><p><strong><?php the_title(); ?></strong></p></a>
                      </li>

                    <?php
                    endwhile; endif; //resetting the page loop
                    wp_reset_query(); //resetting the page query
                    ?>
                  </ul>
                <div class="isee-ssat-content container">
                  <div class="jobs-container">
                        <?php query_posts('category_name="alist-jobs"'. '&order=DEC'); ?>
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <div id="<?php echo $post->post_name ?>">
                          <h5 class="red"><?php the_title(); ?></h5>
                          <?php the_content(); ?>
                        </div>

                        <?php endwhile; endif; ?>



                        <?php
                            wp_reset_query();
                        ?>
                  </div>
                </div>
        <!-- ////////////////////z///////////////////////////////// -->
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
              </div>
          </div><!--inner-pages-content-->
        <div class="clearfix"></div><!--clearfix-->
    </div><!--main-content-->
</div><!--main-body-->
<?php get_footer(); ?>
