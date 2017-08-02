<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="content-wrapper">
        <section class="content-header">
          <h1>
            Projecten
            <small>Nieuw project</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-tasks"></i> Home</a></li>
            <li><a href="#">Projecten</a></li>
            <li class="active">Nieuw</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header fixTop">
                  <h3 class="box-title">Projectgegevens</h3>
                   
                </div>

                <script>

                  function sendForm(){
                    
                      jQuery.ajax({
                        url: '/projects/projects/createBaseProject/' ,
                        data: jQuery("#createNew").serialize(),
                        method: 'POST',
                        success: function(data){
                          console.log(data);
                          if(data.indexOf('nope') < 0){
                            window.location = '/projectsm/projectsm/edit/' + data.trim() + "?saved=1";  
                          } else {
                            jQuery(".melding").slideDown();
                          }
      
                        }
                      });
                   
                  }

                </script>

                <div class="box-body">
                  <div class="melding" style="display: none">
                  <div class="callout callout-danger" onClick="javascript: jQuery('.melding').slideUp();" >
                            <h4>Er is iets fout gegaan</h4>
                            <p>Waarschijnijk kan de klant niet worden gevonden, of zijn niet alle velden ingevuld.</p>
                          </div>
                          </div>
                  <form method="post" id="createNew">
                    <div class="row">
                      <div class="form-group col-sm-6">
                          <label>Klant</label>
                          <input type="text" class="form-control" id="contact_name" placeholder="Klant" value="" name="contact_name">
                      </div>


                      <div class="form-group col-sm-6">
                          <label>Projectnaam</label>
                          <input type="text" class="form-control" id="project_name" placeholder="Projectnaam" value="" name="project_name">
                      </div>
                    </div>

                    <div class="row">


                      <div class="col-sm-12">
                        <button class="btn btn-success pull-right" onClick="javascript: sendForm();return false;">Volgende</button>
                      </div>


                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>




   
            </div>
          </div>
        </section>
      </div>

<script type="text/javascript">

      jQuery(document).ready(function(){
        var options = {

        //url: "/offers/offers/contactAjax",

        url: function(dataStr){
          return "/offers/offers/contactAjax/" + dataStr;
        },

        getValue: "name",

        list: { 
          match: {
            enabled: true
          }
        }

       
      };

      $("#contact_name").easyAutocomplete(options);
      });

    </script>

                         