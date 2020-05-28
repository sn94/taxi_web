<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="manifest" href="/manifest.json">

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
				
               	
    <div class="container  bg-warning">
        <h1 class="text-center">
            <?= $tipo=="c"? "NUEVO CLIENTE": "NUEVO PROVEEDOR" ?>
        </h1>
    </div>
<div class="container">

    <div id="mensaje" >  </div>
    <?php   echo form_open("usuario/create/$tipo", array("onsubmit"=>"prepararDatosGrabar(event)")) ;  ?>
        <div class="row">
                       
            <div class="col-md-6">
                       
                Nick:<input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Nick de usuario" name="nick">
                Contrase&ntilde;a:<input class="form-control form-control-sm form-control-md mt-1" type="password" placeholder="Clave" name="passw">
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Nombres" name="nombre">
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Apellidos" name="apellido">
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Depart.:" name="depart">
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Ciudad" name="ciudad">
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Barrio" name="barrio">
                <br>
                <!--TOKEN DE REGISTRO CLOUD MESSAGING -->
                <input type="hidden" name="id_token">
        
            </div>
            <div class="col-md-6"> 
                            
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Telefono" name="telefono">
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Celular" name="celular">
                <label for="est_civil"  >Estado civil:</label>
                <select name="est_civil" id="" class="form-control form-control-sm form-control-md">
                    <option value="S">SOLTERO/A</option>
                    <option value="C">CASADO/A</option>
                    <option value="CO">CONCUBINO/A</option>
                    <option value="V">VIUDO/A</option>
                </select>
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Fecha de nacimiento" name="fecha_nac">
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Nro. de cedula" name="cedula">
                <?= form_error('cedula'); ?>

                <!--AUTORIZAR NOTIFICACIONES -->
                <div class="form-check" id="notification-verify">
                    <input onchange="permiso(event)" class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">

                        Enviarme notificaciones sobre nuevos clientes

                    </label>
                </div>
                <button type="submit" class="btn btn-success btn-sm d-block invisible">ENVIAR</button>
                              
            </div>
        </div> 
    </form>
</div>
            
          
				 
</div><!-- end container fluid -->
</main>

<?php   $this->load->view("plantillas/footer"); ?>
	 


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
    <script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
    <script src="<?= base_url("/assets/my_js.js")?>"  ></script>
    <script src="<?= base_url("/assets/fcm/firebase-app.js")?>"  ></script>
	<script src="<?= base_url("/assets/fcm/firebase-messaging.js")?>"  ></script>
    <script src="<?= base_url("/assets/fcm/init.js")?>"  ></script>
    
	<script>

//permiso para recibir notificaciones
function permiso( ev){

    if( ev.target.checked ){
        let hacer= function(){
        $("button[type=submit]").removeClass("invisible");
        $("button[type=submit]").addClass("visible");
            
        };
        let hacer_= function(){
            $("#defaultCheck1").prop("checked", false);

        };

        //solicita permiso al usuario para enviarle notificaciones
        //luego se instala el service worker
        Fcm.requestPermission( hacer, hacer_ );
    }else{
        alert("Para continuar con el registro, habilite las notificaciones por favor");
        $("button[type=submit]").removeClass("visible");
        $("button[type=submit]").addClass("invisible");
        
    }
   
}
   

  


    function prepararDatosGrabar( ev){
        //obtener token y adjuntarlo para enviarlo con el formulario
        Fcm.getToken().
        then( function( ag) {
            $("input[name=id_token]").val(  ar);
            peticion( ev, "#mensaje");

        }).catch( function(){
            console.log("Error al obtener token de registro");
            peticion( ev, "#mensaje");
        });
    }

			
	</script>

</body>
</html>