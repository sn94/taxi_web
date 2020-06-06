<?php


class Flete_model extends CI_Model {


    public function __construct(){
        parent::__construct();
		$this->load->database();
	 }


    /**
     * REGISTRO DE FLETE
     */

     public function add(){ 
      $datos= $this->input->post(); 
      foreach( $datos as $clave=>$item){     $datos[$clave]=  $this->input->post( $clave, FALSE ); 
      } 
      $c1= implode(' ', explode( ',', $datos['o_coordenada']));
      $c2= implode(' ', explode( ',', $datos['d_coordenada']));
      $datos['o_coordenada']= "GeomFromText('POINT($c1)')";
      $datos['d_coordenada']= "GeomFromText('POINT($c2)')";
      $sql= "INSERT INTO flete( o_depart, o_ciudad, o_barrio, o_coordenada, o_fecha, o_hora, d_depart, d_ciudad, d_barrio, d_coordenada, d_fecha, d_hora, smallest_size, biggest_size, cant_paque, peso_total, nivel_fragil, det_empaque, material, cliente) ";
      $sql.=" VALUES (  '{$datos['o_depart']}' , '{$datos['o_ciudad']}' , '{$datos['o_barrio']}' , {$datos['o_coordenada']} , '{$datos['o_fecha']}' ,'{$datos['o_hora']}'  , '{$datos['d_depart']}' ,'{$datos['d_ciudad']}'  , '{$datos['d_barrio']}' , {$datos['d_coordenada']}  ,'{$datos['d_fecha']}'  , '{$datos['d_hora']}' , {$datos['smallest_size']} , {$datos['biggest_size']} , {$datos['cant_paque']} ,{$datos['peso_total']}  , '{$datos['nivel_fragil']}' ,'{$datos['det_empaque']}' ,'{$datos['material']}' ,{$datos['cliente']} ) ";
 
     return  $this->db->query(  $sql);
     }

   


     public function get(  $id_flete){ 
         $this->db->select("flete.*, usuario.nick, usuario.id_usu");
         $this->db->from("flete");
         $this->db->join("usuario", "flete.cliente=usuario.id_usu");
        $this->db->where( "id_fle",  $id_flete);  
        return $this->db->get()->row();
     }


   
  
}


?>