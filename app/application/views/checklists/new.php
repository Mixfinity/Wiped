<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <div class="content-wrapper">
    <section class="content-header ">
      <h1>
        Checklist item
        <small>Nieuw</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-list-alt"></i> Home</a></li>
        <li><a href="/checklists/checklists">Checklist</a></li>
        <li class="active">Nieuw</li>
      </ol>
    </section> 

    <section class="content">
      <div class="row">
          <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Nieuwe categorie</h3>
           
                </div>
                <div class="box-body">
                  <form action="/checklists/checklists/newsave" method="POST">
                    <div class="row">           
              <div class="form-group col-md-12">
                <label>Naam</label>
                  <input type="text" class="form-control" placeholder="Naam" value="" name="name">
              </div>  
            </div>
            <button class="btn btn-success pull-right">Opslaan</button>
          </form>
                </div>
              </div>
          </div>
      </div>
    </section>
  </div>