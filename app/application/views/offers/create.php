<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Offertes
            <small>Aanmaken</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/dashboard/dashboard"><i class="fa fa-euro"></i> Home</a></li>
            <li><a href="/offers/offers">Offertes</a></li>
            <li class="active">Aanmaken</li>
          </ol>
        </section>
		<form method="post" name="offerFrm" id="offerFrm">
        <section class="content">
          <div class="row">
          	<div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Offerte aanmaken</h3>
                  <button class="btn btn-success pull-right" onClick="javascript: document.offerFrm.submit();">Verder</button>
                </div>
               </div>
              </div>
          </div>

			
		  	<div class="row">
		  		<div class="col-md-6">


		  			<div class="box box-info">
		  				<div class="box-header">
		  					<h3 class="box-title">Algemeen</h3>
		  				</div>

		  				<div class="box-body">
		  					
		  					<div class="form-group">
			                    <label>Klant</label>
			                    <input type="text" class="form-control" id="contact_name" placeholder="Klant" value="" name="contact_name">
			                </div>

			                <div class="form-group">
			                    <label>Offerte naam</label>
			                    <input type="text" class="form-control" placeholder="Offerte naam" value="" name="name">
			                </div>


		  				</div>
		  			</div>	


		  		</div>


		  		<div class="col-md-6">


		  			<div class="box box-warning">
						<div class="box-header">
		  					<h3 class="box-title">Data</h3>
		  				</div>
		  				<div class="box-body">
		  					<div class="form-group">
			                    <label>Verval datum</label>
			                    <div class="input-group">
		                     		 <div class="input-group-addon">
		                     		   <i class="fa fa-calendar"></i>
		                     		 </div>
		                     		 <input type="text" class="form-control pull-right" id="expiration_date" name="expiration_date">
		                    	</div>
		                  	</div>
				  		</div>
		  			</div>	
				
					<script type="text/javascript">
					jQuery(document).ready(function(){
						$('#expiration_date').daterangepicker({
							timePicker: false, 
							timePickerIncrement: 14, 
							showDropdowns: true,
							singleDatePicker: true,
							format: 'DD-MM-YYYY'});
					});
					</script>

		  		</div>
		  	</div>
		  	</div>



         </section>
     </form>
    </div>


    <script type="text/javascript">

    	jQuery(document).ready(function(){
    		var options = {

			  //url: "/offers/offers/contactAjax",

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

			$("#contact_name").easyAutocomplete(options);
    	});

    </script>