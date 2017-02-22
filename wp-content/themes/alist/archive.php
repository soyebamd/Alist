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
                <?php query_posts('post_type=post&post_status=publish&posts_per_page=10&paged='. get_query_var('paged')); ?>
                <?php if ( have_posts() ) : ?>
                    <header class="archive-header">
                        <h2 class="archive-title"><?php single_cat_title( 'Category: ', true ); ?></h2>
                    <?php if ( category_description() ) : ?>
                        <div class="archive-meta"><?php echo category_description(); ?></div>
                    <?php endif; ?>
                    </header>
                    <?php if( have_posts() ): ?>
                        <?php while( have_posts() ): the_post(); ?>
                               <div id="post-<?php get_the_ID(); ?>" <?php post_class(); ?> >
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(200,220) ); ?></a>
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
                        <?php endwhile; ?>
                        <div class="navigation">
                            <span class="newer">
                                <?php previous_posts_link(__('« Previous','example')) ?>
                            </span>
                            <span class="older"><?php next_posts_link(__('Next »','example')) ?></span>
                        </div><!-- /.navigation -->
                    <?php endif; ?>
                <?php else: ?>
                    <p>Sorry, no posts matched your criteria.</p>
                <?php endif; ?>
                
            </div>  
        </div>
    </div><!--main-body-->
<?php get_footer(); ?>
