<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Detalle de flete</title>
	<link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" /> 
	<link rel="stylesheet" href="<?= base_url("/assets/taxi.css") ?>" /> 
    <style>
    
    .container {
		width: auto;
		max-width: 680px;
		padding: 0 15px;
		}

	.footer { background-color: #f5f5f5; }

	span{  font-weight: bold;}

	h4 span:first-child{  text-decoration: underline;}

	table, span,p{ 	font-size: 0.8em; }

	caption{
		caption-side: top;
		color:black;
		font-weight: bold;
		text-align: center;
	}
	table tr td:first-child{ font-weight: bold; }

	 

</style>
</head>

<body class="d-flex   flex-column   h-100 bg-warning" >

<?php  $this->load->view("plantillas/header/index"); ?>
  
<!-- ESPERA -->
<img  id="waitingimg"   width="100"  style="display: none;position: absolute; margin-top: 10%; margin-left: 50%;margin-right: 50%; z-index: 9999;" src="/taxi_web/assets/img/loading.gif" alt="">

<main role="main" class="flex-shrink-0 align-content-center"   >


	<div class="container-fluid m-1" > 
				
				<?php   $this->load->view("plantillas/user_data_panel/index") ; ?>

				<h4> <span>Detalle del pedido de:</span> "<span><?= $dato->nick ?></span>" </h4>
				 <input type="hidden" id="usuid" value="<?= $dato->id_usu ?>">
				 <input type="hidden" id="flete_id" value="<?=$dato->id_fle?>">
				 
			 
				<div id="propuesta" class="container shadow   p-1">
				<span>¿Qu&eacute; precio ofreces? &nbsp;</span><input type="text"  id="precio">
				<button type="button" onclick="enviar_propuesta()" class="mt-1 btn btn-sm btn-success">Enviar propuesta</button>
				</div>

				<div class="row">
					<div class="col-md-6 col-12 shadow">
						<span>Desde (Lugar y fecha):</span>
						<p><?=  $dato->o_depart.",".$dato->o_ciudad.",".$dato->o_barrio."(".$dato->o_fecha."-".$dato->o_hora.")" ?></p>
					</div>
					<div class="col-md-6 col-12 shadow">
						<span>Hasta (Lugar y fecha):</span>
						<p><?=  $dato->d_depart.",".$dato->d_ciudad.",".$dato->d_barrio."(".$dato->d_fecha."-".$dato->d_hora.")" ?></p>
					</div>
				</div><!--end row -->

				<div class="row">
					<div class="col-6">
						 
						<table id="loadDetails" class="table table-sm table-bordered table-striped">
						<caption >La carga</caption>

							<tr><td>El m&aacute;s grande: </td><td><?= $dato->biggest_size ?>Kg.</td></tr>
							<tr><td>El m&aacute;s peque&ntilde;o: </td><td><?= $dato->smallest_size ?>Kg.</td></tr>
							<tr><td>Total de paquetes:</td><td><?= $dato->cant_paque ?></td></tr>
							<tr><td>Total Kg.:</td><td><?= $dato->peso_total ?>Kg.</td></tr>
							<tr><td>Delicadeza de la carga:</td><td><?= $dato->nivel_fragil ?></td></tr>
							<tr><td>Presentaci&oacute;n:</td><td><?= $dato->det_empaque ?></td></tr>
						</table>
						 
					</div>
					<div class="col-6">
						 
						<table id="showMaterials" class="table table-sm table-bordered table-striped"> 
							<caption  >Tipos de materiales: </caption>
						</table>
					</div>
				</div><!--end row -->

			
				<script type="text/javascript">
					var str_mat= "";
					var mat_obj= <?= $dato->material ?>; 
					Object.keys( mat_obj).forEach( 
						function(key){ 
							let rw=`<tr><td>${key}</td><td>${mat_obj[key]}</td></tr>`; 
							document.getElementById("showMaterials").innerHTML=
							document.getElementById("showMaterials").innerHTML+ rw;
						}
					); 
				</script> 
				
				
			 
				<!-- start container modal  Proveedor elegido -->
				<div id="Modal1" class="modal fade modal-proveedor-sel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content bg-warning">
							<div class="modal-header">
								<h5 class="modal-title font-weight-bold">¿Contactar con este cliente? </h5>
								
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">  
								<h6 id="proveedor-nick" class="font-weight-bold text-center">Nick de proveedor</h6>
								<p class="text-center">¿Desea ponerse en contacto con el proveedor?</p>
							</div>
							<div class="modal-footer d-flex justify-content-center">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
								<a  href="/taxi_web/flete/index" class="btn btn-primary">ACEPTAR</a>
							</div>
						</div>
					</div>
				</div><!-- end container modal -->
				<!-- start container modal  Precio recibido del proveedor-->
				<div id="Modal2" class="modal fade modal-proveedor-precio" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content bg-warning">
							<div class="modal-header">
								<h5 class="modal-title font-weight-bold">ESTE ES EL PRECIO DEL PROVEEDOR:</h5>
								
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">  
								<h6 id="proveedor-nick" class="font-weight-bold text-center">Nick de proveedor</h6>
								<h5>Gs. 5,000,000</h5>
							</div>
							<div class="modal-footer d-flex justify-content-center">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
								<a  href="/taxi_web/flete/index" class="btn btn-primary">ACEPTAR</a>
							</div>
						</div>
					</div>
				</div><!-- end container modal -->
 

			</div><!-- end container fluid -->
</main>

<?php   $this->load->view("plantillas/footer"); ?>
	 


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
	<script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>

		<!-- FIREBASE -->
	<script src="<?= base_url("/firebase-app.js")?>"  ></script>
	<script src="<?= base_url("/firebase-messaging.js")?>"  ></script>
	<script src="<?= base_url("/assets/fcm/init.js")?>"  ></script>
	<script src="<?= base_url("/assets/gui_refresh/refresh.js")?>"  ></script>


	<script>

Fcm.init();  

	function enviar_propuesta(){
		let usu= $("#usuid").val();
		let precio= $("#precio").val();
		let flete= $("#flete_id").val();
		let datos= {cliente: usu,precio:precio , id_flete: flete };
		$.ajax( { url:"/taxi_web/proveedor/proponer", method: "post", data: datos,
		success: function(res){
			let response= JSON.parse( res );
			console.log(response);
			if( response.success == 1)
			{  $("#waitingimg").css("display","none");}
			else {
				$("#waitingimg").css("display","none");
				alert("Error de envio"," Por favor, reintente enviar su mensaje");
			}
		},
		beforeSend: function(){
			$("#waitingimg").css("display","block");
		},
		error: function(xhr, texterr){ 
			$("#waitingimg").css("display","none");
			alert( "Hubo un error en el servidor.");
		}
	});
	}
 
	


 
	 
			
	</script>

</body>
</html>