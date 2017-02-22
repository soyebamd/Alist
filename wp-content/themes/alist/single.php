<?php  
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); 
$post_type = get_post_type($post);
?>

<div class="main-body">
    <div class="main-content">
    <?php
        get_template_part('sidebar');
    ?>
        <div class="inner-pages-content">
            <div class="container-content">
                <h3><?php the_title(); ?></h3>
                <?php the_content(); ?>
                <div class="clearfix"></div>
            </div><!--inner-pages-content-->
        <div class="clearfix"></div><!--clearfix-->
        </div>
        <?php if($post_type!='post'): ?>
            <?php get_template_part('map'); ?>
            <div class="clearfix"></div>
            <?php get_template_part('testimonials');?>
        <?php endif; ?>
        <br />
        <?php
            edit_post_link(
                sprintf(
                        /* translators: %s: Name of current post */
                        __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'), get_the_title()
                ), '<span class="edit-link">', '</span>'
            );
        ?>
    </div><!--inner-page-content-->
</div><!--main-body-->
<?php get_footer();  ?>
