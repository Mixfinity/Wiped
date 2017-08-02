<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header ">
      <h1>
        Rechten
        <small>Bewerken</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/dashboard/dashboard"><i class="fa fa-cogs"></i> Home</a></li>
        <li><a href="/config/config">Configuratie</a></li>
        <li><a href="/config/config/rights">Rechten</a></li>
		    <li class="active">Bewerken</li>
      </ol>
    </section>
    <form method="post">
      <input type="hidden" name="profile_id" value="<?=$profile_id?>">
      <section class="content">
          <div class="row">
            	<div class="col-xs-12">
                	<div class="box box-success">
                  	<div class="box-header">
                    		<h3 class="box-title">Rechten</h3>
                        <button class="btn btn-success pull-right">Opslaan</button>
                  	</div>
                  	<div class="box-body">
                  		<table id="users" class="table profileTable table-bordered table-hover dataTable">
  		                    <thead>
  		                        <tr>
  			                        <th>Rechten</th>
  			                        <th width="36">&nbsp;</th>
  		                        </tr>
  		                    </thead>
  		                    <tbody>
  	                    	  <?php
                              foreach($rights as $right){ 
                            ?>
                                <tr>
                                  <td><?=$right->name?></td>
                                  <td>
                                    <input type="checkbox" name="right[]" <?php if($right->profile_id){ ?> checked <?php } ?> class="minimal" value="<?=$right->id?>">
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
    </form>


</div>

<script type="text/javascript">
  
  jQuery(document).ready(function(){
    jQuery('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'icheckbox_flat-green-green'
    });
  });

</script>