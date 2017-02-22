<?php get_template_part('header'); ?>
<div class="main-body">
    <div class="main-content">
        <?php get_template_part('sidebar'); ?>
        <div class="inner-pages-content">
            <div class="test-subject">
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
                        <div class="navigation">
                            <span class="newer">
                                <?php previous_posts_link(__('« Previous','example')) ?>
                            </span>
                            <span class="older"><?php next_posts_link(__('Next »','example')) ?></span>
                        </div><!-- /.navigation -->
                    <?php endif; ?>
                <?php else: ?>
                    <p>Sorry, no posts matched your criteria.</p>
                <?php endif; wp_reset_query(); ?>
                
            </div>  
        </div>
    </div><!--main-body-->
<?php get_footer(); ?>
