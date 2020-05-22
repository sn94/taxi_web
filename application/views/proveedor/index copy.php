<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>TAXICARGA-PROVEEDORES DISPONIBLES </title>
	<link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" /> 
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

<body class="d-flex flex-column h-100">

<main role="main" class="flex-shrink-0"  >
  
	<div class="container-fluid m-1" > 
				
				<div class="row  border border-warning">
					<div class="col-md-8">
						<div class="row">
						Ubicación: _Dpto.______ Ciudad.___Barrio:______
						</div>
						<div class="row">
							PUBLICIDAD
						</div>
						<div class="row bg-warning">
							ELEGIDO. PROVEEDOR
						</div>
					</div>
					<div class="col-md-4  border border-warning">
						<div class="row">Visita: 15000</div>
						<div class="row bg-warning">Soy Cliente</div>
						<div class="row">N° 1</div>
						<div class="row bg-warning">Mensajes</div>
					</div>
				</div>
				<div class="row border border-warning" >
					<div class="col-md-2 mr-md-0 pr-md-0 pl-0  border border-warning"> 
						<table class="table table-striped table-sm">
							<thead><th>USUARIOS</th></thead>
							<tbody>
								<tr><td>Dany</td></tr>
								<tr><td>Nery</td></tr>
								<tr><td>Sonia</td></tr>
								<tr><td>Javier</td></tr>
							</tbody>
						</table>
						<h4>N° online</h4>
						<h4 class="bg-warning">Historico</h4>
					</div>
					<div class="col-md-10 ml-md-0 pl-md-0 pl-0">
						<table class="table table-striped">
							<thead class="thead-dark"><th>Proveedor</th><th>Kgs</th><th>Tipo móvil</th><th>Ayudante</th><th>Horario</th></thead>
							<tbody>
								<tr class="table-success"><td>Nery</td><td>10</td><td>moto</td><td>si</td><td>L-V 7:00 a 19:00</td></tr>
								<tr class="table-success"><td>Jazmin</td><td>10</td><td>moto</td><td>si</td><td>L-V 7:00 a 19:00</td></tr>
								<tr class="table-danger"><td>Marcelo</td><td>10</td><td>moto</td><td>si</td><td>L-V 7:00 a 19:00</td></tr>
								<tr class="table-warning"><td>Junior</td><td>10</td><td>moto</td><td>si</td><td>L-V 7:00 a 19:00</td></tr>
								<tr class="table-warning"><td>Oscar</td><td>10</td><td>moto</td><td>si</td><td>L-V 7:00 a 19:00</td></tr>
							</tbody>
						</table>
					</div>
				</div> 
				
			</div>
</main>

<?php   $this->load->view("plantillas/footer"); ?>
	 


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
	<script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
	<script>

		 
	</script>

</body>
</html>