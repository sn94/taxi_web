<?php


class Proveedor_model extends CI_Model {


    public function __construct(){
        parent::__construct();
		$this->load->database();
	 }


/**
 *    Listar los pedidos de clientes del dia de hoy (recientes), clientes que se encuentran
 * en la misma zona del proveedor
 */
public function listProveedoresPorZona(){
    $this->db->select("usuario.id_usu, usuario.nick, flete.id_fle, flete.fecha_alta");
    $this->db->from("usuario");
    $this->db->join("flete", "usuario.id_usu = flete.cliente");
    $this->db->where("usuario.modo", "c");
    $sql = $this->db->get()->result();
   return $sql;
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

    public function ofertas_enviadas(){
        $driver_id=$this->session->userdata("id");
        $this->db->select("usuario.nick, ofertas_precio.id_flete,ofertas_precio.fecha_alta,ofertas_precio.estado");
        $this->db->from("ofertas_precio");
        $this->db->join("usuario", "usuario.id_usu=ofertas_precio.cliente");
        $this->db->where("ofertas_precio.proveedor", $driver_id);
        return $this->db->get()->result();
    }

    public function pedido_flete_a_confirmar( $id_flete){
        $this->db->trans_begin();
        //Estado del flete
        $this->db->set('estado', 'es');//pe es co
        $this->db->where('id_fle', $id_flete);
        $this->db->update("flete");
        //Estado del proveedor a naranja
        $this->db->set('estado', 'na');//pe es co
        $this->db->where('id_usu',  $this->session->userdata("id"));
        $this->db->update("usuario");
        if ($this->db->trans_status() === FALSE) {    $this->db->trans_rollback(); return FALSE;
        }else {    $this->db->trans_commit(); return TRUE;
        }
    }




    public function cliente_token_flete( $id_flete){
        $this->db->select("usuario.id_token");
        $this->db->from("flete"); 
        $this->db->join("usuario", "usuario.id_usu=flete.cliente");
        $this->db->where('flete.id_fle', $id_flete);
        return $this->db->get()->row()->id_token; 
     }



}


?>