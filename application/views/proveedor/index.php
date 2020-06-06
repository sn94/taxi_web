<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>TAXICARGA-PROVEEDORES DISPONIBLES </title>
	<link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" /> 
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

</style>
</head>

<body class="d-flex   flex-column   h-100 bg-warning">

<?php  $this->load->view("plantillas/header/index"); ?>
<main role="main" class="flex-shrink-0 align-content-center"  >
 
	<div class="container-fluid m-1" > 
				
				<?php   $this->load->view("plantillas/user_data_panel/index") ; ?>
				<h4>Servicios disponibles ahora en tu zona</h4>
				<div class="row border border-secondary" >
					 
					<div class="col-md-10 ml-md-0 pl-md-0 pl-0">
						<table class="table table-striped table-hover">
							<thead class="thead-dark"><th>Proveedor</th><th>Kgs</th><th>Tipo móvil</th><th>Ayudante</th><th>Horario</th></thead>
							<tbody>

							<?php foreach( $list as $item): ?>

							<tr data-toggle="modal" data-target=".modal-proveedor-sel"  class="table-success" onclick="obtenerNombreDeProveedor(event)"><td ><?= $item->nick ?></td><td> Tipo movil</td><td>si</td><td>L-V 7:00 a 19:00</td></tr>
							
							<?php endforeach;?> 

							</tbody>
						</table>
					</div>
				</div> 
				
			 
				<!-- start container modal  Proveedor elegido -->
				<div id="Modal1" class="modal fade modal-proveedor-sel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content bg-warning">
							<div class="modal-header">
								<h5 class="modal-title font-weight-bold">Usted eligi&oacute; un proveedor:</h5>
								
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
								<a  href="/taxi_web/flete/add" class="btn btn-primary">ACEPTAR</a>
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

			


//Usuario ingresa a la ventana, abandona la ventana
$(document).ready( function(){
   //pagina cargada, activar 
   Fcm.init();
   activarUsuario(); 
   //cierra, abandona la ventana
   $(window).on("beforeunload", function() {  
	   //usuario offline
	   desactivarUsuario();
   });

});

		var ProveedorSeleccionado= "";

		function obtenerNombreDeProveedor( arg ){ 	ProveedorSeleccionado=  arg.target.parentNode.children[0].innerText ; }

		$('#Modal1').on('show.bs.modal', function (e) {
			$("#proveedor-nick").text( '"'+ ProveedorSeleccionado +'"'); 
		});
			
	</script>

</body>
</html>