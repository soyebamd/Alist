<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?>
<?php get_template_part('header'); ?>
<div class="main-body">
    <div class="main-content">
        <?php get_template_part('sidebar'); ?>
        <div class="inner-pages-content">
            <div class="test-subject">
                <?php if ( have_posts() ) : ?>
                    <header class="archive-header">
                        <h2 class="archive-title">Tag: <?php single_tag_title(); ?></h2>
                        <?php if ( tag_description() ) : ?>
                            <div class="archive-meta"><?php echo tag_description(); ?></div>
                        <?php endif; ?>
                    </header>
                    <?php while( have_posts() ): the_post(); ?>
                        <div id="post-<?php get_the_ID(); ?>" <?php post_class(); ?> >
                            <div class="postLeft" >
                                <a href="<?php the_permalink(); ?>">
                                    <?php if ( has_post_thumbnail() ) { ?>
                                       <?php the_post_thumbnail( array(200,220) ); ?>
                                    <?php } else { ?>
                                        <img src="<?php bloginfo('template_directory'); ?>/images/default-featured-image.jpg" alt="<?php the_title(); ?>" />
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="postRight" >
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <span class="meta">
                                    <strong><?php the_time('F jS, Y'); ?></strong> / 
                                    <strong><?php the_author_link(); ?></strong> / 
                                    <span class="comments">
                                        <?php
                                            $categories = get_the_category();
                                            foreach ( $categories as $cat ):
                                        ?>
                                        <a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a>,
                                        <?php endforeach; ?>
                                    </span> / 
                                    <span class="comments"><?php comments_popup_link(__('0 comments','example'),__('1 comment','example'),__('% comments','example')); ?></span>
                                </span>
                                <?php the_excerpt('Continue reading »'); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Sorry, no posts matched your criteria.</p>
                <?php endif; ?>
            </div>  
        </div>
    </div><!--main-body-->
<?php get_footer(); ?>
