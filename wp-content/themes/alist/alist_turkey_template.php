<?php  
/**
* Template name: Turkey Template
*/

get_template_part('header');

$category = get_the_category();
$firstCategory = $category[0]->cat_name;

if ($firstCategory == "alist_city") {
    get_template_part('city_page');
} else {
    $posttags = get_the_tags(); //term_id
    if ($posttags) {
        $page_name = $posttags[0]->name;
    }

    if ('' != locate_template($page_name . '.php')) {
        get_template_part($page_name);
    } else {
        get_template_part('default_uk_page');
    }
}

get_footer();

?>







