<?php
class wpdevart_bc_BookingCalendar {
	
	private $theme_option;
	private $calendar_data;
	private $form_data;
	private $extra_field;
	private $id;
	private $selected;
	private $ajax;
	private $use_mo = true;
	private $booking_id;
	private $calendar_title = "";
	private $currency = "$";
	private $for_tr = array();
	private $week_days = array(
		"Sunday",
		"Monday",
		"Tuesday",
		"Wednesday",
		"Thursday",
		"Friday",
		"Saturday"
	);
	private $abbr_week_days = array(
		"Sun",
		"Mon",
		"Tue",
		"Wed",
		"Thu",
		"Fri",
		"Sat"
	);
	private $short_week_days = array(
		"Su",
		"Mo",
		"Tu",
		"We",
		"Th",
		"Fr",
		"Sa"
	);
	public $jd, $year, $month, $day, $month_days_count, $month_start, $month_name, $prev_month, $next_month,$bookings = array();
	public static $list_of_animations=array('bounce','flash','pulse','rubberBand','shake','swing','tada','wobble','bounceIn','bounceInDown','bounceInLeft','bounceInRight','bounceInUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig','flip','flipInX','flipInY','lightSpeedIn','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','rollIn','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp');
	
	public function __construct($date = '', $id, $theme_option, $calendar_data, $form_option, $extra_field, $selected = array(),$ajax = false,$widget=false,$text_for=array(),$calendar_title = "") {
        $this->theme_option = $theme_option;
        $this->calendar_data = $calendar_data;
        $this->calendar_title = $calendar_title;
        $this->form_data = $form_option;
        $this->extra_field = $extra_field;
        $this->id = $id;
        $this->ajax = $ajax;
        $this->selected = $selected;
        $currency_list = wpdevart_bc_get_currency();
		$this->for_tr = $text_for;
		if($widget == true) {
			$this->booking_id = wpdevart_bc_calendar::$booking_count + 1000;
		} else {
			$this->booking_id = wpdevart_bc_calendar::$booking_count;
		}
		if(isset($this->theme_option['currency']) && isset($currency_list[esc_html($this->theme_option['currency'])])) {
			$this->currency = $currency_list[esc_html($this->theme_option['currency'])]['simbol'];
		}
		if(isset($this->theme_option['use_mo']) && $this->theme_option['use_mo'] == "on") {
			$this->use_mo = true;
		}

		$date_array = explode( '-', $date );
		$year      = $date_array[0];
		$month     = $date_array[1];
		$day       = $date_array[2];
		if (isset( $_REQUEST['year'] ) && $_REQUEST['year'] != '') {
			$year = $_REQUEST['year'];
		}
		if (isset( $_REQUEST['month'] ) && $_REQUEST['month'] != '') {
			$month = $_REQUEST['month'];
		}
		if (isset( $_REQUEST['day'] ) && $_REQUEST['day'] != '') {
			$day = $_REQUEST['day'];
		}
		$this->month = (int) $month;
		$this->year  = (int) $year;
		$this->day   = (int) $day;
		$this->month_days_count = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
		$this->jd = cal_to_jd(CAL_GREGORIAN, $this->month, date( 1 ), $this->year);
		$this->month_start = jddayofweek( $this->jd);
		$this->month_name = __( jdmonthname($this->jd, 1), 'booking-calendar' );
	}

	public function booking_calendar($reservation = "") {
		$prev      = $this->calculate_date( $this->year . '-' . $this->month, '-1', 'month' );
		$prev_date_info = $prev['year'] . '-' . $prev['month'];
		$prev_date = '';
		$this->prev_month = $this->get_month_name($prev['year'] . '-' . $prev['month'],0);
		$prev_html = '<span><</span><span class="wpda-month-name"> ' . __($this->prev_month, 'booking-calendar') . ' ' . $prev_date . '</span>';
		
		$next      = $this->calculate_date( $this->year . '-' . $this->month . '-1', '+ 1', 'month' );
		$next_date = '';
		$next_date_info = $next['year'] . '-' . $next['month'] . '-' . $next['day'];
		$this->next_month = $this->get_month_name($next['year'] . '-' . $next['month'],0);
		$next_html = '<span class="wpda-month-name">' . $next_date . ' ' . __( $this->next_month, 'booking-calendar' ) . ' </span><span>></span>';
		
		$booking_calendar = '';
$booking_calendar .= "<h3>Step 1: Choose a Date</h3>";
		$booking_calendar .= '<div class="wpda-booking-calendar-head '.$reservation.'">';
		// Previous month link
		$booking_calendar .= '<div class="wpda-previous"><a href="?date=' . $prev_date_info . '" rel="nofollow, noindex">' . $prev_html . '</a></div>'; 
		// Current date info
		$booking_calendar .= '<div class="current-date-info"><span class="wpda-current-year">' . $this->year . '</span>&nbsp;<span class="wpda-current-month">' . __( $this->month_name, 'booking-calendar' ) . '</span></div>';
        // Next month link
		$booking_calendar .= '<div class="wpda-next"><a href="?date=' . $next_date_info . '" rel="nofollow, noindex">' . $next_html . '</a></div>';
		$booking_calendar .= '</div>';
        // Booking calendar container
		if( $reservation == "") {
			$booking_calendar .= '<div class="wpdevart-calendar-container div-for-clear">';
		} else {
			$booking_calendar .= '<table class="wpdevart-calendar-container" data-id="' . $this->id . '">';
		}
		if (isset($this->theme_option['week_days']) && $this->theme_option['week_days'] == 0) {
			$week_days = $this->week_days;
		} else if (isset($this->theme_option['week_days']) && $this->theme_option['week_days'] == 1) {
			$week_days = $this->abbr_week_days;
		} else {
			$week_days = $this->short_week_days;
		}
		$day_start = (isset($this->theme_option["day_start"])? $this->theme_option["day_start"] : 0);
		for ($i = 0; $i < count( $week_days ); $i ++) {
			$di      = ( $i + $day_start ) % 7;
			$week_day = $week_days[ $di ];
			if ($i == 0) {
				$cell_class = 'week-day-name week-start';
			} else {
				$cell_class = 'week-day-name';
			}
			$booking_calendar .= $this->booking_calendar_cell( __( $week_day, 'booking-calendar' ), $cell_class );
		}
        /* Previous month cells */
		$empty_cells = 0;
		$count_in_row = 7;

        /* Week start days */
		$week_start_days = $this->month_start - $day_start;
		if ($week_start_days < 0) {
			$week_start_days = $week_start_days + $count_in_row;
		}
		$r = 0;
		for ($i = $week_start_days; $i > 0; $i--) {
			if ( $i == 0 ) {
				$cell_class = 'past-month-day week-start';
			}
			else {
				$cell_class = 'past-month-day';
			}
			$day_count = ($i==1) ? "day" : "days";
			$day = date("j",strtotime("".($this->year . '-' . ($this->month) . '-1')." -".$i." ".$day_count.""));
			if($this->month == 1) {
				$month = 13;
			} else {
				$month = $this->month;
			}
			if($month == 13) {
				$date = ($this->year - 1) . '-' . ($month-1) . '-' . $day;
			} else {
				$date = $this->year . '-' . ($month-1) . '-' . $day;
			}
			if($r == 0  && $reservation == "reservation"){
				$booking_calendar .= "<tr>";
			}
			if( $reservation == "reservation") {
				$booking_calendar .= $this->reserv_calendar_cell(__( $this->prev_month, 'booking-calendar' ) . " " . $day, $cell_class,$date);
			} else {
				$booking_calendar .= $this->booking_calendar_cell(__( $this->prev_month, 'booking-calendar' ) . " " . $day, $cell_class,$date);
			}
			
			if(($r%7 == 0 && $r != 0) && $reservation == "reservation"){
				$booking_calendar .= "</tr><tr>";
			}
			$r++;
			$empty_cells ++;
		}

		/* Days part */
		$row_count    = $empty_cells;
		$weeknumadjust = $count_in_row - ($this->month_start - $day_start);

		for ($j = 1; $j <= $this->month_days_count; $j ++) {

			$date = $this->year . '-' . $this->month . '-' . $j;
			$row_count ++;
			if($r == 0 && $j == 1 && $reservation == "reservation"){
				$booking_calendar .= "<tr>";
			}
			if( $reservation == "reservation") {
				$booking_calendar .= $this->reserv_calendar_cell($j, 'current-month-day', $date);
			} else {
				$booking_calendar .= $this->booking_calendar_cell($j, 'current-month-day', $date);
			}
			if((($r + $j)%7 == 0 ) && $reservation == "reservation"){
				$booking_calendar .= "</tr><tr>";
			}
			if ($row_count % $count_in_row == 0) {
				$row_count = 0;
			}
		}

		/* Next month cells */
		$cells_left_count = $count_in_row - $row_count;
		if ($cells_left_count != $count_in_row) {
			for ($k = 1; $k <= $cells_left_count; $k ++) {
				$day_count = ($k==1) ? "day" : "days";
				$day = date("j",strtotime("".($this->year . '-' . ($this->month) . '-'.$this->month_days_count.'')." +".$k." ".$day_count.""));
				if($this->month == 12) {
					$month = 0;
				} else {
					$month = $this->month;
				}
				if($month == 0) {
					$date = ($this->year + 1) . '-' . ($month+1) . '-' . $day;
				} else {
					$date = $this->year . '-' . ($month+1) . '-' . $day;
				}
				
				if( $reservation == "reservation") {
					$booking_calendar .= $this->reserv_calendar_cell(__( $this->next_month, 'booking-calendar' ) . " " . $k, 'next-month-day',$date);
				} else {
					$booking_calendar .= $this->booking_calendar_cell(__( $this->next_month, 'booking-calendar' ) . " " . $k, 'next-month-day',$date);
				}
				if(($k%7 == 0) && $reservation == "reservation" && $k != $count_in_row){
					$booking_calendar .= "</tr><tr>";
				} elseif(($k%7 == 0) && $reservation == "reservation" && $k == $count_in_row) {
					$booking_calendar .= "</tr>";
				}
				$empty_cells ++;
			}
		}
		if( $reservation == "") {
			$booking_calendar .= '</div><div class="wpdevart-hours-container"><div class="wpdevart-hours-overlay"><div class="wpdevart-load-image"><i class="fa fa-spinner fa-spin"></i></div></div><div class="wpdevart-hours"></div></div>';
		} else {
			$booking_calendar .= '</table>';
		}
		if($reservation != "reservation") {
			if (isset($this->theme_option['legend_enable']) && $this->theme_option['legend_enable'] == "on") {
				$booking_calendar .= '<div class="wpdevart-booking-legends div-for-clear">';
					if (isset($this->theme_option['legend_available_enable']) && $this->theme_option['legend_available_enable'] == "on") {
						$booking_calendar .= '<div class="wpdevart-legends-available"><div class="legend-text"><span class="legend-div"></span>-'.esc_html($this->theme_option['legend_available']).'</div>';
						$booking_calendar .= '</div>';
					}
					if (isset($this->theme_option['legend_booked_enable']) && $this->theme_option['legend_booked_enable'] == "on") {
						$booking_calendar .= '<div class="wpdevart-legends-pending"><div class="legend-text"><span class="legend-div"></span>-'.esc_html($this->theme_option['legend_booked']).'</div>';
						$booking_calendar .= '</div>';
					}
					if (isset($this->theme_option['legend_unavailable_enable']) && $this->theme_option['legend_unavailable_enable'] == "on") {
						$booking_calendar .= '<div class="wpdevart-legends-unavailable"><div class="legend-text"><span class="legend-div"></span>-'.esc_html($this->theme_option['legend_unavailable']).'</div>';
						$booking_calendar .= '</div>';
					}
				$booking_calendar .= '</div>';
			}	
		} else {
			$booking_calendar .= '<div class="wpdevart-booking-legends div-for-clear">';
			$booking_calendar .= '<div class="wpdevart-legends-approved"><div class="legend-text"><span class="legend-div"></span>-Approved</div>';
			$booking_calendar .= '</div>';
			$booking_calendar .= '<div class="wpdevart-legends-pending"><div class="legend-text"><span class="legend-div"></span>-Pending</div>';
			$booking_calendar .= '</div>';
			$booking_calendar .= '<div class="wpdevart-legends-canceled"><div class="legend-text"><span class="legend-div"></span>-Canceled</div>';
			$booking_calendar .= '</div>';
			$booking_calendar .= '<div class="wpdevart-legends-rejected"><div class="legend-text"><span class="legend-div"></span>-Rejected</div>';
			$booking_calendar .= '</div>';
			$booking_calendar .= '</div>';
		}

		if(isset($this->theme_option['cal_animation_type']) && $this->theme_option['cal_animation_type']!='none' && !is_admin()){
			$booking_calendar.='<script>	
			jQuery(document).ready(function(){
				calendar_animat("'.self::get_animations_type_array($this->theme_option['cal_animation_type']).'","booking_calendar_main_container_'.$this->booking_id.'");
				jQuery(window).scroll(function(){
					calendar_animat("'.self::get_animations_type_array($this->theme_option['cal_animation_type']).'","booking_calendar_main_container_'.$this->booking_id.'");
				});
			});</script>';
		}
		return $booking_calendar;
	}
	
	public function booking_calendar_hours($day) {
		$hours = "<div class='wpdevart-hours'>";
$hours .= "<h3>Step 2: Select Hour</h3>";
		$unique_id = $this->id."_".$day;
		$day_info = json_decode($this->get_date_data( $unique_id ),true);
		if (isset($day_info["hours"]) && count($day_info["hours"])) {
			foreach($day_info["hours"] as $key => $hour) {
				$hour_price = "";
				$hour_info = 'data-date="' . $key . '" data-dateformat="' . $key . '" data-currency="' . $this->currency . '"';
				if (isset($hour["price"]) && $hour["price"] != "" && isset($hour["status"]) && $hour["status"] != "unavailable") {
					$hour_price.= ' data-price="' . $hour["price"] . '"';
				}
				
				$hour_price.= ' data-currency="' . $this->currency . '"';
				if (isset($hour["status"]) && $hour["status"] == "available") {
					$hour_info .= ' data-available="' . $hour["available"] . '"';
				}else if(isset($hour["status"]) && $hour["status"] == "unavailable"){
					$hour_info .= ' data-available="0"';
				}
				$class_list = ' wpdevart-hour-' . $hour['status'];
				
				$hours .= "<div ".$hour_info." class='wpdevart-hour-item ".$class_list."'>
				  <div class='wpdevart-hour'><span>".$key."</span></div>";
				if (isset($hour["status"]) && $hour["status"] == "available") {
					if (!(isset($this->theme_option["hide_count_available"]) && $this->theme_option["hide_count_available"] == "on")) {
						$available = $hour["available"];
					}else {
						$available = "";
					}
					$hours .= '<div class="day-availability">' . $available . ' <span class="hour-av">'.$this->for_tr["for_available"].'</span></div>';
					
				} elseif (isset($hour["status"]) && $hour["status"] == "booked") {
					$hours .= '<div class="day-availability">' .$this->for_tr["for_booked"]. '</div>';
				} elseif (isset($hour["status"]) && $hour["status"] == "unavailable") {
					$hours .= '<div class="day-availability">' .$this->for_tr["for_unavailable"]. '</div>';
				}
				if(isset($hour["info_users"]) && $hour["info_users"] != "") {  
				    $hours .= "<div class='wpdevart-hour-info'>".$hour["info_users"]."</div>";
				} 
				if(((isset($hour["price"]) && $hour["price"] != "") || (isset($hour["marked_price"]) && $hour["marked_price"] != "")) && (isset($hour["status"]) && $hour["status"] != "unavailable")) {
				    $hours .= "<div class='wpdevart-hour-price'>";
					if(isset($hour["price"]) && $hour["price"] != "") {
						$hours .= "<span ".$hour_price." class='hour-price new-price'>".((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? $this->currency : "").$hour["price"].(((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? $this->currency : "")." </span>";
					}
					if(isset($hour["marked_price"]) && $hour["marked_price"] != "") {
						$hours .= "<span class='hour-marked-price old-price'>".((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? $this->currency : "").$hour["marked_price"].(((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? $this->currency : "")."</span>";
					}
					$hours .= "</div>";
				}
				$hours .= "</div>";
			}
			
		}else {
			$hours .= $this->for_tr["for_no_hour"];
		}
		$hours .= "</div>";
		return $hours;
	}

	public function booking_calendar_day_hours($day) {
		$hours = "";
		$unique_id = $this->id."_".$day;
		$day_info = json_decode($this->get_date_data( $unique_id ),true);
		if (isset($day_info["hours"]) && count($day_info["hours"])) {
			foreach($day_info["hours"] as $key => $hour) {
				$hour_price = "";
				if (isset($hour["price"]) && $hour["price"] != "" && isset($hour["status"]) && $hour["status"] != "unavailable") {
					$hour_price.= ' data-price="' . $hour["price"] . '"';
				}
				
				$hour_price.= ' data-currency="' . $this->currency . '"';
				$class_list = ' wpdevart-hour-' . $hour['status'];
				
				$hours .= "<div class='wpdevart-day-hour-item ".$class_list."'>
				  <div class='wpdevart-hour'><span>".$key."</span></div>";
				if (isset($hour["status"]) && $hour["status"] == "available") {
					if (!(isset($this->theme_option["hide_count_available"]) && $this->theme_option["hide_count_available"] == "on")) {
						$available = $hour["available"];
					}else {
						$available = "";
					}
					$hours .= '<div class="day-availability">' . $available . ' <span class="hour-av">'.$this->for_tr["for_available"].'</span></div>';
					
				} elseif (isset($hour["status"]) && $hour["status"] == "booked") {
					$hours .= '<div class="day-availability">' .$this->for_tr["for_booked"]. '</div>';
				} elseif (isset($hour["status"]) && $hour["status"] == "unavailable") {
					$hours .= '<div class="day-availability">' .$this->for_tr["for_unavailable"] . '</div>';
				}
				if(((isset($hour["price"]) && $hour["price"] != "") || (isset($hour["marked_price"]) && $hour["marked_price"] != "")) && (isset($hour["status"]) && $hour["status"] != "unavailable")) {
				    $hours .= "<div class='wpdevart-hour-price'>";
					if(isset($hour["price"]) && $hour["price"] != "") {
						$hours .= "<span ".$hour_price." class='hour-price new-price'>".((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? $this->currency : "").$hour["price"].(((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? $this->currency : "")." </span>";
					}
					if(isset($hour["marked_price"]) && $hour["marked_price"] != "") {
						$hours .= "<span class='hour-marked-price old-price'>".((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? $this->currency : "").$hour["marked_price"].(((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? $this->currency : "")."</span>";
					}
					$hours .= "</div>";
				}
				if(isset($hour["info_users"]) && $hour["info_users"] != "") {  
				    $hours .= "<div class='wpdevart-hour-info'>".$hour["info_users"]."</div>";
				}
				$hours .= "</div>";
			}
			
		}else {
			$hours .= $this->for_tr["for_no_hour"];
		}
		return $hours;
	}


	private function booking_calendar_cell( $day, $class, $date = '' ) {
		$class_list = '';
		$data_info = '';
		$data_available = '';
		$day_info = '';
		$hours = array();
		$hours_enabled = false;
		$av_count = 0;
		if($this->theme_option['date_format'] == "d/m/Y"){
			$date_format = date('m/d/Y',strtotime($date));
		} elseif($this->theme_option['date_format'] == 'Y M j'){
			$date_format = date('F j, Y',strtotime($date));
		} else{
			$date_format = date($this->theme_option['date_format'],strtotime($date));
		}
		if($date != "") {
			$date = date("Y-m-d",strtotime($date));
		}
		if (strpos( $class, 'week-day-name') === false ) {
			$class_list .= ' wpdevart-day';
		}
		
		$data_info = 'data-date="' . $date . '" data-dateformat="' . $date_format . '" data-currency="' . $this->currency . '"';
		foreach($this->calendar_data as $day_data) {
			if($day_data['day'] == $date) {
				$day_info = json_decode($day_data['data'], true);
			}
		}
		$week_day = date('w', strtotime( $date ));

		if (isset($day_info["status"]) && $day_info["status"] == "available") {
			if(!(!isset($this->theme_option['hours_enabled']) && isset($day_info['hours']) && trim($day_info['hours'] != ""))){
			$data_available = ' data-available="' . $day_info["available"] . '"';
			}
		}
		if(isset($this->theme_option['unavailable_week_days']) && in_array($week_day,$this->theme_option['unavailable_week_days'])){
			$data_available = ' data-available="0"';
		}
		if(isset($day_info['status']) && $day_info['status'] != ''){
			if(isset($this->theme_option['unavailable_week_days']) && in_array($week_day,$this->theme_option['unavailable_week_days'])){
				$day_info['status']='unavailable';
			}
			
			if($day_info['status'] == 'available') {
				if(!(!isset($this->theme_option['hours_enabled']) && isset($day_info['hours']) && trim($day_info['hours'] != ""))){
					$class_list .= ' wpdevart-available';
				}
			} else {
				$class_list .= ' wpdevart-' . $day_info['status'];
			}
		}
		
		if ($day != '') {
			$date_diff = $this->get_date_diff($date,date( 'Y-m-d' ));
			if (strpos( $class, 'week-day-name') === false ) {
				if ($date_diff<0 && ($date != '' || strpos( $class, 'past-month-day') !== false )) {
					$class_list .= ' past-day';
				}
				if ($date == date( 'Y-m-d' )) {
					$class_list .= ' current-day';
				}
				if (in_array($this->get_day( $date ), array('Saturday', 'Sunday'))) {
					$class_list .= ' weekend';
				}
				$day_start = (isset($this->theme_option["day_start"])? $this->theme_option["day_start"] : 0);
				if ($this->get_day( $date, 0 ) == $day_start) {
					$class_list .= ' week-start';
				}
				if (isset($this->theme_option['unavailable_week_days']) && in_array($week_day,$this->theme_option['unavailable_week_days'])) {
					$class_list .= ' wpdevart-unavailable'; // days with bookings
				} else if (strpos( $class, 'week-day-name' ) === false) {
					$class_list .= ' available-day'; // no bookings
				}
				if (isset($day_info["hours_enabled"]) && $day_info["hours_enabled"] == "on") {
					$hours_enabled = true;
					$class_list .= ' hour-enable'; // hour enable
					if (isset($day_info["hours"]) && $day_info["hours"] != "") {
						foreach($day_info["hours"] as $hour) {
							if($hour["status"] == "available") {
								$av_count += $hour["available"];
							}
						}
					}
				}
				if (isset($this->selected["date"]) && $this->selected["date"] == $date && $this->selected["date"] != "") {
					$class_list .= ' selected';
				}
			}
			$bookings = '<div ' . $data_info . ' ' . $data_available . ' class="' . $class . $class_list . '">';
			$bookings.= '<div class="wpda-day-header div-for-clear"><div class="wpda-day-number">' . $day . '</div>';
			if (isset($day_info["info_admin"]) && $day_info["info_admin"] != "" && is_admin() && !$this->ajax) {
				$bookings .= '<div class="day-user-info-container">a<div class="day-user-info">' . esc_html($day_info["info_admin"]) . '</div></div>';
			}
			if (isset($day_info["info_users"]) && $day_info["info_users"] != "") {
				$bookings .= '<div class="day-user-info-container">i<div class="day-user-info animated fadeInDownShort">' . esc_html($day_info["info_users"]) . '</div></div>';
			}
			
			$bookings.= '</div>';
			if(strpos( $class, 'week-day-name') === false){
				if (isset($day_info["status"]) && $day_info["status"] == "available") {
					if (!(isset($this->theme_option["hide_count_available"]) && $this->theme_option["hide_count_available"] == "on")) {
						$available = $day_info["available"];
						if($hours_enabled){
							$available = $av_count;
						}
					} else {
						$available = "";
					}
					if(!(!isset($this->theme_option['hours_enabled']) && isset($day_info['hours']) && trim($day_info['hours'] != ""))){
						$bookings .= '<div class="day-availability">' . $available . ' <span class="day-av">'.$this->for_tr["for_available"].'</span></div>';
					}
					
				} elseif (isset($day_info["status"]) && $day_info["status"] == "booked") {
					$bookings .= '<div class="day-availability">' .$this->for_tr["for_booked"]. '</div>';
				} elseif ((isset($day_info["status"]) && $day_info["status"] == "unavailable") || (isset($this->theme_option['unavailable_week_days']) && in_array($week_day,$this->theme_option['unavailable_week_days']))) {
					$bookings .= '<div class="day-availability">' .$this->for_tr["for_unavailable"] . '</div>';
				}
				if (isset($day_info["price"]) && $day_info["price"] != "" && !(isset($this->theme_option['unavailable_week_days']) && in_array($week_day,$this->theme_option['unavailable_week_days']))) {
					if(!$hours_enabled){
						$bookings .= '<div class="day-price"><span class="new-price" data-price="' . $day_info["price"] . '" data-currency="' . $this->currency . '">' .   ((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($this->currency) : '') . esc_html($day_info["price"]) . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($this->currency) : '') . '</span>';
						if (isset($day_info["marked_price"]) && $day_info["marked_price"] != "") {
							$bookings .= '<span class="old-price">' . ((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($this->currency) : '') . esc_html($day_info["marked_price"]) . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($this->currency) : '') . '</span>';
						}
						$bookings .= '</div>';
					}
				}
				if((isset($this->theme_option['hours_enabled']) && $this->theme_option['hours_enabled'] == "on") && (isset($this->theme_option['show_hours_info']) && $this->theme_option['show_hours_info'] == "on")){
					$bookings .= '<div class="wpdevart-day-hours animated fadeInUpShort">';
					$bookings .= $this->booking_calendar_day_hours(date("Y-m-d",strtotime($date)));
					
					$bookings .= '</div>';
				}
			}
			$bookings .= '</div>';

			return $bookings;
		}
    }


	private function reserv_calendar_cell( $day, $class, $date = '' ) {
		$date = date("Y-m-d",strtotime($date));	
		$class = "";	
		$link_content = "";	
		$reservations = $this->get_reservation_row_calid($this->id,$date);
		if ($day != '') {
			$bookings = '<td class="' . $class . '">';
			$bookings.= '<div class="wpda-day-header div-for-clear"><div class="wpda-day-number">' . $day . '</div></div>';
				if($reservations) {
					foreach($reservations as $reservation) {
						$hour_html = "";
						$unique_id = $reservation["calendar_id"]."_".$reservation["single_day"];
						$day_hours = $this->get_date_data( $unique_id );
						$day_hours = json_decode($day_hours, true);
						$form_data = $this->get_form_data($reservation["form"]);
						$extras_data = $this->get_extra_data($reservation);
						if($reservation["check_in"] == $date) {
							$class = "start";
						} elseif($reservation["check_out"] == $date) {
							$class = "end";
						}
						$bookings .= '<div class="reservation-month reservation-month-'.$reservation["id"].' '.$reservation["status"].' '.$class.'">';
						if(($reservation["check_in"] == $date && $reservation["email"] == "") || ($reservation["single_day"] == $date && $reservation["email"] == "")) {
							$link_content = $reservation["id"];
						} elseif(($reservation["check_in"] == $date && $reservation["email"] != "") || ($reservation["single_day"] == $date && $reservation["email"] != "")) {
							$link_content = $reservation["email"];
						}elseif($reservation["check_in"] != $date) {
							$link_content = "";
						}
						if(isset($reservation["start_hour"]) && $reservation["start_hour"] != ""){
							$hour_html = $reservation["start_hour"];
						}
						if(isset($reservation["end_hour"]) && $reservation["end_hour"] != ""){
							$hour_html = $hour_html." - ".$reservation["end_hour"];
						}
						if($hour_html != ""){
							$hour_html = '<span class="form_info"><span class="form_label">'.__('Hour','booking-calendar').'</span> <span class="form_value">'.$hour_html.'</span></span>';
						}
						
						$content = '<div class="month-view-content"><div class="reserv-info-container">
									<h5>Details<span class="month_view_id">#'.$reservation["id"].'</span></h5>
									'.$hour_html.'<span class="form_info"><span class="form_label">'.__('Item Count','booking-calendar').'</span> <span class="form_value">'.$reservation["count_item"].'</span></span>
									<span class="form_info"><span class="form_label">'.__('Price','booking-calendar').'</span> <span class="form_value">'.((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($reservation["currency"]) : '') . esc_html($reservation["price"]) . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($reservation["currency"]) : '').'</span></span>
									<span class="form_info"><span class="form_label">'.__('Total Price','booking-calendar').'</span> <span class="form_value">'.((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($reservation["currency"]) : '') . esc_html($reservation["total_price"]) . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($reservation["currency"]) : '').'</span></span>
								</div><div class="reserv-info-items div-for-clear">';
						/*Hours info*/
						
						if(isset($day_hours["hours"]) && count($day_hours["hours"])){
							$content .= "<div class='reserv-info-container hours_info'>
								<h5>".__('Hours','booking-calendar')."</h5>";
								$start = 0;
								$count = 0;
								foreach($day_hours["hours"] as $key => $hour) {
									if($key == $reservation["start_hour"]) {
										$start = 1;
									} 
									if($start == 1 && (!($reservation["end_hour"] == "" && $count == 1))) {
										$content .= "<span class='form_info'><span class='form_label'>".$key."</span> <span class='form_value'>".((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? $reservation["currency"] : '').$hour["price"].(((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? $reservation["currency"] : '')."<span class='hour-info'>".$hour["info_users"]."</span></span></span>";
									    $count += 1;
									}
									if($key == $reservation["end_hour"]){ 
										$start = 0;
									}
								}
							$content .= "</div>";
						} 		
						if(count($form_data)) {
							$content .= "<div class='reserv-info-container'>";
							$content .= "<h5>".__('Contact Information','booking-calendar')."</h5>";
							foreach($form_data as $form_fild_data) {
								$content .= "<span class='form_info'><span class='form_label'>". $form_fild_data["label"] ."</span> <span class='form_value'>". $form_fild_data["value"] ."</span></span>";
							}
							$content .= "</div>";
						}
						if(count($extras_data)) {
							$content .= "<div class='reserv-info-container'>";
							$content .= "<h5>".__('Extra Information','booking-calendar')."</h5>";
							foreach($extras_data as $extra_data) {
								$content .= "<h6>".$extra_data["group_label"]."</h6>";
								$content .= "<span class='form_info'><span class='form_label'>". $extra_data["label"] ."</span>"; 
								$content .= "<span class='form_value'>";
								if($extra_data["price_type"] == "percent") {
									$content .= "<span class='price-percent'>".$extra_data["operation"].$extra_data["price_percent"]."%</span>";
									if(isset($extra_data["price"])) {
										$content .= "<span class='price'>".$extra_data["operation"] .((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($reservation["currency"]) : '') . $extra_data["price"] . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($reservation["currency"]) : '') ."</span>";
									}
								}else {
									if(isset($extra_data["price"])) {
										$content .= "<span class='price'>".$extra_data["operation"] .((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($reservation["currency"]) : '') . $extra_data["price"] . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($reservation["currency"]) : '') ."</span>";
									}
								}
								$content .= "</span></span>";
							}
							$content .= "<h6>".__('Price change','booking-calendar')."</h6>";
							$content .= "<span class='form_info'><span class='form_label'></span><span class='form_value'>".(($reservation["extras_price"]<0)? "" : "+").((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($reservation["currency"]) : '') . $reservation["extras_price"] . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($reservation["currency"]) : '')."</span>"; 
							$content .= "</div>";
						}		
						$content .= '</div></div>';
						$bookings .= '<a href="" onclick="wpdevart_set_value(\'cur_id\',\''.$reservation["id"].'\');wpdevart_set_value(\'task\',\'display_reservations\'); wpdevart_form_submit(event, \'reservations_form\')" class="month-view-link">'.$link_content.'</a>';
						$bookings .= $content.'</div>';
					}
				}
			$bookings .= '</td>';
			return $bookings;
		}
    }

	
	public function booking_form($class) {
		
		$input_atribute = '';
		$form_html = '';		
		$form_html .= '<div class="wpdevart-booking-form-container '.$class.'" id="wpdevart_booking_form_'.$this->booking_id.'">';
$form_html .= "<h3>Step 3: Complete Form</h3>";
		if (!isset($this->theme_option["auto_fill"])) {
			$input_atribute = "autocomplete='off'";
		}
		$form_html .= '<div class="wpdevart-booking-form"><form method="post" class="div-for-clear"><div class="wpdevart-check-section">';
		if (isset($this->theme_option["enable_checkinout"]) && $this->theme_option["enable_checkinout"] == "on" && $this->theme_option["type_days_selection"] == "multiple_days" && !(isset($this->theme_option["hours_enabled"]) && $this->theme_option["hours_enabled"] == "on")) {
			$form_html .= '<div class="wpdevart-fild-item-container ">
				  '.$this->form_field_text(array('name'=>'form_checkin'.$this->booking_id,'class'=>'wpdevart_form_checkin','label'=>$this->for_tr["for_check_in"], 'readonly' => 'true' )).'</div>
				  <div class="wpdevart-fild-item-container ">'.$this->form_field_text(array('name'=>'form_checkout'.$this->booking_id,'class'=>'wpdevart_form_checkout','label'=>$this->for_tr["for_check_out"], 'readonly' => 'true' )).'</div>';
		} elseif (!isset($this->theme_option["enable_checkinout"]) && $this->theme_option["type_days_selection"] == "multiple_days" && !(isset($this->theme_option["hours_enabled"]) && $this->theme_option["hours_enabled"] == "on")) {
			$form_html .= '<input type="hidden" id="wpdevart_form_checkin'.$this->booking_id.'" name="wpdevart_form_checkin'.$this->booking_id.'"><label class="wpdevart_form_checkin wpdevart_none">'.$this->for_tr["for_check_in"].'</label><input type="hidden" id="wpdevart_form_checkout'.$this->booking_id.'" name="wpdevart_form_checkout'.$this->booking_id.'" ><label class="wpdevart_form_checkout wpdevart_none">'.$this->for_tr["for_check_out"].'</label>';
		}  elseif ($this->theme_option["type_days_selection"] == "single_day" || (isset($this->theme_option["hours_enabled"]) && $this->theme_option["hours_enabled"] == "on")) {
			$form_html .= '<input type="hidden" id="wpdevart_single_day'.$this->booking_id.'" name="wpdevart_single_day'.$this->booking_id.'">';
			if(isset($this->theme_option["hours_enabled"]) && $this->theme_option["hours_enabled"] == "on" && (isset($this->theme_option["type_hours_selection"]) && $this->theme_option["type_hours_selection"] == "multiple_hours")) {
				$form_html .= '<input type="hidden" id="wpdevart_start_hour'.$this->booking_id.'" name="wpdevart_start_hour'.$this->booking_id.'"><label class="wpdevart_form_checkin wpdevart_none">'.$this->for_tr["for_start_hour"].'</label><input type="hidden" id="wpdevart_end_hour'.$this->booking_id.'" name="wpdevart_end_hour'.$this->booking_id.'"><label class="wpdevart_form_checkout wpdevart_none">'.$this->for_tr["for_end_hour"].'</label>';
			} elseif(isset($this->theme_option["hours_enabled"]) && $this->theme_option["hours_enabled"] == "on" && (isset($this->theme_option["type_hours_selection"]) && $this->theme_option["type_hours_selection"] == "single_hour")) {
				$form_html .= '<input type="hidden" id="wpdevart_form_hour'.$this->booking_id.'" name="wpdevart_form_hour'.$this->booking_id.'">';
			}
		}		  		  
		if (isset($this->theme_option["enable_number_items"]) && $this->theme_option["enable_number_items"] == "on") {
			$form_html .= $this->form_field_select(array('options'=>'','name'=>'count_item'.$this->booking_id,'class'=>'wpdevart_count_item','label'=>$this->for_tr["for_item_count"],"onchange"=>"change_count(this,".$this->booking_id.",'".((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before")? "before" : "after")."','".($this->currency)."')"));
		}
		if(isset($this->extra_field)) {
			$extra_fields = json_decode( $this->extra_field->data, true );
			$extra_title = $this->extra_field->title;
			$form_html .= '<div class="wpdevart-extras">';
			if (isset($this->theme_option["enable_extras_title"]) && $this->theme_option["enable_extras_title"] == "on") {
				$form_html .= '<h4 class="form_title">'.esc_html($extra_title).'</h4>';
			}
			foreach($extra_fields as $extra_field) {
				$form_html .= $this->extra_field($extra_field);
			}	
			$form_html .= '</div>';	
		}
		$form_html .= '</div>';
		/*FORM SECTION*/
		if(isset($this->form_data)) {
			$form_data = json_decode( $this->form_data->data, true );
			$form_title = $this->form_data->title;
			$form_html .= '<div class="wpdevart-form-section"><div class="wpdevart-reserv-info"><h4 class="form_title">'.$this->for_tr["for_reservation"].'</h4>';
			
			$form_html .= '<div id="check-info-'.$this->booking_id.'" class="check-info " data-content="'.$this->for_tr["for_select_days"].'">'.$this->for_tr["for_select_days"].'</div>';
			$form_html .= '</div>';
			if (isset($this->theme_option["enable_form_title"]) && $this->theme_option["enable_form_title"] == "on") {
				$form_html .= '<h4 class="form_title">'.esc_html($form_title).'</h4>';
			}
			foreach($form_data as $form_field) {
				if(isset($form_field['type'])) {
					$func_name = "form_field_" . $form_field['type'];
					if(method_exists($this,$func_name)) {
						$form_html .= $this->$func_name($form_field,$input_atribute);
					}
				}
			}
			if (isset($this->theme_option["enable_terms_cond"]) && $this->theme_option["enable_terms_cond"] == "on") {		  
				$form_html .= $this->form_field_checkbox(array('required'=>'on','name'=>'terms_cond'.$this->booking_id,'label'=>$this->for_tr["for_termscond"]),"",$this->theme_option["terms_cond_link"]);
			}
			$form_html .= '<button type="submit" class="wpdevart-submit"  id="wpdevart-submit'.$this->booking_id.'" name="wpdevart-submit'.$this->booking_id.'">'.$this->for_tr["for_submit_button"].'</button></div>';
		}
		$form_html .= '<input type="hidden" class="wpdevart_extra_price_value" id="wpdevart_extra_price_value'.$this->booking_id.'" name="wpdevart_extra_price_value'.$this->booking_id.'" value="">';
		$form_html .= '<input type="hidden" class="wpdevart_total_price_value" id="wpdevart_total_price_value'.$this->booking_id.'" name="wpdevart_total_price_value'.$this->booking_id.'" value="">';
		$form_html .= '<input type="hidden" class="wpdevart_price_value" id="wpdevart_price_value'.$this->booking_id.'" name="wpdevart_price_value'.$this->booking_id.'" value="">';
		$form_html .= '<input type="hidden" class="wpdevart_day_count" id="wpdevart_day_count'.$this->booking_id.'" name="wpdevart_day_count'.$this->booking_id.'" value="">';
		$form_html .= '<input type="hidden" name="id" value="'.$this->booking_id.'">';
		$form_html .= '<input type="hidden" name="task" value="save">';
		$form_html .= '</form></div></div>';
		return $form_html;
	}
	
	private function form_field_text($form_field,$input_atribute=''){
		$input_class = array();
		$field_html = '';
		$readonly = '';
		$required = '';
		if(isset($form_field['required'])) {
			$required .= '<span class="wpdevart-required">*</span>';
			$input_class[] = 'wpdevart-required';
		}		
		if(isset($form_field['isemail']) && $form_field['isemail'] == "on" ) {
			$input_class[] = 'wpdevart-email';
		}			
		if(isset($form_field['class']) && $form_field['class'] != "" ) {
			$input_class[] = $form_field['class'];
		}		
		if(isset($form_field['readonly']) && $form_field['readonly'] == "true" ) {
			$readonly = "readonly";
		}	
		if(count($input_class)) {
			$input_class = implode(" ",$input_class);
			$class = "class='".$input_class."'";
		} else {
			$class = "";
		}
		$field_html .= '<div class="wpdevart-fild-item-container">
							<label for="wpdevart_'.$form_field['name'].'" '.$class.'>'.esc_html($form_field['label']).$required. '</label>';
		$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'">
				  <input type="text" id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$form_field['name'].'" '.$input_atribute.' '.$class.' ' .$readonly. '>
			    </div>
		     </div>';
		return $field_html;
	}
	
	private function form_field_textarea($form_field,$input_atribute=''){
		$input_class = '';
		$field_html = '';
		$field_html .= '<div class="wpdevart-fild-item-container">
							<label for="wpdevart_'.$form_field['name'].'">'.esc_html($form_field['label']).'</label>';
		if(isset($form_field['required'])) {
			$field_html .= '<span class="wpdevart-required">*</span>';
			$input_class = 'class="wpdevart-required"';
		}		
		$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'">
				  <textarea id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$form_field['name'].'" '.$input_class.'></textarea>
			    </div>
		     </div>';
		return $field_html;
	}
	
	private function form_field_select($form_field,$input_atribute=''){
		$select_options = explode(PHP_EOL, $form_field['options']);
		$input_class = '';
		$field_html = '';
		if(count($select_options)){
			$field_html .= '<div class="wpdevart-fild-item-container">
								<label for="wpdevart_'.$form_field['name'].'">'.esc_html($form_field['label']).'</label>';
			if(isset($form_field['required'])) {
				$field_html .= '<span class="wpdevart-required">*</span>';
				$input_class = 'wpdevart-required ';
			}	
			if(isset($form_field['class']) && $form_field['class'] != "" ) {
				$input_class .= $form_field['class'];
			}			
			$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'"><select id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$form_field['name'].'"';
			if(isset($form_field['multi'])) {
				$field_html .= 'multiple="multiple"';
			}
			if(isset($form_field['onchange'])) {
				$field_html .= 'onchange="'.$form_field['onchange'].'"';
			}
			$field_html .= ' class="'.$input_class.'">';
			foreach($select_options as $select_option) {
				if(trim($select_option) != '') {
					$field_html .= '<option value="'.esc_html($select_option).'">'.esc_html($select_option).'</option>';
				}
			}		  
			$field_html .= '</select>
					</div>
				 </div>';
		}
		else {
			$field_html .= 'No options';
		}		
		return $field_html;
	}
	
	private function extra_field($extra_field){
		$select_options = $extra_field['items'];
		$input_class = '';
		$field_html = '';
		if(count($select_options)){
			$field_html .= '<div class="wpdevart-fild-item-container">
								<label for="wpdevart_'.$extra_field['name'].'">'.esc_html($extra_field['label']).'</label>';
			if(isset($extra_field['required'])) {
				$input_class = "wpdevart-required";
			}		
			if(isset($extra_field['independent']) && $extra_field['independent'] == "on") {
				$input_class .= " wpdevart-independent";
			}
			$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$extra_field['name'].'"><select onchange="change_extra(this,\''.((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before")? "before" : "after").'\',\''.($this->currency).'\')" class="wpdevart_extras '.$input_class.'" id="wpdevart_'.$extra_field['name'].'" name="wpdevart_'.$extra_field['name'].'">';
			foreach($select_options as $select_option) {
				$field_html .= '<option value="'.$select_option["name"].'" data-operation="'.$select_option["operation"].'" data-type="'.$select_option["price_type"].'" data-price="'.$select_option["price_percent"].'" data-label="'.$select_option["label"].'">'.$select_option["label"].' '.(($select_option["price_percent"])? '('.$select_option["operation"].(((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before" && $select_option["price_type"] == "price") ? $this->currency : '') . $select_option["price_percent"] . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after" && $select_option["price_type"] == "price") || !isset($this->theme_option['currency_pos'])) ? $this->currency : '')).(($select_option["price_type"] == "price")? "" : "%").')' : '').'</option>';
			}		  
			$field_html .= '</select>
					</div>
				 </div>';
		}
		else {
			$field_html .= __('No options','booking-calendar');
		}		
		return $field_html;
	}
	
	private function form_field_checkbox($form_field,$input_atribute='',$link=''){
		$input_class = '';
		$field_html = '';
		$field_html .= '<div class="wpdevart-fild-item-container">';
		if($link != "") {
			$field_html .= '<label for="wpdevart_'.$form_field['name'].'"><a href="'.esc_url($link).'" target="_blank">'.$form_field['label'].'</a></label>';
		} else {
			$field_html .= '<label for="wpdevart_'.$form_field['name'].'">'.esc_html($form_field['label']);
		}
		if(isset($form_field['required'])) {
			$field_html .= '<span class="wpdevart-required">*</span>';
			$input_class = 'class="wpdevart-required"';
		}		
		$field_html .= '</label>';
		$field_html .= '<div class="wpdevart-elem-container div-for-clear" id="wpdevart_wrap_'.$form_field['name'].'">
				  <input type="checkbox" id="wpdevart_'.$form_field['name'].'" name="wpdevart_'.$form_field['name'].'" '.$input_class.'>
			    </div>
		     </div>';
		return $field_html;
	}
	
			
	private function get_day($date, $type = 1) {
		$date      = date('Y n j', strtotime( $date ));
		$date_info = explode(' ', $date);
		$jd        = cal_to_jd( CAL_GREGORIAN, $date_info[1], $date_info[2], $date_info[0] );

		return jddayofweek( $jd, $type );
	}
	
	private function get_date_diff($date1, $date2) {
		$start = strtotime($date1);
		$end = strtotime($date2);
		$datediff = $start - $end;
		return floor($datediff/(60*60*24));
	}

	private function search_in_array($needle, $haystack) {
		$array_iterator = new RecursiveArrayIterator( $haystack );
		$iterator       = new RecursiveIteratorIterator( $array_iterator );
		while ($iterator->valid()) {
			if (( $iterator->current() == $needle )) {
				return $array_iterator->key();
			}
			$iterator->next();
		}
		return false;
	}
	
	
	private function calculate_date( $start_date, $action, $type ) {
		$date    = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( $start_date ) ) . " " . $action . " " . $type ));
		$date    = explode('-', $date);
		$new_date = array(
			'year'  => $date[0],
			'month' => $date[1],
			'day'   => $date[2]
		);
		return $new_date;
	}

	private function get_month_name( $date, $type = 1 ) {
		$date       = date('Y n j', strtotime( $date ));
		$date_info = explode(' ', $date);
		$jd         = cal_to_jd(CAL_GREGORIAN, $date_info[1], $date_info[2], $date_info[0]);
		return __(jdmonthname( $jd, $type ));
	}
	
	
	public function save_reserv($data,$submit){
		global $wpdb;
		$save = false;
		$send_mail = array();
		$emails = "";
		$email_array = array();
		if(isset($this->theme_option['enable_instant_approval']) && $this->theme_option['enable_instant_approval'] == "on") {
			$status = "approved";
		} else {
			$status = "pending";
		}
		$form = array();
		$extras = array();
		$extra_data = array();
		foreach($data as $key=>$item) {
			if(strrpos($key,"form_field") !== false) {
				$form[$key] = esc_html($item);		
			}
			if(strrpos($key,"extra_field") !== false) {
				$extras[$key] = esc_html($item);		
			}
		}
		
		$currency = (isset($this->currency) ? $this->currency : '');
		$check_in = (isset($data['wpdevart_form_checkin'.$submit]) ? esc_html(stripslashes( $data['wpdevart_form_checkin'.$submit])) : '');
		$check_out = (isset($data['wpdevart_form_checkout'.$submit]) ? esc_html(stripslashes( $data['wpdevart_form_checkout'.$submit])) : '');
		if($check_in)
			$check_in = date("Y-m-d", strtotime($check_in));
		if($check_out)
			$check_out = date("Y-m-d",strtotime($check_out));
		
		$single_day = (isset($data['wpdevart_single_day'.$submit]) ? esc_html(stripslashes( $data['wpdevart_single_day'.$submit])) : '');
		if($single_day)
			$single_day = date("Y-m-d",strtotime($single_day));
		/*Start hour or hour*/
		$start_hour = (isset($data['wpdevart_start_hour'.$submit]) ? esc_html(stripslashes( $data['wpdevart_start_hour'.$submit])) : (isset($data['wpdevart_form_hour'.$submit]) ? esc_html(stripslashes( $data['wpdevart_form_hour'.$submit])) : ""));
		$end_hour = (isset($data['wpdevart_end_hour'.$submit]) ? esc_html(stripslashes( $data['wpdevart_end_hour'.$submit])) : '');
		$count_item = (isset($data['wpdevart_count_item'.$submit]) ? esc_html(stripslashes( $data['wpdevart_count_item'.$submit])) : 1);
		$total_price = (isset($data['wpdevart_total_price_value'.$submit]) ? esc_html(stripslashes( $data['wpdevart_total_price_value'.$submit])) : '');
		$price = (isset($data['wpdevart_price_value'.$submit]) ? esc_html(stripslashes( $data['wpdevart_price_value'.$submit])) : '');
		$extras_price = (isset($data['wpdevart_extra_price_value'.$submit]) ? esc_html(stripslashes( $data['wpdevart_extra_price_value'.$submit])) : '');
		$wpdevart_day_count = (isset($data['wpdevart_day_count'.$submit]) ? esc_html(stripslashes( $data['wpdevart_day_count'.$submit])) : 1);
		
		
		
		$form_datas = json_decode($this->form_data->data,true);
		foreach($form_datas as $key => $form_data) {
			if(isset($form_data["isemail"]) && $form_data["isemail"]) {
				if(isset($form["wpdevart_".$key]) && $form["wpdevart_".$key] != "") {
					$email_array[] = $form["wpdevart_".$key];
				}
			}
		}
        if(count($email_array)) {
			$emails = implode(",",$email_array);
		}
		
		/*Item count*/
		if($check_in) {
			$item_count = $wpdevart_day_count;
		} else {
			$item_count = 1;
		}
		if(isset($single_day) && $single_day != "") {
			$unique_id = $this->id."_".$single_day;
			$day_hours = $this->get_date_data( $unique_id );
			$day_hours = json_decode($day_hours, true);
		}
		$hour_count = 0;
		if(isset($day_hours["hours"]) && count($day_hours["hours"])){
			$start = 0;
			foreach($day_hours["hours"] as $key => $hour) {
				if($key == $start_hour) {
					$start = 1;
				} 
				if($start == 1 && (!($end_hour == "" && $hour_count == 1))) { 
					$hour_count += 1;
				}
				if($key == $end_hour){ 
					$start = 0;
				}
			} 
		}
		if($hour_count) {
			$item_count = $hour_count;
		}
		
		
		if(isset($this->extra_field)) {
			$extra_fields = json_decode( $this->extra_field->data, true );
			foreach($extras as $key => $extra) {
				$ex_key = str_replace("wpdevart_", "", $key);
				if(isset($extra_fields[$ex_key]['items'][$extra])) {
					if($extra_fields[$ex_key]['items'][$extra]["price_type"] == "price") {
						if(!isset($extra_fields[$ex_key]['independent'])) {
							$extra_fields[$ex_key]['items'][$extra]['price_percent'] = $extra_fields[$ex_key]['items'][$extra]['price_percent'] * $item_count * $count_item;
						} else {
							$extra_fields[$ex_key]['items'][$extra]['price_percent'] = $extra_fields[$ex_key]['items'][$extra]['price_percent'] * $count_item;
						}
					}
					$extra_data["".$ex_key.""] = $extra_fields[$ex_key]['items'][$extra];
				}
			}
		}
		$form = json_encode($form);
		$extra_data = json_encode($extra_data);
				
		$save_in_db = $wpdb->insert($wpdb->prefix . 'wpdevart_reservations', array(
			'calendar_id' => $this->id,                       
			'single_day' => $single_day,                       
			'check_in' => $check_in,         
			'check_out' => $check_out,         
			'start_hour' => $start_hour,         
			'end_hour' => $end_hour,         
			'currency' => $currency,         
			'count_item' => $count_item,         
			'price' => $price,         
			'total_price' => $total_price,         
			'extras' => $extra_data,         
			'extras_price' => $extras_price,         
			'form' => $form,         
			'address_billing' => '',         
			'address_shipping' => '',         
			'email' => $emails,         
			'status' => $status,         
			'payment_method' => '',         
			'payment_status' => '',         
			'date_created' => date('Y-m-d H:i',time())        
		  ), array(
			'%d',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%d',
			'%d',
			'%d',
			'%s',
			'%d',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		  ));
		 if($save_in_db) {
			$save = true;
			$id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wpdevart_reservations');
			if($status == "approved") {
				$this->change_date_avail_count($id,true);
			}
			$send_mail = $this->send_mail($emails,$form,$extra_data,$count_item,$price,$currency,$total_price,$extras_price,$check_in,$check_out,$single_day,$start_hour, $end_hour);
		 } 
		$result = array($save, $send_mail); 
		return $result;	
	}
	private function send_mail($emails,$form_data,$extras_data,$count_item,$price,$currency,$total_price,$extras_price,$check_in,$check_out,$single_day,$start_hour, $end_hour){
		$admin_email_types = array();
		$user_email_types = array();
		$admin_error_types = array();
		$user_error_types = array();
		$hour_html = "";
		$form_data = $this->get_form_data($form_data);
        $extras_data = $this->get_extra_data($extras_data,$price);
		if($check_in) {
			$check_in = date($this->theme_option["date_format"], strtotime($check_in));
			$check_out = date($this->theme_option["date_format"], strtotime($check_out));
			$res_day = $check_in. "-" .$check_out;
		} else {
			$res_day = date($this->theme_option["date_format"], strtotime($single_day));
		}
		if(isset($start_hour) && $start_hour != ""){
			$hour_html = $start_hour;
		}
		if(isset($end_hour) && $end_hour != ""){
			$hour_html = $hour_html." - ".$end_hour;
		}
		if($hour_html != ""){
			$hour_html = "<tr><td style='padding: 1px 7px;'>".__('Hour','booking-calendar')."</td> <td  style='padding: 1px 7px;'>".$hour_html.'</td></tr>';
		}
		$site_url = site_url();
		$address_list = [
			'Los Angeles, CA' => '5250 Lankershim Blvd, 5th floor, #536 North Hollywood, CA 91601',
			'Tenafly NJ' => '1 Engle Street Tenafly, NJ 07670',
			'Westchester, NY' => '699 Westchester Ave Rye Brook, NY 10573',
			'New York, NY' => '29 W 36th Street, 7th Fl (b/w 5th & 6th) New York, NY 10018',
			'Plainview, NY' => '333 South Service Road Plainview, NY 11803',
			'Manhasset, NY' => '333 Searingtown Road Manhasset, NY 11030'
		];
		$moderate_link = admin_url() . "admin.php?page=wpdevart-reservations";
		$res_info = "<table border='1' style='border-collapse:collapse;min-width: 360px;'>
						<caption style='text-align:left;'>".__('Details','booking-calendar')."</caption>
<tr><td style='padding: 1px 7px;'>".__('Location','booking-calendar')."</td><td style='padding: 1px 7px;'>".$this->calendar_title."</td></tr>
<tr><td style='padding: 1px 7px;'>".__('Address','booking-calendar')."</td><td style='padding: 1px 7px;'>".$address_list[$this->calendar_title]."</td></tr>
						<tr><td style='padding: 1px 7px;'>".__('Test Date','booking-calendar')."</td><td style='padding: 1px 7px;'>".$res_day."</td></tr>".$hour_html."
					</table>";
		$form = "";
		$extras = "";		
		if(count($form_data)) {
			$form .= "<table border='1' style='border-collapse:collapse;min-width: 360px;'>";
			$form .= "<caption style='text-align:left;'>Contact Information</caption>";
			foreach($form_data as $form_fild_data) {
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
					$extras .= "<span class='price'>".$extra_data["operation"] . ((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($currency) : '') . $extra_data["price"] . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($currency) : '')."</span></td></tr>";
				} else {
					$extras .= "<span class='price'>".$extra_data["operation"] .((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($currency) : '') . $extra_data["price"] . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($currency) : '')."</span></td></tr>";
				}
				
			}
			$extras .= "<tr><td style='padding: 1px 7px;'>Price change</td><td style='padding: 1px 7px;'>".(($extras_price<0)? "" : "+").((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "before") ? esc_html($currency) : '') . $extras_price . (((isset($this->theme_option['currency_pos']) && $this->theme_option['currency_pos'] == "after") || !isset($this->theme_option['currency_pos'])) ? esc_html($currency) : '')."</td></tr>";
			$extras .= "</table>";
		}
		if(isset($this->theme_option['notify_admin_on_book']) && $this->theme_option['notify_admin_on_book'] == "on") {
			$admin_email_types[] = 'notify_admin_on_book';
		}
		if(isset($this->theme_option['notify_user_on_book']) && $this->theme_option['notify_user_on_book'] == "on") {
			$user_email_types[] = 'notify_user_on_book';
		}
		if(isset($this->theme_option['enable_instant_approval']) && $this->theme_option['enable_instant_approval'] == "on") {
			if(isset($this->theme_option['notify_admin_on_approved']) && $this->theme_option['notify_admin_on_approved'] == "on") {
				$admin_email_types[] = 'notify_admin_on_approved';
			}
			if(isset($this->theme_option['notify_user_on_approved']) && $this->theme_option['notify_user_on_approved'] == "on") {
				$user_email_types[] = 'notify_user_on_approved';
			}
		}	
			/*Email to admin*/
		if(count($admin_email_types)) {	
			foreach($admin_email_types as $admin_email_type) {
				$to = "";
				$from = "";
				$fromname = "";
				$subject = "";
				$content = "";
				if(isset($this->theme_option[$admin_email_type.'_to']) && $this->theme_option[$admin_email_type.'_to'] != "") {
					$to = stripslashes($this->theme_option[$admin_email_type.'_to']);
				}
				if(isset($this->theme_option[$admin_email_type.'_fromname']) && $this->theme_option[$admin_email_type.'_fromname'] != "") {
					$fromname = stripslashes($this->theme_option[$admin_email_type.'_fromname']);
				}
				if(isset($this->theme_option[$admin_email_type.'_subject']) && $this->theme_option[$admin_email_type.'_subject'] != "") {
					$subject = stripslashes($this->theme_option[$admin_email_type.'_subject']);
				}
				if(isset($this->theme_option[$admin_email_type.'_content']) && $this->theme_option[$admin_email_type.'_content'] != "") {
					$content = stripslashes($this->theme_option[$admin_email_type.'_content']);
					$content = str_replace("[calendartitle]", $this->calendar_title, $content);
					$content = str_replace("[details]", $res_info, $content);
					$content = str_replace("[siteurl]", $site_url, $content);
					$content = str_replace("[moderatelink]", $moderate_link, $content);
					$content = str_replace("[form]", $form, $content);
					$content = str_replace("[extras]", $extras, $content);
					$content = "<div class='wpdevart_email' style='color:#5A5A5A !important;line-height: 1.5;'>".$content."</div>";
				}
				if(isset($this->theme_option[$admin_email_type.'_from']) && $this->theme_option[$admin_email_type.'_from'] != "") {
					if(trim($this->theme_option[$admin_email_type.'_from']) == "[useremail]") {
						$from = "From: '" . $fromname . "' <" . $emails . ">" . "\r\n";
					} else {
						$from = "From: '" . $fromname . "' <" . stripslashes($this->theme_option[$admin_email_type.'_from']) . ">" . "\r\n";
					}
				}
				$headers = "MIME-Version: 1.0\n" . $from . " Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\n";
				
				$admin_error_types[$admin_email_type] = wp_mail($to, $subject, $content, $headers);
			}	
		}	
			/*Email to user*/
		if(count($user_email_types)) {	
			foreach($user_email_types as $user_email_type) {	
				$from = "";
				$fromname = "";
				$subject = "";
				$content = "";
				$to = $emails;
				if(isset($this->theme_option[$user_email_type.'_subject']) && $this->theme_option[$user_email_type.'_subject'] != "") {
					$subject = stripslashes($this->theme_option[$user_email_type.'_subject']);
				}
				if(isset($this->theme_option[$user_email_type.'_fromname']) && $this->theme_option[$user_email_type.'_fromname'] != "") {
					$fromname = stripslashes($this->theme_option[$user_email_type.'_fromname']);
				}
				if(isset($this->theme_option[$user_email_type.'_content']) && $this->theme_option[$user_email_type.'_content'] != "") {
					$content = stripslashes($this->theme_option[$user_email_type.'_content']);
					$content = str_replace("[calendartitle]", $this->calendar_title, $content);
					$content = str_replace("[details]", $res_info, $content);
					$content = str_replace("[siteurl]", $site_url, $content);
					$content = str_replace("[form]", $form, $content);
					$content = str_replace("[extras]", $extras, $content);
					$content = "<div class='wpdevart_email' style='color:#5A5A5A !important;line-height: 1.5;'>".$content."</div>";
				}
				if(isset($this->theme_option[$user_email_type.'_from']) && $this->theme_option[$user_email_type.'_from'] != "") {
					$from = "From: '" . $fromname . "' <" . stripslashes($this->theme_option[$user_email_type.'_from']) . ">" . "\r\n";
				}
				$headers = "MIME-Version: 1.0\n" . $from . " Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\n";
				
				$user_error_types[$user_email_type] = wp_mail($to, $subject, $content, $headers);
			}
		}	
		$result = array($admin_error_types,$user_error_types);
		return 	$result;
	}
	
	public function get_styles(){
		if(isset($this->theme_option)){
			extract($this->theme_option);
		}
		
		$booking_colors_styles = "<style>
		   #booking_calendar_container_".$this->booking_id." .wpdevart-load-image .fa{
			   color:".(isset($load_spinner_color) ? $load_spinner_color : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-day{
			   background-color:".(isset($day_bg) ? $day_bg : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpda-booking-calendar-head{
			   background-color:".(isset($calendar_header_bg) ? $calendar_header_bg : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpda-previous *,#booking_calendar_container_".$this->booking_id." .wpda-next *{
			   color:".(isset($next_prev_month) ? $next_prev_month : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpda-current-year{
			   color:".(isset($current_year) ? $current_year : '').";
			   font-size:".(isset($current_year_size) ? $current_year_size : '')."px;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpda-current-month{
			   color:".(isset($current_month) ? $current_month : '').";
			   font-size:".(isset($current_month_size) ? $current_month_size : '')."px;
		   } 
		   #booking_calendar_container_".$this->booking_id." .week-day-name .wpda-day-header{
			   background-color:".(isset($week_days_bg) ? $week_days_bg : '').";
		   }
		   #booking_calendar_container_".$this->booking_id." .wpdevart-calendar-container{
			   background-color:".(isset($calendar_bg) ? $calendar_bg : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-calendar-container > div{
			   border-right-color:".(isset($calendar_border) ? $calendar_border : '').";
			   border-bottom-color: ".(isset($calendar_border) ? $calendar_border : '').";
		   }  
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-price,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-item{
			   border-color:".(isset($calendar_border) ? $calendar_border : '').";
		   }  
		   #booking_calendar_container_".$this->booking_id." .wpda-booking-calendar-head{
			   border-color:".(isset($calendar_border) ? $calendar_border : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-calendar-container > div:nth-child(7n+1),
		   #booking_calendar_container_".$this->booking_id." .wpdevart-calendar-container > div:first-child{
			   border-left-color: ".(isset($calendar_border) ? $calendar_border : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpda-day-header{
			   background-color:".(isset($day_number_bg) ? $day_number_bg : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-item.wpdevart-hour-available,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-available{
			   background-color:".(isset($available_day_bg) ? $available_day_bg : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-available .wpdevart-hour span,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-available .wpda-day-header{
			   background-color:".(isset($available_day_number_bg) ? $available_day_number_bg : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-available .wpdevart-hour span,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-available .wpda-day-header .wpda-day-number{
			   color:".(isset($available_day_color) ? $available_day_color : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-item.hour_selected .wpdevart-hour span,
		   #booking_calendar_container_".$this->booking_id." div.selected .wpda-day-header{
			   background-color:".(isset($selected_day_number_bg) ? $selected_day_number_bg : '')." !important;
		   }
		   #booking_calendar_container_".$this->booking_id." div.hour_selected,
		   #booking_calendar_container_".$this->booking_id." div.selected{
			   background-color:".(isset($selected_day_bg) ? $selected_day_bg : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-item{
			   width:".(isset($hours_width) ? $hours_width : '')."px;
			   height:".(isset($hours_height) ? $hours_height : '')."px;
		   } 
		   #booking_calendar_container_".$this->booking_id." div.selected .wpdevart-hour-item.hour_selected .wpdevart-hour span,
		   #booking_calendar_container_".$this->booking_id." div.selected .wpda-day-header .wpda-day-number{
			   color:".(isset($selected_day_color) ? $selected_day_color : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-unavailable .wpda-day-header .wpda-day-number,#booking_calendar_container_".$this->booking_id." .wpdevart-hour-unavailable .wpdevart-hour span{
			   color:".(isset($unavailable_day_color) ? $unavailable_day_color : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-unavailable .wpda-day-header,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-unavailable .wpdevart-hour span{
			   background-color:".(isset($unavailable_day_number_bg) ? $unavailable_day_number_bg : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-unavailable,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-unavailable{
			   background-color:".(isset($unavailable_day_bg) ? $unavailable_day_bg : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-booked .wpdevart-hour span,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-booked .wpda-day-header .wpda-day-number{
			   color:".(isset($booked_day_color) ? $booked_day_color : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-booked .wpdevart-hour span,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-booked .wpda-day-header{
			   background-color:".(isset($booked_day_number_bg) ? $booked_day_number_bg : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-item.wpdevart-hour-booked,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-booked{
			   background-color:".(isset($booked_day_bg) ? $booked_day_bg : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .day-user-info-container{
			   border:1px solid ".(isset($info_icon_color) ? $info_icon_color : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .day-user-info-container{
			   color:".(isset($info_icon_color) ? $info_icon_color : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .day-user-info{
			   background-color:".(isset($info_bg) ? $info_bg : '').";
			   color:".(isset($info_color) ? $info_color : '').";
			   font-weight:".(isset($info_font_weight) ? $info_font_weight : '').";
			   font-style:".(isset($info_font_style) ? $info_font_style : '').";
			   font-size:".(isset($info_size) ? $info_size : '')."px;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hours-container .wpdevart-hour-info{
			   font-weight:".(isset($info_font_weight) ? $info_font_weight : '').";
			   font-style:".(isset($info_font_style) ? $info_font_style : '').";
			   font-size:".(isset($info_size) ? $info_size : '')."px;
		   } 
		   #booking_calendar_container_".$this->booking_id." .error_text_container{
			   background-color:".(isset($error_info_bg) ? $error_info_bg : '').";
			   color:".(isset($error_info_color) ? $error_info_color : '').";
			   border:1px solid ".(isset($error_info_border) ? $error_info_border : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .error_text_container .notice_text_close{
			   background-color:".(isset($error_info_close_bg) ? $error_info_close_bg : '').";
			   color:".(isset($error_info_close_color) ? $error_info_close_color : '').";
		   }
		   #booking_calendar_container_".$this->booking_id." .successfully_text_container{
			   background-color:".(isset($successfully_info_bg) ? $successfully_info_bg : '').";
			   color:".(isset($successfully_info_color) ? $successfully_info_color : '').";
			   border:1px solid ".(isset($successfully_info_border) ? $successfully_info_border : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .successfully_text_container .notice_text_close{
			   background-color:".(isset($successfully_info_close_bg) ? $successfully_info_close_bg : '').";
			   color:".(isset($successfully_info_close_color) ? $successfully_info_close_color : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .day-availability{
			    font-size: ".(isset($day_availability_size) ? $day_availability_size : '')."px;
				font-style: ".(isset($day_availability_font_style) ? $day_availability_font_style : '').";
				font-weight: ".(isset($day_availability_font_weight) ? $day_availability_font_weight : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-available .day-availability,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-available .day-availability *,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-available .day-availability,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-available .day-availability *{
				color: ".(isset($day_availability_color) ? $day_availability_color : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-price *,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-day .day-price{
			    font-size: ".(isset($day_price_size) ? $day_price_size : '')."px;
				color: ".(isset($day_price_color) ? $day_price_color : '').";
				font-style: ".(isset($day_price_font_style) ? $day_price_font_style : '').";
				font-weight: ".(isset($day_price_font_weight) ? $day_price_font_weight : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-day .day-price *{
				color: ".(isset($day_price_color) ? $day_price_color : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .hour_selected .day-availability,
		   #booking_calendar_container_".$this->booking_id." .hour_selected .day-availability *,
		   #booking_calendar_container_".$this->booking_id." .selected .day-availability,
		   #booking_calendar_container_".$this->booking_id." .selected .day-availability *{
				color: ".(isset($selected_day_availability_color) ? $selected_day_availability_color : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .hour_selected .wpdevart-hour-price *,
		   #booking_calendar_container_".$this->booking_id." .selected.wpdevart-day .day-price *{
				color: ".(isset($selected_day_price_color) ? $selected_day_price_color : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-unavailable.wpdevart-day .day-availability,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-unavailable .day-availability{
				color: ".(isset($unavailable_day_availability_color) ? $unavailable_day_availability_color : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-hour-booked .day-availability,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-booked .day-availability{
				color: ".(isset($booked_day_availability_color) ? $booked_day_availability_color : '')." !important;
		   } 
		   #wpdevart_booking_form_".$this->booking_id." .wpdevart-booking-form{
			   background-color:".(isset($form_bg) ? $form_bg : '').";
			   border:1px solid ".(isset($form_border) ? $form_border : '').";
		   } 
		   #wpdevart_booking_form_".$this->booking_id." .wpdevart-fild-item-container *{
			   color:".(isset($form_fields_color) ? $form_fields_color : '').";
			   font-size:".(isset($form_fields_size) ? $form_fields_size : '')."px;
			   font-weight:".(isset($form_fields_weight) ? $form_fields_weight : '').";
			   font-style:".(isset($form_fields_style) ? $form_fields_style : '').";
		   } 
		   #wpdevart_booking_form_".$this->booking_id." span.wpdevart-required{
			  color:".(isset($required_star_color) ? $required_star_color : '').";
		   } 
		   #wpdevart_booking_form_".$this->booking_id." button.wpdevart-submit{
			  background:".(isset($submit_button_bg) ? $submit_button_bg : '').";
			  color:".(isset($submit_button_color) ? $submit_button_color : '').";
			  font-weight:".(isset($form_submit_weight) ? $form_submit_weight : '').";
			  font-style:".(isset($form_style_style) ? $form_style_style : '').";
		   } 
		   #booking_calendar_main_container_".$this->booking_id." .wpdevart-legends-available .legend-div{
			   background-color:".(isset($available_day_number_bg) ? $available_day_number_bg : '').";
		   } 
		   #booking_calendar_main_container_".$this->booking_id." .wpdevart-legends-unavailable .legend-div{
			   background-color:".(isset($unavailable_day_number_bg) ? $unavailable_day_number_bg : '').";
		   } 
		   #booking_calendar_main_container_".$this->booking_id." .wpdevart-legends-pending .legend-div{
			   background-color:".(isset($booked_day_number_bg) ? $booked_day_number_bg : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id.",#wpdevart_booking_form_".$this->booking_id."{
			   max-width:".(isset($calendar_max_width) ? $calendar_max_width : '')."px;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpda-booking-calendar-head{
			   padding:".(isset($calendar_header_padding) ? $calendar_header_padding : '')."px;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpda-previous *, #booking_calendar_container_".$this->booking_id." .wpda-next *{
			   font-size:".(isset($next_prev_month_size) ? $next_prev_month_size : '')."px;
		   } 
		   #booking_calendar_container_".$this->booking_id." .week-day-name .wpda-day-number{
			   font-size:".(isset($week_days_size) ? $week_days_size : '')."px;
			   font-weight:".(isset($week_days_font_weight) ? $week_days_font_weight : '').";
			   font-style:".(isset($week_days_font_style) ? $week_days_font_style : '').";
			   color:".(isset($week_days_color) ? $week_days_color : '')." !important;
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpda-day-number{
			   font-size:".(isset($day_number_size) ? $day_number_size : '')."px;
			   font-weight:".(isset($day_number_font_weight) ? $day_number_font_weight : '').";
			   font-style:".(isset($day_number_font_style) ? $day_number_font_style : '').";
			   color:".(isset($day_color) ? $day_color : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpdevart-calendar-container > div:not(.week-day-name){
			   height:".(isset($days_min_height) ? $days_min_height : '')."px;
		   } 
		   #booking_calendar_container_".$this->booking_id." .day-user-info-container{
			   border-radius:".(isset($info_border_radius) ? $info_border_radius : '')."px;
		   } 
		   #wpdevart_booking_form_".$this->booking_id." .wpdevart-fild-item-container label,
		   #wpdevart_booking_form_".$this->booking_id." .wpdevart-fild-item-container label a{
			   font-size:".(isset($form_labels_size) ? $form_labels_size : '')."px;
			   color:".(isset($form_labels_color) ? $form_labels_color : '').";
			   font-weight:".(isset($form_labels_weight) ? $form_labels_weight : '').";
			   font-style:".(isset($form_labels_style) ? $form_labels_style : '').";
		   } 
		   #booking_calendar_container_".$this->booking_id." .wpda-booking-calendar-head *{
			   font-weight:".(isset($calendar_header_font_weight) ? $calendar_header_font_weight : '').";
			   font-style:".(isset($calendar_header_font_style) ? $calendar_header_font_style : '').";
		   } 
		   #wpdevart_booking_form_".$this->booking_id." h4.form_title{
			   font-weight:".(isset($form_title_weight) ? $form_title_weight : '').";
			   font-style:".(isset($form_title_style) ? $form_title_style : '').";
			   font-size:".(isset($form_title_size) ? $form_title_size : '')."px;
			   color:".(isset($form_title_color) ? $form_title_color : '').";
			   background-color:".(isset($form_title_bg) ? $form_title_bg : '').";
		   } 
		   #wpdevart_booking_form_".$this->booking_id." .wpdevart-extra-info.wpdevart-extra-0{
			   border-top: 1px solid ".(isset($form_title_bg) ? $form_title_bg : '').";
		   }
		   #wpdevart_booking_form_".$this->booking_id." .wpdevart-reserv-info{
			   border-bottom: 1px solid ".(isset($form_title_bg) ? $form_title_bg : '').";
		   }
		   #wpdevart_booking_form_".$this->booking_id." .check-info{
			   font-weight:".(isset($reserv_info_weight) ? $reserv_info_weight : '').";
			   font-style:".(isset($reserv_info_style) ? $reserv_info_style : '').";
			   font-size:".(isset($reserv_info_size) ? $reserv_info_size : '')."px;
			   color:".(isset($reserv_info_color) ? $reserv_info_color : '').";
		   } 
		   #wpdevart_booking_form_".$this->booking_id." .wpdevart-total-price.reserv_info_row{
			   background-color:".(isset($total_bg) ? $total_bg : '').";
			   color:".(isset($total_color) ? $total_color : '').";
		   }
		   #booking_calendar_container_".$this->booking_id." .booking_widget_day{
				background-color: ".(isset($widget_day_info_bg) ? $widget_day_info_bg : '').";
				border: 1px solid ".(isset($widget_day_info_border_color) ? $widget_day_info_border_color : '').";
		   }
		   #booking_calendar_container_".$this->booking_id." .widget-day-user-info{
				border-bottom: 1px solid ".(isset($widget_day_info_border_color) ? $widget_day_info_border_color : '').";
		   }
		   #booking_calendar_container_".$this->booking_id." .booking_widget_day *{
				color: ".(isset($widget_day_info_color) ? $widget_day_info_color : '')." !important;
				font-style: ".(isset($widget_day_info_style) ? $widget_day_info_style : '')." !important;
				font-size: ".(isset($widget_day_info_size) ? $widget_day_info_size : '')."px !important;
				font-weight: ".(isset($widget_day_info_weight) ? $widget_day_info_weight : '')." !important;
		   }
		   #booking_calendar_container_".$this->booking_id." .wpdevart-available  .booking_widget_day *,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-booked  .booking_widget_day *,
		   #booking_calendar_container_".$this->booking_id." .wpdevart-unavailable  .booking_widget_day *{
				color: ".(isset($widget_day_info_color) ? $widget_day_info_color : '')." !important;
		   }
		   
		   
		</style>";
		return $booking_colors_styles;
	}

	
	private function change_date_avail_count( $id,$approve ){
		global $wpdb; 	
		$reserv_info = $wpdb->get_row($wpdb->prepare('SELECT calendar_id, single_day, check_in, check_out, start_hour, 	end_hour, count_item, status FROM ' . $wpdb->prefix . 'wpdevart_reservations WHERE id="%d"', $id),ARRAY_A);
		if(isset($reserv_info["count_item"])) {
			$count_item = $reserv_info["count_item"];
		} else {
			$count_item = 1;
		}
		$cal_id = $reserv_info["calendar_id"]; 
		if($reserv_info["single_day"] == "") {
			$start_date = $reserv_info["check_in"];
			$date_diff = abs($this->get_date_diff($reserv_info["check_in"],$reserv_info["check_out"]));
			for($i=0; $i <= $date_diff; $i++) {
				if(isset($this->theme_option["price_for_night"]) && $this->theme_option["price_for_night"] == "on"  && $i == $date_diff){
					continue;
				}
				$day = date( 'Y-m-d', strtotime($start_date. " +" . $i . " day" ));
				$unique_id = $cal_id."_".$day;
				$day_data = json_decode($this->get_date_data( $unique_id ),true);
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
			$day_data = json_decode($this->get_date_data( $unique_id ),true);
			if($approve === true) {
				if($reserv_info["end_hour"] == "" && $reserv_info["start_hour"] == "") {
					$day_data["available"] = $day_data["available"] - $count_item;
				} else {
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
	private function get_date_data( $unique_id ) {
		global $wpdb;
		$row = $wpdb->get_row($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_dates WHERE unique_id="%s"', $unique_id),ARRAY_A);
		$date_info = $row["data"];
		return $date_info;
	}
	
	private function get_reservation_row_calid( $id, $date ) {
		global $wpdb;
		$rows = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpdevart_reservations WHERE calendar_id= '.$id.' and (check_in <= %s and check_out >= %s) or single_day = %s',$date,$date,$date),ARRAY_A);
		return $rows;
	}
	private function get_form_data($form) {
		global $wpdb;
		if($form) {
			$form_value = json_decode($form, true);
			$cal_id = $this->id;
			$form_id = $wpdb->get_var($wpdb->prepare('SELECT form_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $cal_id));
			$form_info = $wpdb->get_var($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_forms WHERE id="%d"', $form_id));
			$form_info = json_decode($form_info, true);
			if(isset($form_info['apply']) || isset($form_info['save']))	{
				array_shift($form_info);
			}
			foreach($form_info as $key=>$form_fild_info) { 
				if(isset($form_value["wpdevart_".$key])) {
					$form_info[$key]["value"] = $form_value["wpdevart_".$key];
				}
				else {
					$form_info[$key]["value"] = "";
				}
			}
		} else {
			$form_info = array();
		}
		return $form_info;
	} 
	
	private function get_extra_data($extra,$price = false) {
		global $wpdb;
		if($price !== false) {
			$price = $price;
			$extra = $extra;
		} else  {
			$price = $extra["price"];
			$extra = $extra["extras"];
		}
		if($extra) {
			$extras_value = json_decode($extra, true);
			$cal_id = $this->id;
			$extra_id = $wpdb->get_var($wpdb->prepare('SELECT extra_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $cal_id));
			$extra_info = $wpdb->get_var($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_extras WHERE id="%d"', $extra_id));
			$extra_info = json_decode($extra_info, true);
			
			if(isset($extra_info['apply']) || isset($extra_info['save']))	{
				array_shift($extra_info);
			}
			foreach($extras_value as $key=>$extra_value) { 
				if(isset($extra_info[$key])) {
					$extras_value[$key]["group_label"] = $extra_info[$key]["label"];
					if($extra_value['price_type'] == "percent") {
						$extras_value[$key]["price"] = ($price*$extra_value['price_percent'])/100;
					} else {
						$extras_value[$key]["price"] = $extra_value['price_percent'];
					}
				}
				else {
					$extras_value[$key]["group_label"] = "";
				}
			}
		} else {
			$extras_value = array();
		}
		return $extras_value;
	} 
	public static function get_animations_type_array($animation=''){
		if($animation=='' || $animation=='none')
			return '';
		if($animation=='random'){	
			return self::$list_of_animations[array_rand(self::$list_of_animations,1)];
		}
		return $animation;
	}

}
