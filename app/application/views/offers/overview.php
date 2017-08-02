<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Offertes
            <small>Overzicht</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-euro"></i> Home</a></li>
            <li class="active">Offertes</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header fixTop">
                  <h3 class="box-title">In aanmaak</h3>
                  <button class="btn btn-success pull-right" onclick="location.href = '/offers/offers/create' ">Nieuw</button>
                </div>

                <div class="box-body">

                      <?php
                        if($notfound){
                      ?>
                          <div class="callout callout-warning" onClick="javascript: jQuery('.callout').slideUp();" >
                            <h4>Offerte niet gevonden</h4>
                            <p>De gevraagde offere is niet gevonden in de database</p>
                          </div>
                      <?php
                        }
                       ?>
                      <?php
                        if($deleted){
                      ?>
                          <div class="callout callout-success" onClick="javascript: jQuery('.callout').slideUp();" >
                            <h4>Verwijderd</h4>
                            <p>De offerte is met succes verwijderd</p>
                          </div>
                      <?php
                        }
                      ?>
             
                          <table id="offers" class="table table-bordered table-hover dataTable">
                            <thead>
                              <tr>
                                <th>Nr.</th>
                                <th>Naam</th>
                                <th>Klant</th>
                                <th class="hidden-xs">Datum</th>
                                <th width="117">&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>              
                              <?php
                                foreach($offers as $offer){?>
                                 <tr>
                                   
                                   <td><?=$offer->id?></td>
                                   <td><?=$offer->name?></td>
                                   <td><?=$offer->contact_name?></td>
                                   <td class="hidden-xs"><?=$offer->date_created?></td>
                                   <td>
                                     
                                     <a href="/offers/offers/edit/<?=$offer->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                     <a href="/offers/offers/delete/<?=$offer->id?>" class="btn btn-danger removeBtn"><i class="fa fa-trash"></i></a>
        

                                   </td>
                                 </tr>
                              <?php }
                              ?>
                            </tbody>
                            
                          </table>
                      


                  </div>

                </div>
              </div>
            </div>
            

       






           <div class="row">
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header fixTop">
                  <h3 class="box-title">Verzonden</h3>
                </div>

                <div class="box-body">          
                          <table id="waiting" class="table table-bordered table-hover dataTable">
                            <thead>
                              <tr>
                                <th>Nr.</th>
                                <th>Naam</th>
                                <th>Klant</th>
                                <th class="hidden-xs">Datum</th>
                                <th width="117">&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>              
                              <?php
                                foreach($sendoffers as $offer){?>
                                 <tr>
                                   
                                   <td><?=$offer->id?></td>
                                   <td><?=$offer->name?></td>
                                   <td><?=$offer->contact_name?></td>
                                   <td class="hidden-xs"><?=$offer->date_created?></td>
                                   <td>
                                     <a href="/offers/offers/edit/<?=$offer->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                     <a href="/offers/offers/delete/<?=$offer->id?>" class="btn btn-danger removeBtn"><i class="fa fa-trash"></i></a>
                                   </td>
                                 </tr>
                              <?php }
                              ?>
                            </tbody>
                        </table>
                  </div>

                </div>
              </div>
            </div>




            <div class="row">
            <div class="col-xs-12">
              <div class="box box-warning">
                <div class="box-header fixTop">
                  <h3 class="box-title">Archief</h3>
                </div>

                <div class="box-body">          
                          <table id="archive" class="table table-bordered table-hover dataTable">
                            <thead>
                              <tr>
                                <th>Nr.</th>
                                <th>Naam</th>
                                <th>Klant</th>
                                <th class="hidden-xs">Datum</th>
                                <th width="57">&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>              
                              <?php
                                foreach($archiveoffers as $offer){?>
                                 <tr>
                                   
                                   <td><?=$offer->id?></td>
                                   <td><?=$offer->name?></td>
                                   <td><?=$offer->contact_name?></td>
                                   <td class="hidden-xs"><?=$offer->date_created?></td>
                                   <td>
                                     
                                     <a href="/offers/offers/edit/<?=$offer->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>

                                   </td>
                                 </tr>
                              <?php }
                              ?>
                            </tbody>
                        </table>
                  </div>

                </div>
              </div>
            </div>
            


       	</section>

    </div>

    


           

     <script>
      $(function () {
        $('#offers, #waiting, #archive').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": false,
          "autoWidth": false
        });
      });

      jQuery(".removeBtn").click(function(){
        showPopup('Verwijderen', 'Weet u zeker dat u deze offerte wilt verwijderen?', 'Ja', 'Nee', '', '', jQuery(this).attr('href'));
        return false;
      });
     
    </script>