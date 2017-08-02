<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form method="post" name="editFrm" id="editFrm">
	<div class="content-wrapper">
        <section class="content-header">
          <h1>
            Klanten
            <small>Nieuw</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/dashboard/dashboard"><i class="fa fa-users"></i> Home</a></li>
            <li><a href="/contacts/contacts">Klanten</a></li>
            <li class="active">Nieuw</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">

              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Nieuwe klant</h3>
                  <button class="btn btn-success pull-right" onClick="javascript: document.editFrm.submit();">Opslaan</button>
                </div>
             </div>
            </div>
          </div>

          <div class="row">
            
            <div class="col-md-6">
              
              <div class="box box-warning">
                
                <div class="box-header">
                  <h3 class="box-title">Algemeen</h3>
                </div>

                <div class="box-body">
                  
                  <div class="form-group">
                    <label>Debiteurnummer</label>
                    <input type="text" class="form-control" placeholder="Debiteurnummer wordt toegekend na opslaan" value="" disabled="">
                  </div>


                  <div class="form-group">
                    <label>Bedrijfsnaam</label>
                    <input type="text" name="name" class="form-control" placeholder="Bedrijfsnaam" value="">
                  </div>


                  <div class="form-group">
                    <label>Adres</label>
                    <input type="text" name="address" class="form-control" placeholder="Adres" value="">
                  </div>

                  <div class="form-group">
                    <label>Postcode</label>
                    <input type="text" name="zip" class="form-control" placeholder="Postcode" value="">
                  </div>

                  <div class="form-group">
                    <label>Plaats</label>
                    <input type="text" name="city" class="form-control" placeholder="Plaats" value="">
                  </div>

                  <div class="form-group">
                    <label>Land</label>
                    <input type="text" name="country" class="form-control" placeholder="Land" value="Nederland">
                  </div>

                  <div class="form-group">
                    <label>Opmerking</label>
                    <textarea class="form-control" name="notify" placeholder="Opmerking"></textarea>
                  </div>

                

                </div>
        

              </div>


              <div class="box box-info">
                
                <div class="box-header">
                  <h3 class="box-title">Bedrijfsgegevens</h3>
                </div>

                <div class="box-body">
                  
                  <div class="form-group">
                    <label>Telefoon</label>
                    <input type="text" name="phone" class="form-control" placeholder="Telefoon" value="">
                  </div>

                  <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" name="email" class="form-control" placeholder="E-mail" value="">
                  </div>

                  <div class="form-group">
                    <label>Website</label>
                    <input type="text" name="website" class="form-control" placeholder="Website" value="">
                  </div>


                  <div class="form-group">
                    <label>KvK</label>
                    <input type="text" name="kvk" class="form-control" placeholder="Kamer van Koophandel" value="">
                  </div>

                  <div class="form-group">
                    <label>BTW</label>
                    <input type="text" name="btw" class="form-control" placeholder="BTW nummer" value="">
                  </div>


                </div>
        

              </div>






         



            </div>

            <div class="col-md-6">
              
              <div class="box box-primary">
                
                <div class="box-header">
                  <h3 class="box-title">Contactpersoon</h3>
                </div>

                <div class="box-body">

                  <div class="form-group">
                    <label>Naam</label>
                    <input type="text" name="contact_name" class="form-control" placeholder="Naam van contactpersoon" value="">
                  </div>

                   <div class="form-group">
                    <label>Telefoon</label>
                    <input type="text" name="contact_phone" class="form-control" placeholder="Telefoonnummer van contactpersoon" value="">
                  </div>

                   <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" name="contact_email" class="form-control" placeholder="E-mail van contactpersoon" value="">
                  </div>
                  
              
                  
                </div>
        

              </div>




           




            </div>

          </div>




          


        </section>
</div>
</form>