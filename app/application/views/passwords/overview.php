<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Wachtwoorden
            <small>Overzicht</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-key"></i> Home</a></li>
            <li class="active">Wachtwoorden</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header fixTop">
                  <h3 class="box-title">Wachtwoorden</h3>
                  <button class="btn btn-success pull-right" onclick="javascript: addNewPassword();">Nieuw</button>
                </div>

                <div class="box-body">
            
                         <table id="passwordTable" class="table table-bordered table-hover dataTable">
                            <thead>
                              <tr>
                                <th>Naam</th>
                                <th>Server</th>
                                <th>Gebruikersnaam</th>
                                <th width="117">&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>              
                                  
                                <?php
                                  foreach($userdata as $data){
                                ?>

                                <tr>
                                  <td><?php echo $data->name; ?></td>
                                  <td><?php echo $data->servername; ?></td>
                                  <td><?php echo $data->username; ?></td>
                                  <td>
                                           <a class="btn btn-success pull-right" href="javascript: showPasswordPopup(<?php echo $data->id?>, '<?php echo $data->name?>');"><i class="fa fa-key"></i></a>
                                           <a class="btn btn-danger pull-right" href="javascript: showDeletePopup(<?php echo $data->id?>, '<?php echo $data->name?>');"><i class="fa fa-trash"></i></a>
                                          
                                  </td>
                                </tr>



                                <?php 
                                  }
                                ?>



                            </tbody>
                            
                          </table>
                        


                  </div>

                </div>
              </div>
            </div>
            




        </section>

    </div>

<div class="fixding">
    <div id="passwordBox" style= "display: none">
      

      <div class="clearBox">
        <p>Wat is je Wiped Wachtwoord?</p>
        <div class="form-group">
          <form onSubmit="javascript: getPasswordData(f_id); return false;">
          <input type="password" name="password" id="passwordBoxInput" class="form-control" placeholder="Wachtwoord" value=""></form>
        </div>
      </div>

    </div>
    </div>



    <div class="fixding2">
    <div id="newBox" style= "display: none">
      

      <div class="clearBox">
        <p>Voeg een nieuw wachtwoord toe</p>
        <div class="form-group">
          <form id="newPasswordDetails">
            <p><input type="text" name="name" id="nameBox" class="form-control" placeholder="Naam" value=""></p>
            <p><input type="text" name="servername" id="serverBox" class="form-control" placeholder="Server" value=""></p>
            <p><input type="text" name="username" id="userBox" class="form-control" placeholder="Gebruikersnaam" value=""></p>
            <p><input type="text" name="password" id="passwdBox" class="form-control" placeholder="Wachtwoord" value=""></p>
          </form>
        </div>
      </div>

    </div>
    </div>




    <script type="text/javascript">

    $(function () {
        $('#passwordTable').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": false,
          "autoWidth": false
        });
      });


      function showPasswordPopup(f_id, f_title){
        jQuery("#modalBox .modal-body").html("");
        
    
        showPopup(f_title, jQuery(".fixding #passwordBox").html().replace('f_id', f_id), '', '', '', 'Verder', 'javascript: getPasswordData("'+f_id+'");');  
          jQuery(".modal-body #passwordBoxInput").focus();
      }    


       function addNewPassword(){
         jQuery("#modalBox .modal-body").html("");
        
    
          showPopup("Nieuw wachtwoord toevoegen", jQuery(".fixding2 #newBox").html(), '', '', '', 'Opslaan', 'javascript: savePassword();');  
           
      }




      function showDeletePopup(f_id, f_name){
         jQuery("#modalBox .modal-body").html("");
        
    
          showPopup("Verwijderen", "Weet u zeker dat u het wachtwoord '"+f_name+"' wilt verwijderen?", '', '', 'Nee', 'Ja', 'javascript: removePassword('+f_id+');');  
           
      }

      function removePassword(f_id){
        jQuery.get("/passwords/passwords/deletePassword/" + f_id, function(data){
          window.location = window.location;
        });
      }

      function getPasswordData(f_id)      {
        jQuery(".modal-body .clearBox").slideUp();
        var url = "/passwords/passwords/showDetails/" + f_id;
        var sendData = {id: f_id, password: jQuery(".modal-body #passwordBoxInput").val()};


        jQuery.post(url, sendData, function(data){
          if(data.indexOf("onjuist") == -1){
            jQuery(".modal-body .clearBox").html(data).slideDown();
          } else {
            jQuery(".modal-body .clearBox").slideDown();
          }
          
          
        });
      }

      function savePassword(){
        var postData = jQuery("#newPasswordDetails").serialize();
        var url = "/passwords/passwords/addPassword";
        jQuery.post(url, postData, function(data){
          if(data.indexOf("ok") != -1){
            window.location = window.location;
          }
        });
      }
    </script>