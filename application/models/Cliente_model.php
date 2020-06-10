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
      $this->db->select("ofertas_precio.id_op,ofertas_precio.id_flete,usuario.nick, flete.fecha_alta, ofertas_precio.estado");
       $this->db->from("ofertas_precio");
       $this->db->join("usuario", "usuario.id_usu = ofertas_precio.proveedor");
       $this->db->join("flete", "flete.id_fle = ofertas_precio.id_flete");
       $this->db->where("ofertas_precio.cliente", $this->session->userdata("id"));
       $sql = $this->db->get()->result(); 
      return $sql;
   }


   public function aceptar_oferta_precio( $id_oferta){
         $this->db->set('estado', 'ac');
          $this->db->where('id_op', $id_oferta);
      return $this->db->update("ofertas_precio");
   }
   


   public function proveedorDelaOferta( $id_oferta){
      $this->db->select("usuario.id_token");
      $this->db->from("ofertas_precio");
      $this->db->join("usuario", "usuario.id_usu= ofertas_precio.proveedor");
      $this->db->where('ofertas_precio.id_op', $id_oferta);
      return $this->db->get()->row()->id_token; 
   }

   public function idFleteDelaOferta( $id_oferta){
      $this->db->select("ofertas_precio.id_flete");
      $this->db->from("ofertas_precio");
      $this->db->join("usuario", "usuario.id_usu= ofertas_precio.proveedor");
      $this->db->where('ofertas_precio.id_op', $id_oferta);
      return $this->db->get()->row()->id_flete; 
   }


   public function aceptar_transaccion( $id_flete){
      $this->db->trans_begin();
      //Estado del flete
      $this->db->set('estado', 'co');//pe es co
      $this->db->where('id_fle', $id_flete);
      $this->db->update("flete");
      //Estado del proveedor a naranja
      $this->db->set('estado', 'ro');//ve na ro
      $this->db->where('id_usu',  $this->session->userdata("id"));
      $this->db->update("usuario");
      if ($this->db->trans_status() === FALSE) {    $this->db->trans_rollback(); return FALSE;
      }else {    $this->db->trans_commit(); return TRUE;
      }
      //borrar registro de la oferta
   }
}


?>