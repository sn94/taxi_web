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

<!-- ESPERA -->
<img  id="waitingimg"   width="100"  style="display: none;position: absolute; margin-top: 10%; margin-left: 50%;margin-right: 50%; z-index: 9999;" src="/taxi_web/assets/img/loading.gif" alt="">

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
                            <tr class="<?= $estiloEstado?>" id="<?= $it->id_op?>">
                            <td><?= $it->nick?></td>
                            <td>A las &nbsp; <?= $it->fecha_alta?></td>
                            <td><?= $it->estado=="pe" ?"PENDIENTE": ($it->estado=="ac" ? "ACEPTADO": ($it->estado=="cc"?"CANCELADO POR TI":"CANCELADO POR EL PROVEEDOR")) ?></td>
                            <td>
								<?php if( $it->estado=="pe" ): ?>
								<button class="btn btn-sm btn-success" type="button" onclick="aceptar_oferta(event)">Aceptar</button>
								<?php  else: echo "-"; endif; ?>
							</td>
                            <td>
								<?php if( $it->estado=="ac" || $it->estado=="pe" ): ?>
								<button class="btn btn-sm btn-danger" type="button">Cancelar</button>
								<?php else: echo "-"; endif; ?>
							</td>
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
								<h6 id="titularnoti" class="font-weight-bold text-center"></h6>
								<h5 class="text-center"><span class="badge badge-info" id="bodynoti"></span></h5>
								
								<p class="text-center">¿Est&aacute; de acuerdo?</p>
							</div>
							<div class="modal-footer d-flex justify-content-center">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">VER M&Aacute;S TARDE</button> 
								<a  id="irDetalle" href="/taxi_web/cliente/ofertas_r" class="btn btn-success">IR A OFERTAS RECIBIDAS</a>
							</div>
						</div>
					</div>
				</div><!-- end container modal -->
 


				<!-- start container modal  Proveedor elegido -->
				<div id="commodal" class="modal fade modal-proveedor-sel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content bg-warning">
							<div class="modal-header">
								<h5 class="modal-title font-weight-bold" id="commodal_title"> </h5>
								
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">   
								<p class="text-center" id="commodal_body"></p>
								 
							</div>
							<div class="modal-footer d-flex justify-content-center">
							<button type="button" class="btn btn-success" data-dismiss="modal">OK</button> 
					 
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
		
		function showLoader(){ 	$("#waitingimg").css("display", "block"); 	}
		function hideLoader(){ $("#waitingimg").css("display", "none"); 	}
		function showMessageFromServer_accept(){
		 
			$("#commodal_title").text( "Bien!");
			$("#commodal_body").text( "Haz aceptado el precio que te ha propuesto el proveedor como costo del servicio. En breve recibirás una solicitud para finalmente concretar el trato con el proveedor");
			$("#commodal").modal("show");
		}

		function aceptar_oferta( e){
			if( confirm("Continuar?")){
				let id_oferta= e.target.parentNode.parentNode.id ;
				let url="/taxi_web/cliente/aceptar_oferta/"+id_oferta;
				$.ajax({
					url: url,
					method: "get",
					success: function(res){
						hideLoader();
						console.log( res );
						showMessageFromServer_accept();
					}, 
					beforeSend:  showLoader,
					error: function(xhr, textstatus){
						alert( textstatus);
						hideLoader();
					}
				});
			} 
		}/** */


	</script>

</body>
</html>