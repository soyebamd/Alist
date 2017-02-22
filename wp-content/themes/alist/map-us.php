<div class="location-map-us__outer-wrap">
  <div class="location-map-us__inner-wrap utility__rel-container">
    <img src="<?php echo bloginfo('template_directory'); ?>/images/us-locations-state-map.png" alt="" style="width:100%;">
    <?php if( $post->ID !== 6641 ) { ?>
    <div class="us-location-btn">
      <a href="<?php echo get_settings('home'); ?>/locations/usa/" class="default-btn">See All Locations</a>
    </div>
    <?php } ?>
  </div>
  <?php if( $post->ID !== 6641 ) { ?>
  <div class="location-map-us__meta-wrap container-outer-wrap">
    <div class="container">
      <p>Interested in any of A-List’s Training & Consulting offerings? Complete our Get Started Form to provide us with more information about your school/organization. An A-List representative will be in touch about getting started.</p>
      <div class="w100 mrg25 flex flex-just-cent"><a href="<?php echo get_settings('home'); ?>/training-and-consulting/get-started/" class="default-btn">Get Started</a></div>
    </div>
  </div>
  <?php } ?>
</div>