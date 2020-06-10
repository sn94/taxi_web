<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>TAXICARGAS - PEDIDOS REALIZADOS</title>
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

<?php  $this->load->view("plantillas/header"); ?>
<main role="main" class="flex-shrink-0 align-content-center"  >
  
	<div class="container-fluid m-1" > 
			 
			 
		<h4>PEDIDOS REALIZADOS</h4>	  
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped">
				<thead class="thead-dark "><th>PROVEEDOR</th><th>FECHA</th><th>HORA</th><th>ESTADO</th></thead>
				<tbody>
					<tr class="table-secondary"><td>Nery</td><td>25-03-2020</td><td>20:05</td><td>PENDIENTE</td></tr>
					<tr  class="table-warning"><td>Mario</td><td>25-03-2020</td><td>20:05</td><td>ATENDIDO</td></tr>
					<tr  class="table-success"><td>Akkun</td><td>25-03-2020</td><td>20:05</td><td>CONCRETADO</td></tr>
				</tbody>
			</table>
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
 

</body>
</html>