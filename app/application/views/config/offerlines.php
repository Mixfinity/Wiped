<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Standaard offerte regels
            <small>Overzicht	</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/dashboard/dashboard"><i class="fa fa-cogs"></i> Home</a></li>
            <li><a href="/config/config">Configuratie</a></li>
            <li class="active">Standaard offerte regels</li>
          </ol>
        </section>
	
        <section class="content">
          <div class="row">
          	<div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Standaard offerte regels</h3>
                  <button class="btn btn-success pull-right" onClick="javascript: window.location = '/config/config/offerline_edit';">Nieuw</button>

                  	<?php
	                        if($deleted){
	                      ?><br><br>
	                          <div class="callout callout-success" onClick="javascript: jQuery('.callout').slideUp();" >
	                            <h4>Verwijdert</h4>
	                            <p>De offerte regel is met succes verwijdert</p>
	                          </div>
	                      <?php
	                        }
	                      ?>
                </div>
               </div>
              </div>
                	<?php
                		foreach($categories as $sub2 => $sub){
                			foreach($sub as $name => $values){ ?>
								  <div class="col-md-6">
              
						              <div class="box box-warning">
						                 
						                <div class="box-header">
						                  <h3 class="box-title"><?=$name?></h3>
						                </div>

						                <div class="box-body">
							
								
								<table id="<?=strtolower($name)?>" class="table table-bordered table-hover dataTable">
		                            <thead>
			                            <tr>
			                                <th>Titel</th>	                                
			                                <th width="117">&nbsp;</th>
			                            </tr>
		                            </thead>
		                            <tbody>         
	                <?php 		foreach($values as $thing => $row){
	                					foreach($row as $item){
	                						?>
										<tr>
											   <td><?=$item->name?></td>
											   <td>
													<a href="/config/config/offerline_edit/<?=$item->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                     				<a href="/config/config/offerline_delete/<?=$item->id?>" class="btn btn-danger removeBtn"><i class="fa fa-trash"></i></a>
											   </td>
										</tr>
	                <?php	                					}
	                					}
	                				?>
	                				</tbody>
	                			</table>
	                		</div>
	                	</div>
	                </div>
              		<?php
                			}
                		}
                	?>
            </div>
         </section>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function(){
	    jQuery(".removeBtn").click(function(){
	        showPopup('Verwijderen', 'Weet u zeker dat u deze offerteregel wilt verwijderen?', 'Ja', 'Nee', '', '', jQuery(this).attr('href'));
	        return false;
	    });
	});
    </script>