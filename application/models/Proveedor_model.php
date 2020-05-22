<?php


class Proveedor_model extends CI_Model {


    public function __construct(){
        parent::__construct();
		$this->load->database();
	 }



     
 
   
     public function get( $ci ){  
         
         $dts= $this->db->get_where("usuario",  "cedula=$ci")->row();
         return $dts;
     }

//El cliente llego a retirar el dinero
     public function retirado( $cedu){
      $this->db->set('retirado', "S");  
      $this->db->where('cedula', $cedu);
      $this->db->update("clientez"); 
      return $this->db->affected_rows();
     }



     public function listCustom(  $estado="0", $vendedor="0", $m1="1",  $m2="12", $empresa_fondo="0", $year= "" ){
      $params= $this->input->post();
      /**Definir parametros de consulta  si la peticion NO fuera POST*/
      if( !sizeof($params) ){
         $params= array("estado"=> $estado , "vendedor"=> $vendedor,"mes1"=> $m1, "mes2"=> $m2, "empresa"=> $empresa_fondo, "anio"=>$year);  
      } 
      if( $params['estado'] !="0" ){ $this->db->where('estado', $params['estado']); }//todo

      if(   $params['vendedor'] !="0"){   $this->db->where('vendedor', $params['vendedor']); }//cedula de vendedor
     
      if(   $params['empresa'] !="0"){   $this->db->where('empresa', $params['empresa']); }//empresa de fondos
      //definir anio
      $year=  (isset($params['anio']) && $params['anio']!="")?$params['anio']: date("yy") ;
      $this->db->where('year(clientez.fecha_alta)', $year);
      // iniciar consultas
       $this->db->select("clientez.*,usuarioz.usuario as vendedor");
       $this->db->from("clientez");
       $this->db->join("usuarioz",  'usuarioz.cedula = clientez.vendedor' );
       $this->db->where('month(clientez.fecha_alta)>=', $params['mes1']);
      $this->db->where('month(clientez.fecha_alta)<=', $params['mes2']);
      //quien accede, filtrar si se trata de vendedor
      if( $this->session->userdata("tipo") == "V"){
         $this->db->where('vendedor', $this->session->userdata("id")  );
      } 
      $datos=  $this->db->get();
     //var_dump( $this->db->last_query() );
      return $datos->result();
   }


     public function list(){//Obtiene una lista de clientes dados de alta en el mes y por el vendedor autenticado actualmente
      
      $datos = $this->db->get_where("usuario", "modo='c'"); 
        //var_dump( $this->db->last_query());
      return $datos->result();
     }


     public function listByName($nom){//lista de clientes, buscados por nombre
        $nombre= strtolower(  $nom );
        $mes= intval(   date("m")   ); 
        $datos= NULL;
        if($this->session->userdata("tipo")=="S" || $this->session->userdata("tipo")=="A"){
           $params= array('month(fecha_alta)' => $mes );
           $this->db->select('*');
           $this->db->from('clientez');
           $this->db->where('month(fecha_alta)', $mes) ;
           $this->db->like('lcase(nombres)', "$nombre");
           $datos = $this->db->get(); 
          // var_dump( $this->db->last_query() );
        }else{    
        $params= array('month(fecha_alta)' => $mes );
           $this->db->select('*');
           $this->db->from('clientez');
           $this->db->where('month(fecha_alta)', $mes) ;
           $this->db->where('vendedor', $this->session->userdata("id")  ) ;
           $this->db->like('lcase(nombres)', "$nombre");
           $datos = $this->db->get(); 
        } 
        return $datos->result();
     }


     public function totalizarClientesPorEstado(){
      $this->db->select("count(estado) as total, estado");
      $this->db->from("clientez");
      $this->db->group_by("estado");
      if($this->session->userdata("tipo")=="V" ){//FILTRAR POR VENDEDOR
         $this->db->where("vendedor", $this->session->userdata("id") );
      }   
      $Resul= $this->db->get();
      return $Resul->result();
    }

     public function habilitadoParaConfirmar($ci){
     
        $cli= $this->get( $ci);
        if($cli->estado == "A" || $cli->estado == "R"){
            $datos= array("confirmado"=>"Este prestamo ya sido ". ($cli->estado == "A"?"APROBADO":"RECHAZADO") ) ;
            return json_encode( $datos );
        }else {//SI FUERA PENDIENTE
            $datos= array("OK"=>"Sin problemas") ;
            return json_encode( $datos );
        }
     }
   

     public function del( $ci){
      $this->db->where("cedula", $ci);
      return $this->db->delete('clientez');
     }
}


?>