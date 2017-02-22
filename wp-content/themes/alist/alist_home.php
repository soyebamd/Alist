<div class="main-body">
    <div class="home-banner">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            
  <ol class="carousel-indicators">
      <?php
            $s = 0;
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => 'banner'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                if ($s == 0) {
                            $class = "active";
                        } else {
                            $class = "";
                        }
                ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?php echo $s;?>" class="<?php echo $class;?>"></li>
                <?php 
                     $s++;
                     wp_reset_query();
                endwhile;
            }
            ?>              
  </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php
            $s = 0;
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => 'banner'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                    if ($feat_image) {
                        if ($s == 0) {
                            $class = "active";
                        } else {
                            $class = "";
                        } $s++;
                        $view_link = get_post_custom_values("home slider link", $post->ID);
                        ?>
          
                
              <div class="item <?php echo $class; ?>">
                                <div class="home-carousel">
                                    <div class="slider-img"><img src="<?php echo $feat_image; ?>"></div>
                                    <div class="carousel-caption">
                                        <h1><?php the_title();?></h1>
                                        <span><?php the_content();?></span>
                                        <?php edit_post_link(sprintf(('Edit')));?>
                                        <a href="<?php echo $view_link[0];?>" class="default-btn">LEARN MORE</a>
                                    </div>
                                </div>
                            </div>  
               <?php
                    } wp_reset_query();
                endwhile;
            }
            ?>
                
            </div><!--carousel-inner-->                   
        </div><!--carousel slide-->
    </div><!--home-banner-->
    <div class="clearfix"></div><!--clearfix-->
    <div class="container">
        <div class="row">
            <?php the_content(); ?>
        </div><!--row-->
    </div><!--container-->
    <div class="clearfix"></div><!--clearfix-->
    <?php get_template_part('map'); ?>
    <div class="alist-assessment">
        <div class="container">
            <?php
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => 'proprietary_content'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                             ?>
            <div class="row">
                <div class="col-lg-8 col-sm-8 no-padding">
                    
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?>   
                     <br><?php edit_post_link(sprintf(('Edit')));?>
                </div><!--col-lg-8 col-sm-8-->
                <div class="col-lg-4 col-sm-4 no-padding">
                    <img src="<?php echo $feat_image; ?>" alt="" class="img-responsive">
                </div><!--col-lg-4 col-sm-4-->
                <div class="clearfix"></div><!--clearfix-->
                <a class="default-btn" href="/schools-and-non-profits/online-content-test-assessment-portal/">Learn More</a>
            <?php
                    wp_reset_query();
                endwhile;
            }
            ?>
            </div><!--row-->
        </div><!--container-->
    </div><!--alist-assessment-->
    <div class="clearfix"></div><!--clearfix-->
    <div class="exceptional-educators">
        <div class="container">
            <div class="row">
                <h3>Exceptional Educators</h3>
                <ul>
            <?php
            $type = 'page';
            $homeCatObj = get_category_by_slug( 'home-page-team' );
            $teamCatObj = get_category_by_slug( 'except_educators' );
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'orderby' => 'post_title',
                'category__and' =>  array( $homeCatObj->term_id, $teamCatObj->term_id )
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    //$feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                    $feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'team_thumb');
         
                    ?>
                    <li>
                        <a href="<?php the_permalink();?>">
                            <img src="<?php if($feat_image[0]){ echo $feat_image[0];} else {echo bloginfo('template_directory'); ?>/images/map-pin.png <?php }?>" alt="">  
                            <label><?php the_title(); ?></label>
                        </a>
                        <br><?php edit_post_link(sprintf(('Edit')));?>
                    </li>
                    <?php
                    wp_reset_query();
                endwhile;
            }
            ?>
                    
                </ul>
                <a href="<?php echo get_settings('home'); ?>/meet-our-team/" class="default-btn">See All</a>
            </div><!--row-->
        </div><!--container-->
    </div><!--exceptional-educators-->
    <div class="clearfix"></div><!--clearfix-->
    <div class="outstanding-results">
        <div class="container">
            <?php
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => 'outstanding_results'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
//                    $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                    $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page','secondary-image');
                             ?>
            <div class="row">
                <div class="outstanding-heading">
                    
                    <h3><?php the_title();?></h3>
                    <br><?php edit_post_link(sprintf(('Edit')));?>
                    <?php the_content();?>
                </div><!--outstanding-heading-->
                <div class="clearfix"></div><!--clearfix-->
                <div class="result-status">
                    <img src="<?php echo $feat_image; ?>" alt="" class="img-responsive" class="utility__hide-on-mobile">
                    <img src="/wp-content/themes/alist/images/mobile_index_results.jpg" alt="" class="utility__hide-on-desktop">
                    <div class="clearfix"></div><!--clearfix-->
                </div><!--result-status-->
            </div><!--row-->
            <?php
                    wp_reset_query();
                endwhile;
            }
            ?>
        </div><!--container-->
    </div><!--outstanding-results-->
    <div class="clearfix"></div><!--clearfix-->
    <?php get_template_part('testimonials');?>
    <div class="clearfix"></div><!--clearfix-->
    
    <div class="featured-on">
                    <div class="container">
                        <div class="row">
                            <h3>Featured On</h3>
                            <ul>
                                <?php
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => 'featured_on'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                             ?>
                                <li><a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $feat_image; ?>" alt="">
                        </a>
                        <br><?php edit_post_link(sprintf(('Edit')));?>
                        </li>
                   
                   <?php
                    wp_reset_query();
                endwhile;
            }
            ?>   </ul>


                            <div id="owl-demo" class="owl-carousel">
                                <?php
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => 'featured_on'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                    $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                             ?>
                           <div class="item"><img src="<?php echo $feat_image;?>" alt=""></div>
                            <?php
                    wp_reset_query();
                endwhile;
            }
            ?>    
                            <?php
                             edit_post_link(
                                        sprintf(
                                                /* translators: %s: Name of current post */
                                                __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                                        ), '<span class="edit-link">', '</span>'
                                );
                                ?>
                            </div><!--owl-demo-->



                        </div><!--row--> 
                        
                    </div><!--container-->
                </div><!--featured-on-->
    
</div><!--main-body-->
