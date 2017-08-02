<?php
defined('BASEPATH') OR exit('No direct script access allowed');


	$count = 0;
	foreach($lines as $line){
?>
		<br>
		<br>
		<h2><?=$line->name?></h2>
		<p><?=$line->description?></p>
		<br>
		<br>
	

<?php
		$count++;
	}

	if($count == 0){?>
		<p>De offerte is nog leeg. Sleep regels in de offerte om deze te vullen.</p>
<?php	}
?>