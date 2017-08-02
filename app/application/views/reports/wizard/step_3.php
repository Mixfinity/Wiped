<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Rapportages
            <small>Stap 3</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-area-chart"></i> Home</a></li>
            <li>Rapportages</li>
            <li class="active">Stap 3</li>
          </ol>
        </section>
		<form method="post" name="reportsFrm" id="reportsFrm">
        <section class="content">
          <div class="row">
          	<div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Kanalen</h3>
                  <button class="btn btn-success pull-right" onClick="javascript: document.reportsFrm.submit();">Verder</button>
                </div>
               </div>
              </div>
          </div>
 
				<form name="reportsFrm" id="reportsFrm">
					<input type="hidden" name="report_id" value="<?=$report_id?>">
		  		<div class="row">
		  		
					<div class="col-md-8">
						



			  			<div class="box box-info">
			  				<div class="box-header">
			  					<h3 class="box-title">Kanalen</h3>
			  				</div>

			  				<div class="box-body">

			  				
			  				

			  				</div>
						</div>
					</div>
					<div class="col-md-4">
						
						<div class="box box-info">
			  				<div class="box-header">
			  					<h3 class="box-title">Nieuw</h3>
			  				</div>

			  				<div class="box-body">

			  			
		
			  					

			  				</div>
						</div>
					</div>
		  		
				
		  		</div>
		  		</form>
		  	</div>




         </section>
     </form>
    </div>