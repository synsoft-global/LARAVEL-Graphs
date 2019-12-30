(function ($) {
  'use strict';

  $(document).ready(function() {
    $('.SumoUnder').SumoSelect();
    $('#selectbox-ex2').SumoSelect();
    $('#selectbox-ex3').SumoSelect({
      okCancelInMulti: true
    });
    $('#selectbox-ex4').SumoSelect({
      selectAll: true
    });
  });
})(jQuery);
