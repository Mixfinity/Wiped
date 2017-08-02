<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header ">
          <h1>
            Rapportages
            <small>Overzicht</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-area-chart"></i> Home</a></li>
            <li class="active">Rapportages</li>
          </ol>
        </section>

        <section class="content">
          

          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header fixTop">
                  <h3 class="box-title">Rapportages</h3>
                  <button class="btn btn-success pull-right" onclick="location.href = '/reports/reports/new' ">Nieuw</button>
                </div>

                <div class="box-body">

                         <table id="contacts" class="table table-bordered table-hover dataTable">
                            <thead>
                              <tr>
                                <th width="300">Klant</th>
                                <th>Naam</th>
                                <th width="150" class="hidden-xs">Datum</th>           
                                <th width="117">&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>              
                              <?php
                                foreach($reports as $r):
                              ?>
                              <tr>
                                
                                <td><?=$r->contact_name?></td>
                                <td><?=$r->name?></td>
                                <td><?=$r->date_created?></td>
                                <td><a href="/reports/reports/step_2/<?=$r->id?>" class="btn btn-success pull-right"><i class="fa fa-edit"></i></a>
</td>
                              </tr>
                              <?php
                                endforeach;
                              ?>
                            </tbody>
                            
                          </table>
                        


                  </div>

                </div>
              </div>
            </div>


       	</section>

    </div>

    


           
