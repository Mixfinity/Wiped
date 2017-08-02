<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header">
          <h1>
            Projectbeheer
            <small>Overzicht</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-plus-square"></i> Home</a></li>
            <li class="active">Projectbeheer</li>
          </ol>
        </section>



        <section class="content">
          

               <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header fixTop">
                  <h3 class="box-title">Check</h3>
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
                        
                          foreach($end_projects as $project){?>
                           <tr>
                             
                             <td><?=$project->name?></td>
                             <td><?=$project->contact_name?></td>
                             <td class="hidden-xs"><?=$project->date_created?></td>
                             <td>
                               
                               <!-- edit / delete buttons -->
                              <a class="btn btn-warning pull-right" href="/projects/projects/projectDetails/<?=$project->id?>"><i class="fa fa-arrow-right"></i></a>

                              <a href="/projectsm/projectsm/edit/<?=$project->id?>" class="btn btn-success pull-right"><i class="fa fa-edit"></i></a>

                              <a class="btn btn-warning pull-right" href="/projects/projects/specifications/<?=$project->id?>/1"><i class="fa fa-line-chart"></i></a>

                                            

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
              <div class="box">
                <div class="box-header fixTop">
                  <h3 class="box-title">Concepten</h3>
                  <button style="display: none" class="btn btn-success pull-right" onclick="location.href = '/projectsm/projectsm/edit' ">Nieuw</button>
                </div>

                <div class="box-body">

                         <table id="projects" class="table table-bordered table-hover dataTable">
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
                                foreach($concept_projects as $project){?>
                                 <tr>
                                   
                                   <td><?=$project->name?></td>
                                   <td><?=$project->contact_name?></td>
                                   <td class="hidden-xs"><?=$project->date_created?></td>
                                   <td>
                                     
                                     <!-- edit / delete buttons -->

                                      <a class="btn btn-primary pull-left" href="/projects/projects/projectDetails/<?=$project->id?>"><i class="fa fa-trello"></i></a>

                                      <a href="/projectsm/projectsm/edit/<?=$project->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>

                                  
        

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
                  <h3 class="box-title">Uitvoering</h3>
                </div>

                <div class="box-body">

                   <table id="project_check" class="table table-bordered table-hover dataTable">
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
                       
                          foreach($plan_projects as $project){?>
                           <tr>
                             
                             <td><?=$project->name?></td>
                             <td><?=$project->contact_name?></td>
                             <td class="hidden-xs"><?=$project->date_created?></td>
                             <td>
                               
                               <!-- edit / delete buttons -->
                                <a class="btn btn-primary pull-left" href="/projects/projects/projectDetails/<?=$project->id?>"><i class="fa fa-trello"></i></a>

                              <a href="/projectsm/projectsm/edit/<?=$project->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>

                              <a class="btn btn-warning pull-right" href="/projects/projects/projectDetails/<?=$project->id?>"><i class="fa fa-arrow-right"></i></a>           
  

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



<?php if(1===3): ?>
             <div class="row">
            <div class="col-xs-12">
              <div class="box box-warning">
                <div class="box-header fixTop">
                  <h3 class="box-title">Mee bezig</h3>
                </div>

                <div class="box-body">

                   <table id="project_check" class="table table-bordered table-hover dataTable">
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
                        if(1 == 2):
                          foreach($concept_projects as $project){?>
                           <tr>
                             
                             <td><?=$project->name?></td>
                             <td><?=$project->contact_name?></td>
                             <td class="hidden-xs"><?=$project->date_created?></td>
                             <td>
                               
                               <!-- edit / delete buttons -->
 <a class="btn btn-primary pull-left" href="/projects/projects/projectDetails/<?=$project->id?>"><i class="fa fa-trello"></i></a>

                              <a href="/projectsm/projectsm/edit/<?=$project->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>

                              <a class="btn btn-warning pull-right" href="/projects/projects/projectDetails/<?=$project->id?>"><i class="fa fa-arrow-right"></i></a>           

                             </td>
                           </tr>
                        <?php }
                        endif;
                        ?>
                      </tbody>
                      
                    </table>
                


                  </div>

                </div>
              </div>
            </div>
            
<?php endif; ?>



          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header fixTop">
                  <h3 class="box-title">Proef / Feedback</h3>
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
                
                          foreach($proef_projects as $project){?>
                           <tr>
                             
                             <td><?=$project->name?></td>
                             <td><?=$project->contact_name?></td>
                             <td class="hidden-xs"><?=$project->date_created?></td>
                             <td>
                               
                               <!-- edit / delete buttons -->

                             <a class="btn btn-primary pull-left" href="/projects/projects/projectDetails/<?=$project->id?>"><i class="fa fa-trello"></i></a>

                              <a href="/projectsm/projectsm/edit/<?=$project->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>

                              <a class="btn btn-warning pull-right" href="/projects/projects/projectDetails/<?=$project->id?>"><i class="fa fa-arrow-right"></i></a>           

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





     



            <?php if(1===3): ?>

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
                          <th width="117">&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>              
                        <?php
                        if(1 == 2):
                          foreach($concept_projects as $project){?>
                           <tr>
                             
                             <td><?=$project->name?></td>
                             <td><?=$project->contact_name?></td>
                             <td class="hidden-xs"><?=$project->date_created?></td>
                             <td>
                               
                               <!-- edit / delete buttons -->

                               <a href="/projectsm/projectsm/edit/<?=$project->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                               <a href="/projectsm/projectsm/delete/<?=$project->id?>" class="btn btn-danger removeBtn"><i class="fa fa-trash"></i></a>
  

                             </td>
                           </tr>
                        <?php }
                        endif;
                        ?>
                      </tbody>
                      
                    </table>
                


                  </div>

                </div>
              </div>
            </div>
<?php endif; ?>




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