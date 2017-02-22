<?php
$menu_options = get_page_options($post->ID);
$map = $menu_options->hide_map;
if ($map == 0) {

    //Display US Map
    $display_us_map = [10,16,6641]; //Hack for NOW USING PAGE IDs
    if ( in_array($post->ID, $display_us_map) ) {
        //INCLUDE THIS INSTEAD OF LOOP? -- JR
    	get_template_part('map-us'); 
    }
    else {
    	get_template_part('map-global');
    }
  }