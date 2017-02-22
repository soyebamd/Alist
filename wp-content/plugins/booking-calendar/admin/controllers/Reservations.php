<?php
class wpdevart_bc_ControllerReservations {
	private $model;	
	private $view;	
	  
	public function __construct() {
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Reservations.php");
		$this->model = new wpdevart_bc_ModelReservations();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/views/Reservations.php");
		$this->view = new wpdevart_bc_ViewReservations($this->model);
	}  	
	  
	public function perform() {
		$task = wpdevart_bc_Library::get_value('task');
		$id = wpdevart_bc_Library::get_value('id', 0);
		$action = wpdevart_bc_Library::get_value('action');
		if (method_exists($this, $task)) {
		  $this->$task($id);
		}
		else {
		  $this->display_reservations();
		}
	}
	  
	private function display_reservations($id=0,$send_mail = array()){
		$this->view->display_reservations($id,$send_mail);
	}  
	
	private function display_month_reservations(){
		$this->view->display_month_reservations();
	}
  	
	private function delete( $id ){
		global $wpdb; 
		$send_mail = array();
		$res_status = $this->model->get_reservation_row( $id );
		$delete_res = $wpdb->query($wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_reservations WHERE id="%d"',$id ));
		if($delete_res) {
			if($res_status["status"] == "approved") {
				$this->change_date_avail_count( $id, false, $res_status );
			}
			$send_mail = $this->send_mail($id,"deleted", $res_status);
		}
		$this->display_reservations(0,$send_mail);
	}
	
	private function add() {
		$this->view->add();
	}
	
	private function save($id){
		if(isset($_POST["wpdevart-submit".$id])){
			$booking_obg = new wpdevart_bc_calendar();
			$result = $booking_obg->wpdevart_booking_calendar($_SESSION["clendar_id"]);
			echo $result;
		}
		$this->display_reservations();
	}

  
	private function delete_selected(){
		global $wpdb; 
		$send_mail = array();
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$res_status = $this->model->get_reservation_row( $check );
			$delete_res = $wpdb->query($wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_reservations WHERE id="%d"',$check ));
			if($delete_res) {
				if($res_status["status"] == "approved") {
					$this->change_date_avail_count( $check, false, $res_status );
				}
				$send_mail = $this->send_mail($check,"deleted", $res_status);
			}
		}
		$this->display_reservations(0,$send_mail);
	}
	
	private function approve_selected(){
		global $wpdb; 
		$send_mail = array();
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
				array('status' => "approved"),
				array('id' => $check),
				array('%s')
			);
			if($update_res) {
				$this->change_date_avail_count( $check, true );
				$send_mail = $this->send_mail($check,"approved");
			}
		}

		$this->display_reservations(0,$send_mail);
	}
	
	private function canceled_selected(){
		global $wpdb; 
		$send_mail = array();
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$res_status = $this->model->get_reservation_row( $check );
			$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
				array('status' => "canceled"),
				array('id' => $check),
				array('%s')
			);
			if($update_res) {
				if($res_status["status"] == "approved") {
					$this->change_date_avail_count( $check, false );
				}
				$send_mail = $this->send_mail($check,"canceled");
			}
		}
		$this->display_reservations(0,$send_mail);
	}
	
	private function reject_selected(){
		global $wpdb; 
		$send_mail = array();
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$res_status = $this->model->get_reservation_row( $check );
			$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
				array('status' => "rejected"),
				array('id' => $check),
				array('%s')
			);
			if($update_res) {
				if($res_status["status"] == "approved") {
					$this->change_date_avail_count( $check, false );
				}
				$send_mail = $this->send_mail($check,"rejected");
			}
		}
		$this->display_reservations(0,$send_mail);
	}
	
	
	private function approve( $id ){
		global $wpdb; 
		$send_mail = array();
		$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
            array('status' => "approved"),
            array('id' => $id),
            array('%s')
        );
		if($update_res) {
			$this->change_date_avail_count( $id, true );
			$send_mail = $this->send_mail($id,"approved");
		}
		
		$this->display_reservations(0,$send_mail);
	}
	
	private function canceled( $id ){
		global $wpdb; 
		$send_mail = array();  
		$res_status = $this->model->get_reservation_row( $id );
		$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
            array('status' => "canceled"),
            array('id' => $id),
            array('%s')
        );
		if($update_res) {
			if($res_status["status"] == "approved") {
				$this->change_date_avail_count( $id, false );
			}
			$send_mail = $this->send_mail($id,"canceled");
		}
		$this->display_reservations(0,$send_mail);
	}
	private function reject( $id ){
		global $wpdb;
		$send_mail =  array();		
		$res_status = $this->model->get_reservation_row( $id );
		$update_res = $wpdb->update($wpdb->prefix . 'wpdevart_reservations',
            array('status' => "rejected"),
            array('id' => $id),
            array('%s')
        );
		if($update_res) {
			if($res_status["status"] == "approved") {
				$this->change_date_avail_count( $id, false );
			}
			$send_mail = $this->send_mail($id,"rejected");
		}
		$this->display_reservations(0,$send_mail);
	}
	
	private function change_date_avail_count( $id,$approve,$reserv_info_del="" ){
		global $wpdb;
		$theme_rows = $this->model->get_theme_rows();
		if($reserv_info_del == "") {
			$reserv_info = $this->model->get_reservation_row($id);
		} else {
			$reserv_info = $reserv_info_del;
		}		
		$cal_id = $reserv_info["calendar_id"]; 
		if(isset($reserv_info["count_item"])) {
			$count_item = $reserv_info["count_item"];
		} else {
			$count_item = 1;
		}
		if($reserv_info["single_day"] == "") {
			$start_date = $reserv_info["check_in"];
			$date_diff = abs($this->get_date_diff($reserv_info["check_in"],$reserv_info["check_out"]));
			for($i=0; $i <= $date_diff; $i++) {
				if(isset($theme_rows["price_for_night"]) && $theme_rows["price_for_night"] == "on"  && $i == $date_diff){
					continue;
				}
				$day = date( 'Y-m-d', strtotime($start_date. " +" . $i . " day" ));
				$unique_id = $cal_id."_".$day;
				$day_data = json_decode($this->model->get_date_data( $unique_id ),true);
				if($approve === true) {
					$day_data["available"] = $day_data["available"] - $count_item;
					if($day_data["available"] == 0) {
						$day_data["status"] = "booked";
					}
				} else {
					$day_data["available"] = $day_data["available"] + $count_item;
					$day_data["status"] = "available";
				}
				$day_info_jsone = json_encode($day_data);
				$update_in_db = $wpdb->update($wpdb->prefix . 'wpdevart_dates', array(
					'calendar_id' => $cal_id,
					'day' => $day,
					'data' => $day_info_jsone,
				  ), array('unique_id' => $unique_id));
			}
		} else {
			$unique_id = $cal_id."_".$reserv_info["single_day"];
			$day_data = json_decode($this->model->get_date_data( $unique_id ),true);
			if($approve === true) {
				if($reserv_info["end_hour"] == "" && $reserv_info["start_hour"] == "") {
					$day_data["available"] = $day_data["available"] - $count_item;
				} else {
					if(isset($day_data["hours"])){
						if($reserv_info["end_hour"] == "") {
							$day_data["hours"][$reserv_info["start_hour"]]["available"] =  $day_data["hours"][$reserv_info["start_hour"]]["available"] - $count_item;
							if($day_data["hours"][$reserv_info["start_hour"]]["available"] == 0) {
								$day_data["hours"][$reserv_info["start_hour"]]["status"] = "booked";
							}
							$count = 1;	
						} else {
							/*multihour here*/
							if(count($day_data["hours"])) {
								$start = 0;
								$count = 0;							
								foreach($day_data["hours"] as $key => $hour) {
									if($key == $reserv_info["start_hour"]) {
										$start = 1;
									} 
									if($start == 1) {
										$day_data["hours"][$key]["available"] =  $day_data["hours"][$key]["available"] - $count_item;
										$count += 1;
									}
									if($key == $reserv_info["end_hour"]) {
										$start = 0;
									}
									if($day_data["hours"][$key]["available"] == 0) {
										$day_data["hours"][$key]["status"] = "booked";
									}
								}
							}
						}
						$day_data["available"] = $day_data["available"] - ($count_item*$count);
					}
				}
				if($day_data["available"] == 0) {
					$day_data["status"] = "booked";
				}
			} else {
				if($reserv_info["end_hour"] == "" && $reserv_info["start_hour"] == "") {
					$day_data["available"] = $day_data["available"] + $count_item;
				} else {
					if($reserv_info["end_hour"] == "") {
						$day_data["hours"][$reserv_info["start_hour"]]["available"] =  $day_data["hours"][$reserv_info["start_hour"]]["available"] + $count_item;
						$day_data["hours"][$reserv_info["start_hour"]]["status"] = "available";
						$count = 1;	
					} else {
						/*multihour here*/
						if(count($day_data["hours"])) {
							$start = 0; 
							$count = 0;	
							foreach($day_data["hours"] as $key => $hour) {
								if($key == $reserv_info["start_hour"]) {
									$start = 1;
								}
								if($start == 1) {
									$day_data["hours"][$key]["available"] =  $day_data["hours"][$key]["available"] + $count_item;
									$count += 1;
								}
								if($key == $reserv_info["end_hour"]) {
									$start = 0;
								}
								if($day_data["hours"][$key]["available"] != 0) {
									$day_data["hours"][$key]["status"] = "available";
								}
							}
						}
					}
					$day_data["available"] = $day_data["available"] + ($count_item * $count);
				}
				$day_data["status"] = "available";
			}
			$day_info_jsone = json_encode($day_data);
			$update_in_db = $wpdb->update($wpdb->prefix . 'wpdevart_dates', array(
				'calendar_id' => $cal_id,
				'day' => $reserv_info["single_day"],
				'data' => $day_info_jsone,
			  ), array('unique_id' => $unique_id));
		}
	}
	
	private function send_mail($res_id,$type,$reserv_info_del=""){
		$email_array = array();
		$admin_email_types = array();
		$user_email_types = array();
		$admin_error_types = array();
		$user_error_types = array();
		$hour_html = "";
		$calendar_title = $this->model->get_calendar_title();
		if($reserv_info_del == "") {
			$form_result = $this->model->get_reservation_row($res_id);
		} else {
			$form_result = $reserv_info_del;
		}
		$theme_rows = $this->model->get_theme_rows($form_result["calendar_id"]);
		$form_datas = $this->model->get_form_data($form_result["form"]);
        $extras_data = $this->model->get_extra_data($form_result["extras"],"mail",$form_result["price"]);
		if($form_result["check_in"]) {
			$check_in = date($theme_rows["date_format"], strtotime($form_result["check_in"]));
			$check_out = date($theme_rows["date_format"], strtotime($form_result["check_out"]));
			$res_day = $form_result["check_in"]. "-" .$form_result["check_out"];
		} else {
			$res_day = date($theme_rows["date_format"], strtotime($form_result["single_day"]));
		}
		if(isset($form_result["start_hour"]) && $form_result["start_hour"] != ""){
			$hour_html = $form_result["start_hour"];
		}
		if(isset($form_result["end_hour"]) && $form_result["end_hour"] != ""){
			$hour_html = $hour_html." - ".$form_result["end_hour"];
		}
		if($hour_html != ""){
			$hour_html = "<tr><td style='padding: 1px 7px;'>".__('Hour','booking-calendar')."</td> <td  style='padding: 1px 7px;'>".$hour_html.'</td></tr>';
		}
		$site_url = site_url();
		$moderate_link = admin_url() . "admin.php?page=wpdevart-reservations";
		$res_info = "<table border='1' style='border-collapse:collapse;min-width: 360px;'>
						<caption style='text-align:left;'>".__('Details','booking-calendar')."</caption>
						<tr><td style='padding: 1px 7px;'>".__('Reservation dates','booking-calendar')."</td><td style='padding: 1px 7px;'>".$res_day."</td></tr>".$hour_html."
						<tr><td style='padding: 1px 7px;'>".__('Item Count','booking-calendar')."</td><td style='padding: 1px 7px;'>".$form_result["count_item"]."</td></tr>
						<tr><td style='padding: 1px 7px;'>".__('Price','booking-calendar')."</td> <td style='padding: 1px 7px;'>".(((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "before") ? $form_result["currency"] : '') . $form_result["price"] . (((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "after") || !isset($theme_rows['currency_pos'])) ? $form_result["currency"] : ''))."</td></tr>
						<tr><td style='padding: 1px 7px;'>".__('Total Price','booking-calendar')."</td> <td style='padding: 1px 7px;'>".(((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "before") ? $form_result["currency"] : '') . $form_result["total_price"] . (((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "after") || !isset($theme_rows['currency_pos'])) ? $form_result["currency"] : ''))."</td></tr>
					</table>";
		$form = "";
		$extras = "";		
		if(count($form_datas)) {
			$form .= "<table border='1' style='border-collapse:collapse;min-width: 360px;'>";
			$form .= "<caption style='text-align:left;'>Contact Information</caption>";
			foreach($form_datas as $form_fild_data) {
				$form .= "<tr><td style='padding: 1px 7px;'>". $form_fild_data["label"] ."</td> <td style='padding: 1px 7px;'>". $form_fild_data["value"] ."</td></tr>";
			}
			$form .= "</table>";
		}	
		if(count($extras_data)) {
			$extras .= "<table border='1' style='border-collapse:collapse;min-width: 360px;'>";
			$extras .= "<caption style='text-align:left;'>".__('Extra Information','booking-calendar')."</caption>";
			foreach($extras_data as $extra_data) {
				$extras .= "<tr><td colspan='2' style='padding: 1px 7px;'>".$extra_data["group_label"]."</td></tr>";
				$extras .= "<tr><td style='padding: 1px 7px;'>". $extra_data["label"] ."</td>"; 
				$extras .= "<td style='padding: 1px 7px;'>";
				if($extra_data["price_type"] == "percent") {
					$extras .= "<span class='price-percent'>".$extra_data["operation"].$extra_data["price_percent"]."%</span>";
					$extras .= "<span class='price'>".$extra_data["operation"] . (((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "before") ? $form_result["currency"] : '') . (isset($extra_data["price"])? $extra_data["price"] : "") . (((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "after") || !isset($theme_rows['currency_pos'])) ? $form_result["currency"] : ''))."</span></td></tr>";
				} else {
					$extras .= "<span class='price'>".$extra_data["operation"] . (((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "before") ? $form_result["currency"] : '') . $extra_data["price"] . (((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "after") || !isset($theme_rows['currency_pos'])) ? $form_result["currency"] : ''))."</span></td></tr>";
				}
				
			}
			$extras .= "<tr><td style='padding: 1px 7px;'>".__('Price change','booking-calendar')."</td><td style='padding: 1px 7px;'>+".(((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "before") ? $form_result["currency"] : '') . $form_result["extras_price"] . (((isset($theme_rows['currency_pos']) && $theme_rows['currency_pos'] == "after") || !isset($theme_rows['currency_pos'])) ? $form_result["currency"] : ''))."</td></tr>";
			$extras .= "</table>";
		}
		$emails = $form_result["email"];
		
		if(isset($theme_rows['notify_admin_on_book']) && $theme_rows['notify_admin_on_book'] == "on" && $type == "book") {
			$admin_email_types[] = 'notify_admin_on_book';
		}
		if(isset($theme_rows['notify_admin_on_approved']) && $theme_rows['notify_admin_on_approved'] == "on" && $type == "approved") {
			$admin_email_types[] = 'notify_admin_on_approved';
		}
		/*if(isset($theme_rows['notify_admin_paypal']) && $theme_rows['notify_admin_paypal'] == "on" && $type == "admin_paypal") {
			$admin_email_types[] = 'notify_admin_paypal';
		}*/
		
		
		if(isset($theme_rows['notify_user_on_book']) && $theme_rows['notify_user_on_book'] == "on" && $type == "book") {
			$user_email_types[] = 'notify_user_on_book';
		}
		if(isset($theme_rows['notify_user_on_approved']) && $theme_rows['notify_user_on_approved'] == "on" && $type == "approved") {
			$user_email_types[] = 'notify_user_on_approved';
		}
		if(isset($theme_rows['notify_user_canceled']) && $theme_rows['notify_user_canceled'] == "on" && $type == "canceled") {
			$user_email_types[] = 'notify_user_canceled';
		}
		if(isset($theme_rows['notify_user_deleted']) && $theme_rows['notify_user_deleted'] == "on" && ($type == "deleted" ||  $type == "rejected")) {
			$user_email_types[] = 'notify_user_deleted';
		}
		/*if(isset($theme_rows['notify_user_paypal']) && $theme_rows['notify_user_paypal'] == "on" && $type == "user_paypal") {
			$user_email_types[] = 'notify_user_paypal';
		}*/
		/*Email to admin on approved*/
		if(count($admin_email_types)) {	
			foreach($admin_email_types as $admin_email_type) {
				$to = "";
				$from = "";
				$fromname = "";
				$subject = "";
				$content = "";
				if(isset($theme_rows[$admin_email_type.'_to']) && $theme_rows[$admin_email_type.'_to'] != "") {
					$to = stripslashes($theme_rows[$admin_email_type.'_to']);
				}
				if(isset($theme_rows[$admin_email_type.'_fromname']) && $theme_rows[$admin_email_type.'_fromname'] != "") {
					$fromname = stripslashes($theme_rows[$admin_email_type.'_fromname']);
				}
				if(isset($theme_rows[$admin_email_type.'_subject']) && $theme_rows[$admin_email_type.'_subject'] != "") {
					$subject = stripslashes($theme_rows[$admin_email_type.'_subject']);
				}
				if(isset($theme_rows[$admin_email_type.'_content']) && $theme_rows[$admin_email_type.'_content'] != "") {
					$content = stripslashes($theme_rows[$admin_email_type.'_content']);
					$content = str_replace("[calendartitle]", $calendar_title, $content);
					$content = str_replace("[details]", $res_info, $content);
					$content = str_replace("[siteurl]", $site_url, $content);
					$content = str_replace("[moderatelink]", $moderate_link, $content);
					$content = str_replace("[form]", $form, $content);
					$content = str_replace("[extras]", $extras, $content);
					$content = "<div class='wpdevart_email' style='color:#5A5A5A !important;line-height: 1.5;'>".$content."</div>";
				}
				if(isset($theme_rows[$admin_email_type.'_from']) && $theme_rows[$admin_email_type.'_from'] != "") {
					if(trim($theme_rows[$admin_email_type.'_from']) == "[useremail]") {
						$from = "From: '" . $fromname . "' <" . $emails . ">" . "\r\n";
					} else {
						$from = "From: '" . $fromname . "' <" . stripslashes($theme_rows[$admin_email_type.'_from']) . ">" . "\r\n";
					}
				}
				$headers = "MIME-Version: 1.0\n" . $from . " Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\n";
				
				$admin_error_types[$admin_email_type] = wp_mail($to, $subject, $content, $headers);
			}	
		}	
			/*Email to user on approved*/
		if(count($user_email_types)) {	
			foreach($user_email_types as $user_email_type) {	
				$from = "";
				$fromname = "";
				$subject = "";
				$content = "";
				$to = $emails;
				if(isset($theme_rows[$user_email_type.'_subject']) && $theme_rows[$user_email_type.'_subject'] != "") {
					$subject = stripslashes($theme_rows[$user_email_type.'_subject']);
				}
				if(isset($theme_rows[$user_email_type.'_fromname']) && $theme_rows[$user_email_type.'_fromname'] != "") {
					$fromname = stripslashes($theme_rows[$user_email_type.'_fromname']);
				}
				if(isset($theme_rows[$user_email_type.'_content']) && $theme_rows[$user_email_type.'_content'] != "") {
					$content = stripslashes($theme_rows[$user_email_type.'_content']);
					$content = str_replace("[calendartitle]", $calendar_title, $content);
					$content = str_replace("[details]", $res_info, $content);
					$content = str_replace("[siteurl]", $site_url, $content);
					$content = str_replace("[form]", $form, $content);
					$content = str_replace("[extras]", $extras, $content);
					$content = "<div class='wpdevart_email' style='color:#5A5A5A !important;ine-height: 1.5;'>".$content."</div>";
				}
				if(isset($theme_rows[$user_email_type.'_from']) && $theme_rows[$user_email_type.'_from'] != "") {
					$from = "From: '" . $fromname . "' <" . stripslashes($theme_rows[$user_email_type.'_from']) . ">" . "\r\n";
				}
				$headers = "MIME-Version: 1.0\n" . $from . " Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\n";
				
				$user_error_types[$user_email_type] = wp_mail($to, $subject, $content, $headers);
			}
		}
		$result = array($admin_error_types,$user_error_types);
		return 	$result;	
	}

 
  	private function get_date_diff($date1, $date2) {
		$start = strtotime($date1);
		$end = strtotime($date2);
		$datediff = $start - $end;
		return floor($datediff/(60*60*24));
	}

}

?>