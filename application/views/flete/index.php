<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>TAXICARGA-PROVEEDORES DISPONIBLES </title>
	<link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" />  
	<link rel="stylesheet" href="<?= base_url("/assets/jqueryui/jquery-ui.css") ?>" /> 
	<link rel="stylesheet" href="<?= base_url("/assets/timepicker/jquery.timepicker.min.css") ?>" />
	<link rel="stylesheet" href="<?= base_url("/assets/leafletmap/leaflet.css") ?>" />
	<link rel="stylesheet" href="<?= base_url("/assets/taxi.css") ?>" /> 
    <style>
    
    .container {
		width: auto;
		max-width: 680px;
		padding: 0 15px;
		}

	.footer {
	background-color: #f5f5f5;
	}

	.ui-datepicker-calendar{
		z-index: 10
	}
 
 #coord-ori,  #coord-dest{ 
	 z-index:  0;
	 max-height: 200px;
 }
	 
</style>
</head>

<body class="d-flex   flex-column   h-100 bg-warning">


<?php  $this->load->view("plantillas/header/index"); ?>

<?php
		 
		 function fillMaterialPercentage(){
			for( $i= 0 ; $i <=100 ; $i++){
				echo "<option value=$i>$i</option>";
			}
		}
	 
?>
<main role="main" class="flex-shrink-0 align-content-center"  >
  
	<div class="container-fluid m-1"  id="p-trabajo" > 

			<?php echo form_open("flete/add", array("method"=> "post", "onsubmit"=>"peticion(event, '#p-trabajo')") )  ?>
			<h4 class="text-center">Detalles del flete</h4>
		 
			<input type="hidden" name="cliente" value="<?= $this->session->userdata("id") ?>">
			<div class="row">
				 
				<div class="col-12 col-sm-12 col-md-3 taxipanel">
					<h4>Origen</h4>
					<dl class="row"> 
						<dt class="col-sm-5">Departamento:</dt>
						<dd class="col-sm-7"><select class="form-control"   id="o_depart"  ></select></dd>
						<input type="hidden" name="o_depart"> 

						<dt class="col-sm-5">Ciudad:</dt>
						<dd class="col-sm-7"> <select   class="form-control"  id="o_ciudad"  ></select> </dd>
						<input type="hidden" name="o_ciudad"> 

						<dt class="col-sm-5">Barrio:</dt>
						<dd class="col-sm-7"><input type="text" class="form-control"  name="o_barrio"  ></dd>
					</dl>

					<span style="font-weight: bold;">Coordenadas:</span>
					<input type="hidden" name="o_coordenada"  > 
					<br>
					<div id="coord-ori"  >
					<button type="button" onclick="cargarMapas()">TOMAR UBICACION</button>
					</div>
						 
					<dl class="row">
						<dt class="col-sm-5">Fecha de carga:</dt>
						<dd class="col-sm-7"> <input id="fechacarga" type="text" class="form-control"  name="o_fecha"  ></dd>

						<dt class="col-sm-5">Hora aproximada:</dt>
						<dd class="col-sm-7"><input type="text" class="form-control timepicker"  name="o_hora"  > </dd>
					</dl>
				</div>  <!--end column -->
		 
				 
				<div class="col-12 col-sm-12 col-md-3 taxipanel">
				<h4>Destino</h4>
					<dl class="row">
						<dt class="col-sm-5">Departamento:</dt>
						<dd class="col-sm-7"><select  class="form-control"  id="d_depart"  ></select></dd>
						<input type="hidden" name="d_depart"> 

						<dt class="col-sm-5">Ciudad:</dt>
						<dd class="col-sm-7"> <select class="form-control"  id="d_ciudad"  ></select> </dd>
						<input type="hidden" name="d_ciudad"> 

						<dt class="col-sm-5">Barrio:</dt>
						<dd class="col-sm-7"><input type="text" class="form-control"  name="d_barrio"  ></dd>
					</dl>

					<span style="font-weight: bold;">Coordenadas:</span>
					<input type="hidden" name="d_coordenada"  > 
					<br>
					<div class="container" id="coord-dest">
					<button type="button" onclick="cargarMapas()">TOMAR UBICACION</button>
					</div>

					<dl class="row">
						<dt class="col-sm-5">Fecha de Descarga:</dt>
						<dd class="col-sm-7"> <input id="fechadescarga" type="text" class="form-control"  name="d_fecha"  ></dd>

						<dt class="col-sm-5">Hora aproximada:</dt>
						<dd class="col-sm-7"><input type="text" class="form-control timepicker"  name="d_hora"  > </dd>
					</dl>
				</div>
				<div class="col-12 col-sm-12 col-md-5 taxipanel">
					<h4>Detalles f&iacute;sicos</h4>
					<dl class="row"> 
						
						<dt class="col-sm col-md-6">Tama&ntilde;o de la carga m&aacute;s peque&ntilde;a:</dt>
						<dd class="col-sm col-md-6"><input class="form-control"    name="smallest_size" type="text"></dd>
							
						<dt class="col-sm col-md-6">Tama&ntilde;o de la carga m&aacute;s grande:</dt>
						<dd class="col-sm col-md-6"><input class="form-control"    name="biggest_size" type="text"></dd>
						<dt class="col-sm col-md-6">Cantidad de paquetes, cajas o bultos:</dt>
						<dd class="col-sm col-md-6"><input class="form-control"   name="cant_paque" type="text"></dd>
					</dl>
					<dl class="row" >
							<dt class="col-sm col-md-6">Peso aproximado de todo el conjunto:</dt>
							<dd class="col-sm col-md-6"><input class="form-control"   name="peso_total" type="text"></dd>
							<dt class="col-sm col-md-3">Su carga es:</dt>
							<dd class="col-sm col-md-9">	<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio"  name="nivel_fragil" value="fragil"  checked>
										<label class="form-check-label" for="fragil">
										Fr&aacute;gil 
										</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio"  name="nivel_fragil" value="semifragil"   >
										<label class="form-check-label" for="semifragil">
										Semifr&aacute;gil
										</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio"  name="nivel_fragil" value="protegida"   >
										<label class="form-check-label" for="semifragil">
										Protegida
										</label>
									</div> 
							</dd>
							<dt class="col-sm col-md-3">Su carga est&aacute;:</dt>
							<dd class="col-sm col-md-9"><div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" value="Embalada" name="det_empaque"   checked>
										<label class="form-check-label" for="Embalada">
										Embalada
										</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" value="paletizada" name="det_empaque"     >
										<label class="form-check-label" for="paletizada">
										Paletizada
										</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" value="apilable" name="det_empaque"  >
										<label class="form-check-label" for="apilable">
										Apilable
										</label>
									</div> 
							</dd>
						</dl>
				</div>
			</div>
			
		 
			<dl class="row">
					<dt class="col-sm col-md-3 ">Del 100% cu&aacute;nto es:</dt>
					<dd class="col-sm col-md-10 ">
						 <div class="row">
							<div class="col-sm col col-md-5  ">
							<input type="hidden" name="material">

							Metal <select onchange="buildMaterialInfo(event)"   id="metal"> <?php fillMaterialPercentage(); ?>  </select>%
							Pl&aacute;stico <select onchange="buildMaterialInfo(event)"  id= "plastico"> <?php fillMaterialPercentage(); ?> </select>%
							Madera <select onchange="buildMaterialInfo(event)"    id="madera"><?php fillMaterialPercentage(); ?> </select>%

							</div>
							<div class="col-sm col col-md-7">
							Papel <select onchange="buildMaterialInfo(event)"    id="papel"><?php fillMaterialPercentage(); ?> </select>%
							Electr&oacute;nicos <select onchange="buildMaterialInfo(event)"   id= "electronicos"><?php fillMaterialPercentage(); ?> </select>%
							L&iacute;quidos <select onchange="buildMaterialInfo(event)"   id="liquidos"><?php fillMaterialPercentage(); ?> </select>%
							Otros <select onchange="buildMaterialInfo(event)"  id="otros"><?php fillMaterialPercentage(); ?> </select>%
							</div>
						 </div>
							
							
					</dd>
			</dl>
			<a href="<?= base_url("proveedor/index")?>" class="btn btn-secondary"  >CANCELAR</a>
			<button type="submit" class="btn btn-primary">ACEPTAR</button>	
				 
				
			 
				
				
				  
		</form>
			 
 

	</div><!-- end container fluid -->
</main> 

<?php   $this->load->view("plantillas/footer"); ?>
	 


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
	<script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
	<script src="<?= base_url("/assets/jqueryui/jquery-ui.js") ?>" ></script>
	<script src="<?= base_url("/assets/timepicker/jquery.timepicker.min.js") ?>" ></script>
	<script src="<?= base_url("/assets/leafletmap/leaflet.js") ?>" ></script>
	<script src="<?= base_url("/assets/mymaps.js") ?>" ></script>
	<script src="<?= base_url("/assets/citydata.js") ?>" ></script>
	 
	<script src="<?= base_url("/assets/my_js.js") ?>" ></script>
 

	<script>



		//inicializacion
	var  monthNames= [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
	var dayNamesMin= [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ];
	$("#fechacarga").datepicker( { monthNames: monthNames,dayNamesMin: dayNamesMin } );
	$("#fechadescarga").datepicker(  { monthNames: monthNames,dayNamesMin: dayNamesMin } );

	  

	$('.timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 60, 
    dynamic: false,
    dropdown: true,
    scrollbar: true
});



	//TIPOS DE MATERIAL
	var materiales= { metal: 0, plastico: 0, madera: 0, papel:0, electronicos:0, liquidos:0, otros:0};
	$("input[name=material]").val(  JSON.stringify(materiales )  );
	function buildMaterialInfo(e){
		materiales[  e.target.id]=  e.target.value;
		$("input[name=material]").val(  JSON.stringify(materiales )  );
		//console.log(  materiales);
	}

// AIzaSyB7ib73Cavw4hWCzHKyJcom54RPwkWrLfs
// AIzaSyB7ib73Cavw4hWCzHKyJcom54RPwkWrLfs
 	
 
	//lISTA DE CIUDADES Y DEPARTAMENTOS
	City_data.datosGeo( "#o_depart","#o_ciudad"); 
	City_data.datosGeo(   "#d_depart", "#d_ciudad"); 


	//Instancias de mapas, handlers para capturar lat y lng
	var mapa1, mapa2;
	function coordenadaOrigen( coorde){
		let coor=  coorde.lat+","+coorde.lng;
		$("input[name=o_coordenada]").val(coor);
		$("#coord-ori").css("height","200px");
	}
	function coordenadaDestino(coorde){
		let coor=  coorde.lat+","+coorde.lng;
		$("input[name=d_coordenada]").val(coor);
		$("#coord-dest").css("height","200px");
	}

	function cargarMapas(){
		requestLocationPermission( function(){
		mapa1= new MyMaps( "coord-ori", coordenadaOrigen);
		mapa2= new MyMaps( "coord-dest", coordenadaDestino);
		});
	}
	
		
		

	
	

	</script>

</body>
</html>