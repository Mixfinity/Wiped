<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Gebruikers
            <small><?=$type?>	</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/dashboard/dashboard"><i class="fa fa-cogs"></i> Home</a></li>
            <li><a href="/config/config">Configuratie</a></li>
			<li><a href="/config/config/users">Gebruikers</a></li>
            <li class="active"><?=$type?></li>
          </ol>
        </section>
	<?php if(is_object($line)) { ?>
		
	        <section class="content">
	          <div class="row">
	          	<div class="col-xs-12">
	              <div class="box box-success">
	                <div class="box-header">
	                  <h3 class="box-title">Gebruiker &quot;<?=$line->name?>&quot;</h3>
	                  <button class="btn btn-success pull-right" onclick="javascript: document.editFrm.submit();">Opslaan</button>
	                </div>
	                	<form method="post" name="editFrm" id="editFrm">
				<input type="hidden" name="id" value="<?=$line->id?>">
	                <div class="box-body">	
	                	<?php
	                        if($saved){
	                      ?>
	                          <div class="callout callout-success" onClick="javascript: jQuery('.callout').slideUp();" >
	                            <h4>Opgeslagen</h4>
	                            <p>De gebruiker is met succes opgeslagen</p>
	                          </div>
	                      <?php
	                        }
	                      ?>
	                	  <div class="row">
	               					
               					<div class="form-group col-md-6">
							        <label>Naam</label>
							        <input type="text" class="form-control" placeholder="Naam" value="<?=$line->name?>" name="name">
							    </div>

							    <div class="form-group col-md-6">
							        <label>E-mail</label>
							        <input type="text" class="form-control" placeholder="E-mail" value="<?=$line->email?>" name="email">
							    </div>
							<?php if($this->session->userdata('profile_id') == 1){ ?>
							    <div class="form-group col-md-6">
							        <label>Gebruikersnaam</label>
							        <input type="text" class="form-control" placeholder="Gebruikersnaam" value="<?=$line->username?>" name="username">
							    </div>
							<?php } ?>

							    <div class="form-group col-md-6">
							        <label>Wachtwoord</label>
							        <input type="password" class="form-control" placeholder="Wachtwoord" value="*************************" name="password">
							    </div>
							<?php if($this->session->userdata('profile_id') == 1){ ?>
							    <div class="form-group col-md-6">
							    	<label>Profiel</label>						    	
									<select class="form-control" name="profile_id" id="profile_id">
										<?php
											foreach($profiles as $profile){
										?>
												<option <?php if((int)$line->profile_id == (int)$profile->id) { ?> selected <?php } ?> value="<?=$profile->id?>"><?=$profile->name?></option>
										<?php
											}
										?>
									</select>
							    </div>

							     <div class="form-group col-md-6">
							    	<label>Divisie</label>						    	
									<select class="form-control" name="division_id" id="division_id">
										<?php
											foreach($divisions as $division){
										?>
												<option <?php if((int)$line->division_id == (int)$division->id) { ?> selected <?php } ?>  value="<?=$division->id?>"><?=$division->name?></option>
										<?php
											}
										?>
									</select>
							    </div>
							<?php } ?>

							<div class="form-group col-md-6">
						        <label>Slogan</label>
						        <input type="text" class="form-control" placeholder="Slogan" value="<?=$line->slogan?>" name="slogan">
						    </div>


	                	</div>
						
	                </div>
	                </form>
	               </div>
	              </div>
	            </div>




				<!-- BESCHIKBAARDHEID -->

		<?php if($this->session->userdata('profile_id') == 1){ ?>
				<div class="row">
					
					<div class="col-xs-6">
		              <div class="box box-success">
		                <div class="box-header">
		                  <h3 class="box-title">Beschikbaarheid</h3>
		                </div>
		                <div class="box-body">	
						<form method="post" name="avFrm" id="avFrm">
							<input type="hidden" name="user_id" value="<?=$line->id?>">
							<?php
								foreach($workdays as $day){
							?>
								
									<div class="form-group">
										<input type="checkbox" class="minimal" <?php if($day->user_id){ ?> checked  <?php } ?> name="availability[]" value="<?=$day->id?>">		<span class="def_width"><?=$day->name?></span>		
									</div>

							<?php 
								}
							?>
						</form>

		                </div>
		               </div>
		             </div>
					

				</div>

				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery(".minimal").on("ifChanged", function(){
							
							jQuery.ajax({
								url: "/config/config/saveAvailability" ,
								data: jQuery("#avFrm").serialize(),
								type: "POST",
								success: function(result){
									
								}
							});
				        });
					});
				</script>



		<?php } ?>


	        </section>
    	


    	<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		          checkboxClass: 'icheckbox_flat-green',
		          radioClass: 'icheckbox_flat-green-blue'
		        });
			});
		</script>



	<?php } else { ?>

		<form method="post" name="editFrm" id="editFrm">
	        <section class="content">
	          <div class="row">
	          	<div class="col-xs-12">
	              <div class="box box-success">
	                <div class="box-header">
	                  <h3 class="box-title">Gebruiker</h3>
	                  <button class="btn btn-success pull-right">Opslaan</button>
	                </div>
	                <div class="box-body">	
	                	  <div class="row">
	               					
               					<div class="form-group col-md-6">
							        <label>Naam</label>
							        <input type="text" class="form-control" placeholder="Naam" value="" name="name">
							    </div>

							    <div class="form-group col-md-6">
							        <label>E-mail</label>
							        <input type="text" class="form-control" placeholder="E-mail" value="" name="email">
							    </div>

							    <div class="form-group col-md-6">
							        <label>Gebruikersnaam</label>
							        <input type="text" class="form-control" placeholder="Gebruikersnaam" value="" name="username">
							    </div>

							    <div class="form-group col-md-6">
							        <label>Wachtwoord</label>
							        <input type="password" class="form-control" placeholder="Wachtwoord" value="" name="password">
							    </div>

							    <div class="form-group col-md-6">
							    	<label>Profiel</label>						    	
									<select class="form-control" name="profile_id" id="profile_id">
										<?php
											foreach($profiles as $profile){
										?>
												<option value="<?=$profile->id?>"><?=$profile->name?></option>
										<?php
											}
										?>
									</select>
							    </div>

							     <div class="form-group col-md-6">
							    	<label>Divisie</label>						    	
									<select class="form-control" name="division_id" id="division_id">
										<?php
											foreach($divisions as $division){
										?>
												<option value="<?=$division->id?>"><?=$division->name?></option>
										<?php
											}
										?>
									</select>
							    </div>



	                	  </div>
						
	                </div>
	               </div>
	              </div>
	            </div>
	        </section>
    	</form>

	<?php } ?>
    </div>