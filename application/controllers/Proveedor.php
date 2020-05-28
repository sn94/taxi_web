<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {
 
	 public function __construct(){
		parent::__construct();
		date_default_timezone_set("America/Asuncion");
		$this->load->model("Usuario_model");
	 }

	public function index()
	{  
		$dts=  $this->Usuario_model->list_proveedores();
		//obtener datos de usuario actual
		if( $this->session->has_userdata("usuario") ){
			$cedula= $this->session->userdata("id") ;
			$usu= $this->Usuario_model->get( $cedula);
			$this->load->view('proveedor/index', array("list"=> $dts, "usuario"=> $usu )  );
		}else{

			if( $this->session->userdata("tipo") =="v" ){//Si fuera visitante
				 
				$this->load->view('proveedor/index', array("list"=> $dts )  );
			}else{
				$this->load->view('proveedor/index', array("list"=> $dts)  );
			} 
 
		} 
	
	}

	 public function z(){
		$dts= $this->Cliente_model->list();  
		echo json_encode( $dts);
	 }

	public function list(){ 
		$cList=	$this->Cliente_model->listCustom(); 
		echo json_encode(  $cList);
	}

	public function listView(){ 
		$cList=	$this->Cliente_model->listCustom(); 
		if( $this->session->userdata("tipo")=="S" )
		$this->load->view("cliente/index/index_s", array("list"=> $cList)   );
		if( $this->session->userdata("tipo")=="A" )
		$this->load->view("cliente/index/index_a",  array("list"=> $cList) );
		if( $this->session->userdata("tipo")=="V" )
		$this->load->view("cliente/index/index_v", array("list"=> $cList) ); 
	}

	public function create(){
		$d= $this->input->post();
		if( sizeof($d) ){
			$this->Cliente_model->add();
			$this->load->view("plantillas/success", array("mensaje"=>"Datos de Cliente agregado"));
		}else{
			$this->load->helper("form"); 
			$this->load->view("cliente/create"); 
		} 			
	}



	public function edit( $cedula ){
		$d= NULL;// PAYLOAD DE FORMULARIO
		$d= $this->input->post();
		if( sizeof($d)){ 
			$this->Cliente_model->edit() ;
			$this->load->view("plantillas/success", array("mensaje"=>"Datos de cliente Actualizado")); 
			 
		}else{
			//POBLAR FORMULARIO
			$this->load->helper("form");
			$cli= $this->Cliente_model->get( $cedula );
			$this->load->view("cliente/edit/index", array("datos"=> $cli) );
		} 
	}


	public function delete( $id= "" ){
		 
		if( $id ){
			$this->Cliente_model->del( $id);
			$this->load->view("plantillas/success", array("mensaje"=>"Datos de cliente borrados")); 
			 
		}else{ 
			$this->load->helper("form");
			$this->load->view("cliente/delete" ); 
		} 
 
	}

	public function del( $id= "" ){
		echo  $this->Cliente_model->del( $id);
	}

	public function retirado( $cedula){
		$cli= $this->Cliente_model->retirado( $cedula );
		if( $cli > 0){
			echo json_encode( array("ok"=>"SE HA REGISTRADO EL RETIRO DE DINERO") );
		}else{
			echo json_encode( array("error"=>"NO SE PUDO REGISTRAR EL RETIRO. COMUNIQUESE CON EL DESARROLLADOR") );
		}
	}
	
	public function view($cedula){
		$cli= $this->Cliente_model->get( $cedula );
		$this->load->view("cliente/view/index", array("datos"=> $cli) );
	}
	//busqueda por cedula
	public function get(  $ci){
		$dt= $this->Cliente_model->get( $ci ) ;
		if( is_null ($dt )){
            echo json_encode(  array('error' => "Este cliente no existe" )); 
         } else{ 
			echo json_encode($dt );
		}		
   }



	public function getForRead(  $ci){
		$dt= $this->Cliente_model->get( $ci ) ;
		if( is_null ($dt )){
            echo json_encode(  array('error' => "Este cliente no existe" )); 
         } else{
			$this->load->helper("form");
			$this->load->view("cliente/view_data", array("datos"=> $dt));
			 
		}		
   }

	public function getForEdit(  $ci){
		 $dt= $this->Cliente_model->get( $ci ) ;
		 if( is_null ($dt)){
            echo json_encode(  array('error' => "Este cliente no existe" )); 
         }else{
			$this->load->helper("form");
			$this->load->view("cliente/edit_data", array("datos"=> $dt));
			 
		 }	
	}

	public function getClientes(  ){
		$dt= $this->Cliente_model->listByName( $this->input->post("nom") ) ;
		if( is_null ($dt)){
		   echo json_encode(  array('error' => "Sin resultados" )); 
		}else{
		   echo json_encode( $dt );  
		}	
   }

	 
   /**Confirma si el credito ha sido aprobado o NO */
	public function confirmar($ci){
		echo $this->Cliente_model->habilitadoParaConfirmar($ci);
	}



	public function informes(){
		$dts= $this->Cliente_model->list(); 
		$this->load->view( "cliente/informes", array("list"=> $dts)  );
	}

	public function t( $estado="P", $vendedor="0", $m1="1",  $m2="12"){ 
	
	var_dump( $this->Cliente_model->listCustom( $estado, $vendedor, $m1, $m2) ); 
	
	}
	 


	private function monthDescr($m){
		$r="";
		switch( $m){
			case 1: return "Enero";break;
			case 2: return "Febrero";break;
			case 3: return "Marzo";break;
			case 4: return "Abril";break;
			case 5: return "Mayo";break;
			case 6: return "Junio";break;
			case 7: return "Julio";break;
			case 8: return "Agosto";break;
			case 9: return "Septiembre";break;
			case 10: return "Octubre";break;
			case 11: return "Noviembre";break;
			case 12: return "Diciembre";break;
		}  return $r;
	}



	public function generarPdf( $estado="0", $vendedor="0", $m1="1",  $m2="12", $empresa_fondo= "0", $anio=2020){ 

		$usersList=	$this->Cliente_model->listCustom(  $estado, $vendedor, $m1, $m2, $empresa_fondo , $anio); 
		$estadoLabel= $estado=="0"? "" : ( $estado=="P"? "'PENDIENTES'" :  ($estado=="R"? "'RECHAZADOS'" : "'APROBADOS'") );
		
		$mesesLabel= ($m1 == $m2)?"<span>MES: </span>{$this->monthDescr($m1) }": "<span>DESDE: </span>{$this->monthDescr($m1) } <span>HASTA: </span>{$this->monthDescr($m2)} ";
		$empresaLabel= "<span>EMPRESA: </span>{$empresa_fondo}";

		$html=<<<EOF
		<style>
		table.cabecera{
			font-size:11px;  
		}
		span{
			font-weight: bolder;
		}
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
		tr.success{
			background-color: #aaffaa;
			border-bottom: 1px solid #000000; 
		}
		tr.pending{
			background-color: #888888;
			border-bottom: 1px solid #000000; 
		}
		tr.danger{
			background-color: #ffaaaaa;
			border-bottom: 1px solid #000000; 
		}
		</style>
		<table class="cabecera">
		<tbody>
		<tr> <td>$mesesLabel </td> <td>$estadoLabel </td> <td>$empresaLabel </td> </tr>
		</tbody>
		</table>
		<h6></h6>
		<table class="tabla">
		<thead >
		<tr class="header">
		<td>Cedula</td>
		<td>Nombre completo</td>
		<td>Telefono</td>
		<td>Importe aprobado</td>
		<td>Vendedor</td>
		<td>Estado</td>
		<td>Empresa</td>
		</tr>
		</thead>
		<tbody>
		EOF;
		foreach( $usersList as $row){
			$nombres= $row->nombres." ".$row->apellidos;
			$estado= ($row->estado =="P" )? "PENDIENTE": ($row->estado =="A" ? "APROBADO":"RECHAZADO") ;
			$clase= ($row->estado =="P" )? "pending": ($row->estado =="A" ? "success":"danger") ;
			$html.="<tr class='$clase'> <td>{$row->cedula}</td> <td>{$nombres}</td> <td>{$row->telefono},{$row->celular}</td> <td>{$row->monto_a}</td><td>{$row->vendedor}</td> <td>{$estado}</td><td>{$row->empresa}</td></tr>";
		}
		$html.="</tbody> </table> ";
		/********* */

		$tituloDocumento= "Clientes-".date("d")."-".date("m")."-".date("yy")."-".rand();

			$this->load->library("PDF"); 	
			$pdf = new PDF(); 
			$pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
			$pdf->generarHtml( $html);
			$pdf->generar();
	}



	public function generarPdfGrill( $estado="0", $vendedor="0", $m1="1",  $m2="12", $empresa_fondo= "0", $anio=2020){ 

		$usersList=	$this->Cliente_model->listCustom(  $estado, $vendedor, $m1, $m2, $empresa_fondo , $anio); 
		$estadoLabel= $estado=="0"? "" : ( $estado=="P"? "'PENDIENTES'" :  ($estado=="R"? "'RECHAZADOS'" : "'APROBADOS'") );
		
		$mesesLabel= ($m1 == $m2)?"<span>MES: </span>{$this->monthDescr($m1) }": "<span>DESDE: </span>{$this->monthDescr($m1) } <span>HASTA: </span>{$this->monthDescr($m2)} ";
		$empresaLabel= "<span>empresa: </span>$empresa_fondo ";

		$html=<<<EOF
		<style>
		table.cabecera{
			font-size:11px;  
		}
		span{
			font-weight: bolder;
		}
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
		tr.success{
			background-color: #aaffaa;
			border-bottom: 1px solid #000000; 
		}
		tr.pending{
			background-color: #888888;
			border-bottom: 1px solid #000000; 
		}
		tr.danger{
			background-color: #ffaaaaa;
			border-bottom: 1px solid #000000; 
		}
		</style>
		<table class="cabecera">
		<tbody>
		<tr> <td>$mesesLabel </td> <td>$estadoLabel </td> <td>$empresaLabel </td> </tr>
		</tbody>
		</table>
		<h6></h6>
		<table class="tabla">
		<thead >
		<tr class="header">
		<td>Cedula</td>
		<td>Nombre completo</td>
		<td>Telefono</td>
		<td>Celular</td>
		<td>Vendedor</td>
		<td>Estado</td>
		<td>empresa</td>
		</tr>
		</thead>
		<tbody>
		EOF;
		foreach( $usersList as $row){
			$nombres= $row->nombres." ".$row->apellidos;
			$estado= ($row->estado =="P" )? "PENDIENTE": ($row->estado =="A" ? "APROBADO":"RECHAZADO") ;
			$clase= ($row->estado =="P" )? "pending": ($row->estado =="A" ? "success":"danger") ;
			$html.="<tr class='$clase'> <td>{$row->cedula}</td> <td>{$nombres}</td> <td>{$row->telefono}</td> <td>{$row->celular}</td><td>{$row->vendedor}</td> <td>{$estado}</td><td>{$row->empresa}</td></tr>";
		}
		$html.="</tbody> </table> ";
		/********* */

		$tituloDocumento= "Clientes-".date("d")."-".date("m")."-".date("yy");

			$this->load->library("PDF"); 	
			$pdf = new PDF(); 
			$pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
			$pdf->generarHtml( $html);
			$pdf->generar();
	}



	public function totalClientes(){
		$totals= $this->Cliente_model->totalizarClientesPorEstado();
		echo json_encode( $totals);
	}

	public function estadistica(){
		//$totals= $this->Cliente_model->totalizarClientesPorEstado();
		$this->load->view("cliente/estadistica" );
	}


	public function ubicacion(){
		$this->load->view("cliente/ubicacion" );
	}
}
