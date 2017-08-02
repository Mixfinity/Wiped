<aside class="main-sidebar">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?=$this->session->userdata('profile_image');?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?=$this->session->userdata('name');?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <ul class="sidebar-menu">
            <li class="header">Navigatie</li>
  <?php
    foreach($menu as $menuitem){


      if($this->uri->segment(3, 0) === "allProjects" || $this->uri->segment(3,0) === "projectDetails" || $this->uri->segment(3,0) === "archive" ):
         if($menuitem->hasSub == 1){
  ?>

         <li class="treeview <?php if(strtolower($this->uri->segment(3, 0)) == $menuitem->internal_name) {?> active <?php } ?>">
            <a href="<?=$menuitem->link?>">
              <i class="fa fa-<?=$menuitem->icon?>"></i> <span><?=$menuitem->name?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php
          
                 foreach($menuitem->subs as $submenu){
              ?>
                 <li><a href="<?=$submenu->link?>"><?=$submenu->name?></a></li>
              <?php
                }
              ?>  
            </ul>
          </li>
   <?php
        } else {
   
   ?> 

            <li class="<?php if(strtolower($this->uri->segment(3, 0)) == $menuitem->internal_name) {?> active <?php } ?>">


              <a href="<?=$menuitem->link?>">
                <i class="fa fa-<?=$menuitem->icon?>"></i> <span><?=$menuitem->name?></span> 
              </a>

            </li>

    <?php
        }

      else:
        if($menuitem->hasSub == 1){
  ?>

         <li class="treeview <?php if($this->uri->segment(1, 0) == $menuitem->internal_name) {?> active <?php } ?>">
            <a href="<?=$menuitem->link?>">
              <i class="fa fa-<?=$menuitem->icon?>"></i> <span><?=$menuitem->name?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php
          
                 foreach($menuitem->subs as $submenu){
              ?>
                 <li><a href="<?=$submenu->link?>"><?=$submenu->name?></a></li>
              <?php
                }
              ?>  
            </ul>
          </li>
   <?php
        } else {
   
   ?> 

            <li class="<?php if($this->uri->segment(1, 0) == $menuitem->internal_name) {?> active <?php } ?>">


              <a href="<?=$menuitem->link?>">
                <i class="fa fa-<?=$menuitem->icon?>"></i> <span><?=$menuitem->name?></span> 
              </a>

            </li>

    <?php
        }
        endif;
      }
    ?>            
          </ul>
        </section>
      </aside>

       <div class="modal" id="modalBox">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                <p></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn repairBtn btn-default closeModal cancelBtn pull-left" data-dismiss="modal"></button>
                <button type="button" class="btn repairBtn btn-default closeModal noBtn" data-dismiss="modal"></button>
                <button type="button" class="btn repairBtn btn-success okBtn" data-dismiss=""></button>
                <button type="button" class="btn repairBtn btn-danger yesBtn"></button>
              </div>
            </div>
          </div>
        </div>