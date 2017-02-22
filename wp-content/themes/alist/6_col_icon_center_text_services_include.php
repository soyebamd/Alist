<div class="service-include services-include__25w">
    <h2>Services Include</h2>
    <ul>
        <?php
        $type = 'page';
        $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1,
        'category_name' => 'advising_services'
        );
        $my_query = null;
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
        while ($my_query->have_posts()) : $my_query->the_post();
        $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        $imgURL = MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'secondary-image', NULL, 'large');
        ?>
        <li>
            <a href="<?php the_permalink();?>">
                <img src="<?php echo $imgURL; ?>" alt="">
                <span><?php the_title(); edit_post_link(sprintf(('Edit')));?></span>
            </a>
        </li>
        <?php
                wp_reset_query();
            endwhile;
        }
        ?>
    </ul>
    <a href="<?php get_settings('home'); ?>/parents-and-students/get-started/" class="default-btn">Get Started</a>
</div><!--service-include-->
<div class="clearfix"></div><!--clearfix-->