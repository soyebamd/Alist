
<div class="clearfix"></div><!--clearfix-->
            <footer>
                <div class="footer-content">
                    <div class="footer-logo"><img alt="" src="<?php echo bloginfo('template_directory'); ?>/images/logo.png"></div><!--footer-logo-->
                    <div class="footer-nav">
                       
                           <?php
                                if ( has_nav_menu( 'footer-menu' ) ):
                                $args = array(
                                    'theme_location' => 'footer-menu',
                                 );
                                 wp_nav_menu($args);
                             endif;
                                ?>   
                       
                       
                            <?php
                                if ( has_nav_menu( 'top-menu' ) ):
                                $args = array(
                                    'theme_location' => 'top-menu',
                                 );
                                 wp_nav_menu($args);
                             endif;
                                ?>
                       
                            <?php
                                if ( has_nav_menu( 'cms-menu' ) ):
                                $args = array(
                                    'theme_location' => 'cms-menu',
                                 );
                                 wp_nav_menu($args);
                             endif;
                                ?>      
                    </div><!--footer-nav-->
                    <div class="newsletter-form">
<!--                        <h5>Stay Up To Date</h5>-->
                        <div class="newsletter-filed">
                            <?php
                            if (is_active_sidebar('newsletter-1')) {
                                dynamic_sidebar('newsletter-1');
                            }
                            ?>
                            <form style=" display:  none;">
                                <input type="text" placeholder="Enter your email...">
                                <button>SUBMIT</button>
                            </form>
                        </div><!--newsletter-filed-->
                        <ul>
                            <li><a href="https://www.facebook.com/AListEducation" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com/AListEduNY" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.facebook.com/AListEducation" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.linkedin.com/company/a-list-education/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.youtube.com/user/TheAListEducation" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                        </ul>
                    </div><!--newsletter-form-->
                </div><!--footer-content-->            
                <div class="clearfix"></div><!--clearfix-->
                <div class="copyright-text">
                    <p>&copy; A-List Education <?php echo date('Y');?></p>
                </div><!--copyright-text-->
                <div class="clearfix"></div><!--clearfix-->
            </footer>

        </div><!--wrapper-->

        <link href="<?php echo bloginfo('template_directory'); ?>/css/custom.css" rel="stylesheet">
        <script src="<?php echo bloginfo('template_directory'); ?>/js/jquery.min.js"></script>
        <script src="<?php echo bloginfo('template_directory'); ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo bloginfo('template_directory'); ?>/js/custom.js"></script>
        <script src="<?php echo bloginfo('template_directory'); ?>/js/owl.carousel.js"></script>

<!-- begin SnapEngage code -->
<script type="text/javascript">
  (function() {
    var se = document.createElement('script'); se.type = 'text/javascript'; se.async = true;
    se.src = '//storage.googleapis.com/code.snapengage.com/js/a899c1b8-a1cb-44db-8b02-9d3ad9f1c674.js';
    var done = false;
    se.onload = se.onreadystatechange = function() {
      if (!done&&(!this.readyState||this.readyState==='loaded'||this.readyState==='complete')) {
        done = true;
        /* Place your SnapEngage JS API code below */
        /* SnapEngage.allowChatSound(true); Example JS API: Enable sounds for Visitors. */
      }
    };
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(se, s);
  })();
</script>
<!-- end SnapEngage code -->
<!--<script>
    
          // clicking on anchor element inside li
$('li a').click(function () {
   // remove existing active class inside li elements
   $('li.menu-item').removeClass('active');
  // add class to current clicked element
   $(this).closest('li.menu-item').addClass('active');
});  
            
          </script>  -->
<!-- end SnapEngage code -->
<?php wp_footer(); ?>
</body>
</html>