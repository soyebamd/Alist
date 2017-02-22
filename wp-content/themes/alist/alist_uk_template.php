<?php  
/**
* Template name: UK Template
*/

get_template_part('header');
//get_header();


$posttags = get_the_tags(); //term_id

if ($posttags) {
    $page_name = $posttags[0]->name;
}
 
if ('' != locate_template($page_name . '.php')) {
    get_template_part($page_name);
} else {
    get_template_part('default_uk_page');
}

get_footer();

?>







