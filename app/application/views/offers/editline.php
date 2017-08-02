<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form name="editLineFrm" id="editLineFrm">
	<input type="hidden" name="id" value="<?=$line->id?>" id="curr_offer_line">

	<div class="form-group">
        <label>Titel</label>
        <input type="text" class="form-control" id="changedName" placeholder="Titel" value="<?=$line->name?>" name="name">
    </div>

    <div class="form-group" style="display: none;">
        <label>Afbeelding</label>
        <input type="text" class="form-control" placeholder="Afbeelding" value="<?=$line->image?>" name="image">
    </div>
	<div class="row">
		<div class="form-group col-md-6">
	        <label>Aantal uur</label>
	        <input type="text" class="form-control" placeholder="Aantal uur" value="<?=$line->work_hour?>" name="work_hour">
	    </div>

	    <div class="form-group col-md-6">
	        <label>Prijs</label>
	        <input type="text" class="form-control" placeholder="Prijs" value="<?=$line->price?>" name="price">
	    </div>
    </div>

    <div class="form-group">
        <label>Beschrijving</label>
       	<textarea class="textarea" id="description" name="description" placeholder="Omschrijving"><?=$line->description?></textarea>
    </div>

    <div class="row">

    	<div class="form-group col-md-6">
	        <input type="checkbox" name="show_price_on_end" <?php if($line->show_price_on_end){ ?> checked <?php } ?> class="minimal "> Laat prijs zien onder offerte
	    </div>

	    <div class="form-group col-md-6">
	        <input type="checkbox" name="fixed_price" <?php if($line->fixed_price){ ?> checked <?php } ?> class="minimal "> Vaste prijs
	    </div>

    </div>


	<style>

		.wysihtml5-toolbar li:nth-child(3), .wysihtml5-toolbar li:nth-child(5), .wysihtml5-toolbar li:nth-child(6){
			display: none;
		}

		.wysihtml5-toolbar li:nth-child(1), .wysihtml5-toolbar li:nth-child(2){
			margin-right: 17px;
		}

		.wysihtml5-sandbox{
			width: 		100% 				!important;
			height: 	120px 				!important;
			border: 	1px solid #d2d6de 	!important;
			padding: 	10px 				!important;
		}

	</style>


</form>
