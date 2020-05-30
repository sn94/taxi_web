<?php


class Usuario_model extends CI_Model {


    public function __construct(){
        parent::__construct();
		$this->load->database();
	 }



     public function add(){
        $datos= $this->input->post(); 
        //hash
        $datos['passw']=   password_hash($datos['passw'],  PASSWORD_DEFAULT );
        return $this->db->insert('usuario', $datos);   
     }

  

     public function get( $ci ){  
         $dts= $this->db->get_where('usuario', array('id_usu' => $ci ))->row();
        
         return $dts;
     }


     public function getByName( $n ){  
      $dts= $this->db->get_where('usuario', array('nick' => $n ))->row();
     
      return $dts;
  }


     public function list( $opc= "0"){
        $params= NULL;
        $mes= date("m");
        if(  $opc != "0"){$this->db->where( "tipousuario", $opc); }
         
        $datos=  $this->db->get('usuario' );
        return $datos->result();
     }
   
     public function list_array(){
      $mes= date("m");
      $this->db->select( "cedula,nombres,usuario");
      $this->db->from("usuario");
      $this->db->where( 'month(fecha_alta)' , $mes );
      $datos=  $this->db->get();//sin parametros
      return $datos->result_array();
   }

   public function list_clientes(){ 
      $dt=$this->db->get_where("usuario", array( "modo"=>"c") );
      return $dt->result();
   }

   public function list_proveedores(){ 
      $dt=$this->db->get_where("usuario", array( "modo"=>"p") );
      return $dt->result();
   }
   

   public function passwordUpdate(){
      $datos= $this->input->post();
      $this->db->set('passw', $datos['clave-n'], FALSE);
      $this->db->where('cedula',  $datos['cedula']);
      return $this->db->update('usuario'); 
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



     public function  correctPassword( $passinput, $nick ){
        $usr= $this->getByName(  $nick);
        return password_verify( $passinput,  $usr->passw  );
     }
     
      
     

 


}


?>