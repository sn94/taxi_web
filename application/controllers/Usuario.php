<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {
 
	 public function __construct(){
		parent::__construct(  );
		date_default_timezone_set("America/Asuncion");
		$this->load->model("Usuario_model");
		$this->load->library("firebase_req");
	 }

	public function index()
	{

		if( $this->session->userdata("tipo") == "S"){
			$dts= $this->Usuario_model->list();
			$this->load->view('usuario/index', array("list"=> $dts)  );
		}else {
			redirect(  base_url("welcome") );
		} 
	}


	/**
	 * inicio de sesion
	 */

	 private function internal_sign_in(   $usr, $passwrd){

		//OBTENER NRO REG DE USUARIO a partir de su NICK
		$d_u= $this->Usuario_model->getByName( $usr);
		//VERIFICAR EXISTENCIA DE USUARIO
		if( is_null( $d_u) ){//no existe
			$this->load->view("login/index", array("errorSesion"=> "El usuario ->$usr<- no existe") );
		}else{
			$id_usr=$d_u->id_usu; 
			$nom= $d_u->nombre; 
			$pass= $passwrd;
			$tipo= $d_u->modo; 

			// VERIFICACION DE contrasenha correcta
			if( $this->Usuario_model->correctPassword( $pass, $usr) ){
				$newdata = array( 	'id' => $id_usr, 'usuario'  => $usr, 'nombres' => $nom,'tipo'     => $tipo);
				$this->session->set_userdata( $newdata);//CREACION DE LA SESION 

				if( $tipo=="c")
				redirect(  base_url("proveedor/index") ); 
				else
				redirect(  base_url("cliente/index") ); 
			}else{
			//	echo json_encode(  array('error' => "Clave incorrecta" )); 
				$this->load->view("login/index", array("errorSesion"=> "Clave incorrecta") );
			}
		}//end else
	}


	public function sign_in(){
	
		$this->load->helper("form");
		$this->load->library("session");
		 if(  is_null( $this->input->post("usuario") ) ){//SI no hay parametros
			//MOSTRAR FORM
			$this->load->view("login/index");
		 }else{
				//DATOS DE SESIOn
				$usr= $this->input->post("usuario");
				$pass=  $this->input->post("passw");
				$this->internal_sign_in( $usr, $pass);
				//usuario a activo
				
				
		 }//END ANALISIS DE PARAMETROS
	}//END SIGN IN

	public function sign_out(){
		$this->load->library("session");
		//$ced= $this->session->userdata("id");
		//$jsn= $this->Usuario_model->accessLoggedOut( $ced);
		//if( !isset( $jsn['error'])  ){
			$this->session->sess_destroy(); 
		//}

		redirect(    base_url("welcome")   ); 
	}

	 

	public function  read_user_tokens(){
		$fichero= fopen("online_users.txt", "r");
		$registration_ids=[];
		while(  !feof($fichero)){
			$linea= fgets( $fichero);
			$datos= explode(",",  $linea); 
			if( sizeof( $datos) > 1){
				array_push( $registration_ids,   $datos[0]);
			}  
			 
		}
		fclose($fichero); 
		return  $registration_ids;
	}

	private function add_visit_log($data){
		$this->Usuario_model->add_visit_log( $data); 
	}


	private function add_user_log( $data){
		$fichero= fopen("online_users.txt", "a");
		$Cadena=$data['token'].",".$data['id'];
		fputs(  $fichero, $Cadena); 
		fputs( $fichero, chr(13).chr(10) );
		fclose( $fichero);
	}

	public function user_status( $online){
		//1 online  0 offline
		$token= $this->input->post("token");
		$ip= $this->input->ip_address();
		$id_usuario=  $this->session->userdata("id"); 
		$nick_usuario=  $this->session->userdata("usuario"); 
		//navegador sistema operativo
		$navegador= $this->input->user_agent();
		//fecha-hora
		$fecha= date("Y/m/d H:i:s");
		/**********grabar en archivo de seguimiento de usuarios */
		$DATOS= array( "ip"=>$ip, "id_us"=>$id_usuario, "browser"=> $navegador, "fecha_hora"=>$fecha);
		$this->add_visit_log(  $DATOS );
		$this->add_user_log(  array("token"=> $token, "id"=>$id_usuario) ) ;
		/***Notificar a otros usuarios */
		$tokens=$this->read_user_tokens();
		$datos_noti= array("gui_user_refresh"=>"yes","user"=>$nick_usuario,"on"=>"1");
		if( sizeof($tokens) > 0)
	{	
		$this->firebase_req->send_message_one_device(   $tokens, $datos_noti);
	} 	 	
	}


	public function passChange(){ 
		if( sizeof($this->input->post()) )
		{ 
			//verificar si contrasenha actual es correcta
			$ced= $this->input->post("cedula");
			$obj_usr= $this->Usuario_model->get( $ced);
			$pass=  $obj_usr->pass;
			if( $pass == $this->input->post("clave-a") ){
				//cambiar pass
				if($this->Usuario_model->passwordUpdate()){
					echo json_encode( array("OK"=>"Clave cambiada!") );
				}else{
					echo json_encode( array("error"=>"Errores tecnicos!") );
				} 
			}else{
				echo json_encode( array("error"=>"La clave ingresada es incorrecta") );
			}

		}
		else{
			$this->load->helper("form");
			$this->load->view("usuario/passwordChange");
		} 

	}

	public function z(){ 
	var_dump( $this->Usuario_model->getByName( "ffdg") );
		//var_dump(  $this->session->userdata( "nombres") );
		//var_dump( $this->Usuario_model->list_vendedores());
	}

	public function list_clientes(  ){ 
		echo json_encode( $this->Usuario_model->list_clientes() ); 
	}
	
	public function list( $opc= "0"){ 
		$usersList=	$this->Usuario_model->list($opc); 
		echo json_encode(  $usersList);
	}

	public function sel_tipo_usuario(){
		$this->load->view("usuario/sel_tipo"); 
	}


	public function create( $tipo="c"){
		 
	$this->load->helper("form");

		if(   $this->input->method(FALSE)	 == "post" ){ 
			 
			if( $this->Usuario_model->add() ){
				$this->internal_sign_in( $this->input->post("nick"),
										$this->input->post("passw"));
			}else{
				$this->load->view("usuario/error", array("mensaje"=> "Hubo un error al registrar sus datos. Vuelva a intentar")  );
			}
			
			
		}else{  
			$this->load->view("usuario/create", array("tipo"=> $tipo)  );
			//$this->load->view("plantillas/success", array("mensaje"=>"Datos de Usuario agregado"));
		}

			
		  
		
		
	}

 


	public function edit($cedula, $permitir= 0 ){
		if( $this->session->userdata("tipo") == "S" || $permitir ){
			if( !sizeof( $this->input->post() )  )
			{
				//var_dump( $this->input->post()   );
				//POBLAR FORMULARIO
				$this->load->helper("form");
				$cli= $this->Usuario_model->get( $cedula );
				$this->load->view("usuario/edit_express", array("datos"=> $cli) );
			}else{
				$d= NULL;// PAYLOAD DE FORMULARIO
				$d= $this->input->post();
				if( sizeof($d) ){ 
					$this->Usuario_model->edit();
					$this->load->view("plantillas/success", array("mensaje"=>"Datos de usuario Actualizado")); 
					 
				}else{ 
					echo "aca no";
					$this->load->helper("form");
					$this->load->view("usuario/edit" ); 
				} //end else
			}//end else
		}else {
			redirect(  base_url("welcome") );
		}
	}

	public function delete( $id= "" ){
		echo  $this->Usuario_model->del( $id);
	}
	 

	//busqueda por cedula
	public function view(  $ci){
		$dt= $this->Usuario_model->get( $ci ) ;
		$this->load->view("usuario/view", array("datos"=> $dt));
          		
   }
	//busqueda por cedula
	public function get(  $ci){
		$dt= $this->Usuario_model->get( $ci ) ;
		if( is_null ($dt )){
            echo json_encode(  array('error' => "Este usuario no existe" )); 
         } else{ 
			echo json_encode($dt );
		}		
   }

   public function getByName(  $n, $permitir= 0){
	if( !$this->session->has_userdata("usuario")  || $this->session->userdata("tipo") == "S" || $permitir){
		
			$dt= $this->Usuario_model->getByName( $n ) ;
			if( is_null ($dt )){
				echo json_encode(  array('error' => "Este usuario no existe" )); 
			} else{ 
				echo json_encode($dt );
			}	 
	}else {
		redirect(  base_url("welcome") );
	}	
}



	public function getForRead(  $ci){

		if( $this->session->userdata("tipo") == "S"){
		
				$dt= $this->Usuario_model->get( $ci ) ;
				if( is_null ($dt )){
					echo json_encode(  array('error' => "Este usuario no existe" )); 
				} else{
					$this->load->helper("form");
					$this->load->view("usuario/view_data", array("datos"=> $dt));
					
				} 
		}else {
			redirect(  base_url("welcome") );
		}			
   }


   public function getForReadByNick(  $nick){

	if( $this->session->userdata("tipo") == "S"){
	
			$dt= $this->Usuario_model->getByName( $nick ) ;
			if( is_null ($dt )){
				echo json_encode(  array('error' => "Este usuario no existe" )); 
			} else{
				$this->load->helper("form");
				$this->load->view("usuario/view_data", array("datos"=> $dt));
			} 
	}else {
		redirect(  base_url("welcome") );
	}			
}


   public function getForEditByNick(  $nick){

	if( $this->session->userdata("tipo") == "S"){
	
		$dt= $this->Usuario_model->getByName( $nick ) ;
		if( is_null ($dt)){
		   echo json_encode(  array('error' => "Este usuario no existe" )); 
		}else{
		   $this->load->helper("form");
		   $this->load->view("usuario/edit_data", array("datos"=> $dt));
			
		}	
	}else {
		redirect(  base_url("welcome") );
	}	
}

	public function getForEdit(  $ci){

		if( $this->session->userdata("tipo") == "S"){
		
			$dt= $this->Usuario_model->get( $ci ) ;
			if( is_null ($dt)){
			   echo json_encode(  array('error' => "Este usuario no existe" )); 
			}else{
			   $this->load->helper("form");
			   $this->load->view("usuario/edit_data", array("datos"=> $dt));
				
			}	
		}else {
			redirect(  base_url("welcome") );
		}	
	}

	 
	/**
	 * Reportes
	 */



	public function informes(){
		$dts= $this->Usuario_model->list(); 
		$this->load->view( "usuario/informes", array("list"=> $dts)  );
	}


	public function generarPdf( $opc= "0"){ 
		$usersList=	$this->Usuario_model->list($opc); 

		$html=<<<EOF
		<style>
		table.tabla{
			color: #003300;
			font-family: helvetica;
			font-size: 8pt;
			border-left: 3px solid #777777;
			border-right: 3px solid #777777;
			border-top: 3px solid #777777;
			border-bottom: 3px solid #777777;
			background-color: #ddddff;
		}
		
		tr.header{
			background-color: #ccccff; 
			font-weight: bold;
		} 
		tr{
			background-color: #ddeeff;
			border-bottom: 1px solid #000000; 
		}
		</style>

		<table class="tabla">
		<thead >
		<tr class="header">
		<td>Cedula</td>
		<td>Nombres</td>
		<td>Usuario</td>
		</tr>
		</thead>
		<tbody>
		EOF;
		foreach( $usersList as $row){
			$html.="<tr> <td>{$row->cedula}</td> <td>{$row->nombres}</td> <td>{$row->usuario}</td> </tr>";
		}
		$html.="</tbody> </table> ";
		/********* */

		$tituloDocumento= "Usuarios-".date("d")."-".date("m")."-".date("yy");

			$this->load->library("PDF"); 	
			$pdf = new PDF(); 
			$pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
			$pdf->generarHtml( $html);
			$pdf->generar();
	}
	

	public function generarXls(){
		//require_once '../Classes/PHPExcel/IOFactory.php';
		$this->load->library('Excel');
		$this->excel->setActiveSheetIndex(0);         
		$this->excel->getActiveSheet()->setTitle('test worksheet');         
		$this->excel->getActiveSheet()->setCellValue('A1', 'Un poco de texto');         
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);         
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);         
		$this->excel->getActiveSheet()->mergeCells('A1:D1');           
	
		header('Content-Type: application/vnd.ms-excel');         
		header('Content-Disposition: attachment;filename="nombredelfichero.xls"');
		header('Cache-Control: max-age=0'); //no cache         
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');         
		
		// Forzamos a la descarga         
		$objWriter->save('php://output');
	  }


	

}
