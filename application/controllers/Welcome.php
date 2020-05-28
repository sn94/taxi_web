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

	public function sel_modo_ingreso( $quien){
		$this->load->view("visitante/index", array("who"=> $quien) );
	}
	private function crear_sesion_visitante(){
		$newdata = array(   
			'depart'  => $this->input->post("depart"),
			'ciudad'  => $this->input->post("ciudad"),
			'barrio'  => $this->input->post("barrio"),
			'tipo'     => "v");
		$this->session->set_userdata( $newdata);
	}
	public function registro_visitante( $who){ 
			$this->load->helper("form");
			if(  $this->input->method(FALSE)	 == "post"){	
				if($this->Visitante_model->add()){
					$this->crear_sesion_visitante();
					if( $who=="c")
					redirect("proveedor/index");
					else
					redirect("cliente/index");
				}
			}else{
				$this->load->view("visitante/registro", array("modo"=> $who)  );
			}
		 
	}//end registro_visitante


}
