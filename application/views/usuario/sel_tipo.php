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

 
<main role="main" class="flex-shrink-0 align-content-center"  >
  
	<div class="container-fluid m-1" >  
				
    <h4  class="text-center">REGISTRARSE COMO</h4>
		<div class="row mt-5">
			<div class="offset-3 col-3 offset-sm-4 col-sm-2 offset-md-5 col-md-1">
				<a href="/taxi_web/usuario/create/c" class="btn btn-info">CLIENTE</a>
			</div>
			<div class="col-3 col-sm-2 col-md-1">
				<a  href="/taxi_web/usuario/create/p" class="btn btn-info">PROVEEDOR</a>
			</div>
		</div> 
				 
	</div><!-- end container fluid -->
</main>

<?php   $this->load->view("plantillas/footer"); ?>
	 


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>

	<script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
	<script>

 

		var ProveedorSeleccionado= "";

		function obtenerNombreDeProveedor( arg ){ 	ProveedorSeleccionado=  arg.target.parentNode.children[0].innerText ; }

		$('#Modal1').on('show.bs.modal', function (e) {
			$("#proveedor-nick").text( '"'+ ProveedorSeleccionado +'"'); 
		});
			
	</script>

</body>
</html>