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

 
    public function registrar_oferta(){
        $driver_id=$this->session->userdata("id");
		$id_cliente= $this->input->post("cliente");
        $precio= $this->input->post("precio"); 
        $id_flete=  $this->input->post("id_flete"); 
        $dts= array("proveedor"=>$driver_id, "cliente"=>$id_cliente, "precio"=>$precio, "id_flete"=> $id_flete);
        return $this->db->insert('ofertas_precio', $dts);      
    }
}


?>