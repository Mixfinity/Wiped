<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Klanten
            <small>Overzicht</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
            <li class="active">Klanten</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header fixTop">
                  <h3 class="box-title">Overzicht</h3>
                  <button class="btn btn-success pull-right" onclick="location.href = '/contacts/contacts/create' ">Nieuw</button>
                </div>

                <div class="box-body">

                      <?php
                        if($notfound){
                      ?>
                          <div class="callout callout-warning" onClick="javascript: jQuery('.callout').slideUp();" >
                            <h4>Klant niet gevonden</h4>
                            <p>De gevraagde klant is niet gevonden in de database</p>
                          </div>
                      <?php
                        }
                       ?>
                      <?php
                        if($deleted){
                      ?>
                          <div class="callout callout-success" onClick="javascript: jQuery('.callout').slideUp();" >
                            <h4>Verwijderd</h4>
                            <p>De klant is met succes verwijderd</p>
                          </div>
                      <?php
                        }
                      ?>
             
                          <table id="contacts" class="table table-bordered table-hover dataTable">
                            <thead>
                              <tr>
                                <th>Naam</th>
                                <th class="hidden-xs">Adres</th>
                                <th>Plaats</th>
                                <th class="hidden-xs">Contactpersoon</th>
                                <th width="117">&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>              
                              <?php
                                foreach($contacts as $contact){?>
                                 <tr>
                                   
                                   <td><?=$contact->name?></td>
                                   <td class="hidden-xs"><?=$contact->address?></td>
                                   <td><?=$contact->city?></td>
                                   <td class="hidden-xs"><?=$contact->contact_name?></td>
                                   <td>
                                     
                                     <!-- edit / delete buttons -->

                                     <a href="/contacts/contacts/edit/<?=$contact->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                     <a href="/contacts/contacts/delete/<?=$contact->id?>" class="btn btn-danger removeBtn"><i class="fa fa-trash"></i></a>
        

                                   </td>
                                 </tr>
                              <?php }
                              ?>
                            </tbody>
                            
                          </table>
                      


                  </div>

                </div>
              </div>
            </d iv>
            



       	</section>

    </div>

    


           

     <script>
      $(function () {
        $('#contacts').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": false,
          "autoWidth": false
        });
      });

      jQuery(".removeBtn").click(function(){
        showPopup('Verwijderen', 'Weet u zeker dat u deze klant wilt verwijderen?', 'Ja', 'Nee', '', '', jQuery(this).attr('href'));
        return false;
      });
     
    </script>