<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>	

<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Alle lopende projecten
        <small>Detail</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-tasks"></i> Home</li>
        <li><a href="#">Alle projecten</a></li>
        <li class="active">Detail</li>
      </ol>
    </section>


    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="box box-warning">
            <div class="box-header fixTop">
              <h3 class="box-title">Informatie</h3>
            </div>

            <div class="box-body">     
              <p><b>Klant</b><br><?=$project_info->contact_name?></p>
              <p><b>Project</b><br><?=$project_info->project_name?></p>
              <p><b>Projectnummer</b><br><?=$project_nr?></p>
              <?php 
                if($project_info->percentage):
                  $percentage = $project_info->percentage;
                else:
                  $percentage = 0;
                endif;
               ?>
              <p><b>Voortgang</b><br><?=$percentage?> %</p>
              <p><b>Gewerkt</b><br><?=calculateToHour($project_info->total_worked)?> / <?=calculateToHour($project_info->total_estimation)?> </p>

        <?php if($_SESSION["profile_id"] == 1): ?>
              <p><b>Projectstatus</b></p>
              <select name="project_status" id="project_status" class="selectbox" onChange="javascript: saveProjectStatus('<?=$project_info->id?>', this.value);">
                <?php
                  foreach($project_statusses as $status):
                ?>

                  <option value="<?=$status->id?>" <?php if($status->id == $project_info->status_id){ ?> selected <?php } ?>><?=$status->name?></option>
                <?php
                  endforeach;
                ?>
              </select>

            <?php endif; ?>
            
            </div>
          </div>
        </div>

       <div class="col-md-8">
          <div class="box box-success">
            <div class="box-header fixTop">
              <h3 class="box-title">Deelprojecten</h3>
            </div>

            <div class="box-body">     

               <table id="waiting" class="table table-bordered table-hover dataTable">
                <thead>
                  <tr>
                    <th>Naam</th>
                    <th class="hidden-xs">Uitvoerder</th>
                    <th class="hidden-xs">Voortgang</th>
                    <th width="117">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($project_lines as $project_line):
                  ?>
                    <tr>
                      <td><?=$project_line->project_name?></td>
                      <td class="hidden-xs"><?=$project_line->executive_name?></td>
                      <?php 
                        if($project_line->percentage):
                          $percentage = $project_line->percentage;
                        else:
                          $percentage = 0;
                        endif;
                       ?>
                       <td class="hidden-xs"><?=$percentage?> % <span style="float:right">(<?=calculateToHour($project_line->total_worked )?> / <?=calculateToHour($project_line->total_estimation)?>)</span></td>
                      <td>
                        
                        <a class="btn btn-success pull-right" href="javascript: showProjectPopup(<?=$project_line->project_id?>);"><i class="fa fa-search"></i></a>

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






      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header fixTop">
              <h3 class="box-title">Trello</h3>
            </div>

            <div class="box-body draggable">


<style>
  
  .card{
    padding: 10px;
    border: 1px solid #999999;
    display: block;
    list-style: none;
    border-radius: 8px;
    background-color: #f2f2f2;
    margin: 10px 0;
    transition: 0.3s ease;
  }

  .card_holder{
    list-style: none;
    margin-left: -40px;
  }

  .card:hover{
    background-color: #eeeeee;
  }
</style>

  <?php
  $list_ids = array();
  $teller = 1;
    $list_count = 0;
    if($trello_items){


     foreach($trello_items as $item){
        
        if($teller == 1){
          echo "<div class='row'>";
        }
      ?>
                <div class="col-md-4 trello_list">
                  <h4><?php echo $item->name; ?></h4>
                  <ul style="width: 100%; min-height: 200px" id="list_<?=$list_count?>" class="trello_list_paste" data-list-id="<?=$item->id?>">
                  <?php
                    foreach($item->cards as $card){

                  ?>

                    <li class="card_holder" data-card-id="<?=$card->id?>">
                      <a class="card" href="<?php echo $card->shortUrl; ?>" target="_blank">
                        <p><?php echo $card->name?></p>
                      </a>
                    </li>

                  <?php }
                ?>
                  </ul>
                </div>
              <?php 

              if($teller == 3){
                echo "</div>";
              }

              $teller = $teller + 1;
              $list_count++;
              if($teller == 4){ $teller = 1; }


            }
          } else {
            echo "Er is geen tello bord beschikbaar voor dit project.";
          }
                ?>

            </div>
          </div>

      </div>

    </section>


</div>

<?php
  $selector = "";

  for($i = 0;  $i < $list_count; $i++){
    $selector = $selector . "#list_" . $i . ", ";
  }

  $selector = substr($selector, 0, -2);
?>





    <script type="text/javascript">

    var bitch = function(){
      return "Coffee";
    }

      $( function() {
        $( "<?=$selector?>" ).sortable({
          connectWith: ".trello_list_paste",
          stop: function(event, ui){
            var toList = ui.item[0].parentElement.dataset.listId;
            var cardId = ui.item[0].dataset.cardId;
            jQuery.get('/webapi/setCardToList/' + cardId + "/" + toList);
          }
        }).disableSelection();
      } );

      function saveProjectStatus(f_project_id, status_id){

        jQuery.ajax({
          type: 'POST',
          url: '/projects/projects/saveProjectStatus',
          data: 'project_id=' + f_project_id + '&status_id=' + status_id ,
          success: function(r_data){
          
          }
        });
      }

      function showProjectPopup(f_id){
        jQuery(".modal-body").html(" ");
        resetLineNumberItem();
        var items = '';
        jQuery.getJSON('/projects/projects/getAllProjectLines/' + f_id, function(data){
            var items = [];
            resetLineNumberItem();
            jQuery.each(data, function(key_temp, val_temp){
              jQuery.each(val_temp, function(key, val){
              resetLineNumberItem();
              jQuery('.plan_lines_popup_thingy').html("");
              jQuery("#po_debiteur").html(val.contact_name);
              jQuery("#po_project_name").html(val.project_name);
              jQuery("#po_sub_project_name").html(val.sub_project_name);
              jQuery(".line_number_item").attr("id", "line_number_" + val.line_id);
              jQuery("#onClickDingFix").attr("onClick", "slideDownObject("+val.line_id+");").css("cursor", "pointer");
             // jQuery("#ln_click").attr("onClick", "slideDownObject("+val.line_id+");");
              jQuery("#ln_title").html(val.line_name);
              jQuery("#minutes_input").attr('class', 'minutes_input_' + val.line_id);
              
              if(val.worked != null){
                jQuery("#ln_worked").html(val.worked);
                if(parseInt(val.worked) > parseInt(val.estimation)){
                  jQuery("#ln_worked").parent().css('color', '#ff4444');
                } else {
                   jQuery("#ln_worked").parent().css('color', '#00a65a');
                }
              } else {
                jQuery("#ln_worked").html(0);

                 if(val.worked > val.estimation){
                  jQuery("#ln_worked").parent().css('color', '#00a65a');
                }
              }
              jQuery("#ln_minutes_holder ol .removable").remove();
              var minutes_list = [];

           
              jQuery.each(val.minutes, function(mkey, mval){
                minutes_list = minutes_list + ('<li class="removable"> <span class="minutes_date">'+mval.datum+'</span> '+mval.minutes+' min </li>'); 
              });
              jQuery("#ln_minutes_holder ol").html(minutes_list + jQuery("#ln_minutes_holder ol").html());
              jQuery(".done_button").attr("project_line", val.line_id);
              jQuery("#ln_estimated").html(val.estimation);
              jQuery("#ln_description").html(val.description);
              jQuery(".showAll a").attr('href', '/projects/projects/projectLineDetail/' + val.line_id);
              jQuery("#minutes_project_line_id").val(val.line_id);
              jQuery("#ln_internal_description textarea").html(val.internal_description).attr('onKeyUp', 'javascript: saveInternalDescription(' + val.line_id + ');').attr("id", "internal_description_" + val.line_id);
              items.push(jQuery("#lineItemHolder").html());
            });
            });
            jQuery('.plan_lines_popup_thingy').html("").append(items);
            showPopup('Projectregels', jQuery("#project_overview").html(), '', 'OK', '', '', '#');  
            jQuery(document).on('click', '.done_button', function () {             
              if(jQuery(this).html() == "Bevestigen"){
                jQuery.ajax({
                  url: '/projects/projects/setWorkDone/' + jQuery(this).attr("project_line") ,
                  success: function(data){
                    showProjectPopup(f_id);
                  }
                });               
              } else {
                 if(jQuery(this).html() == "Afronden"){
                    jQuery(".done_button").each(function(){
                      jQuery(this).html("Afronden");
                    });
                    jQuery(this).html("Bevestigen");
                 }
              }
            });
         
             
            
        });
      }

    
      function slideDownObject(f_id){
        if(jQuery("#line_number_" + f_id).css("height") != "26px"){
          jQuery("#line_number_" + f_id).css('height', "26px");
        } else {
          jQuery("#line_number_" + f_id).css('height', "100%");  
        }
      } 

      function resetLineNumberItem(){
        jQuery("#ln_click").attr("onClick", " ");
        jQuery("#po_debiteur").html(" ");
        jQuery("#po_project_name").html(" ");
        jQuery("#po_sub_project_name").html(" ");
        jQuery("#po_deadline").html(" ");
        jQuery("#ln_title").html(" ");
        jQuery("#ln_worked").html(" ");
        jQuery("#ln_estimated").html(" ");
        jQuery("#ln_description").html(" ");
        jQuery("#ln_internal_description textarea").html(" ");
      }

      function isNumberKey(evt)
      {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 44 && charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
         return false;
        return true;
      }


      function setWorkedMinutes(f_minutes, f_project_line){
        if(f_minutes != '' && f_minutes != parseInt(0)){
          jQuery.ajax({
            url: '/projects/projects/setUserMinutes/' + f_minutes + '/' + f_project_line,
            method: 'GET',
            success: function(data){
              jQuery("#line_number_"+f_project_line+" #ln_minutes_holder ol li.removable:nth-child(2)").remove();
              jQuery("#line_number_"+f_project_line+" #ln_minutes_holder ol").html("<li class='removable'><span class='minutes_date'>"+$.datepicker.formatDate('dd-mm-yy', new Date())+"</span> "+f_minutes+" min</li>" + jQuery("#ln_minutes_holder ol ").html());
              jQuery("#minuten_field").val("");
            }
          });
        } else {
           jQuery(".minutes_input_" + f_project_line + ' input').css('background-color', '#ffd2d2');
        }
      }

      function saveInternalDescription(f_project_line){
        jQuery.ajax({
          url: '/projects/projects/updateInternaLDescription/' +  f_project_line,
          data: 'internal_description=' + jQuery("#internal_description_" + f_project_line).val(),
          method: 'POST',
          success: function(data){
            
          }
        });
      }



            
    
    </script>


    <div id="project_overview" style="display: none">
      <div class="project_left">
        <p><span class="left_overview">Debiteur:    </span>    <span class="po_debiteur" id="po_debiteur"></span></p>
        <p><span class="left_overview">Project:     </span>    <span class="po_project_name" id="po_project_name"></span></p>
        <p><span class="left_overview">Deelproject: </span>    <span class="po_sub_project_name" id="po_sub_project_name"></span></p> 
        <p><span class="left_overview">Deadline:    </span>    <span class="po_deadline" id="po_deadline"></span></p>
      </div>
      <div id="project_lines_popup" style="margin-top: -12px;">
        <div class="plan_lines plan_lines_popup_thingy">
        
        </div>
      </div>

    </div>

    <div id="lineItemHolder" style="display: none">
      <div id="" class="line_number_item">
        <span id="onClickDingFix" style="padding-bottom: 5px; display: block; border-bottom: 1px solid #f4f4f4; width: 100%"> <span id="ln_title" style="font-weight: bold;">Website aanpassingen tbv Google</span>
          <span class="right"> 
            <span style="color: #00a65a; font-weight: bold;"><span id="ln_worked">105</span></span> / <span id="ln_estimated">180</span> min 
            <i id="ln_click" onClick="javascript: slideDownObject();" class="fa fa-angle-down right-fa"></i> 
          </span></span>
          <div class="description_holder" id="ln_description" style="margin: 5px 0 10px 0;">
            Punten die uit SEO rapport komen, oppakken en verwerken.
          </div>
          <div class="minutes_holder" > 

             

            <div id="ln_minutes_holder">
              <ol>

                <li class="removable"> 
                  <span class="minutes_date">05-01-2016</span> 30 min
                </li>
                
                 <li class="removable"> 
                  <span class="minutes_date">04-01-2016</span> 15 min
                </li>

                <li class="fixed showAll">
                  <a href="/projects/projects/projectLineDetail">Bekijk alles</a>
                </li>

                <li class="fixed btn-success">
                  <a class="done_button" href="#">Afronden</a>
                </li>

              </ol>
            </div>
          
            
          </div>  
          <div class="internal_description" id="ln_internal_description">
            <textarea>
            </textarea>
          </div> 
        </div>
</div>

    <style type="text/css">

     .line_number_item ol li{
        text-align: right;
        padding: 4px 10px 4px 10px !important;  
      }

    .line_number_item  li.fixed{
        text-align: center;
        width: 49%;
        float:left;
      }
      .fixed a{
        text-align: center;
        color: #ffffff;
      }

    .line_number_item  ol li.fixed.btn-success{
        background-color: #5cb85c;
        float: right;
      }

    .line_number_item  ol li.fixed.btn-success:hover{
        background-color: #008d4c;
      }

    .line_number_item  ol li .minutes_date{
        float: left;
      }

      @media(min-width: 768px){

        div.minutes_holder{
          vertical-align:top;
          display: inline-block;
          width: 40%;
          clear:both;
          margin-top: 4px;
      }

        .modal-dialog{
          width: 1024px;
        }

        .project_left{
          display: inline-block;
          width: 40%;
          vertical-align: top;
        }
        #project_lines_popup{
          display: inline-block;
          vertical-align: top;
          width: 56%;
          margin-left: 3%;
        }
      }

      

      .internal_description{
        width: 55.5%;
        margin-left: 3.5%;
        vertical-align: top;
        display: inline-block;
      }

      .modal{
       /* position: absolute !important;*/
      }

      .internal_description textarea{
        width: 100%;
        resize: none;
        border-radius: 5px;
        height: 140px;
        border: 1px solid #f0f0f0;
      }

     .modal ol{
        float:left;
            width: 100%;
        padding-left:0;
      }

      .line_number_item ol li{
        float: left;
      }

      .minutes_holder{
          vertical-align:top;
          display: inline-block;
          width: 100%;
          clear:both;
          margin-top: 4px;
      }

      .minutes_input{
          vertical-align:top;
          display: inline-block;
          float:left;
          clear:both;
          margin-bottom: 4px;
      }

      .minutes_input .input-group{
        width: 80%;
        float:left;
      }

      .minutes_holder:hover{
        cursor: default !important;
      }

      .left_overview{
        display: inline-block;
        width: 150px;
      }

      .right{
        float:right;
      }

      .inner_process{
        display: inline-block;
        height: 100%;
        float:left;
        background-color: #ffffff;
      }

      .project_name_drag{
        display: inline-block;
        width: 65%;
      }

      .project_est_time{
        display: inline-block;
        width: 100px;
        text-align: right;
      }

      .drop-hover{
        background-color: #A3F5D0;
        transition: 0.3s ease;
        border: none !important;
      }

      .right-fa{
        margin-left: 6px;
      }

      div.plan_lines>div{
        height: 26px;
        overflow: hidden;
      }

    </style>
