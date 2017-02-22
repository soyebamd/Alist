<?php
$page_template = get_page_template_slug();
$testimonials['class'] = 'testimonials';


if ( !isset($testimonials['cat']) ) {

    if($page_template=="alist_parents_students_template.php"){
        $testimonials['cat'] = 'testimonial_parent_students';
        $testimonials['link'] = '/parents-and-students/testimonials/';
    } else if($page_template=="alist_schools_template.php"){
        $testimonials['cat'] = 'testimonial_school_nonprofits';
        $testimonials['link'] = '/schools-and-non-profits/testimonials/';
    } else if($page_template=="alist_training_template.php"){
        $testimonials['cat'] = 'testimonial_training_consulting';
        $testimonials['link'] = '/schools-and-non-profits/testimonials/';
    } else if($page_template=="alist_common_template.php"){
       $testimonials['cat'] = 'testimonial_location';
       $cat_id  = get_cat_ID( $testimonials['cat'] );
       if (get_category($cat_id)->category_count == 0){
           $testimonials['cat'] = 'testimonial_parent_students';
       }
       $testimonials['link'] = '/success-stories/';
    } else if( $page_template=="alist_uk_template.php" ) {
       $testimonials['cat'] = 'Testimonial_UK';
       $testimonials['link'] = '/uk/testimonials/';
       $testimonials['class'] = 'uk_testimonials'; //why this?? --JR
    } else if( $page_template=="alist_uae_template.php" ) {
       $testimonials['cat'] = 'Testimonial_UAE';
       $testimonials['link'] = '/uae/testimonials/';
       $testimonials['class'] = 'uk_testimonials';
    } else if( $page_template=="alist_china_template.php" ) {
       $testimonials['cat'] = 'Testimonial_China';
       $testimonials['link'] = '/china/testimonials/';
       $testimonials['class'] = 'uk_testimonials';
    } else if( $page_template=="alist_turkey_template.php" ) {
       $testimonials['cat'] = 'Testimonial_Turkey';
       $testimonials['link'] = '/turkey/testimonials/';
       $testimonials['class'] = 'uk_testimonials';
    } else{
        $testimonials['cat'] = 'testimonial_parent_students';
        $testimonials['link'] = '/success-stories/';
    }
}

$page_id = get_queried_object_id();
$menu_options= get_page_options($page_id);
$testimonial= $menu_options->hide_testimonial;
if($testimonial==0 && !empty($testimonials['cat']) ){
?>
<div class="client-testimonials">
<div id="testimonials-slider" class="carousel slide" data-ride="carousel">
    <!-- Wrapper for slides -->   
    <div class="container">
        <div class="row">
            <div class="carousel-inner" role="listbox">
               <?php $s=0;
                $type = 'testimonials';
                $args = array(
                    'post_type' => $type,
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'caller_get_posts' => 1,
                    'category_name' => $testimonials['cat'],
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
                                <div class="testimonials-content <?php echo $testimonials['class']; ?>">
                                    <h3><?php the_title(); ?></h3>
                                    <?php the_content();?>
                                    <?php edit_post_link(sprintf(('Edit')));?>
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
            
    <ol class="carousel-indicators <?php echo $testimonials['class']; ?>">
        <?php  $s=0;
        $type = 'testimonials';
        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'caller_get_posts' => 1,
            'category_name' => $testimonials['cat'],
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
    <div class="w100 mrgb25 flex flex-just-cent">
        <a href="<?php echo $testimonials['link'] ?>" class="default-btn">See All Success Stories</a>
    </div>
</div><!--client-testimonials-->
<?php } ?>
