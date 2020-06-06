<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {
 
	 public function __construct(){
		parent::__construct();
		date_default_timezone_set("America/Asuncion");
		$this->load->model("Usuario_model");
		$this->load->model("Proveedor_model");
	 }

	public function index()
	{  
		$dts=  $this->Usuario_model->list_proveedores();
		/**Totalizar visitas */
			$tv=$this->Usuario_model->getTotalOf("v");
			$tc=$this->Usuario_model->getTotalOf("c");
			$tp=$this->Usuario_model->getTotalOf("p");
		/*** */

		//obtener datos de usuario actual
		if( $this->session->has_userdata("usuario") ){
			/**** Datos de usuario ****/
			$cedula= $this->session->userdata("id") ;
			$usu= $this->Usuario_model->get( $cedula);
			/******/ 
			$this->load->view('proveedor/index', 
			array("list"=> $dts,
				 "usuario"=> $usu,
				 "totales"=> array("v"=>$tv,"c"=>$tc,"p"=>$tp) )  );
		}else{

			if( $this->session->userdata("tipo") =="v" ){//Si fuera visitante
				 
				$this->load->view('proveedor/index', array("list"=> $dts, "totales"=> array("v"=>$tv,"c"=>$tc,"p"=>$tp) )  );
			}else{
				$this->load->view('proveedor/index', array("list"=> $dts, "totales"=> array("v"=>$tv,"c"=>$tc,"p"=>$tp))  );
			} 
		} 
	}


	public function servicio(){
		/**Totalizar visitas */
		$tv=$this->Usuario_model->getTotalOf("v");
		$tc=$this->Usuario_model->getTotalOf("c");
		$tp=$this->Usuario_model->getTotalOf("p");
		/*** */
		/**** Datos de usuario ****/
		$cedula= $this->session->userdata("id") ;
		$usu= $this->Usuario_model->get( $cedula);
		/******/ 

		$this->load->helper("form");
		if(   $this->input->method(FALSE)	 == "post" ){ 
			//agregar registro de taxi
			if( $this->Proveedor_model->registrar_servicio()){
				$this->load->view("plantillas/success", array("mensaje"=>"Haz registrado un servicio de taxi-carga"));
			}else{
				$this->load->view("plantillas/error", array("mensaje"=> "Hubo un error al tratar de registrar su anuncio"));
			}
		}else{
			$this->load->view("proveedor/servicio", array(  "usuario"=> $usu, "totales"=> array("v"=>$tv,"c"=>$tc,"p"=>$tp) ));
		}
	 
	}

	 public function z(){
		$dts= $this->Cliente_model->list();  
		echo json_encode( $dts);
	 }

	 

	 public function proponer( ){
		$id_cliente= $this->input->post("cliente");
		$precio= $this->input->post("precio");
		var_dump( $this->input->post());
		$usu= $this->Usuario_model->get( $id_cliente);
		$datos=  array("title"=>"Precio", "body"=> $precio  );
		$this->load->library("firebase_req");
 
		 $this->firebase_req->send_message_one_device( $usu->id_token, $datos);

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
