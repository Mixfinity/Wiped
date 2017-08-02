<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Rapportages
            <small>Stap 2</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-area-chart"></i> Home</a></li>
            <li>Rapportages</li>
            <li class="active">Stap 2</li>
          </ol>
        </section>
		<form method="post" name="reportsFrm" id="reportsFrm">
        <section class="content">
          <div class="row">
          	<div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Bezoekersaantallen</h3>
                  <button class="btn btn-success pull-right" onClick="javascript: document.reportsFrm.submit();">Verder</button>
                </div>
               </div>
              </div>
          </div>
 
				<form name="reportsFrm" id="reportsFrm">
					<input type="hidden" name="report_id" value="<?=$report_id?>">
		  		<div class="row">
		  		
					<div class="col-md-6">
						



			  			<div class="box box-info">
			  				<div class="box-header">
			  					<h3 class="box-title">Oud</h3>
			  				</div>

			  				<div class="box-body">

			  					<div class="form-group">
				                    <label>Naam*</label>
				                    <input type="text" name="prev_name" class="form-control" placeholder="Naam" value="">
				                </div>

				                <div class="form-group">
				                    <label>Totaal aantal bezoekers*</label>
				                    <input type="text" name="total_visitors_prev" class="form-control" placeholder="Totaal aantal bezoekers" value="">
				                </div>

				                <div class="form-group">
				                    <label>Totaal aantal unieke bezoekers*</label>
				                    <input type="text" name="unique_visitors_prev" class="form-control" placeholder="Totaal aantal unieke bezoekers" value="">
				                </div>

								<p>* Niet verplicht</p>
			  				

			  				</div>
						</div>
					</div>
					<div class="col-md-6">
						
						<div class="box box-info">
			  				<div class="box-header">
			  					<h3 class="box-title">Nieuw</h3>
			  				</div>

			  				<div class="box-body">

			  					<div class="form-group">
				                    <label>Naam</label>
				                    <input type="text" name="name" class="form-control" placeholder="Naam" value="">
				                </div>

				                <div class="form-group">
				                    <label>Totaal aantal bezoekers</label>
				                    <input type="number" name="total_visitors" class="form-control" placeholder="Totaal aantal bezoekers" value="">
				                </div>

				                <div class="form-group">
				                    <label>Totaal aantal unieke bezoekers</label>
				                    <input type="number" name="unique_visitors" class="form-control" placeholder="Totaal aantal unieke bezoekers" value="">
				                </div>
								
								<p>&nbsp;</p>
			  					

			  				</div>
						</div>
					</div>
		  		
				
		  		</div>
		  		</form>
		  	</div>




         </section>
     </form>
    </div>