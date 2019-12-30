
var CustomersearchStart='';
/*filter customer list*/
function filterdata(orderbyVal='', whereVal='', limit='',segments=[],page=1,gridview='default'){
	
	window.clearTimeout(CustomersearchStart);
	 CustomersearchStart = window.setTimeout(function () { 	 	
	 	let range_picker = $('#order_range').val();		
		$.ajax({
			url:site_url+'/products/product_group_list',
			type:'get',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },  
			success:function(data){			
				$('#product_groups_list').html(data.html);	
				let range_picker = $('#order_range').val();
				$.ajax({
					url:site_url+'/products/group_list_detail',
					type:'post',
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
					data:{
					 	groups: JSON.stringify(data.groups),
					 	range_picker:range_picker,
					},
					success:function(data){
						for (var index in data.groups) {
							$('#list-detail-'+data.groups[index].id).html(data.groups[index].view);
						}
						loadOrderData(data.groups, "group", "net");
					},error:function(e){
						console.log(e);
					}
				});
			},error:function(e){
				console.log(e);
			}
		})	
 	}, 1000);	
}

/*On click exports the chart detail csv*/
function export_product_chart_detail(){
	var href = window.location.href.split('?')[0];
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
				export_for:"group", 
				range_picker:range_picker,
				data:'text/csv;charset=utf-8',
			},
		success:function(data){
			var str = data;
			var uri = 'data:text/csv;charset=utf-8,' + str;
			$(".graph-loading").hide();
			var downloadLink = document.createElement("a");
			downloadLink.href = uri;
			downloadLink.download = downloadLink.download = "groups-sales-report-"+start_date+"-"+end_date+".csv";

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
function filterdata_detail(orderbyVal='', whereVal='', limit='', updateChart=false){
	var href = window.location.href.split('?')[0];
	var currentView = href.substring(href.lastIndexOf('/') + 1)
	var orderby ='';
	if($('#up').hasClass('ua-icon-arrow-down')){
		orderby = 'desc';
	}else{
		orderby = 'asc';
	}
	whereVal = $('#search_product').val();
	limit = $('#changelimit').val();
	chartby = $('#aBtnGroup').val();
	range_picker = $('#product_detail_range').val();
	compare_range_picker = $('#compare_date_datepicker_detail').val();
	$.ajax({
		url:site_url+'/product-groups/'+currentView,
		type:'post',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
		data:{orderby:orderby, whereVal:whereVal, limit:limit, chartby:chartby, range_picker:range_picker,compare_range_picker:compare_range_picker},
		success:function(data){	
			$(".graph-loading").hide();
			if(updateChart && data.chart) {
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

/*Get details of data based on range and compare range date picker*/
function getDetailData() {
	var href = window.location.href.split('?')[0],
	product_id = $('#product_ids').val(),
	range_picker = $('#product_detail_range').val();
	compare_range_picker = $('#compare_date_datepicker_detail').val();
	$('#compare_date_datepicker_detail_html').html(compare_range_picker)
	$.ajax({
		url:site_url+'/getDetailAcToDate',
		type:'POST',
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
		data:{product_id:product_id, range_picker:range_picker, compare_range_picker:compare_range_picker, detail_for:'group'},
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
			createChart(JSON.parse(data.chart), JSON.parse(data.label), data.unit);
			$('[data-toggle="popover"]').popover();
		},error:function(e){
			console.log("error", e);
		}
	})
}

$(function() {  

	
	filterdata();
	
    $(document).on('change', '#order_range', function(){
		var range_picker = $(this).val();
		filterdata('','', '');
	});

	$(document).on('click', ".openGroupModal", function(){
		$("#modal-settings").modal('show');	
	});

	$(document).on('click', ".delete_confirm", function(){
		var id = $('#id').val();
		$('.delete_confirm').addClass('is-loading');
		$('.delete_confirm').attr('disabled','disabled');
		$.ajax({
			url:site_url+"/products/product_group_delete",
			type:"post",
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
			data:{id:id},
			success: function(data){		            
				$('#delete_confirm').removeAttr('disabled');
				$('#delete_confirm').removeClass('is-loading');

				// $('#product_groups_list').html(data.html);             
				if(data.status){
					show_success_msg(data.msg);
					window.location = site_url+'/product-groups/';
				}else{
					show_error_msg(data.msg);
				}
				$("#modal-settings").modal('hide');	
			}
		});
	});
	
	// $(document).on('click', "#product_group_update_button_submit", function(){
	// 	actionForForm("save");	
	// });
	// $(document).on('click', "#product_group_update_button_confirm", function(){
	// 	actionForForm("delete_confirm");	
	// });

	$(document).on('click','#edit-button', function(){
		$("#products_lits").html('');
		$(".group-product-list li").each(function(){
			let id=$(this).data('id');
			let name=$(this).data('name');
			$("#products_lits").append('<div id="product_'+id+'" data-id="'+id+'" class="product product-child"><span class="name">'+name+'</span><a data-id="'+id+'" class="remove"><i  class="fa fa-times"></i></a><input type="hidden" name="productids[]" value="'+id+'"/></div>');
		});

		$("#name").val($("#group_title").data('name')).trigger('keyup');
		$("#product").trigger('change');

		$("#cancel-button").removeClass('hide_c');	
		$("#product-edit").removeClass('hide_c');	
		$("#product-list").addClass('hide_c');	
		$("#edit-button").addClass('hide_c');	
	});

	$(document).on('click','#cancel-button', function(){
		$("#edit-button").removeClass('hide_c');	
		$("#product-list").removeClass('hide_c');	
		$("#product-edit").addClass('hide_c');	
		$("#cancel-button").addClass('hide_c');	
	});

	$(document).on('click','#product_group_update_button_delete', function(){
		$("#product_group_update_button_delete").addClass('hide_c');
		$(".delete_confirm").removeClass('hide_c');
	});

	$(document).on('click', ".remove", function(){
		let id=$(this).data('id');
		$("#product_"+id).remove();
	});

	$(document).on('change', ".search_product_list", function(){
		let val=$(this).find("option:selected").val();
		
		if(val!='' && val!=undefined){			
			let str='<div id="product_'+$(this).find("option:selected").val()+'" data-id="'+$(this).find("option:selected").val()+'" class="product product-child"><span class="name">'+$(this).find("option:selected").text()+'</span><a data-id="'+$(this).find("option:selected").val()+'" class="remove"><i  class="fa fa-times"></i></a><input type="hidden" name="productids[]" value="'+$(this).find("option:selected").val()+'"/></div>';
			$("#products_lits").append(str);	
			$(this).val('').trigger('change');		
		}
		let child=$(".product-child").length;

    	if(parseFloat(child) > 0){
    		$('#product').removeClass('is-invalid');
			$('.product-group .is-invalid').hide();
    	}
		
	});

	$(".search_product_list").select2({		      
	  theme: 'default select_custom_hide_selected',
	  ajax: {
		    url: site_url+"/products/dropdownCustomer",
		    dataType: 'json',
		    delay: 0,
		    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
		    data: function (params) {
		      return {
		        q: params.term, // search term,
		        productids:$("input[name='productids[]']").map(function(){return $(this).val();}).get()
		      };
		    },
		    processResults: function (data) {		    
		      return {
		        results: data
		      };
		    },
		    cache: false
		  }
	});

	jQuery.validator.addMethod("atLeastOneProduct", function(value, element) {
		let child=$(".product-child").length;			
    	return (parseFloat(child) > 0);

	}, msg_atleast_one_product_must_be_selected);



	$('#product_group_update').validate({
		errorClass: "is-invalid",
		errorElement: "span",
		rules:{
			'name':{
				required:true,
				maxlength:200

			},
			'product': {
				atLeastOneProduct: true
				
			}			
		},
		submitHandler:function(event){			
		   $('#product_group_update_submit').addClass('is-loading');
		   $('#product_group_update_submit').attr('disabled','disabled');
			$.ajax({
		            url:site_url+"/products/product_group_update",
		            type:"post",
		            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
					data:$("#product_group_update").serialize(),
		            success: function(data){		            
		              $('#product_group_update_submit').removeAttr('disabled');
		              $('#product_group_update_submit').removeClass('is-loading');

		              if(data.status){
		              	show_success_msg(data.msg);
		              	filterdata(); 
		              	$("#name").val('');
		              	$("#products_lits").html('');
		              }else{
		              	show_error_msg(data.msg);
		              }
		              $("#modal-settings").modal('hide');	
		      }
		    });
		   return false;		
		}
	});


	$('#product_group_update_edit').validate({
		errorClass: "is-invalid",
		rules:{
			'name':{
				required:true,
				maxlength:200
			},
			'product': {
				atLeastOneProduct: true
				
			}			
		},
		submitHandler:function(event){
			var action = $('#product_group_update_button_submit').attr('data-action');
			var href = window.location.href.split('?')[0];
			var currentView = href.substring(href.lastIndexOf('/') + 1)
			if(action == "save") {
				$('#product_group_update_button_submit').addClass('is-loading');
				$('#product_group_update_button_submit').attr('disabled','disabled');
				$.ajax({
					url:site_url+"/products/product_group_update",
					type:"post",
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
					data:$("#product_group_update_edit").serialize(),
					success: function(data){		            
						$('#product_group_update_button_submit').removeAttr('disabled');
						$('#product_group_update_button_submit').removeClass('is-loading');
						if(data.status) {
							window.location = site_url+'/product-groups/'+currentView;
						}else{
							show_error_msg(data.msg);
						}

					}
				});
			}
		   return false;		
		}
	});



});


