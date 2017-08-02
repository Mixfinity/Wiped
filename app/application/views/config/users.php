<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Gebruikers
            <small>Overzicht	</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/dashboard/dashboard"><i class="fa fa-cogs"></i> Home</a></li>
            <li><a href="/config/config">Configuratie</a></li>
            <li class="active">Gebruikers</li>
          </ol>
        </section>

		
		<section class="content">
          <div class="row">
          	<div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Gebruikers</h3>
                  <button class="btn btn-success pull-right" onClick="javascript: window.location = '/config/config/user_edit';">Nieuw</button>
                </div>
                <div class="box-body">

                  <?php
                    if($deleted){?>
                          <div class="callout callout-success" onClick="javascript: jQuery('.callout').slideUp();" >
                            <h4>Verwijderd</h4>
                            <p>De gebruiker is met succes verwijderd</p>
                          </div>
                  <?php }
                  ?>


                  
                    <table id="users" class="table userTable table-bordered table-hover dataTable">
                      <thead>
                        <tr>
                          <th width="50" class="hidden-xs"></th>
                          <th>Naam</th>
                          <th width="117">&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>  
                       <?php
                    foreach($users as $user){
                  ?>
                        <tr>
                          <td><img src="<?=$user->profile_image?>" class="img-circle" alt="<?=$user->name?>"></td>
                          <td><?=$user->name?></td>
                          <td>
                             <!-- edit / delete buttons -->

                             <a href="/config/config/user_edit/<?=$user->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                             <a href="/config/config/user_delete/<?=$user->id?>" class="btn btn-danger removeBtn"><i class="fa fa-trash"></i></a>
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
      jQuery(".removeBtn").click(function(){
          showPopup('Verwijderen', 'Weet u zeker dat u deze gebruiker wilt verwijderen?', 'Ja', 'Nee', '', '', jQuery(this).attr('href'));
          return false;
      });
  });
    </script>
