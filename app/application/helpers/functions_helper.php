<?php
	if(!function_exists('calculateToHour'))
	{
	  function calculateToHour($value)
	  {
	  	$hours  = floor($value/60); 
		$minutes = $value % 60;
		if(strlen($minutes)< 2){
			$minutes = "0" . $minutes;
		}
		return $hours . ":" . $minutes;
	  }
	}



	if(!function_exists('debug'))
	{
	  function debug($value, $die = false)
	  {
	  	echo "<pre>";
	  		print_r($value);
	  	echo "</pre>";

	  	if($die){
	  		die();
	  	}
	  }
	}


	if(!function_exists('render')){
		function render($view = false, $data = false){
			if(!$view){
				die("Je moet een view opgeven!");
			}
			$CI =& get_instance();
			$CI->load->model("ModelMenu", "menu");
			$CI->load->model("ConfigModel", "config_model");
			$temp_menu = $CI->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$CI->load->view('common/header');
			$CI->load->view('common/menu', $menudata);
			if($data){
				$CI->load->view($view, $data);
			} else {
				$CI->load->view($view);
			}
			
			$CI->load->view('common/footer');
		}
	}



?>