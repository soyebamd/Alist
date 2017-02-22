<?php
class wpdevart_bc_ViewUserPermissions {
	public $model_obj;
    	
    public function __construct( $model ) {
		$this->model_obj = $model;
    }	
    public function display_permissions() {
		$pages_rows = $this->model_obj->get_pages_permissions();
		$pages_rows = json_decode($pages_rows,true);
		
        $wpdevart_pages = array(
			'calendar_page' => array(
				'id'   => 'calendar_page',
				'title' => __('Calendars','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'default' => 'publish_pages'
			),
			'reservation_page' => array(
				'id'   => 'reservation_page',
				'title' => __('Reservations','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'default' => 'publish_pages'
			),
			'form_page' => array(
				'id'   => 'form_page',
				'title' => __('Forms','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'default' => 'publish_pages'
			),
			'extra_page' => array(
				'id'   => 'extra_page',
				'title' => __('Extras','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'default' => 'publish_pages'
			),
			'theme_page' => array(
				'id'   => 'theme_page',
				'title' => __('Themes','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'default' => 'publish_pages'
			)
		);
		?>
		<div id="wpdevart_themes" class="wpdevart-list-container user-permissions">
			<div id="action-buttons" class="div-for-clear">
				<div class="div-for-clear">
					<h1><?php _e('User permissions for booking calendar pages','booking-calendar'); ?></h1>
				</div>
			</div>	
			<form action="admin.php?page=wpdevart-user-permissions" method="post" id="calendars_form">
			    <div class="wpdevart-item-section"> 
					<div class="wpdevart-item-section-cont">
					<?php
						foreach( $wpdevart_pages as $key => $wpdevart_page ) { 
							if ( !isset($pages_rows) ) {
								$sett_value = $wpdevart_page['default'];
							} else {
								$sett_value = $pages_rows[$key];
							}
							$function_name = "wpdevart_callback_" . $wpdevart_page['type'];
							wpdevart_bc_Library::$function_name($wpdevart_page, $sett_value);
						} ?>
					</div>	
				</div>
				<input type="hidden" name="task" value="save">
				<input type="submit" value="Save" class="action-link wpda-input" name="save">
			</form>
		</div>
    <?php 
	}
	 private function get_users(){
		$users = array(   
		    "manage_options" => __("Administrator",'booking-calendar'),
			"publish_pages" => __("Editor",'booking-calendar'), 	
			"publish_posts" => __("Author",'booking-calendar'), 
		    "edit_posts" => __("Contributor",'booking-calendar'),
		    "read" => __("Subscriber",'booking-calendar')
		); 
		return  $users;
	 }
 
}

?>