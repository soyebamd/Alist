<?php  
/**
* Template name: US - Large Banner Image
*/


$innerBannerClass = 'full-bg-image';

get_template_part('header');

$posttags = get_the_tags(); //term_id
if ($posttags) {
    $page_name = $posttags[0]->name.'.php';
}

if ('' != locate_template($page_name) ) {
    include(locate_template($page_name));
} else {
    include(locate_template('default_page.php'));
}

get_footer();
