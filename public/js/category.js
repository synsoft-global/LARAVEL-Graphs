/***********Category Module js code starts***************/



function addLoadingC(flag=true){
	if(flag){
		$('.category-result').addClass('customer-js-loading');
		//$('#show_filters').addClass('customer-js-loading');
		$('#categoryTable').addClass('customer-js-loading');
	}else{
		$('.category-result').removeClass('customer-js-loading');
		//$('#show_filters').removeClass('customer-js-loading');
		$('#categoryTable').removeClass('customer-js-loading');
	}
	
}


var OrdersearchStart='';
var xhr='';
var ajax_inprocess = false;

/*filter order list*/
function filterdata(orderbyVal='', whereVal='', limit='',segments=[],page=1,gridview='default'){	
	window.clearTimeout(OrdersearchStart);
	 OrdersearchStart = window.setTimeout(function () { 	 	
	 		if (ajax_inprocess == true)
			{
			    xhr.abort();
			}
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
			let filter_type=$("#filter_type").val();			
			let orderbyVal = $('#orderby').val();		
			let range_picker = $('#order_range').val();
			ajax_inprocess = true;
			xhr=$.ajax({
				url:site_url+'/getPaginatedCategory',
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
				 	range_picker:range_picker,
				 	filter_type:filter_type
				},
				success:function(data){
					let text='category';
					
					if(data.total>1){
						text='categories';
						$('#export_btn').html('Export '+data.total+' categories');
						if(data.total>exp_total_limit){
							$('#exportCustomer').attr('disabled', true);
						}else{
							$('#exportCustomer').attr('disabled', false);
						}
					}else{
						$('#exportCustomer').attr('disabled', false);
						$('#export_btn').html('Export');
					}
					if($('.show_rec_export_tab').is(":hidden") == true && $("#modal-settings-notifications").is(":hidden") == true){
						$('.showCustomerCount').html('<strong>Export</strong> '+data.total+' '+text+'<i class="fa fa-info-circle mx-3" aria-hidden="true"></i>');	
					}
					$('[data-toggle="popover"]').popover();	
					$('#categoryTable').empty();
					$('#categoryTable').empty();
					$('#categoryTable').html(data.html);
					$('.category-result').html(data.result);
					$(".select_custom").select2({		      
				      minimumResultsForSearch: Infinity,
				      allowClear: false,
				      
				  });
				addLoadingC(false);
				ajax_inprocess = false;
				 if(data.total > 0) {
					loadOrderData(data.categories.data, "category");
				 }
				},error:function(e){	
					addLoadingC(false);					
					if(e.statusText!="abort"){
						show_error_msg(msg_something_went_wrong);
					}
					console.log(e);
				}
			})	
 	}, 1000);

}

/*Redirects to product page with filter */
$(document).on('click', ".view-all", function(){
	var href = window.location.href.split('?')[0];
	var category_id = href.substring(href.lastIndexOf('/') + 1);
	var localStorageData = '[{"filter":"category","rowid":1,"column":"category","method":"category","option":"include_or","from":["'+category_id+'"],"to":""}]';
	localStorage.setItem( "products_filter_segment", localStorageData);
	window.location = site_url+"/products";
});

// $(document).on('click', "#switch-table", function(){
// 	let get_detail_as = ($('#get_detail_as').attr('data-value')) ? $('#get_detail_as').attr('data-value') : "gross";
// 	let update_get_detail_as = "gross";
// 	if($('#get_detail_as').attr('data-value') == "gross"){
// 		update_get_detail_as = "net";
// 	}else if($('#get_detail_as').attr('data-value') == "net"){
// 		update_get_detail_as = "gross";
// 	}
// 	$('#get_detail_as').attr('data-value', update_get_detail_as);
// 	$('#get_detail_as').html(update_get_detail_as);
// 	localStorage.setItem("category-data", get_detail_as);
// 	filterdata('','', '','','','', get_detail_as);
// });

/*Export product page rows */
$(document).on('click', ".view-order-detail", function(){
	var href = window.location.href.split('?')[0];
	var category_id = href.substring(href.lastIndexOf('/') + 1);
	var range_picker = $('#product_detail_range').val();
	var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
	var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
	var filter = $(this).attr('data-selectedFilter');
	var value = $(this).attr('data-selectedValue');
	localStorage.setItem( "orders_filter_segment", `[{"filter":"`+filter+`","rowid":1,"column":"orders.billing_country","method":"billing_country","option":"in_list","from":["`+value+`"],"to":""},{"filter":"order_created","rowid":2,"column":"orders.date_created","method":"common_date_search","option":"after_including","from":"`+start_date+`","to":"days"},{"filter":"order_created","rowid":3,"column":"orders.date_created","method":"common_date_search","option":"before_including","from":"`+end_date+`","to":"days"},{"filter":"order_status","rowid":4,"column":"orders.status","method":"order_status","option":"not_in_list","from":["pending","cancelled","failed"],"to":""},{"filter":"order_product_category","rowid":5,"column":"order_product_category","method":"order_product_category","option":"in_list","from":["`+category_id+`"],"to":""},{"filter":"order_total","rowid":6,"column":"orders.total","method":"common_number_search","option":"greater_than","from":"0","to":""}]`);

	window.location = site_url+"/orders";
});

/*On click exports the chart detail csv*/
function export_product_chart_detail(){
	var href = window.location.href.split('?')[0];
	var category_id = href.substring(href.lastIndexOf('/') + 1);
	var product_id = $('#product_ids').val();
	var orderbyVal = $('#orderby_product_detail').val();
	var chartby = $('#aBtnGroup').val();
	var range_picker = $('#product_detail_range').val();
	var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
	var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
	$(".graph-loading").show();
	$.ajax({			
		headers:{'X-CSRF-TOKEN':$('meta[name="csrf_token"]').attr('content')},
		url:site_url+'/export_product_chart_detail',
		type:'post',
		data:{
				orderbyValP:orderbyVal, 
				product_id:product_id, 
				chartby:chartby, 
				export_for:"category", 
				range_picker:range_picker,
				data:'text/csv;charset=utf-8',
			},
		success:function(data){
			var str = data;
			var uri = 'data:text/csv;charset=utf-8,' + str;
			$(".graph-loading").hide();
			var downloadLink = document.createElement("a");
			downloadLink.href = uri;
			downloadLink.download = "category-sales-report-"+start_date+"-"+end_date+".csv";

			document.body.appendChild(downloadLink);
			downloadLink.click();
			document.body.removeChild(downloadLink);
		},error:function(e){
			$(".graph-loading").hide();
			show_error_msg(msg_export_couldnot_process_please_try_again);
		}
	})
};

/*filter order detail in product detail*/
function filterdata_detail(orderbyVal='', whereVal='', limit='', updateChart=false, showAll=false, sort=''){
	var href = window.location.href.split('?')[0];
	showAll=localStorage.getItem('product_showAll');
	product_g_sort=localStorage.getItem('product_g_sort');
	var currentView = href.substring(href.lastIndexOf('/') + 1)
	var orderby ='';
	if($('#up').hasClass('ua-icon-arrow-down')){
		orderby = 'desc';
	}else{
		orderby = 'asc';
	}
	whereVal = $('#search_product').val();
	limit = $('#changelimit').val();
	orderbyVal = $('#orderby_product_detail').val();
	if(orderbyVal.split('_')[0] == "billing" || orderbyVal.split('_')[0] == "shipping") {
		groupbyVal = $('#orderby_product_detail_group').val();
	}else{
		groupbyVal = '';
	}
	chartby = $('#aBtnGroup').val();
	range_picker = $('#product_detail_range').val();
	compare_range_picker = $('#compare_date_datepicker_detail').val();
	$.ajax({
		url:site_url+'/categories/'+currentView,
		type:'post',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
		data:{
			orderbyValP:orderbyVal,
			groupbyVal:groupbyVal, 
			orderby:orderby, 
			whereVal:whereVal, 
			limit:limit, 
			chartby:chartby, 
			range_picker:range_picker,
			compare_range_picker:compare_range_picker,
			showAll:showAll,
			product_g_sort:product_g_sort
		},
		success:function(data){	
			$('#filter_product_detail').empty();
			$('#filter_product_detail').html(data.html);
			$(".graph-loading").hide();
			$(".select_custom").select2({		      
			    minimumResultsForSearch: Infinity,
			    allowClear: false,
		  	});
			if(updateChart) {
				if (window.myBar) {
				  window.myBar.destroy();
				}
				createChart(JSON.parse(data.chart), JSON.parse(data.label), data.unit);
			}
			$('[data-toggle="popover"]').popover();
		},error:function(e){
			console.log("error", e);
		}
	})	
}


/*Export product page rows */
function export_product_filter_detail(){
	var href = window.location.href.split('?')[0];
	var category_id = href.substring(href.lastIndexOf('/') + 1);
	$(".filter-loading").show();
	var product_id = $('#product_ids').val();
	var orderbyVal = $('#orderby_product_detail').val();
	if(orderbyVal.split('_')[0] == "billing" || orderbyVal.split('_')[0] == "shipping") {
		groupbyVal = $('#orderby_product_detail_group').val();
	}else{
		groupbyVal = '';
	}
	var range_picker = $('#product_detail_range').val();
	var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
	var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
	$.ajax({			
		headers:{'X-CSRF-TOKEN':$('meta[name="csrf_token"').attr('content')},
		url:site_url+'/export_product_order_detail',
		type:'post',
		data:{
				orderbyValP:orderbyVal, 
				groupbyVal:groupbyVal, 
				productId:product_id, 
				export_for:'category',
				data:'text/csv;charset=utf-8',
			},
		success:function(data){
			var str = data;
			var uri = 'data:text/csv;charset=utf-8,' + str;
			$(".filter-loading").hide();
			var downloadLink = document.createElement("a");
			downloadLink.href = uri;
			downloadLink.download = "category-"+category_id+"-grouped-by-"+orderbyVal+"-data-"+start_date+"-"+end_date+".csv";

			document.body.appendChild(downloadLink);
			downloadLink.click();
			document.body.removeChild(downloadLink);
		},error:function(e){
			$(".filter-loading").hide();
			show_error_msg(msg_export_couldnot_process_please_try_again);
		}
	})
};

/*trigger function on search keyup*/
function show_exp_msg(msg){
	$('#modal-export').modal('hide');
	$('.export').removeClass('is-loading');
	$('.export_order_segment').removeClass('is-loading');
/*	$('.export_msg').html(msg);
	$('#modal-msg').modal('show');
	setTimeout(function(){
		$('#modal-msg').modal('hide');
	}, 3000);*/
}

/*Get details of data based on range and compare range date picker*/
function getDetailData() {
	var href = window.location.href.split('?')[0],
	product_id = $('#product_ids').val(),
	range_picker = $('#product_detail_range').val();
	compare_range_picker = $('#compare_date_datepicker_detail').val();
	if(product_id == "[]") {
		product_id = '';
	}
	$('#compare_date_datepicker_detail_html').html(compare_range_picker)
	$.ajax({
		url:site_url+'/getDetailAcToDate',
		type:'POST',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
		data:{product_id:product_id, range_picker:range_picker, compare_range_picker:compare_range_picker, detail_for:'category'},
		success:function(data){	
			$(".select_custom").select2({		      
			    minimumResultsForSearch: Infinity,
			    allowClear: false,
		  	});
			$('#net_data').empty();
			$('#product_order_details').empty();
			$('#filter_product_detail').empty();
			$('#number_of_orders').empty();
			$('#net_avg').empty();
			$('#filter_product_detail').html(data.order_placed_data_grouped);
			if(data.number_of_orders > 0) {
				$('#net_data').removeClass('hide_c');
				$('#net_avg').removeClass('hide_c');
				$('#product_order').removeClass('hide_c');
				$('#product_order_details').removeClass('hide_c');
				$('#net_data').html(data.net_data);
				$('#net_avg').html(data.net_avg);
				$('#product_order_details').html(data.order_placed_data);
				$('#number_of_orders').html(data.number_of_orders_view);
			}else{
				$('#net_data').addClass('hide_c');
				$('#net_avg').addClass('hide_c');
				$('#product_order_details').addClass('hide_c');
				$('#product_order').addClass('hide_c');
			}
			if (window.myBar) {
			  window.myBar.destroy();
			}
			if(data.label) {
				createChart(JSON.parse(data.chart), JSON.parse(data.label), data.unit);
			}
			$('[data-toggle="popover"]').popover();
		},error:function(e){
			console.log("error", e);
		}
	})
}


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

/*on click clears the compare date*/
$(document).on('click','#clear_compare', function(){
	document.getElementById('compare_date').value = '';
	$('#modal-compare').modal('hide');
	filterdata('','', '','','','');
});


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

	$(document).on('change', '#compare_date', function(){
		document.getElementById('compare_date').value = $(this).val();
		// $('compare_date')
	});

	$(document).on('click', ".compare_order_range_view_icon", function(e){	
		$('#compare_date_datepicker').trigger('click');
	});
	

  });



})(jQuery);

/****************Order module js ends*********************/
