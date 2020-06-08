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
<main role="main" class="flex-shrink-0 align-content-center"  >
  
	<div class="container-fluid m-1" > 
				
		<?php   $this->load->view("plantillas/user_data_panel/index") ; ?>

		<h4>Potenciales clientes en tu zona</h4>
		<div class="alert alert-success" >
       <h4> Enhorabuena</h4>
         Haz aceptado el precio que te ha propuesto<br>
         el proveedor como costo del servicio. 
         En breve recibir&aacute;s una solicitud para que finalmente concretar el trato con el proveedor

					 
		</div> 
				
			  
 

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

 
	</script>

</body>
</html>