<?php
    $menu_options= get_page_options($post->ID);
    $page_template = get_page_template_slug();
    $sidebar= $menu_options->hide_sidebar;
    $post_type = get_post_type($post);


    if ($sidebar==0 && !is_cart() && !is_checkout()){
         $side_class="";
?>


                <div class="sidebar-nav scrollbar-inner">
        <div class="sidebar-toggle">
            <a href="javascript:void(0);"><span>Sidebar Menu</span><i class="glyphicon glyphicon-menu-down"></i></a>
        </div><!--sidebar-toggle-->
        <?php if ( !isset($menu_id) ) {
                if($page_template=="alist_parents_students_template.php"){
                    $menu_id = 'parents-menu';
                } else if($page_template=="alist_team_template.php"){
                    $menu_id = 'parents-menu';
                } else if($page_template=="alist_schools_template.php"){
                    $menu_id = 'schools-menu';
                } else if($page_template=="alist_training_template.php"){
                    $menu_id = 'traning-menu';
                } else if($page_template=="alist_uk_template.php"){
                    $menu_id = 'uk-side';
                }
                else if($page_template=="alist_turkey_template.php"){
                    $menu_id = 'turkey-side';
                }
                else if($page_template=="alist_uae_template.php"){
                    $menu_id = 'uae-side';
                }
                else if($page_template=="alist_china_template.php"){
                    $menu_id = 'china-side';
                }
                else if(is_single() && $post_type=='post' || is_tag() || is_category() ){
                    global $wpdb;
                    
                    $taxonomyToFind = 'category';
                    $query = "SELECT wp_terms.term_id
                    FROM  `wp_terms` 
                    INNER JOIN wp_term_taxonomy tax ON tax.term_id = wp_terms.term_id
                    INNER JOIN wp_term_relationships rel ON rel.term_taxonomy_id=tax.term_taxonomy_id
                    INNER JOIN wp_posts posts ON posts.ID=rel.object_id
                    WHERE tax.taxonomy='".$taxonomyToFind."' AND posts.post_type='post' AND posts.post_status='publish'
                    GROUP BY wp_terms.term_id";
                    $tag_idz = $wpdb->get_results($query);
                    if(!empty($tag_idz)){
                        $classes = 'menu-item menu-item-type-post_type';
                        echo '<h4>Categories</h4>';
                        echo '<ul class="termsList categories-list">';
                        foreach ($tag_idz as $key => $tagId) {
                            $link = get_category_link( $tagId->term_id );
                            $tag = get_term_by('id', $tagId->term_id, 'post_tag');
                            echo '<li class="'.$classes.'"><a href="'.$link.'">'.$tag->name.'</a></li>';
                        }
                        echo '</ul>';
                    }
                    
                    $taxonomyToFind = 'post_tag';
                    $query = "SELECT wp_terms.term_id
                    FROM  `wp_terms` 
                    INNER JOIN wp_term_taxonomy tax ON tax.term_id = wp_terms.term_id
                    INNER JOIN wp_term_relationships rel ON rel.term_taxonomy_id=tax.term_taxonomy_id
                    INNER JOIN wp_posts posts ON posts.ID=rel.object_id
                    WHERE tax.taxonomy='".$taxonomyToFind."' AND posts.post_type='post' AND posts.post_status='publish'
                    GROUP BY wp_terms.term_id";
                    
                    $tag_idz = $wpdb->get_results($query);
                    if(!empty($tag_idz)){
                        $classes = 'menu-item menu-item-type-post_type';
                        echo '<h4>Topics</h4>';
                        echo '<ul class="termsList tags-list">';
                        foreach ($tag_idz as $key => $tagId) {
                            $link = get_tag_link( $tagId->term_id );
                            $tag = get_term_by('id', $tagId->term_id, 'post_tag');
                            echo '<li class="'.$classes.'"><a href="'.$link.'">'.$tag->name.'</a></li>';
                        }
                        echo '</ul>';
                    }
                    
                }  else{
                    $menu_id = 'side-menu';
                }
                }
                
                if (has_nav_menu($menu_id)):
                    $args = array( 'theme_location' => $menu_id );
                    wp_nav_menu($args);
                endif;
                if( $menu_id == 'uk-side'){
                    ?>
                    <div class="partner-programs">
                        <p>A-List UK is a proud partner of:</p>
                        <img src="<?php echo bloginfo('template_directory'); ?>/images/uk_product0.png" alt="Partner Program" title="Partner Program" />
                        <img src="<?php echo bloginfo('template_directory'); ?>/images/uk_product1.png" alt="Partner Program" title="Partner Program" />
                    </div>
                    <?php
                }
                
            ?>
    </div><!--sidebar-nav-->


    <?php /* FUCK THIS IS DANGEROUS */ ?>
    <div class="inner-page-content">
    <?php } else { ?>
        <div class="inner-page-content full-width">
    <?php } ?>

        

        
        
