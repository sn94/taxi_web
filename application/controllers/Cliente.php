<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
 
	 public function __construct(){
		parent::__construct();
		date_default_timezone_set("America/Asuncion");
		$this->load->model("Usuario_model");
		$this->load->model("Cliente_model");
	 }

	public function index()
	{
		//listar clientes de la zona
		$dts= $this->Cliente_model->listPedDeCliPorZona();

		/**Totalizar visitas */
		$tv=$this->Usuario_model->getTotalOf("v");
		$tc=$this->Usuario_model->getTotalOf("c");
		$tp=$this->Usuario_model->getTotalOf("p");
		/*** */

		//obtener datos de usuario actual
		if( $this->session->has_userdata("usuario") ){ 
			$cedula= $this->session->userdata("id") ;
			$usu= $this->Usuario_model->get( $cedula);
			$this->load->view('cliente/index', array("list"=> $dts, "usuario"=> $usu, "totales"=> array("v"=>$tv,"c"=>$tc,"p"=>$tp)  )  );
		}else{
			if( $this->session->userdata("tipo") =="v" ){//Si fuera visitante
				 
				$this->load->view('cliente/index', array("list"=> $dts, "totales"=> array("v"=>$tv,"c"=>$tc,"p"=>$tp)  )  );
			}else{ $this->load->view('cliente/index', array( "list"=> $dts, "totales"=> array("v"=>$tv,"c"=>$tc,"p"=>$tp) )  );} 
		}
	 
	}



	public function ofertas_r(){
			/**Totalizar visitas */
			$tv=$this->Usuario_model->getTotalOf("v");
			$tc=$this->Usuario_model->getTotalOf("c");
			$tp=$this->Usuario_model->getTotalOf("p");
			/*** user*/
			$cedula= $this->session->userdata("id") ;
			$usu= $this->Usuario_model->get( $cedula);
			//listar ofertas
			$lista= $this->Cliente_model->ofertasRecibidas();
		$this->load->view("cliente/ofertas_r", 
		 array( "list"=> $lista, "usuario"=> $usu, "totales"=> array("v"=>$tv,"c"=>$tc,"p"=>$tp)  ) );
	}
	


	public function aceptar_oferta( $id_oferta){

		if($this->Cliente_model->aceptar_oferta_precio( $id_oferta ))
		{
			$usuarioCliente= $this->session->userdata("usuario");
			$usu_token_proveedor= $this->Cliente_model->proveedorDelaOferta( $id_oferta);
			$titulo="Buenas noticias!";
			$body= "($usuarioCliente) aceptó su precio";
			$datos=  array("title"=> $titulo, "body"=> $body );
			$this->load->library("firebase_req");
			echo $this->firebase_req->send_message_one_device( $usu_token_proveedor, $datos);
			
		
		}else 
		trigger_error("Error al tratar de registrar en la B.D", E_ERROR);
	}


	 public function z(){
	 
	$lista= $this->Cliente_model->ofertasRecibidas();
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


  
}
