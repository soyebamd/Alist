<?php
class wpdevart_bc_ViewThemes {
	public $model_obj;
    	
    public function __construct( $model ) {
		$this->model_obj = $model;
    }	
    public function display_themes($error_msg="",$delete=true) {
		$rows = $this->model_obj->get_themes_rows();
		$items_nav = $this->model_obj->items_nav();
		$asc_desc = ((isset($_POST['asc_desc']) && $_POST['asc_desc'] == 'asc') ? 'asc' : 'desc');
		$res_order_by = (isset($_POST['order_by']) ? esc_html($_POST['order_by']) :  'id');
		$res_order_class = 'sorted ' . $asc_desc; ?>
		<div id="wpdevart_themes_container" class="wpdevart-list-container">
			<div id="action-buttons" class="div-for-clear">
				<div class="div-for-clear">
					<span class="admin_logo"></span>
					<h1><?php _e('Themes','booking-calendar'); ?></h1>
				</div>
				<a href="" onclick="wpdevart_set_value('task','add'); wpdevart_form_submit(event, 'themes_form')" class="action-link"><?php _e('Add Theme','booking-calendar'); ?></a>
				<a href="" onclick="wpdevart_set_value('task','delete_selected'); wpdevart_form_submit(event, 'themes_form')" class="action-link delete-link"><?php _e('Delete','booking-calendar'); ?></a>
			</div>
			<?php if(isset($error_msg) && $error_msg != "") {
				$class = "error";
				if($delete === true) {
					$class = "updated";
				} ?>
				<div id="message" class="<?php echo $class; ?> notice is-dismissible"><p><?php echo $error_msg; ?></p></div>
			<?php } ?>
			<form action="admin.php?page=wpdevart-themes" method="post" id="themes_form">
			<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'themes_form'); ?>
				<table class="wp-list-table widefat fixed pages wpdevart-table"> 
					<tr>
						<thead>
							<th class="check-column"><input type="checkbox" name="check_all" onclick="check_all_checkboxes(this,'check_for_action');"></th>
							<th class="small-column"><?php _e('ID','booking-calendar'); ?></th>
							<th><?php _e('Title','booking-calendar'); ?></th>
							<th class="action-column"><?php _e('Edit','booking-calendar'); ?></th>
							<th class="action-column"><?php _e('Delete','booking-calendar'); ?></th>
						</thead>
					<tr>
					<?php
						foreach ( $rows as $row ) { ?>
							<tr>
								<td><input type="checkbox" name="check_for_action[]" class="check_for_action" value="<?php echo $row->id; ?>"></td>
								<td><?php echo $row->id; ?></td>
								<td><a href="" onclick="wpdevart_set_value('task','edit'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'themes_form')" ><?php echo $row->title; ?></a></td>
								<td><a href="" onclick="wpdevart_set_value('task','edit'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'themes_form')" ><?php _e('Edit','booking-calendar'); ?></a></td>
								<td><a href="" onclick="wpdevart_set_value('task','delete'); wpdevart_set_value('cur_id','<?php echo $row->id; ?>'); wpdevart_form_submit(event, 'themes_form')" ><?php _e('Delete','booking-calendar'); ?></a></td>
							<tr>
					<?php	}
					?>
				</table>
				<input type="hidden" name="task" id="task" value="">
				<input type="hidden" name="id" id="cur_id" value="">
				<?php wpdevart_bc_Library::items_nav($items_nav['limit'],$items_nav['total'],'themes_form'); ?>
			</form>
		</div>
    <?php }
	
    public function edit_setting( $id = 0 ) { 
	    
		$wpdevart_themes = array(
	
			/* General Themes */
			'general' => array(
				'title' => __('General','booking-calendar'),
				'sections' => array(
				    'general' => array(
						'date_format' => array(
							'id'   => 'date_format',
							'title' => __('Date format','booking-calendar'),
							'description' =>__('Select date format for emails and the reservation table','booking-calendar'),
							'valid_options' => array(
							  'F j, Y' => date('F j, Y'),
							  'd.m.Y' => date('d.m.Y'),
							  'd-m-Y' => date('d-m-Y'),
							  'm/d/Y' => date('m/d/Y')
							),
							'type' => 'select',
							'default' => ''
						),
						'week_days' => array(
							'id'   => 'week_days',
							'title' => __('Week days format','booking-calendar'),
							'description' => __('Select week days format','booking-calendar' ),
							'valid_options' => array(
							  '0' => __('Sunday','booking-calendar'),
							  '1' => __('Sun','booking-calendar'),
							  '2' => __('Su','booking-calendar')
							),
							'type' => 'select',
							'default' => ''
						),
						/*'tyme_type' => array(
							'id'   => 'tyme_type',
							'title' => __( 'Tyme type', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'default' => ''
						),
						'month_number' => array(
							'id'   => 'month_number',
							'title' => __( 'Number of months', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'default' => 1
						),*/
						'day_start' => array(
							'id'   => 'day_start',
							'title' => __('Start Day of the week','booking-calendar'),
							'description' => __('Select start day of the week for Calendar','booking-calendar'),
							'valid_options' => array(
							  '0' => __('Sunday','booking-calendar'),
							  '1' => __('Monday','booking-calendar'),
							  '2' => __('Tuesday','booking-calendar'),
							  '3' => __('Wednesday','booking-calendar'),
							  '4' => __('Thursday','booking-calendar'),
							  '5' => __('Friday','booking-calendar'),
							  '6' => __('Saturday','booking-calendar')
							),
							'type' => 'select',
							'default' => '1'
						),
						'default_year' => array(
							'id'   => 'default_year',
							'title' => __('Default Year','booking-calendar'),
							'description' => __('Type here default year(for example 2018)','booking-calendar' ),
							'type' => 'text',
							'default' => ''
						),
						'default_month' => array(
							'id'   => 'default_month',
							'title' => __('Default Month','booking-calendar'),
							'description' => __('Select default month for Calendar','booking-calendar' ),
							'valid_options' => $this->get_month(),
							'type' => 'select',
							'default' => '0'
						),
						'cal_animation_type' => array(
							'id'   => 'cal_animation_type',
							'title' => __('Calendar Animation type','booking-calendar'),
							'description' => __('Select calendar animation type','booking-calendar' ),
							'valid_options' => $this->cal_animation_type(),
							'type' => 'select',
							'default' => 'none'
						),
						'scroll_offset' => array(
							'id'   => 'scroll_offset',
							'title' => 'Scroll Offset',
							'description' => __('After selecting date or hour on calendar you will be scroll down to the form, so correct the scrolling distance using this option, type only numbers(also you can type reverse numbers, for example -150)','booking-calendar' ),
							'type' => 'text',
							'default' => ''
						),
						'show_form' => array(
							'id'   => 'show_form',
							'title' =>__('Show Form before select the days','booking-calendar'),
							'description' => __('Use this option if you need to display form before users select date or hour on the calendar','booking-calendar' ),
							'type' => 'checkbox',
							'default' => 'on'
						),
						'delete_prev_date' => array(
							'id'   => 'delete_prev_date',
							'title' => __('Delete previews dates','booking-calendar'),
							'description' =>  __('Use this option if you need to clear the information for previous dates on calendar','booking-calendar' ),
							'type' => 'checkbox',
							'default' => ''
						),						
						'unavailable_week_days' => array(
							'id'   => 'unavailable_week_days',
							'title' => __('Unavailable week days','booking-calendar'),
							'description' => __('Select unavailable week days for calendar','booking-calendar' ),
							'valid_options' => array(
							  '0' => __('Sunday','booking-calendar'),
							  '1' => __( 'Monday','booking-calendar'),
							  '2' => __('Tuesday','booking-calendar'),
							  '3' => __( 'Wednesday','booking-calendar'),
							  '4' => __('Thursday','booking-calendar'),
							  '5' => __('Friday','booking-calendar'),
							  '6' => __('Saturday','booking-calendar')
							),
							'type' => 'checkbox',
							'default' => array()
						),
						'enable_instant_approval' => array(
							'id'   => 'enable_instant_approval',
							'title' => __('Enable instant approval','booking-calendar'),
							'description' => __('Select this if you need approve the booking requests instantly, without moderation','booking-calendar'),
							'type' => 'checkbox',
							'default' => ''
						),
						'type_days_selection' => array(
							'id'   => 'type_days_selection',
							'title' => __('Type of days selection in calendar','booking-calendar'),
							'description' => __('Select the type of days selection in calendar','booking-calendar' ),
							'type' => 'radio_enable',
							'valid_options' => array("multiple_days"=>__("Multiple days",'booking-calendar'),"single_day"=>__("Single day",'booking-calendar')),
							'enable' => array('multiple_days'=>'price_for_night'),
							'default' => 'multiple_days'
						),
						'price_for_night' => array(
							'id'   => 'price_for_night',
							'title' => __('Calculate price for night','booking-calendar'),
							'description' => __('Calculate price for night','booking-calendar'),
							'type' => 'checkbox',
							'default' => ''
						),
						'enable_checkinout' => array(
							'id'   => 'enable_checkinout',
							'title' => __('Enable Check in/Check out','booking-calendar'),
							'description' => __('Show Check in/Check out text in Form','booking-calendar'),
							'type' => 'checkbox',
							'default' => 'on'
						),
						'enable_number_items' => array(
							'id'   => 'enable_number_items',
							'title' => __('Show items number in form','booking-calendar'),
							'description' => __('Use this option if you need show the number of items in form','booking-calendar'),
							'type' => 'checkbox',
							'default' => 'on'
						),
						'hide_count_available' => array(
							'id'   => 'hide_count_available',
							'title' => __('Hide number of available events','booking-calendar'),
							'description' => __("Select this option if you don't need to display the number of available events on calendar in front-end",'booking-calendar'),
							'type' => 'checkbox',
							'default' => ''
						),
						'enable_terms_cond' => array(
							'id'   => 'enable_terms_cond',
							'title' => __('Enable Terms & Conditions','booking-calendar'),
							'description' => __('Enable Terms & Conditions option','booking-calendar'),
							'enable' => array('terms_cond_link'),
							'type' => 'checkbox_enable',
							'default' => ''
						),
						'terms_cond_link' => array(
							'id'   => 'terms_cond_link',
							'title' => __('Terms & Conditions link','booking-calendar'),
							'description' =>__('Insert here the url for Terms & Conditions text','booking-calendar'),
							'type' => 'text',
							'extra_div'=> true,
							'extra_div_end'=> true,
							'default' => ''
						),
						'enable_form_title' => array(
							'id'   => 'enable_form_title',
							'title' =>__( 'Show title of Form','booking-calendar'),
							'description' => __('Show or hide the title of form','booking-calendar' ),
							'type' => 'checkbox',
							'default' => 'on'
						),
						'enable_extras_title' => array(
							'id'   => 'enable_extras_title',
							'title' => __('Enable title of Extra','booking-calendar'),
							'description' => __('Show or hide the title of Extra','booking-calendar' ),
							'type' => 'checkbox',
							'default' => 'on'
						),
						'legend_enable' => array(
							'id'   => 'legend_enable',
							'title' => __('Display days status texts below calendare','booking-calendar'),
							'description' =>__('Display days status texts below calendar(Available, Booked, Unavailable)','booking-calendar'),
							'enable' => array('legend_available_enable','legend_available','legend_booked_enable','legend_booked','legend_unavailable_enable','legend_unavailable'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'legend_available_enable' => array(
							'id'   => 'legend_available_enable',
							'title' => __('Available','booking-calendar'),
							'description' => '',
							'enable' => array('legend_available'),
							'type' => 'checkbox_enable',
							'extra_div'=> true,
							'default' => 'on'
						),
						'legend_available' => array(
							'id'   => 'legend_available',
							'title' => '',
							'description' => '',
							'type' => 'text',
							'default' => 'Available'
						),
						'legend_booked_enable' => array(
							'id'   => 'legend_booked_enable',
							'title' => __('Booked','booking-calendar'),
							'description' => '',
							'enable' => array('legend_booked'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'legend_booked' => array(
							'id'   => 'legend_booked',
							'title' => '',
							'description' => '',
							'type' => 'text',
							'default' => 'Booked'
						),
						'legend_unavailable_enable' => array(
							'id'   => 'legend_unavailable_enable',
							'title' =>__('Unavailable','booking-calendar'),
							'description' => '',
							'enable' => array('legend_unavailable'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'legend_unavailable' => array(
							'id'   => 'legend_unavailable',
							'title' => '',
							'description' => '',
							'type' => 'text',
							'extra_div_end'=> true,
							'default' => 'Unavailable'
						),
						'action_after_submit' => array(
							'id'   => 'action_after_submit',
							'title' => __('Action after submition','booking-calendar'),
							'description' => __('Selct the action after users submit the booking form','booking-calendar' ),
							'valid_options' => array(
								'stay_on_calendar' => __('Stay on Calendar','booking-calendar'),
								'redirect' => __('Redirect visitor to a new page','booking-calendar')
							),
							'enable' => array('stay_on_calendar'=>array('message_text'),'redirect' =>array( 'redirect_url')),
							'type' => 'radio_enable',
							'default' => 'stay_on_calendar'
						),
						'message_text' => array(
							'id'   => 'message_text',
							'title' => __('Message after submition','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Thanks :)'
						),
						/*'time_of_message' => array(
							'id'   => 'time_of_message',
							'title' => __( 'Time of message showing', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'default' => '30'
						),*/
						'redirect_url' => array(
							'id'   => 'redirect_url',
							'title' => __('URL','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => ''
						)
					),
					'currency_settings' => array(
						'currency' => array(
							'id'   => 'currency',
							'title' => __('Currency','booking-calendar'),
							'description' => __('Select the default currency for calendar','booking-calendar' ),
							'valid_options' => wpdevart_bc_get_currency(),
							'currency' => true,
							'type' => 'select',
							'default' => 'USD'
						),
						'currency_pos' => array(
							'id'   => 'currency_pos',
							'title' => __( 'Currency Position', 'booking-calendar' ),
							'description' => __('Select the currency position(after or before price)','booking-calendar' ),
							'valid_options' => array("after" => "After","before" => "Before"),
							'type' => 'radio',
							'default' => 'after'
						)
					),
					'hours_settings' => array(
						'hours_enabled' => array(
							'id'   => 'hours_enabled',
							'title' => 'Enable Hours',
							'description' => __('Enable this option if you need to create hour booking calendar','booking-calendar' ),
							'enable' => array('type_hours_selection','hours'),
							'type' => 'checkbox_enable',
							'default' => ''
						),/*
						'hours_interval_enabled' => array(
							'id'   => 'hours_interval_enabled',
							'title' => __( 'Hours Interval Enabled', 'booking-calendar' ),
							'description' => '',
							'extra_div' => true,
							'type' => 'checkbox',
							'default' => ''
						),*/
						'type_hours_selection' => array(
							'id'   => 'type_hours_selection',
							'title' => 'Type of hours selection in calendar',
							'description' => __('Choose the type of hours selection in calendar','booking-calendar' ),
							'type' => 'radio',
							'extra_div' => true,
							'valid_options' => array("multiple_hours"=>"Multiple hours","single_hour"=>"Single hour"),
							'default' => 'multiple_hours'
						),
						'show_hours_info' => array(
							'id'   => 'show_hours_info',
							'title' => 'Show hours availability info on hover',
							'description' => __('Display hours availability info when users mouse over on calendar days','booking-calendar' ),
							'type' => 'checkbox',
							'default' => 'on'
						),
						'hours' => array(
							'id'   => 'hours',
							'title' => 'Hours',
							'description' => __( 'Add a simple hour field(hh:mm) using "Add Hour" button or use our default hours button "Add Default", that will add 24 fields with 1 hour inteval for all day. Use 24 hour format.','booking-calendar' ),
							'extra_div_end' => true,
							'type' => 'hours_element',
							'default' => ''
						),
					),
					'widget_settings' => array(
						'show_day_info_on_hover' => array(
							'id'   => 'show_day_info_on_hover',
							'title' => __('Show Day Info on Hover','booking-calendar'),
							'description' => __('Select this option if you need to display days info on hover(only for widget calendar)','booking-calendar' ),
							'type' => 'checkbox',
							'default' => 'on'
						)
					)
                )					
			),
			"styles_and_colors" => array(
				'title' => __('Styles and Colors','booking-calendar'),
				'sections' => array(
					'styles' => array(
						/*Calendar styles*/
						'calendar_max_width' => array(
							'id'   => 'calendar_max_width',
							'title' => __('Calendar Maximum width','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '680'
						),
						'calendar_header_font_weight' => array(
							'id'   => 'calendar_header_font_weight',
							'title' => __('Calendar Header font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'calendar_header_font_style' => array(
							'id'   => 'calendar_header_font_style',
							'title' => __('Calendar Header font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'calendar_header_padding' => array(
							'id'   => 'calendar_header_padding',
							'title' => __('Calendar Header padding','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '10'
						),
						'next_prev_month_size' => array(
							'id'   => 'next_prev_month_size',
							'title' => __('Next Prev Month font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '15'
						),
						'current_month_size' => array(
							'id'   => 'current_month_size',
							'title' => __('Current Month font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '19'
						),
						'current_year_size' => array(
							'id'   => 'current_year_size',
							'title' => __('Current Year font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '19'
						),
						'week_days_font_weight' => array(
							'id'   => 'week_days_font_weight',
							'title' => __('Week Days font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'week_days_font_style' => array(
							'id'   => 'week_days_font_style',
							'title' => __('Week Days font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'week_days_size' => array(
							'id'   => 'week_days_size',
							'title' => __('Week Days font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '13'
						),
						'day_number_font_weight' => array(
							'id'   => 'day_number_font_weight',
							'title' => __('Day Number font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'day_number_font_style' => array(
							'id'   => 'day_number_font_style',
							'title' => __('Day Number font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'day_number_size' => array(
							'id'   => 'day_number_size',
							'title' => __('Day Number font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '13'
						),
						'day_availability_font_weight' => array(
							'id'   => 'day_availability_font_weight',
							'title' => __('Day Availability font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'day_availability_font_style' => array(
							'id'   => 'day_availability_font_style',
							'title' => __('Day Availability font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'day_availability_size' => array(
							'id'   => 'day_availability_size',
							'title' => __('Day Availability font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '13'
						),
						'day_price_font_weight' => array(
							'id'   => 'day_price_font_weight',
							'title' => __('Day Price font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'day_price_font_style' => array(
							'id'   => 'day_price_font_style',
							'title' =>__( 'Day Price font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'day_price_size' => array(
							'id'   => 'day_price_size',
							'title' => __('Day Price font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '12'
						),
						'days_min_height' => array(
							'id'   => 'days_min_height',
							'title' => __('Days height','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '65'
						),
						'hours_width' => array(
							'id'   => 'hours_width',
							'title' => __('Hours width','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '95'
						),
						'hours_height' => array(
							'id'   => 'hours_height',
							'title' => __('Hours height','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '125'
						),
						'info_font_weight' => array(
							'id'   => 'info_font_weight',
							'title' => __('Info font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'info_font_style' => array(
							'id'   => 'info_font_style',
							'title' => __('Info font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'info_size' => array(
							'id'   => 'info_size',
							'title' => __('Info font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '13'
						),
						'info_border_radius' => array(
							'id'   => 'info_border_radius',
							'title' => __('Info Border radius','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '0'
						),
						/*Form styles*/
						'form_title_weight' => array(
							'id'   => 'form_title_weight',
							'title' =>__('Form/Extra Title font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'form_title_style' => array(
							'id'   => 'form_title_style',
							'title' => __('Form/Extra Title font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'italic'
						),
						'form_title_size' => array(
							'id'   => 'form_title_size',
							'title' => __('Form/Extra Title font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '21'
						),
						'form_labels_weight' => array(
							'id'   => 'form_labels_weight',
							'title' => __('Form/Extra Labels font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'form_labels_style' => array(
							'id'   => 'form_labels_style',
							'title' => __('Form/Extra Labels font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'italic'
						),
						'form_labels_size' => array(
							'id'   => 'form_labels_size',
							'title' => __('Form/Extra Labels font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '15'
						),
						'form_fields_weight' => array(
							'id'   => 'form_fields_weight',
							'title' => __('Form/Extra Fields font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'form_fields_style' => array(
							'id'   => 'form_fields_style',
							'title' => __('Form/Extra Fields font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'form_fields_size' => array(
							'id'   => 'form_fields_size',
							'title' => __('Form/Extra Fields font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '15'
						),
						'form_submit_weight' => array(
							'id'   => 'form_submit_weight',
							'title' => __('Form Submit font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'form_style_style' => array(
							'id'   => 'form_style_style',
							'title' => __('Form Submit font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'reserv_info_weight' => array(
							'id'   => 'reserv_info_weight',
							'title' => __('Reservation Info font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'reserv_info_style' => array(
							'id'   => 'reserv_info_style',
							'title' => __('Reservation Info font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'reserv_info_size' => array(
							'id'   => 'reserv_info_size',
							'title' => __('Reservation Info font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '14'
						),
						'widget_day_info_weight' => array(
							'id'   => 'widget_day_info_weight',
							'title' => __('Widget Day Info font weight','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_weight(),
							'default' => 'normal'
						),
						'widget_day_info_style' => array(
							'id'   => 'widget_day_info_style',
							'title' => __('Widget Day Info font style','booking-calendar'),
							'description' => '',
							'type' => 'select',
							'valid_options' => $this->font_style(),
							'default' => 'normal'
						),
						'widget_day_info_size' => array(
							'id'   => 'widget_day_info_size',
							'title' => __('Widget Day Info font size','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => '14'
						)
					),
					"colors" => array(	
						/*Calendar colors*/
						'load_spinner_color' => array(
							'id'   => 'load_spinner_color',
							'title' => __('Load Spinner color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#464646'
						),
						'calendar_header_bg' => array(
							'id'   => 'calendar_header_bg',
							'title' => __('Calendar Header background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'next_prev_month' => array(
							'id'   => 'next_prev_month',
							'title' => __('Next Preview Month color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#636363'
						),
						'current_month' => array(
							'id'   => 'current_month',
							'title' => __('Current Month color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#636363'
						),
						'current_year' => array(
							'id'   => 'current_year',
							'title' => __('Current Year color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#636363'
						),
						'week_days_bg' => array(
							'id'   => 'week_days_bg',
							'title' => __('Week Days background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#ECECEC'
						),
						'week_days_color' => array(
							'id'   => 'week_days_color',
							'title' => __('Week Days color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#656565'
						),
						'calendar_bg' => array(
							'id'   => 'calendar_bg',
							'title' => __('Calendar background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'calendar_border' => array(
							'id'   => 'calendar_border',
							'title' => __('Calendar Border color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#ddd'
						),
						'day_bg' => array(
							'id'   => 'day_bg',
							'title' => __('Day background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'day_number_bg' => array(
							'id'   => 'day_number_bg',
							'title' => __('Day Number background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#ECECEC'
						),
						'day_color' => array(
							'id'   => 'day_color',
							'title' => __('Day Number color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#464646'
						),
						'day_availability_color' => array(
							'id'   => 'day_availability_color',
							'title' => __('Day Availability color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#848484'
						),
						'day_price_color' => array(
							'id'   => 'day_price_color',
							'title' =>__( 'Day Price color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#848484'
						),
						'available_day_bg' => array(
							'id'   => 'available_day_bg',
							'title' =>__( 'Available Day background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'available_day_number_bg' => array(
							'id'   => 'available_day_number_bg',
							'title' => __('Available Day Number background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#85B70B'
						),
						'available_day_color' => array(
							'id'   => 'available_day_color',
							'title' => __('Available Day Number color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'selected_day_bg' => array(
							'id'   => 'selected_day_bg',
							'title' => __('Selected Day background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'selected_day_number_bg' => array(
							'id'   => 'selected_day_number_bg',
							'title' => __('Selected Day Number background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#373740'
						),
						'selected_day_color' => array(
							'id'   => 'selected_day_color',
							'title' => __('Selected Day Number color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'selected_day_availability_color' => array(
							'id'   => 'selected_day_availability_color',
							'title' => __('Selected Day Availability color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#848484'
						),
						'selected_day_price_color' => array(
							'id'   => 'selected_day_price_color',
							'title' => __('Selected Day Price color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#848484'
						),
						'unavailable_day_bg' => array(
							'id'   => 'unavailable_day_bg',
							'title' => __('Unavailable Day background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'unavailable_day_number_bg' => array(
							'id'   => 'unavailable_day_number_bg',
							'title' => __('Unavailable Day Number background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#464646'
						),
						'unavailable_day_color' => array(
							'id'   => 'unavailable_day_color',
							'title' => __('Unavailable Day Number color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#ECECEC'
						),
						'unavailable_day_availability_color' => array(
							'id'   => 'unavailable_day_availability_color',
							'title' => __('Unavailable Day Availability color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#848484'
						),
						'booked_day_bg' => array(
							'id'   => 'booked_day_bg',
							'title' => __('Booked Day background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'booked_day_number_bg' => array(
							'id'   => 'booked_day_number_bg',
							'title' => __('Booked Day Number background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FD7C93'
						),
						'booked_day_color' => array(
							'id'   => 'booked_day_color',
							'title' => __('Booked Day Number color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'booked_day_availability_color' => array(
							'id'   => 'booked_day_availability_color',
							'title' => __('Booked Day Availability color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#848484'
						),
						'info_icon_color' => array(
							'id'   => 'info_icon_color',
							'title' => __('Info Icon color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'info_bg' => array(
							'id'   => 'info_bg',
							'title' => __('Info background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'info_color' => array(
							'id'   => 'info_color',
							'title' => __('Info color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#4E4E4E'
						),
						/*Form colors*/
						'form_bg' => array(
							'id'   => 'form_bg',
							'title' => __('Form background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FDFDFD'
						),
						'form_border' => array(
							'id'   => 'form_border',
							'title' => __('Form boreder color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#ddd'
						),
						'form_title_color' => array(
							'id'   => 'form_title_color',
							'title' => __('Form/Extra Title color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#636363'
						),
						'form_title_bg' => array(
							'id'   => 'form_title_bg',
							'title' => __('Form/Extra Title background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FDFDFD'
						),
						'form_labels_color' => array(
							'id'   => 'form_labels_color',
							'title' => __('Form/Extra Labels color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#636363'
						),
						'form_fields_color' => array(
							'id'   => 'form_fields_color',
							'title' => __('Form/Extra Fields color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#636363'
						),
						'reserv_info_color' => array(
							'id'   => 'reserv_info_color',
							'title' => __('Reservation Info color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#545454'
						),
						'total_bg' => array(
							'id'   => 'total_bg',
							'title' => __('Total Price background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#545454'
						),
						'total_color' => array(
							'id'   => 'total_color',
							'title' => __('Total Price color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#F7F7F7'
						),
						'required_star_color' => array(
							'id'   => 'required_star_color',
							'title' => __('Required Star color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FD7C93'
						),
						'submit_button_bg' => array(
							'id'   => 'submit_button_bg',
							'title' => __('Submit Button background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FD7C93'
						),
						'submit_button_color' => array(
							'id'   => 'submit_button_color',
							'title' => __('Submit Button color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'error_info_bg' => array(
							'id'   => 'error_info_bg',
							'title' => __('Error Info background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'error_info_color' => array(
							'id'   => 'error_info_color',
							'title' => __('Error Info color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#C11212'
						),
						'error_info_border' => array(
							'id'   => 'error_info_border',
							'title' => __('Error Info Border color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#C11212'
						),
						'error_info_close_bg' => array(
							'id'   => 'error_info_close_bg',
							'title' => __('Error Info Close background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#C11212'
						),
						'error_info_close_color' => array(
							'id'   => 'error_info_close_color',
							'title' => __('Error Info Close color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'successfully_info_bg' => array(
							'id'   => 'successfully_info_bg',
							'title' => __('Successfully Info background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'successfully_info_color' => array(
							'id'   => 'successfully_info_color',
							'title' => __('Successfully Info color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#7FAD16'
						),
						'successfully_info_border' => array(
							'id'   => 'successfully_info_border',
							'title' => __('Successfully Info Border color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#7FAD16'
						),
						'successfully_info_close_bg' => array(
							'id'   => 'successfully_info_close_bg',
							'title' => __('Successfully Info Close background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#7FAD16'
						),
						'successfully_info_close_color' => array(
							'id'   => 'successfully_info_close_color',
							'title' => __('Successfully Info Close color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'widget_day_info_bg' => array(
							'id'   => 'widget_day_info_bg',
							'title' => __('Widget Day Info background','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#FFFFFF'
						),
						'widget_day_info_color' => array(
							'id'   => 'widget_day_info_color',
							'title' => __('Widget Day Info color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#6B6B6B'
						),
						'widget_day_info_border_color' => array(
							'id'   => 'widget_day_info_border_color',
							'title' => __('Widget Day Info border color','booking-calendar'),
							'description' => '',
							'type' => 'color',
							'default' => '#C7C7C7'
						)
					)				
			    )			
			),
			"notifications" => array(
				'title' => __('Notifications','booking-calendar'),
				'sections' => array(
					'email_to_administrator' => array(
						'admin_mail_info' => array(
							'id'   => 'admin_mail_info',
							'title' => __('You can use these shortcodes in content of admin templates','booking-calendar'),
							'description' => '<span>[calendartitle]</span> - inserting title of calendar,<br><span>[details]</span> - inserting details about the reservation,<br><span>[siteurl]</span> - inserting your site URL ,<br><span>[moderatelink]</span> - inserting moderate link of new reservation,<br><span>[form]</span> - inserting form information,<br><span>[extras]</span> - inserting extras information, ',
							'type' => 'info',
							'default' => ''
						),
						'admin_mail_info2' => array(
							'id'   => 'admin_mail_info2',
							'title' => __('You can use this shortcodes in Email From: field','booking-calendar'),
							'description' => '<span>[useremail]</span> - inserting user email, ',
							'type' => 'info',
							'default' => ''
						),
						'notify_admin_on_book' => array(
							'id'   => 'notify_admin_on_book',
							'title' => __('Notify on book request','booking-calendar'),
							'description' => '',
							'enable' => array('notify_admin_on_book_to','notify_admin_on_book_from','notify_admin_on_book_subject','notify_admin_on_book_content'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'notify_admin_on_book_to' => array(
							'id'   => 'notify_admin_on_book_to',
							'title' => __('To:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'extra_div' => true,
							'default' => get_option("admin_email")
						),
						'notify_admin_on_book_from' => array(
							'id'   => 'notify_admin_on_book_from',
							'title' => __('Email From:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => '[useremail]'
						),
						'notify_admin_on_book_fromname' => array(
							'id'   => 'notify_admin_on_book_fromname',
							'title' => __('From Name:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => ''
						),
						'notify_admin_on_book_subject' => array(
							'id'   => 'notify_admin_on_book_subject',
							'title' => __('Subject:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => 'You received a booking request.'
						),
						'notify_admin_on_book_content' => array(
							'id'   => 'notify_admin_on_book_content',
							'title' => __('Content:','booking-calendar'),
							'description' => '',
							'type' => 'textarea',
							'wp_editor' => true,
							'required' => "on",
							'default' => ''
						),
						'notify_admin_on_book_error' => array(
							'id'   => 'notify_admin_on_book_error',
							'title' => __("Enable notification when email doesn't send",'booking-calendar'),
							'description' => '',
							'type' => 'checkbox',
							'width' => 340,
							'extra_div_end' => true,
							'default' => ''
						),
						'notify_admin_on_approved' => array(
							'id'   => 'notify_admin_on_approved',
							'title' => __('Notify on approved book request','booking-calendar'),
							'description' => '',
							'enable' => array('notify_admin_on_approved_to','notify_admin_on_approved_from','notify_admin_on_approved_subject','notify_admin_on_approved_content'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'notify_admin_on_approved_to' => array(
							'id'   => 'notify_admin_on_approved_to',
							'title' => __('To:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'extra_div' => true,
							'default' => get_option("admin_email")
						),
						'notify_admin_on_approved_from' => array(
							'id'   => 'notify_admin_on_approved_from',
							'title' => __('Email From:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => '[useremail]'
						),
						'notify_admin_on_approved_fromname' => array(
							'id'   => 'notify_admin_on_approved_fromname',
							'title' => __('From Name:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => ''
						),
						'notify_admin_on_approved_subject' => array(
							'id'   => 'notify_admin_on_approved_subject',
							'title' => __('Subject:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => 'You received a booking request.'
						),
						'notify_admin_on_approved_content' => array(
							'id'   => 'notify_admin_on_approved_content',
							'title' => __('Content:','booking-calendar'),
							'description' => '',
							'type' => 'textarea',
							'wp_editor' => true,
							'required' => "on",
							'default' => ''
						),
						'notify_admin_on_approved_error' => array(
							'id'   => 'notify_admin_on_approved_error',
							'title' => __("Enable notification when email doesn't send",'booking-calendar'),
							'description' => '',
							'type' => 'checkbox',
							'width' => 340,
							'extra_div_end' => true,
							'default' => ''
						),
						/*'notify_admin_paypal' => array(
							'id'   => 'notify_admin_paypal',
							'title' => __( 'PayPal - Notify', 'booking-calendar' ),
							'description' => '',
							'enable' => array('notify_admin_paypal_to','notify_admin_paypal_from','notify_admin_paypal_subject','notify_admin_paypal_content'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'notify_admin_paypal_to' => array(
							'id'   => 'notify_admin_paypal_to',
							'title' => __( 'To:', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'extra_div' => true,
							'default' => get_option("admin_email"))
						),
						'notify_admin_paypal_from' => array(
							'id'   => 'notify_admin_paypal_from',
							'title' => __( 'Email From:', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => '[useremail]'
						),
						'notify_admin_paypal_fromname' => array(
							'id'   => 'notify_admin_paypal_fromname',
							'title' => __( 'From Name:', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => ''
						),
						'notify_admin_paypal_subject' => array(
							'id'   => 'admin_paypal_subject',
							'title' => __( 'Subject:', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => 'You received a booking request.'
						),
						'notify_admin_paypal_content' => array(
							'id'   => 'admin_paypal_content',
							'title' => __( 'Content:', 'booking-calendar' ),
							'description' => '',
							'type' => 'textarea',
							'wp_editor' => true,
							'required' => "on",
							'extra_div_end' => true,
							'default' => ''
						)*/
					),
					'email_to_user' => array(
						'user_mail_info' => array(
							'id'   => 'user_mail_info',
							'title' => __('You can use these shortcodes in content of user templates','booking-calendar'),
							'description' => '<span>[calendartitle]</span> - inserting title of calendar,<br><span>[details]</span> - inserting details about the reservation,<br><span>[siteurl]</span> - inserting your site URL ,<br><span>[form]</span> - inserting form information,<br><span>[extras]</span> - inserting extras information, ',
							'type' => 'info',
							'default' => ''
						),
						'notify_user_on_book' => array(
							'id'   => 'notify_user_on_book',
							'title' =>__('Notify on book request','booking-calendar'),
							'description' => '',
							'enable' => array('notify_user_on_book_from','notify_user_on_book_subject','notify_user_on_book_content'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'notify_user_on_book_from' => array(
							'id'   => 'notify_user_on_book_from',
							'title' => __('Email From:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'extra_div' => true,
							'default' => get_option("admin_email")
						),
						'notify_user_on_book_fromname' => array(
							'id'   => 'notify_user_on_book_fromname',
							'title' => __('From Name:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => ""
						),
						'notify_user_on_book_subject' => array(
							'id'   => 'notify_user_on_book_subject',
							'title' => __('Subject:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => 'Your booking request has been sent.'
						),
						'notify_user_on_book_content' => array(
							'id'   => 'notify_user_on_book_content',
							'title' => __('Content:','booking-calendar'),
							'description' => '',
							'type' => 'textarea',
							'wp_editor' => true,
							'required' => "on",
							'default' => ''
						),
						'notify_user_on_book_error' => array(
							'id'   => 'notify_user_on_book_error',
							'title' => __("Enable notification when email doesn't send",'booking-calendar'),
							'description' => '',
							'type' => 'checkbox',
							'width' => 340,
							'extra_div_end' => true,
							'default' => ''
						),
						'notify_user_on_approved' => array(
							'id'   => 'notify_user_on_approved',
							'title' =>__( 'Notify when reservation is approved','booking-calendar'),
							'description' => '',
							'enable' => array('notify_user_on_approved_from','notify_user_on_approved_subject','notify_user_on_approved_content'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'notify_user_on_approved_from' => array(
							'id'   => 'notify_user_on_approved_from',
							'title' => __('Email From:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'extra_div' => true,
							'default' => get_option("admin_email")
						),
						'notify_user_on_approved_fromname' => array(
							'id'   => 'notify_user_on_approved_fromname',
							'title' => __('From Name:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => ""
						),
						'notify_user_on_approved_subject' => array(
							'id'   => 'notify_user_on_approved_subject',
							'title' => __('Subject:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => 'Your booking request has been approved'
						),
						'notify_user_on_approved_content' => array(
							'id'   => 'notify_user_on_approved_content',
							'title' => __('Content:','booking-calendar'),
							'description' => '',
							'type' => 'textarea',
							'wp_editor' => true,
							'required' => "on",
							'default' => ''
						),
						'notify_user_on_approved_error' => array(
							'id'   => 'notify_user_on_approved_error',
							'title' => __("Enable notification when email doesn't send",'booking-calendar'),
							'description' => '',
							'type' => 'checkbox',
							'width' => 340,
							'extra_div_end' => true,
							'default' => ''
						),
						'notify_user_canceled' => array(
							'id'   => 'notify_user_canceled',
							'title' => __('Notify when reservation is canceled','booking-calendar'),
							'description' => '',
							'enable' => array('notify_user_canceled_from','notify_user_canceled_subject','notify_user_canceled_content'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'notify_user_canceled_from' => array(
							'id'   => 'notify_user_canceled_from',
							'title' => __('Email From:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'extra_div' => true,
							'default' => get_option("admin_email")
						),
						'notify_user_canceled_fromname' => array(
							'id'   => 'notify_user_canceled_fromname',
							'title' => __('From Name:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => ""
						),
						'notify_user_canceled_subject' => array(
							'id'   => 'notify_user_canceled_subject',
							'title' => __('Subject:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => 'Your booking request has been canceled'
						),
						'notify_user_canceled_content' => array(
							'id'   => 'notify_user_canceled_content',
							'title' => __('Content:','booking-calendar'),
							'description' => '',
							'type' => 'textarea',
							'wp_editor' => true,
							'required' => "on",
							'default' => ''
						),
						'notify_user_canceled_error' => array(
							'id'   => 'notify_user_canceled_error',
							'title' => __("Enable notification when email doesn't send",'booking-calendar'),
							'description' => '',
							'type' => 'checkbox',
							'width' => 340,
							'extra_div_end' => true,
							'default' => ''
						),
						'notify_user_deleted' => array(
							'id'   => 'notify_user_deleted',
							'title' => __('Notify when reservation is deleted (rejected)','booking-calendar'),
							'description' => '',
							'enable' => array('notify_user_deleted_from','notify_user_deleted_subject','notify_user_deleted_content'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'notify_user_deleted_from' => array(
							'id'   => 'notify_user_deleted_from',
							'title' => __('Email From:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'extra_div' => true,
							'default' => get_option("admin_email")
						),
						'notify_user_deleted_fromname' => array(
							'id'   => 'notify_user_deleted_fromname',
							'title' => __('From Name:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => ""
						),
						'notify_user_deleted_subject' => array(
							'id'   => 'notify_user_deleted_subject',
							'title' => __('Subject:','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => 'Your booking request has been rejected'
						),
						'notify_user_deleted_content' => array(
							'id'   => 'notify_user_deleted_content',
							'title' => __('Content:','booking-calendar'),
							'description' => '',
							'type' => 'textarea',
							'required' => "on",
							'wp_editor' => true,
							'default' => ''
						),
						'notify_user_deleted_error' => array(
							'id'   => 'notify_user_deleted_error',
							'title' => __("Enable notification when email doesn't send",'booking-calendar'),
							'description' => '',
							'type' => 'checkbox',
							'width' => 340,
							'extra_div_end' => true,
							'default' => ''
						),
						/*'notify_user_paypal' => array(
							'id'   => 'notify_user_paypal',
							'title' => __( 'PayPal - Notify', 'booking-calendar' ),
							'description' => '',
							'enable' => array('notify_user_paypal_from','notify_user_paypal_subject','notify_user_paypal_content'),
							'type' => 'checkbox_enable',
							'default' => 'on'
						),
						'notify_user_paypal_from' => array(
							'id'   => 'notify_user_paypal_from',
							'title' => __( 'Email From:', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'extra_div' => true,
							'default' => get_option("admin_email")
						),
						'notify_user_paypal_fromname' => array(
							'id'   => 'notify_user_paypal_fromname',
							'title' => __( 'From Name:', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => ""
						),
						'notify_user_paypal_subject' => array(
							'id'   => 'notify_user_paypal_subject',
							'title' => __( 'Subject:', 'booking-calendar' ),
							'description' => '',
							'type' => 'text',
							'width' => 340,
							'default' => 'Your booking request has been sent.'
						),
						'notify_user_paypal_content' => array(
							'id'   => 'notify_user_paypal_content',
							'title' => __( 'Content:', 'booking-calendar' ),
							'description' => '',
							'type' => 'textarea',
							'wp_editor' => true,
							'extra_div_end' => true,
							'default' => ''
						)*/
					)
				)
			),
			"default_texts" => array(
				'title' => __('Default Texts','booking-calendar'),
				'sections' => array(
					'default_texts' => array(
						'use_mo' => array(
							'id'   => 'use_mo',
							'title' => __('Use mo','booking-calendar'),
							'description' => 'Use .mo file',
							'type' => 'checkbox',							
							'default' => ''
						),
						'for_available' => array(
							'id'   => 'for_available',
							'title' => __('Text for available','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'available'
						),
						'for_booked' => array(
							'id'   => 'for_booked',
							'title' => __('Text for booked','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Booked'
						),
						'for_unavailable' => array(
							'id'   => 'for_unavailable',
							'title' => __('Text for unavailable','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Unavailable'
						),
						'for_check_in' => array(
							'id'   => 'for_check_in',
							'title' => __('Text for check in','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Check in'
						),
						'for_check_out' => array(
							'id'   => 'for_check_out',
							'title' => __('Text for check out','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Check out'
						),
						'for_no_hour' => array(
							'id'   => 'for_no_hour',
							'title' => __('Text for No hour available.','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'No hour available.'
						),
						'for_start_hour' => array(
							'id'   => 'for_start_hour',
							'title' => __('Text for start hour','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Start hour'
						),
						'for_end_hour' => array(
							'id'   => 'for_end_hour',
							'title' => __('Text for end hour','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'End hour'
						),
						'for_item_count' => array(
							'id'   => 'for_item_count',
							'title' => __('Text for item count','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Item count'
						),
						'for_termscond' => array(
							'id'   => 'for_termscond',
							'title' => __('Text for terms & conditions','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'I accept to agree to the Terms & Conditions.'
						),
						'for_reservation' => array(
							'id'   => 'for_reservation',
							'title' => __('Text for reservation','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Reservation'
						),
						'for_select_days' => array(
							'id'   => 'for_select_days',
							'title' => __('Text for select days','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Please select the days from calendar.'
						),
						'for_price' => array(
							'id'   => 'for_price',
							'title' => __('Text for price','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Price'
						),
						'for_total' => array(
							'id'   => 'for_total',
							'title' => __('Text for total','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Total'
						),
						'for_submit_button' => array(
							'id'   => 'for_submit_button',
							'title' => __('Text for submit button','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Book Now'
						),
						'for_request_successfully_sent' => array(
							'id'   => 'for_request_successfully_sent',
							'title' => __('Text for request successfully sent','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Your request has been successfully sent. Please wait for approval.'
						),
						'for_request_successfully_received' => array(
							'id'   => 'for_request_successfully_received',
							'title' => __('Text for request successfully received','booking-calendar'),
							'description' => '',
							'type' => 'text',
							'default' => 'Your request has been successfully received. We are waiting you!'
						),
						'for_error_single' => array(
							'id'   => 'for_error_single',
							'title' => __('Text for no services available(single days)','booking-calendar'),
							'description' => "",
							'type' => 'text',
							'default' => 'There are no services available for this day.'
						),
						'for_error_multi' => array(
							'id'   => 'for_error_multi',
							'title' => __('Text for no services available(multiple days)','booking-calendar'),
							'description' =>"",
							'type' => 'text',
							'default' => 'There are no services available for the period you selected.'
						),
						'for_notify_texts' => array(
							'id'   => 'for_notify_texts',
							'title' => __("Notification texts when email doesn't send",'booking-calendar'),
							'description' => "",
							'type' => 'empty',
							'default' => ""
						),
						'for_notify_admin_on_book' => array(
							'id'   => 'for_notify_admin_on_book',
							'title' => __("To administrator after book request",'booking-calendar'),
							'description' => "",
							'type' => 'text',
							'default' => "Email on book to administrator doesn't send"
						),
						'for_notify_admin_on_approved' => array(
							'id'   => 'for_notify_admin_on_approved',
							'title' => __("To administrator after book request approved",'booking-calendar'),
							'description' => "",
							'type' => 'text',
							'default' => "Email on approved to administrator doesn't send"
						),
						'for_notify_user_on_book' => array(
							'id'   => 'for_notify_user_on_book',
							'title' => __("To user after book request",'booking-calendar'),
							'description' => "",
							'type' => 'text',
							'default' => "Email on book to user doesn't send"
						),
						'for_notify_user_on_approved' => array(
							'id'   => 'for_notify_user_on_approved',
							'title' => __("To user after book request approved",'booking-calendar'),
							'description' => "",
							'type' => 'text',
							'default' => "Email on approved to user doesn't send"
						),
						'for_notify_user_canceled' => array(
							'id'   => 'for_notify_user_canceled',
							'title' => __("To user after book request canceled",'booking-calendar'),
							'description' => "",
							'type' => 'text',
							'default' => "Email on canceled to user doesn't send"
						),
						'for_notify_user_deleted' => array(
							'id'   => 'for_notify_user_deleted',
							'title' => __("To user after book request deleted",'booking-calendar'),
							'description' => "",
							'type' => 'text',
							'default' => "Email on delete to user doesn't send"
						)
					)
				)
			)	
		);
		if($id != 0){
			$setting_rows = $this->model_obj->get_setting_rows( $id );
			$value = json_decode( $setting_rows->value, true );
		}
		?>
		<div id="wpdevart_themes" class="wpdevart-item-container wpdevart-main-item-container">
			<?php
			    if($id != 0){ ?>
					<div class="div-for-clear">
						<span class="admin_logo"></span>
						<h1><?php _e('Edit Theme','booking-calendar'); ?></h1>
					</div>
				<?php } else { ?>
					<div class="div-for-clear">
						<span class="admin_logo"></span>
						<h1><?php _e('Add Theme','booking-calendar'); ?></h1>
					</div>
				<?php } ?>
			<form action="?page=wpdevart-themes" method="post" class="div-for-clear">
				<div id="wpdevart_wpdevart-item_title">
					<span><?php _e('Theme Name','booking-calendar'); ?></span> <input type="text" name="title" value="<?php if(isset($setting_rows->title)) echo esc_attr($setting_rows->title); ?>">
					<input type="button" value="Save" class="action-link wpda-input" name="save" onclick="content_required('save')">
					<input type="button" value="Apply" class="action-link wpda-input" name="apply" onclick="content_required('apply')">
				</div>
				<div id="wpdevart-tabs-container" class="div-for-clear">
					<div id="wpdevart_theme-tabs" class="div-for-clear">
						<?php foreach($wpdevart_themes as $key=>$wpdevart_theme) { ?>
							<div id="wpdevart_theme-tab-<?php echo $key; ?>" class="wpdevart_tab <?php echo ($key == "general")? "show" : ""; ?>"><?php echo $wpdevart_theme["title"];
							?></div>
						<?php } ?>
					</div>
					<div id="wpdevart-tabs-item-container" class="div-for-clear">
						<?php foreach( $wpdevart_themes as $key=>$wpdevart_setting ) {
							$pro = false;
							if(isset($wpdevart_setting['pro']) && $wpdevart_setting['pro'] === true) {
								$pro = true;
							}
						?>
							<div id="wpdevart_theme-tab-<?php echo $key; ?>_container" class="wpdevart_container wpdevart-item-section <?php echo ($key == "general")? "show" : ""; ?>"> 
							<?php foreach( $wpdevart_setting['sections'] as $value_key=>$value_setting ) { ?>
								<div class="wpdevart-item-section-cont">
									<h3><?php echo str_replace("_"," ",$value_key); ?></h3>
									<div>
										<?php
										foreach( $value_setting as $key => $wpdevart_setting_value ) {
											if(isset($wpdevart_setting_value["extra_div"]) && $wpdevart_setting_value["extra_div"]){
												echo "<div class='items_open'>";
											}
											
											if( isset($value[$key]) ) {
												$sett_value = $value[$key];
											} else if(isset($value) && ($wpdevart_setting_value["type"] == "checkbox" || $wpdevart_setting_value["type"] == "checkbox_enable")){
												if(isset($wpdevart_setting_value["valid_options"])) {
													$sett_value = array();
												} else {
													$sett_value = "";
												}
											} else {
												$sett_value = $wpdevart_setting_value['default'];
											}

											$function_name = "wpdevart_callback_" . $wpdevart_setting_value['type'];
											wpdevart_bc_Library::$function_name($wpdevart_setting_value, $sett_value, $pro);
											if(isset($wpdevart_setting_value["extra_div_end"]) && $wpdevart_setting_value["extra_div_end"]){
												echo "</div>";
											}
										}
									?>
									</div>	
								</div>	
							<?php } ?>	
							</div>	
						<?php  } ?>
						<input type="hidden" id="button_action" name="button_action" value="">
						<input type="hidden" name="task" value="save">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
				    </div>
				</div>
			</form>
		</div>
	<?php	
	}
  
    private function font_weight() {
		$font_weight = array(
		     "normal" => "Normal",
		     "bold"   => "Bold",
		     "light"  => "Light"
		);
		return $font_weight;
	}
  
    private function font_style() {
		$font_style = array(
		     "normal" => "Normal",
		     "italic" => "Italic",
		);
		return $font_style;
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
	
    private function cal_animation_type() {
		$cal_animation_type = array(
		     "none" => "None",
		     "random" => "Random",
		     "bounce" => "Bounce",
		     "flash" => "Flash",
		     "pulse" => "Pulse",
		     "rubberBand" => "RubberBand",
		     "shake" => "Shake",
		     "swing" => "Swing",
		     "tada" => "Tada",
		     "wobble" => "Wobble",
		     "bounceIn" => "BounceIn",
		     "bounceInDown" => "BounceInDown",
		     "bounceInLeft" => "BounceInLeft",
		     "bounceInRight" => "BounceInRight",
		     "bounceInUp" => "BounceInUp",
		     "fadeIn" => "FadeIn",
		     "fadeInDown" => "FadeInDown",
		     "fadeInDownBig" => "FadeInDownBig",
		     "fadeInLeft" => "FadeInLeft",
		     "fadeInLeftBig" => "FadeInLeftBig",
		     "fadeInRight" => "FadeInRight",
		     "fadeInRightBig" => "FadeInRightBig",
		     "fadeInUp" => "FadeInUp",
		     "fadeInUpBig" => "FadeInUpBig",
		     "flip" => "Flip",
		     "flipInX" => "FlipInX",
		     "flipInY" => "FlipInY",
		     "lightSpeedIn" => "LightSpeedIn",
		     "rotateIn" => "RotateIn",
		     "rotateInDownLeft" => "RotateInDownLeft",
		     "rotateInDownRight" => "RotateInDownRight",
		     "rotateInUpLeft" => "RotateInUpLeft",
		     "rotateInUpRight" => "RotateInUpRight",
		     "rollIn" => "RollIn",
		     "zoomIn" => "ZoomIn",
		     "zoomInDown" => "ZoomInDown",
		     "zoomInLeft" => "ZoomInLeft",
		     "zoomInRight" => "ZoomInRight",
		     "zoomInUp" => "ZoomInUp",
		);
		return $cal_animation_type;
	}

}

?>