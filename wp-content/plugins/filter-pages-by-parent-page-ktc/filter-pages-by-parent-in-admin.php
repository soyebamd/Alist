<?php
/*
Plugin Name: Filter Pages By Parent Page in Admin Side
Plugin URI: http://kingtidecreative.com/
Description: This plugin enables a user to filter pages w.r.t. parent page in admin area.
Version: 1.0
Author: KingTide
Author URI: http://kingtidecreative.com/
*/


class ES_page_filter {

    public function __construct(){
        add_action('restrict_manage_posts',array($this, 'filter_by_parent_in_admin'));
        add_filter('parse_query',array($this,'filter_the_pages'));
    }
    
    public function filter_by_parent_in_admin(){
        global $pagenow;
        
	    if ($pagenow=='edit.php' && $_GET['post_type']=='page') {
	        
	        if (isset($_GET['parentId'])) {
		        $dropdown_options = array(
		            'show_option_none' => __( 'Show only children of:' ),
		            'depth' => 1,
                            'include' => [6, 8, 10, 404, 362, 406, 411],
		            'hierarchical' => 1,
		            'post_type' => $_GET['post_type'],
		            'sort_column' => 'name',
		            'selected' => $_GET['parentId'],
		            'name' => 'parentId'
		        );
	        } else {
		        $dropdown_options = array(
		            'show_option_none' => __( 'Show only children of:' ),
		            'depth' => 1,
                            'include' => [6, 8, 10, 404, 362, 406, 411],
		            'hierarchical' => 1,
		            'post_type' => $_GET['post_type'],
		            'sort_column' => 'name',
		            'name' => 'parentId'
		        );
	        }
	        
	        wp_dropdown_pages( $dropdown_options );   
        }
    } //END METHOD filter_by_parent_in_admin
    
    public function filter_the_pages($query) {
    
        if (isset($_GET['parentId'])) {
	        global $pagenow;
    
	        $childPages = get_pages(
	            array(
	                'child_of' => $_GET['parentId'],
	                'post_status' => array('publish','draft','trash')
	                )
	             );
	        
	        $filteredPages = array($_GET['parentId']);
	        
	        foreach($childPages as $cp){
	        	array_push($filteredPages, $cp->ID);
	        }
	        
	        $qv = &$query->query_vars;
	        if ($pagenow=='edit.php' && $qv['post_type']=='page') {
	            $qv['post__in'] = $filteredPages;
	        }
        
        }
    
    } //END METHOD filter_the_pages
    
} //END CLASS

if(is_post_type_hierarchical($_GET['post_type'])){
    $es_page_filter = new ES_page_filter();
}
