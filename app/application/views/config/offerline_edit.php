<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Standaard offerte regels
            <small><?=$type?>	</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/dashboard/dashboard"><i class="fa fa-cogs"></i> Home</a></li>
            <li><a href="/config/config">Configuratie</a></li>
			<li><a href="/config/config/offerlines">Standaard offerte regels</a></li>
            <li class="active"><?=$type?></li>
          </ol>
        </section>
	<?php if(is_object($line)) { ?>
		<form method="post" name="editFrm" id="editFrm">
	        <section class="content">
	          <div class="row">
	          	<div class="col-xs-12">
	              <div class="box box-success">
	                <div class="box-header">
	                  <h3 class="box-title">Standaard offerte regels</h3>
	                  <button class="btn btn-success pull-right" onClick="javascript: window.location = '/config/config/offerline_edit';">Opslaan</button>
	                </div>
	                <div class="box-body">
	                	<?php
	                        if($saved){
	                      ?>
	                          <div class="callout callout-success" onClick="javascript: jQuery('.callout').slideUp();" >
	                            <h4>Opgeslagen</h4>
	                            <p>De offerte is met succes opgeslagen</p>
	                          </div>
	                      <?php
	                        }
	                      ?>
	                	<input type="hidden" name="id" value="<?=$line->id?>" id="curr_offer_line">
						<div class="row">
							<div class="form-group col-md-6">
						        <label>Titel</label>
						        <input type="text" class="form-control" id="changedName" placeholder="Titel" value="<?=$line->name?>" name="name">
						    </div>

						     <div class="form-group col-md-6">
						    	<label>Categorie</label>						    	
								<select class="form-control" name="category_id" id="category_id">
									<?php
										foreach($categories as $category){
									?>
											<option <?php if((int)$category->id == (int)$line->category_id){ ?> selected <?php } ?> value="<?=$category->id?>"><?=$category->name?></option>
									<?php
										}
									?>
								</select>
						    </div>
					    </div>

					    <div class="form-group" style="display: none;">
					        <label>Afbeelding</label>
					        <input type="text" class="form-control" placeholder="Afbeelding" value="" name="image">
					    </div>
						<div class="row">
							<div class="form-group col-md-6">
						        <label>Aantal uur</label>
						        <input type="text" class="form-control" placeholder="Aantal uur" value="<?=$line->work_hour?>" name="work_hour">
						    </div>

						    <div class="form-group col-md-6">
						        <label>Prijs</label>
						        <input type="text" class="form-control" placeholder="Prijs" value="<?=$line->price?>" name="price">
						    </div>
					    </div>

					    <div class="form-group">
					        <label>Beschrijving</label>
					       	<textarea class="textarea" id="description" name="description" placeholder="Omschrijving"><?=$line->description?></textarea>
					    </div>

					    <div class="row">

					    	<div class="form-group col-md-6">
						        <input type="checkbox" name="show_price_on_end" <?php if($line->show_price_on_end) { ?>checked<?php } ?> class="minimal "> Laat prijs zien onder offerte
						    </div>

						    <div class="form-group col-md-6">
						        <input type="checkbox" name="fixed_price" <?php if($line->fixed_price) { ?>checked<?php } ?> class="minimal "> Vaste prijs
						    </div>

					    </div>


						<style>

							.wysihtml5-toolbar li:nth-child(3), .wysihtml5-toolbar li:nth-child(5), .wysihtml5-toolbar li:nth-child(6){
								display: none;
							}

							.wysihtml5-toolbar li:nth-child(1), .wysihtml5-toolbar li:nth-child(2){
								margin-right: 17px;
							}

							.wysihtml5-sandbox{
								width: 		100% 				!important;
								height: 	120px 				!important;
								border: 	1px solid #d2d6de 	!important;
								padding: 	10px 				!important;
							}

						</style>
						<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery(".textarea").wysihtml5();
								jQuery('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
						          checkboxClass: 'icheckbox_flat-green',
						          radioClass: 'icheckbox_flat-green-green'
						        });
							});
						</script>
	                </div>
	               </div>
	              </div>
	            </div>
	        </section>
    	</form>
	<?php } else { ?>

		<form method="post" name="editFrm" id="editFrm">
	        <section class="content">
	          <div class="row">
	          	<div class="col-xs-12">
	              <div class="box box-success">
	                <div class="box-header">
	                  <h3 class="box-title">Standaard offerte regels</h3>
	                  <button class="btn btn-success pull-right" onClick="javascript: window.location = '/config/config/offerline_edit';">Opslaan</button>
	                </div>
	                <div class="box-body">
	                	<input type="hidden" name="id" value="" id="curr_offer_line">

						<div class="row">
							<div class="form-group col-md-6">
						        <label>Titel</label>
						        <input type="text" class="form-control" id="changedName" placeholder="Titel" value="" name="name">
						    </div>

						    <div class="form-group col-md-6">
						    	<label>Categorie</label>						    	
								<select class="form-control" name="category_id" id="category_id">
									<?php
										foreach($categories as $category){
									?>
											<option value="<?=$category->id?>"><?=$category->name?></option>
									<?php
										}
									?>
								</select>
						    </div>
					    </div>


					    <div class="form-group" style="display: none;">
					        <label>Afbeelding</label>
					        <input type="text" class="form-control" placeholder="Afbeelding" value="" name="image">
					    </div>
						<div class="row">
							<div class="form-group col-md-6">
						        <label>Aantal uur</label>
						        <input type="text" class="form-control" placeholder="Aantal uur" value="" name="work_hour">
						    </div>

						    <div class="form-group col-md-6">
						        <label>Prijs</label>
						        <input type="text" class="form-control" placeholder="Prijs" value="" name="price">
						    </div>
					    </div>

					    <div class="form-group">
					        <label>Beschrijving</label>
					       	<textarea class="textarea" id="description" name="description" placeholder="Omschrijving"></textarea>
					    </div>

					    <div class="row">

					    	<div class="form-group col-md-6">
						        <input type="checkbox" name="show_price_on_end" class="minimal "> Laat prijs zien onder offerte
						    </div>

						    <div class="form-group col-md-6">
						        <input type="checkbox" name="fixed_price" class="minimal "> Vaste prijs
						    </div>

					    </div>


						<style>

							.wysihtml5-toolbar li:nth-child(3), .wysihtml5-toolbar li:nth-child(5), .wysihtml5-toolbar li:nth-child(6){
								display: none;
							}

							.wysihtml5-toolbar li:nth-child(1), .wysihtml5-toolbar li:nth-child(2){
								margin-right: 17px;
							}

							.wysihtml5-sandbox{
								width: 		100% 				!important;
								height: 	120px 				!important;
								border: 	1px solid #d2d6de 	!important;
								padding: 	10px 				!important;
							}

						</style>
						<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery(".textarea").wysihtml5();
								jQuery('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
						          checkboxClass: 'icheckbox_flat-green',
						          radioClass: 'icheckbox_flat-green-blue'
						        });
							});
						</script>
	                </div>
	               </div>
	              </div>
	            </div>
	        </section>
    	</form>


	<?php } ?>
    </div>