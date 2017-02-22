<?php
class wpdevart_bc_ControllerUserPermissions {
	private $model;
	private $view;
	  
	public function __construct() {
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/UserPermissions.php");
		$this->model = new wpdevart_bc_ModelUserPermissions();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/views/UserPermissions.php");
		$this->view = new wpdevart_bc_ViewUserPermissions($this->model);
	}  	
	  
	public function perform() {
		$task = wpdevart_bc_Library::get_value('task');
		$id = wpdevart_bc_Library::get_value('id', 0);
		$action = wpdevart_bc_Library::get_value('action');
		if (method_exists($this, $task)) {
		  $this->$task($id);
		}
		else {
		  $this->display_permissions();
		}
	}
	  
	  
	private function display_permissions(){
		$this->view->display_permissions();
	}
	  	  
	private function save( $id ){
		$permissions = json_encode($_POST);
		$option_name = 'wpdevart_permissions' ;

		if ( get_option( $option_name ) !== false ) {
			update_option( $option_name, $permissions );
		} else {
			$deprecated = null;
			$autoload = 'no';
			add_option( $option_name, $permissions, $deprecated, $autoload );
		}
		$this->view->display_permissions();
	}
 
}

?>