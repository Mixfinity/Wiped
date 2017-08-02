<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="content-wrapper">
    <section class="content-header ">
      <h1>
        Checklists
        <small>Bewerken</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-list-alt"></i> Home</a></li>
        <li><a href="/checklists/checklists">Checklist</a></li>
        <li class="active"><?=$category->name?></li>
      </ol>
    </section> 

    <section class="content">
      <div class="row">
          <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title"><?=$category->name?></h3>
                    <button class="btn btn-success pull-right newBtn" onClick="javascript: window.location = '/checklists/checklists/newitem/<?=$category->id?>'">Nieuw</button>
                </div>
                <div class="box-body">
                  <table id="categories" class="table profileTable table-bordered table-hover dataTable">
                      <thead>
                          <tr>
                            <th>Naam</th>
                            <th width="118">&nbsp;</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                        foreach($items as $i){
                      ?>
                              <tr>
                                <td><?=$i->name?></td>
                                <td width="118">
                                  <a class="btn btn-success" href="/checklists/checklists/edititem/<?=$i->id?>"><i class="fa fa-edit"></i></a>
                                  <a class="btn btn-danger" href="/checklists/checklists/deleteitem/<?=$i->id?>"><i class="fa fa-trash"></i></a>
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