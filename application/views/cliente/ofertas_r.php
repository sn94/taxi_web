<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>OFERTAS RECIBIDAS</title>
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

				<h4>Ofertas recibidas:</h4>
				<div class="row border border-secondary" >
					 
					<div class="col-md-10 ml-md-0 pl-md-0 pl-0">
						<table class="table table-striped table-hover">
							<thead class="thead-dark"><th>Ofertante</th><th>Hora</th><th>Estado</th> <th></th> <th></th></thead>
                           <tbody>
                           <?php foreach($list as $it): 
                            $estiloEstado=$it->estado=="p" ?"table-secondary": ($it->estado=="a" ? "table-success": "table-danger");
                            ?> 
                            <tr class="<?= $estiloEstado?>">
                            <td><?= $it->nick?></td>
                            <td>A las &nbsp; <?= $it->fecha_alta?></td>
                            <td><?= $it->estado=="p" ?"PENDIENTE": ($it->estado=="a" ? "ACEPTADO": "RECHAZADO") ?></td>
                            <td><button class="btn btn-sm btn-success" type="button">Aceptar</button></td>
                            <td><button class="btn btn-sm btn-danger" type="button">Rechazar</button></td>
                            </tr>
                            <?php  endforeach; ?>
                           </tbody>
						</table>
					</div>
				</div> 
				
			 
				<!-- start container modal  Proveedor elegido -->
				<div id="new-notifi" class="modal fade modal-proveedor-sel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content bg-warning">
							<div class="modal-header">
								<h5 class="modal-title font-weight-bold">Nueva notificaci&oacute;n </h5>
								
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
								<a  id="irDetalle" href="/taxi_web/flete/view/" class="btn btn-primary">ACEPTAR</a>
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


	var ClienteSeleccionado= "";
	function obtenerNombreDeCliente( arg ){
		//id de flete
		let idFlete= arg.target.parentNode.children[0].id;
		$("#irDetalle").attr("href", 	$("#irDetalle").attr("href")+idFlete );
		//obtener nick de cliente
		ClienteSeleccionado=  arg.target.parentNode.children[0].innerText ;
	 }
	$('#Modal1').on('show.bs.modal', function (e) {
		$("#proveedor-nick").text( '"'+ ClienteSeleccionado +'"'); 
	});
			
	</script>

</body>
</html>