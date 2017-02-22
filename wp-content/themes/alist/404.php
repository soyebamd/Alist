<head>
  <style media="screen">
    #four-container{
      margin-left: 32%;
      height: 351px;
    }
    .q-guy{
      margin-left: 16%;
    }

  </style>

</head>

<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

<div id="four-container" class="content-area">
		<div id="content" class="site-content" role="main">
   	<h3><?php _e( 'Oops! 404 Page Not Found', 'twentythirteen' ); ?></h3>
     <img class="q-guy" src="/wp-content/themes/alist/images/404-icon.png" alt="404-icon">

    			<div class="page-wrapper">
    				<div class="page-content">


    					<!-- <?php get_search_form(); ?> -->
    				</div><!-- .page-content -->
    			</div><!-- .page-wrapper -->
    		</div><!-- #content -->
    	</div><!-- #primary -->


<?php get_footer(); ?>
