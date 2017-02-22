<?php
class wpdevart_bc_ControllerCalendars {
	private $model;
	private $view;
	  
	public function __construct() {
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Calendars.php");
		$this->model = new wpdevart_bc_ModelCalendars();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/views/Calendars.php");
		$this->view = new wpdevart_bc_ViewCalendars($this->model);
	}  	
	  
	public function perform() {
		$task = wpdevart_bc_Library::get_value('task');
		$id = wpdevart_bc_Library::get_value('id', 0);
		$action = wpdevart_bc_Library::get_value('action');
		if (method_exists($this, $task)) {
		  $this->$task($id);
		}
		else {
		  $this->display_calendars();
		}
	}
	  
	  
	private function display_calendars(){
		$this->view->display_calendars();
	}
	  
	private function add(){
		$this->view->edit_calendars();
	}
	  
	private function edit( $id ){
		$this->view->edit_calendars( $id );
	}
	  
	private function save( $id ){
		global $wpdb; 
		$calendar_days = $this->model->get_db_days( $id );
		$ids = $this->model->get_ids($id);
		$theme_options = $this->model->get_setting_row($ids["theme_id"]);
		$start_date = (isset($_POST['start_date']) ? esc_html(stripslashes( $_POST['start_date'])) : '');
		$end_date = (isset($_POST['end_date']) ? esc_html(stripslashes( $_POST['end_date'])) : '');
		$days_availability = (isset($_POST['days_availability']) ? esc_html(stripslashes( $_POST['days_availability'])) : '');
		$number_availability = ((isset($_POST['number_availability']) && $_POST['number_availability'] != "") ? esc_html(stripslashes( $_POST['number_availability'])) : 1);
		$price = (isset($_POST['price']) ? esc_html(stripslashes( $_POST['price'])) : '');
		$marked_price = (isset($_POST['marked_price']) ? esc_html(stripslashes( $_POST['marked_price'])) : '');
		$info_users = (isset($_POST['info_users']) ? esc_html(stripslashes( $_POST['info_users'])) : '');
		$hours_info_users = (isset($_POST['hours_info_users']) ? esc_html(stripslashes( $_POST['hours_info_users'])) : '');
		$info_admin = (isset($_POST['info_admin']) ? esc_html(stripslashes( $_POST['info_admin'])) : '');
		$hours_enabled = ((isset($theme_options['hours_enabled']) && $theme_options['hours_enabled'] == 'on') ? 'on' : '');
		$hours_interval_enabled = ((isset($theme_options['hours_interval_enabled']) && $theme_options['hours_interval_enabled'] == 'on') ? 'on' : '');
		$hours = ((isset($_POST['day_hours'])) ? $_POST['day_hours'] : array());
		$hours_info = array();
		$day_av = 0; 
		if(isset($hours['hour_value']) && count($hours['hour_value'])) {
			for($i=0; $i<count($hours['hour_value']); $i++) {
				if($hours['hours_number_availability'][$i] == "") {
					$hours['hours_number_availability'][$i] = 1;
				}
				$hours_info[$hours['hour_value'][$i]] = array("status" => $hours['hours_availability'][$i], "available" => $hours['hours_number_availability'][$i], "info_users" => $hours['hour_info'][$i], "price" => $hours['hour_price'][$i], "marked_price" => $hours['hours_marked_price'][$i]);
				if($hours['hours_availability'][$i] == "available") {
					$day_av += $hours['hours_number_availability'][$i];
				}
			}
		} 
		
		if($hours_enabled == "on") {
			$day_info = array( "status" => $days_availability, "available" => $day_av, "info_users" => $info_users, "info_admin" => $info_admin, "price" => "hours_price", "marked_price" => "hours_marked_price", "hours_enabled" => "on",  "hours_interval_enabled" => $hours_interval_enabled, "hours" => $hours_info);
		} else {
			$day_info = array( "status" => $days_availability, "available" => $number_availability, "info_users" => $info_users, "info_admin" => $info_admin, "price" => $price, "marked_price" => $marked_price );
		}
		$day_info_jsone = json_encode($day_info);
		
		$title = (isset($_POST['title']) ? esc_html(stripslashes( $_POST['title'])) : '');
		$theme_id = (isset($_POST['theme_id']) ? esc_html(stripslashes( $_POST['theme_id'])) : '');
		$form_id = (isset($_POST['form_id']) ? esc_html(stripslashes( $_POST['form_id'])) : '');
		$extra_id = (isset($_POST['extra_id']) ? esc_html(stripslashes( $_POST['extra_id'])) : '');
		
		if ($id != 0) {
			 $save = $wpdb->update($wpdb->prefix . 'wpdevart_calendars', array(
				'user_id' => 1,
				'title' => $title,
				'hours_enabled' => $hours_enabled,
				'hours_interval_enabled' => $hours_interval_enabled,
				'theme_id' => $theme_id,
				'form_id' => $form_id,
				'extra_id' => $extra_id
			 ), array('id' => $id));
		  
		}
		else {
			$save = $wpdb->insert($wpdb->prefix . 'wpdevart_calendars', array(
				'user_id' => 1,                       
				'title' => $title,                       
				'hours_enabled' => $hours_enabled,         
				'hours_interval_enabled' => $hours_interval_enabled,         
				'theme_id' => $theme_id,         
				'form_id' => $form_id,      
				'extra_id' => $extra_id         
			), array(
				'%d',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%d'
			));
			$id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wpdevart_calendars');
		}
		
		$date_diff = abs($this->get_date_diff($start_date,$end_date));
		if($date_diff > 0) {
			for($i=0; $i <= $date_diff; $i++) {
				$day = date( 'Y-m-d', strtotime($start_date. " +" . $i . " day" ));
				$week_day = date('w', strtotime($start_date. " +" . $i . " day" ));
				$exists = 0;
				foreach($calendar_days as $calendar_day) {
					if(in_array($id . "_" . $day,$calendar_day)) {
						$exists = 1;
						break;
					}
				}
				if(!(isset($theme_options['unavailable_week_days']) && in_array($week_day,$theme_options['unavailable_week_days']))) {
					if($exists) {
						if($number_availability == 0 || ($hours_enabled == "on" && $day_av == 0)) {
							$wpdb->query( 
								$wpdb->prepare( "DELETE FROM ".$wpdb->prefix . "wpdevart_dates WHERE unique_id = %s", $id . "_" . $day )
							);
						} else {
							$update_in_db = $wpdb->update($wpdb->prefix . 'wpdevart_dates', array(
								'calendar_id' => $id,
								'day' => $day,
								'data' => $day_info_jsone,
							  ), array('unique_id' => $id . "_" . $day));					
						}
					}
					else {
						if(!($number_availability == 0 || ($hours_enabled == "on" && $day_av == 0))) {
							$save_in_db = $wpdb->insert($wpdb->prefix . 'wpdevart_dates', array(
								'unique_id' => $id . "_" . $day,                       
								'calendar_id' => $id,         
								'day' => $day,         
								'data' => $day_info_jsone,         
							  ), array(
								'%s',
								'%d',
								'%s',
								'%s',
							  ));
						}
					}
				}
			}
		} elseif($date_diff == 0 && $start_date){
			$day = date( 'Y-m-d', strtotime($start_date));
			$week_day = date('w', strtotime($start_date));
			$exists = 0;
			foreach($calendar_days as $calendar_day) {
				if(in_array($id . "_" . $day,$calendar_day)) {
					$exists = 1;
					break;
				}
			}
			if(!(isset($theme_options['unavailable_week_days']) && in_array($week_day,$theme_options['unavailable_week_days']))) {
				if($exists) {
					if($number_availability == 0 || ($hours_enabled == "on" && $day_av == 0)) {
						$wpdb->query( 
							$wpdb->prepare( "DELETE FROM ".$wpdb->prefix . "wpdevart_dates WHERE unique_id = %s", $id . "_" . $day )
						);
					} else {
						$update_in_db = $wpdb->update($wpdb->prefix . 'wpdevart_dates', array(
							'calendar_id' => $id,
							'day' => $day,
							'data' => $day_info_jsone,
						  ), array('unique_id' => $id . "_" . $day));
					}
				}
				else {
					if(!($number_availability == 0 || ($hours_enabled == "on" && $day_av == 0))) {
						$save_in_db = $wpdb->insert($wpdb->prefix . 'wpdevart_dates', array(
							'unique_id' => $id . "_" . $day,                       
							'calendar_id' => $id,         
							'day' => $day,         
							'data' => $day_info_jsone,         
						  ), array(
							'%s',
							'%d',
							'%s',
							'%s',
						  ));
					}
				}
			}
		}
		if(isset($_POST["save"])) {
			$this->display_calendars();
		}
		else {
			$this->edit($id);
		}
	}
 
  	private function get_date_diff($date1, $date2) {
		$start = strtotime($date1);
		$end = strtotime($date2);
		$datediff = $start - $end;
		return floor($datediff/(60*60*24));
	}
	
	private function delete( $id ){
		global $wpdb; 
		$query = $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"',$id );
		$wpdb->query($query);
		$this->display_calendars();
	}
  
	private function delete_selected(){
		global $wpdb; 
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$query = $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"',$check );
			$wpdb->query($query);
		}
		$this->display_calendars();
	}
}

?>