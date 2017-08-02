<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  $totalminutes = (int)0;
?>
	<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Projecten
        <small>Detail</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-tasks"></i> Home</li>
        <li><a href="#">Projecten</a></li>
        <li class="active">Detail</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        
        <div class="col-md-6">
          <div class="box-warning box">
            <div class="box-header">
              <h3 class="box-title">
                Projectinformatie
              </h3> 
            </div>

            <div class="box-body">

              <?php
                if($project_line):
              ?>

                  <p><label>Project</label><?=$project_line->project_name?></p>
                  <p><label>Deelproject</label><?=$project_line->category_name?></p>
                  <p><label>Klant</label><?=$project_line->contact_name?></p>
                  <br>
                  <p><b><?=$project_line->line_name?></b></p>
                  <p><?=$project_line->description?></p>
                  <textarea onKeyUp="javascript: saveInternalDescription(<?=$project_line_id?>);"><?=$project_line->internal_description?></textarea>
                <form method="POST" name="status_done" id="status_done" action="#">
                  <div class="form-group">
                    <br>
                    <p><input type="checkbox" <?php if($project_line->done == "1"): ?> checked <?php endif; ?> class="minimal"  name="status" value="1">    <span class="def_width">Afgerond</span>   </p>
                    <p><input type="checkbox" <?php if($project_line->done == "1"): ?> checked <?php endif; ?> class="minimal"  name="check" value="1">    <span class="def_width">Controle</span>   </p>
                  </div>
                </form>

              <?php
                endif;
              ?>

            </div>  
          </div>





          <div class="box-success box">
            <div class="box-header">
              <h3 class="box-title">
                Alle projectregels van dit project
              </h3> 
            </div>

            <div class="box-body">

              <pre style="display: none;">
                <?=print_r($all_project_lines);?>
              </pre>
             
            </div>  
          </div>




        </div>

        <div class="col-md-6">
          <div class="box-danger box">
            <div class="box-header">
              <h3 class="box-title">
                Gewerkte uren
              </h3> 
            </div>

            <div class="box-body">

              <div class="minute_holder">
                  <div class="minute_date">
                    <b>Datum</b>
                 </div>

                  <div class="minute_name">
                    <b>Naam</b>
                  </div>

                  <div class="minute_minutes">
                    <b>Tijden</b>
                  </div>
                </div>

              <?php
                foreach($minutes as $minute):
                  $totalminutes += $minute->minutes;
              ?>
                <div class="minute_holder">
                  <div class="minute_date">
                    <?=$minute->datum?>
                 </div>

                  <div class="minute_name">
                    <?=$minute->user_name?>
                  </div>

                  <div class="minute_minutes">
                    <?=calculateToHour($minute->minutes)?> 
                  </div>
                </div>
              <?php
                endforeach;
              ?>

              <div class="minute_holder">
                <div class="minute_date">
                  &nbsp;
                </div>
              

                <div class="minute_name">
                  <span class="pull-right">Totaal: &nbsp; &nbsp; </span>
                </div>

                <div class="minute_minutes">
                  <?=calculateToHour($totalminutes)?> / <?=calculateToHour($project_line->estimation)?>
                </div>
              </div>
      
            </div>  
          </div>
        </div>

      </div>
    </section>
  </div>

  <style type="text/css">
    .minute_holder{
      float:left;
      width: 100%;
    }

    .minute_date, .minute_minutes{
      float: left;
      display: inline-block;
      width: 20%;
    }

    .minute_name{
      float:left;
      width:60%;
      display: inline-block;
    }

    .box-body p label{
      display: inline-block;
      width: 25%;
    }
    .box-body textarea{
      width: 100%;
      resize: none;
      border-radius: 5px;
      height: 140px;
      border: 1px solid #f0f0f0;
    }
  </style>


  <script type="text/javascript">

     function saveInternalDescription(f_project_line){
        jQuery.ajax({
          url: '/projects/projects/updateInternaLDescription/' +  f_project_line,
          data: 'internal_description=' + jQuery("textarea").val(),
          method: 'POST',
          success: function(data){
            
          }
        });
      }


      jQuery(document).ready(function(){
        jQuery('input[type="checkbox"].minimal').iCheck({
          checkboxClass: 'icheckbox_flat-green'
        });
<?php if($project_line): ?>

        jQuery(".minimal").on("ifChanged", function(){     
          jQuery.ajax({
            url: "/projects/projects/setWorkDoneWithCheck/<?=$project_line->id?>" ,
            data: jQuery("#status_done").serialize(),
            type: "POST",
            success: function(result){

            }
          });
        });


<?php endif;?>
      });




  </script>