<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header">
          <h1>
            Archief
            <small>Overzicht</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-plus-square"></i> Home</a></li>
            <li>Projectbeheer</li>
            <li class="active">Archief</li>
          </ol>
        </section>

        <section class="content">
         

          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header fixTop">
                  <h3 class="box-title">Afgerond</h3>
                </div>

                <div class="box-body">

                   <table id="project_archive" class="table table-bordered table-hover dataTable">
                      <thead>
                        <tr>
                          <th>Naam</th>
                          <th>Klant</th>
                          <th class="hidden-xs">Aangemaakt op</th>
                          <th width="167">&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>              
                        <?php
                       
                          foreach($projects as $project){?>
                           <tr>
                             
                             <td><?=$project->name?></td>
                             <td><?=$project->contact_name?></td>
                             <td class="hidden-xs"><?=$project->date_created?></td>
                             <td>
                               
                               <!-- edit / delete buttons -->
                             <a class="btn btn-warning" href="/projects/projects/specifications/<?=$project->id?>/1"><i class="fa fa-line-chart"></i></a>
                               <a href="/projectsm/projectsm/edit/<?=$project->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-warning" href="/projects/projects/projectDetails/<?=$project->id?>"><i class="fa fa-arrow-right"></i></a>
                              <!-- <a href="/projectsm/projectsm/delete/<?=$project->id?>" class="btn btn-danger removeBtn"><i class="fa fa-trash"></i></a>-->
  

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

    <script type="text/javascript">

    jQuery(document).ready(function(){
      
        jQuery('#projects, #project_check').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": false,
          "autoWidth": false
        });

        jQuery('#project_archive').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": false,
          "autoWidth": false
        });

    });

    </script>