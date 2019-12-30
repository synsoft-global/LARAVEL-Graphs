/*For adding loading on the list page*/

var filterdata_s='';
function filterdata(){
	window.clearTimeout(filterdata_s);
 	 filterdata_s = window.setTimeout(function () { 
	  	filterdata_detail_status();
	  	filterdata_detail_customer_type();
		filterdata_detail_payment();
		filterdata_detail_billing();
		filterdata_detail_shipping();
		filterdata_detail_sidewidget();
		filterdata_detail_chart();
	}, timeout);
}


localStorage.setItem('report_g_sort','');
/*Export product page rows */
$(document).on('click', ".view-order-detail", function(){
	var href = window.location.href.split('?')[0];
	var product_id = href.substring(href.lastIndexOf('/') + 1);
	var range_picker = $('#order_range').val();
	var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
	var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
	var filter = $(this).attr('data-selectedFilter');
	var value = $(this).attr('data-selectedValue');
	if(filter=='status'){
	localStorage.setItem( "orders_filter_segment", `[{"filter":"order_status","rowid":1,"column":"`+filter+`","method":"common_value_search","option":"in_list","from":["`+value+`"],"to":""},{"filter":"order_created","rowid":2,"column":"orders.date_created","method":"common_date_search","option":"after_including","from":"`+start_date+`","to":"days"},{"filter":"order_created","rowid":3,"column":"orders.date_created","method":"common_date_search","option":"before_including","from":"`+end_date+`","to":"days"},{"filter":"order_total","rowid":6,"column":"total","method":"common_value_search","option":"greater_than","from":"0","to":""}]`);

	}else if(filter=='payment_method_id'){
	localStorage.setItem( "orders_filter_segment", `[{"filter":"payment_method","rowid":1,"column":"`+filter+`","method":"payment_method","option":"in_list","from":["`+value+`"],"to":""},{"filter":"order_created","rowid":2,"column":"orders.date_created","method":"common_date_search","option":"after_including","from":"`+start_date+`","to":"days"},{"filter":"order_created","rowid":3,"column":"orders.date_created","method":"common_date_search","option":"before_including","from":"`+end_date+`","to":"days"},{"filter":"order_status","rowid":4,"column":"status","method":"common_value_search","option":"not_in_list","from":["cancelled", "failed", "pending"],"to":""},{"filter":"order_total","rowid":6,"column":"total","method":"common_value_search","option":"greater_than","from":"0","to":""}]`);

	}else{
	localStorage.setItem( "orders_filter_segment", `[{"filter":"`+filter+`","rowid":1,"column":"orders.`+filter+`","method":"`+filter+`","option":"in_list","from":["`+value+`"],"to":""},{"filter":"order_created","rowid":2,"column":"orders.date_created","method":"common_date_search","option":"after_including","from":"`+start_date+`","to":"days"},{"filter":"order_created","rowid":3,"column":"orders.date_created","method":"common_date_search","option":"before_including","from":"`+end_date+`","to":"days"},{"filter":"order_status","rowid":4,"column":"status","method":"common_value_search","option":"not_in_list","from":["cancelled", "failed", "pending"],"to":""},{"filter":"order_total","rowid":6,"column":"total","method":"common_value_search","option":"greater_than","from":"0","to":""}]`);

	}

	window.location = site_url+"/orders";
});



/****************Order report module's **********************/
localStorage.setItem('report_order_status_sort', '');
/**********status table ************/
$(document).on('click', ".report_status_sort", function(){
	let sort=$(this).data('id');
	 if($(this).hasClass('sorting_asc')){ 
	    $(this).removeClass('sorting_asc');     
	    $(this).addClass('sorting_desc');  
	     sort=sort+'__desc';
	  }
	  else if($(this).hasClass('sorting_desc')){
	    sort=sort+'__asc';
	     $(this).removeClass('sorting_desc');     
	    $(this).addClass('sorting_asc'); 
	  }else{
	     sort=sort+'__asc';
	     $(this).removeClass('sorting_desc');     
	     $(this).addClass('sorting_asc'); 
	  }	
	report_g_sort=localStorage.setItem('report_order_status_sort', sort);
	filterdata_detail_status();
});
/**********End status table ************/

/********** payment table order by *************/
localStorage.setItem('report_order_payment_sort','');	
$(document).on('click', ".report_payment_sort", function(){
    let sort=$(this).data('id');

   if($(this).hasClass('sorting_asc')){ 
    $(this).removeClass('sorting_asc');     
    $(this).addClass('sorting_desc');  
     sort=sort+'__desc';
  }
  else if($(this).hasClass('sorting_desc')){
    sort=sort+'__asc';
     $(this).removeClass('sorting_desc');     
    $(this).addClass('sorting_asc'); 
  }else{
     sort=sort+'__asc';
     $(this).removeClass('sorting_desc');     
     $(this).addClass('sorting_asc'); 
  }
 
 	localStorage.setItem('report_order_payment_sort',sort);	
	filterdata_detail_payment();
});

/**********End payment table order by *************/


/********** payment table group by *************/
localStorage.setItem('report_order_payment_group_by','');
$(document).on('click', '.groupby_order_detail', function(){	
	$(this).addClass('active').siblings().removeClass('active');
	var groupBy = $(this).val();
	localStorage.setItem('report_order_payment_group_by',groupBy);
	filterdata_detail_payment();
})

/********** Billing table group by *************/
localStorage.setItem('report_order_billing_group_by','');
$(document).on('click', ".groupby_billing", function(){
	$(this).addClass('active').siblings().removeClass('active');
	var groupBy = $(this).val();
	localStorage.setItem('report_order_billing_group_by',groupBy);

	filterdata_detail_billing();
});
/**********End billing table group by *************/

/********** Billing table sort by *************/
localStorage.setItem('report_order_billing_sort_by','');
$(document).on('click', ".report_billing_sort", function(){
	let sort=$(this).data('id');
	 if($(this).hasClass('sorting_asc')){ 
	    $(this).removeClass('sorting_asc');     
	    $(this).addClass('sorting_desc');  
	     sort=sort+'__desc';
	  }
	  else if($(this).hasClass('sorting_desc')){
	    sort=sort+'__asc';
	     $(this).removeClass('sorting_desc');     
	    $(this).addClass('sorting_asc'); 
	  }else{
	     sort=sort+'__asc';
	     $(this).removeClass('sorting_desc');     
	     $(this).addClass('sorting_asc'); 
	  }
	localStorage.setItem('report_order_billing_sort_by',sort);	
	filterdata_detail_billing();
});
/**********End billing table sort by *************/

/********** Billing table where val *************/
localStorage.setItem('report_order_billing_where','');
$(document).on('change', "#groupby_billing_where", function(){
	let where=$('#groupby_billing_where').children("option:selected"). val();
	localStorage.setItem('report_order_billing_where',where);	
	filterdata_detail_billing();
});
/**********End Billing table sort by *************/


/********** shipping table group by *************/
localStorage.setItem('report_order_shipping_group_by','');
$(document).on('click', ".groupby_shipping", function(){
	$(this).addClass('active').siblings().removeClass('active');
	var groupBy = $(this).val();
	localStorage.setItem('report_order_shipping_group_by',groupBy);

	filterdata_detail_shipping();
});
/**********End shipping table group by *************/

/********** shipping table sort by *************/
localStorage.setItem('report_order_shipping_sort_by','');
$(document).on('click', ".report_shipping_sort", function(){
	
	let sort=$(this).data('id');
	 if($(this).hasClass('sorting_asc')){ 
	    $(this).removeClass('sorting_asc');     
	    $(this).addClass('sorting_desc');  
	     sort=sort+'__desc';
	  }
	  else if($(this).hasClass('sorting_desc')){
	    sort=sort+'__asc';
	     $(this).removeClass('sorting_desc');     
	    $(this).addClass('sorting_asc'); 
	  }else{
	     sort=sort+'__asc';
	     $(this).removeClass('sorting_desc');     
	     $(this).addClass('sorting_asc'); 
	  }
	localStorage.setItem('report_order_shipping_sort_by',sort);	
	filterdata_detail_shipping();
});
/**********End shipping table sort by *************/

/********** shipping table where val *************/
localStorage.setItem('report_order_shipping_where','');
$(document).on('change', "#groupby_shipping_where", function(){
	let where=$('#groupby_shipping_where').children("option:selected"). val();
	localStorage.setItem('report_order_shipping_where',where);	
	filterdata_detail_shipping();
});
/**********End shipping table sort by *************/



/***************show all orders at billing table************ */
localStorage.setItem('report_order_showAll','');
$(document).on('click', "#show_all", function(){
	localStorage.setItem('report_order_showAll',true);
	filterdata_detail_billing();
});

/***************show all orders at shipping table ***************/
localStorage.setItem('report_shipping_showAll','');
$(document).on('click', "#shipping_show_all", function(){
	localStorage.setItem('report_shipping_showAll',true);
	filterdata_detail_shipping();
});
/***************Ends show all orders at shipping table ***************/

/***************Export orders at status table ***************/
	localStorage.setItem('report_export_status',0);
$(document).on('click', ".export_status_btn", function(){
	localStorage.setItem('report_export_status',1);
	filterdata_detail_status();
});
/***************Ends Export orders at status table ***************/


/***************Export orders at billing table ***************/
	localStorage.setItem('report_export_billing',0);
$(document).on('click', ".export_billing_btn", function(){
	localStorage.setItem('report_export_billing',1);
	filterdata_detail_billing();
});
/***************Ends Export orders at billing table ***************/

/***************Export orders at payment table ***************/
	localStorage.setItem('report_export_payment',0);
$(document).on('click', ".export_payment_btn", function(){
	localStorage.setItem('report_export_payment',1);
	filterdata_detail_payment();
});
/***************Ends Export orders at payment table ***************/


/***************Export orders at shipping table ***************/
	localStorage.setItem('report_export_shipping',0);
$(document).on('click', ".export_shipping_btn", function(){
	localStorage.setItem('report_export_shipping',1);
	filterdata_detail_shipping();
});
/***************Ends Export orders at shipping table ***************/


/**********Show or hide gross and net at widget *************/
$(document).on('click', '#show_avg_gross', function(){
	$('.avg_net').hide();
	$('.avg_gross').show();
});
$(document).on('click', '#show_avg_net', function(){
	$('.avg_net').show();
	$('.avg_gross').hide();
})
/**********Show or hide gross and net at widget ends*************/

/*$(document).on('click', '.get_payment_table', function(){
	var groupBy = $(this).val();
	filterdata_detail();
})*/


/*filter order detail report module for status table*/
var filterdata_detail_status_s='';
function filterdata_detail_status(orderbyVal='', whereVal='', limit='', updateChart=false, sort='', groupby=''){
	window.clearTimeout(filterdata_detail_status_s);
	  filterdata_detail_status_s = window.setTimeout(function () { 
		report_g_sort=localStorage.getItem('report_order_status_sort');
		sort=localStorage.getItem('report_order_status_sort');	
		exportbtn = localStorage.getItem('report_export_status');
		var orderbyVal = sort.split('__')[0];
		var orderby = sort.split('__')[1];
		let range_picker = $('#order_range').val();
		var dt1 = new Date(range_picker.split('-')[0]);
		var dt2 = new Date(range_picker.split('-')[1]);
		var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
		var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
		if(exportbtn == 1){
			//$("#status-filter-loading").show();
			$('.export_status_btn').addClass('is-loading');
 			$('.export_status_btn').attr('disabled','disabled');
		}
		let compare_range_picker = $('#compare_date').val();
		$('#compare_date_html').html(compare_range_picker);
		$('#order-status-grouped').addClass('customer-js-loading');
		$.ajax({
			url:site_url+'/reports/orders_status_detail',
			type:'post',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{
				orderbyValP:orderbyVal,
				orderby:orderby,  
				range_picker:range_picker,
				compare_range_picker:compare_range_picker,
				report_g_sort:report_g_sort,
				exportbtn:exportbtn
			},
			success:function(data){	
				if(exportbtn == 1){
					//$("#status-filter-loading").hide();
					 $('.export_status_btn').removeClass('is-loading');
      				 $('.export_status_btn').removeAttr('disabled');
   					 $('.export_status_btn').popover('hide');

					try {	const a = document.createElement("a");
					    document.body.appendChild(a);
					    a.style = "display: none";				   
				        const blob = new Blob([data], {type: "octet/stream"}),
				           url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
				        a.href = url;
				        a.download = "grouped-by-status-data-"+start_date+"-"+end_date+".csv";
				       	a.click();
				        window.URL.revokeObjectURL(url);				   
					}
					catch(err) {
							url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
							window.open(url,'_self');					
					}
				}else{
					$('#order-status-grouped').empty();
					$('#order-status-grouped').html(data.status_table);
					$('[data-toggle="popover"]').popover();

				}
				localStorage.setItem('report_export_status',0);
				$('#order-status-grouped').removeClass('customer-js-loading');
			},error:function(e){
				console.log("error", e);
				$('#order-status-grouped').removeClass('customer-js-loading');
			}
		})	
	}, timeout);

}

/*filter order detail report module for status table*/
var filterdata_detail_customer_type_s='';
function filterdata_detail_customer_type(orderbyVal='', whereVal='', limit='', updateChart=false, sort='', groupby=''){
	window.clearTimeout(filterdata_detail_customer_type_s);
	  filterdata_detail_customer_type_s = window.setTimeout(function () { 
		report_g_sort=localStorage.getItem('report_order_status_sort');
		sort=localStorage.getItem('report_order_status_sort');	
		exportbtn = localStorage.getItem('report_export_status');
		var orderbyVal = sort.split('__')[0];
		var orderby = sort.split('__')[1];
		let range_picker = $('#order_range').val();
		var dt1 = new Date(range_picker.split('-')[0]);
		var dt2 = new Date(range_picker.split('-')[1]);
		var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
		var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
		if(exportbtn == 1){
			$("#status-filter-loading").show();
		}
		let compare_range_picker = $('#compare_date').val();
		$('#compare_date_html').html(compare_range_picker);
		$('#orders_customers_type').addClass('customer-js-loading');
		$.ajax({
			url:site_url+'/reports/orders_customer_type_detail',
			type:'post',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{			
				range_picker:range_picker,
				compare_range_picker:compare_range_picker							
			},
			success:function(data){	
		
			$('#orders_customers_type').empty();
			$('#orders_customers_type').html(data.html);
			$('[data-toggle="popover"]').popover();

				$('#orders_customers_type').removeClass('customer-js-loading');

			},error:function(e){
				console.log("error", e);
				$('#orders_customers_type').removeClass('customer-js-loading');
			}
		})	
	}, timeout);

}



/*filter order detail report module by status*/
var filterdata_detail_payment_s='';
function filterdata_detail_payment(orderbyVal='', whereVal='', limit='', updateChart=false, sort='', groupby=''){
	window.clearTimeout(filterdata_detail_payment_s);
	  filterdata_detail_payment_s = window.setTimeout(function () {

		report_g_sort=localStorage.getItem('report_order_payment_sort');
		groupby=localStorage.getItem('report_order_payment_group_by');
		sort=localStorage.getItem('report_order_payment_sort');	
		exportbtn = localStorage.getItem('report_export_payment');
		var orderbyVal = sort.split('__')[0];
		var orderby = sort.split('__')[1];
		let range_picker = $('#order_range').val();
		var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
		var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
		if(exportbtn == 1){
			$('.export_payment_btn').addClass('is-loading');
			$('.export_payment_btn').attr('disabled','disabled');
		}
		var dt1 = new Date(range_picker.split('-')[0]);
		var dt2 = new Date(range_picker.split('-')[1]);	
		let compare_range_picker = $('#compare_date').val();
		$('#compare_date_html').html(compare_range_picker);
		$('#order_payment_table').addClass('customer-js-loading');
		$.ajax({
			url:site_url+'/reports/orders_payment_detail',
			type:'post',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{
				orderbyValP:orderbyVal,
				groupbyVal:groupby,
				orderby:orderby, 		
				range_picker:range_picker,
				compare_range_picker:compare_range_picker,			
				report_g_sort:report_g_sort,
				exportbtn:exportbtn
			},
			success:function(data){	
				if(exportbtn == 1){
					$('.export_payment_btn').removeClass('is-loading');
					$('.export_payment_btn').removeAttr('disabled');
					$('.export_payment_btn').popover('hide');
					try {	
						const a = document.createElement("a");
					    document.body.appendChild(a);
					    a.style = "display: none";				   
				        const blob = new Blob([data], {type: "octet/stream"}),
				           url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
				        a.href = url;
				        if(groupby==''){
				        	groupby = 'payment_method';
				        }
				        a.download = "grouped-by-"+groupby+"-data-"+start_date+"-"+end_date+".csv";
				       	a.click();
				        window.URL.revokeObjectURL(url);				   
					}
					catch(err) {
							url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
							window.open(url,'_self');					
					}
				}else{		
					$('#order_payment_table').empty();
					$('#order_payment_table').html(data.payment_table);		
					$('[data-toggle="popover"]').popover();
				}
				localStorage.setItem('report_export_payment',0);
				$('#order_payment_table').removeClass('customer-js-loading');
			},error:function(e){
				console.log("error", e);
				$('#order_payment_table').removeClass('customer-js-loading');
			}
		})	
	}, timeout);

}



/*filter order detail report module by billing country*/
var filterdata_detail_billing_s='';
function filterdata_detail_billing(){
	window.clearTimeout(filterdata_detail_billing_s);
	  filterdata_detail_billing_s = window.setTimeout(function () {

		report_g_sort=localStorage.getItem('report_order_billing_sort_by');
		sort=localStorage.getItem('report_order_billing_sort_by');
		groupby=localStorage.getItem('report_order_billing_group_by');	
		showAll=localStorage.getItem('report_order_showAll');
		exportbtn = localStorage.getItem('report_export_billing');
		var where = '';	
		if(groupby!='billing_country'){
			where=localStorage.getItem('report_order_billing_where');	
		}
		var orderbyVal = sort.split('__')[0];
		var orderby = sort.split('__')[1];
		let range_picker = $('#order_range').val();
		var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
		var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
		if(exportbtn == 1){
			$('.export_billing_btn').addClass('is-loading');
			$('.export_billing_btn').attr('disabled','disabled');
		}
		var dt1 = new Date(range_picker.split('-')[0]);
		var dt2 = new Date(range_picker.split('-')[1]);
		let compare_range_picker = $('#compare_date').val();
		$('#compare_date_html').html(compare_range_picker);
		$('#order_billing_table').addClass('customer-js-loading');
		$.ajax({
			url:site_url+'/reports/orders_billing_detail',
			type:'post',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{
				orderbyValP:orderbyVal,
				groupbyVal:groupby,
				orderby:orderby, 
				showAll:showAll,
				range_picker:range_picker,
				compare_range_picker:compare_range_picker,
				report_g_sort:report_g_sort,
				whereVal:where,
				exportbtn:exportbtn
			},
			success:function(data){
				if(exportbtn == 1){
					$('.export_billing_btn').removeClass('is-loading');
					$('.export_billing_btn').removeAttr('disabled');
					$('.export_billing_btn').popover('hide');
					try {	
						const a = document.createElement("a");
					    document.body.appendChild(a);
					    a.style = "display: none";				   
				        const blob = new Blob([data], {type: "octet/stream"}),
				           url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
				        a.href = url;
				        if(groupby==''){
				        	groupby = 'billing_country';
				        }
				        a.download = "grouped-by-"+groupby+"-data-"+start_date+"-"+end_date+".csv";
				       	a.click();
				        window.URL.revokeObjectURL(url);				   
					}
					catch(err) {
							url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
							window.open(url,'_self');					
					}
				}else{	
					$('#order_billing_table').empty();
					$('#order_billing_table').html(data.billing_table);	
					$('[data-toggle="popover"]').popover();
					$(".select_custom").select2({		      
						    minimumResultsForSearch: Infinity,
						    allowClear: false,
					  	});
				}
				localStorage.setItem('report_export_billing',0);
				$('#order_billing_table').removeClass('customer-js-loading');

			},error:function(e){
				console.log("error", e);
				$('#order_billing_table').removeClass('customer-js-loading');
			}
		})	
	}, timeout);

}


/*filter order detail report module by billing country*/
var filterdata_detail_shipping_s='';
function filterdata_detail_shipping(){
	window.clearTimeout(filterdata_detail_shipping_s);
	  filterdata_detail_shipping_s = window.setTimeout(function () {
		report_g_sort=localStorage.getItem('report_order_shipping_sort_by');
		groupby=localStorage.getItem('report_order_shipping_group_by');	
		showAll=localStorage.getItem('report_shipping_showAll');
		var where = '';	
		if(groupby!='shipping_country'){
			where=localStorage.getItem('report_order_shipping_where');	
		}
		exportbtn = localStorage.getItem('report_export_shipping');
		var orderbyVal = report_g_sort.split('__')[0];
		var orderby = report_g_sort.split('__')[1];
		let range_picker = $('#order_range').val();
		var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
		var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
		if(exportbtn == 1){
			$('.export_shipping_btn').addClass('is-loading');
			$('.export_shipping_btn').attr('disabled','disabled');
		}
		var dt1 = new Date(range_picker.split('-')[0]);
		var dt2 = new Date(range_picker.split('-')[1]);
		let compare_range_picker = $('#compare_date').val();
		$('#compare_date_html').html(compare_range_picker);
		$('#order_shipping_table').addClass('customer-js-loading');
		$.ajax({
			url:site_url+'/reports/orders_shipping_detail',
			type:'post',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{
				orderbyValP:orderbyVal,
				groupbyVal:groupby,
				orderby:orderby, 
				showAll:showAll,
				range_picker:range_picker,
				compare_range_picker:compare_range_picker,
				report_g_sort:report_g_sort,
				whereVal:where,
				exportbtn:exportbtn
			},
			success:function(data){	
				if(exportbtn == 1){
						$('.export_shipping_btn').removeClass('is-loading');
						$('.export_shipping_btn').removeAttr('disabled');
						$('.export_shipping_btn').popover('hide');
					try {	
						const a = document.createElement("a");
					    document.body.appendChild(a);
					    a.style = "display: none";				   
				        const blob = new Blob([data], {type: "octet/stream"}),
				           url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
				        a.href = url;
				        if(groupby==''){
				        	groupby = 'shipping_country';
				        }
				        a.download = "grouped-by-"+groupby+"-data-"+start_date+"-"+end_date+".csv";
				       	a.click();
				        window.URL.revokeObjectURL(url);				   
					}
					catch(err) {
							url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
							window.open(url,'_self');					
					}
				}else{
					$('#order_shipping_table').empty();
					$('#order_shipping_table').html(data.shipping_table);	
					$('[data-toggle="popover"]').popover();
					$(".select_custom").select2({		      
						    minimumResultsForSearch: Infinity,
						    allowClear: false,
					  	});
				}
				localStorage.setItem('report_export_shipping',0);
				$('#order_shipping_table').removeClass('customer-js-loading');
			},error:function(e){
				console.log("error", e);
				$('#order_shipping_table').removeClass('customer-js-loading');
			}
		})	
	}, timeout);

}


/*filter order detail report module by sidewidget*/
var filterdata_detail_sidewidget_s='';
function filterdata_detail_sidewidget(){
	window.clearTimeout(filterdata_detail_sidewidget_s);
	  filterdata_detail_sidewidget_s = window.setTimeout(function () {
		let range_picker = $('#order_range').val();
		let compare_range_picker = $('#compare_date').val();
		$('#compare_date_html').html(compare_range_picker);
		$('#order-sidewidget').addClass('customer-js-loading');
		$("#chart_item_count").find('.loading').show();
		$("#chart_order_count").find('.loading').show();
		$("#chart_spend_by_day").find('.loading').show();
		$("#chart_spend_by_hour").find('.loading').show();
		$.ajax({
			url:site_url+'/reports/orders_sidewidgets',
			type:'post',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{
				range_picker:range_picker,
				compare_range_picker:compare_range_picker,
			},
			success:function(data){	
				
				$('#order-sidewidget').empty();
				$('#order-sidewidget').html(data.sidewidget);
				$('#order-widget').empty();
				$('#order-widget').html(data.widget);	
				$('[data-toggle="popover"]').popover();
				$(".select_custom").select2({		      
					    minimumResultsForSearch: Infinity,
					    allowClear: false,
				  	});
				 
				$("#chart_item_count").find('.loading').hide();
				$("#chart_order_count").find('.loading').hide();
				$("#chart_spend_by_day").find('.loading').hide();
				$("#chart_spend_by_hour").find('.loading').hide();
			
				

				createChartItem(JSON.parse(data.item_count.chart), JSON.parse(data.item_count.label), '', [],'');

				createChartOrder(JSON.parse(data.order_count.chart), JSON.parse(data.order_count.label), '', [],'');

				createChartSpendByDay(JSON.parse(data.spend_by_day.chart), JSON.parse(data.spend_by_day.label), '', ["data_sold"],'');

				createChartSpendByHour(JSON.parse(data.spend_by_hour.chart), JSON.parse(data.spend_by_hour.label),'', ["data_sold"],'');



				$('#order-sidewidget').removeClass('customer-js-loading');
			},error:function(e){
				console.log("error", e);
				$('#order-sidewidget').removeClass('customer-js-loading');
			}
		})	
	}, timeout);

}


//var data_revenue  = [], data_order_count  = [],data_items_count  = [], data_sold  = [], data_refunds  = [],data_taxes  = [], data_shipping  = [], data_fees  = [],data_previous  = [], label  = [], datasets = [];

/*filter order detail report module by sidewidget*/
var chartData='';
var data_to_show = ["data_revenue"];
var filterdata_detail_chart_s='';
function filterdata_detail_chart(chartby='', export_chart=''){
	window.clearTimeout(filterdata_detail_chart_s);
	  filterdata_detail_chart_s = window.setTimeout(function () {
		let range_picker = $('#order_range').val();
		let compare_range_picker = $('#compare_date').val();
		$('#compare_date_html').html(compare_range_picker);
		$('#order-chart').addClass('customer-js-loading');
		$.ajax({
			url:site_url+'/reports/orders_charts',
			type:'post',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{
				chartby:chartby,
				range_picker:range_picker,
				export_chart:export_chart,
				compare_range_picker:compare_range_picker
			},
			success:function(data){	


				
				$('#export_chart_data').removeClass('is-loading');
				$('#export_chart_data').removeAttr('disabled');
				$('#export_chart_data').popover('hide');
				if(export_chart){
					try {
						var start_date = moment(range_picker.split('-')[0]).format('YYYY-MM-DD');
						var end_date = moment(range_picker.split('-')[1]).format('YYYY-MM-DD');
						const a = document.createElement("a");
					    document.body.appendChild(a);
					    a.style = "display: none";				   
				        const blob = new Blob([data], {type: "octet/stream"}),
				           url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
				        a.href = url;
				        a.download = "orders-report-"+start_date+"-"+end_date+".csv";
				       // a.target = '_blank';
				        a.click();
				        window.URL.revokeObjectURL(url);				   
					}
					catch(err) {
							url ='data:text/csv;charset=utf-8,' + encodeURIComponent(data);
							window.open(url,'_self');					
					}
				}else{
				
					$('#order-chart').empty();
					$('#order-chart').html(data.chartSection);
					$('#order_monthly_net').empty();
					$('#order_monthly_net').html(data.ordermonthly);
					$('[data-toggle="popover"]').popover();
					$(".select_custom").select2({		      
					    minimumResultsForSearch: Infinity,
					    allowClear: false,
				  	});
				  	if (window.myBar) {
						  window.myBar.destroy();
						}
					chartData=data.data_chart;

					let report_order_breakdown= localStorage.getItem("report_order_breakdown"); 				
					
					 $("#"+data.data_chart.unit+'_btn').addClass('active').siblings().removeClass('active');
					
					 if(report_order_breakdown==1){				 
					 	$("#breakdown_btn").addClass('active');
					 	 data_to_show = ["data_revenue","data_sold","data_refunds","data_discounts","data_taxes","data_shipping","data_fees"];
					 }

					 createChart(JSON.parse(data.data_chart.chart), JSON.parse(data.data_chart.label), data.data_chart.unit, data_to_show,report_order_breakdown,JSON.parse(data.data_chart.chart_p));



					 if(data.show_hours){
					 	$('#hour_btn').removeAttr('disabled');
					 }else{
					 	$('#hour_btn').attr('disabled','disabled');
					 }
					
				}
				 $('#order-chart').removeClass('customer-js-loading');
			},error:function(e){
				console.log("error", e);
				$('#order-chart').removeClass('customer-js-loading');
			}
		})	
	}, timeout);

}

$(document).on('click', "#export_chart_data", function(){
	exportDetail();
});


/*Export product page rows */
function exportDetail(){		
	
	$('#export_chart_data').addClass('is-loading');
	$('#export_chart_data').attr('disabled','disabled');
	let thisBtn=$(".orders-four-btn-grp").find('active').find('button').val();
	filterdata_detail_chart(thisBtn,true)
	
};




/*On click of button generates chart data*/
$(document).on('click', ".orders-four-btn-grp button", function(){
  var thisBtn = $(this);    
  thisBtn.addClass('active').siblings().removeClass('active');
  var btnValue = thisBtn.val();
  $('.orders-four-btn-grp').val(btnValue);     
  filterdata_detail_chart(btnValue);
});

localStorage.setItem("report_order_breakdown", 0);  

$(document).on('click', "#breakdown_btn", function(){
  var thisBtn = $(this); 
  let  report_order_breakdown=0;
  if(thisBtn.hasClass('active')){
  	thisBtn.removeClass('active');
  	report_order_breakdown=0;
  	localStorage.setItem("report_order_breakdown", 0);  
  	data_to_show = ["data_revenue"];
  }else{
  	thisBtn.addClass('active');
  	report_order_breakdown=1;
  	localStorage.setItem("report_order_breakdown", 1);  
  	data_to_show = ["data_revenue","data_sold","data_refunds","data_discounts","data_taxes","data_shipping","data_fees"];
  }    

 // data_to_show = ["data_revenue","data_sold","data_refunds","data_discounts","data_taxes","data_shipping","data_fees"];

  localStorage.setItem("report_order_breakdown", report_order_breakdown);  
  createChart( JSON.parse(chartData.chart), JSON.parse(chartData.label), chartData.unit, data_to_show, report_order_breakdown,JSON.parse(chartData.chart_p));
});    


 function createChart(data_click, labelData, unit, data_to_show, chart_type,chart_p) {
      if(data_click.length > 0) {
        var displayFormats = {
          quarter: "MMM YYYY",
          month: "MMM ' YY",
          week: "MMM D",
          day: "MMM D",
          hour: "MMM D - hA"
        };
        var data_revenue  = [], data_order_count  = [],data_items_count  = [], data_sold  = [], data_refunds  = [], data_discounts  = [], data_taxes  = [], data_shipping  = [], data_fees  = [],data_previous  = [], label  = [], datasets = [];
     
        for(let x= 0; x < data_click.length; x++) {
          data_revenue.push(data_click[x].net_sales);
          data_order_count.push(data_click[x].order_count);
          data_items_count.push(data_click[x].items_count);
          data_discounts.push(data_click[x].discounts);
          data_sold.push(data_click[x].gross_sales);
          data_refunds.push(data_click[x].refunds);
          data_taxes.push(data_click[x].taxes);
          data_shipping.push(data_click[x].shipping); 
          data_fees.push(data_click[x].fees); 
       		let pre=(!!chart_p[x] && chart_p[x].net_sales) ?  chart_p[x].net_sales : 0;
           data_previous.push(pre); 
        }
       

        var unitSize = 4;
        if(unit == "day") {
          unitSize = 153;
        }else if(unit == "week") {
          unitSize = 22;
        }else if(unit == "hour") {
          unitSize = 4;
          displayFormat = {
            quarter: 'MMM YYYY'
          }
        }

        if($('#compare_date').val()) {
          datasets.push({             
              type: "line",
              data: data_previous,
              fill: false,              
              lineTension:0,
              borderWidth:4,            
              borderColor:'rgba(253,126,20,1)'
          });
        }
        

        for(var x = 0; x < data_to_show.length;x++) {
          if(data_to_show[x] == "data_revenue") {
            backgroundColor = 'rgba(185, 228, 193, 1)';
            borderColor = 'rgba(76, 110, 245, 1)';
            data = data_revenue;
        }else if(data_to_show[x] == "data_sold") {
            backgroundColor = 'rgba(193, 204, 252, 1)';
            borderColor = 'rgba(55, 178, 77, 1)';
            data = data_sold;
          }else if(data_to_show[x] == "data_refunds") {
            backgroundColor = 'rgba(253, 195, 195, 1)';
            borderColor = 'rgba(250, 82, 82, 1)';
            data = data_refunds; 
        }else if(data_to_show[x] == "data_discounts") {
            backgroundColor = 'rgba(253, 195, 195, 1)';
            borderColor = 'rgba(250, 82, 82, 1)';
            data = data_discounts;
          }else if(data_to_show[x] == "data_taxes") {
            backgroundColor = 'rgba(252, 208, 105, 1)';
            borderColor = 'rgba(250, 176, 5, 1)';
            data = data_taxes;
          }else if(data_to_show[x] == "data_shipping") {
            backgroundColor = 'rgba(181, 159, 251, 1)';
            borderColor = 'rgba(132, 94, 247, 1)';
            data = data_shipping;
          }else if(data_to_show[x] == "data_fees") {
            backgroundColor = 'rgba(240, 146, 179, 1)';
            borderColor = 'rgba(230, 73, 128, 1)';
            data = data_fees;
          }

          datasets.push({
              type: "line",
              data: data,
               yAxisID: 'y-axis-0',
              fill:false,
              backgroundColor:backgroundColor,
              pointHoverBackgroundColor:backgroundColor,
              lineTension:0,
              borderWidth:4,
              pointHoverBorderWidth:0.5,
              pointHoverRadius:5,
              pointHoverBorderColor: borderColor,
              borderColor:borderColor
          });
        }


        datasets.push({
              type: "bar",
              data: data_order_count,
               yAxisID: 'y-axis-1',             
              backgroundColor:backgroundColor,
              pointBorderColor:'rgba(204, 218, 234, 1)',
              pointBackgroundColor:'rgba(204, 218, 234, 1)',
              backgroundColor:'rgba(204, 218, 234, 1)',
              borderColor:'rgba(204, 218, 234, 1)'
          });

        datasets.push({
              type: "bar",
              data: data_items_count,
              yAxisID: 'y-axis-1',             
              backgroundColor:backgroundColor,
              pointBorderColor:'rgba(204, 218, 234, 0.7)',
              pointBackgroundColor:'rgba(204, 218, 234, 0.7)',
              backgroundColor:'rgba(204, 218, 234, 0.7)',
              borderColor:'rgba(204, 218, 234, 0.7)'
          });


        

        var lineChartData = {
          labels: labelData,
          datasets: datasets
        };

        var ctx = document.getElementById("chart-orders");
        if (window.myBar) {
          window.myBar.destroy();
        }
        $('#no-chart-data').addClass('hide_c');
        $('#chart-data').removeClass('hide_c');
        Chart.defaults.global.elements.point.radius = 0
        Chart.Tooltip.positioners.custom = function(elements, eventPosition) { //<-- custom is now the new option for the tooltip position
            /** @type {Chart.Tooltip} */
            var tooltip = this;
            return {
                x: eventPosition.x,
                y: eventPosition.y
            };
        }
        window.myBar = new Chart(ctx, {
          type: 'bar',
          data: lineChartData,
          options: {
            tooltips: {
              // Disable the on-canvas tooltip
              enabled: false,
              mode : 'index',
              intersect: false,
              position : 'nearest',
              yAlign: 'top',
              custom: function(tooltipModel) {
                  // Tooltip Element
                  var tooltipEl = document.getElementById('chartjs-tooltip');

                  // Create element on first render
                  if (!tooltipEl) {
                      tooltipEl = document.createElement('div');
                      tooltipEl.id = 'chartjs-tooltip';
                      // tooltipEl.innerHTML = '<div id="tooltip"></div>';
                      document.body.appendChild(tooltipEl);
                  }
                  // Hide if no tooltip
                  if (tooltipModel.opacity === 0) {
                      tooltipEl.style.opacity = 0;
                      return;
                  }

                  // Set caret Position
                  tooltipEl.classList.remove('above', 'below', 'no-transform');
                  if (tooltipModel.yAlign) {
                      tooltipEl.classList.add(tooltipModel.yAlign);
                      tooltipEl.classList.add('center');
                  } else {
                      tooltipEl.classList.add('no-transform');
                  }

                  function getBody(bodyItem) {
                      return bodyItem.lines;
                  }

                  // Set Text
                  if (tooltipModel.body) {
                      var titleLines = tooltipModel.title || [];
                      var bodyLines = tooltipModel.body.map(getBody);

                      var innerHtml = '';
                      titleLines.forEach(function(title) {                      
                          innerHtml += '<div class="title">' +title + '</div>';
                      });

                      innerHtml += '<div class="body">';

                      bodyLines.forEach(function(body, i) {                      	
                        var colors = '#0000';
                        var style = 'border-bottom: 2px solid rgba(76, 110, 245, 0.5)';
                        if($('#breakdown_btn').hasClass('active')) {
                          if(i == 0) {
                            label = "Previous Net Revenue";
                            style = 'border-bottom: 2px solid rgba(253,126,20,1)';
                          }else if(i == 1) {
                            label = "Net Sales";
                            style = 'border-bottom: 2px solid rgba(76, 110, 245, 1)';
                          }else if(i == 2) {
                            label = "Gross Sales";
                            style = 'border-bottom: 2px solid rgba(55, 178, 77, 1)';
                          }else if(i == 3) {
                            label = "Refunds";
                            style = 'border-bottom: 2px solid rgba(250, 82, 82, 1)';
                          }else if(i == 4) {
                            label = "Taxes";
                            style = 'border-bottom: 2px solid rgba(250, 176, 5, 1)';
                          }else if(i == 5) {
                            label = "Shipping";
                            style = 'border-bottom: 2px solid rgba(132, 94, 247, 1)';
                          }else if(i == 6) {
                            label = "Fees";
                            style = 'border-bottom: 2px solid rgba(230, 73, 128, 1)';
                          }else if(i == 7) {
                            label = "Discounts";
                            style = 'border-bottom: 2px solid rgba(230, 73, 128, 1)';
                          }else if(i == 8) {
                            label = "Orders";
                            style = 'border-bottom: 2px solid rgba(204, 218, 234, 1)';
                          }else if(i == 9) {
                            label = "Items";
                            style = 'border-bottom: 2px solid rgba(204, 218, 234, 0.7)';
                          }
                        }else{
                        	 if(i == 0) {
                            label = "Previous Net Revenue";
                            style = 'border-bottom: 2px solid rgba(253,126,20,1)';
                          }else if(i == 1) {
                            label = "Net Sales";
                            style = 'border-bottom: 2px solid rgba(76, 110, 245, 1)';
                          }else if(i == 2) {
                            label = "Orders";
                            style = 'border-bottom: 2px solid rgba(204, 218, 234, 1)';
                          }else if(i ==3) {
                            label = "Items";
                            style = 'border-bottom: 2px solid rgba(204, 218, 234, 0.7)';
                          }
                        }

                        if(!(label=="Orders" || label=='Items')){
                        	body=(Math.round(body*100)/100).toFixed(2).toLocaleString();
                       
	                          if(body<0){
	                            body=body.replace("-","");
	                            body="("+body+')';
	                          }
	                        body=currency+body;  

                        }
                         

                          
                        
                        
                        var spanLabel = '<div class="line-label pdt-popover">' +  label+'</div>';
                        var spanValue = '<div class="amount">'+body+'</div>';
                        innerHtml += '<div class="line" style="'+style+'">'+ spanLabel + spanValue + '</div>';
                      });
                      innerHtml += '</div>';

                      tooltipEl.innerHTML = innerHtml;
                  }

                  // `this` will be the overall tooltip
                  var position = this._chart.canvas.getBoundingClientRect();
                  
                  // Display, position, and set styles for font
                  tooltipEl.style.opacity = 1;
                  tooltipEl.style.width = 'auto';
                  // tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                  tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX - 50+ 'px';
                  tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY - 100+ 'px';
              }
            },
            legend: {
              display: false
            },
            elements: {
              rectangle: {
                borderWidth: 2,
                // borderColor: 'rgb(0, 255, 0)',
                borderSkipped: 'bottom'
              }
            },
            responsive: true,
            title: {
              display: false,
            },
            scales: {
              xAxes: [{
                display:true,
                stacked: true,
                gridLines : {
                  display : false
                },
                // type: 'time',
                // time: {
                //   unit: unit,
                //   stepSize: unitSize,
                //   displayFormats: displayFormats
                // },
                ticks: {
                  fontColor:"#bbb",
                  maxRotation:0,
                  maxTicksLimit:9,
                  callback: function(value, index, values) {                    
                    return moment(value).format(displayFormats[unit]);
                  } 
                  // beginAtZero: true,
                  // callback: function(value, index, values) {
                  //   return value;
                  // },
                  // stepSize: 120
                },
              }],
               yAxes: [{
                stacked: true,
                position: "left",
                ticks: {
                  beginAtZero: true,
                  maxTicksLimit:4,
                  callback: function(value, index, values) {
                    return '$' + value;
                  },
                  // stepSize: stepSize_revenue
                },
                id: "y-axis-0",
              }, {
                stacked: true,
                position: "right",
                gridLines : {
                  display : false
                },
                ticks: {
                  beginAtZero: true,
                  maxTicksLimit:7,
                  callback: function(value, index, values) {
                    return value;
                  },
                  // stepSize: stepSize_sold
                },
                id: "y-axis-1",
              }]
            }
          }
        });
      }else{
        $('#no-chart-data').removeClass('hide_c');
        $('#chart-data').addClass('hide_c');
      }
    };


				
   function createChartItem(data_click, labelData, unit, data_to_show, chart_type) {
   	console.log(data_click);

     // if(data_click.length > 0) {
        var displayFormats = {
          quarter: "MMM YYYY",
          month: "MMM ' YY",
          week: "MMM D",
          day: "MMM D",
          hour: "MMM D - hA"
        };
        labelData=[];
        unit='';
        var data_revenue  = [], data_order_count  = [],data_items_count  = [], data_sold  = [], data_refunds  = [], data_discounts  = [], data_taxes  = [], data_shipping  = [], data_fees  = [],data_previous  = [], label  = [], datasets = [];
     
        for(let x= 0; x < data_click.length; x++) {
          data_revenue.push(data_click[x].order_count);
          labelData.push(data_click[x].order_item_count);        
        }
       

        var unitSize = 4;
                  

         datasets.push({
              type: "bar",
              data: data_revenue,             
              fill:true,
              backgroundColor:'rgba(76, 110, 245, 1)',
              pointHoverBackgroundColor:'rgba(76, 110, 245, 1)',       
            
              pointHoverBorderColor: 'rgba(76, 110, 245, 1)',
              borderColor:'rgba(76, 110, 245, 1)'
          });


        var lineChartData = {
          labels: labelData,
          datasets: datasets
        };

        var ctx = document.getElementById("chart-chart_item_count");
        if (window.myBar1) {
          window.myBar1.destroy();
        }
       
        Chart.defaults.global.elements.point.radius = 0
        Chart.Tooltip.positioners.custom = function(elements, eventPosition) { //<-- custom is now the new option for the tooltip position
            /** @type {Chart.Tooltip} */
            var tooltip = this;
            return {
                x: eventPosition.x,
                y: eventPosition.y
            };
        }
        window.myBar1 = new Chart(ctx, {
          type: 'bar',
          data: lineChartData,
          options: {
            tooltips: {
              // Disable the on-canvas tooltip
              enabled: false,
              mode : 'index',
              intersect: false,
              position : 'nearest',
              yAlign: 'top',
              custom: function(tooltipModel) {
                  // Tooltip Element
                  var tooltipEl = document.getElementById('chartjs-tooltip');

                  // Create element on first render
                  if (!tooltipEl) {
                      tooltipEl = document.createElement('div');
                      tooltipEl.id = 'chartjs-tooltip';
                      // tooltipEl.innerHTML = '<div id="tooltip"></div>';
                      document.body.appendChild(tooltipEl);
                  }
                  // Hide if no tooltip
                  if (tooltipModel.opacity === 0) {
                      tooltipEl.style.opacity = 0;
                      return;
                  }

                  // Set caret Position
                  tooltipEl.classList.remove('above', 'below', 'no-transform');
                  if (tooltipModel.yAlign) {
                      tooltipEl.classList.add(tooltipModel.yAlign);
                      tooltipEl.classList.add('center');
                  } else {
                      tooltipEl.classList.add('no-transform');
                  }

                  function getBody(bodyItem) {
                      return bodyItem.lines;
                  }

                  // Set Text
                  if (tooltipModel.body) {
                      var titleLines = tooltipModel.title || [];
                      var bodyLines = tooltipModel.body.map(getBody);

                      var innerHtml = '';
                      titleLines.forEach(function(title) {                      
                          innerHtml += '<div class="title">' +title + '</div>';
                      });

                      innerHtml += '<div class="body">';

                      bodyLines.forEach(function(body, i) {                      	
                        var colors = '#0000';
                        var style = 'border-bottom: 2px solid rgba(76, 110, 245, 0.5)';
                        label = "Orders";         
                   		var spanLabel = '<div class="line-label pdt-popover">' +  label+'</div>';
                        var spanValue = '<div class="amount">'+body+'</div>';
                        innerHtml += '<div class="line" style="'+style+'">'+ spanLabel + spanValue + '</div>';
                      });
                      innerHtml += '</div>';

                      tooltipEl.innerHTML = innerHtml;
                  }

                  // `this` will be the overall tooltip
                  var position = this._chart.canvas.getBoundingClientRect();
                  
                  // Display, position, and set styles for font
                  tooltipEl.style.opacity = 1;
                  tooltipEl.style.width = 'auto';
                  // tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                  tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX - 50+ 'px';
                  tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY - 100+ 'px';
              }
            },
            legend: {
              display: false
            },
            elements: {
              rectangle: {
                borderWidth: 2,
                // borderColor: 'rgb(0, 255, 0)',
                borderSkipped: 'bottom'
              }
            },
            responsive: true,
            title: {
              display: false,
            },
            scales: {
              xAxes: [{
                display:true,
                stacked: true,
                gridLines : {
                  display : false
                },
                // type: 'time',
                // time: {
                //   unit: unit,
                //   stepSize: unitSize,
                //   displayFormats: displayFormats
                // },
                ticks: {
                  fontColor:"#bbb",
                  maxRotation:0,
                  maxTicksLimit:9,
                  callback: function(value, index, values) {                    
                    return value;
                  } 
                  // beginAtZero: true,
                  // callback: function(value, index, values) {
                  //   return value;
                  // },
                  // stepSize: 120
                },
              }],
               yAxes: [{
                stacked: true,
                position: "left",
                
                ticks: {
                  beginAtZero: true,
                   maxTicksLimit:4,
                  callback: function(value, index, values) {
                    return value;
                  },                 
                },
                
              }]
            }
          }
        });
     // }else{
       // $('#no-chart-data').removeClass('hide_c');
      //  $('#chart-data').addClass('hide_c');
     // }
    }; 

    function createChartOrder(data_click, labelData, unit, data_to_show, chart_type) {
   	console.log(data_click);

      //if(data_click.length > 0) {
        var displayFormats = {
          quarter: "MMM YYYY",
          month: "MMM ' YY",
          week: "MMM D",
          day: "MMM D",
          hour: "MMM D - hA"
        };
        labelData=[];
        unit='';
        var data_revenue  = [], data_order_count  = [],data_items_count  = [], data_sold  = [], data_refunds  = [], data_discounts  = [], data_taxes  = [], data_shipping  = [], data_fees  = [],data_previous  = [], label  = [], datasets = [];
     
        for(let x= 0; x < data_click.length; x++) {
          data_revenue.push(data_click[x].order_count);
          labelData.push(data_click[x].gross_sales);        
        }
       

        var unitSize = 4;
                  

         datasets.push({
              type: "bar",
              data: data_revenue,             
              fill:true,
              backgroundColor:'rgba(76, 110, 245, 1)',
              pointHoverBackgroundColor:'rgba(76, 110, 245, 1)',       
            
              pointHoverBorderColor: 'rgba(76, 110, 245, 1)',
              borderColor:'rgba(76, 110, 245, 1)'
          });


        var lineChartData = {
          labels: labelData,
          datasets: datasets
        };

        var ctx = document.getElementById("chart-chart_order_count");
        if (window.myBar2) {
          window.myBar2.destroy();
        }
       
        Chart.defaults.global.elements.point.radius = 0
        Chart.Tooltip.positioners.custom = function(elements, eventPosition) { //<-- custom is now the new option for the tooltip position
            /** @type {Chart.Tooltip} */
            var tooltip = this;
            return {
                x: eventPosition.x,
                y: eventPosition.y
            };
        }
        window.myBar2 = new Chart(ctx, {
          type: 'bar',
          data: lineChartData,
          options: {
            tooltips: {
              // Disable the on-canvas tooltip
              enabled: false,
              mode : 'index',
              intersect: false,
              position : 'nearest',
              yAlign: 'top',
              custom: function(tooltipModel) {
                  // Tooltip Element
                  var tooltipEl = document.getElementById('chartjs-tooltip');

                  // Create element on first render
                  if (!tooltipEl) {
                      tooltipEl = document.createElement('div');
                      tooltipEl.id = 'chartjs-tooltip';
                      // tooltipEl.innerHTML = '<div id="tooltip"></div>';
                      document.body.appendChild(tooltipEl);
                  }
                  // Hide if no tooltip
                  if (tooltipModel.opacity === 0) {
                      tooltipEl.style.opacity = 0;
                      return;
                  }

                  // Set caret Position
                  tooltipEl.classList.remove('above', 'below', 'no-transform');
                  if (tooltipModel.yAlign) {
                      tooltipEl.classList.add(tooltipModel.yAlign);
                      tooltipEl.classList.add('center');
                  } else {
                      tooltipEl.classList.add('no-transform');
                  }

                  function getBody(bodyItem) {
                      return bodyItem.lines;
                  }

                  // Set Text
                  if (tooltipModel.body) {
                      var titleLines = tooltipModel.title || [];
                      var bodyLines = tooltipModel.body.map(getBody);

                      var innerHtml = '';
                      titleLines.forEach(function(title) {                      
                          innerHtml += '<div class="title">' +title + '</div>';
                      });

                      innerHtml += '<div class="body">';

                      bodyLines.forEach(function(body, i) {                      	
                        var colors = '#0000';
                        var style = 'border-bottom: 2px solid rgba(76, 110, 245, 0.5)';
                        label = "Orders";         
                   		var spanLabel = '<div class="line-label pdt-popover">' +  label+'</div>';
                        var spanValue = '<div class="amount">'+body+'</div>';
                        innerHtml += '<div class="line" style="'+style+'">'+ spanLabel + spanValue + '</div>';
                      });
                      innerHtml += '</div>';

                      tooltipEl.innerHTML = innerHtml;
                  }

                  // `this` will be the overall tooltip
                  var position = this._chart.canvas.getBoundingClientRect();
                  
                  // Display, position, and set styles for font
                  tooltipEl.style.opacity = 1;
                  tooltipEl.style.width = 'auto';
                  // tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                  tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX - 50+ 'px';
                  tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY - 100+ 'px';
              }
            },
            legend: {
              display: false
            },
            elements: {
              rectangle: {
                borderWidth: 2,
                // borderColor: 'rgb(0, 255, 0)',
                borderSkipped: 'bottom'
              }
            },
            responsive: true,
            title: {
              display: false,
            },
            scales: {
              xAxes: [{
                display:true,
                stacked: true,
                gridLines : {
                  display : false
                },
                // type: 'time',
                // time: {
                //   unit: unit,
                //   stepSize: unitSize,
                //   displayFormats: displayFormats
                // },
                ticks: {
                  fontColor:"#bbb",
                  maxRotation:0,
                  maxTicksLimit:9,
                  callback: function(value, index, values) {  
                  	let val=value.split("-"); 
                  	let val1='$'+(Math.round(val[0]*100)/100).toFixed(2).toLocaleString();
                  	let val2='$'+(Math.round(val[1]*100)/100).toFixed(2).toLocaleString();
                  
	                      
                            
                    return val1+' - '+val2;
                  } 
                  // beginAtZero: true,
                   

                  // stepSize: 120
                },
              }],
               yAxes: [{
                stacked: true,
                position: "left",
                
                ticks: {
                	 maxTicksLimit:4,
                  beginAtZero: true,
                  callback: function(value, index, values) {
                    return value;
                  },                 
                },
                
              }]
            }
          }
        });
     // }else{
       // $('#no-chart-data').removeClass('hide_c');
      //  $('#chart-data').addClass('hide_c');
      //}
    };

    function createChartSpendByDay(data_click, labelData, unit, data_to_show, chart_type) {
   	console.log(data_click);

     // if(data_click.length > 0) {
       
        labelData=[];
        unit='';
        var data_revenue  = [], data_order_count  = [], datasets = [];
     
        for(let x= 0; x < data_click.length; x++) {
          data_revenue.push(data_click[x].gross_sales);
          data_order_count.push(data_click[x].order_count);
          labelData.push(data_click[x].date_created);        
        }
       

        var unitSize = 7;
                  

         datasets.push({
              type: "bar",
              data: data_revenue,             
              fill:true,
              backgroundColor:'rgba(76, 110, 245, 1)',
              pointHoverBackgroundColor:'rgba(76, 110, 245, 1)',      
              yAxisID: 'y-axis-0',
              pointHoverBorderColor: 'rgba(76, 110, 245, 1)',
              borderColor:'rgba(76, 110, 245, 1)'
          });

          datasets.push({
              type: "bar",
              data: data_order_count,             
              fill:true,      
               yAxisID: 'y-axis-1',
              backgroundColor:'rgba(204, 218, 234, 1)',
              pointBorderColor:'rgba(204, 218, 234, 1)',
              pointBackgroundColor:'rgba(204, 218, 234, 1)',
              backgroundColor:'rgba(204, 218, 234, 1)',
              borderColor:'rgba(204, 218, 234, 1)'
          });


        var lineChartData = {
          labels: labelData,
          datasets: datasets
        };

        var ctx = document.getElementById("chart-chart_spend_by_day");
        if (window.myBar3) {
          window.myBar3.destroy();
        }
       
        Chart.defaults.global.elements.point.radius = 0
        Chart.Tooltip.positioners.custom = function(elements, eventPosition) { //<-- custom is now the new option for the tooltip position
            /** @type {Chart.Tooltip} */
            var tooltip = this;
            return {
                x: eventPosition.x,
                y: eventPosition.y
            };
        }
        window.myBar3 = new Chart(ctx, {
          type: 'bar',
          data: lineChartData,
          options: {
            tooltips: {
              // Disable the on-canvas tooltip
              enabled: false,
              mode : 'index',
              intersect: false,
              position : 'nearest',
              yAlign: 'top',
              custom: function(tooltipModel) {
                  // Tooltip Element
                  var tooltipEl = document.getElementById('chartjs-tooltip');

                  // Create element on first render
                  if (!tooltipEl) {
                      tooltipEl = document.createElement('div');
                      tooltipEl.id = 'chartjs-tooltip';
                      // tooltipEl.innerHTML = '<div id="tooltip"></div>';
                      document.body.appendChild(tooltipEl);
                  }
                  // Hide if no tooltip
                  if (tooltipModel.opacity === 0) {
                      tooltipEl.style.opacity = 0;
                      return;
                  }

                  // Set caret Position
                  tooltipEl.classList.remove('above', 'below', 'no-transform');
                  if (tooltipModel.yAlign) {
                      tooltipEl.classList.add(tooltipModel.yAlign);
                      tooltipEl.classList.add('center');
                  } else {
                      tooltipEl.classList.add('no-transform');
                  }

                  function getBody(bodyItem) {
                      return bodyItem.lines;
                  }

                  // Set Text
                  if (tooltipModel.body) {
                      var titleLines = tooltipModel.title || [];
                      var bodyLines = tooltipModel.body.map(getBody);

                      var innerHtml = '';
                      titleLines.forEach(function(title) {                      
                          innerHtml += '<div class="title">' +title + '</div>';
                      });

                      innerHtml += '<div class="body">';

                      bodyLines.forEach(function(body, i) {                      	
                        var colors = '#0000';
                        var style = 'border-bottom: 2px solid rgba(204, 218, 234, 1)';
                        label = "Orders"; 

                      if(i ==0) { 
                        label = "Gross Sales";
                        style = 'border-bottom: 2px solid rgba(76, 110, 245, 1)';
                      }
                       if(!(label=="Orders" || label=='Items')){
                        	body=(Math.round(body*100)/100).toFixed(2).toLocaleString();
                       
	                          if(body<0){
	                            body=body.replace("-","");
	                            body="("+body+')';
	                          }
	                        body=currency+body;  

                        }

                   		var spanLabel = '<div class="line-label pdt-popover">' +  label+'</div>';
                        var spanValue = '<div class="amount">'+body+'</div>';
                        innerHtml += '<div class="line" style="'+style+'">'+ spanLabel + spanValue + '</div>';
                      });
                      innerHtml += '</div>';

                      tooltipEl.innerHTML = innerHtml;
                  }

                  // `this` will be the overall tooltip
                  var position = this._chart.canvas.getBoundingClientRect();
                  
                  // Display, position, and set styles for font
                  tooltipEl.style.opacity = 1;
                  tooltipEl.style.width = 'auto';
                  // tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                  tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX - 50+ 'px';
                  tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY - 100+ 'px';
              }
            },
            legend: {
              display: false
            },
            elements: {
              rectangle: {
                borderWidth: 2,
                // borderColor: 'rgb(0, 255, 0)',
                borderSkipped: 'bottom'
              }
            },
            responsive: true,
            title: {
              display: false,
            },
            scales: {
              xAxes: [{
                display:true,
                stacked: false,
                gridLines : {
                  display : false
                },
                // type: 'time',
                // time: {
                //   unit: unit,
                //   stepSize: unitSize,
                //   displayFormats: displayFormats
                // },
                ticks: {
                  fontColor:"#bbb",
                  maxRotation:0,
                  maxTicksLimit:9,
                  callback: function(value, index, values) {                    
                      return moment(value).format('dddd');
                  } 
                  // beginAtZero: true,
                  // callback: function(value, index, values) {
                  //   return value;
                  // },
                  // stepSize: 120
                },
              }],
                yAxes: [{
                stacked: false,
                position: "left",
                ticks: {
                  beginAtZero: true,
                   maxTicksLimit:4,
                  callback: function(value, index, values) {
                    return '$' + value;
                  },
                  // stepSize: stepSize_revenue
                },
                id: "y-axis-0",
              }, {
                stacked: false,
                position: "right",
                gridLines : {
                  display : false
                },
                ticks: {
                  beginAtZero: true,
                   maxTicksLimit:4,
                  callback: function(value, index, values) {
                    return value;
                  },
                  // stepSize: stepSize_sold
                },
                id: "y-axis-1",
              }]
            }
          }
        });
      //}else{
       // $('#no-chart-data').removeClass('hide_c');
       // $('#chart-data').addClass('hide_c');
      //}
    };

              


 function createChartSpendByHour(data_click, labelData, unit, data_to_show, chart_type) {
    //  if(data_click.length > 0) {
      
       var data_revenue  = [], data_order_count  = [], datasets = [];
     
        for(let x= 0; x < data_click.length; x++) {
          data_revenue.push(data_click[x].gross_sales);         
          data_order_count.push(data_click[x].order_item_count);         
          labelData.push(data_click[x].date_created);        
        }             
      

          datasets.push({
              type: "line",
              data: data_revenue,
              yAxisID: 'y-axis-0',
              fill:false,
              backgroundColor:'rgba(76, 110, 245, 1)',
              pointHoverBackgroundColor:'rgba(76, 110, 245, 1)',
              lineTension:0,
              borderWidth:4,
              pointHoverBorderWidth:0.5,
              pointHoverRadius:5,
              pointHoverBorderColor: 'rgba(76, 110, 245, 1)',
              borderColor:'rgba(76, 110, 245, 1)',
          });


          datasets.push({
              type: "bar",
              data: data_order_count,             
              fill:true,      
               yAxisID: 'y-axis-1',
              backgroundColor:'rgba(204, 218, 234, 1)',
              pointBorderColor:'rgba(204, 218, 234, 1)',
              pointBackgroundColor:'rgba(204, 218, 234, 1)',
              backgroundColor:'rgba(204, 218, 234, 1)',
              borderColor:'rgba(204, 218, 234, 1)'
          });

   

        var lineChartData = {
          labels: labelData,
          datasets: datasets
        };

        var ctx = document.getElementById("chart-chart_spend_by_hour");
        if (window.myBar4) {
          window.myBar4.destroy();
        }
        $('#no-chart-data').addClass('hide_c');
        $('#chart-data').removeClass('hide_c');
        Chart.defaults.global.elements.point.radius = 0
        Chart.Tooltip.positioners.custom = function(elements, eventPosition) { //<-- custom is now the new option for the tooltip position
            /** @type {Chart.Tooltip} */
            var tooltip = this;
            return {
                x: eventPosition.x,
                y: eventPosition.y
            };
        }
        window.myBar4 = new Chart(ctx, {
          type: 'bar',
          data: lineChartData,
          options: {
            tooltips: {
              // Disable the on-canvas tooltip
              enabled: false,
              mode : 'index',
              intersect: false,
              position : 'nearest',
              yAlign: 'top',
              custom: function(tooltipModel) {
                  // Tooltip Element
                  var tooltipEl = document.getElementById('chartjs-tooltip');

                  // Create element on first render
                  if (!tooltipEl) {
                      tooltipEl = document.createElement('div');
                      tooltipEl.id = 'chartjs-tooltip';
                      // tooltipEl.innerHTML = '<div id="tooltip"></div>';
                      document.body.appendChild(tooltipEl);
                  }
                  // Hide if no tooltip
                  if (tooltipModel.opacity === 0) {
                      tooltipEl.style.opacity = 0;
                      return;
                  }

                  // Set caret Position
                  tooltipEl.classList.remove('above', 'below', 'no-transform');
                  if (tooltipModel.yAlign) {
                      tooltipEl.classList.add(tooltipModel.yAlign);
                      tooltipEl.classList.add('center');
                  } else {
                      tooltipEl.classList.add('no-transform');
                  }

                  function getBody(bodyItem) {
                      return bodyItem.lines;
                  }

                  // Set Text
                  if (tooltipModel.body) {
                      var titleLines = tooltipModel.title || [];
                      var bodyLines = tooltipModel.body.map(getBody);

                      var innerHtml = '';
                      titleLines.forEach(function(title) {                      
                          innerHtml += '<div class="title">' +title + '</div>';
                      });

                      innerHtml += '<div class="body">';

                      bodyLines.forEach(function(body, i) {                      	
                        var colors = '#0000';
                        var style = 'border-bottom: 2px solid rgba(204, 218, 234, 1)';
                        label = "Orders"; 

                      if(i ==0) { 
                        label = "Gross Sales";
                        style = 'border-bottom: 2px solid rgba(76, 110, 245, 1)';
                      }
                       if(!(label=="Orders" || label=='Items')){
                        	body=(Math.round(body*100)/100).toFixed(2).toLocaleString();
                       
	                          if(body<0){
	                            body=body.replace("-","");
	                            body="("+body+')';
	                          }
	                        body=currency+body;  

                        }

                          
                        
                        
                        var spanLabel = '<div class="line-label pdt-popover">' +  label+'</div>';
                        var spanValue = '<div class="amount">'+body+'</div>';
                        innerHtml += '<div class="line" style="'+style+'">'+ spanLabel + spanValue + '</div>';
                      });
                      innerHtml += '</div>';

                      tooltipEl.innerHTML = innerHtml;
                  }

                  // `this` will be the overall tooltip
                  var position = this._chart.canvas.getBoundingClientRect();
                  
                  // Display, position, and set styles for font
                  tooltipEl.style.opacity = 1;
                  tooltipEl.style.width = 'auto';
                  // tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                  tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX - 50+ 'px';
                  tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY - 100+ 'px';
              }
            },
            legend: {
              display: false
            },
            elements: {
              rectangle: {
                borderWidth: 2,
                // borderColor: 'rgb(0, 255, 0)',
                borderSkipped: 'bottom'
              }
            },
            responsive: true,
            title: {
              display: false,
            },
            scales: {
              xAxes: [{
                display:true,
                stacked: true,
                gridLines : {
                  display : false
                },
                // type: 'time',
                // time: {
                //   unit: unit,
                //   stepSize: unitSize,
                //   displayFormats: displayFormats
                // },
                ticks: {
                  fontColor:"#bbb",
                  maxRotation:0,
                  maxTicksLimit:9,
                  callback: function(value, index, values) {                    
                    return moment(value).format('h A');
                  }                
                },
              }],
               yAxes: [{
                stacked: true,
                position: "left",
                ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                    return '$' + value;
                  },
                  // stepSize: stepSize_revenue
                },
                id: "y-axis-0",
              },{
                stacked: false,
                position: "right",
                gridLines : {
                  display : false
                },
                ticks: {
                  beginAtZero: true,
                   maxTicksLimit:4,
                  callback: function(value, index, values) {
                    return value;
                  },
                  // stepSize: stepSize_sold
                },
                id: "y-axis-1",
              }]
            }
          }
        });
      //}else{
       // $('#no-chart-data').removeClass('hide_c');
        //$('#chart-data').addClass('hide_c');
      //}
    };
