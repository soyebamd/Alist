  
var wpdevartScript;
var wpdevartScriptOb;

jQuery( document ).ready(function() {

	wpdevartScript = function () {
		var $ = jQuery;

		var ajax_next = "";
		$(".wpda-booking-calendar-head:not(.reservation) .wpda-previous,.wpda-booking-calendar-head:not(.reservation) .wpda-next").on( "click", function(e){
			if(typeof(start_index) == "undefined") {
				start_index = "";
				selected_date = "";
			}
			e.preventDefault();
			var bc_main_div = $(this).closest('.booking_calendar_container');
			$(bc_main_div).find('.wpdevart-load-overlay').show();
			$.post(wpdevart.ajaxUrl, {
				action: 'wpdevart_ajax',
				wpdevart_selected: start_index,
				wpdevart_selected_date: selected_date,
				wpdevart_link: $(this).find('a').attr('href'),
				wpdevart_id: $(this).closest(".booking_calendar_main_container").data('id'),
				wpdevart_nonce: wpdevart.ajaxNonce
			}, function (data) {
				$(bc_main_div).find('div.booking_calendar_main').replaceWith(data);
				$(bc_main_div).find('.wpdevart-load-overlay').hide();

				if($(data).find(".wpdevart-day.selected").length == 1) {
					select_index = $(data).find(".wpdevart-day.selected").index() - 7;
				} else if($(data).find(".wpdevart-day.selected").length == 0){
					select_index = 0;
				}
			});
			e.stopPropagation();
		});

		$(".reservation .wpda-previous,.reservation .wpda-next").on( "click", function(e){
			if(typeof(start_index) == "undefined") {
				start_index = "";
				selected_date = "";
			}
			e.preventDefault();
			var bc_main_div = $(this).closest('.booking_calendar_container');
			if($(".wpdevart_res_month_view").length != 0) {
				var reserv = "true";
				var cal_id = $(this).parent().parent().find("table").data('id');
			} else {
				var reserv = "false";
				var cal_id = $(this).closest(".booking_calendar_main_container").data('id');
			}
			$(bc_main_div).find('.wpdevart-load-overlay').show();
			$.post(wpdevart.ajaxUrl, {
				action: 'wpdevart_ajax',
				wpdevart_reserv: reserv,
				wpdevart_selected: start_index,
				wpdevart_selected_date: selected_date,
				wpdevart_link: $(this).find('a').attr('href'),
				wpdevart_id: cal_id,
				wpdevart_nonce: wpdevart.ajaxNonce
			}, function (data) {
				$(bc_main_div).find('div.booking_calendar_main').replaceWith(data);
				$(bc_main_div).find('.wpdevart-load-overlay').hide();
				if($(data).find(".wpdevart-day.selected").length == 1) {
					select_index = $(data).find(".wpdevart-day.selected").index() - 7;
				} else if($(data).find(".wpdevart-day.selected").length == 0){
					select_index = 0;
				}

			});
			e.stopPropagation();
		});
		$(".wpda-booking-calendar-head .wpda-next").on( "click", function(e){
			ajax_next = "next";
		});
		$(".wpda-booking-calendar-head .wpda-previous").on( "click", function(e){
			ajax_next = "prev";
		});
		
		
		$(".wpdevart-submit").on( "click", function(e){
			var wpdevart_required_field = wpdevart_required($(this));
			e.preventDefault();
			if(wpdevart_required_field === true) {
				var reserv_data = {};
				var offset = $(this).closest(".booking_calendar_main_container").data("offset");
				$(this).closest("form").find("input[type=text],button,input[type=hidden],input[type=checkbox],input[type=radio],select,textarea").each(function(index,element){
					if(jQuery(element).is("input[type=checkbox]")) {
						if(jQuery(element).is(':checked')) {
							reserv_data[jQuery(element).attr("name")] = "on";
						} else {
							reserv_data[jQuery(element).attr("name")] = "";
						}
					} else if(jQuery(element).is("select") && jQuery(element).attr("multiple") == "multiple"){
						if($(element).val()) {
							var multy_select = $(element).val().join(", ");
							reserv_data[jQuery(element).attr("name")] = multy_select;
						}
					}else {
						reserv_data[jQuery(element).attr("name")] = $(element).val();
					}
				});
				reserv_json = JSON.stringify(reserv_data);
				$(this).addClass("load");
				var reserv_form = $(this).closest("form");
				var reserv_cont = $(this).closest(".booking_calendar_main_container");
				var form_div = $(this).closest(".wpdevart-booking-form-container");
				$.post(wpdevart.ajaxUrl, {
					action: 'wpdevart_form_ajax',
					wpdevart_data: reserv_json,
					wpdevart_id: $(this).closest(".booking_calendar_main_container").data('id'),
					wpdevart_submit: $(this).attr('id').replace("wpdevart-submit", ""),
					wpdevart_nonce: wpdevart.ajaxNonce
				}, function (data) {
					if($(form_div).hasClass("hide_form")) {
						$(form_div).hide();
					}
					$(reserv_cont).find('div.booking_calendar_main').replaceWith(data);
					$(reserv_cont).find('div.selected').removeClass("selected");
					$(reserv_form).find("input[type=text],input[type=hidden],textarea").each(function(index,element){
						jQuery(element).val("");
					});
					$(reserv_form).find("select").each(function(index,element){
						jQuery(element).find("option:selected").removeAttr("selected");
					});
					$(reserv_form).find("input[type=checkbox],input[type=radio]").each(function(index,element){
						jQuery(element).find(":checked").removeAttr("checked");
					});
					$(reserv_form).find(".wpdevart-submit").removeClass("load").hide();
					$(window).scrollTo( reserv_cont, 400,{'offset':{'top':-(offset)}});
				});
				e.stopPropagation();
			}
		});
		
		/*
		*CALENDAR
		*/
		var select_ex = false,
			existtt = false,
			count_item = $(".wpdevart-day").length,
			start_index,check_in,check_out,
			item_count = "",
			extra_price_value = 0;
		if($("#wpdevart_update_res").length){
			existtt = true;
			item_click(false,$(".wpdevart-day.selected").get(0));
		}	
			
		$(document).on("click",".wpdevart-day", function() {
			item_click(false,this);
		});
		
		$(".wpdevart-day").on("hover",function(){
			item_hover(false,this);
		});
		
		/*
		*HOURS
		*/
		
                $(document).on("click", ".wpdevart-hour-item",function() {
                    item_click(true,this);	
                });

		
		$(document).on("click", ".wpdevart-hour-item",function() {
			item_hover(true,this);
		});
		
		function item_hover(hour,el) {
			if(hour == true) {
				var selected = "hour_selected";
				var item = "wpdevart-hour-item";
			} else {
				var selected = "selected";
				var item = "wpdevart-day";
			}	
			if(typeof id == "undefined") {
				id = 0;
			}
			if(id != 0) {
				if(($("#booking_calendar_main_container_"+id+" ."+selected).length != 0 || typeof(start_index) != "undefined") && select_ex == false && ($("#wpdevart_single_day" + id).length == 0 || (hour == true && $("#wpdevart_form_hour" + id).length == 0)) && (start_index != "" || hour == true)) {
					end_index = $("#booking_calendar_main_container_"+id+" ."+item).index(el);
					if(ajax_next == "" || hour == true) {
						if(start_index <= end_index) {
							for(var j = 0; j < start_index; j++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(j).removeClass(selected);
							}
							for(var n = end_index; n < count_item; n++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(n).removeClass(selected);
							}
							for (var i = start_index; i < end_index; i++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(i).addClass(selected);
							}
						}
						else if(start_index >= end_index){
							for(var k = start_index+1; k < count_item; k++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(k).removeClass(selected);
							}
							for(var p = 0; p < end_index; p++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(p).removeClass(selected);
							}
							for (var m = end_index; m < start_index; m++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(m).addClass(selected);
							}
						}
					} else if(ajax_next == "next" && hour == false) {
						if(select_index <= end_index) {
							for(var j = 0; j < select_index; j++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(j).removeClass(selected);
							}
							for(var n = end_index; n < count_item; n++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(n).removeClass(selected);
							}
							for (var i = select_index; i < end_index; i++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(i).addClass(selected);
							}
						}
						else if(select_index >= end_index){
							for(var k = select_index+1; k < count_item; k++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(k).removeClass(selected);
							}
							for(var p = 0; p < end_index; p++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(p).removeClass(selected);
							}
							for (var m = end_index; m < select_index; m++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(m).addClass(selected);
							}
						}
					} else if(ajax_next == "prev" && hour == false) {
						if(select_index == 0) {
							select_index = count_item;
						}
						if(select_index <= end_index) {
							for(var j = 0; j < select_index; j++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(j).removeClass(selected);
							}
							for(var n = end_index; n < count_item; n++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(n).removeClass(selected);
							}
							for (var i = select_index; i < end_index; i++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(i).addClass(selected);
							}
						}
						else if(select_index >= end_index){
							for(var k = select_index+1; k < count_item; k++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(k).removeClass(selected);
							}
							for(var p = 0; p < end_index; p++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(p).removeClass(selected);
							}
							for (var m = end_index; m < select_index; m++) {
								$("#booking_calendar_main_container_"+id+" ."+item).eq(m).addClass(selected);
							}
						}
					}
					$(el).addClass(selected);
				}
			}
			if($(el).closest(".booking_calendar_main_container").hasClass("booking_widget") && $(el).closest(".booking_calendar_main_container").hasClass("show_day_info_on_hover") && hour == false) {
				if($(el).find(".booking_widget_day").length == 0) {
					var day_price = "",
						day_user_info = "",
						day_availability = "";
					if($(el).find(".day-availability").length != 0) {
						day_availability = "<div class='day-availability'>"+$(el).find(".day-availability").clone().html()+"</div>";
					}
					if($(el).find(".day-price").length != 0) {
						day_price = "<div class='day-price'>"+$(el).find(".day-price").clone().html()+"</div>";
					}
					if($(el).find(".day-user-info").length != 0) {
						day_user_info = "<div class='widget-day-user-info'>"+$(el).find(".day-user-info").clone().html()+"</div>";
					}
					if(day_price != "" || day_availability != "" || day_user_info != "") {
						$(el).append("<div class='booking_widget_day'>"+day_user_info+day_availability+day_price+"</div>");
					}
				}
			}
		}
		
		
		function item_click(hour,el) {
			var price = 0,
				price_div = "",
				total_div = "",
				extra_div = "",
				currency = "",
				selected_count = 0,
				div_container = $(el).closest(".booking_calendar_main_container"),
				calendar_idd = $(div_container).data("id"),
				form_container = $(el).closest(".booking_calendar_main_container").find(".wpdevart-booking-form-container"),				
				offset = $(div_container).data("offset");
				pos = $(div_container).data("position");
				id = $(div_container).attr("id").replace("booking_calendar_main_container_", "");
				date_data = {};
			if(hour == true) {
				var selected = "hour_selected";
				var available = "wpdevart-hour-available";
				var item = "wpdevart-hour-item";
				var for_hidden = "#wpdevart_start_hour"+id;
				var for_hidden_end = "#wpdevart_end_hour"+id;
			} else {
				var selected = "selected";
				var available = "wpdevart-available";
				var item = "wpdevart-day";
				var for_hidden = "#wpdevart_form_checkin"+id;
				var for_hidden_end = "#wpdevart_form_checkout"+id;
			}	
				if(!$(el).hasClass(available)  && $("#booking_calendar_main_container_"+id+" ."+selected).length == 0 || $(item).parent().hasClass("wpdevart-day-hours")){
				return false;
			}	
			if(($("#wpdevart_form_checkin" + id).length != 0 || (hour == true && $("#wpdevart_start_hour" + id).length != 0))) {
				selected_count = $("#booking_calendar_main_container_"+id+" ."+item+"."+selected).length;
				selected_av_count = $("#booking_calendar_main_container_"+id+" ."+available+"."+selected).length;
				if(select_ex == true) {
					$("#booking_calendar_main_container_"+id+" ."+item).each(function() {
						$(this).removeClass(selected);
					});
					/*$(for_hidden).val($(el).data("date"));
					$(for_hidden_end).val($(el).data("date"));*/
					select_ex = false;
				}
				if(selected_count == 0 || existtt == true) {
					ajax_next = "";
					$(el).addClass(selected);
					start_index = $("#booking_calendar_main_container_"+id+" ."+item).index(el);
					selected_date = $("#booking_calendar_main_container_"+id+" ."+item).eq(start_index).data("date");
					selected_dateformat= $("#booking_calendar_main_container_"+id+" ."+item).eq(start_index).data("dateformat");
				} 
				else {
					if(existtt == false)
					select_ex = true;
				}
				if(select_ex == true){
					var exist = false;
					for(var k=0; k<$("#booking_calendar_main_container_"+id+" ."+selected).length; k++){
						if(typeof($("#booking_calendar_main_container_"+id+" ."+selected).eq(k).data("available")) == "undefined") {
							if($("#booking_calendar_main_container_"+id).data("night") == 1 && ($("#booking_calendar_main_container_"+id+" ."+selected).length - 1) == k && exist == false) {
								break;
							}
							exist = true;
						}
					}
					if(exist == true) {
						$(div_container).find(".error_text_container").fadeIn();
						$(div_container).find(".successfully_text_container,.email_error").fadeOut();
						$(window).scrollTo( $(div_container).find(".error_text_container"), 400,{'offset':{'top':-(offset)}});
						$("#booking_calendar_main_container_"+id+" ."+item).each(function(){
							$(this).removeClass(""+selected);
						});
						remove_select_data(id);
						exist = false;
					}
					else {
						$(div_container).find(".error_text_container,.successfully_text_container").fadeOut(10);
						var av_min = $("#booking_calendar_main_container_"+id+" ."+selected).eq(0).data("available");
						for(var i = 1; i < selected_count; i++) {
							if($("#booking_calendar_main_container_"+id+" ."+selected).eq(i).data("available") < av_min && $("#booking_calendar_main_container_"+id+" ."+selected).eq(i).hasClass(available)) {
								av_min = $("#booking_calendar_main_container_"+id+" ."+selected).eq(i).data("available");
							}
						}
						
						$("#wpdevart_count_item"+id+" option").remove();
						for(var j = 1; j <= av_min; j++){
							$("#wpdevart_count_item"+id).append("<option value='"+j+"'>"+j+"</option>");
						}
						if(ajax_next == "") {
							if(start_index >= $("#booking_calendar_main_container_"+id+" ."+item).index(el)){
								check_indateformat = $(el).data("dateformat");
								check_outdateformat = selected_dateformat
							}
							else {
								check_indateformat = selected_dateformat;
								check_outdateformat = $(el).data("dateformat");
							}
						} else if(ajax_next == "next"){
							if(select_index) {
								if(select_index >= $("#booking_calendar_main_container_"+id+" ."+item).index(el)){
									check_indateformat = $(el).data("dateformat");
									check_outdateformat = selected_dateformat
								}
								else {
									check_indateformat = selected_dateformat;
									check_outdateformat = $(el).data("dateformat");
								}
							} else {
								check_indateformat = selected_dateformat;
								check_outdateformat = $(el).data("dateformat");
							}
						} else if(ajax_next == "prev"){
							if(select_index) {
								if(select_index >= $("#booking_calendar_main_container_"+id+" ."+item).index(el)){
									check_indateformat = $(el).data("dateformat");
									check_outdateformat = selected_dateformat
								}
								else {
									check_indateformat = selected_dateformat;
									check_outdateformat = $(el).data("dateformat");
								}
							} else {
								check_indateformat = $(el).data("dateformat");
								check_outdateformat = selected_dateformat;
							}	
						}
						$(for_hidden).val(check_indateformat);
						$(for_hidden_end).val(check_outdateformat);
						$("#wpdevart-submit" + id).show();
						$("#wpdevart_booking_form_" + id).show();
						if($(div_container).hasClass("hours_enabled") && hour == true) {
							reservation_info(el,price,price_div,total_div,extra_div,currency,id,extra_price_value,check_indateformat,check_outdateformat,item_count,false,selected_av_count,pos,selected);
						    $(window).scrollTo( $(form_container), 400,{'offset':{'top':-(offset)}});
						} else {
							$.get(wpdevart.ajaxUrl, {
								action: 'wpdevart_ajax_get_interval_dates',
								wpdevart_start_date: check_indateformat,
								wpdevart_end_date: check_outdateformat,
								wpdevart_id: calendar_idd,
								wpdevart_nonce: wpdevart.ajaxNonce
							}, function (data) {
								date_data = JSON.parse(data);
								if(date_data == 0){
									$(div_container).find(".error_text_container").fadeIn();
									$(div_container).find(".successfully_text_container,.email_error").fadeOut();
									$(window).scrollTo( $(div_container).find(".error_text_container"), 400,{'offset':{'top':-(offset)}});
									$("#booking_calendar_main_container_"+id+" ."+item).each(function(){
										$(this).removeClass(""+selected);
									});
									remove_select_data(id);
									exist = false;
								} else {
									reservation_info(el,price,price_div,total_div,extra_div,currency,id,extra_price_value,check_indateformat,check_outdateformat,item_count,false,selected_av_count,pos,selected,date_data);
									$(window).scrollTo( $(form_container), 400,{'offset':{'top':-(offset)}});
								}
							});
						}
						
					}
				existtt= true;
				} else { existtt = false; }
			} else if($("#wpdevart_single_day" + id).length != 0 || (hour == true && $("#wpdevart_form_hour" + id).length != 0)) {
				if(hour == true) {
					var for_hidden_single = "#wpdevart_form_hour"+id;
				} else {
					var for_hidden_single = "#wpdevart_single_day"+id;
				}	
				$("#booking_calendar_main_container_"+id+" ."+item).each(function(){
					$(this).removeClass(selected);
				});
				if(typeof($(el).data("available")) != "undefined" || $(el).hasClass("wpdevart-unavailable")) {
					$(el).addClass(selected);
					$(for_hidden_single).val($(el).data("dateformat"));
					$(div_container).find(".error_text_container,.successfully_text_container").fadeOut(10);
					$("#wpdevart_count_item"+id+" option").remove();
					if($(div_container).hasClass("hours_enabled") && hour == false) {
						$(div_container).find('.wpdevart-hours-container').show();
						$(div_container).find('.wpdevart-hours-overlay').show();
						$.post(wpdevart.ajaxUrl, {
							action: 'wpdevart_ajax',
							wpdevart_selected_date: $(el).data("date"),
							wpdevart_hours: true,
							wpdevart_id: $(div_container).data('id'),
							wpdevart_nonce: wpdevart.ajaxNonce
						}, function (data) {
							$(div_container).find('div.wpdevart-hours').replaceWith(data);
							$(div_container).find('.wpdevart-hours-overlay').hide();


$('.wpdevart-hour-item:first').trigger('click');
						});
					} else {
						for(var j = 1; j <= ($(el).data("available")); j++){
							$("#wpdevart_count_item"+id).append("<option value='"+j+"'>"+j+"</option>");
						}
						$("#wpdevart-submit" + id).show();
						$("#wpdevart_booking_form_" + id).show();
						if($(div_container).hasClass("hours_enabled") && hour == true) {
							reservation_info(el,price,price_div,total_div,extra_div,currency,id,extra_price_value,check_in,check_out,item_count,$(el).data("dateformat"),1,pos,selected,date_data);

						} else {
							$.get(wpdevart.ajaxUrl, {
								action: 'wpdevart_ajax_get_interval_dates',
								wpdevart_start_date: $(el).data("dateformat"),
								wpdevart_end_date: $(el).data("dateformat"),
								wpdevart_id: calendar_idd,
								wpdevart_nonce: wpdevart.ajaxNonce
							}, function (data) {
								date_data = JSON.parse(data);
								if(date_data == 0){
									$(div_container).find(".error_text_container").fadeIn();
									$(window).scrollTo( $(div_container).find(".error_text_container"), 400,{'offset':{'top':-(offset)}});
									$(form_container).find(for_hidden_single).val("");
									exist = false;
								} else {
									reservation_info(el,price,price_div,total_div,extra_div,currency,id,extra_price_value,check_in,check_out,item_count,$(el).data("dateformat"),1,pos,selected,date_data);
									$(window).scrollTo( $(form_container), 400,{'offset':{'top':-(offset)}});
								}
							});
						}
						
					}
				} else {
					$(div_container).find(".error_text_container").fadeIn();
					$(window).scrollTo( $(div_container).find(".error_text_container"), 400,{'offset':{'top':-(offset)}});
					$(form_container).find(for_hidden_single).val("");
				}
			}
		}
		
		
		
		$(document).on("click", ".notice_text_close",function() {
			$(this).parent().fadeOut(10);
		});
		$(function() {
			$( ".datepicker" ).datepicker({
			  dateFormat: "yy-mm-dd"
			});
		});
$(document).find('.wpdevart-available:first').trigger('click');

		wpdevart_responsive();
			
		$('.wpdevart-day-hours').on("click",function(event){
			event.stopPropagation();
		});
	}

	wpdevartScriptOb = new wpdevartScript();	
});
jQuery( document ).ajaxComplete(function() {
	wpdevart_responsive();
});
function remove_select_data(id) {
	jQuery("#wpdevart_form_checkin"+id).val('');
	jQuery("#wpdevart_form_checkout"+id).val('');
	jQuery("#wpdevart-submit"+id).hide();
	jQuery("check-info-"+id).html(jQuery("check-info-"+id).data("content"));
}

function wpdevart_set_value(id,value) {
	jQuery("#"+id).val(value);
}

function change_count(el,id,pos,currency) {
	var price = 0,
		old_price = 0,
		total_price = 0,
		extra_price_value = 0,
		extraprice = 0,
		old_total = 0,
		form_container = jQuery(el).closest(".wpdevart-booking-form");
	if(jQuery(form_container).find(".price").length != 0) {
		old_price = parseFloat(jQuery(form_container).find(".price").data("price"));
		price = parseFloat(jQuery(form_container).find(".price span").html());
		total_price = old_price*(jQuery(el).val());
		old_total = parseFloat(jQuery(form_container).find(".total_price span").html());
		if(jQuery(form_container).find(".wpdevart-extra-info").length != 0) {
			jQuery(form_container).find(".wpdevart-extra-info").each(function(){
				if(jQuery(this).find("span:first-child").html() != "") {
					if(jQuery(this).find("input.extra_price_value").val() != "") {
						operation = jQuery(this).find(".extra_price").data("extraop");
						extraprice = jQuery(this).find(".extra_price").data("extraprice");
						if( jQuery(this).find(".extra_percent").length != 0 && jQuery(this).find(".extra_percent").is(":visible")) {
							jQuery(this).find("input.extra_price_value").val(operation+(extraprice*(old_price*(jQuery(el).val()))/100));
							jQuery(this).find("span.extra_price_value").html(operation+(pos=="before" ? currency : "")+(extraprice*(old_price*(jQuery(el).val()))/100)+(pos=="after" ? currency : ""));
							extra_price_value += operation + (extraprice*(old_price*(jQuery(el).val()))/100);
							total_price = (operation == "+")? (total_price + (extraprice*(old_price*(jQuery(el).val()))/100)) : (total_price - (extraprice*(old_price*(jQuery(el).val()))/100));
						} else {
							jQuery(this).find("input.extra_price_value").val(operation+(extraprice*jQuery(el).val()));
							jQuery(this).find("span.extra_price_value").html(operation+(pos=="before" ? currency : "")+(extraprice*jQuery(el).val())+(pos=="after" ? currency : ""));
							total_price = (operation == "+")? (total_price + extraprice*jQuery(el).val()) : (total_price - extraprice*jQuery(el).val());
							extra_price_value += operation + (extraprice*jQuery(el).val());
						}
					}
				}
			});
		} else {
			total_price = (old_total-price)+(old_price*(jQuery(el).val()));
		}
		jQuery(form_container).find(".total_price span").html(total_price);
		jQuery(form_container).find(".price span").html(old_price*(jQuery(el).val()));
		jQuery(form_container).find(".wpdevart_extra_price_value").val(eval(extra_price_value));
		jQuery(form_container).find(".wpdevart_total_price_value").val(total_price);
		jQuery(form_container).find(".wpdevart_price_value").val(old_price*(jQuery(el).val()));
	}
	if(jQuery(form_container).find(".count_item").length != 0) {
		jQuery(form_container).find(".count_item").html(jQuery(el).val());
	}
}
function change_extra(el,pos,currency) {
	var id = jQuery(el).attr("id"),
		form_container = jQuery(el).closest(".wpdevart-booking-form-container"),
	    thisprice =  jQuery(el).find("option:selected").data("price"),
	    thisop =  jQuery(el).find("option:selected").data("operation"),
	    label =  jQuery(el).find("option:selected").data("label"),
	    thistype =  jQuery(el).find("option:selected").data("type"),
	    extraprice =  ((jQuery(form_container).find("."+id+" input.extra_price_value").val())? parseFloat(jQuery(form_container).find("."+id+" input.extra_price_value").val()) : 0),
	    extraop =  jQuery(form_container).find("."+id+" .extra_price").data("extraop"),
	    item_count =  (jQuery(form_container).find(".wpdevart_count_item").length !=0)? jQuery(form_container).find(".wpdevart_count_item").val() : 1,
	    total_price =  0,
	    extra_price_value =  0,
		total = parseFloat(jQuery(form_container).find(".total_price span").html()),
		price = parseFloat(jQuery(form_container).find(".price span").html()),
	 	new_total = (extraop == "+") ? (total - Math.abs(extraprice)) : (total + Math.abs(extraprice)),
	    forNight = jQuery(el).closest(".booking_calendar_main_container").data("night");
	if(jQuery(form_container).closest(".booking_calendar_main_container").hasClass("hours_enabled")) {	
	 	selected_count = jQuery(form_container).prev().find(".wpdevart-hour-available.hour_selected").length;
    } else {
	 	selected_count = (forNight == 1 && date_data.length > 1) ? (date_data.length - 1) : date_data.length;
	}
	if(jQuery(form_container).find("."+id).length != 0) {
		jQuery(form_container).find("."+id+" .extra_price").data("extraop", thisop);
		jQuery(form_container).find("."+id+" .option_label").html(label);
		if(thisprice) {
			if(jQuery(el).hasClass("wpdevart-independent")) {
				var indep_price = thisprice * item_count;
			} else {
				var indep_price = thisprice * selected_count * item_count;
			}
			if(thistype == "price") {
				jQuery(form_container).find("."+id+" span.extra_price_value").html(thisop+(pos=="before" ? currency : "")+ indep_price +(pos=="after" ? currency : ""));
				jQuery(form_container).find("."+id+" input.extra_price_value").val(thisop+indep_price);
				jQuery(form_container).find("."+id+" .extra_percent").hide();
				jQuery(form_container).find("."+id+" .extra_price").show();
				if(jQuery(el).hasClass("wpdevart-independent")) {
					jQuery(form_container).find("."+id+" .extra_price").data("extraprice", thisprice);
				} else {
					jQuery(form_container).find("."+id+" .extra_price").data("extraprice", (thisprice*selected_count));
				}
				total_price = (thisop == "+")? (new_total + indep_price) : (new_total - indep_price);				
			} else {
				if(isNaN(price)) {
					var new_price = 0;
				} else {
					var new_price = (price*thisprice)/100;
				}
				jQuery(form_container).find("."+id+" span.extra_price_value").html(thisop+(pos=="before" ? currency : "")+new_price+(pos=="after" ? currency : ""));
				jQuery(form_container).find("."+id+" input.extra_price_value").val(thisop+new_price);
				jQuery(form_container).find("."+id+" .extra_percent").html(thisprice+"%").show();
				jQuery(form_container).find("."+id+" .extra_price").show();
				jQuery(form_container).find("."+id+" .extra_price").data("extraprice", thisprice);
				total_price = (thisop == "+")? (new_total + new_price) : (new_total - new_price);
			}
		} else {
			jQuery(form_container).find("."+id+" span.extra_price_value").html("");
			jQuery(form_container).find("."+id+" input.extra_price_value").val("");
			jQuery(form_container).find("."+id+" .extra_percent,."+id+" .extra_price").hide();
			total_price = new_total;
		}
		jQuery(form_container).find("input.extra_price_value").each(function(){
			extra_price_value += jQuery(this).val();
		});
		jQuery(form_container).find(".total_price span").html(total_price);
		jQuery(form_container).find(".wpdevart_total_price_value").val(total_price);	
		jQuery(form_container).find(".wpdevart_extra_price_value").val(eval(extra_price_value));
	}
	
}

function reservation_info(el,price,price_div,total_div,extra_div,currency,id,extra_price_value,check_in,check_out,item_count,single_date,selected_count,pos,selected,date_data) {
	/*Reservation info*/
	var day_info = "",
	    form_container = jQuery(el).closest(".booking_calendar_container").next(),
	    forNight = jQuery(el).closest(".booking_calendar_main_container").data("night");
	if(jQuery(form_container).closest(".booking_calendar_main_container").hasClass("hours_enabled")) {
		jQuery(el).parent().find("."+selected).each(function(index,sel_element) {
		if(jQuery(sel_element).find(".new-price").length != 0) {
			price += parseFloat(jQuery(sel_element).find(".new-price").data("price"));
		}
		currency = jQuery(sel_element).data("currency");
	});
	} else {
		selected_count = (forNight == 1 && date_data.length > 1) ? (date_data.length - 1) : date_data.length;
		var i = 0;
		jQuery.each(date_data, function (index, value) {
			i++;
			current_date = JSON.parse(value.data);
			if(forNight == 1 && date_data.length > 1){
				if(i <= date_data.length)
					price += parseFloat(current_date.price);
			} else {
				price += parseFloat(current_date.price);
			}
			currency = jQuery(el).parent().find("."+selected).data("currency");
		});
	}
	var total_price = price;
	
	if(jQuery(form_container).find(".wpdevart_count_item").length != 0) {
		item_count = "<div class='reserv_info_row'><span class='reserv_info_cell'>" +  (jQuery(form_container).find(".wpdevart_count_item").closest(".wpdevart-fild-item-container").find("label").html()) + "</span><span class='reserv_info_cell_value count_item'>1</span></div>";
	}
	if(jQuery(form_container).find(".wpdevart_extras").length != 0) {
		jQuery(form_container).find(".wpdevart_extras").each(function(sel_index,select){
			var label = jQuery(select).parent().parent().find("label").html(),
				option_label_arr = jQuery(select).find("option:selected").html().split(' '),
				option_label = option_label_arr[0],
				operation = jQuery(select).find("option:selected").data("operation"),
				type = jQuery(select).find("option:selected").data("type"),
				opt_price = parseFloat(jQuery(select).find("option:selected").data("price"));
				if(jQuery(this).hasClass("wpdevart-independent")) {
					var indep_price = opt_price;
				} else {
					var indep_price = opt_price * selected_count;
				}
			if(type == "price") {
				if(opt_price != 0 || opt_price != "") {
					var option_info = "<span class='extra_percent' style='display:none;'></span><span class='extra_price' data-extraprice='"+(indep_price)+"' data-extraop='"+operation+"' style='display:inline-block;'><span class='extra_price_value'>"+operation+((pos == "before") ? currency : "")+(indep_price)+((pos == "after") ? currency : "")+"</span></span><input type='hidden' class='extra_price_value' value='"+operation+(indep_price)+"'>";
				} else {
					var option_info = "<span class='extra_percent' style='display:none;'></span><span class='extra_price' data-extraprice='"+opt_price+"' data-extraop='"+operation+"'  style='display:none;'><span class='extra_price_value'></span></span><input type='hidden' class='extra_price_value' value=''>";
				}
				total_price = (operation == "+")? (total_price + indep_price) : (total_price - indep_price);
				extra_price_value += operation+indep_price;
			} else {
				if(opt_price != 0 || opt_price != "") {
					var option_info = "<span class='extra_percent'>"+operation+opt_price+"%</span><span class='extra_price' data-extraprice='"+opt_price+"' data-extraop='"+operation+"'  style='display:inline-block;'><span class='extra_price_value'>"+operation+((pos == "before") ? currency : "")+((price * opt_price)/100)+((pos == "after") ? currency : "")+"</span></span><input type='hidden' class='extra_price_value' value='"+operation+((price * opt_price)/100)+"'>";
				} else {
					var option_info = "<span class='extra_percent'></span><span class='extra_price' data-extraprice='"+opt_price+"' data-extraop='"+operation+"'  style='display:none;'><span class='extra_price_value'></span></span><input type='hidden' class='extra_price_value' value=''>";
				}
				total_price = (operation == "+")? (total_price + ((price * opt_price)/100)) : (total_price - ((price * opt_price)/100));
				extra_price_value += operation+((price * opt_price)/100);
			}
			extra_div += "<div class='wpdevart-extra-info wpdevart-extra-"+sel_index+" reserv_info_row "+(jQuery(select).attr("id"))+"'><span class='reserv_info_cell'>"+label+"</span><span class='reserv_info_cell_value'><span class='option_label'>"+option_label+"</span>"+option_info+"</span></div>";
			
		});
	}
	if(!isNaN(price)) {
		price_div = "<div class='reserv_info_row no-display'><span class='reserv_info_cell'>"+(jQuery(el).closest(".booking_calendar_main_container").data("price"))+"</span><span class='reserv_info_cell_value price' data-price='"+price+"'>"+((pos == "before") ? currency : "")+"<span>"+price+"</span>"+((pos == "after") ? currency : "")+"</span></div>";
		total_div = "<div class='wpdevart-total-price reserv_info_row no-display'><span class='reserv_info_cell'>"+(jQuery(el).closest(".booking_calendar_main_container").data("total"))+"</span><span class='reserv_info_cell_value total_price'>"+((pos == "before") ? currency : "")+"<span>"+total_price+"</span>"+((pos == "after") ? currency : "")+"</span></div>";
	}
	if(single_date === false) {
		if(jQuery(form_container).closest(".booking_calendar_main_container").hasClass("hours_enabled")) {
			day_info = "<div class='reserv_info_row'><span class='reserv_info_cell'>" + wpdevart.date + "</span><span class='reserv_info_cell_value'>"+jQuery(form_container).closest(".booking_calendar_main_container").find(".selected").data("dateformat")+"</span></div>";
		}		
		jQuery(form_container).find(".check-info").html(day_info + "<div class='reserv_info_row'><span class='reserv_info_cell'>" + jQuery(form_container).find("label.wpdevart_form_checkin").html() + "</span><span class='reserv_info_cell_value'>"+check_in+"</span></div><div class='reserv_info_row'><span class='reserv_info_cell'>" + jQuery(form_container).find("label.wpdevart_form_checkout").html() + "</span><span class='reserv_info_cell_value'>"+check_out+"</span></div>"+item_count+price_div+extra_div+total_div+"");
	} else {
		if(jQuery(form_container).closest(".booking_calendar_main_container").hasClass("hours_enabled")) {
			jQuery(form_container).find(".check-info").html("<div class='reserv_info_row'><span class='reserv_info_cell'>" + wpdevart.date + "</span><span class='reserv_info_cell_value'>"+jQuery(form_container).closest(".booking_calendar_main_container").find(".selected").data("dateformat")+"</span></div><div class='reserv_info_row'><span 	class='reserv_info_cell'>" + wpdevart.hour + "</span><span class='reserv_info_cell_value'>"+single_date+"</span></div>"+item_count+price_div+extra_div+total_div);
		} else {
			jQuery(form_container).find(".check-info").html("<div class='reserv_info_row'><span 	class='reserv_info_cell'>" + wpdevart.date + "</span><span class='reserv_info_cell_value'>"+single_date+"</span></div>"+item_count+price_div+extra_div+total_div);
		}
	}
	jQuery(form_container).find(".wpdevart_extra_price_value").val(eval(extra_price_value));
	jQuery(form_container).find(".wpdevart_total_price_value").val(total_price);
	jQuery(form_container).find(".wpdevart_price_value").val(price);
	jQuery(form_container).find(".wpdevart_day_count").val(selected_count);
}

function wpdevart_responsive(){
	jQuery(".booking_calendar_main_container").each(function(index,el){
		if(jQuery(el).width() < 450 || jQuery("body").width() < 470) {
			jQuery(el).addClass("wpdevart-responsive");
			jQuery(el).next().addClass("wpdevart-responsive");
		}else {
			jQuery(el).find(".wpda-month-name").show();
		}
	});
}

function wpdevart_required(submit) {
	var label = "",
		tag_name = "",
		type = "",
		error = false,
		error_email = false,
		offset = jQuery(submit).closest(".booking_calendar_main_container").data("offset");
	if(jQuery(submit).closest("form").find(".wpdevart-required:not(span)").length != 0 || jQuery(submit).closest("form").find(".wpdevart-email").length != 0) {
		jQuery(submit).closest("form").find(".wpdevart-required:not(span),.wpdevart-email").each(function(index,el){
			label = jQuery(el).closest(".wpdevart-fild-item-container").find("label").text();
			tag_name = jQuery(el).prop("tagName");
			type = jQuery(el).attr("type");
			if(tag_name == "INPUT") {
				if(type == "text") {
					if(jQuery(el).val().trim() == "" && !jQuery(el).hasClass("wpdevart-email")) {
						error = true;
					}
					if(jQuery(el).hasClass("wpdevart-email") && validate_email(jQuery(el).val())) {
						if(jQuery(el).val().trim() == "" && jQuery(el).hasClass("wpdevart-required")) {
							error = true;
						}
						if(jQuery(el).val() != "" && !jQuery(el).hasClass("wpdevart-required")){
							error_email = true;
						}else if(jQuery(el).hasClass("wpdevart-required")) {
							error_email = true;
						}
					}
				} else if(type == "checkbox" || type == "radio") {
					if(typeof jQuery(el).attr("checked") == "undefined") {
						error = true;
					} 
				}
			} else if(tag_name == "SELECT") {
				if(jQuery(el).find("option:selected").val() == "") {
					error = true;
				}
			} else if(tag_name == "TEXTAREA") {
				if(jQuery(el).val().trim() == "") {
					error = true;
				}
			}
			if(error === true) {
				alert(label + ": " + wpdevart.required);
				jQuery(el).focus();
				jQuery(window).scrollTo( jQuery(el), 400,{'offset':{'top':-(offset)}});
				return false;
			} else if(error_email === true) {
				alert(wpdevart.emailValid);
				jQuery(el).focus();
				jQuery(window).scrollTo( jQuery(el), 400,{'offset':{'top':-(offset)}});
				return false;
			} 
		});
	}
	if(error === true || error_email === true) {
		return false;
	} else {
		return true;
	}	
}

function validate_email(email) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(email)) {
		return true;
	} else {
		return false;
	}	
}