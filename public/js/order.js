/***********Order Module js code starts***************/



function addLoadingC(flag=true){
	if(flag){
		$('.order-result').addClass('customer-js-loading');
		//$('#show_filters').addClass('customer-js-loading');
		$('#orderTable').addClass('customer-js-loading');
	}else{
		$('.order-result').removeClass('customer-js-loading');
		//$('#show_filters').removeClass('customer-js-loading');
		$('#orderTable').removeClass('customer-js-loading');
	}
	
}


var OrdersearchStart='';
var xhr='';
var ajax_inprocess = false;
/*filter order list*/

function filterdata(orderbyVal='', whereVal='', limit='',segments=[],page=1,gridview='default'){	
	window.clearTimeout(OrdersearchStart);
	 OrdersearchStart = window.setTimeout(function () { 
	 		addLoadingC();
	 		if (ajax_inprocess == true)
			{
			    xhr.abort();
			}
	 		if(gridview=='default'){	 			
	 			gridview = window.matchMedia("only screen and (max-width: 767px)").matches;
	 			if(gridview){
	 				$(".customer_grid_view").removeClass("active");
					$(".customer_list_view").removeClass("active");
					$(".customer_grid_view").addClass("active");
	 			}else{
	 				$(".customer_grid_view").removeClass("active");
					$(".customer_list_view").removeClass("active");					
	 			}
	 		}
	 		
	 		var orderby ='';
			if($('#up').hasClass('fa-arrow-down')){
				orderby = 'desc';
			}else{
				orderby = 'asc';
			}
			segments=[];
			var $currentWrap = $('.customer-body-area' );
		    var count = $currentWrap.find(".filter-container:last").data('rowid')  || 0;
		    $currentWrap.find(".filter-container").each(function () {
		    	let column = $(this).find('.customer_segment_select').find(':selected').data('column');
		    	let method = $(this).find('.customer_segment_select').find(':selected').data('method');
			    segments.push(
			    	{
			    		filter:$(this).find(".customer_segment_select").val(),
			    		column:column,
			    		method:method,
			    		option:$(this).find(".customer_option_dropdown").val(),
			    		from:$(this).find(".customer_option_dropdown_input:eq(0)").val(),
			    		to:$(this).find(".customer_option_dropdown_input:eq(1)").val()
			    		},
		    	)
			});			

			let whereVal = $('#search_customer').val();

			if(!!whereVal){
				segments=[];
			}
			let limit = $('#changelimit').val();
			let order_filter_type=$("#filter_type").val();			
			let orderbyVal = $('#orderby').val();	
			$('[data-toggle=popover]').popover('hide');	
			$('.ajaxcustomerview').popover('hide');	
			$('[data-toggle=tooltip]').tooltip('hide');	
			ajax_inprocess = true;
			xhr=$.ajax({
				url:site_url+'/getPaginatedOrder',
				type:'post',
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
				data:{
					orderbyVal:orderbyVal, 
					orderby:orderby,
					whereVal:whereVal,
				 	limit:limit, 
				 	gridview:gridview, 				 	
				 	segments:segments,
				 	page:page,
				 	order_filter_type:order_filter_type
				},
				success:function(data){
					$(".order_status_change").hide();	
					let text='order';
					if(data.total>1){
						text='orders';
						$('#export_btn').html('Export '+data.total+' orders');
						if(data.total>exp_total_limit){
							$('#exportCustomer').attr('disabled', true);
						}else{
							$('#exportCustomer').attr('disabled', false);
						}
					}else{
						$('#exportCustomer').attr('disabled', false);
						$('#export_btn').html('Export');
					}
					$('[data-toggle="popover"]').popover(); 
					if($('.show_rec_export_tab').is(":hidden") == true && $("#modal-settings-notifications").is(":hidden") == true){
						$('.showCustomerCount').html('<strong>Export</strong> '+data.total+' '+text+'<i class="fa fa-info-circle mx-3" aria-hidden="true"></i>');	
					}		
					$('#orderTable').empty();
					$('#orderTable').html(data.html);
					$('.order-result').html(data.result);					
					console.log(data.first_row);
					$('.ajaxcustomerview').popover({
						container: '.order-custom-container'
					}); 			  
					$('[data-toggle="popover"]').popover(); 						
					$('[data-toggle="tooltip"]').tooltip(); 						
					$(".select_custom").select2({		      
				      minimumResultsForSearch: Infinity,
				      allowClear: false,
				      
				  });
					addLoadingC(false);
					ajax_inprocess = false;
				},error:function(e){
					addLoadingC(false);	
					if(e.statusText!="abort"){
						show_error_msg(msg_something_went_wrong);
					}
				}
			})	
 	}, 1000);

}

/*Export order page rows */


$(document).on('change', "#order_status_edit_change", function(){	
	$('#modal-update-order').modal('show');		
	
	$('#modal-order-status').html($(this).find('option:selected').text());	
	$('#modal-order-orig').html($(this).find('[value="'+$(this).data('original')+'"]').text());		

});



$(document).on('click', "#update_order_btn", function(){	
	let order_status= $("#order_status_edit_change").val();
	let order_id= $("#order_status_edit_change").data('orderid');
	let self=this;
	$(self).attr('disabled','disabled');
	$(self).addClass('is-loading');	
	$('#order_status_edit_change').attr('disabled','disabled');		
	$.ajax({
        url:site_url+"/order/update_order_status",
        type:"post",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
		data:{order_status:order_status,order_id:order_id},
        success: function(data){		            
              
          if(data.status){
          	show_success_msg(data.msg);
          	$("#order_status_edit_change").data('original',order_status);
          	$('#modal-update-order').modal('hide');	              	
          	addOrderDetail(order_id);

          }else{
          	show_error_msg(data.msg);
          	$('#modal-update-order').modal('hide');		
          }
          $('#order_status_edit_change').removeAttr('disabled');  
          $(self).removeAttr('disabled');
		  $(self).removeClass('is-loading');	            
 		},
	    error: function(data){
	       show_error_msg(msg_something_went_wrong);
	       $('#modal-update-order').modal('hide');	
	       $('#order_status_edit_change').removeAttr('disabled');
	       $(self).removeAttr('disabled');
		   $(self).removeClass('is-loading');
	    }
    });
	

});

function addOrderDetail(order_id){
	$('#order_detail_view').hide();	
  	$('.loading-order-detail').show();	
	$.ajax({
	        url:site_url+"/order/get_order_detail",
	        type:"post",
	        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{order_id:order_id},
	        success: function(data){  	              
	          if(data.status){	          	
	          	$('#order_detail_view').html(data.html);	
	          	 $("img.lazy").lazyload();
	          }

		        $('#order_detail_view').show();	
				$('.loading-order-detail').hide();	            
	  		},
		    error: function(data){
		       show_error_msg(msg_something_went_wrong);
		       	$('#order_detail_view').html('');	
		        $('#order_detail_view').show();	
				$('.loading-order-detail').hide();
		    }
	});
}

$(document).on('click', ".checkall", function(){
	if($(this).is(':checked')){
		$(".checkedOrder").prop('checked',true);	
		$(".order_status_change").show();			
	}else{
		$(".checkedOrder").prop('checked',false);
		$(".order_status_change").hide();	

			
	}
	
});

$('#modal-update-order').on('hidden.bs.modal', function () {
   $("#order_status_change").val('').trigger('change');  
});

$(document).on('click', ".checkedOrder", function(){
	let orders_row=$(".orders_row").length;
	let checkedOrder=$(".checkedOrder:checked").length;	
	if(orders_row==checkedOrder){
		$(".checkall").prop('checked',true);				
	}else{
		$(".checkall").prop('checked',false);				
	}
	$(".order_status_change").hide();	
	if(checkedOrder > 0){
		$(".order_status_change").show();
	}
	
});

$(document).on('change', "#order_status_change", function(){
	let checkedOrder=$(".checkedOrder:checked").length;	
	let order_status_change=$("#order_status_change").val();
	if(order_status_change!='' && checkedOrder > 0){
		$('#modal-update-order').modal('show');
		$('#modal-order-num').html(checkedOrder);
		if(checkedOrder > 1){
			$('#modal-order-text').html('s');
		}else{
			$('#modal-order-text').html('');
		}
		$('#modal-order-status').html($(this).find('option:selected').text());	
	}
	
	
});

$(document).on('click', "#update_orders_list_btn", function(){	
	let order_status= $("#order_status_change").val();
	let orderIDs= [];
	$(".checkedOrder:checked").each(function(){
		orderIDs.push($(this).data('id'));
	});
	let self=this;
	$(self).attr('disabled','disabled');
	$(self).addClass('is-loading');	
	
	$('#order_status_edit_change').attr('disabled','disabled');		
		$.ajax({
            url:site_url+"/order/update_order_status_bulk",
            type:"post",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{order_status:order_status,orderIDs:orderIDs},
            success: function(data){		            
	              $('#order_status_edit_change').removeAttr('disabled');	           
	              if(data.status){
	              	show_success_msg(data.msg);
	              	$("#order_status_edit_change").data('original',order_status);
	              	
	              }else{
	              	show_error_msg(data.msg);
	              	
	              }
	              $('#modal-update-order').modal('hide');		
	              $(self).removeAttr('disabled');
	              $(self).removeClass('is-loading');	
	              $(".checkedOrder").prop('checked',false);
				  $(".order_status_change").hide();	
				
				  var href = $(".pagination").find('.active').find('.page-link').html();					 
				 
				  $('html, body').animate({
				        scrollTop: $("#customer_export_grid").offset().top
				   }, "slow");

				  filterdata('','', '','',href);
	            
	      	},
		    error: function(data){
		       	show_error_msg(msg_something_went_wrong);
	        	$('#modal-update-order').modal('hide');		
	            $(self).removeAttr('disabled');
	              $(self).removeClass('is-loading');	
	            $(".loading-order").hide();
	            $(".checkedOrder").prop('checked',false);
				$(".order_status_change").hide();	
		    }
	    });
	

});

$('#customer_private_note').validate({
	errorClass: "is-invalid",
	rules:{
		'name':{
			required:true,
			maxlength:200
		},	

		
	},
	messages: {
		name: {
            required: "Please enter a note",
           // maxlength: jQuery.format("Enter at least {0} characters")           
        }       
      
    },
	submitHandler:function(event){			
	   $('#private_note_update_submit').attr('disabled','disabled');
	   $('#private_note_update_submit').addClass('is-loading');
		$.ajax({
	            url:site_url+"/order/update_order_note",
	            type:"post",
	            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
				data:$("#customer_private_note").serialize(),
	            success: function(data){		            
	              $('#private_note_update_submit').removeAttr('disabled');
	              $('#private_note_update_submit').removeClass('is-loading');
	              $('#private_note_list').html(data.html);	       	             
	              $("#customer_private_note").find("#name").val('');
	              $("#customer_private_note").find("#note_type").val('private');
	              $(".order-chat-note-description").hide();
	              if(data.status){
	              	show_success_msg(data.msg);	              	
              		 $(".date_from_now_order").each(function(){
				      let date = $(this).data('date');      
				      $(this).html(moment(date).fromNow());     
				      $(this).data('content',moment(date).calendar(null,{
				        sameElse: 'LL [at] LT'
				      }));     
				   });
              		 $('[data-toggle="popover"]').popover(); 
	              }else{
	              	show_error_msg(data.msg);
	              }
	      },error:function(e){
				$('#private_note_update_submit').removeAttr('disabled');
                $('#private_note_update_submit').removeClass('is-loading');
                show_error_msg(msg_something_went_wrong);
			}
	    });
	   return false;		
	}
});







/*Export order page rows */
/*$(document).on('click', ".export", function(){
	$('.export').addClass('is-loading');
	var email = $(this).attr('data-email');	
	var order_segment = $(this).attr('data-order_segment');	
	var msg = '';

	if(email == 0){
		var orderbyOrder ='';
			if($('#up').hasClass('ua-icon-arrow-down')){
				orderbyOrder = 'desc';
			}else{
				orderbyOrder = 'asc';
			}
			segments=[];
			var $currentWrap = $('.order-body-area' );
		    var count = $currentWrap.find(".filter-container").length;
		    $currentWrap.find(".filter-container").each(function () {
		    	let column = $(this).find('.order_segment_select').find(':selected').data('column');
			    let method = $(this).find('.order_segment_select').find(':selected').data('method');
			    segments.push(
			    	{
			    		filter:$(this).find(".order_segment_select").val(),
			    		column:column,
			    		method:method,
			    		option:$(this).find(".order_option_dropdown").val(),
			    		from:$(this).find(".order_option_dropdown_input:first").first().val(),
			    		to:$(this).find(".order_option_dropdown_input:last").last().val()
			    		},
		    	)
			});


			whereValOrder = $('#search_order').val();
			if(whereValOrder!=''){
				segments=[];
			}
			limit = $('#changelimit').val();
			orderbyValOrder = $('#orderbyOrder').val();

		$.ajax({			
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf_token"').attr('content')},
			url:site_url+'/downloadExcelOrder',
			type:'post',
			data:{
					orderbyValOrder:orderbyValOrder, 
					orderbyOrder:orderbyOrder, 
					whereValOrder:whereValOrder, 
					limit:limit, 
					segments:segments,
					data:'text/csv;charset=utf-8',
				},
			success:function(data){
				console.log(data);
				var str = data;
				var uri = 'data:text/csv;charset=utf-8,' + str;

				var downloadLink = document.createElement("a");
				downloadLink.href = uri;
				downloadLink.download = "data.csv";

				document.body.appendChild(downloadLink);
				downloadLink.click();
				document.body.removeChild(downloadLink);
				
				if(data==true){
					msg = '<div class="btn btn-block btn-block btn-enabled">Export will be generated and emailed to gmail as soon as it\'s ready</div>';
				}else{
					msg = '<div class="btn btn-block btn-block btn-disabled">Mail could not be saved.</div>';
				}
				  //var url = "{{URL::to('downloadExcel_location_details')}}?" + $.param(query)

   				//window.location = site_url+'/downloadExcel';
				show_exp_msg(msg);
			},error:function(e){
				msg = '<div class="btn btn-block btn-block btn-disabled">Mail could not be saved.</div>';
				show_exp_msg(msg);
			}
		})


		//$('.export').attr('href', site_url+'/downloadExcel');
		//msg = '<div class="btn btn-block btn-block btn-enabled">Your download has started.....</div>';	
		//show_exp_msg(msg);
	}else if(email == 'order-segment'){
		$('.export').attr('href', site_url+'/downloadOrderSegmentExcel');
		msg = '<div class="btn btn-block btn-block btn-enabled">Your download has started.....</div>';	
		show_exp_msg(msg);
	}else{
		$.ajax({			
			url:site_url+'/export_mail',
			type:'get',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf_token"').attr('content')},
			success:function(data){
				if(data==true){
					msg = '<div class="btn btn-block btn-block btn-enabled">Export will be generated and emailed to gmail as soon as it\'s ready</div>';
				}else{
					msg = '<div class="btn btn-block btn-block btn-disabled">Mail could not be saved.</div>';
				}
				show_exp_msg(msg);
			},error:function(e){
				msg = '<div class="btn btn-block btn-block btn-disabled">Mail could not be saved.</div>';
				show_exp_msg(msg);
			}
		})
	}
	
});*/



$(document).on('change', "#note_type", function(){
	if($(this).val() == 'for_customer'){
		$('.order-chat-note-description').show();
	}	
	else{	
	    $(".order-chat-note-description").hide();	  
	}
})






/*$('#recurring_export_form').submit(function(e) {
    e.preventDefault();
}).validate({
	rules:{
		export_name: "required",
		export_method: "required",
		email_to: {
			"required":true,
			//"email":true
		},
		freq_to: "required",
		send_on: "required",
		send_at: "required"
	},
	errorElement: "div",
    errorPlacement: function (error, element) {
        var name = $(element).attr("name");
        $('#'+name).addClass('is-invalid');
        $("#" + name + "_validation").empty();
        error.appendTo($("#" + name + "_validation"));
    },
	submitHandler:function(event){
		console.log($('#recurring_export_form :input(:hidden)').serialize());
		$.ajax({
			url:site_url+'/saverecurring',
			type:'post',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:$('#recurring_export_form :input(:hidden)').serialize()+ "&user_id="+$('input[name=user_id]').val(),
			success:function(data){
				console.log("data", data);
				if(data == 1){
					$('#recurring_export_form').hide();
					$('.export_complete').html('<div>Export Created</div>')
					setTimeout(function(){
						$('#modal-recurring_export').modal('hide');
						$('.export_complete').empty();
						$('#recurring_export_form')[0].reset();
						$('#recurring_export_form').show();
						$('.form-control').removeClass('is-invalid');
					},2000);
				}	
			},error:function(e){
				console.log(e);
			}
		})
    	return false;
	}
})

*/

/*get orders on change of datepicker*/
$(function(){
	$(document).on('change', '#order_range', function(){
		var range_picker = $(this).val();
		filterdata('','', '');

	});
})




/*$(document).on('change','#segment_filter',function(){
	var segment_filter = $(this).val();
	var segment_operator = $('#segment_operator').val();
	getFilterHtml(segment_filter, segment_operator); 
});*/
/*
$(document).on('change','.segment_operator',function(){
	var segment_filter = $('.segment_filter').val();
	var segment_operator = $(this).val(); 
	var addfilter = $(this).attr('data-filter');
	getFilterHtml(segment_filter, segment_operator, addfilter);
});*/



/*$(document).on('click','#removefilter',function(){
	$('.add').remove();
});*/
$(document).on('click','#removefilter', function(){
    $(this).closest(".add").remove();
});

$(document).on('click','#addfilter',function(){
	$('.select_filter_dropdown').show();
});
/*
$(document).on('change','.segment_filter',function(){
	//$('.select_filter_dropdown').show();
	var addfilter = $(this).attr('data-filter');
	var segment_filter = $(this).val();
	var segment_operator = $('#segment_operator').val();
	getFilterHtml(segment_filter, segment_operator,addfilter);
});

*/
function getFilterHtml(segment_filter, segment_operator, addfilter = 0){

	//var addfilter = 1;
	$.ajax({
		url:site_url+'/segments/getfilterhtml',
		type:'post',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
		data:{segment_filter:segment_filter, segment_operator:segment_operator},
		success:function(data){
			console.log("data", data);
			$('#select_filter_dropdown').hide();
			$('#choose_btn').show();
			$('#segments_btn').show();
			if(addfilter != 1){

				$('#segment_row').empty();
			}
			$('#segment_row').append(data.html);
			/*if(data == 1){
				$('#recurring_export_form').hide();
				$('.export_complete').html('<div>Export Created</div>')
				setTimeout(function(){
					$('#modal-recurring_export').modal('hide');
					$('.export_complete').empty();
					$('#recurring_export_form')[0].reset();
					$('#recurring_export_form').show();
					$('.form-control').removeClass('is-invalid');
				},2000);
			}	*/
		},error:function(e){
			console.log(e);
		}
	});
}



(function ($) {
  'use strict';

  $(document).ready(function() {    

    /*get orders on change of datepicker*/

    $(document).on('change', '#order_range', function(){
		var range_picker = $(this).val();
		filterdata('','', '');

	});

	$(document).on('click', ".order_range_view_segment", function(e){	
		$('#order_range_segment_customers').trigger('click');
	});

	$(document).on('change', '#order_range_segment_customers', function(){
		var range_picker = $(this).val();
		filterdata_customers_segment('','', '');
	});
	

  });



})(jQuery);


$(document).on('click', '#row_per_item',function(){
	if($('#row_per_item').is(":checked") == true){
		$('.show_line_col').show();
	}else{
		$('.show_line_col').hide();
	}
})

$(document).on('click', '#add_btn', function(){
	$('.add_update_order').empty().html('Add Order');
	$('#first_name').val('');
	$('#last_name').val('');
	$('#user_email').val('');
	$('#id').val('');
	$('#user_phone').val('');
	$("#user_role_id").select2({		      
			    minimumResultsForSearch: Infinity,
			    allowClear: false,
		  	});
	$('#user_role_id').val(1).trigger('change');
	$('#category_div').hide();

	$('#modal-add_user').modal('show');
});

/****************Order module js ends*********************/
