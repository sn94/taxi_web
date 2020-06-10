<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>TAXICARGA-CLIENTES QUE BUSCAN </title>
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

				<h4>Potenciales clientes en tu zona</h4>
				<div class="row border border-secondary" >
					 
					<div class="col-md-10 ml-md-0 pl-md-0 pl-0">
						<table class="table table-striped table-hover">
							<thead class="thead-dark"><th>Cliente</th><th>Hora</th><th>Detalles</th> </thead>
							<tbody>
								<?php foreach( $list as $item): ?>
								<tr  class="table-success" >
								<td id="<?= $item->id_fle ?>"> <?= $item->nick ?></td><td> <?= $item->fecha_alta ?> </td> <td> <button type="button" onclick="obtenerNombreDeCliente(event)" data-toggle="modal" data-target="#modal-comun"  >Ver</button> </td>
								</tr>
								
								<?php endforeach;?>
							  
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


 
	
/*********MECANISMOS PARA ACTUALIZAR EL TOKEN DE USUARIO*** */		 
	//acciones- de espera
	let waiting= function(){
            $("#waitingimg").css( "display","block"); 
        };
        
        //acciones - obtencion exitosa del token
        let hacer=    function( ag) {   
			console.log("token: ", ag);
			Fcm.updateUserToken( ag);
			$("#waitingimg").css( "display","none");    
		 }; 
        //acciones - error al obtener token
        let hacer_= function(){    
			console.log("Error al obtener token");
			$("#waitingimg").css( "display","none"); 
		 };

        //verifica/solicita permiso al usuario para enviarle notificaciones
        //luego se instala el service worker
 
        waiting();
        Fcm.requestPermissionToGetToken().
        then( function( ar){ //todo resulto bien, podemos obtener el token
            if( ar)    Fcm.obtenerToken().then(  hacer );
            else hacer_();
         } ).
		catch(  hacer_);
	/******************************** */

 	


	
	function obtenerNombreDeCliente( arg ){
			let ClienteSeleccionado= "";
			//id de flete
			let idFlete= arg.target.parentNode.parentNode.children[0].id;
			$("#modal-botones").html("<a class='btn btn-success' href='/taxi_web/flete/view/"+idFlete+"'>Si, quiero ver detalles</a>")
			//obtener nick de cliente
			ClienteSeleccionado=  arg.target.parentNode.parentNode.children[0].innerText ;
			$("#modal-titulo").text( 'Usuario: "'+ ClienteSeleccionado +'"'); 
			$("#modal-cuerpo").text("¿Desea enviarle una propuesta?");
		
	
	 }/** */
	$('#modal-comun').on('show.bs.modal', function (e) {
	
	});
			
	</script>

</body>
</html>