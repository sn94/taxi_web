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
				
				<div class="container col-md-6">
					<h4 class="text-center">HOLA VISITANTE!</h4> 
					<?php  
						echo form_open("welcome/registro_visitante/$modo") ; 
					?>
						<label for="departamento">Departamento:</label> 
						<select class="form-control" name="depart" id="o_depart"  onchange="City_data.actualizarListas('#o_depart','#o_ciudad')" >

						</select>
						<label for="ciudad">Ciudad:</label>
						<select class="form-control" name="ciudad" id="o_ciudad"></select>

						<label for="barrio">Barrio:</label>
						<input class="form-control" type="text" name="barrio">
						 
						 
	
						<input type="hidden" name="modo" value="<?=$modo?>">
						<br>
						<a class="btn btn-danger"  href="/taxi_web/" class="btn btn-info">Cancelar</a >
						<button class="btn btn-info"  type="submit">Aceptar</button >
						<br>
						<a href="/taxi_web/usuario/sign_in">Iniciar sesi&oacute;n</a>
						<a href="/taxi_web/usuario/sel_tipo_usuario">Registrarse</a>
					</form> 
				</div>
				
				 
	</div><!-- end container fluid -->
</main>

<?php   $this->load->view("plantillas/footer"); ?>
	 


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
	<script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
	<script src="<?= base_url("/assets/citydata.js") ?>" ></script>
	<script>
		
		City_data.datosGeo( "#o_depart","#o_ciudad");  


		
	</script>

</body>
</html>