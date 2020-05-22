<?php


class Visitante_model extends CI_Model {


    public function __construct(){
        parent::__construct();
		$this->load->database();
	 }



     public function add(){ 

      $datos= $this->input->post();
      $res= $this->db->insert('visitante', $datos);
      return $res;
     }


   public function edit(){
      $datos= $this->input->post();   
      if( $this->session->userdata("tipo")=="A"){//SOLO ADMINISTRATIVOS

         $fecha_apro_rech= date("yy-m-d");
         $this->db->set('empresa', $datos['empresa']);
         $this->db->set('monto_a', $datos['monto_a']);
         $this->db->set('estado', $datos['estado']);
         $this->db->set('fecha_a_r', $fecha_apro_rech);
         $this->db->set('observacion', $datos['observacion']);
         //dinero retirado
         if( isset($datos['retirado'])) $this->db->set('retirado', "S");
         //Donde
         $this->db->where('cedula', $datos['cedula']);
         $this->db->update("clientez"); 
          
      }else{ //EDICION POR EL VENDEDOR O SUPERVISOR
          $this->db->where("cedula", $datos['cedula']); 
          //ACTUALIZACION DE FOTO CEDULA
         $this->load->library("upload_file"); 
         $filepath= "../cedulas-fotos/";
         $n_f1=  "ced-anverso-".$datos['cedula']; $n_f2= "ced-reverso-".$datos['cedula'];
         $subida1= $this->upload_file->do_upload("foto1", $filepath, $n_f1 ); 
         $subida2= $this->upload_file->do_upload("foto2", $filepath, $n_f2);
         //antes de grabar
         if($subida1) $datos['foto1']= $subida1;
         if($subida2) $datos['foto2']= $subida2;
         $this->db->update('clientez', $datos);
      
      }//end else
   }


   
     public function get( $ci ){  
         $this->db->select("clientez.*,usuarioz.cedula as vendedor, usuarioz.nombres as nombrevend");
         $this->db->from("clientez");
         $this->db->join("usuarioz", 'usuarioz.cedula = clientez.vendedor');
         $this->db->where("clientez.cedula",  $ci);
         $dts= $this->db->get()->row();
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
        $mes= intval(   date("m")   ); 
        $anio= intval(   date("yy")   ); 
        $datos= NULL;
        if($this->session->userdata("tipo")=="S" || $this->session->userdata("tipo")=="A"){
           //$params= array('month(fecha_alta)' => $mes );
           //$datos=  $this->db->get_where('clientez' , $params  );

           $this->db->select("clientez.cedula,clientez.nombres,clientez.apellidos,clientez.telefono,usuarioz.usuario as vendedor,clientez.estado");
           $this->db->from("clientez");
           $this->db->where('month(clientez.fecha_alta)', $mes);
           $this->db->where('year(clientez.fecha_alta)', $anio);
           $this->db->join('usuarioz', 'usuarioz.cedula = clientez.vendedor');
           $datos = $this->db->get();

        }else{    
                $vendd= $this->session->userdata("id"); 
                 $this->db->select("clientez.cedula,clientez.nombres,clientez.apellidos,clientez.telefono,usuarioz.usuario as vendedor,clientez.estado");
                 $this->db->from("clientez");
                 $this->db->where('month(clientez.fecha_alta)', $mes);
                 $this->db->where('year(clientez.fecha_alta)', $anio);
                 $this->db->where('clientez.vendedor', $vendd);
                 $this->db->join('usuarioz', 'usuarioz.cedula = clientez.vendedor');
                 $datos = $this->db->get();
        } 
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