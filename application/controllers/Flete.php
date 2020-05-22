<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 

class Flete extends CI_Controller {
 
	 public function __construct(){
		parent::__construct();
		date_default_timezone_set("America/Asuncion");
		$this->load->model("Flete_model");
		
	 
	 }


	public function index()
	{  
		
	
	}


	public function add(){
		
	
		if(  $this->input->method(FALSE)	 == "post"){
			if($this->Flete_model->add())
				$this->load->view("plantillas/success", array("mensaje"=>"Flete registrado!")); 
			else
				$this->load->view("plantillas/error", array("mensaje"=>"Hubo un error en el servidor, vuelva a intentar")); 
			
		}else{
			$this->load->helper("form");
			$this->load->view('flete/index' );
		}
	}
	 
	 
}
