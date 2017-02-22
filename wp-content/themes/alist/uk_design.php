<?php            
            $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
            if(!$feat_image){
                $parents = get_post_ancestors( $post->ID );
                $pid = ($parents) ? $parents[count($parents)-1]: $post->ID;
                $feat_image = wp_get_attachment_url(get_post_thumbnail_id($pid));
            }
            if($feat_image){
        ?>
                <div class="clearfix"></div><!--clearfix-->
            <div class="inner-banner">
                <div class="inner-caption" style="background-image: url(<?php echo $feat_image;
                ; ?>)">
                </div><!--inner-caption-->
            </div><!--inner-banner-->
        <?php } ?>
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
        <!-- needed end -->

                   
