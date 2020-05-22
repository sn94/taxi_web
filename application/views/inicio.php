<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>INICIO</title>
	<link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" /> 
 
    <style>
		.fondo{
			background-image: url("assets/img/fondo_taxi.jpg");
			background-repeat: repeat-x;
			background-size: contain; 
			
			height: 100%;
		} 
 
	.titulo{
		font-weight: bolder;
		color: #000417;
	}

	.btn.btn-info{
		background-color:  #e3f852 !important;
		color: #151704;
		font-weight: bold;
	}
	 
	</style>
</head>

<body class="d-flex   flex-column   h-100" style="background-color: black; ">


<main role="main" class="flex-shrink-0 align-content-center"  >
   <!-- style="background-color: #ffe08490"  -->

	<div class="container-fluid  fondo pb-5">  
		<br><br>
		<h1 class="titulo display-4 text-center">TAXI CARGAS</h1>
		<img src="assets/img/0.png" alt="" height="200"  class="mx-auto d-block">
	</div>
	<br>
	<br>

	<div id="container-fluid">
		<div class="row">
			<div class="offset-3 col-3 offset-sm-4 col-sm-2 offset-md-5 col-md-1">
				<a href="welcome/registro_visitante/c" class="btn btn-info">BUSCAR</a>
			</div>
			<div class="col-3 col-sm-2 col-md-1">
				<a  href="welcome/registro_visitante/p" class="btn btn-info">OFRECER</a>
			</div>
		</div> 
	</div>
</main>
	

	<?php   $this->load->view("plantillas/footer"); ?>


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
	<script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
	<script>

		function unavailableFeature(){
			alert("OPCION NO DISPONIBLE EN ESTA VERSION");
		}
	</script>

</body>
</html>