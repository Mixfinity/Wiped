<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header">
          <h1>
            Projectbeheer
            <small><?=$type?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-plus-square"></i> Home</a></li>
            <li><a href="/projectm/projectm">Projectbeheer</a></li>
            <li class="active"><?=$type?></li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header fixTop">
                  <?php
                  if($type == "Bewerken"){
                  ?>
                    <h3 class="box-title">Project &quot; <?=$project->name?> &quot; bewerken. Projectnummer: <?=$project_id?></h3>
                  <?php
                  } else {
                  ?>
                    <h3 class="box-title">Project aanmaken</h3> 
                  <?php
                  }
                  ?>

                </div>
                </div>
              </div>
            </div>
  <?php 
    if(!$project->init): 
  ?>
          
            <iframe src="https://unicorn.wiped.nl/api/createChecklistItem/<?=$project->trello_first_list?>/<?=$project->id?>" frameborder="0" style="display: none;"></iframe>

<?php 
  endif;
?>
            <div class="row">

              <div class="col-md-5">
                <div class="box box-warning">
                  <div class="box-header">
                    <h3 class="box-title">Projectregels</h3>
                  </div>

                  <div class="box-body" id="project_result">

          
                
                  </div>
                </div>
              </div>


              <div class="col-md-7">

                <div class="box box-info">
                  <div class="box-header">
                    <h3 class="box-title">Projectregel aanmaken</h3>
                  </div>

                  <div class="box-body">
                    <form name="plFrm" id="plFrm" onSubmit="javascript: return false;">
                      <input type="hidden" name="line_id" id="line_id" value="">
                      <input type="hidden" name="project_id" id="project_id" value="<?=$project->id?>">
                      <div class="form-group">
                        <label>Titel</label>
                        <input type="text" name="name" class="form-control" placeholder="Titel" value="">
                      </div>

                      <div class="form-group">
                        <label>Deelproject</label>
                        <input type="text" name="category" class="form-control" placeholder="Deelproject" value="">
                      </div>

                      <div class="form-group">
                        <label>Inschatting minuten</label>
                        <input type="text" name="estimation" class="form-control" placeholder="Inschatting minuten" value="">
                      </div>

                      <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="division_id">
                          <option value="">Maak een keuze...</option>
                      <?php  foreach($divisions as $division) { ?>
                         <option value="<?=$division->id?>"><?=$division->name?></option>
                      <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Voorkeursuitvoerder</label>
                        <select class="form-control" name="employee_id">
                          <option value="">Maak een keuze...</option>
                          <?php  foreach($users as $user) { ?>
                             <option value="<?=$user->id?>"><?=$user->name?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Omschrijving</label>
                        <textarea class="form-control noresize descTxt" name="description"></textarea>
                      </div>


                      <div class="form-group">
                        <label>Interne info</label>
                        <textarea class="form-control noresize descTxt" name="internal_description"></textarea>
                      </div>

                      <button class="btn btn-info pull-right" onClick="javascript: return saveProjectLine();">Opslaan</button>
                      <button class="btn btn-warning pull-right pull-alittleright" onClick="javascript: approveProject()">Project in planning zetten</button>
                   

                    </form>
                  </div>
                </div>



              </div>



            </div>
            

  


       	</section>

    </div>

    <script type="text/javascript">

      function approveProject(){
        showPopup('Project doorzetten', 'Weet u zeker dat u dit project wilt doorzetten naar planning?', '', 'Nee', '', 'Ja', '/projectsm/projectsm/setProjectPlanning/<?=$project->id?>');
        return false;
      }

      function deleteProjectLine(f_event){
      
        showPopup('Verwijderen', 'Weet u zeker dat u deze projectregel wilt verwijderen?', 'Ja', 'Nee', '', '', '/projectsm/projectsm/removeProjectLine/' + f_event + '/<?=$project->id?>');

      }

      jQuery(document).ready(function(){

          getProjectData();

      
      });


      function getProjectData(){
         jQuery.getJSON( '/projectsm/projectsm/getCurrentProjectLines/<?=$project->id?>', function( data ) {
        var ReplaceValue = '';
        var items = [];

        jQuery.each( data, function( key, value ) {

          jQuery.each(value, function(index, val) {
           ReplaceValue = ReplaceValue + "<h4 class='box-title'>" + index + "</h4>";

              jQuery.each(val, function(index2, val2) {

                jQuery.each(val2, function(index3, val3) {
                    ReplaceValue = ReplaceValue +"<h5 class='box-title'>&nbsp;&nbsp;&nbsp;" + index3 + "</h5><ol id='current_lines' class='current_lines '>";

                    jQuery.each(val3, function(index4, val4) {
                       ReplaceValue = ReplaceValue + "<li onclick='javascript:editSelectedLine("+val4.project_line_id+");' class='edit_proj_item' data-id='" + val4.project_line_id + "' style='float:left;'>" + 
                        "<span class='col-md-9'>"+val4.project_line_name+"</span>" + 
                        "<span class='col-md-2' style='text-align: right;'>"+val4.estimation+" min</span>" +
                        "<span class='col-md-1' style='text-align: right;'>" + 
                         " <a class='removeProjectLineBtn' href='javascript: deleteProjectLine("+val4.id+");'> "+ 
                            "<i class='fa fa-close' style='color: #ffffff;'></i>" +
                          "</a>" + 
                        "</span>" +
                      "</li>";
                    });

                    ReplaceValue = ReplaceValue + "</ol>";

                });
          
              });
            });
          });
         jQuery("#project_result").html( ReplaceValue );
         jQuery(".removeProjectLineBtn").each(function(){
          jQuery(this).click(function(e){
            e.stopPropagation();
          }); 
        });

        });
      }
      function saveProjectLine(){

        jQuery.ajax({
          type: 'POST',
          url: '/projectsm/projectsm/saveProjectLine',
          data: jQuery("#plFrm").serialize() ,
          success: function(r_data){
            if(r_data != ''){
              jQuery("#line_id").val(r_data.replace(' ', ''));
              getProjectData();
              clearProjectLineAdd();
            }
          }
        });


      }

function editSelectedLine(f_event){

  jQuery.getJSON('/projectsm/projectsm/prepareEditProjectLine/' + f_event, function(data){
      $.each(data,function(key,value) {
          jQuery("#plFrm").find("input[name='"+key+"']").val(value);
          if(key == "description" || key == "internal_description"){
            jQuery("#plFrm").find("textarea[name='"+key+"']").html(value);
          }
          if(key == "employee_id" || key =="division_id" ){
            jQuery("#plFrm").find("select[name='" + key + "']").find("option[value='"+value+"']").attr('selected', true);
          }
          if(key == "id"){
            jQuery("#plFrm").find("input[name='line_id']").val(value);
          }
      });



  });
  return true;

}


function print_r (array, return_val) {
  var output = '',
    pad_char = ' ',
    pad_val = 4,
    d = this.window.document,
    getFuncName = function (fn) {
      var name = (/\W*function\s+([\w\$]+)\s*\(/).exec(fn);
      if (!name) {
        return '(Anonymous)';
      }
      return name[1];
    },
    repeat_char = function (len, pad_char) {
      var str = '';
      for (var i = 0; i < len; i++) {
        str += pad_char;
      }
      return str;
    },
    formatArray = function (obj, cur_depth, pad_val, pad_char) {
      if (cur_depth > 0) {
        cur_depth++;
      }

      var base_pad = repeat_char(pad_val * cur_depth, pad_char);
      var thick_pad = repeat_char(pad_val * (cur_depth + 1), pad_char);
      var str = '';

      if (typeof obj === 'object' && obj !== null && obj.constructor && getFuncName(obj.constructor) !== 'PHPJS_Resource') {
        str += 'Array\n' + base_pad + '(\n';
        for (var key in obj) {
          if (Object.prototype.toString.call(obj[key]) === '[object Array]') {
            str += thick_pad + '[' + key + '] => ' + formatArray(obj[key], cur_depth + 1, pad_val, pad_char);
          }
          else {
            str += thick_pad + '[' + key + '] => ' + obj[key] + '\n';
          }
        }
        str += base_pad + ')\n';
      }
      else if (obj === null || obj === undefined) {
        str = '';
      }
      else { // for our "resource" class
        str = obj.toString();
      }

      return str;
    };

  output = formatArray(array, 0, pad_val, pad_char);

  if (return_val !== true) {
    if (d.body) {
      this.echo(output);
    }
    else {
      try {
        d = XULDocument; // We're in XUL, so appending as plain text won't work; trigger an error out of XUL
        this.echo('<pre xmlns="http://www.w3.org/1999/xhtml" style="white-space:pre;">' + output + '</pre>');
      } catch (e) {
        this.echo(output); // Outputting as plain text may work in some plain XML
      }
    }
    return true;
  }
  return output;
}


function clearProjectLineAdd(){
  jQuery("#line_id").val("");
  jQuery("#plFrm input[type=text]").each(function(){
    jQuery(this).val("");
  });
  jQuery("#plFrm textarea").each(function(){
    jQuery(this).val("");
  });

  jQuery("#plFrm select").each(function(){
    jQuery(this).val("");
  });
}
    </script>