<?php


class Usuario_model extends CI_Model {


    public function __construct(){
        parent::__construct();
		$this->load->database();
	 }


    //CRUD

     public function add(){
        $datos= $this->input->post(); 
        //hash
        $datos['passw']=   password_hash($datos['passw'],  PASSWORD_DEFAULT );
        return $this->db->insert('usuario', $datos);   
     }

     //recuperacion
     public function get( $ci ){  
         $dts= $this->db->get_where('usuario', array('id_usu' => $ci ))->row();
         return $dts;
     }

     public function getByName( $n ){  
      $dts= $this->db->get_where('usuario', array('nick' => $n ))->row();
      return $dts;
      }

      public function edit(){
         $datos= $this->input->post();
         if( isset( $datos['passw'] ) )
         $datos['passw']= password_hash($datos['passw'],  PASSWORD_DEFAULT );
         
         $this->db->where("cedula", $datos['cedula']);
         $this->db->update('usuario', $datos);
      }
 
      public function del( $ci){
       $this->db->where("cedula", $ci);
       return $this->db->delete('usuario');
      }

      public function actualizarToken(){
         $id_us= $this->session->userdata("id");
        $tkn=  $this->input->post("token");
         $this->db->set('id_token', $tkn);
         $this->db->where('id_usu', $id_us);
      return $this->db->update("usuario");  
      }
/******************
 * ESTADOS DEL USUARIO
 */
 //Historico de todas las visitas al sitio
  public  function add_visit_log($data){
   $this->db->insert('visitas', $data);
  //var_dump(  $this->db->last_query()   );
}
//Registrar temporalmente a un usuario en la tabla de usuarios en linea
public  function add_user_log($data){ 
   $this->db->insert('online_users', $data);
  //var_dump(  $this->db->last_query()   );
}
//verifica si el usuario esta en linea
public function isOnlineUser( $id){
   $dts= $this->db->get_where('online_users', array('id_usu' => $id ))->row();
   return  !is_null( $dts);
}
//Obtiene una lista de todos los usuarios en linea
public function getOnlineUsers(){ 
   $datos=  $this->db->get('online_users' );
   return $datos->result();
}
//Obtiene una lista de usuarios en linea segun tipo
public function getOnlineUsersFor( $tipo){ 
   $this->db->where("tipo", $tipo);
   $datos=  $this->db->get('online_users' );
   return $datos->result();
}
//Obtiene el total de todos los usuarios en linea
public function getTotalOnlineUsers(){ 
      $datos=  $this->db->count_all('online_users' );
      return $datos;
}
//Total de usuarios en linea que son visitantes
public function getTotalOf( $tipo){
   $this->db->where("tipo", $tipo);
   $datos=  $this->db->count_all_results('online_users' );
   return $datos;
}


   /***
    * FUNCIONES DE LISTADO
    */
   public function list(){ 
        $datos=  $this->db->get('usuario' );
        return $datos->result();
   } 

   public function list_clientes(){ 
      $dt=$this->db->get_where("usuario", array( "modo"=>"c") );
      return $dt->result();
   }

   public function list_proveedores(){ 
      $dt=$this->db->get_where("usuario", array( "modo"=>"p") );
      return $dt->result();
   }
   

   /***
    * CLAVES
    */
   public function passwordUpdate(){
      $datos= $this->input->post();
      $this->db->set('passw', $datos['clave-n'], FALSE);
      $this->db->where('cedula',  $datos['cedula']);
      return $this->db->update('usuario'); 
   }
     public function  correctPassword( $passinput, $nick ){
        $usr= $this->getByName(  $nick);
        return password_verify( $passinput,  $usr->passw  );
     }
     
      
     

 


}


?>