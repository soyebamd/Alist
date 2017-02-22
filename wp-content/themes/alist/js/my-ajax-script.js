/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($) {
    $("i.fa.fa-shopping-cart").click(function (e) {
        e.preventDefault();
        $.ajax({
		url: my_ajax_object.ajax_url,
		data: {
			'action':'example_ajax_request'
		},
		success:function(data) {
                        window.location.href = data;
		},
		error: function(errorThrown){
		    console.log(errorThrown);
		}
	});
    });	  
});