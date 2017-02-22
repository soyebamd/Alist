<?php
class wpdevart_bc_ViewCalendars {
	public $model_obj;
    	
    public function __construct( $model ) {
		$this->model_obj = $model;
    }	
    public function display_calendars() {
		$rows = $this->model_obj->get_calendars_rows();
		$items_nav = $this->model_obj->items_nav();
		$asc_desc = ((isset($_POST['asc_desc']) && $_POST['asc_desc'] == 'asc') ? 'asc' : 'desc');
		$res_order_by = (isset($_POST['order_by']) ? esc_html($_POST['order_by']) :  'id');
		$res_order_class = 'sorted ' . $asc_desc; ?>
		<div id="wpdevart_calendars_container" class="wpdevart-list-container">
			<div id="action-buttons" class="div-for-clear">
				<div class="div-for-clear">
					<span class="admin_logo"></span>
					<h1><?php _e('Calendars','booking-calendar'); ?></h1>
				</div>
				<a href="" onclick="wpdevart_set_value('task','add'); wpdevart_form_submit(event, 'calendars_form')" class="action-link"><?php _e('Add Calendar','booking-calendar'); ?></a>
				<a href="" onclick="wpdevart_set_value('task','delete_selected'); wpdevart_form_submit(event, 'calendars_form')" class="action-link delete-link"><?php _e('Delete','booking-calendar'); ?></a>
			</div>	
			<form action="admin.php?page=wpdevart-calendars" method="post" id="calendars_form">
			<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'calendars_form'); ?>
				<table class="wp-list-table widefat fixed pages wpdevart-table"> 
					<tr>
						<thead>
							<th class="check-column"><input type="checkbox" name="check_all" onclick="check_all_checkboxes(this,'check_for_action');"></th>
							<th class="small-column"><?php _e('ID','booking-calendar'); ?></th>
							<th><?php _e('Title','booking-calendar'); ?></th>
							<th><?php _e('Shortcode','booking-calendar'); ?></th>
							<th class="action-column"><?php _e('Edit','booking-calendar'); ?></th>
							<th class="action-column"><?php _e('Delete','booking-calendar'); ?></th>
						</thead>
					<tr>
					<?php
						foreach ( $rows as $row ) { ?>
							<tr>
								<td><input type="checkbox" name="check_for_action[]" class="check_for_action" value="<?php echo $row->id; ?>"></td>
								<td><?php echo $row->id; ?></td>
								<td><a href="" onclick="wpdevart_set_value('task','edit'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'calendars_form')" ><?php echo $row->title; ?></a></td>
								<td><input type="text" value="[wpdevart_booking_calendar id=&quot;<?php echo $row->id; ?>&quot;]" onclick="this.focus();this.select();" readonly="readonly" size="32"></td>
								<td><a href="" onclick="wpdevart_set_value('task','edit'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'calendars_form')" ><?php _e('Edit','booking-calendar'); ?></a></td>
								<td><a href="" onclick="wpdevart_set_value('task','delete'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'calendars_form')" ><?php _e('Delete','booking-calendar'); ?></a></td>
							<tr>
					<?php	}
					?>
				</table>
				<input type="hidden" name="task" id="task" value="">
				<input type="hidden" name="id" id="cur_id" value="">
				<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'calendars_form'); ?>
			</form>
		</div>
    <?php }
	
    public function edit_calendars( $id = 0 ) { 
	    $themes = array();
	    $forms = array("0"=>"None");
	    $extras = array("0"=>"None");
	    $themes_arr = $this->model_obj->get_setting_rows();
	    $forms_arr = $this->model_obj->get_form_rows();
	    $extras_arr = $this->model_obj->get_extra_rows();
		foreach ($themes_arr as $theme) {
			$themes[$theme['id']] = $theme['title'];
		}
		foreach ($forms_arr as $form) {
			$forms[$form['id']] = $form['title'];
		}
		foreach ($extras_arr as $extra) {
			$extras[$extra['id']] = $extra['title'];
		}
		if($id != 0){
			$calendar_rows = $this->model_obj->get_calendar_rows( $id );
			$theme_info = $this->model_obj->get_setting_row($calendar_rows['theme_id']);
		}				
		$wpdevart_calendars = array(
	
			'general' => array(
				'title' => 'General',
				'value' => array(
					'title' => array(
						'id'   => 'title',
						'title' => __('Calendar Title','booking-calendar'),
						'description' => '',
						'type' => 'text',
						'default' => ''
					),
					'theme_id' => array(
						'id'   => 'theme_id',
						'title' => __('Theme','booking-calendar'),
						'description' => '',
						'valid_options' => $themes,
						'onchange' => "submit_form('apply')",
						'type' => 'select',
						'default' => ''
					),
					'form_id' => array(
						'id'   => 'form_id',
						'title' => __('Form','booking-calendar'),
						'description' => '',
						'valid_options' => $forms,
						'type' => 'select',
						'default' => ''
					),
					'extra_id' => array(
						'id'   => 'extra_id',
						'title' => __('Extra','booking-calendar'),
						'description' =>  '',
						'valid_options' => $extras,
						'type' => 'select',
						'default' => ''
					)
				)	
			)
		);
		
		if(isset($theme_info["hours_enabled"]) && $theme_info["hours_enabled"] == "on"){
			$wpdevart_calendar_form = array(
				'set_days_availability' => array(
					'title' => 'Set days availability',
					'value' => array(
						'days_availability' => array(
							'id'   => 'days_availability',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'info_users' => array(
							'id'   => 'info_users',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin' => array(
							'id'   => 'info_admin',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						)
					)	
				),
				'set_hours_availability' => array(
					'title' => 'Set hours availability',
					'value' => array(
						'day_hours' => array(
							'id'   => 'day_hours',
							'title' => 'Days hours',
							'description' =>'This will overwrite hours data in theme. Add one per line(hh:mm). Use 24 hours format.',
							'type' => 'hours_element',
							'default' => $theme_info["hours"]
						)
					)	
				)
			);
		} else {
			$wpdevart_calendar_form = array(
				'set_days_availability' => array(
					'title' => 'Set days availability',
					'value' => array(
						'days_availability' => array(
							'id'   => 'days_availability',
							'title' => 'Set days availability',
							'description' => '',
							'valid_options' => array(
												   "available" => "Available",
												   "booked" => "Booked",
												   "unavailable" => "Unavailable",
												),
							'type' => 'select',
							'default' => ''
						),
						'number_availability' => array(
							'id'   => 'number_availability',
							'title' => 'Number Availabile',
							'description' =>'',
							'type' => 'text',
							'default' => '1'
						),
						'price' => array(
							'id'   => 'price',
							'title' => 'Price',
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'marked_price' => array(
							'id'   => 'marked_price',
							'title' => 'Marked Price',
							'description' =>'',
							'type' => 'text',
							'default' => ''
						),
						'info_users' => array(
							'id'   => 'info_users',
							'title' => 'Information for users',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						),
						'info_admin' => array(
							'id'   => 'info_admin',
							'title' => 'Information for administrators',
							'description' => '',
							'type' => 'textarea',
							'default' => ''
						)
					)	
				)
			);
		}
	

		$wpdevart_calendar_form ["set_days_availability"]["value"] = array("start_date" => array(
			'id'   => 'start_date',
			'title' => __('Start Date','booking-calendar'),
			'description' => '',
			'type' => 'text',
			'readonly' => true,
			'default' => ''
		)) + array("end_date" => array(
			'id'   => 'end_date',
			'title' => __('End Date','booking-calendar'),
			'description' => '',
			'type' => 'text',
			'readonly' => true,
			'default' => ''
		)) + $wpdevart_calendar_form ["set_days_availability"]["value"];
			
		
		?>
		<div id="wpdevart_calendars" class="wpdevart-item-container wpdevart-main-item-container">
			<?php
			    if($id != 0){ ?>
					<div class="div-for-clear">
						<span class="admin_logo"></span>
						<h1><?php _e('Edit Calendar','booking-calendar'); ?></h1>
					</div>
				<?php } else { ?>
					<div class="div-for-clear">
						<span class="admin_logo"></span>
						<h1><?php _e('Add Calendar','booking-calendar'); ?></h1>
					</div>
				<?php } ?>
			<form action="?page=wpdevart-calendars" method="post" id="add_edit_form">
				<?php
				  foreach( $wpdevart_calendars as $wpdevart_calendar ) { ?>
					<div class="wpdevart-item-section"> 
					    <h3><?php echo $wpdevart_calendar['title']; ?></h3>
						<div class="wpdevart-item-section-cont">
							<?php foreach( $wpdevart_calendar['value'] as $key => $wpdevart_calendars_value ) {
								if ( !isset($calendar_rows) ) {
									$sett_value = $wpdevart_calendars_value['default'];
								} else {
									if(isset($calendar_rows[$key]))
										$sett_value = $calendar_rows[$key];
									else
										$sett_value = "";
								}
								$function_name = "wpdevart_callback_" . $wpdevart_calendars_value['type'];
								wpdevart_bc_Library::$function_name($wpdevart_calendars_value, $sett_value);
							} ?>
						</div>	
					</div>	
				<?php  }
				$booking_obg = new wpdevart_bc_calendar();
				$result = $booking_obg->wpdevart_booking_calendar($id); ?>
				<div class="admin-calendar div-for-clear">
					<?php echo $result;
					  foreach( $wpdevart_calendar_form as $form_item ) {
						$sett_value_cal = 0;			?>
						<div class="wpdevart-item-section form-section"> 
							<h3><?php echo $form_item['title']; ?></h3>
							<div class="wpdevart-item-section-cont">
								<?php foreach( $form_item['value'] as $key => $value ) {
									$sett_value_cal = $value['default'];
									$function_name = "wpdevart_callback_" . $value['type'];
									wpdevart_bc_Library::$function_name($value, $sett_value_cal);
								} ?>
							</div>	
						</div>	
					<?php  } ?>
				</div>	
				<input type="hidden" name="task" value="save">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<input type="submit" value="Save" class="action-link wpda-input" name="save">
				<input type="submit" value="Apply" class="action-link wpda-input" name="apply" id="apply">
			</form>
		</div>
	<?php	
	}
  
	private function get_month() {
		$month = array(
		    '0'  => __('Current','booking-calendar'),
		    '01' => __('January','booking-calendar'),
			'02' => __('February','booking-calendar'),
			'03' => __('March','booking-calendar'),
			'04' => __('April','booking-calendar'),
			'05' => __('May','booking-calendar'),
			'06' => __('June','booking-calendar'),
			'07' => __('July','booking-calendar'),
			'08' => __('August','booking-calendar'),
			'09' => __('September','booking-calendar'),
			'10' => __('October','booking-calendar'),
			'11' => __('November','booking-calendar'),
			'12' => __('December','booking-calendar')
		);
		return $month;
	}
 
 
  
}

?>