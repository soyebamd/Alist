<?php  
/**
* Template name: Typography and List
*/ 
get_template_part('header');
?>
<div class="inner-pages-content container-outer-wrap">
    <div class="container-content container">
            <h3><?php the_title(); ?></h3>
            <?php the_content(); ?>
    </div><!--inner-pages-content-->
</div>

<div class="container flex flex-just-cent">
  <h4>Template: 6_col_icon_center_text_services_include </h4>
</div>
<?php get_template_part('6_col_icon_center_text_services_include'); ?> 

<div class="container flex flex-just-cent">
  <h4>Template: 4_col_icon_center_text_what_can </h4>
</div>
<?php get_template_part('4_col_icon_center_text_what_can'); ?> 

<?php
get_footer();

?>