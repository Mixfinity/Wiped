<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form method="post" name="editFrm" id="editFrm">
	<div class="content-wrapper">
        <section class="content-header">
          <h1>
            Klanten
            <small>Bewerken</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/dashboard/dashboard"><i class="fa fa-users"></i> Home</a></li>
            <li><a href="/contacts/contacts">Klanten</a></li>
            <li class="active">Bewerken</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">

              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">&quot;<?=$contact->name?>&quot; bewerken</h3>
                  <button class="btn btn-success pull-right" onClick="javascript: document.editFrm.submit();">Opslaan</button>
                  <?php
                    if($saved){?><br><br>
                          <div class="callout callout-success" onClick="javascript: jQuery('.callout').slideUp();" >
                            <h4>Opgeslagen</h4>
                            <p>De gegevens zijn met succes opgeslagen</p>
                          </div>
                  <?php }
                  ?>
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
                    <input type="hidden" name="id" value="<?=$contact->id?>">
                    <input type="text" class="form-control" placeholder="Debiteurnummer wordt toegekend na opslaan" value="<?=$contact->id?>" disabled="">
                  </div>


                  <div class="form-group">
                    <label>Bedrijfsnaam</label>
                    <input type="text" name="name" class="form-control" placeholder="Bedrijfsnaam" value="<?=$contact->name?>">
                  </div>


                  <div class="form-group">
                    <label>Adres</label>
                    <input type="text" name="address" class="form-control" placeholder="Adres" value="<?=$contact->address?>">
                  </div>

                  <div class="form-group">
                    <label>Postcode</label>
                    <input type="text" name="zip" class="form-control" placeholder="Postcode" value="<?=$contact->zip?>">
                  </div>

                  <div class="form-group">
                    <label>Plaats</label>
                    <input type="text" name="city" class="form-control" placeholder="Plaats" value="<?=$contact->city?>">
                  </div>

                  <div class="form-group">
                    <label>Land</label>
                    <input type="text" name="country" class="form-control" placeholder="Land" value="<?=$contact->country?>">
                  </div>
                  
                  <div class="form-group">
                    <label>Opmerking</label>
                    <textarea class="form-control" name="notify" placeholder="Opmerking"><?=$contact->notify?></textarea>
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
                    <input type="text" name="phone" class="form-control" placeholder="Telefoon" value="<?=$contact->phone?>">
                  </div>

                  <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" name="email" class="form-control" placeholder="E-mail" value="<?=$contact->email?>">
                  </div>

                  <div class="form-group">
                    <label>Website</label>
                    <input type="text" name="website" class="form-control" placeholder="Website" value="<?=$contact->website?>">
                  </div>


                  <div class="form-group">
                    <label>KvK</label>
                    <input type="text" name="kvk" class="form-control" placeholder="Kamer van Koophandel" value="<?=$contact->kvk?>">
                  </div>

                  <div class="form-group">
                    <label>BTW</label>
                    <input type="text" name="btw" class="form-control" placeholder="BTW nummer" value="<?=$contact->btw?>">
                  </div>


                </div>
        

              </div>





              <div class="box box-info">
                
                <div class="box-header">
                  <h3 class="box-title">Locatie</h3>
                </div>

                <div class="box-body">
                  <iframe
                    id="mapsContainer"
                    width="100%"
                    height="450"
                    frameborder="0" style="border:0"
                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAdqeAf_BSLbrtBZgwoFgoIX2IQB1yQeAw
                      &q=<?=str_replace(' ', '+', $contact->address)?>,<?=str_replace(' ', '+', $contact->city)?>" allowfullscreen>
                  </iframe>

                  <button class="btn btn-info pull-right" id="directions">Routebeschrijving</button>

                  <script type="text/javascript">

                    jQuery("#directions").click(function(){
                        jQuery("#mapsContainer").attr('src','https://www.google.com/maps/embed/v1/directions?origin=Biesboschhaven+Noord+12,+Werkendam,+Nederland&destination=<?=str_replace(' ', '+', $contact->address)?>,<?=str_replace(' ', '+', $contact->city)?>&key=AIzaSyAdqeAf_BSLbrtBZgwoFgoIX2IQB1yQeAw');
                    });

                  </script>

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
                    <input type="text" name="contact_name" class="form-control" placeholder="Naam van contactpersoon" value="<?=$contact->contact_name?>">
                  </div>

                   <div class="form-group">
                    <label>Telefoon</label>
                    <input type="text" name="contact_phone" class="form-control" placeholder="Telefoonnummer van contactpersoon" value="<?=$contact->contact_phone?>">
                  </div>

                   <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" name="contact_email" class="form-control" placeholder="E-mail van contactpersoon" value="<?=$contact->contact_email?>">
                  </div>
                  
              
                  
                </div>
        

              </div>




               <div class="box box-success">
                
                <div class="box-header">
                  <h3 class="box-title">Projecten</h3>
                </div>

                <div class="box-body">
                  
                  <p>Er zijn geen lopende projecten</p>
                  
                </div>
        

              </div>





                  <div class="box box-danger">
                
                <div class="box-header">
                  <h3 class="box-title">Offertes</h3>
                </div>

                <div class="box-body">
          
                 
                  <?php
                    if(is_array($offers)):
                  ?>
                  <ol class="current_lines ">
                    <?php
                      foreach($offers as $offer):
                    ?>
                      <li onClick="javascript: window.location = '/offers/offers/edit/<?=$offer->id?>'">
                        <?=$offer->name?>
                        <span class="pull-right">
                          <i class="fa fa-<?php
                            switch($offer->offer_status){
                              case "0":
                                echo "arrow-up";
                                break;
                              case "1":
                                echo "arrow-right";
                                break;
                              case "2":
                                echo "check";
                                break;
                              case "-1":
                                echo "times";
                                break;
                            } ?>"></i>&nbsp;&nbsp;&nbsp;
                          <?=$offer->datum?>
                        </span>
                      </li>
                    <?php
                      endforeach;
                    ?>
                  </ol>
                  <?php
                    else:
                  ?>
                    <p>Er zijn geen offertes bekend</p>   
                  <?php
                    endif;
                  ?>
      
                </div>
        

              </div>

                <div class="box box-primary">
                
                <div class="box-header">
                  <h3 class="box-title">Gebruikers</h3>
                </div>
                <div class="box-body">
                  <button class="btn btn-info pull-right"><i class="fa fa-plus"></i></button>
                   <p>Er zijn geen gekoppelde gebruikers</p>
                </div>
              </div>
            </div>
          </div>
        </section>
</div>
</form>

<script type="text/javascript">
  jQuery("#directions").click(function(){
      return false;
  });
</script>