(function ($) {
  'use strict';

  $(document).ready(function() {
    $('.js-date-range').daterangepicker();


   $(".date_from_now").each(function(){
      let date = $(this).data('date');      
      $(this).html(moment(date).fromNow());     
   });

   $(".date_from_now_order").each(function(){
      let date = $(this).data('date');      
      $(this).html(moment(date).fromNow());   
      $(this).data('content',moment(date).calendar(null,{
        sameElse: 'LL [at] LT'
      }));    
      $(this).attr('data-content',moment(date).calendar(null,{
        sameElse: 'LL [at] LT'
      }));    
   });
   $('[data-toggle="popover"]').popover(); 

   $(".date_calendar").each(function(){
      let date = $(this).data('date');      
      $(this).html(moment(date).calendar(null,{
        sameElse: 'LL [at] LT'
      }));     
   });


    $('.js-date-custom-ranges').daterangepicker({    
      minDate:moment(store_start_date),
      maxDate:moment(),
      showDropdowns: true, 
      locale: {
        format: 'MMM DD, YYYY'
      } ,   
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        // 'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Year To Date': [moment().startOf('year'), moment()],
         'Last 7 Days': [moment().subtract(7, 'days'),moment()],
         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
         'Last 6 Months': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],    
          'All Time': [moment(store_start_date), moment()]
      },

    });    
 
    });


})(jQuery);