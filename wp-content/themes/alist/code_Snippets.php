<?php

/* * *****************Parents And Students sub pages******* */
echo '<div class="what-can-do"><ul>';
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
        $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page', 'secondary-image');

        echo '<li>
                       <a href=' . get_the_permalink() . '>
                            <div class="img-circle">
                                <div class="icon-circle">
                                    <img src=' . $feat_image . ' alt="">
                                </div>
                            </div>
                            <span>' . get_the_title() . '</span>
                        </a>
                         </li>';

        wp_reset_query();
    endwhile;
}
echo '</ul></div>';


/* * *****************School and Non Profits sub pages******* */
echo '<div class="school-instruction"><ul>';
$type = 'page';
$args = array(
    'post_type' => $type,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts' => 1,
    'category_name' => 'school_nonprofits'
);
$my_query = null;
$my_query = new WP_Query($args);
if ($my_query->have_posts()) {
    while ($my_query->have_posts()) : $my_query->the_post();
        //$feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        $feat_image = MultiPostThumbnails::get_post_thumbnail_url('page', 'secondary-image');

        echo '<li>
                                    <a href=' . get_the_permalink() . '>
                                        <div class="dev-icon"><img src=' . $feat_image . ' ></div>
                                        <strong>' . get_the_title() . '</strong>
                                    </a>
                                </li>';

        wp_reset_query();
    endwhile;
}

echo '</ul></div>';


/* * *****************Program Highlights******* */

echo "<strong>Program Highlights:</strong> 
 <ul>";

$type = 'page';
$args = array(
    'post_type' => $type,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts' => 1,
    'category_name' => 'sat_subject_tests'
);
$my_query = null;
$my_query = new WP_Query($args);
if ($my_query->have_posts()) {
    while ($my_query->have_posts()) : $my_query->the_post();
        echo '<li>
                                    <a href=' . get_the_permalink() . '>
                                        
                                        ' . get_the_title() . '
                                    </a>
                                </li>';

        wp_reset_query();
    endwhile;
}
echo "</ul>";



/* * *************Advising Services************ */
echo "<ul>";

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

        echo '<li>
                                    <a href=' . get_the_permalink() . '>
                            <img src=' . $feat_image . ' >
                            <span>' . the_title().edit_post_link(sprintf(('Edit'))) . '</span>
        
                        </a>
                    </li>';

        wp_reset_query();
    endwhile;
}

echo '</ul>';
            
?>