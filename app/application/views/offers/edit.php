<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Offertes
            <small>Bewerken</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-euro"></i> Home</a></li>
            <li><a href="/offers/offers">Offertes</a></li>
            <li class="active">Bewerken</li>
          </ol>
        </section> 



        <section class="content">

        	<div class="row">
	            <div class="col-xs-12">
		            <div class="box box-success">
		                <div class="box-header">
		                  <h3 class="box-title">Offerte &quot; <?=$offer->name?> &quot; bewerken</h3>
		                  <button class="btn btn-success pull-right">Opslaan</button>

		                   <?php
                        if($sended){
                      ?>
                          <br><br><div class="callout callout-success" onClick="javascript: jQuery('.callout').slideUp();" >
                            <h4>Offerte verzonden</h4>
                            <p>De offere is in het systeem aangemerkt als verzonden</p>
                          </div>
                      <?php
                        }
                       ?>


		                </div>


		               
					</div>
				</div>
			</div>


          <div class="row">

          	<div class="col-md-8">
          		<div class="box box-warning">
		            <div class="box-header">
		            	<h3 class="box-title">Offerte</h3>
		            </div>

		            <div class="box-body">

						<div class="offer_container" id="offer">
							<p>Offerte wordt geladen...</p>
						</div>

		            </div>
		        </div>

          	</div>

          	<div class="col-md-4">
          		<div class="box box-info">
		            <div class="box-header">
		            	<h3 class="box-title">Offerte regels</h3>
		            </div>

		            <div class="box-body">

						<?php
							foreach($categories as $cat_item){
								foreach($cat_item as $category => $key){
						?>

							<h4 class="box-title"><?=$category?></h4>
								<ol class="draggable offer_drag" id="drag_<?=$category?>">
									<?php
										foreach($key as $obj){
											foreach($obj as $line){?>

												<li line="<?=$line->id?>"><?=$line->name?></li>
									<?php
											}
										}
									?>
								</ol>

						<?php
								}
							}
						?>

		            </div>
		        </div>
		        <div class="box box-success">
		            <div class="box-header">
		            	<h3 class="box-title">Aanwezige offerte regels</h3>
		            </div>
		            <div class="box-body">
						<ul id="current_lines">
							<?php
								foreach($current_lines as $current_line){
							?>
								<li id='line_<?=$current_line->id?>' dbline='<?=$current_line->id?>'><span id="content_<?=$current_line->id?>"><?=$current_line->name?></span><i class='fa fa-remove pull-right removeBtn'></i><i class='fa fa-pencil pull-right editBtn'></i></li>
							<?php
								}
							?>
						</ul>
		            </div>
		        </div>

		        <div class="box box-primary">
		            <div class="box-header">
		            	<h3 class="box-title">Algemeen</h3>
		            </div>
		            <div class="box-body">
		            	<div class="form-group">
		                    <label>Klant</label>
		                    <input type="text" class="form-control" id="contact_name" placeholder="Klant" value="<?=$offer->contact_name?>" name="contact_name">
		                </div>

		                <div class="form-group">
		                    <label>Offerte naam</label>
		                    <input type="text" class="form-control" placeholder="Offerte naam" value="<?=$offer->name?>" name="name">
		                </div>

		                <div class="form-group">
		                    <label>Verval datum</label>
		                    <div class="input-group">
	                     		 <div class="input-group-addon">
	                     		   <i class="fa fa-calendar"></i>
	                     		 </div>
	                     		 <input type="text" class="form-control pull-right" id="expiration_date" name="expiration_date">
	                    	</div>
	                  	</div>


						<a href="/offers/offers/pdf/<?=$offer_id?>" target="_blank" class="btn btn-primary">Download offerte</a>
						<button class="btn btn-success pull-right">Opslaan</button>

						<?php
							if($offer->offer_status == (int)0){
						?>

							<button class="btn btn-warning pull-right pull-alittleright" onClick="javascript: offerSended()">Offerte verzonden</button>

						<?php
						}
						if ($offer->offer_status == (int)1){

						?>

							<button class="btn btn-warning pull-right pull-alittleright" onClick="javascript: approveOffer()">Offerte doorzetten</button>

						<?php
						}
						?>
						
						
		            </div>
		        </div>


          	</div>


          </div>
        </section>
    </div>




<script type="text/javascript">
jQuery(document).ready(function(){

	var options = {
	  url: function(dataStr){
	  	return "/offers/offers/contactAjax/" + dataStr;
	  },
	  getValue: "name",
	  list: {	
	    match: {
	      enabled: true
	    }
	  }			 
	};

	jQuery("#contact_name").easyAutocomplete(options);


	jQuery( ".draggable li" ).draggable({
		revert: true ,
		opacity: 0.7
	});

	jQuery( "#offer" ).droppable({
		hoverClass: "drop-hover",
	    drop: function( event, ui ) {
	    	addLineToDb(event, ui);


	    }
	});

	jQuery( "#current_lines" ).sortable({
		stop: function(event, ui) {
			postdata = jQuery( "#current_lines" ).sortable('serialize');
			jQuery.ajax({
				url: "/offers/offers/setOfferLinesPriority",
				data: postdata,
				method: "POST",
				success: function(result){
					generatePreview();
				}
			});
	 	}
	 });
	jQuery(".removeBtn").click(function(){
		line_id = jQuery(this).parent().attr('dbline');
		showPopup('Verwijderen', 'Weet u zeker dat u deze offerte regel wilt verwijderen?', 'Ja', 'Nee', '', '', "javascript: deleteLine('"+line_id+"');");

	});
	jQuery(".editBtn").click(function(){
		line_id = jQuery(this).parent().attr('dbline');
		editLine(line_id);
			});
	jQuery('#expiration_date').daterangepicker({
							timePicker: false,
							timePickerIncrement: 14,
							showDropdowns: true,
							singleDatePicker: true,
							format: 'DD-MM-YYYY'});
	generatePreview();
});

function addLineToDb(event, ui){
	jQuery("#offer").css('opacity', '0.5');
	jQuery("#current_lines").addClass('waiting');
	var offer_id = '<?=$offer_id?>';
	var line_id =  ui.draggable.attr('line');
	jQuery.ajax({
		url: "/offers/offers/addOfferLine/" + line_id + "/" + offer_id,
		success: function(result){
        	jQuery("#current_lines").html(jQuery("#current_lines").html() + "<li id='line_"+result+"' dbline='"+result+"'><span id='content_"+result+"'>" + ui.draggable.html() + "</span><i class='fa fa-close pull-right removeBtn'></i><i class='fa fa-pencil pull-right editBtn'></i></li>").removeClass('waiting');
        	generatePreview();

        	jQuery(".removeBtn").click(function(){
				line_id = jQuery(this).parent().attr('dbline');
				showPopup('Verwijderen', 'Weet u zeker dat u deze offerte regel wilt verwijderen?', 'Ja', 'Nee', '', '', "javascript: deleteLine('"+line_id+"');");
			});

			jQuery(".editBtn").click(function(){
				line_id = jQuery(this).parent().attr('dbline');
				editLine(line_id);
			});
    }});
}

function deleteLine(f_line){
	jQuery("#offer").css('opacity', '0.5');
	jQuery.ajax({
		url: "/offers/offers/removeOfferLine/" + line_id,
		success: function(result){
			jQuery("#line_" + f_line).slideUp();
			jQuery(".modal").fadeOut();
			generatePreview();
		}
	});
}

function generatePreview(){
	jQuery("#offer").css('opacity', '0.5');
	var offer_id = '<?=$offer_id?>';
	jQuery.ajax({
		url: "/offers/offers/generatePreview/" + offer_id,
		success: function(result){
        	jQuery("#offer").html(result);
        	jQuery("#offer").css('opacity', '1');
    }});
}

var editFrm = '';

function editLine(f_line){
	jQuery.ajax({
		url: "/offers/offers/getOfferLineEditFrm/" + f_line,
		success: function(result){

			showPopup('Offerte regel bewerken', '</p>'+result+'<p>', '', '', 'Sluiten', 'Opslaan', "javascript: saveOfferLineFrm();");
			jQuery(".textarea").wysihtml5();
			jQuery('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
	          checkboxClass: 'icheckbox_flat-green',
	          radioClass: 'icheckbox_flat-green-blue'
	        });
		}
	});
}


function saveOfferLineFrm(){
	jQuery.ajax({
		url: '/offers/offers/saveOfferLine',
		data: jQuery("#editLineFrm").serialize(),
		type: 'POST',
		success: function(){
			var curr_id = jQuery("#curr_offer_line").val();
			jQuery("#content_" + curr_id).html(jQuery("#changedName").val());
			generatePreview();
			jQuery(".modal").fadeOut();
		}
	});
}

	function approveOffer(){
		showPopup('Offerte doorzetten', 'Weet u zeker dat u deze offerte wilt doorzetten als project?<br><br><b>Klant:</b><?=addslashes($offer->contact_name)?><br><b>Offerte:</b><?=addslashes($offer->name)?>', '', 'Nee', '', 'Ja', "javascript: setApproveOffer();");
	}

	function setApproveOffer(){
		jQuery.ajax({
			type: 'GET',
			url: '/offers/offers/offerApprove/<?=$offer->id?>',
			success: function(r_data){
				window.location.href = '/projectsm/projectsm/edit/' + r_data;
			}
		});
	}

	function offerSended(){
		showPopup('Offerte verzonden?', 'Weet u zeker dat u deze offerte heeft verzonden?<br><br><b>Klant:</b><?=addslashes($offer->contact_name)?><br><b>Offerte:</b><?=addslashes($offer->name)?>', '', 'Nee', '', 'Ja', "javascript:  setOfferSended();");
	}

	function setOfferSended(){
		jQuery.ajax({
			url: '/offers/offers/offerSended/<?=$offer->id?>',
			type: 'GET',
			success: function(r_data){
				window.location.href=window.location.href.replace('?saved=1', '')  + "?sended=1";
			}
		});
	}


</script>