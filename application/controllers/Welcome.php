<?php
defined('BASEPATH') OR exit('No direct script access allowed');


//visitante
class Welcome extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("America/Asuncion");
		$this->load->model("Visitante_model");
	 }


	public function index()
	{
		 $this->load->view("inicio");
	}

	public function registro_visitante( $who){ 
			$this->load->library("form_validation");
			$this->form_validation->set_error_delimiters('<p class="text-danger font-weight-bold">', '</p>');
			$this->form_validation->set_rules( "cedula","cedula","required", array('required' => 'Proporcione el numero de cedula') );
			$this->load->helper("form");

		if( $this->form_validation->run() == FALSE ){ 	$this->load->view("visitante/registro", array("modo"=> $who)  );
		}else{
			if($this->Visitante_model->add()){
				/*if( $who=="c")
				redirect("proveedor/index");
				else
				redirect("cliente/index");*/
			} 
		} 
	}//end f


}
