function showPopup(f_title, f_body, f_yes, f_no, f_cancel, f_ok, f_link){

    jQuery("#modalBox .modal-title").html(f_title);
    jQuery("#modalBox .modal-body").html('<p>' + f_body + '</p>');
	
	jQuery(".repairBtn").each(function(){
		jQuery(this).css('display', 'inline-block');
	});

    if(f_yes != ''){
      jQuery('#modalBox .yesBtn').html(f_yes);
    } else {
        jQuery('#modalBox .yesBtn').css('display' , 'none');
    }

    if(f_no != ''){
      jQuery('#modalBox .noBtn').html(f_no);
    } else {
      jQuery('#modalBox .noBtn').css('display' , 'none');
    }

    if(f_cancel != ''){
      jQuery('#modalBox .cancelBtn').html(f_cancel);
    } else {
        jQuery('#modalBox .cancelBtn').css('display' , 'none');
    }

    if(f_ok != ''){
      jQuery('#modalBox .okBtn').html(f_ok);
    } else {
        jQuery('#modalBox .okBtn').css('display' , 'none');
    }

    if(f_link != ''){
        jQuery('#modalBox .yesBtn, #modalBox .okBtn').click(function(){
          location.href = f_link;
        });
    } else {
        jQuery("#modalBox .modal-body").html(jQuery("#modalBox .modal-body").html() + '<i class="text text-danger">Er is geen link ingevuld!</i>');
    }

       jQuery("#modalBox").fadeIn();

}

jQuery(document).ready(function(){
  jQuery(".closeModal").click(function(){
     jQuery("#modalBox").fadeOut();
   });


    setTimeout( function(){
      jQuery(".callout").slideUp();
    }  , 3000 );
	
	jQuery(".sidebar-toggle").click(function(){
		jQuery.ajax({
			url: "/webapi/changemenustate" ,
			success: function(result){
			}
		});
	});
	
});
