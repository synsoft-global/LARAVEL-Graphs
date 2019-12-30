/*For adding loading on the list page*/

$(document).on('change', '#order_range', function(){
    var range_picker = $(this).val();
	var dt1 = new Date(range_picker.split('-')[0]);
	var dt2 = new Date(range_picker.split('-')[1]);
	var DaysDiff1 = Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
	
	if(DaysDiff1 == 0) {
		$('#date-data').empty();
		$('#date-data').html('on '+ moment(dt1).format("MMMM DD, YYYY"));
	}else{
		$('#date-data').empty();
		$('#date-data').html('between <span  data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Change these dates from top right." data-tippy-placement="right" data-original-title="" class="tooltip-line"> '+  moment(dt1).format("MMMM DD, YYYY") +' and '+  moment(dt2).format("MMMM DD, YYYY")+'</span>');
		$('[data-toggle="popover"]').popover();
	}
   $('#order_refunds_date').html(moment(dt2).subtract(1,'days').format("MMMM DD, YYYY"));

	calculateCompareDateAcToRange("list");
    // document.getElementById('compare_date').value = compare_range;
	// $('#compare_date_html').html(compare_range);
	//filterdata('','', '');
});

	$(document).on('change', "#orderby_product_detail_group", function(){
	 	var orderbyVal = $(this).val();
	 	filterdata_detail(orderbyVal,'','',false);
	});
	
    $(document).on('click', ".compare_order_range_view_icon", function(e){	
    	e.preventDefault();
		$('#compare_date').trigger('click');
		return false;
	});

	$(document).on('click', ".order_range_view_icon", function(e){	
		$('#order_range').trigger('click');
		$('#product_detail_range').trigger('click');
	});

		/*on click calculates the compare date range based on range picker*/
	$(document).on('click','#date_comapare_list', function(){
		calculateCompareDateList($(this).val());
	});


	$(document).on('change', '#compare_date', function(){	
		filterdata('','', '');
	});

	$(document).on('change', '#product_detail_range', function(){
		// calculateCompareDate();
		calculateCompareDateAcToRange("detail");
	    // document.getElementById('compare_date_datepicker_detail').value = compare_range;
		// $('#compare_date_datepicker_detail_html').html(compare_range);
		getDetailData();	
	});

	$(document).on('change', '#compare_date_datepicker_detail', function(){
		getDetailData();	
	});

	$(document).on('change', '#compare_date', function(){
		document.getElementById('compare_date').value = $(this).val();
	});

	$(document).on('click', ".compare_order_range_view_icon", function(e){	
		$('#compare_date_datepicker_detail').trigger('click');
		$('#compare_date_datepicker').trigger('click');
	});

	/*on click clears the compare date*/
	$(document).on('click','#clear_compare', function(){
		// console.log(":D");
		// $('#clear_compare').val(true);
		// document.getElementById('compare_date').value = '';
		// $('compare_date_html').html(compare);
		// $('.adv-filter-search-bar').modal('hide');
		 $('.header-compare-button').trigger('click');		
		// filterdata('','', '','','','');
	})

	/*on click clears the compare date*/
	$(document).on('click','#clear_compare_detail', function(){
		// $('#clear_compare_detail').val(true);
		// var compare = $('#compare_date_datepicker_detail').val();
		// document.getElementById('compare_date_datepicker_detail').value = '';
		// $('compare_date_datepicker_detail_html').html(compare);
		// $('#modal-compare').modal('hide');
		// getDetailData();
	})


/*On click of button calculates the date range and calls the function for details*/
function calculateCompareDateList(selected_period) {
	
	var range_picker = $('#order_range').val();
	var dt1 = new Date(range_picker.split('-')[0]);
	var dt2 = new Date(range_picker.split('-')[1]);
	var start_date ='';
	var end_date ='';
	var range_picker_start = moment(dt1);
	var range_picker_end = moment(dt2);

	if(selected_period == "period") {
		var DaysDiff = Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));

		if(DaysDiff==0){
			end_date = moment(range_picker_start).subtract(1, 'days').format("MMM DD, YYYY");
			start_date = moment(range_picker_start).subtract(1, 'days').format("MMM DD, YYYY");
		}else{
			end_date = moment(range_picker_start).subtract(1, 'days').format("MMM DD, YYYY");
			start_date = moment(range_picker_start).subtract(DaysDiff, 'days').format("MMM DD,YYYY");
		}

		
		
	}


	else if(selected_period == "month") {
		start_date = moment(range_picker_start).subtract(1, 'months').format("MMM DD, YYYY");
		end_date = moment(range_picker_end).subtract(1, 'months').format("MMM DD, YYYY");
		
	}

	else if(selected_period == "week") {
		
		start_date = moment(range_picker_start).subtract(1, 'weeks').format("MMM DD, YYYY");
		end_date = moment(range_picker_end).subtract(1, 'weeks').format("MMM DD, YYYY");
		
	}else{
		start_date = moment(range_picker_start).subtract(1, 'years').format("MMM DD, YYYY");
		end_date = moment(range_picker_end).subtract(1, 'years').format("MMM DD, YYYY");
	}



	document.getElementById('compare_date').value = start_date+' - '+end_date;
	$('#compare_date_html').html(start_date+' - '+end_date);

	/*
	if(selected_period == "period") {
		subtract_day = 6;
	}else {
		subtract_day = 1;
	}

	if(selected_period == "period") {
		subtract_by = "days";
	}else {
		subtract_by = selected_period+'s';
	}

	
	
	var DaysDiff = Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));

	

	var start_date = moment(range_picker_start).subtract(subtract_day, subtract_by).format("MMM DD,YYYY");
	var end_date = moment(start_date).add(DaysDiff, 'days').format("MMM DD,YYYY");

	document.getElementById('compare_date').value = start_date+' - '+end_date;
	$('#compare_date_html').html(start_date+' - '+end_date);
	*/
	filterdata();
}

/*Calculates the date range based on selected  time period and calls the function get details accordingly */
function calculateCompareDateAcToRange(Compare_range_for="list") {

	if(Compare_range_for == "list") {
 		calculateCompareDateList('period');
	}else if(Compare_range_for == "detail") {
		calculateCompareDate('period');
	}	
}