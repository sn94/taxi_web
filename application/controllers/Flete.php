<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 

class Flete extends CI_Controller {
 
	 public function __construct(){
		parent::__construct();
		date_default_timezone_set("America/Asuncion");
		$this->load->model("Usuario_model");
		$this->load->model("Flete_model");
		
	 
	 }


	public function index()
	{  
		
	
	}


	public function add(){
		if(  $this->input->method(FALSE)	 == "post"){
			if($this->Flete_model->add()){
				$this->load->view("plantillas/success", array("mensaje"=>"Flete registrado!")); 
				//enviar notificaciones a proveedores en expectativa
				
			}else
				$this->load->view("plantillas/error", array("mensaje"=>"Hubo un error en el servidor, vuelva a intentar")); 
			
		}else{ 	$this->load->helper("form"); $this->load->view('flete/index' ); 	}
	}
	

	public function view( $id_flete){
		/**Totalizar visitas */
		$tv=$this->Usuario_model->getTotalOf("v");
		$tc=$this->Usuario_model->getTotalOf("c");
		$tp=$this->Usuario_model->getTotalOf("p");
		/*** Usuario******/
		$cedula= $this->session->userdata("id") ;
		$usu= $this->Usuario_model->get( $cedula);
		/********Datos de flete*********/
		$datos= $this->Flete_model->get(  $id_flete) ; 
		/********Mostrar vista**********/
		$this->load->view("flete/detalle", array( "usuario"=>$usu, "dato"=>   $datos, "totales"=> array("v"=>$tv,"c"=>$tc,"p"=>$tp)));
	}


	/**
	 * LISTAR OFERTAS
	 */
	public function z(){
		$datos= $this->Flete_model->get(  6) ;
		var_dump( $datos);
	}
	 
}
