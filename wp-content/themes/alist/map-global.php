    <div class="alist-map">
      <?php
      $i = 0;
      $type = 'page';
      $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'caller_get_posts' => 1,
        'category_name' => 'alist_map'
        );
      $my_query = null;
      $my_query = new WP_Query($args);
      if ($my_query->have_posts()) {
        while ($my_query->have_posts()) : $my_query->the_post();
        $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        if ($feat_image) {
          ?>
          <img src="<?php echo $feat_image; ?>" alt="" class="map-img">
          <?php
        } wp_reset_query();
        endwhile;
      }
      ?>
      <div class="clearfix"></div><!--clearfix-->
      <div class="global-reach">
        <h3>Global Reach</h3>
        <ul>
          <?php
          $i = 0;
          $type = 'page';
          $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'caller_get_posts' => 1,
            'category_name' => 'alist_country'
            );
          $my_query = null;
          $my_query = new WP_Query($args);
          if ($my_query->have_posts()) {
            while ($my_query->have_posts()) : $my_query->the_post();
                        $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page', 'flag'); //secondary-image(OLD)
                        //if ($feat_image) {
                        if ($i == 0) {
                          $class = "active";
                        } else {
                          $class = "";
                        } $i++;
                        ?>
                        <li id="location__outer-wrap-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" class="<?php //echo $class; ?>"><img src="<?php echo $feat_image; ?>" alt=""><strong><?php the_title(); ?></strong></a>
                          <br><?php edit_post_link(sprintf(('Edit'))); ?>
                        </li>
                        <?php
                        //}
                        wp_reset_query();
                        endwhile;
                      }
                      ?>

                    </ul>
                    <?php if( $post->ID !== 12 ) { ?> 
                    <div class="clearfix"></div><!--clearfix-->
                    <div class="container flex flex-just-cent">
                      <a class="default-btn" href="<?php echo get_settings('home'); ?>/locations/">See All</a>
                    </div>
                    <?php } ?> 
                  </div><!--global-reach-->
                  <div class="clearfix"></div><!--clearfix-->
                </div><!--alist-map-->
