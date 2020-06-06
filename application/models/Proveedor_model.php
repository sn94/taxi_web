<?php


class Proveedor_model extends CI_Model {


    public function __construct(){
        parent::__construct();
		$this->load->database();
	 }


 
    public function registrar_servicio(){
      $datos= $this->input->post(); 
     /* $datos['depart']= implode(' ', explode( ',', $datos['depart']));
      $datos['ciudad']= implode(' ', explode( ',', $datos['ciudad']));*/
       return $this->db->insert('taxis', $datos);   
    }

 
}


?>