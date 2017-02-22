<div class="what-can-do what-can-do__outer-wrap">
    <h2>What Can We Do For You?</h2>
    <ul class="flex flex-wrap flex-just-spar">
        <?php
//$type = 'parents_students';
$type = 'page';        
$args = array(
    'post_type' => $type,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts' => 1,
    'category_name' => 'do_for_you'
);
$my_query = null;
$my_query = new WP_Query($args);
if ($my_query->have_posts()) {
    while ($my_query->have_posts()) : $my_query->the_post();
        //$feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page','secondary-image');

        ?>
        <li>
            <a href="<?php the_permalink(); ?>">
                <div class="img-circle">
                    <div class="icon-circle">
                        <img src="<?php echo $feat_image; ?>" alt="">
                    </div><!--icon-circle-->
                </div><!--img-circle-->
                <span><?php the_title();?></span>
            </a>
             <?php edit_post_link(sprintf(('Edit')));?>
        </li>
         <?php
        wp_reset_query();
    endwhile;
}
?>  
        
    </ul>
    <div class="clearfix"></div><!--clearfix-->
    <div class="flex flex-just-cent">
        <a href="/meet-our-team/" class="default-btn">Find A Tutor</a>
    </div>
    <div class="clearfix"></div><!--clearfix-->
</div><!--what-can-do-->
<div class="clearfix"></div><!--clearfix-->