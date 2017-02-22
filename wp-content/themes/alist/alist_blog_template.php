<?php
/**
* Template name: Blog Page
*/
get_template_part('header');
?>
<div class="main-body">
    <div class="main-content">
        
        <div class="inner-page-content full-width">

        <div class="inner-pages-content full-width container-outer-wrap">
            <div class="test-subject blog container">
                <h3><?php the_title(); ?></h3>
                <?php the_content(); ?>
                <div class="clearfix"></div><!--clearfix-->
                <?php
                    query_posts('orderby=date&order=DESC&post_type=post&post_status=publish&posts_per_page=10&paged='. get_query_var('paged'));
                ?>
                <?php if( have_posts() ): ?>
                    <?php while( have_posts() ): the_post(); ?>
                        <div id="post-<?php get_the_ID(); ?>" <?php post_class(); ?> >
                            <div class="postLeft" >
                                <a href="<?php the_permalink(); ?>">
                                    <?php if ( has_post_thumbnail() ) { ?>
                                       <?php the_post_thumbnail( array(200,220) ); ?>
                                    <?php } else {
                                        $pageContent = get_the_content();
                                        if( strpos( $pageContent, '<img ' ) ){
                                            $regex = '/src="([^"]*)"/';
                                            preg_match_all( $regex, $pageContent, $matches );
                                            $matches = array_reverse($matches);
                                            $imageUrl = $matches[0][0];

                                        } else {
                                            $imageUrl = get_template_directory_uri() . '/images/default-featured-image.jpg';
                                        }
                                    ?>
                                        <img src="<?php echo $imageUrl; ?>" alt="<?php the_title(); ?>" />
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
                <?php else: ?>
                    <div id="post-404" class="noposts">
                            <p><?php _e('Posts are not found.','example'); ?></p>
                    </div><!-- /#post-404 -->
                <?php endif; wp_reset_query(); ?>
            </div>  
        </div>
    </div><!--main-body-->
<?php get_footer(); ?>
