<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Configurar datos de Servicio</title>
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
	 
	</div><!-- end container fluid -->
	<div class="container">

   <div id="mensaje">

   </div>
    <?php   echo form_open("proveedor/servicio", array("onsubmit"=>"peticion(event,'#mensaje')")) ;  ?>
        <div class="row">
                       
            <div class="col-md-6">
                       
                Marca:<input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="marca" name="marca" >
                Modelo<input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="modelo" name="modelo">
                Tipo: <select  class="form-control form-control-sm form-control-md mt-1" name="tipo">
						<option value="moto">Moto</option>
						<option value="camion">Camion</option> 
				</select>
				Con ayudante?:  
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio"  name="ayudante" value="n"  checked>
					<label class="form-check-label" for="">
					No
					</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio"  name="ayudante" value="s" >
					<label class="form-check-label" for="">
					Si
					</label>
				</div>
                <br>
                <!--TOKEN DE REGISTRO CLOUD MESSAGING -->
                <input type="hidden" name="propietario" value="<?= $this->session->userdata("id") ?>">
                 <button class="btn btn-sm btn-success">ENVIAR</button>
        
            </div>
             
        </div> 
    </form>
</div>
</main>

<?php   $this->load->view("plantillas/footer"); ?>
	 


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
	<script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
	<script src="<?= base_url("/my_js.js")?>"  ></script>
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

		var ProveedorSeleccionado= "";

		function obtenerNombreDeProveedor( arg ){ 	ProveedorSeleccionado=  arg.target.parentNode.children[0].innerText ; }

		$('#Modal1').on('show.bs.modal', function (e) {
			$("#proveedor-nick").text( '"'+ ProveedorSeleccionado +'"'); 
		});
			
	</script>

</body>
</html>