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
								<?php  endif;
								if( $it->estado=="ac"): ?>
								<button class="btn btn-sm btn-success" type="button" onclick="aceptar_transaccion(event)">Concretar</button>
								<?php else:  echo "-"; endif; ?>
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
				
			  <!-- start container modal  comun-->
<div id="modal-comun" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
						<div class="modal-content bg-warning">
							<div class="modal-header"><h5 id="modal-titulo" class="modal-title font-weight-bold"> </h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">&times;</span></button></div>
							<div class="modal-body">   <p id="modal-cuerpo" class="text-center"> </p></div>
							<div id="modal-botones" class="modal-footer d-flex justify-content-center"> <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button> </div>
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
		 
			$("#modal-titulo").text( "Bien!");
			$("#modal-cuerpo").text( "Haz aceptado el precio que te ha propuesto el proveedor como costo del servicio. En breve recibirás una solicitud para finalmente concretar el trato con el proveedor");
			$("#modal-comun").modal("show");
		}
		function showMessageFromServer_accept2(){
		 
		 $("#modal-titulo").text( "Bien!");
		 $("#modal-cuerpo").text( "Haz dado el paso final en confirmar el trato con el Proveedor. En breve, el mismo se pondrá en contacto con usted ");
		 $("#modal-comun").modal("show");
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
						//actualizar tabla
						//falta hacer
					}, 
					beforeSend:  showLoader,
					error: function(xhr, textstatus){
						alert( textstatus);
						hideLoader();
					}
				});
			} 
		}/** */
 

		function aceptar_transaccion( e){
			if( confirm("Continuar?")){
				let id_oferta= e.target.parentNode.parentNode.id ;
				let url="/taxi_web/cliente/aceptar_transac/"+id_oferta;
				$.ajax({
					url: url,
					method: "get",
					success: function(res){
						hideLoader();
						console.log( res );
						showMessageFromServer_accept2();
						//actualizar tabla
						//falta hacer
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