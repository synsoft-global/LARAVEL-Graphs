/***********Order Module js code starts***************/



function addLoadingC(flag=true){
	if(flag){
		$('.variation-result').addClass('customer-js-loading');
		//$('#show_filters').addClass('customer-js-loading');
		$('#variationTable').addClass('customer-js-loading');
	}else{
		$('.variation-result').removeClass('customer-js-loading');
		//$('#show_filters').removeClass('customer-js-loading');
		$('#variationTable').removeClass('customer-js-loading');
	}
	
}


var OrdersearchStart='';

/*filter order list*/

function filterdata(orderbyVal='', whereVal='', limit='',segments=[],page=1,gridview='default'){	
	window.clearTimeout(OrdersearchStart);
	 OrdersearchStart = window.setTimeout(function () { 
	 		addLoadingC();
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
			$.ajax({
				url:site_url+'/getPaginatedVariation',
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
					//console.log("data.count", data);
					if(data.total>1){
						$('#export_btn').html('Export '+data.total+' variation(s)');
						if(data.total>1000){
							$('#exportOrder').attr('disabled', true);
						}else{
							$('#exportOrder').attr('disabled', false);
						}
					}else{
						$('#export_btn').html('Export');
					}
					$('[data-toggle="popover"]').popover(); 
					$('.showOrderCount').html('Export '+data.total+' variation(s)');				
					$('#variationTable').empty();
					$('#variationTable').html(data.html);
					$('.variation-result').html(data.result);
					$(".select_custom").select2({		      
				      minimumResultsForSearch: Infinity,
				      allowClear: false,
				      
				  });
					addLoadingC(false);
				},error:function(e){
					console.log(e);
				}
			})	
 	}, 1000);

}



/*trigger function on search keyup*/

function show_exp_msg(msg){
	$('#modal-export').modal('hide');
	$('.export').removeClass('is-loading');
	$('.export_order_segment').removeClass('is-loading');
	$('.export_msg').html(msg);
	$('#modal-msg').modal('show');
	setTimeout(function(){
		$('#modal-msg').modal('hide');
	}, 3000);
}


/*Export order page rows */
$(document).on('click', ".export", function(){
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
					/*page:page*/
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
	
});



/*show or hide recurring and export modal*/
$(document).on('click', "#close_rec_modal", function(){
	$('#modal-recurring_export').modal('hide');
	$('#modal-export').modal('show');
});

$(document).on('click', "#show_rec_modal", function(){
	$('#modal-recurring_export').modal('show');
	$('#modal-export').modal('hide');
});

/*show or hide weekday's dropdown on change of daily|weekly|monthly frequency*/ 
$(document).on('change', "#freq_to", function(){
	if($(this).val() == 'daily'){
		$('#weekdays').hide();
	}
	else if($(this).val() == 'monthly'){
		$('#weekdays').show();
	    $(".hideday").hide();
	    $(".hidedates").show();
	}
	else{
		$('#weekdays').show();
	    $(".hideday").show();
	    $(".hidedates").hide();
	}
})




$('#recurring_export_form').submit(function(e) {
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
					$('.export_complete').html('<div>'+msg_export_created+'</div>')
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


$(document).on('click', '#hidetext, #hidetext1', function(){
	$('.text').hide();
	$('.selectbox').show();
});	



$(document).on('change', '.include_meta, .delimiter, .customise_columns', function(){
	var customise_columns = $('.customise_columns').val();//$('[name="customise_columns"]').val();
	var columns = ''; 
	if (customise_columns!==null) {
		columns = customise_columns.join(",");
	}
	//columns += "'"
	var include_meta = $('[name="include_meta"]').val();
	var meta = '';
	if (include_meta!==null) {
		meta = include_meta.join(",");	
	}
	//meta += "'";
	var delimiter = $('[name="delimiter"]').val();

	save_export_setting(columns,meta,delimiter);
});	

function save_export_setting(columns,meta,delimiter){
	var user_id = $('[name="user_id"]').val();
	$.ajax({
		url:site_url+'/savesettings',
		type:'post',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
		data:{column:columns,meta:meta,delimiter:delimiter,user_id:user_id},
		success:function(data){
			console.log("data", data);
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
	})
}

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



/****************Order module js ends*********************/
