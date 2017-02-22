<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>  
        <title><?php the_title();?></title>
        <link rel="icon" type="image/x-icon" href="<?php echo bloginfo('template_directory'); ?>/images/favicon.ico">
        <link href="<?php echo bloginfo('template_directory'); ?>/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo bloginfo('template_directory'); ?>/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo bloginfo('template_directory'); ?>/css/custom.css" rel="stylesheet">
        <?php wp_head(); ?>
        <link href="<?php echo bloginfo('template_directory'); ?>/css/ktc-app.css" rel="stylesheet">
    </head>
    <body <?php body_class(); ?>>
        <?php include_once("analyticstracking.php") ?>
        <?php
            $menu="primary";
            $color="";
            $logo="logo.png";
            $home_link=get_settings('home');
            $template = get_post_meta( $post->ID, '_wp_page_template', true );
            //james code her
            $parents = get_post_ancestors( $post->ID );
            /* Get the top Level page->ID count base 1, array base 0 so -1 */ 
            $top_parent_id = ($parents) ? $parents[count($parents)-1]: $post->ID;
            //UK
            if ($top_parent_id  === 404) {
                $menu="uk-main";
                $menu_id = 'uk-side';
                $logo="alist-uk-logo.png";
                $home_link=get_settings('home')."/uk"; 
                $testimonials['cat'] = 'Testimonial_UK';
                $testimonials['link'] = '/uk/testimonials/';
                $testimonials['class'] = 'uk_testimonials'; //why this?? --JR 
            }
            //TURKEY
            else if ( $top_parent_id === 362 ) {
                $menu="turkey-main";
                $menu_id = 'turkey-side';
                $logo="alist-turkey-logo.png";
                $home_link=get_settings('home')."/turkey";
                $testimonials['cat'] = 'Testimonial_Turkey';
                $testimonials['link'] = '/turkey/testimonials/';
                $testimonials['class'] = 'uk_testimonials'; 
            }
            //UAE
            else if ( $top_parent_id === 406) {
                $menu="uae-main";
                $menu_id = 'uae-side';
                $logo="alist-uae-logo.png";
                $home_link=get_settings('home')."/uae";
                $testimonials['cat'] = 'Testimonial_UAE';
                $testimonials['link'] = '/uae/testimonials/';
                $testimonials['class'] = 'uae_testimonials';
            }
            //CHINA 
            else if ( $top_parent_id === 411 ) {
                $menu="china-main";
                $menu_id = 'china-side';
                $logo="alist-china-logo.png";
                $home_link=get_settings('home')."/china";
                $testimonials['cat'] = 'Testimonial_China';
                $testimonials['link'] = '/china/testimonials/';
                $testimonials['class'] = 'uk_testimonials';
            }
            else if($template=="red_header_template.php"){
                $color="red-menu";
            }
        ?>
        <div class="wrapper">
        
          <header>
                <div class="topbar <?php echo $color;?>">
                    <div class="countries-select">
                        <ul>
                            <?php $i=0;
            $type = 'page';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'caller_get_posts' => 1,
                'category_name' => 'alist_country_header',
                'orderby' => 'menu_order'
            );
            $my_query = null;
            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()) : $my_query->the_post();
                   // $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page','flag');//secondary-image(OLD)
                    $image_id = MultiPostThumbnails::get_post_thumbnail_id( 'page', 'flag', $post->ID );
                // if ($feat_image) {
                        
                          ?>
                            <li><a href="<?php the_permalink(); ?>"><?php echo fly_get_attachment_image( $image_id, 'flag-crop' ); ?></a></li>
                             
                                <?php
                    //} 
                    wp_reset_query();
                endwhile;
            }
            ?>
               
                        </ul>
                    </div><!--countries-select-->
                    <div class="top-nav">
                        <div class="nav-content">
                            <ul class="topnav-link">
                               <?php
                                if ( has_nav_menu( 'top-menu' ) ):
                                $args = array(
                                    'theme_location' => 'top-menu',
                                 );
                                 wp_nav_menu($args);
                             endif;
                                ?>  
                           
                            </ul>
                            <ul class="myaccount-ul">
                              <?php
                                    if ('yes' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
                                    if ( is_user_logged_in()){
                                        echo '<li><a href="'.get_settings('home').'/my-account">My Account</a></li>';
                                    }else{
                                        echo '<li><a href="'.get_settings('home').'/my-account">Parent Platform</a></li>';
                                         }
                                     }
                                     ?>
                                </ul>
                             <?php get_template_part('social_links') ?>
                            
                        </div><!--nav-content-->
                    </div><!--top-nav-->
                </div><!--topbar-->
                <div class="clearfix"></div><!--clearfix-->
                <div class="mobile-nav">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="<?php echo $home_link;?>"><img src="<?php echo bloginfo('template_directory'); ?>/images/<?php echo $logo;?>" alt="A-List"></a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="navbar-menu">
                                    <?php 
                                        wp_nav_menu(array('theme_location' => $menu, 'menu_class' => '')); 
                                    ?>
                                </ul>
                                 <ul>
                               <?php
                                if ( has_nav_menu( 'top-menu' ) ):
                                $args = array(
                                    'theme_location' => 'top-menu',
                                 );
                                 wp_nav_menu($args);
                             endif;
                                ?>  
                           
                            </ul>
                                 <ul>
                              <?php
                                    if ('yes' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
                                    if ( is_user_logged_in()){
                                        echo '<li><a href="'.get_settings('home').'/my-account">My Account</a></li>';
                                    }else{
                                        echo '<li><a href="'.get_settings('home').'/my-account">Sign In</a></li>';
                                         }
                                     }
                                     ?>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div><!--mobile-nav-->

                <div class="logo-nav">
                    <div class="logo <?php echo $menu; ?>-logo"><a href="<?php echo $home_link;?>"><img src="<?php echo bloginfo('template_directory'); ?>/images/<?php echo $logo;?>" alt="A-List"></a></div><!--logo-->
                    <div class="main-menu">
                        <div class="overly-img"></div><!--overly-img-->
                        <nav class="menu">
                            <ul class="navbar-menu">
                                 <?php wp_nav_menu(array('theme_location' => $menu, 'menu_class' => '')); 
                                       ?>
                            </ul>
                        </nav>
                    </div><!--main-menu-->
                    <div class="search-box">
                        <form id="search-mobile" name="search" action="<?php echo home_url(); ?>" method="get">
                            <input type="text" placeholder="Search..." name="s">
                        <i class="fa fa-search" aria-hidden="true"></i>           
                                    </form> 
                        
                    </div><!--search-box-->
                </div><!--logo-nav-->
                <div class="clearfix"></div><!--clearfix-->
            </header>
            
            
            
            <div class="clearfix"></div><!--clearfix-->
            <?php /* <div><strong>Current template:</strong> <? php get_current_template( true ); ?></div> */ ?>
