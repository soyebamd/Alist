<div class="main-body">
                <div class="main-content">
                     <?php get_template_part('sidebar');
                     ?>
                          <div class="inner-pages-content container-content container-outer-wrap">
                            
                            <div class="for-schools container">
                                <h3><?php //the_title(); ?></h3>
                              <?php the_content(); ?>
                        </div><!--inner-pages-content-->
                        
                        <div class="clearfix"></div><!--clearfix-->
                        
                             <?php get_template_part('testimonials');?>
                       <?php
                             edit_post_link(
                                        sprintf(
                                                /* translators: %s: Name of current post */
                                                __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                                        ), '<span class="edit-link">', '</span>'
                                );
                                ?>
                        <div class="clearfix"></div><!--clearfix-->
                        </div>
                    </div><!--inner-page-content-->
               
            </div><!--main-body-->
