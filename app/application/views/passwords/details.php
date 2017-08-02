<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
	if(isset($name)){
?>

	<div id="information">
		<p><label class="col-sm-4">Naam:</label><?php echo $name; ?></p>
		<p><label class="col-sm-4">Server:</label><?php echo $servername; ?> <a href="<?php echo $servername; ?>" target="_blank">(Klik)</a></p>
		<p><label class="col-sm-4">Gebruikersnaam:</label><?php echo $username; ?></p>
		<p><label class="col-sm-4">Wachtwoord:</label><?php echo $password; ?></p>



	</div>


<?php
	}
?>