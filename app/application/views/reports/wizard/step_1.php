<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Rapportages
            <small>Nieuw</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-area-chart"></i> Home</a></li>
            <li>Rapportages</li>
            <li class="active">Nieuw</li>
          </ol>
        </section>
		<form method="post" name="reportsFrm" id="reportsFrm">
        <section class="content">
          <div class="row">
          	<div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Rapportage aanmaken</h3>
                  <button class="btn btn-success pull-right" onClick="javascript: document.reportsFrm.submit();">Verder</button>
                </div>
               </div>
              </div>
          </div>

			
		  	<div class="row">
		  		<div class="col-md-12">


		  			<div class="box box-info">
		  				<div class="box-header">
		  					<h3 class="box-title">Algemeen</h3>
		  				</div>

		  				<div class="box-body">
		  					
		  					<div class="form-group col-md-6">
			                    <label>Klant</label>
			                    <input type="text" class="form-control" id="contact_name" placeholder="Klant" value="" name="contact_name">
			                </div>

			                <div class="form-group col-md-6">
			                    <label>Rapportage naam</label>
			                    <input type="text" class="form-control" placeholder="Rapportage naam" value="" name="name">
			                </div>


		  				</div>
		  			</div>	


		  		</div>


		  		
				
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