<?php
/**
 * Plugin Name: Booking Calendar WpDevArt
 * Plugin URI: http://wpdevart.com/wordpress-booking-calendar-plugin
 * Description: Booking calendar - Booking System plugin is an awesome tool for creating booking systems for your website. Create booking calendars in a few minutes.
 * Version: 10.0
 * Author: wpdevart
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 


 
class wpdevart_bc_calendar{
	
	protected $version = "1.0";
	protected $prefix = 'wpdevart';
	public $options;
	static $booking_count = 1;
	
	
	function __construct(){
		@session_start();
		$this->setup_constants();		//Cnstants setup
		$this->require_files();
		
		$this->call_base_filters();		//Function for the main filters (hooks)
		$this->create_admin_menu();		//Function for creating admin menu
		add_shortcode(WPDEVART_PLUGIN_PREFIX."_booking_calendar", array($this,'shortcodes'));
	}
	
	/**
	* Cnstants setup
	**/
	private function setup_constants() {
		if ( ! defined( 'WPDEVART_PLUGIN_DIR' ) ) {
			define( 'WPDEVART_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		}
		if ( ! defined( 'WPDEVART_PLUGIN_PREFIX' ) ) {
			define( 'WPDEVART_PLUGIN_PREFIX', $this->prefix );
		}
		if(! defined( 'WPDEVART_URL' ) ){
			define ('WPDEVART_URL', trailingslashit( plugins_url('', __FILE__ ) ) );
		}if(! defined( 'WPDEVART_VERSION' ) ){
			define ('WPDEVART_VERSION', $this->version);
		}
	}

	/**
	* Require files
	**/
	private function require_files() {
		require_once(WPDEVART_PLUGIN_DIR.'includes/currency_list.php');
		require_once(WPDEVART_PLUGIN_DIR.'includes/wpdevart_lib.php');
		require_once(WPDEVART_PLUGIN_DIR.'includes/booking_class.php');
		require_once(WPDEVART_PLUGIN_DIR.'includes/widgets/widget-booking_calendar.php');
	}
	
	private function create_admin_menu(){
		// Registration of file that is responsible for admin menu
		require_once(WPDEVART_PLUGIN_DIR.'includes/admin_menu.php');
		// Creation of admin menu object type 
		$wpdevart_admin_menu = new wpdevart_bc_admin_menu(array('menu_name' => 'Booking Calendar'));
		//Hook that will connect admin menu with class
		add_action('admin_menu', array($wpdevart_admin_menu,'create_menu'));
		
	}
	
	public function shortcodes($attr) {
		extract(shortcode_atts(array(
			'id' => null
		), $attr, WPDEVART_PLUGIN_PREFIX));
		if (empty($id)) {
			return;
		}
		$result = $this->wpdevart_booking_calendar($id);
		self::$booking_count += 1;
		return  $result;
	}
	
	public function wpdevart_booking_calendar($id=0, $date='', $ajax = false, $selected = array(),$data = array(),$submit = "",$widget = false,$hours = array()) {
		global $wpdb;
		wp_enqueue_script( 'wpdevart-script' );
		wp_localize_script( 'wpdevart-script', WPDEVART_PLUGIN_PREFIX, array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'ajaxNonce'   => wp_create_nonce( 'wpdevart_ajax_nonce' )
		) );
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Themes.php");
		$theme_model = new wpdevart_bc_ModelThemes();
		
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Calendars.php");
		$calendar_model = new wpdevart_bc_ModelCalendars();
		
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Forms.php");
		$form_model = new wpdevart_bc_ModelForms();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Extras.php");
		$extra_model = new wpdevart_bc_ModelExtras();
		$ids = $calendar_model->get_ids($id);
		$theme_option = $theme_model->get_setting_rows($ids["theme_id"]);
		$calendar_data = $calendar_model->get_db_days_data($id);
		$calendar_title = $calendar_model->get_calendar_rows($id);
		$calendar_title = $calendar_title["title"];
		$extra_field = $extra_model->get_extra_rows($ids["extra_id"]);
		$form_option = $form_model->get_form_rows($ids["form_id"]);
		if($widget == true) {
			$booking_id = self::$booking_count + 1000;
		} else {
			$booking_id = self::$booking_count;
		}
		if(isset($theme_option)) {
			$theme_option = json_decode($theme_option->value, true);	
		} else {
			$theme_option = array();
		}
		
		if(isset($theme_option['delete_prev_date']) && $theme_option['delete_prev_date'] == "on") {
			$day = date( 'Y-m-d', strtotime("last day"));
			$wpdb->query("DELETE FROM ".$wpdb->prefix . "wpdevart_dates WHERE calendar_id=".$id." AND  day BETWEEN '1970-01-01' AND '".$day."'" );
			$wpdb->query("DELETE FROM ".$wpdb->prefix . "wpdevart_reservations WHERE calendar_id=".$id." AND  (single_day BETWEEN '1970-01-01' AND '".$day."' OR (check_in BETWEEN '1970-01-01' AND '".$day."' AND  check_out BETWEEN '1970-01-01' AND '".$day."'))" );
		}
		$text_for = $this->text_for_tr();	
		$for_trarray = array();
		foreach($text_for as $key => $for) {
			if(isset($theme_option['use_mo']) && $theme_option['use_mo'] == "on") {
				$for_trarray[$key] = __($for,'booking-calendar');
			} elseif(isset($theme_option[$key])){
				$for_trarray[$key] = $theme_option[$key];
			} else {
				$for_trarray[$key] = __($for,'booking-calendar');
			}
		}		
		
		
		if ($date == '' && !isset( $_REQUEST['date'] )) {
			$date = date( 'Y-m-d' );
		}
		/* Default year and month */
		if(isset($theme_option["default_month"]) && $theme_option["default_month"] != 0 && ($ajax == false || isset($data["wpdevart-submit".$submit]))) {
			$date_m = substr_replace($date,$theme_option["default_month"],5,2);
		}
		if(isset($theme_option["default_year"]) && $theme_option["default_year"] != "" && ($ajax == false || isset($data["wpdevart-submit".$submit]))) {
			if(isset($date_m )){
				$date_y = substr_replace($date_m,$theme_option["default_year"],0,4);
			} else{
				$date_y = substr_replace($date,$theme_option["default_year"],0,4);
			}
		}
		if(strtotime( $date ) < strtotime( $date_y )) {
			$date = $date_y;
		}
		if (isset( $_REQUEST['date'] ) && $_REQUEST['date'] != '') {
			$date = $_REQUEST['date'];
		}
		$date  = date('Y-m-d', strtotime( $date ));
			
		$calendar_start = new wpdevart_bc_BookingCalendar($date, $id, $theme_option, $calendar_data, $form_option, $extra_field,array(),false,$widget,$for_trarray,$calendar_title);
		
		$calendar_start = new wpdevart_bc_BookingCalendar($date, $id, $theme_option, $calendar_data, $form_option, $extra_field,array(),false,$widget,$for_trarray,$calendar_title);
		if(isset($hours['hours']) && $hours['hours'] == "true") {
			echo $calendar_start->booking_calendar_hours($hours['date']); 
			die();
		}
		
		$request_message = "";
		$mail_error = array();
		if(isset($data["wpdevart-submit".$submit])){
			$result = $calendar_start->save_reserv($data,$submit);
			$save= $result[0];
			$send_mails = $result[1];
			if(!is_admin() || count($data)) {
				if($save && isset($theme_option["enable_instant_approval"]) && $theme_option["enable_instant_approval"] == "on") {
					$request_message = $for_trarray["for_request_successfully_received"];
				} elseif($save) {
					$request_message = $for_trarray["for_request_successfully_sent"];
				}

				foreach($send_mails as $send_mail) {
					foreach($send_mail as $key=>$value) {
						if(isset($theme_option[$key."_error"]) && $theme_option[$key."_error"] == "on" && $value === false) {
							$mail_error[] = (isset($for_trarray["for_".$key]) ? $for_trarray["for_".$key] : "");
						}
					}		
				}
				
				if(isset($theme_option["action_after_submit"]) && $theme_option["action_after_submit"] == "stay_on_calendar") {
					$submit_message = $theme_option["message_text"];
				}
				else { ?>
					<script>
						window.location.href = "<?php echo esc_url($theme_option["redirect_url"]); ?>";
					</script>
					<?php exit();
				}
			} else {
				return;
			}
		}
		
		$calendar_data_after_save = $calendar_model->get_db_days_data($id);
		$calendar = new wpdevart_bc_BookingCalendar($date, $id, $theme_option, $calendar_data_after_save, $form_option,$extra_field, $selected,$ajax,$widget,$for_trarray,$calendar_title);
		$booking_calendar = "";

		if(isset($theme_option) && !$ajax) {
			$booking_calendar .= $calendar->get_styles();
		}
		if (!$ajax) {
			$booking_calendar .= "<div id='booking_calendar_main_container_" . $booking_id  . "' class='booking_calendar_main_container ".((isset($theme_option['hours_enabled']) && $theme_option['hours_enabled'] == "on") ? "hours_enabled" : "" )." ".((isset($widget) && $widget == true) ? "booking_widget" : "" )." ".((isset($theme_option['show_day_info_on_hover']) && $theme_option['show_day_info_on_hover'] == 'on') ? "show_day_info_on_hover" : "" )." ".((isset($theme_option['cal_animation_type']) && $theme_option['cal_animation_type'] != 'none') ? "animation_calendar" : "" )."' data-total='".$for_trarray["for_total"]."' data-price='".$for_trarray["for_price"]."' data-offset='".((isset($theme_option["scroll_offset"]) && $theme_option["scroll_offset"] != '') ? $theme_option["scroll_offset"] : 0)."' data-position='".((isset($theme_option["currency_pos"]) && $theme_option["currency_pos"] == 'before') ? "before" : "after")."'  data-night='".((isset($theme_option["price_for_night"]) && $theme_option["price_for_night"] == 'on') ? "1" : "0")."' data-id='" . $id . "'>";
			$booking_calendar .= "<div class='booking_calendar_container' id='booking_calendar_container_" . $booking_id  . "'><div class='wpdevart-load-overlay'><div class='wpdevart-load-image'><i class='fa fa-spinner fa-spin'></i></div></div>";
		}	
		if (isset($submit_message) && $submit_message != "") {
			$booking_calendar .= "<div class='booking_calendar_message successfully_text_container'>".$submit_message."<span class='notice_text_close'>x</span></div>";
		}
		if($request_message != "") {
			$booking_calendar .= "<div class='successfully_text_container div-for-clear'>".$request_message."<span class='notice_text_close'>x</span></div>";
		}
		if(count($mail_error)) {
			$booking_calendar .= '<div class="error_text_container div-for-clear email_error" style="display: block;"><span class="error_text">';
			foreach($mail_error as $error) {
				$booking_calendar .= $error. "</br>";
			}
			$booking_calendar .= '</span><span class="notice_text_close">x</span></div>';
		}
		if (!$ajax) {
			if(isset($theme_option["type_days_selection"]) && $theme_option["type_days_selection"] == "multiple_days") {
				$booking_calendar .= "<div class='error_text_container div-for-clear'><span class='error_text'>".$for_trarray["for_error_multi"]."</span><span class='notice_text_close'>x</span></div>";
			} else {
				$booking_calendar .= "<div class='error_text_container div-for-clear'><span class='error_text'>".$for_trarray["for_error_single"]."</span><span class='notice_text_close'>x</span></div>";
			}
		}	
		$booking_calendar .= "<div class='booking_calendar_main'>";
		$booking_calendar .= $calendar->booking_calendar();
		if (!$ajax) {
			$booking_calendar .= "</div>";
		}
		$booking_calendar .= "</div>";
		if((!is_admin() || (isset($_GET["page"]) && $_GET["page"] == "wpdevart-reservations"))) {
			$class = "";
			if(!isset($theme_option["show_form"])) {
				$class = "hide_form";
			}
			$booking_calendar .= $calendar->booking_form($class);
		}
		if (!$ajax) {
			$booking_calendar .= "</div>";
		}
		return $booking_calendar;
	}

	
	
	public function wpdevart_booking_calendar_res($id=0, $date='', $ajax = false) {
		wp_enqueue_script( WPDEVART_PLUGIN_PREFIX.'-script' );
		wp_localize_script( WPDEVART_PLUGIN_PREFIX.'-script', WPDEVART_PLUGIN_PREFIX, array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'ajaxNonce'   => wp_create_nonce( 'wpdevart_ajax_nonce' )
		) );
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Themes.php");
		$theme_model = new wpdevart_bc_ModelThemes();
		
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Calendars.php");
		$calendar_model = new wpdevart_bc_ModelCalendars();
		
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Forms.php");
		$form_model = new wpdevart_bc_ModelForms();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Extras.php");
		$extra_model = new wpdevart_bc_ModelExtras();
		$ids = $calendar_model->get_ids($id);
		$theme_option = $theme_model->get_setting_rows($ids["theme_id"]);
		$calendar_data = $calendar_model->get_db_days_data($id);
		$extra_field = $extra_model->get_extra_rows($ids["extra_id"]);
		$form_option = $form_model->get_form_rows($ids["form_id"]);
		$theme_option =json_decode($theme_option->value, true);		
		$calendar = new wpdevart_bc_BookingCalendar($date, $id, $theme_option, $calendar_data, $form_option, $extra_field,array());
		$booking_calendar = "";
				
		if (!$ajax) {
			$booking_calendar .= "<div class='booking_calendar_container' id='booking_calendar_container_" . self::$booking_count . "'><div class='wpdevart-load-overlay'><div class='wpdevart-load-image'><i class='fa fa-spinner fa-spin'></i></div></div>";
		}	
			
		$booking_calendar .= "<div class='booking_calendar_main'>";
		$booking_calendar .= $calendar->booking_calendar("reservation");
		if (!$ajax) {
			$booking_calendar .= "</div>";
		}
		$booking_calendar .= "</div>";		
		return $booking_calendar;
	}
	
	public function  wpdevart_ajax_get_interval_dates(){
		global $wpdb;
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Calendars.php");
		$calendar_model = new wpdevart_bc_ModelCalendars();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Themes.php");
		$theme_model = new wpdevart_bc_ModelThemes();
		
		$start_date = "1970-01-01";
		if(isset($_GET['wpdevart_start_date']))
			$start_date = date( 'Y-m-d', strtotime($_GET['wpdevart_start_date']));
		else
			die('0');
		
		$end_date = "1970-01-01";
		if(isset($_GET['wpdevart_end_date']))
			$end_date = date( 'Y-m-d', strtotime($_GET['wpdevart_end_date']));
		else
			die('0');
		
		$id=0;
		if(isset($_GET['wpdevart_id']))
			$id = $_GET['wpdevart_id'];
		else
			die('0');
		
		$ids = $calendar_model->get_ids($id);
		$theme_options = $theme_model->get_setting_rows($ids["theme_id"]);
		if(isset($theme_options)) {
			$theme_options = json_decode($theme_options->value, true);	
		} else {
			$theme_options = array();
		}
		$date_diff = abs($this->get_date_diff($start_date,$end_date));
		if($date_diff > 3500){
			die("0");
		}
		$get_cur_call_all_dates = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpdevart_dates WHERE calendar_id="%d"', $id),ARRAY_A);
		
		$avaible_days_array = array();
		foreach($get_cur_call_all_dates as $key=>$value){
			$jsoned_value=json_decode($value['data'],true);
			if($jsoned_value['status']=='available'){
				$avaible_days_array[$key]=$value['day'];				
			}
		}
		
		$selected_dates = array(); // main genereted days
		for($i=0; $i <= $date_diff; $i++) {
			$day = date( 'Y-m-d', strtotime($start_date. " +" . $i . " day" ));
			$week_day = date('w', strtotime($start_date. " +" . $i . " day" ));
			if(!(isset($theme_options['unavailable_week_days']) && in_array($week_day,$theme_options['unavailable_week_days']))) {
				if(false !== $key = array_search($day,$avaible_days_array)){
					$selected_dates[] = $get_cur_call_all_dates[$key];
				}else{
					if(isset($theme_options['price_for_night']) && $theme_options['price_for_night'] == "on" && $date_diff == $i) {
						continue;
					}
					die('0');
				}
			}
		}
		echo json_encode($selected_dates);
		die();
		
	}
	
	public function wpdevart_ajax() {
		if(!check_ajax_referer('wpdevart_ajax_nonce', 'wpdevart_nonce')) {
			die('Request has failed.');
		}
		$id = 0;
		$selected = array();
		if(isset($_POST['wpdevart_link'])) {
			$link = esc_html( $_POST['wpdevart_link'] );
			parse_str( $link, $link_arr );
			$date = $link_arr['?date'];
		}
		if(isset($_POST['wpdevart_id'])) {
			$id = esc_html($_POST['wpdevart_id']);
		}
		if(isset($_POST['wpdevart_reserv'])) {
			$reserv = esc_html($_POST['wpdevart_reserv']);
		}
		if(isset($_POST['wpdevart_selected'])) {
			$selected["index"] = esc_html($_POST['wpdevart_selected']);
		}
		if(isset($_POST['wpdevart_selected_date'])) {
			$selected["date"] = esc_html($_POST['wpdevart_selected_date']);
		}
		if(isset($_POST['wpdevart_hours'])) {
			$selected['hours'] = esc_html($_POST['wpdevart_hours']);
			
		}
		if(isset($reserv) && $reserv == "true") {
			echo $this->wpdevart_booking_calendar_res($id,$date,true,$selected);
		} elseif(isset($selected['hours']) && $selected['hours'] == "true") {
			echo $this->wpdevart_booking_calendar($id,'',false,array(),array(),"",false,$selected);
		} else {
			echo $this->wpdevart_booking_calendar($id,$date,true,$selected);
		}
		wp_die();
	}
	
	public function wpdevart_form_ajax() {
		if(!check_ajax_referer('wpdevart_ajax_nonce', 'wpdevart_nonce')) {
			die('Request has failed.');
		}
		$id = 0;
		$data = array();
		$submit = "";
		if(isset($_POST['wpdevart_id'])) {
			$id = esc_html($_POST['wpdevart_id']);
		}
		if(isset($_POST['wpdevart_data'])) {
			$data = json_decode(stripcslashes($_POST['wpdevart_data']),true);
		}
		if(isset($_POST['wpdevart_submit'])) {
			$submit = esc_html($_POST['wpdevart_submit']);
		}
		echo $this->wpdevart_booking_calendar($id,"",true,array(),$data,$submit);
		wp_die();
	}
	
	public function wpdevart_add_field() {
		$max_id = 0;
		$count = 0;
		if ( isset( $_POST['wpdevart_field_type'] ) ) {
			$type = str_replace('_field', '', esc_html( $_POST['wpdevart_field_type']));
		}
		if ( isset( $_POST['wpdevart_field_max'] ) ) {
			$max_id = esc_html( $_POST['wpdevart_field_max']);
		}
		if ( isset( $_POST['wpdevart_field_count'] ) ) {
			$count = esc_html( $_POST['wpdevart_field_count']);
		}
		$args =  array(
			'name'   => 'form_field' . ($max_id + 1 + $count),
			'label' => __( 'New ' . $type . ' Field', 'booking-calendar' ),
			'type' => $type,
			'default' => ''
		);
		$function_name = "wpdevart_form_" . $type;
		wpdevart_bc_Library::$function_name($args, array('label' => __( 'New ' . $type . ' Field', 'booking-calendar' )));
		wp_die();
	}
	
	public function wpdevart_add_extra_field() {
		$max_id = 0;
		$count = 0;
		if ( isset( $_POST['wpdevart_extra_field_max'] ) ) {
			$max_id = esc_html( $_POST['wpdevart_extra_field_max']);
		}
		if ( isset( $_POST['wpdevart_extra_field_count'] ) ) {
			$count = esc_html( $_POST['wpdevart_extra_field_count']);
		}
		$args =  array(
			'name'   => 'extra_field' . ($max_id + 1 + $count),
			'label' => __( 'New Extra', 'booking-calendar' ),
			'type' => 'extras_field',
			'items' => array(
				'field_item1' => array('name'=>'field_item1',
									'label' => '1',
									'operation' => '+',
									'price_type' => 'price',
									'price_percent' => '0',
									'order' => '1'
								),
				'field_item2' => array('name'=>'field_item2',
									'label' => '2',
									'operation' => '+',
									'price_type' => 'price',
									'price_percent' => '0',
									'order' => '2'
								),
				'field_item3' => array('name'=>'field_item3',
									'label' => '3',
									'operation' => '+',
									'price_type' => 'price',
									'price_percent' => '0',
									'order' => '3'
								)
			),
			'default' => ''
		);
		wpdevart_bc_Library::wpdevart_extras_field($args,$args);
		wp_die();
	}	
	
	public function wpdevart_add_extra_field_item() {
		$count = 0;
		$max_id = 0;
		if ( isset( $_POST['wpdevart_extra_field_item_max'] ) ) {
			$max_id = esc_html( $_POST['wpdevart_extra_field_item_max']);
		}
		if ( isset( $_POST['wpdevart_extra_field'] ) ) {
			$extra_field = esc_html( $_POST['wpdevart_extra_field']);
		}
		if ( isset( $_POST['wpdevart_extra_field_item_count'] ) ) {
			$count = esc_html( $_POST['wpdevart_extra_field_item_count']);
		}
		$args =  array('name'=>'field_item'. ($max_id + 1 + $count),
			'label' => ($max_id + 1),
			'operation' => '+',
			'price_type' => 'price',
			'price_percent' => '0',
			'order' => ($max_id + 1)
		);
		wpdevart_bc_Library::wpdevart_extras_field_item($extra_field,$args);
		wp_die();
	}
	
	public function install_databese(){
		$version = get_option("wpdevart_booking_version");
        $new_version = $this->version;
		//registration of file that is responsible for database
		require_once(WPDEVART_PLUGIN_DIR.'includes/install_database.php');
		//Creation of database object type 
		$wpdevart_bc_install_database = new wpdevart_bc_install_database();
		if (!$version) {
			$wpdevart_bc_install_database->install_databese();
			add_option("wpdevart_booking_version", $new_version, '', 'no');
		}
		
	}
	
	public function registr_requeried_scripts(){
		load_plugin_textdomain( 'booking-calendar', FALSE, basename(dirname(__FILE__)).'/languages' );
		wp_enqueue_script( 'jquery-ui-datepicker', array('jquery') ); 
		if(!is_admin()){
			wp_register_script( 'wpdevart-booking-script', WPDEVART_URL.'js/booking.js', array("jquery"));
			wp_localize_script( 'wpdevart-booking-script', WPDEVART_PLUGIN_PREFIX, array(
				'ajaxUrl'         => admin_url( 'admin-ajax.php' ),
				'ajaxNonce'       => wp_create_nonce( 'wpdevart_ajax_nonce' ),
				'required' => __("is required.",'booking-calendar'),
				'emailValid' => __("Enter the valid email address.",'booking-calendar'),
				'date' => __("Date",'booking-calendar'),
				'hour' => __("Hour",'booking-calendar')
			) );
			wp_enqueue_script( 'wpdevart-booking-script' );
			wp_enqueue_script( 'wpdevart-script', WPDEVART_URL.'js/script.js', array("jquery") );
		}
		wp_enqueue_script( 'scrollto', WPDEVART_URL.'js/jquery.scrollTo-min.js', array("jquery") );
		wp_enqueue_style( 'jquery-ui',  WPDEVART_URL.'css/jquery-ui.css');
		wp_enqueue_style('wpdevart-font-awesome', WPDEVART_URL . 'css/font-awesome/font-awesome.css');
		wp_enqueue_style( 'wpdevart-style', WPDEVART_URL.'css/style.css');
		wp_enqueue_style( 'wpdevart-effects', WPDEVART_URL.'css/effects.css');
		wp_enqueue_style( 'wpdevartcalendar-style', WPDEVART_URL.'css/booking.css');
	}
	
	public function call_base_filters(){
		add_action( 'init',  array($this,'registr_requeried_scripts') );
		register_activation_hook( __FILE__, array( $this, 'install_databese' ) );
		add_action( 'wp_ajax_nopriv_wpdevart_add_field', array($this,'wpdevart_add_field') );
		add_action( 'wp_ajax_wpdevart_add_field', array($this,'wpdevart_add_field') );
		add_action( 'wp_ajax_nopriv_wpdevart_add_extra_field', array($this,'wpdevart_add_extra_field') );
		add_action( 'wp_ajax_wpdevart_add_extra_field', array($this,'wpdevart_add_extra_field') );
		add_action( 'wp_ajax_nopriv_wpdevart_add_extra_field_item', array($this,'wpdevart_add_extra_field') );
		add_action( 'wp_ajax_wpdevart_add_extra_field_item', array($this,'wpdevart_add_extra_field_item') );
		add_action( 'wp_ajax_nopriv_wpdevart_ajax', array($this,'wpdevart_ajax') );
		add_action( 'wp_ajax_wpdevart_ajax', array($this,'wpdevart_ajax') );
		add_action( 'wp_ajax_nopriv_wpdevart_ajax_get_interval_dates', array($this,'wpdevart_ajax_get_interval_dates') );
		add_action( 'wp_ajax_wpdevart_ajax_get_interval_dates', array($this,'wpdevart_ajax_get_interval_dates') );
		add_action( 'wp_ajax_nopriv_wpdevart_form_ajax', array($this,'wpdevart_form_ajax') );
		add_action( 'wp_ajax_wpdevart_form_ajax', array($this,'wpdevart_form_ajax') );
		
	}
	private function text_for_tr() {
		$for_tr = array(
			"for_available" => "available",
			"for_booked" => "Booked",
			"for_unavailable" => "Unavailable",
			"for_check_in" => "Check in",
			"for_check_out" => "Check out",
			"for_no_hour" => "No hour available.",
			"for_start_hour" => "Start hour",
			"for_end_hour" => "End hour",
			"for_item_count" => "Item count",
			"for_termscond" => "I accept to agree to the Terms & Conditions.",
			"for_reservation" => "Reservation",
			"for_select_days" => "Please select the days from calendar.",
			"for_price" => "Price",
			"for_total" => "Total",
			"for_submit_button" => "Book Now",
			"for_request_successfully_sent" => "Your request has been successfully sent. Please wait for approval.",
			"for_request_successfully_received" => "Your request has been successfully received. We are waiting you!",
			"for_error_single" => "There are no services available for this day.",
			"for_error_multi" => "There are no services available for the period you selected.",
			"for_notify_admin_on_book" => "Email on book to administrator doesn't send",
			"for_notify_admin_on_approved" => "Email on approved to administrator doesn't send",
			"for_notify_user_on_book" => "Email on book to user doesn't send",
			"for_notify_user_on_approved" => "Email on approved to user doesn't send",
			"for_notify_user_canceled" => "Email on canceled to user doesn't send",
			"for_notify_user_deleted" => "Email on delete to user doesn't send"
		);
		return $for_tr;
	}
	private function get_date_diff($date1, $date2) {
		$start = strtotime($date1);
		$end = strtotime($date2);
		$datediff = $start - $end;
		return floor($datediff/(60*60*24));
	}
}
$wpdevart_booking = new wpdevart_bc_calendar(); // Creation of the main object

?>