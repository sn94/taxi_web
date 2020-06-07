<?php


class Cliente_model extends CI_Model {


    public function __construct(){
        parent::__construct();
		$this->load->database();
	 }
 
 
    
/**
 *    Listar los pedidos de clientes del dia de hoy (recientes), clientes que se encuentran
 * en la misma zona del proveedor
 */
    public function listPedDeCliPorZona(){
       $this->db->select("usuario.id_usu, usuario.nick, flete.id_fle, flete.fecha_alta");
       $this->db->from("usuario");
       $this->db->join("flete", "usuario.id_usu = flete.cliente");
       $this->db->where("usuario.modo", "c");
       $sql = $this->db->get()->result();
      return $sql;
   }


   public function ofertasRecibidas(){
      $this->db->select("ofertas_precio.id_flete,usuario.nick, flete.fecha_alta, ofertas_precio.estado");
       $this->db->from("ofertas_precio");
       $this->db->join("usuario", "usuario.id_usu = ofertas_precio.proveedor");
       $this->db->join("flete", "flete.id_fle = ofertas_precio.id_flete");
       $this->db->where("ofertas_precio.cliente", $this->session->userdata("id"));
       $sql = $this->db->get()->result(); 
      return $sql;
   }


   


}


?>