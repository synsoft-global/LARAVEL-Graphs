/*call function on change of filter button at customer list*/

$(".select_custom_hide_selected").select2({		      
  minimumResultsForSearch: Infinity,
  theme: 'default select_custom_hide_selected',
  allowClear: false,  
});

		
function show_success_msg(msg){	
	$('#success-msg-alert').find('.alert-success').find('.msg').html(msg);	
	$('#success-msg-alert').find('.alert-success').show();
	setTimeout(function(){		
		$('.hide_alert').hide();
		$('#success-msg-alert').find('.alert-success').find('.msg').html('');	
	}, 3000);
}

function show_error_msg(msg){	


	$('#success-msg-alert').find('.alert-danger').find('.msg').html(msg);	
	$('#success-msg-alert').find('.alert-danger').show();
	setTimeout(function(){	
		$('.hide_alert').hide();
		$('#success-msg-alert').find('.alert-danger').find('.msg').html('');	
	}, 3000);
}


function show_warning_msg(msg){		

	$('#success-msg-alert').find('.alert-warning').find('.msg').html(msg);	
	$('#success-msg-alert').find('.alert-warning').show();
	setTimeout(function(){		
		$('.hide_alert').hide();
		$('#success-msg-alert').find('.alert-warning').find('.msg').html('');	
	}, 3000);
}


/*Edit export list's segment filter*/
$(document).ready(function(){
	const urlParams = new URLSearchParams(window.location.search);
	const myParam = urlParams.get('e_id');
	var url_module =$('#segment_filter').attr('data-resource');	
	//const myParam1 = urlParams.split('/')[1];
	if(myParam){

		let $id = myParam;
		$.ajax({
			url:site_url+'/edit_export/'+$id+'?url_module='+url_module,
			type:'get',
			success:function(data){
				if(data.status == 1){
					$('#append_popup').html(data.html);
					$('#delete_rec').val('2');
					$('.include_meta').trigger('change');
					$('.delimiter').trigger('change');
					$('.customise_columns').trigger('change');
					var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
					array = [];
					if($('input[name="email_tags[]"]').val()!=''){
						$('input[name="email_tags[]"]').map(function(){

							if($(this).val() != '' ){
								if(reg.test($(this).val()) == true){
									var valExist = $.inArray($(this).val(), array);
									if (valExist == -1) {
									  array.push($(this).val());
									} 
								}else{
									$(this).val('').addClass('error is-invalid');

									$("#email_tags_validation").empty().html('<div for="export_name" class="error" style="">'+msg_email_is_invalid+'</div>');
								}
							}
						}).get();
					}

					$(".select_custom_hide_selected").select2({		      
					    minimumResultsForSearch: Infinity,
					    allowClear: false,
				  	});
					console.log(array);
					$('#recurring_export').html(msg_save_changes);
					$('#show_rec_modal').html('<i class="fa fa-clock-o mr-2" aria-hidden="true"></i>'+msg_update_a_recurring_automatic_export);
					$('.showCustomerCount').html(msg_edit_exports);
				}else{
					show_error_msg(msg_no_data_found);
					setTimeout(function(){
						window.location.replace(data.redirect);
					}, 2000);
				}
			},error:function(e){
				console.log(e);
			}
		})
	}
});

$('#row_per_item').click(function(){
	if($('#row_per_item').is(":checked") == true){
		$('.show_line_col').show();
	}else{
		$('.show_line_col').hide();
	}
})

$("document").ready(function(){
    setTimeout(function(){
      $('.hide_alert').hide();
    }, 3000 ); // 3 secs

}); 
