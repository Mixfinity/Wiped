<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header ">
      <h1>
        Rechten
        <small>Overzicht</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/dashboard/dashboard"><i class="fa fa-cogs"></i> Home</a></li>
        <li><a href="/config/config">Configuratie</a></li>
		<li class="active">Rechten</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
          	<div class="col-xs-12">
              	<div class="box box-success">
                	<div class="box-header">
                  		<h3 class="box-title">Profielen</h3>
                  		<button class="btn btn-success pull-right newBtn">Nieuw</button>
                	</div>
                	<div class="box-body">
                		<table id="users" class="table profileTable table-bordered table-hover dataTable">
		                    <thead>
		                        <tr>
			                        <th>Profielnaam</th>
			                        <th width="60">&nbsp;</th>
		                        </tr>
		                    </thead>
		                    <tbody>
	                    	<?php
	                    		foreach($profiles as $profile){
	                    	?>
								<tr>
									<td><?=$profile->name?></td>
									<td width="60">
										<a class="btn btn-success" href="/config/config/rights_edit/<?=$profile->id?>"><i class="fa fa-edit"></i></a>
									</td>
								</tr>
	                    	<?php
	                    		}
	                    	?>
		                    </tbody>
		                </table>  
                	</div>
               	</div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

	jQuery(document).ready(function(){
		jQuery(".newBtn").click(function(){
			showPopup('Nieuw profiel', 'Vul de naam in van het profiel:<br><form id="profileFrm"><div class="form-group"><input type="text" class="form-control" id="profile_name" placeholder="Profielnaam" value="" name="profile_name"></div></form>', '', '', 'Annuleren', 'Opslaan', 'javascript: saveProfile();');
         	return false;
		});
	});

	function saveProfile(){
		jQuery.ajax({
			data: jQuery("#profileFrm").serialize(),
			method: "POST",
			url: "/config/config/saveprofile" ,
			success: function(data){
				location.reload();
			}
		});
	}
	
</script>