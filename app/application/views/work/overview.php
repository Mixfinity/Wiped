<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
      	<h1>
        	Werkrapport
        	<small>Overzicht</small>
      	</h1>
     	<ol class="breadcrumb">
        	<li><a href="#"><i class="fa fa-clock-o"></i> Home</a></li>
        	<li class="active">Werkrapport</li>
      	</ol>
    </section>


     <section class="content">

      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header fixTop">
              <h3 class="box-title">Werkrapport</h3>
            </div>

            <div class="box-body">
          
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Datum</label>
                    <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <input type="text" class="form-control pull-right active" id="work_date" value="<?=htmlspecialchars($date, ENT_QUOTES, 'UTF-8')?>" name="work_date">
                    </div>

                    <script type="text/javascript">
                      jQuery(document).ready(function(){
                        $('#work_date').daterangepicker({
                          timePicker: false, 
                          timePickerIncrement: 14, 
                          showDropdowns: true,
                          singleDatePicker: true,
                          format: 'DD-MM-YYYY',
                           onChange: function(start) {
                            console.log(start);
                            submitForm();
                           }
                         },

                          function(start, end, things){
                           submitForm();
                          }




                         );
                             
                      });

                   <?php if($_SESSION["profile_id"] == 1): ?>

                    jQuery(document).ready(function(){
                      jQuery("#employee").change(function(){
                        submitForm();
                      });
                    });

                      function submitForm(){
                        window.location = '/work/work/index/' + jQuery("#work_date").val() + '/' + jQuery("#employee").val();
                      }

                    <?php else: ?>

                      function submitForm(){
                        window.location = '/work/work/index/' + jQuery("#work_date").val() ;
                      }



                    <?php endif; ?>



                      </script>

                  </div>
                </div>
                <div class="col-md-6">
                  
                  <?php if($_SESSION["profile_id"] == 1): ?>

                  <div class="form-group">
                        <label>Wie</label>
                        <select class="form-control" name="employee_id" id="employee">
                          <option value="">Maak een keuze...</option>
                          <?php  foreach($users as $user) { ?>
                             <option <?php if($current_user == $user->id): ?> selected <?php endif; ?> value="<?=$user->id?>"><?=$user->name?></option>
                          <?php } ?>
                        </select>
                      </div>

                    <?php endif; ?>

                </div>

              </div>
              <div class="row">
                <div class="col-md-12">
      
                  <table class="table table-condensed">
                    <tbody>
                      <tr>
                        <th style="width: 40px"></th>
                        <th>Project</th>
                        <th>Subproject</th>
                        <th>Taak</th>
                        <th style="width: 40px">Minuten</th>
                        <th style="width: 40px"></th>
                      </tr>


                      <?php
                        $total_minutes = 0;
                        foreach($timestamps as $t):
                          $total_minutes = $total_minutes + (int)$t->minutes;
                      ?>
                      <tr>
                        <td></td>
                        <td><?=$t->project_name?></td>
                        <td><?=$t->sub_project_name?></td>
                        <td><?=$t->project_line_name?></td>
                        <td><?=$t->minutes?></td>
                        <td></td>
                      </tr>

                      <?php
                        endforeach;
                      ?>
                        <tr>
                        
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                      </tr>
                      
                      <tr>
                        
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Totaal:</b></td>
                        <td><?=$total_minutes?></td>
                        <td></td>

                      </tr>
                      
                    </tbody>
                  </table>



                </div>
              </div>



            </div>
          </div>

        </div>

      </div>

     </section>
</div>