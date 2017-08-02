<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="content-wrapper">
        <section class="content-header">
          <h1>
            Planning
            <small>Overzicht</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-table"></i> Home</a></li>
            <li class="active">Planning</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-6">
              <div class="box">
                <div class="box-header fixTop">
                  <h3 class="box-title">Te plannen projecten</h3>
                </div>

                <div class="box-body">

                       
                	<ul id="projects" class="plan_lines draggable">
                	</ul>


                  </div>

                </div>
              </div>

              <style type="text/css">
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

                
              </style>

               <div class="col-xs-6">
              <div class="box">
                <div class="box-header fixTop">
                  <h3 class="box-title">Medewerkers</h3>
                </div>

                <div class="box-body">

                  
                  <?php
                    foreach($users as $user):
                  ?>

                    <div style="padding: 6px 5px;border-radius: 6px;" id="user_<?=$user->id?>"  class="user_item" onClick="javascript: getProjectLinesByUser(<?=$user->id?>);" userid="<?=$user->id?>">
                      <h5 class="user_name"><?=$user->name?> <span class="arrow-down"><i class="fa fa-arrow-down"></i></span><span class="aval_till"> Tot: <span id="aval_<?=$user->id?>">21-01-2015</span></span></h5>

                      <div class="current_project_lines current_project_lines_<?=$user->id?>">

                        <ul class="current_lines" id="current_lines_<?=$user->id?>">
                       </ul>
                      </div>  
                    </div>

                  <?php
                    endforeach;
                  ?>       
                  

                </div>

                </div>
              </div>


            </div>
            

         </div>


       	</section>

    </div>

    <script type="text/javascript">


  


    	jQuery(document).ready(function(){



           jQuery( "#current_lines" ).sortable({
              stop: function(event, ui) {
                postdata = jQuery( "#current_lines" ).sortable('serialize');
                jQuery.ajax({
                  url: "/offers/offers/setOfferLinesPriority",
                  data: postdata,
                  method: "POST",
                  success: function(result){
                    generatePreview(); 
                  }
                });
              }
             }); 


            jQuery( ".current_lines" ).sortable({
              connectWith: '.current_lines',
              stop: function(event, ui) {
                postdata = jQuery( this ).sortable('serialize');
              }
             });
          

            jQuery( ".user_item" ).droppable({
            hoverClass: "drop-hover",
              connectWith: '#current_lines li',
            drop: function( event, ui ) {
              var sub_project_id = jQuery(ui.draggable).attr("id").replace('project_','');
              var user_id = jQuery(event.target).attr("id").replace("user_", "");
              jQuery.get("/plan/plan/setProjectToUser/" + sub_project_id + '/' + user_id + "/", function(data){
    
              });
              jQuery (ui.draggable).remove();
              
            }
          });

     		jQuery.getJSON('/plan/plan/getplanprojects/', function(data){
          var teller = 0;
    			jQuery.each(data, function (key, val) {

    				jQuery.each(val, function (key2, val2) {
              teller = teller + 1;

    					jQuery("#projects").html(jQuery("#projects").html() + '<h4>'+key2+'</h4>');
    					jQuery.each(val2, function (key3, val3) {
    						jQuery("#projects").html(jQuery("#projects").html() + '<li id="project_' + val3.sub_project_id + '"><span class="project_name_drag">' + val3.division_name +": " +val3.category+ '</span> <span class="project_est_time">'  + val3.total_estimation + ' min</span>' +'<span class="rightzoom" id="zoom_'+val3.sub_project_id+'"><i class="fa fa-search"></i></span></li>');
    					});
    				});
    			});

          if(teller == 0){
            jQuery("#projects").html("<p>Goed werk geleverd vandaag! Alle projecten zijn ingepland.");
            alert(teller);
          }


          jQuery( ".draggable li" ).draggable({
            connectWith: '.user_item',
            revert: true,
            opacity: 0.7
          });
          jQuery('.rightzoom').click(function(){
            var sub_project_id = jQuery(this).attr('id').replace('zoom_', '');

            jQuery.getJSON('/plan/plan/getSubprojectDetails/' + sub_project_id, function(f_data){
              jQuery("#po_debiteur").html(f_data.debiteur);
              jQuery("#po_project_name").html(f_data.project_name);
              jQuery("#po_sub_project_name").html(f_data.sub_project_name);
              jQuery("#po_total_estimation").html(f_data.total_estimation + " min");
              jQuery("#po_deadline").html(f_data.deadline);
              jQuery("#po_executive_user").html(f_data.executive_user);

              jQuery.getJSON('/plan/plan/getProjectlines/' + sub_project_id, function(f_data){
                jQuery('.plan_lines_popup_thingy').html("");
                jQuery.each(f_data, function(key, val){
  
                  jQuery('.plan_lines_popup_thingy').html(jQuery('.plan_lines_popup_thingy').html() + "<li>"+val.name+"<span class='right'>"+val.estimation+" min</span></li>");

                });

                showPopup('Deelproject Overzicht', jQuery("#project_overview").html(), '', 'OK', '', '', '#');  
              });

              
            });


            

          });


    		});
    	});


    function getProjectLinesByUser(f_id){
     
        user_id = f_id;

        jQuery.getJSON("/plan/plan/getProjectsByUser/" + user_id, function(data){
          var items = [];
          jQuery.each(data, function (key, obj) {
            user_id = obj.user_id;

            str_width = "";
            current_percentage = 0;
            if(obj.percentage > 0){
              current_percentage = obj.percentage;
              str_width = ' style="width: '+obj.percentage+'%" ';
            }

            if(obj.visible == "1"){
              visibleClass = "eye";
            } else {
              visibleClass = "eye-slash";
            }

            //console.log(obj);

            items.push('<li><span class="line_name" title="'+obj.project_name+'">'+obj.sub_project_name+'</span>   <span class="line_customer" title="'+obj.debiteur+'">'+obj.debiteur+'</span>      <span class="processbar" title="Voortgang: '+current_percentage+'%"><span '+str_width+' class="inner_process"></span> </span>     <span title="'+obj.project_name+'" id="visible_eye_'+obj.sub_project_id+'" onclick="javascript: setVisible('+obj.sub_project_id+');" class="visible_eye fa fa-'+visibleClass+'"></span> <a style="color: #ffffff;" onclick="javascript: removeProjectFromPlanningConfirm('+obj.sub_project_id+', '+user_id+');" class="pull-right" href="javascript: void(0);"><i class="fa fa-close"></i></a>  </li>');
          });


          jQuery("#user_" + user_id + " .current_lines").html("").append(items);


          
        });


        jQuery('.current_project_lines_<?=$user->id?>').slideDown();
    } 


    function setVisible(f_id){
      jQuery.ajax({
        url: '/plan/plan/setVisible/' + f_id ,
        success: function(data){
          if(data == "1"){
            visibleClass = "eye";
          }
          else{
            visibleClass = "eye-slash";
          }
          jQuery("#visible_eye_" + f_id).removeClass("fa-eye").removeClass("fa-eye-slash").addClass(visibleClass);
        }
      });   
    }

    function removeProjectFromPlanning(f_id, f_user){
      jQuery.ajax({
        url: '/plan/plan/removeProjectFromPlanning/' + f_id,
        success: function(data){

          getProjectLinesByUser(f_user);



            jQuery("#projects").html("");




           jQuery( "#current_lines" ).sortable({
              stop: function(event, ui) {
                postdata = jQuery( "#current_lines" ).sortable('serialize');
                jQuery.ajax({
                  url: "/offers/offers/setOfferLinesPriority",
                  data: postdata,
                  method: "POST",
                  success: function(result){
                    generatePreview(); 
                  }
                });
              }
             }); 


            jQuery( ".current_lines" ).sortable({
              connectWith: '.current_lines',
              stop: function(event, ui) {
                postdata = jQuery( this ).sortable('serialize');
              }
             });
          

            jQuery( ".user_item" ).droppable({
            hoverClass: "drop-hover",
              connectWith: '#current_lines li',
            drop: function( event, ui ) {
              var sub_project_id = jQuery(ui.draggable).attr("id").replace('project_','');
              var user_id = jQuery(event.target).attr("id").replace("user_", "");
              jQuery.get("/plan/plan/setProjectToUser/" + sub_project_id + '/' + user_id + "/", function(data){
    
              });
              jQuery (ui.draggable).remove();
              
            }
          });

        jQuery.getJSON('/plan/plan/getplanprojects/', function(data){
          var teller = 0;
          jQuery.each(data, function (key, val) {

            jQuery.each(val, function (key2, val2) {
              teller = teller + 1;

              jQuery("#projects").html(jQuery("#projects").html() + '<h4>'+key2+'</h4>');
              jQuery.each(val2, function (key3, val3) {
                jQuery("#projects").html(jQuery("#projects").html() + '<li id="project_' + val3.sub_project_id + '"><span class="project_name_drag">' + val3.division_name +": " +val3.category+ '</span> <span class="project_est_time">'  + val3.total_estimation + ' min</span>' +'<span class="rightzoom" id="zoom_'+val3.sub_project_id+'"><i class="fa fa-search"></i></span></li>');
              });
            });
          });

          if(teller == 0){
            jQuery("#projects").html("<p>Goed werk geleverd vandaag! Alle projecten zijn ingepland.");
            alert(teller);
          }


          jQuery( ".draggable li" ).draggable({
            connectWith: '.user_item',
            revert: true,
            opacity: 0.7
          });
          jQuery('.rightzoom').click(function(){
            var sub_project_id = jQuery(this).attr('id').replace('zoom_', '');

            jQuery.getJSON('/plan/plan/getSubprojectDetails/' + sub_project_id, function(f_data){
              jQuery("#po_debiteur").html(f_data.debiteur);
              jQuery("#po_project_name").html(f_data.project_name);
              jQuery("#po_sub_project_name").html(f_data.sub_project_name);
              jQuery("#po_total_estimation").html(f_data.total_estimation + " min");
              jQuery("#po_deadline").html(f_data.deadline);
              jQuery("#po_executive_user").html(f_data.executive_user);

              jQuery.getJSON('/plan/plan/getProjectlines/' + sub_project_id, function(f_data){
                jQuery('.plan_lines_popup_thingy').html("");
                jQuery.each(f_data, function(key, val){
  
                  jQuery('.plan_lines_popup_thingy').html(jQuery('.plan_lines_popup_thingy').html() + "<li>"+val.name+"<span class='right'>"+val.estimation+" min</span></li>");

                });

                showPopup('Deelproject Overzicht', jQuery("#project_overview").html(), '', 'OK', '', '', '#');  
              });

              
            });


            

          });


        }); 








          
        }
      });
    }


    function  removeProjectFromPlanningConfirm(f_id, f_user){
      showPopup('Project terug in planning zetten ', "<p>Weet je zeker dat je dit project terug in de planning wilt zetten? Er kunnen door deze persoon geen minuten meer worden ingevuld voor dit project.</p>", '', '', 'Nee', 'Ja', 'javascript: removeProjectFromPlanning(' + f_id + ', ' + f_user+ ');');  
    }
  

    </script>

    <div id="project_overview" style="display: none">
      <p><span class="left_overview">Debiteur: </span> <span id="po_debiteur"></span></p>
      <p><span class="left_overview">Project: </span> <span id="po_project_name"></span></p>
      <p><span class="left_overview">Deelproject: </span> <span id="po_sub_project_name"></span></p> 
      <br>
      <p><span class="left_overview">Inschatting: </span> <span id="po_total_estimation"></span></p>
      <p><span class="left_overview">Deadline: </span> <span id="po_deadline"></span></p>
      <p><span class="left_overview">Voorkeursuitvoerder: </span> <span id="po_executive_user"></span></p>
      <br>
      <a id="remove_show_project_lines" href="javascript: jQuery('#project_lines_popup').slideDown(); jQuery('#remove_show_project_lines').slideUp();">Toon projectregels</a>
      <br>
      <div id="project_lines_popup" style="display: none; margin-top: -12px;">
        <ul class="plan_lines plan_lines_popup_thingy">
        
        </ul>
      </div>
    </div>

    <style type="text/css">
      .left_overview{
        display: inline-block;
        width: 150px;
      }

      .right{
        float:right;
      }

      .visible_eye{
        font-size: 20px;
        margin-left: 10px;
      }

      .visible_eye.fa-eye-slash{
        color: lightgray;
      }
    </style>