<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header">
          <h1>
            Projecten
            <small>Specificaties</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-tasks"></i> Home</a></li>
            <li><a href="#">Projecten</a></li>
            <li class="active">Specificaties</li>
          </ol>
        </section>

        <section class="content">
         
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header fixTop">
                  <h3>Specificaties</h3>
                </div>
                <div class="box-body">
                <form method="POST" name="dateRange" id="dateRange">
                <div class="form-group col-md-6">
                  <label>Van</label>
                  <div class="input-group">
                     <div class="input-group-addon">
                       <i class="fa fa-calendar"></i>
                     </div>
                     <input type="text" class="form-control pull-right" id="from" name="from" value="<?=$from?>">
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label>Tot</label>
                  <div class="input-group">
                     <div class="input-group-addon">
                       <i class="fa fa-calendar"></i>
                     </div>
                     <input type="text" class="form-control pull-right" id="till" name="till" value="<?=$till?>">
                  </div>
                </div>
                </form>
                <div class="col-md-12">
                 <button class="btn btn-success pull-right" onClick="javascript: getSpecifications();">Ophalen</button>
                 

               <?php if($project): ?>
              <?php if($main): ?>
                
                <button class="btn btn-warning pull-right" onClick="window.location = '/projects/projects/pdfadv/<?=$id?><?php if(!empty($from)){ ?>/<?=$from?>/<?=$till?>
                 <?php } ?>'">Genereer PDF</button>
      
              <?php else: ?>
                 <button class="btn btn-warning pull-right" onClick="window.location = '/projects/projects/pdf/<?=$id?><?php if(!empty($from)){ ?>/<?=$from?>/<?=$till?>
                 <?php } ?>'">Genereer PDF</button>
              <?php endif; ?>
              <?php endif; ?>






                </div>

                <script type="text/javascript">
                  jQuery(document).ready(function(){
                    $('#from, #till').daterangepicker({
                      timePicker: false, 
                      timePickerIncrement: 14, 
                      showDropdowns: true,
                      singleDatePicker: true,
                      format: 'YYYY-MM-DD'});
                  });

                  function getSpecifications(){

                    jQuery("#dateRange").submit();

                  }
                </script>

                
                <?php if(!$project): ?>
                  <p>Voor dit project zijn geen specificaties beschikbaar</p>
                <?php endif; ?>

                <h3><?=$contact?></h3>
                <h5><?=$project?></h5>
                <table>
                  <?php
                    $sub_project_name = "";
                    $sub_project_id = 0;
                    $line_name = "";
                    $teller = 0;

                    foreach($specifications as $info):
                      if($sub_project_id != $info->sub_project_id){
                        $sub_project_name = $info->sub_project_name;
                        $sub_project_id = $info->sub_project_id;
                      ?>
                        <tr>
                        <th colspan="3"><br><br><?=$sub_project_name?></th>
                        </tr>
                      <?php
                      }

                      if($line_name != $info->description ){
                        $line_name  = $info->description;
                        ?>  
                          </table>
                          <h5><?=$line_name?></h5>
                          <table>

                        <?php
                      }

                  ?>   
                    <tr>
                      <td width="150"><?=$info->mutation_date?></td>
                      <td width="50" align="right"><?=$info->minutes?></td>

                    </tr>

                  <?php
                    endforeach;
                  ?>

                  </table>
                 </div>
              </div>
            </div>
          </div>



        </section>
      </div>
