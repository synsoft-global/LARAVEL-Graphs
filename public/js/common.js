/********User Profile js*********/
$('#updateProfile').validate({
	errorElement:'span',
	errorClass: "invalid-feedback",
	rules:{

		'first_name':{
			required:true,
		},
		'last_name':{
			required:true,
		},
		'email': { required: true, email:true },
	},
	submitHandler:function(form){
		form.submit();
		$("#profile_sbt_btn").addClass('is-loading');
        $("#profile_sbt_btn").attr('disabled', 'disabled');
	}
})


$('#updatePassword').validate({
	errorElement:'span',
	errorClass: "invalid-feedback",
	rules:{
		'old_password':{
			required:true,
			minlength:7,
		},
		'new_password': {
			required: true,
			minlength:7			
		},
		'con_password':{
			required: true,
			minlength:7,
			equalTo:'#new_password'
		}
	},
	submitHandler:function(form){
		form.submit();
		$("#submit_password_btn").addClass('is-loading');
        $("#submit_password_btn").attr('disabled', 'disabled');
	}
})

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#image').attr('src', e.target.result);
    }
    var file_data = input.files[0];
    var form_data = new FormData();  // Create a FormData object
    form_data.append('file', file_data);  // Append all element in FormData  object

    $.ajax({
            url         : site_url+'/updateProfile',     // point to server-side PHP script 
            dataType    : 'text',           // what to expect back from the PHP script, if anything
            cache       : false,
            contentType : false,
            processData : false,
            data        : form_data,                         
            type        : 'post',
			headers		: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },   
            success     : function(data){     	
			                var dataval = JSON.parse(data);
			                $('#image').val('');                     /* Clear the file container */
					        $('#image').attr('src', asset_url+'uploads/profile_img/'+dataval.img);
					        swal(dataval.message);
		    			  },
            error		: function(e){
				            console.log(e);
				          }
    });
    
    reader.readAsDataURL(input.files[0]);

  }
}

$("#imgInp").change(function() {
  readURL(this);
});

$('#login_form').validate({
	errorElement:'span',
	errorClass: "invalid-feedback",
	rules:{
		'password':{
			required:true,
			minlength: 7
		},
		'email': { required: true, email:true },
	},
	submitHandler:function(form){
		form.submit();
	}
});

$('#form_password').validate({
	errorElement:'span',
	errorClass: "invalid-feedback",
	rules:{		
		'email': { required: true, email:true },
	},
	submitHandler:function(form){
		form.submit();
	}
});



$(function() {
   $("img.lazy").lazyload();
   	setTimeout(function () {		
      $('.page-loading').show();
      document.getElementById("page_loading").setAttribute("style", "display:block;");
    }, 500);

});
var CustomersearchStart='';
var xhr='';
var ajax_inprocess = false;

$(document).on('keyup', "#search_global", function(e){
		if(e.keyCode==38){
			console.log("up");
		}
		else if(e.keyCode==40){
			console.log("down");
			console.log($(".search_global_result").find(".results").find('ul').find('li').length)			
		}else{
			let self=this;
			window.clearTimeout(CustomersearchStart);
			 CustomersearchStart = window.setTimeout(function () { 
			 	if (ajax_inprocess == true)
					{
					    xhr.abort();
					}

					$(".search_global_result").addClass('customer-js-loading');
					ajax_inprocess = true;
					xhr=$.ajax({
						url:site_url+'/dashboard/search_everything',
						type:'post',
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },    
						data:{search:$(self).val()},
						success:function(data){	
							if(data.status){			       
								$(".search_global_result").html(data.html);
								  $(".date_from_now_order").each(function(){
								      let date = $(self).data('date');      
								      $(self).html(moment(date).fromNow());   
								      $(self).data('content',moment(date).calendar(null,{
								        sameElse: 'LL [at] LT'
								      }));    
								      $(self).attr('data-content',moment(date).calendar(null,{
								        sameElse: 'LL [at] LT'
								      }));    
								   });
						 	}else{ 
				          		show_error_msg(data.msg);
				          	}
				          	ajax_inprocess = false;
				           	$(".search_global_result").removeClass('customer-js-loading');
						},error:function(e){
							if(e.statusText!="abort"){
								show_error_msg(msg_something_went_wrong);
							}
							$(".search_global_result").removeClass('customer-js-loading');
						}
					});
			}, 1000);
		}	


	
		
});





$(document).on('click', ".search_everything_more", function(){
	let resource=$(this).data('resource');	
	let search=$(this).data('search');		
	localStorage.setItem("search_"+resource, search);
	localStorage.setItem("search_everything", search);
	window.location = site_url+"/"+resource;		
});



$('#search_global').on('click', function (e) {
    e.stopPropagation();
   
    if ($(".global-search").find('.dropdown-menu').is(":hidden")){
	    $(".global-search").find('.dropdown-toggle').dropdown('show');
	    $(".global-search").find('.dropdown-menu').addClass('show');
	  }
});

$('body').on('click', function (e) {
    if (!$('#search_global').is(e.target) 
       
    ) {
    	
        $(".global-search").find('.dropdown-toggle').dropdown('hide');
    }
});


$(function () {
    $('#Decor ul')
        .hide(400)
        .parent()
        .prepend('<span class="icon plus"></span>');
    $('#Decor li').on('click', function (e) {
        e.stopPropagation();
        $(this).children('ul').slideToggle('slow', function () {
            if ($(e.target).is("span")) {
                $(e.target)
                    .toggleClass('minus', $(this).is(':visible'));                        
            }
            else {
                $(e.target).children('span')
                    .toggleClass('minus', $(this).is(':visible'));                        
            }
        });
    });
    $('#Decor a').not('[href="#"]').attr('target', '_blank');
});